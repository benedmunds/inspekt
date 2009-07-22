<?php
require_once('../Inspekt.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>formtest</title>
	
</head>

<body>
	<form action="formtest.php" method="POST">
		<h3>Enter 5 email addresses</h3>
		<input type="text" name="email_addresses[group1][a]" value="foo1@bar.com" /><br />
		<input type="text" name="email_addresses[group1][b]" value="foo2@bar.com" /><br />
		<input type="text" name="email_addresses[group1][c]" value="foo3@bar.com" /><br />
		<input type="text" name="email_addresses[group2][a]" value="foo4@bar.com" /><br />
		<input type="text" name="email_addresses[group2][b]" value="foo5@bar.com" /><br />
		<input type="text" name="email_addresses[group3][a]" value="foo6@bar.com" /><br />
		<input type="text" name="email_addresses[group3][b]" value="foo7@bar.com" /><br />
		
		<input type="submit" name="submit" value="Go!" id="submit" />
	</form>
	
	<?php
	$input = Inspekt::makeSuperCage();
	
	if ($email = $input->post->testEmail('/email_addresses/group3/a')) {
		echo $email;
	} else {
		echo "invalid address";
	}
	

	?>

</body>
</html>
