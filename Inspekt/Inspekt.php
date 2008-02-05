<?php
/**
 * Inspekt - main source file
 *
 *
 *
 * @author Chris Shiflett <chris@shiflett.org>
 * @author Ed Finkler <coj@funkatron.com>
 *
 * @package Inspekt
 */


/**
 * Inspekt_Error
 */
require_once('Inspekt/Error.php');

/**
 * Inspekt_Cage
 */
require_once('Inspekt/Cage.php');

/**
 * Inspekt_Cage_Session
 */
require_once('Inspekt/Cage/Session.php');

/**
 * Inspekt_Supercage
 */
require_once('Inspekt/Supercage.php');


/**
 * Options for isHostname() that specify which types of hostnames
 * to allow.
 *
 * HOST_ALLOW_DNS:   Allows Internet domain names (e.g.,
 *                   example.com).
 */
define ('ISPK_HOST_ALLOW_DNS',   1);

/**
 * Options for isHostname() that specify which types of hostnames
 * to allow.
 *
 * HOST_ALLOW_IP:    Allows IP addresses.
 */
define ('ISPK_HOST_ALLOW_IP',    2);

/**
 * Options for isHostname() that specify which types of hostnames
 * to allow.
 *
 * HOST_ALLOW_LOCAL: Allows local network names (e.g., localhost,
 *                   www.localdomain) and Internet domain names.
 */
define ('ISPK_HOST_ALLOW_LOCAL', 4);

/**
 * Options for isHostname() that specify which types of hostnames
 * to allow.
 *
 * HOST_ALLOW_ALL:   Allows all of the above types of hostnames.
 */
define ('ISPK_HOST_ALLOW_ALL',   7);

/**
 * Options for isUri that specify which types of URIs to allow.
 *
 * URI_ALLOW_COMMON: Allow only "common" hostnames: http, https, ftp
 */
define ('ISPK_URI_ALLOW_COMMON', 1);

/**
 * regex used to define what we're calling a valid domain name
 *
 */
define ('ISPK_DNS_VALID', '/^(?:[^\W_]((?:[^\W_]|-){0,61}[^\W_])?\.)+[a-zA-Z]{2,6}\.?$/');

/**
 * regex used to define what we're calling a valid email
 *
 * we're taking a "match 99%" approach here, rather than a strict
 * interpretation of the RFC.
 *
 * @see http://www.regular-expressions.info/email.html
 */
define ('ISPK_EMAIL_VALID', '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/');

/**
 * @package    Inspekt
 */
class Inspekt
{

	/**
	 * Returns the $_SERVER data wrapped in an Inspekt_Cage object
	 *
	 * This utilizes a singleton pattern to get around scoping issues
	 *
	 * @param string  $config_file
	 * @param boolean $strict whether or not to nullify the superglobal array
	 * @return Inspekt_Cage
	 */
	function makeServerCage($config_file=NULL, $strict=TRUE) {
		/**
		 * @staticvar $_instance
		 */
		static $_instance;

		if (!isset($_instance)) {
			$_instance = Inspekt_Cage::Factory($_SERVER, $config_file, '_SERVER', $strict);
		}
		$GLOBALS['HTTP_SERVER_VARS'] = NULL;
		return $_instance;
	}


	/**
	 * Returns the $_GET data wrapped in an Inspekt_Cage object
	 *
	 * This utilizes a singleton pattern to get around scoping issues
	 *
	 * @param string  $config_file
	 * @param boolean $strict whether or not to nullify the superglobal array
	 * @return Inspekt_Cage
	 * @static
	 */
	function makeGetCage($config_file=NULL, $strict=TRUE) {
		/**
		 * @staticvar $_instance
		 */
		static $_instance;

		if (!isset($_instance)) {
			$_instance = Inspekt_Cage::Factory($_GET, $config_file, '_GET', $strict);
		}
		$GLOBALS['HTTP_GET_VARS'] = NULL;
		return $_instance;
	}


	/**
	 * Returns the $_POST data wrapped in an Inspekt_Cage object
	 *
	 * This utilizes a singleton pattern to get around scoping issues
	 *
	 * @param string  $config_file
	 * @param boolean $strict whether or not to nullify the superglobal array
	 * @return Inspekt_Cage
	 * @static
	 */
	function makePostCage($config_file=NULL, $strict=TRUE) {
		/**
		 * @staticvar $_instance
		 */
		static $_instance;

		if (!isset($_instance)) {
			$_instance = Inspekt_Cage::Factory($_POST, $config_file, '_POST', $strict);
		}
		$GLOBALS['HTTP_POST_VARS'] = NULL;
		return $_instance;
	}

