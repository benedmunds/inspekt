<?php
require_once "../Inspekt.php";
require_once('../Inspekt/AccessorAbstract.php');

class testUsername extends AccessorAbstract {
	/**
	 * a function to test for a valid username
	 *
	 * @param string $str 
	 * @return bool
	 * @author Ed Finkler
	 */
	protected function inspekt($val) {
		if (preg_match('/^[a-zA-Z0-9_]{1,64}$/', $val)) {
			return $val;
		} else {
			return false;
		}
	}
	
}


class noWhitespace extends AccessorAbstract {	
	/**
	 * a function to return values stripped of whitespace
	 *
	 * @param string|array $value 
	 * @return string|array
	 * @author Ed Finkler
	 */
	protected function inspekt($val) {
		return preg_replace("/\s+/", '', $val);
	}
	
}

$superCage = Inspekt::makeSuperCage();

$superCage->addAccessor('testUsername');
$superCage->addAccessor('noWhitespace');


$rs = $superCage->server->testUsername('GIT_EDITOR');
var_dump($rs);

$rs = $superCage->server->noWhitespace('MANPATH');
var_dump($rs);


/*
	Now let's take an arbitrary cage
*/
$d = array();
$d['input'] = '<img id="475">yes</img>';
$d['lowascii'] = '    ';
$d[] = array('foo', 'bar<br />', 'yes<P>', 1776);
$d['x']['woot'] = array('booyah'=>'meet at the bar at 7:30 pm',
						'ultimate'=>'<strong>hi there!</strong>',
						);

$dc = Inspekt_Cage::Factory($d);

/*
	Sad that we have to re-add, but it's done on a cage-by-cage basis
*/
$dc->addAccessor('testUsername');
$dc->addAccessor('noWhitespace');

$rs = $dc->noWhitespace('x');
var_dump($rs);