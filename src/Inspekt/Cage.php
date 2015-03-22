<?php
/**
 * Inspekt Cage - main source file
 *
 * @author Chris Shiflett <chris@shiflett.org>
 * @author Ed Finkler <coj@funkatron.com>
 *
 * @package Inspekt
 */

namespace Inspekt;

/**
 *
 */
define('ISPK_ARRAY_PATH_SEPARATOR', '/');

/**
 *
 */
define('ISPK_RECURSION_MAX', 15);

/**
 * @package Inspekt
 */
class Cage implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * {@internal The raw source data.  Although tempting, NEVER EVER
     * EVER access the data directly using this property!}}
     *
     * Don't try to access this.  ever.  Now that we're safely on PHP5, we'll
     * enforce this with the "protected" keyword.
     *
     * @var \ArrayObject
     */
    protected $source = null;

    /**
     * where we store user-defined methods
     *
     * @var array
     */
    public $user_accessors = array();

    /**
     * the holding property for autofilter config
     *
     * @var array
     */
    public $autofilter_conf = null;

    /**
     *
     * @var \HTMLPurifer
     */
    public $purifier = null;


    /**
     *
     * @return Cage
     */
    public function __construct()
    {
        // placeholder -- we're using a factory here
    }


    /**
     * Takes an array and wraps it inside an object.  If $strict is not set to
     * FALSE, the original array will be destroyed, and the data can only be
     * accessed via the object's accessor methods
     *
     * @param array $source
     * @param string $conf_file
     * @param string $conf_section
     * @param boolean $strict
     * @return Cage
     *
     * @static
     */
    public static function factory(&$source, $conf_file = null, $conf_section = null, $strict = true)
    {

        if (!is_array($source)) {
            throw new Exception('$source ' . $source . ' is not an array');
        }

        $cage = new Cage();
        $cage->setSource($source);
        $cage->parseAndApplyAutoFilters($conf_file, $conf_section);

        if ($strict) {
            $source = null;
        }

        return $cage;
    }


    /**
     * {@internal we use this to set the data array in factory()}}
     *
     * @see factory()
     * @param array $newsource
     */
    private function setSource(&$newsource)
    {

        $this->source = Inspekt::convertArrayToArrayObject($newsource);

    }


    /**
     * Returns an iterator for looping through an ArrayObject.
     *
     * @access public
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return $this->source->getIterator();
    }


    /**
     * Sets the value at the specified $offset to value$
     * in $this->source.
     *
     * @param mixed $offset
     * @param mixed $value
     * @access public
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->source->offsetSet($offset, $value);
    }


    /**
     * Returns whether the $offset exists in $this->source.
     *
     * @param mixed $offset
     * @access public
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->source->offsetExists($offset);
    }


    /**
     * Unsets the value in $this->source at $offset.
     *
     * @param mixed $offset
     * @access public
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->source->offsetUnset($offset);
    }


    /**
     * Returns the value at $offset from $this->source.
     *
     * @param mixed $offset
     * @access public
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->source->offsetGet($offset);
    }


    /**
     * Returns the number of elements in $this->source.
     *
     * @access public
     * @return int
     */
    public function count()
    {
        return $this->source->count();
    }


    /**
     * Load the HTMLPurifier library and instantiate the object
     * @param mixed $opts options that are sent to HTMLPurifier. Optional
     */
    public function loadHTMLPurifier($opts = null)
    {
        if (isset($opts) && is_array($opts)) {
            $config = $this->buildHTMLPurifierConfig($opts);
        } else {
            $config = null;
        }

        $this->purifier = new \HTMLPurifier($config);
    }


    /**
     *
     * @param \HTMLPurifier $pobj an HTMLPurifer Object
     */
    public function setHTMLPurifier(\HTMLPurifier $pobj)
    {
        $this->purifier = $pobj;
    }

    /**
     * @return \HTMLPurifier
     */
    public function getHTMLPurifier()
    {
        return $this->purifier;
    }


    /**
     * @param $opts
     * @return \HTMLPurifier_Config
     */
    protected function buildHTMLPurifierConfig($opts)
    {
        $config = \HTMLPurifier_Config::createDefault();
        foreach ($opts as $key => $val) {
            $config->set($key, $val);
        }
        return $config;
    }


    /**
     * @param $conf_file
     * @param $conf_section
     */
    protected function parseAndApplyAutoFilters($conf_file, $conf_section)
    {
        if (isset($conf_file)) {
            $conf = parse_ini_file($conf_file, true);
            if ($conf_section) {
                if (isset($conf[$conf_section])) {
                    $this->autofilter_conf = $conf[$conf_section];
                }
            } else {
                $this->autofilter_conf = $conf;
            }

            $this->applyAutoFilters();
        }
    }


    /**
     *
     */
    protected function applyAutoFilters()
    {
        if (isset($this->autofilter_conf) && is_array($this->autofilter_conf)) {
            foreach ($this->autofilter_conf as $key => $val) {
                // get universal filter key
                if ($key == '*') {
                    // get filters for this key
                    $uni_filters = explode(',', $this->autofilter_conf[$key]);
                    array_walk($uni_filters, 'trim');

                    // apply uni filters
                    foreach ($uni_filters as $this_filter) {
                        foreach ($this->source as $key => $val2) {
                            $this->source[$key] = $this->$this_filter($key);
                        }
                    }
                } elseif ($val == $this->keyExists($key)) {
                    // get filters for this key
                    $filters = explode(',', $this->autofilter_conf[$key]);
                    array_walk($filters, 'trim');

                    // apply filters
                    foreach ($filters as $this_filter) {
                        $this->setValue($key, $this->$this_filter($key));
                    }
                }
            }
        }
    }


    /**
     * @param $name
     * @param $args
     * @return bool|mixed
     * @throws \Exception
     */
    public function __call($name, $args)
    {
        if (in_array($name, $this->user_accessors)) {
            /** @var AccessorAbstract $acc */
            $acc = new $name($this, $args);
            /*
                this first argument should always be the key we're accessing
            */
            return $acc->run($args[0]);
        } else {
            throw new Exception("The accessor $name does not exist and is not registered", E_USER_ERROR);
            return false;
        }
    }

    /**
     * This method lets the developer add new accessor methods to a cage object
     * Note that calling these will be quite a bit slower, because we have to
     * use call_user_func()
     *
     * The dev needs to define a procedural function like so:
     *
     * <code>
     * function foo_bar($cage_object, $arg2, $arg3, $arg4, $arg5...) {
     *    ...
     * }
     * </code>
     *
     * @param string $accessor_name
     * @return void
     * @author Ed Finkler
     */
    public function addAccessor($accessor_name)
    {
        $this->user_accessors[] = $accessor_name;
    }


    /**
     * Returns only the alphabetic characters in value.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag filter
     */
    public function getAlpha($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return Inspekt::getAlpha($this->getValue($key));
    }

    /**
     * Returns only the alphabetic characters and digits in value.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag filter
     */
    public function getAlnum($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return Inspekt::getAlnum($this->getValue($key));
    }

    /**
     * Returns only the digits in value. This differs from getInt().
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag filter
     */
    public function getDigits($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return Inspekt::getDigits($this->getValue($key));
    }

    /**
     * Returns dirname(value).
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag filter
     */
    public function getDir($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return Inspekt::getDir($this->getValue($key));
    }

    /**
     * Returns (int) value.
     *
     * @param mixed $key
     * @return int
     * @throws Exception
     * @tag filter
     */
    public function getInt($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return Inspekt::getInt($this->getValue($key));
    }

    /**
     * Returns realpath(value).
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag filter
     */
    public function getPath($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return Inspekt::getPath($this->getValue($key));
    }


    /**
     * Returns ROT13-encoded version
     *
     * @param string $key
     * @return mixed
     * @throws Exception
     * @tag hash
     */
    public function getROT13($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return Inspekt::getROT13($this->getValue($key));
    }


    /**
     * This returns the value of the given key passed through the HTMLPurifer
     * object, if it is instantiated with Cage::loadHTMLPurifer
     *
     * @param string $key
     * @return mixed purified HTML version of input
     * @throws Exception
     * @tag filter
     */
    public function getPurifiedHTML($key)
    {
        if (!isset($this->purifier)) {
            throw new Exception("HTMLPurifier was not loaded");
        }

        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        $val = $this->getValue($key);
        if (Inspekt::isArrayOrArrayObject($val)) {
            return $this->purifier->purifyArray($val);
        } else {
            return $this->purifier->purify($val);
        }
    }


    /**
     * Returns value.
     *
     * @param string $key
     * @return mixed
     * @throws Exception
     * @tag filter
     */
    public function getRaw($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return $this->getValue($key);
    }

    /**
     * Returns value if every character is alphabetic or a digit,
     * FALSE otherwise.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testAlnum($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isAlnum($this->getValue($key))) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if every character is alphabetic, FALSE
     * otherwise.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testAlpha($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isAlpha($this->getValue($key))) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is greater than or equal to $min and less
     * than or equal to $max, FALSE otherwise. If $inc is set to
     * FALSE, then the value must be strictly greater than $min and
     * strictly less than $max.
     *
     * @param mixed $key
     * @param mixed $min
     * @param mixed $max
     * @param boolean $inc
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testBetween($key, $min, $max, $inc = true)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isBetween($this->getValue($key), $min, $max, $inc)) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is a valid credit card number format. The
     * optional second argument allows developers to indicate the
     * type.
     *
     * @param mixed $key
     * @param mixed $type
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testCcnum($key, $type = null)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isCcnum($this->getValue($key), $type)) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns $value if it is a valid date, FALSE otherwise. The
     * date is required to be in ISO 8601 format.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testDate($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isDate($this->getValue($key))) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if every character is a digit, FALSE otherwise.
     * This is just like isInt(), except there is no upper limit.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testDigits($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isDigits($this->getValue($key))) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is a valid email format, FALSE otherwise.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testEmail($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isEmail($this->getValue($key))) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is a valid float value, FALSE otherwise.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testFloat($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isFloat($this->getValue($key))) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is greater than $min, FALSE otherwise.
     *
     * @param mixed $key
     * @param mixed $min
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testGreaterThan($key, $min = null)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isGreaterThan($this->getValue($key), $min)) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is a valid hexadecimal format, FALSE
     * otherwise.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testHex($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isHex($this->getValue($key))) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is a valid hostname, FALSE otherwise.
     * Depending upon the value of $allow, Internet domain names, IP
     * addresses, and/or local network names are considered valid.
     * The default is HOST_ALLOW_ALL, which considers all of the
     * above to be valid.
     *
     * @param mixed $key
     * @param int $allow bitfield for HOST_ALLOW_DNS, HOST_ALLOW_IP, HOST_ALLOW_LOCAL
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testHostname($key, $allow = ISPK_HOST_ALLOW_ALL)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isHostname($this->getValue($key), $allow)) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is a valid integer value, FALSE otherwise.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testInt($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isInt($this->getValue($key))) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is a valid IP format, FALSE otherwise.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testIp($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isIp($this->getValue($key))) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is less than $max, FALSE otherwise.
     *
     * @param mixed $key
     * @param mixed $max
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testLessThan($key, $max = null)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isLessThan($this->getValue($key), $max)) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is one of $allowed, FALSE otherwise.
     *
     * @param mixed $key
     * @param null $allowed
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testOneOf($key, $allowed = null)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isOneOf($this->getValue($key), $allowed)) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is a valid phone number format, FALSE
     * otherwise. The optional second argument indicates the country.
     *
     * @param mixed $key
     * @param string $country
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testPhone($key, $country = 'US')
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isPhone($this->getValue($key), $country)) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it matches $pattern, FALSE otherwise. Uses
     * preg_match() for the matching.
     *
     * @param mixed $key
     * @param mixed $pattern
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testRegex($key, $pattern = null)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isRegex($this->getValue($key), $pattern)) {
            return $this->getValue($key);
        }

        return false;
    }


    /**
     * Enter description here...
     *
     * @param string $key
     * @return bool|string
     * @throws Exception
     * @tag validator
     */
    public function testUri($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isUri($this->getValue($key))) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value if it is a valid US ZIP, FALSE otherwise.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag validator
     */
    public function testZip($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (Inspekt::isZip($this->getValue($key))) {
            return $this->getValue($key);
        }

        return false;
    }

    /**
     * Returns value with all tags removed.
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag filter
     */
    public function noTags($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return Inspekt::noTags($this->getValue($key));
    }

    /**
     * Returns basename(value).
     *
     * @param mixed $key
     * @return mixed
     * @throws Exception
     * @tag filter
     */
    public function noPath($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return Inspekt::noPath($this->getValue($key));
    }


    /**
     * @param $key
     * @return array|bool|mixed|string
     * @throws Exception
     */
    public function noTagsOrSpecial($key)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return Inspekt::noTagsOrSpecial($this->getValue($key));
    }


    /**
     * @param string $key
     * @param resource $conn a connection resource
     * @return bool|mixed
     * @throws Exception
     */
    public function escMySQL($key, $conn)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        return Inspekt::escMySQL($this->getValue($key), $conn);
    }


    /**
     * @param $key
     * @param null $conn
     * @return bool|mixed
     * @throws Exception
     */
    public function escPgSQL($key, $conn = null)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (isset($conn)) {
            return Inspekt::escPgSQL($this->getValue($key), $conn);
        } else {
            return Inspekt::escPgSQL($this->getValue($key));
        }

    }


    /**
     * @param $key
     * @param null $conn
     * @return bool|mixed
     * @throws Exception
     */
    public function escPgSQLBytea($key, $conn = null)
    {
        if (!$this->keyExists($key)) {
            throw new Exception('Key does not exist');
        }
        if (isset($conn)) {
            return Inspekt::escPgSQLBytea($this->getValue($key), $conn);
        } else {
            return Inspekt::escPgSQLBytea($this->getValue($key));
        }

    }


    /**
     * Checks if a key exists
     *
     * @param mixed $key
     * @param boolean $return_value whether or not to return the value if key exists. defaults to FALSE.
     * @return mixed
     *
     */
    public function keyExists($key, $return_value = false)
    {
        if (strpos($key, ISPK_ARRAY_PATH_SEPARATOR) !== false) {
            $key = trim($key, ISPK_ARRAY_PATH_SEPARATOR);
            $keys = explode(ISPK_ARRAY_PATH_SEPARATOR, $key);
            return $this->keyExistsRecursive($keys, $this->source);
        } else {
            $exists = array_key_exists($key, $this->source);
            if ($exists) {
                if ($return_value) {
                    return $this->source[$key];
                } else {
                    return $exists;
                }
            } else {
                return false;
            }

        }
    }


    /**
     * @param $keys
     * @param $data_array
     * @return bool
     */
    protected function keyExistsRecursive($keys, $data_array)
    {
        $thiskey = current($keys);

        if (is_numeric($thiskey)) { // force numeric strings to be integers
            $thiskey = (int)$thiskey;
        }

        if (array_key_exists($thiskey, $data_array)) {
            if (sizeof($keys) == 1) {
                return true;
            } elseif ($data_array[$thiskey] instanceof \ArrayObject) {
                unset($keys[key($keys)]);
                return $this->keyExistsRecursive($keys, $data_array[$thiskey]);
            }
        }
        return false;
    }

    /**
     * Retrieves a value from the source array. This should NOT be called directly, but needs to be public
     * for use by AccessorAbstract. Maybe a different approach should be considered
     *
     * @param string $key
     * @return mixed
     * @private
     */
    public function getValue($key)
    {
        if (strpos($key, ISPK_ARRAY_PATH_SEPARATOR) !== false) {
            $key = trim($key, ISPK_ARRAY_PATH_SEPARATOR);
            $keys = explode(ISPK_ARRAY_PATH_SEPARATOR, $key);
            return $this->getValueRecursive($keys, $this->source);
        } else {
            return $this->source[$key];
        }
    }


    /**
     * @param $keys
     * @param $data_array
     * @param int $level
     * @return bool
     * @throws \Exception
     */
    protected function getValueRecursive($keys, $data_array, $level = 0)
    {
        $thiskey = current($keys);

        if (is_numeric($thiskey)) { // force numeric strings to be integers
            $thiskey = (int)$thiskey;
        }

        if (array_key_exists($thiskey, $data_array)) {
            if (sizeof($keys) == 1) {
                return $data_array[$thiskey];
            } elseif ($data_array[$thiskey] instanceof \ArrayObject) {
                if ($level < ISPK_RECURSION_MAX) {
                    unset($keys[key($keys)]);
                    return $this->getValueRecursive($keys, $data_array[$thiskey], $level + 1);
                } else {
                    throw new Exception('Inspekt recursion limit met');
                    return false;
                }
            }
        }
        return false;
    }


    /**
     * Sets a value in the source array
     *
     * @param mixed $key
     * @param mixed $val
     * @return mixed
     */
    protected function setValue($key, $val)
    {
        if (strpos($key, ISPK_ARRAY_PATH_SEPARATOR) !== false) {
            $key = trim($key, ISPK_ARRAY_PATH_SEPARATOR);
            $keys = explode(ISPK_ARRAY_PATH_SEPARATOR, $key);
            return $this->setValueRecursive($keys, $val, $this->source);
        } else {
            $this->source[$key] = $val;
            return $this->source[$key];
        }
    }


    /**
     * @param $keys
     * @param $val
     * @param $data_array
     * @param int $level
     * @return bool
     * @throws \Exception
     */
    protected function setValueRecursive($keys, $val, $data_array, $level = 0)
    {
        $thiskey = current($keys);

        if (is_numeric($thiskey)) { // force numeric strings to be integers
            $thiskey = (int)$thiskey;
        }

        if (array_key_exists($thiskey, $data_array)) {
            if (sizeof($keys) == 1) {
                $data_array[$thiskey] = $val;
                return $data_array[$thiskey];
            } elseif ($data_array[$thiskey] instanceof \ArrayObject) {
                if ($level < ISPK_RECURSION_MAX) {
                    unset($keys[key($keys)]);
                    return $this->setValueRecursive($keys, $val, $data_array[$thiskey], $level + 1);
                } else {
                    throw new Exception('Inspekt recursion limit met');
                    return false;
                }
            }
        }
        return false;
    }
}