	/**
	 * Returns the $_COOKIE data wrapped in an Inspekt_Cage object
	 *
	 * This utilizes a singleton pattern to get around scoping issues
	 *
	 * @param string  $config_file
	 * @param boolean $strict whether or not to nullify the superglobal array
	 * @return Inspekt_Cage
	 * @static
	 */
	function makeCookieCage($config_file=NULL, $strict=TRUE) {
		/**
		 * @staticvar $_instance
		 */
		static $_instance;

		if (!isset($_instance)) {
			$_instance = Inspekt_Cage::Factory($_COOKIE, $config_file, '_COOKIE', $strict);
		}
		$GLOBALS['HTTP_COOKIE_VARS'] = NULL;
		return $_instance;
	}


	/**
	 * Returns the $_ENV data wrapped in an Inspekt_Cage object
	 *
	 * This utilizes a singleton pattern to get around scoping issues
	 *
	 * @param string  $config_file
	 * @param boolean $strict whether or not to nullify the superglobal array
	 * @return Inspekt_Cage
	 * @static
	 */
	function makeEnvCage($config_file=NULL, $strict=TRUE) {
		/**
		 * @staticvar $_instance
		 */
		static $_instance;

		if (!isset($_instance)) {
			$_instance = Inspekt_Cage::Factory($_ENV, $config_file, '_ENV', $strict);
		}
		$GLOBALS['HTTP_ENV_VARS'] = NULL;
		return $_instance;
	}


	/**
	 * Returns the $_FILES data wrapped in an Inspekt_Cage object
	 *
	 * This utilizes a singleton pattern to get around scoping issues
	 *
	 * @param string  $config_file
	 * @param boolean $strict whether or not to nullify the superglobal array
	 * @return Inspekt_Cage
	 * @static
	 */
	function makeFilesCage($config_file=NULL, $strict=TRUE) {
		/**
		 * @staticvar $_instance
		 */
		static $_instance;

		if (!isset($_instance)) {
			$_instance = Inspekt_Cage::Factory($_FILES, $config_file, '_FILES', $strict);
		}
		$GLOBALS['HTTP_POST_FILES'] = NULL;
		return $_instance;
	}


	/**
	 * Returns the $_SESSION data wrapped in an Inspekt_Cage object
	 *
	 * This utilizes a singleton pattern to get around scoping issues
	 *
	 * @param string  $config_file
	 * @param boolean $strict whether or not to nullify the superglobal array
	 * @return Inspekt_Cage
	 * @static
	 */
	function makeSessionCage($config_file=NULL, $strict=TRUE) {
		
		trigger_error('makeSessionCage is disabled in this version', E_USER_ERROR);
		
		/**
		 * @staticvar $_instance
		 */
		static $_instance;

		if (!isset($_SESSION)) {
			return NULL;
		}

		if (!isset($_instance)) {
			$_instance = Inspekt_Cage_Session::Factory($_SESSION, $config_file, '_SESSION', $strict);
		}
		$GLOBALS['HTTP_SESSION_VARS'] = NULL;
		return $_instance;
	}


	/**
	 * Returns a Supercage object, which wraps ALL input superglobals
	 *
	 * @param string  $config_file
	 * @param boolean $strict whether or not to nullify the superglobal
	 * @return Inspekt_Supercage
	 * @static
	 */
	function makeSuperCage($config_file=NULL, $strict=TRUE) {
		/**
		 * @staticvar $_instance
		 */
		static $_scinstance;

		if (!isset($_scinstance)) {
			$_scinstance = Inspekt_Supercage::Factory($strict, $config_file);
		}
		return $_scinstance;

	}


	/**
	 * Recursively walks an array and applies a given filter method to
	 * every value in the array.
	 *
	 * This should be considered a "protected" method, and not be called
	 * outside of the class
	 *
	 * @param array $input
	 * @param string $inspektor  The name of a static filtering method, like get* or no*
	 * @return array
	 *
	 */
	function _walkArray($input, $method) {

		if (!is_array($input)) {
			user_error('$input must be an array', E_USER_ERROR);
			return FALSE;
		}

		if ( !is_callable( array('Inspekt', $method) ) ) {
			user_error('$inspektor '.$method.' is invalid', E_USER_ERROR);
			return FALSE;
		}

		foreach($input as $key=>$val) {
			if (is_array($val)) {
				$input[$key]=Inspekt::_walkArray($val, $method);
			} else {
				$val = Inspekt::$method($val);
				$input[$key]=$val;
			}
		}
		return $input;
	}







