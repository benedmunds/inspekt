<?php
require_once('../Inspekt.php');

session_start();

echo "<h2>Session handling in Inspekt is still being worked on</h2>";

$input = Inspekt::makeSuperCage();

echo "<pre>\$input->session:"; echo var_dump($input->session); echo "</pre>\n";


echo "<pre>SID:"; echo var_dump(SID); echo "</pre>\n";

echo "<pre>";
echo "session.name:".ini_get('session.name')."\n";
echo "session.auto_start:".ini_get('session.auto_start')."\n";
echo "session.use_cookies:".ini_get('session.use_cookies')."\n";
echo "session.use_only_cookies:".ini_get('session.use_only_cookies')."\n";
echo "</pre>";


echo "<pre>\$_SESSION:"; echo var_dump($_SESSION); echo "</pre>\n";





if (!isset($input->session->_source['foo'])) {
	$input->session->_source['foo'] = 0;
} else {
	$input->session->_source['foo']++;
}

echo "<pre>\$input->session:"; echo var_dump($input->session); echo "</pre>\n";

$_SESSION = array();
$_SESSION['foo'] = $input->session->_source['foo'];

echo "<pre>"; echo var_dump($_SESSION); echo "</pre>\n";