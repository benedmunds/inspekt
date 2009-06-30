<?php
/**
 * Demonstration of:
 * - use of static filter methods on arrays
 * - creating a cage on an arbitrary array
 * - accessing a deep key in a multidim array with the "Array Query" approach
 */

require_once('../Inspekt.php');

echo "<p>Iterating over a cage's variables and calling Inspekt::getAlpha() on them.</p>\n\n";

$d = array();
$d['input'] = '<img id="475">yes</img>';
$d[] = array('foo', 'bar<br />', 'yes<P>', 1776);
$d['x']['woot'] = array('booyah'=>'meet at the bar at 7:30 pm',
						'ultimate'=>'<strong>hi there!</strong>',
						);

$d['lemon'][][][][][][][][][][][][][][] = 'far';

$_GET['locale'] = "en_US";
$_GET['new'] = 1;
$_GET['time'] = 1246233204.5486;
$_GET['id'] = 7444632820;
$_GET['key'] = "2.Hhun0mQ4KF1BfJ_WfeBB3Q__.86400.1246320000-714446282";
$_GET['ss'] = "un4SUm022i5sZ5iIZeNYWQ__";
$_GET['somestuff'] = "i, would, like, some, milk, and__cookies--please!";

$getCage = Inspekt::makeGetCage();

echo "\n<pre>All the cage params:\n\n";
foreach ($getCage as $key => $value) {
	var_dump($key);
	var_dump($value);
	var_dump($getCage->getAlpha($key));
	echo "\n";
}
echo 'Accessing cage param via array syntax "$getCage[\'locale\']" :: '.Inspekt::getAlnum($getCage['locale']);
echo "\n</pre>\n";