	/**
     * Returns only the alphabetic characters in value.
     *
     * @param mixed $value
     * @return mixed
     *
     * @tag filter
     * @static
     */
	function getAlpha($value)
	{
		if (is_array($value)) {
			return Inspekt::_walkArray($value, 'getAlpha');
		} else {
			return preg_replace('/[^[:alpha:]]/', '', $value);
		}
	}

	/**
     * Returns only the alphabetic characters and digits in value.
     *
     * @param mixed $value
     * @return mixed
     *
     * @tag filter
     * @static
     */
	function getAlnum($value)
	{
		if (is_array($value)) {
			return Inspekt::_walkArray($value, 'getAlnum');
		} else {
			return preg_replace('/[^[:alnum:]]/', '', $value);
		}
	}

	/**
     * Returns only the digits in value. This differs from getInt().
     *
     * @param mixed $value
     * @return mixed
     *
     * @tag filter
     * @static
     */
	function getDigits($value)
	{
		if (is_array($value)) {
			return Inspekt::_walkArray($value, 'getDigits');
		} else {
			return preg_replace('/[^\d]/', '', $value);
		}
	}

	/**
     * Returns dirname(value).
     *
     * @param mixed $value
     * @return mixed
     *
     * @tag filter
     * @static
     */
	function getDir($value)
	{
		if (is_array($value)) {
			return Inspekt::_walkArray($value, 'getDir');
		} else {
			return dirname($value);
		}
	}

	/**
     * Returns (int) value.
     *
     * @param mixed $value
     * @return int
     *
     * @tag filter
     */
	function getInt($value)
	{
		if (is_array($value)) {
			return Inspekt::_walkArray($value, 'getInt');
		} else {
			return (int) $value;
		}
	}

	/**
     * Returns realpath(value).
     *
     * @param mixed $value
     * @return mixed
     *
     * @tag filter
     */
	function getPath($value)
	{
		if (is_array($value)) {
			return Inspekt::_walkArray($value, 'getPath');
		} else {
			return realpath($value);
		}
	}

	/**
     * Returns TRUE if every character is alphabetic or a digit,
     * FALSE otherwise.
     *
     * @param mixed $value
     * @return boolean
     *
     * @tag validator
     */
	function isAlnum($value)
	{
		return ctype_alnum($value);
	}

	/**
     * Returns TRUE if every character is alphabetic, FALSE
     * otherwise.
     *
     * @param mixed $value
     * @return boolean
     *
     * @tag validator
     */
	function isAlpha($value)
	{
		return ctype_alpha($value);
	}

	/**
     * Returns TRUE if value is greater than or equal to $min and less
     * than or equal to $max, FALSE otherwise. If $inc is set to
     * FALSE, then the value must be strictly greater than $min and
     * strictly less than $max.
     *
     * @param mixed $value
     * @param mixed $min
     * @param mixed $max
     * @return boolean
     *
     * @tag validator
     */
	function isBetween($value, $min, $max, $inc = TRUE)
	{
		if ($value > $min &&
		$value < $max) {
			return TRUE;
		}

		if ($inc &&
		$value >= $min &&
		$value <= $max) {
			return TRUE;
		}

		return FALSE;
	}

	/**
     * Returns TRUE if it is a valid credit card number format. The
     * optional second argument allows developers to indicate the
     * type.
     *
     * @param mixed $value
     * @param mixed $type
     * @return boolean
     *
     * @tag validator
     */
	function isCcnum($value, $type = NULL)
	{
		/**
         * @todo Type-specific checks
         */

		$value = self::getDigits($value);
		$length = strlen($value);

		if ($length < 13 || $length > 19) {
			return FALSE;
		}

		$sum = 0;
		$weight = 2;

		for ($i = $length - 2; $i >= 0; $i--) {
			$digit = $weight * $value[$i];
			$sum += floor($digit / 10) + $digit % 10;
			$weight = $weight % 2 + 1;
		}

		$mod = (10 - $sum % 10) % 10;

		return ($mod == $value[$length - 1]);
	}

	/**
     * Returns TRUE if value is a valid date, FALSE otherwise. The
     * date is required to be in ISO 8601 format.
     *
     * @param mixed $value
     * @return boolean
     *
     * @tag validator
     */
	function isDate($value)
	{
		list($year, $month, $day) = sscanf($value, '%d-%d-%d');

		return checkdate($month, $day, $year);
	}

