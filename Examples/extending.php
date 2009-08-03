<?php
require_once "../Inspekt.php";

Class Inspk2 extends Inspekt {
	
	/**
	 * a function to test for a valid username
	 *
	 * @param string $str 
	 * @return bool
	 * @author Ed Finkler
	 */
	static public function isUsername($value) {
		if (preg_match('/^[a-zA-Z0-9_]{1,64}$/', $value)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * a function to return values stripped of whitespace
	 *
	 * @param string|array $value 
	 * @return string|array
	 * @author Ed Finkler
	 */
	static public function noWhitespace($value) {
		if (self::isArrayOrArrayObject($value)) {
			return self::_walkArray($value, 'noWhitespace', __CLASS__);
		} else {
			return preg_replace("/\s+/", '', $value);
		}
	}
}


$username = "__funkyman";
$rs = Inspk2::isUsername($username);
echo "<pre>"; var_dump($rs); echo "</pre>";

$username = "lessth4nzer0";
$rs = Inspk2::isUsername($username);
echo "<pre>"; var_dump($rs); echo "</pre>";


$username = "harry-cary";
$rs = Inspk2::isUsername($username);
echo "<pre>"; var_dump($rs); echo "</pre>";


$input = array('lorem ipsum dolor', 'et tu brutae?');
$rs = Inspk2::noWhitespace($input);
echo "<pre>"; var_dump($rs); echo "</pre>";

