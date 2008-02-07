<?php
/**
 * Inspekt Session Cage - main source file
 *
 * @author Chris Shiflett <chris@shiflett.org>
 * @author Ed Finkler <coj@funkatron.com>
 *
 * @package Inspekt
 */


/**
 * @package Inspekt
 */
class Inspekt_Cage_Session extends Inspekt_Cage {
	
//	var $_session_id;
//	
//	var $_session_name;
	
	function Factory(&$source, $conf_file = NULL, $conf_section = NULL, $strict = TRUE) {

		if (!is_array($source)) {
			user_error('$source '.$source.' is not an array', E_USER_NOTICE);
		}

		$cage = new Inspekt_Cage_Session();
		$cage->_setSource($source);
		$cage->_parseAndApplyAutoFilters($conf);
		
		if (ini_get('session.use_cookies') || ini_get('session.use_only_cookies') ) {
			if (isset($_COOKIE) && isset($_COOKIE[session_name()])) {
				session_id($_COOKIE[session_name()]);
			} elseif ($cookie = Inspekt::makeSessionCage()) {
				session_id($cookie->getAlnum(session_name()));
			}
		} else { // we're using session ids passed via GET
			if (isset($_GET) && isset($_GET[session_name()])) {
				session_id($_GET[session_name()]);
			} elseif ($cookie = Inspekt::makeSessionCage()) {
				session_id($cookie->getAlnum(session_name()));
			}
		}
		
		
		if ($strict) {
			$source = NULL;
		}

		return $cage;
		
		register_shutdown_function();
		
		register_shutdown_function( array($this, '_repopulateSession') );
		
	}
	
	
	
	function _repopulateSession() {
		
//		echo "<pre>"; echo var_dump($this->_source); echo "</pre>\n";
		$_SESSION = array();
		
		$_SESSION = $this->_source;
//		echo "<pre>"; echo var_dump($_SESSION); echo "</pre>\n";
		
	}
	

	
}