	/**
     * Returns TRUE if every character is a digit, FALSE otherwise.
     * This is just like isInt(), except there is no upper limit.
     *
     * @param mixed $value
     * @return boolean
     *
     * @tag validator
     */
	function isDigits($value)
	{
		return ctype_digit((string) $value);
	}

	/**
     * Returns TRUE if value is a valid email format, FALSE otherwise.
     *
     * @param string $value
     * @return boolean
     * @see http://www.regular-expressions.info/email.html
     * @see ISPK_EMAIL_VALID
     *
     * @tag validator
     */
	function isEmail($value)
	{
		return (bool) preg_match(ISPK_EMAIL_VALID, $value);
	}

	/**
     * Returns TRUE if value is a valid float value, FALSE otherwise.
     *
     * @param string $value
     * @return boolean
     *
     * @tag validator
     */
	function isFloat($value)
	{
		$locale = localeconv();

		$value = str_replace($locale['decimal_point'], '.', $value);
		$value = str_replace($locale['thousands_sep'], '', $value);

		return (strval(floatval($value)) == $value);
	}

	/**
     * Returns TRUE if value is greater than $min, FALSE otherwise.
     *
     * @param mixed $value
     * @param mixed $min
     * @return boolean
     *
     * @tag validator
     * @static
     */
	function isGreaterThan($value, $min)
	{
		return ($value > $min);
	}

	/**
     * Returns TRUE if value is a valid hexadecimal format, FALSE
     * otherwise.
     *
     * @param mixed $value
     * @return boolean
     *
     * @tag validator
     * @static
     */
	function isHex($value)
	{
		return ctype_xdigit($value);
	}

