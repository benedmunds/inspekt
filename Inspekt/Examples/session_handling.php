<?php
set_include_path(get_include_path().PATH_SEPARATOR.dirname(dirname(__FILE__)));
require_once('Inspekt.php');



session_start();

$input = Inspekt::makeSuperCage();

echo "<pre>"; echo var_dump($input->session); echo "</pre>\n";


echo "<pre>SID:"; echo var_dump(SID); echo "</pre>\n";


echo ini_get('session.name');
echo ini_get('session.auto_start');
echo ini_get('session.use_cookies');
echo ini_get('session.use_only_cookies');



echo "<pre>"; echo var_dump($_SESSION); echo "</pre>\n";





if (!isset($input->session->_source['foo'])) {
	$input->session->_source['foo'] = 0;
} else {
	$input->session->_source['foo']++;
}

echo "<pre>"; echo var_dump($input->session); echo "</pre>\n";

/*$_SESSION = array();
$_SESSION['foo'] = $input->session->_source['foo'];*/

//echo "<pre>"; echo var_dump($_SESSION); echo "</pre>\n";