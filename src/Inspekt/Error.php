<?php
/**
 * Source file for Error
 *
 * @author Ed Finkler <coj@funkatron.com>
 * @package Inspekt
 */

namespace Inspekt;

/**
 * Error handling for Inspekt
 *
 * @package Inspekt
 *
 */
class Error
{

    /**
     * Constructor
     *
     * @return Error
     */
    public function __construct()
    {

    }

    /**
     * Raises an error.  In >= PHP5, this will throw an exception.
     *
     * @param string $msg
     * @param int $type One of the PHP Error Constants (E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE)
     *
     * @throws \Exception
     * @link http://www.php.net/manual/en/ref.errorfunc.php#errorfunc.constants
     */
    public static function raiseError($msg, $type = E_USER_WARNING)
    {
        throw new \Exception($msg, $type);
    }
}
