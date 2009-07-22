<?php
/**
 * Demonstration of:
 * - helper "make*Cage()" methods to create input cage from superglobal
 * - cleanup of HTTP_*_VARS
 * - cage filter methods
 * - "Array Query" method of accessing deep keys in multidim arrays
 */


require_once('../Inspekt.php');

$serverCage = Inspekt::makeServerCage();

echo "<pre>"; echo var_dump($serverCage); echo "</pre>\n";

echo 'Digits:'.$serverCage->getDigits('SERVER_SOFTWARE').'<p/>';
echo 'Alpha:'.$serverCage->getAlpha('SERVER_SOFTWARE').'<p/>';
echo 'Alnum:'.$serverCage->getAlnum('SERVER_SOFTWARE').'<p/>';
echo 'Raw:'.$serverCage->getRaw('SERVER_SOFTWARE').'<p/>';

echo '<pre>$_SERVER:'; echo var_dump($_SERVER); echo "</pre>\n";
echo '<pre>HTTP_SERVER_VARS:'; echo var_dump($HTTP_SERVER_VARS); echo "</pre>\n";

var_dump($serverCage->getAlnum('/argv/0'));