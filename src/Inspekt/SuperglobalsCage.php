<?php
/**
 * Inspekt SuperglobalsCage
 *
 * @author Ed Finkler <coj@funkatron.com>
 *
 * @package Inspekt
 */

namespace Inspekt;

/**
 * The SuperglobalsCage object wraps ALL of the superglobals
 *
 * @package Inspekt
 *
 */
class SuperglobalsCage
{

    /**
     * The get cage
     *
     * @var Cage
     */
    public $get;

    /**
     * The post cage
     *
     * @var Cage
     */
    public $post;

    /**
     * The cookie cage
     *
     * @var Cage
     */
    public $cookie;

    /**
     * The env cage
     *
     * @var Cage
     */
    public $env;

    /**
     * The files cage
     *
     * @var Cage
     */
    public $files;

    /**
     * The server cage
     *
     * @var Cage
     */
    public $server;

    /**
     * Enter description here...
     *
     * @return SuperglobalsCage
     */
    public function __construct()
    {
        // placeholder
    }

    /**
     * Enter description here...
     *
     * @param string $config_file
     * @param boolean $strict
     * @return SuperglobalsCage
     */
    public static function factory($config_file = null, $strict = true)
    {

        $sc = new SuperglobalsCage();
        $sc->makeCages($config_file, $strict);

        // eliminate the $_REQUEST superglobal
        if ($strict) {
            $_REQUEST = null;
        }

        return $sc;

    }

    /**
     * Enter description here...
     *
     * @see Inspekt\Supercage::Factory()
     * @param string $config_file
     * @param boolean $strict
     */
    protected function makeCages($config_file = null, $strict = true)
    {
        $this->get = Inspekt::makeGetCage($config_file, $strict);
        $this->post = Inspekt::makePostCage($config_file, $strict);
        $this->cookie = Inspekt::makeCookieCage($config_file, $strict);
        $this->env = Inspekt::makeEnvCage($config_file, $strict);
        $this->files = Inspekt::makeFilesCage($config_file, $strict);
        $this->server = Inspekt::makeServerCage($config_file, $strict);
    }


    /**
     * @param $name
     */
    public function addAccessor($name)
    {
        $this->get->addAccessor($name);
        $this->post->addAccessor($name);
        $this->cookie->addAccessor($name);
        $this->env->addAccessor($name);
        $this->files->addAccessor($name);
        $this->server->addAccessor($name);
    }
}
