<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This file defines an extention of the CI_Input class that utilizes Inspekt.
 * 
 * It REQUIRES PHP5. PHP5.2 or higher is strongly recommended. Inspekt must be
 * in your include path.
 * 
 * To use this library, drop it in your application's libraries/ folder with the
 * name "MY_Input.php" (the MY_ prefix may be different depending on your config).
 * 
 * This changes the behavior of the input library. Typically in CI, you would
 * access input this way:
 * 
 * <code>
 * $this->input->post('key');
 * </code>
 * 
 * This extention uses the Inspekt method for key retrieval, where you must
 * use an accessor method to test or filter the key. For example:
 * 
 * <code>
 * $this->input->post->getAlpha('key');
 * </code>
 * 
 * Also, the standard CI input lib would take a boolean as the second param to 
 * apply CI's XSS filtering. This is not available here, but you can still apply XSS
 * filtering to an arbitrary string via
 * 
 * <code>
 * $this->input->xss_clean($string);
 * </code>
 * 
 * Two config keys are used to configure the Inspekt SuperCage's behavior:
 * - 'inspekt_config_file' (default NULL)
 *   If set, this should point to an .ini file to configure Inspekt's
 *   auto-filtering behavior
 * - 'inspekt_strict' (default TRUE)
 *   If set, sets STRICT mode for the Inspekt cages. If strict mode is enabled,
 *   the corresponding superglobal for each cage is UNSET.
 * 
 * Other public functions from the standard CI Input library should be unchanged
 * 
 * This library also creates a pointer to the Inspekt SuperCage object, which 
 * you can access like this:
 * 
 * <code>
 * $this->inspekt->post->getAlpha('key');
 * </code>
 * 
 * Currently there's no great advantage to this approach, though.
 * 
 * @author Ed Finkler
 * @link http://inspekt.org
 */


/**
 * Inspekt must be in your include path
 */
require_once('Inspekt.php');

/**
 * This class utilizes the Inspekt input filtering and validation library
 */
class MY_Input extends CI_Input {
	
	/**
	 * Constructor
	 *
	 * @return void
	 * @author Ed Finkler
	 */
	public function MY_Input() {
		parent::CI_Input();
		$this->_makeInspektSuperCage();
	}
	
	/**
	 * This creates the supercage, through which we grab all data
	 *
	 * @return void
	 * @author Ed Finkler
	 */
	protected function _makeInspektSuperCage()
	{
		$CFG =& load_class('Config');
		$config = $CFG->item('inspekt_config_file');
		$strict = $CFG->item('inspekt_strict');
		
		/*
			set specific defaults
		*/
		if (!$config) { $config = NULL; }
		if (!$strict !== FALSE ) { $strict = TRUE; }

		$this->cage = Inspekt::makeSuperCage($config, $strict);
		$this->_mapCagesToProperties();
		/*
			allow direct access to supercage from CI object
		*/
		$CI->inspekt = $this->cage;
	}
	
	/**
	 * This maps the various cages in the supercage to properties of this object
	 * 
	 * It allows the dev to get input like this:
	 * 
	 * <code>$this->input->post->getAlpha('key')</code>
	 * 
	 * This is closer to the typical CI syntax
	 *
	 * @return void
	 * @author Ed Finkler
	 */
	protected function _mapCagesToProperties() {
		
		$cages = array('get', 'post', 'cookie', 'env', 'files', 'server', 'session');
		
		foreach ($cages as $val) {
			$this->{"$val"} = $this->cage->{"$val"};
		}
		
	}
	
	
	
}

