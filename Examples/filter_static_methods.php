<?php
/**
 * Demonstration of:
 * - use of static filter methods on arrays
 */


require_once('../Inspekt.php');

$d = array();
$d['input'] = '<img id="475">yes</img>';
$d['lowascii'] = '    ';
$d[] = array('foo', 'bar<br />', 'yes<P>', 1776);
$d['x']['woot'] = array('booyah'=>'meet at the bar at 7:30 pm',
						'ultimate'=>'<strong>hi there!</strong>',
						);

$d['lemon'][][][][][][][][][][][][][][] = 'far';
?>
<h2>A crazy, crazy array ($d)</h2>
<?php
echo "<pre>"; echo var_dump($d); echo "</pre>\n";
?>


<h2>Inspekt::noTags($d)</h2>
<?php
$newd = Inspekt::noTags($d);
echo "<pre>"; echo var_dump($newd); echo "</pre>\n";
?>


<h2>Inspekt::noTagsOrSpecial($d)</h2>
<?php
$newd = Inspekt::noTagsOrSpecial($d);
echo "<pre>"; echo var_dump($newd); echo "</pre>\n";
?>


<h2>Inspekt::getDigits($d)</h2>
<?php
$newd = Inspekt::getDigits($d);
echo "<pre>"; echo var_dump($newd); echo "</pre>\n";
?>


<h2>Inspekt::getROT13($d)</h2>
<?php
$newd = Inspekt::getROT13($d);
echo "<pre>"; echo var_dump($newd); echo "</pre>\n";
?>
