<?php
/**
 * Demonstration of:
 * - singleton pattern used by the Inspekt::make*Cage() functions
 * - "Array Query" approach of accessing deep keys in multidim arrays
 */


require_once('../Inspekt.php');


/**
 * first level of scoping
 *
 */
function testScoping() {
	testScoping2();
}

/**
 * second level of scoping
 *
 */
function testScoping2() {
	$cage_POST = Inspekt::makePostCage();
	echo "<pre>In " . __FUNCTION__."(): "; echo var_dump($cage_POST->testAlnum('/funky,_+=_\|;:!@#$%^&*~time/0/0/`~foo,.+=_\|;:!@#$%^&*~-bar')); echo "</pre>\n";

	echo "<pre>POST is not accessible here: "; echo var_dump($_POST); echo "</pre>\n";
}

?>

<form action="" method="post">
	<input type="text" name="funky,.+=_\|;:!@#$%^&*~time[][][`~foo,.+=_\|;:!@#$%^&*~-bar]" value='75563' />
	<input type="submit" value="submit" />
</form>

<?php
	$cage_POST = Inspekt::makePostCage();
	echo "<pre>In MAIN: "; echo var_dump($cage_POST->testAlnum('/funky,_+=_\|;:!@#$%^&*~time/0/0/`~foo,.+=_\|;:!@#$%^&*~-bar')); echo "</pre>\n";

	testScoping();
?>