<?php
/**
 * Inspekt Supercage
 *
 * @author Ed Finkler <coj@funkatron.com>
 *
 * @package Inspekt
 */

/**
 * require main Inspekt class
 */
require_once 'Inspekt.php';

/**
 * require the Cage class
 */
require_once 'Inspekt/Cage.php';

/**
 * The Supercage object wraps ALL of the superglobals
 *
 */
Class Inspekt_Supercage {

	/**
	 * The get cage
	 *
	 * @var Inspekt_Cage
	 */
	var $get;

	/**
	 * The post cage
	 *
	 * @var Inspekt_Cage
	 */
	var $post;

	/**
	 * The cookie cage
	 *
	 * @var Inspekt_Cage
	 */
	var $cookie;

	/**
	 * The env cage
	 *
	 * @var Inspekt_Cage
	 */
	var $env;

	/**
	 * The files cage
	 *
	 * @var Inspekt_Cage
	 */
	var $files;

	/**
	 * The session cage
	 *
	 * @var Inspekt_Cage
	 */
	var $session;

	var $server;

	/**
	 * Enter description here...
	 *
	 * @return Inspekt_Supercage
	 */
	function Inspekt_Supercage() {
		// placeholder
	}

	/**
	 * Enter description here...
	 * 
	 * @param string  $config_file
	 * @param boolean $strict
	 * @return Inspekt_Supercage
	 */
	function Factory($config_file = NULL, $strict = TRUE) {

		$sc	= new Inspekt_Supercage();
		$sc->_makeCages($strict, $config_file);

		// eliminate the $_REQUEST superglobal
		if ($strict) {
			$_REQUEST = null;
		}

		return $sc;

	}

	/**
	 * Enter description here...
	 *
	 * @see Inspekt_Supercage::Factory()
	 * @param string  $config_file
	 * @param boolean $strict
	 */
	function _makeCages($config_file=NULL, $strict=TRUE) {
		$this->get		= Inspekt::makeGetCage($config_file, $strict);
		$this->post		= Inspekt::makePostCage($config_file, $strict);
		$this->cookie	= Inspekt::makeCookieCage($config_file, $strict);
		$this->env		= Inspekt::makeEnvCage($config_file, $strict);
		$this->files	= Inspekt::makeFilesCage($config_file, $strict);
		// $this->session	= Inspekt::makeSessionCage($config_file, $strict);
		$this->server	= Inspekt::makeServerCage($config_file, $strict);
	}

}