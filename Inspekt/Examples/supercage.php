<?php

set_include_path(get_include_path().PATH_SEPARATOR.dirname(dirname(__FILE__)));

require_once('Inspekt.php');

$superCage = Inspekt::makeSuperCage();

echo "<pre>"; echo var_dump($superCage); echo "</pre>\n";

echo 'Digits:'.$superCage->server->getDigits('SERVER_SOFTWARE').'<p/>';
echo 'Alpha:'.$superCage->server->getAlpha('SERVER_SOFTWARE').'<p/>';
echo 'Alnum:'.$superCage->server->getAlnum('SERVER_SOFTWARE').'<p/>';
echo 'Raw:'.$superCage->server->getRaw('SERVER_SOFTWARE').'<p/>';