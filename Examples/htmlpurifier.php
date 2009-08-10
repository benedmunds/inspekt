<?php
require_once '../Inspekt.php';


$inputarray['html'] = array(
	'xss'=>'<IMG """><SCRIPT>alert("XSS")</SCRIPT>">',
	'bad_nesting'=>'<p>This is a malformed fragment of <em>HTML</p></em>',
	'arstechnica'=>file_get_contents('./htmlpurifier_example_ars.html'),
	'google'=>file_get_contents('./htmlpurifier_example_google.html'),
	'imorecords'=>file_get_contents('./htmlpurifier_example_imorecords.html'),
	'soup'=>file_get_contents('./htmlpurifier_example_soup.html')
);

var_dump($inputarray);

/*
 * build our cage
 */
$cage = Inspekt_Cage::Factory($inputarray);

/*
 * set options to disable caching. This will slow down HTMLPurifer, but for the
 * sake of this example, we'll turn it off. You should set the cache path with
 * 'Cache.SerializerPath' in a production situation to a server-writable folder
 */
$opts['Cache.DefinitionImpl'] = null;

/*
 * because we don't assume you have HTMLPurifer installed, you have to load it
 * manually. we pass NULL as the first param because we don't need to point to
 * where HTMLPurifier is installed -- it's already in our include path via PEAR.
 * If you don't have it in your include path, give the full path to the file
 * you want to include
 */
$cage->loadHTMLPurifier(null, $opts);

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
?>