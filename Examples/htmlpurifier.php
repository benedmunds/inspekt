<?php
require_once dirname(__FILE__) . "/../vendor/autoload.php";

use Inspekt\Cage;

$inputarray['html'] = array(
    'xss' => '<IMG """><SCRIPT>alert("XSS")</SCRIPT>">',
    'bad_nesting' => '<p>This is a malformed fragment of <em>HTML</p></em>',
    'arstechnica' => file_get_contents('./htmlpurifier_example_ars.html'),
    'google' => file_get_contents('./htmlpurifier_example_google.html'),
    'imorecords' => file_get_contents('./htmlpurifier_example_imorecords.html'),
    'soup' => file_get_contents('./htmlpurifier_example_soup.html')
);

var_dump($inputarray);

/*
 * build our cage
 */
$cage = Cage::Factory($inputarray);

/*
 * set options to disable caching. This will slow down HTMLPurifer, but for the
 * sake of this example, we'll turn it off. You should set the cache path with
 * 'Cache.SerializerPath' in a production situation to a server-writable folder
 */
$opts['Cache.DefinitionImpl'] = null;

/**
 * HTMLPurifier loading should be handled by your composer autoloader
 */
$cage->loadHTMLPurifier($opts);

$cleanHTML = $cage->getPurifiedHTML('html');


echo "<hr>";

echo "<h2>xss</h2>";
var_dump($cleanHTML['xss']);

echo "<h2>bad_nesting</h2>";
var_dump($cleanHTML['bad_nesting']);

echo "<h2>arstechnica</h2>";
echo "<pre>";
echo htmlspecialchars($cleanHTML['arstechnica'], ENT_QUOTES);
echo "</pre>";

echo "<h2>google</h2>";
echo "<pre>";
echo htmlspecialchars($cleanHTML['google'], ENT_QUOTES);
echo "</pre>";

echo "<h2>imorecords</h2>";
echo "<pre>";
echo htmlspecialchars($cleanHTML['imorecords'], ENT_QUOTES);
echo "</pre>";

echo "<h2>soup</h2>";
echo "<pre>";
echo htmlspecialchars($cleanHTML['soup'], ENT_QUOTES);
echo "</pre>";
