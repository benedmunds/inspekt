<?php
require_once('../Inspekt.php');

/*
	initialize the supercage
*/
$sc = Inspekt::makeSuperCage();

/**
 * a wrapper to retrieve input from either the get or post Inspekt cages
 *
 * @param string $key the key you're trying to retrieve
 * @param string $accessor the name of the accessor method to use
 * @return mixed  null if key does not exist
 * @author Ed Finkler
 */
function getInputGP($key, $accessor) {
	
	/*
		this returns the singleton
	*/
	$sc = Inspekt::makeSuperCage();
	
	if ($sc->get->keyExists($key)) {
		return $sc->get->$accessor($key);
	} elseif ($sc->post->keyExists($key)) {
		return $sc->post->$accessor($key);
	} else {
		return null;
	}
	
}


$id = getInputGP('id', 'getInt');

echo "<pre>"; var_dump($id); echo "</pre>";


?>