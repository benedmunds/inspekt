<?php
/**
 * Demonstration of:
 * - use of static filter methods on arrays
 * - creating a cage on an arbitrary array
 * - accessing a deep key in a multidim array with the "Array Query" approach
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


<h2>Create a cage for the array</h2>
<?php
$d_cage = Inspekt_Cage::Factory($d);

?>


<h2>$d_cage->getAlpha('/x/woot/ultimate')</h2>
<?php
echo "<pre>"; echo var_dump($d_cage->getAlpha('/x/woot/ultimate')); echo "</pre>\n";

?>


<h2>$d_cage->getAlpha('lemon/0/0/0/0/0/0/0/0/0/0/0/0/0')</h2>
<?php
echo "<pre>"; echo var_dump($d_cage->getAlpha('lemon/0/0/0/0/0/0/0/0/0/0/0/0/0')); echo "</pre>\n";

?>


<h2>$d_cage->getAlpha('x')</h2>
<?php
$x = $d_cage->getAlpha('x');
echo "<pre>"; echo var_dump($x); echo "</pre>\n";
?>


<h2>$d_cage->getAlpha('input')</h2>
<?php
$x = $d_cage->getAlpha('input');
echo "<pre>"; echo var_dump($x); echo "</pre>\n";
?>


<h2>$d_cage->getROT13('input')</h2>
<?php
$input = $d_cage->getROT13('input');
echo "<pre>"; echo var_dump($input); echo "</pre>\n";
?>
