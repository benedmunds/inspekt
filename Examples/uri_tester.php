<?php
require_once dirname(__FILE__) . "/../vendor/autoload.php";

use Inspekt\Inspekt;

$URIs = array(
    '//lessthan',
    'ftp://funky7:boooboo@123.444.999.12/',
    'http://spinaltap.micro.umn.edu/00/Weather/California/Los%lngeles',
    'http://funkatron.com/////////12341241',
    'http://funkatron.com:12',
    'http://funkatron.com:8000/#foo',
    'https://funkatron.com',
    'https://funkatron.com:42/funky.php?foo[]=bar',
    'http://www.w3.org/2001/XMLSchema',
);

foreach ($URIs as $uri) {
    echo 'Testing ' . $uri . '<br/>';
    $rs = Inspekt::isUri($uri);
    echo "<pre>";
    var_dump($rs);
    echo "</pre>\n";
    echo "<hr>";
}