	/**
     * Returns TRUE if value is a valid hostname, FALSE otherwise.
     * Depending upon the value of $allow, Internet domain names, IP
     * addresses, and/or local network names are considered valid.
     * The default is HOST_ALLOW_ALL, which considers all of the
     * above to be valid.
     *
     * @param mixed $value
     * @param integer $allow bitfield for ISPK_HOST_ALLOW_DNS, ISPK_HOST_ALLOW_IP, ISPK_HOST_ALLOW_LOCAL
     * @return boolean
     *
     * @tag validator
     * @static
     */
	function isHostname($value, $allow = ISPK_HOST_ALLOW_ALL)
	{
		if (!is_numeric($allow) || !is_int($allow)) {
			user_error('Illegal value for $allow; expected an integer', E_USER_WARNING);
		}

		if ($allow < ISPK_HOST_ALLOW_DNS || ISPK_HOST_ALLOW_ALL < $allow) {
			user_error('Illegal value for $allow; expected integer between ' . ISPK_HOST_ALLOW_DNS . ' and ' . ISPK_HOST_ALLOW_ALL, E_USER_WARNING);
		}

		// determine whether the input is formed as an IP address
		$status = self::isIp($value);

		// if the input looks like an IP address
		if ($status) {
			// if IP addresses are not allowed, then fail validation
			if (($allow & ISPK_HOST_ALLOW_IP) == 0) {
				return FALSE;
			}

			// IP passed validation
			return TRUE;
		}

		// check input against domain name schema
		$status = @preg_match('/^(?:[^\W_]((?:[^\W_]|-){0,61}[^\W_])?\.)+[a-zA-Z]{2,6}\.?$/', $value);
		if ($status === false) {
			user_error('Internal error: DNS validation failed', E_USER_WARNING);
		}

		// if the input passes as an Internet domain name, and domain names are allowed, then the hostname
		// passes validation
		if ($status == 1 && ($allow & ISPK_HOST_ALLOW_DNS) != 0) {
			return TRUE;
		}

		// if local network names are not allowed, then fail validation
		if (($allow & ISPK_HOST_ALLOW_LOCAL) == 0) {
			return FALSE;
		}

		// check input against local network name schema; last chance to pass validation
		$status = @preg_match('/^(?:[^\W_](?:[^\W_]|-){0,61}[^\W_]\.)*(?:[^\W_](?:[^\W_]|-){0,61}[^\W_])\.?$/',
		$value);
		if ($status === FALSE) {
			user_error('Internal error: local network name validation failed', E_USER_WARNING);
		}

		if ($status == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	/**
     * Returns TRUE if value is a valid integer value, FALSE otherwise.
     *
     * @param mixed $value
     * @return boolean
     *
     * @tag validator
     * @static
     */
	function isInt($value)
	{
		$locale = localeconv();

		$value = str_replace($locale['decimal_point'], '.', $value);
		$value = str_replace($locale['thousands_sep'], '', $value);

		return (strval(intval($value)) == $value);
	}

	/**
     * Returns TRUE if value is a valid IP format, FALSE otherwise.
     *
     * @param mixed $value
     * @return boolean
     *
     * @tag validator
     * @static
     */
	function isIp($value)
	{
		return (bool) ip2long($value);
	}

	/**
     * Returns TRUE if value is less than $max, FALSE otherwise.
     *
     * @param mixed $value
     * @param mixed $max
     * @return boolean
     *
     * @tag validator
     * @static
     */
	function isLessThan($value, $max)
	{
		return ($value < $max);
	}

	/**
     * Returns TRUE if value is one of $allowed, FALSE otherwise.
     *
     * @param mixed $value
     * @return boolean
     *
     * @tag validator
     * @static
     */
	function isOneOf($value, $allowed = NULL)
	{
		/**
         * @todo: Consider allowing a string for $allowed, where each
         * character in the string is an allowed character in the
         * value.
         */

		return in_array($value, $allowed);
	}

	/**
     * Returns TRUE if value is a valid phone number format, FALSE
     * otherwise. The optional second argument indicates the country.
     * This method requires that the value consist of only digits.
     *
     * @param mixed $value
     * @return boolean
     *
     * @tag validator
     * @static
     */
	function isPhone($value, $country = 'US')
	{
		if (!ctype_digit($value)) {
			return FALSE;
		}

		switch ($country)
		{
			case 'US':
				if (strlen($value) != 10) {
					return FALSE;
				}

				$areaCode = substr($value, 0, 3);

				$areaCodes = array(201, 202, 203, 204, 205, 206, 207, 208,
				209, 210, 212, 213, 214, 215, 216, 217,
				218, 219, 224, 225, 226, 228, 229, 231,
				234, 239, 240, 242, 246, 248, 250, 251,
				252, 253, 254, 256, 260, 262, 264, 267,
				268, 269, 270, 276, 281, 284, 289, 301,
				302, 303, 304, 305, 306, 307, 308, 309,
				310, 312, 313, 314, 315, 316, 317, 318,
				319, 320, 321, 323, 325, 330, 334, 336,
				337, 339, 340, 345, 347, 351, 352, 360,
				361, 386, 401, 402, 403, 404, 405, 406,
				407, 408, 409, 410, 412, 413, 414, 415,
				416, 417, 418, 419, 423, 424, 425, 430,
				432, 434, 435, 438, 440, 441, 443, 445,
				450, 469, 470, 473, 475, 478, 479, 480,
				484, 501, 502, 503, 504, 505, 506, 507,
				508, 509, 510, 512, 513, 514, 515, 516,
				517, 518, 519, 520, 530, 540, 541, 555,
				559, 561, 562, 563, 564, 567, 570, 571,
				573, 574, 580, 585, 586, 600, 601, 602,
				603, 604, 605, 606, 607, 608, 609, 610,
				612, 613, 614, 615, 616, 617, 618, 619,
				620, 623, 626, 630, 631, 636, 641, 646,
				647, 649, 650, 651, 660, 661, 662, 664,
				670, 671, 678, 682, 684, 700, 701, 702,
				703, 704, 705, 706, 707, 708, 709, 710,
				712, 713, 714, 715, 716, 717, 718, 719,
				720, 724, 727, 731, 732, 734, 740, 754,
				757, 758, 760, 763, 765, 767, 769, 770,
				772, 773, 774, 775, 778, 780, 781, 784,
				785, 786, 787, 800, 801, 802, 803, 804,
				805, 806, 807, 808, 809, 810, 812, 813,
				814, 815, 816, 817, 818, 819, 822, 828,
				829, 830, 831, 832, 833, 835, 843, 844,
				845, 847, 848, 850, 855, 856, 857, 858,
				859, 860, 863, 864, 865, 866, 867, 868,
				869, 870, 876, 877, 878, 888, 900, 901,
				902, 903, 904, 905, 906, 907, 908, 909,
				910, 912, 913, 914, 915, 916, 917, 918,
				919, 920, 925, 928, 931, 936, 937, 939,
				940, 941, 947, 949, 951, 952, 954, 956,
				959, 970, 971, 972, 973, 978, 979, 980,
				985, 989);

				return in_array($areaCode, $areaCodes);
				break;
			default:
				user_error('isPhone() does not yet support this country.', E_USER_WARNING);
				return FALSE;
				break;
		}
	}

	/**
     * Returns TRUE if value matches $pattern, FALSE otherwise. Uses
     * preg_match() for the matching.
     *
     * @param mixed $value
     * @param mixed $pattern
     * @return mixed
     *
     * @tag validator
     * @static
     */
	function isRegex($value, $pattern = NULL)
	{
		return (bool) preg_match($pattern, $value);
	}


	/**
	 * Enter description here...
	 *
	 * @param string $value
	 * @param integer $mode
	 * @return boolean
	 *
	 * @link http://www.ietf.org/rfc/rfc2396.txt
	 *
	 * @tag validator
	 * @static
	 */
	function isUri($value, $mode=ISPK_URI_ALLOW_COMMON)
	{
		/**
         * @todo
         */
		$regex = '';
		switch ($mode) {

			// a common absolute URI: ftp, http or https
			case ISPK_URI_ALLOW_COMMON:

				$regex .= '&';
				$regex .= '^(ftp|http|https):';					// protocol
				$regex .= '(//)';								// authority-start
				$regex .= '([-a-z0-9/~;:@=+$,.!*()\']+@)?';		// userinfo
				$regex .= '(';
					$regex .= '((?:[^\W_]((?:[^\W_]|-){0,61}[^\W_])?\.)+[a-zA-Z]{2,6}\.?)';		// domain name
				$regex .= '|';
					$regex .= '([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?(\.[0-9]{1,3})?)';	// OR ipv4
				$regex .= ')';
				$regex .= '(:([0-9]*))?';						// port
				$regex .= '(/((%[0-9a-f]{2}|[-a-z0-9/~;:@=+$,.!*()\'\&]*)*)/?)?';	// path
				$regex .= '(\?[^#]*)?';							// query
				$regex .= '(#([-a-z0-9_]*))?';					// anchor (fragment)
				$regex .= '$&i';
				//echo "<pre>"; echo print_r($regex, true); echo "</pre>\n";

				break;

			case ISPK_URI_ALLOW_ABSOLUTE:

				user_error('isUri() for ISPK_URI_ALLOW_ABSOLUTE has not been implemented.', E_USER_WARNING);
				return FALSE;

//				$regex .= '&';
//				$regex .= '^(ftp|http|https):';					// protocol
//				$regex .= '(//)';								// authority-start
//				$regex .= '([-a-z0-9/~;:@=+$,.!*()\']+@)?';		// userinfo
//				$regex .= '(';
//					$regex .= '((?:[^\W_]((?:[^\W_]|-){0,61}[^\W_])?\.)+[a-zA-Z]{2,6}\.?)';		// domain name
//				$regex .= '|';
//					$regex .= '([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?(\.[0-9]{1,3})?)';	// OR ipv4
//				$regex .= ')';
//				$regex .= '(:([0-9]*))?';						// port
//				$regex .= '(/((%[0-9a-f]{2}|[-a-z0-9/~;:@=+$,.!*()\'\&]*)*)/?)?';	// path
//				$regex .= '(\?[^#]*)?';							// query
//				$regex .= '(#([-a-z0-9_]*))?';					// anchor (fragment)
//				$regex .= '$&i';
				//echo "<pre>"; echo print_r($regex, true); echo "</pre>\n";

				break;

		}
		$result = preg_match($regex, $value, $subpatterns);
		//echo "<pre>"; echo print_r($subpatterns, true); echo "</pre>\n";
		return $result;
	}

	/**
     * Returns TRUE if value is a valid US ZIP, FALSE otherwise.
     *
     * @param mixed $value
     * @return boolean
     *
     * @tag validator
     * @static
     */
	function isZip($value)
	{
		return (bool) preg_match('/(^\d{5}$)|(^\d{5}-\d{4}$)/', $value);
	}

	/**
     * Returns value with all tags removed.
     *
     * @param mixed $value
     * @return mixed
     *
     * @tag filter
     * @static
     */
	function noTags($value)
	{
		if (is_array($value)) {
			return Inspekt::_walkArray($value, 'noTags');
		} else {
			return strip_tags($value);
		}
	}

	/**
     * Returns basename(value).
     *
     * @param mixed $value
     * @return mixed
     *
     * @tag filter
     * @static
     */
	function noPath($value)
	{
		if (is_array($value)) {
			return Inspekt::_walkArray($value, 'noPath');
		} else {
			return basename($value);
		}
	}
}

