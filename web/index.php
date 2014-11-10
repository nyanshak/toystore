<?php include "php/base.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Toy Store logon</title>
		<link rel="stylesheet" href="/css/styles.css" type="text/css" />

<?php
if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
	 ?>
	</head>

	<body>
		<div id="main">
 
			<h1>Member Area</h1>
			<p>Thanks for logging in! You are <code><?=$_SESSION['Username']?></code> and your email address is <code><?=$_SESSION['EmailAddress']?></code>.</p>
		
	 <?php
} elseif (!empty($_POST['username']) && !empty($_POST['password'])) {
	$username = $mysqli->escape_string($_POST['username']);
	$password = $mysqli->escape_string($_POST['password']);
	 
	$checklogin = $mysqli->query("SELECT * FROM User WHERE Username = '" . $username . "'");

	if ($checklogin->num_rows == 1) {
		$row = $checklogin->fetch_assoc();

		if (password_verify($password, $row['Password'])) {
			$email = $row['Email'];
			$shipAddr = $row['ShippingAddress'];
			$billAddr = $row['BillingAddress'];
		
			$_SESSION['Username'] = $username;
			$_SESSION['EmailAddress'] = $email;
			$_SESSION['ShippingAddress'] = $shipAddr;
			$_SESSION['BillingAddress'] = $billAddr;
			$_SESSION['LoggedIn'] = 1;
			
			echo "<meta http-equiv='refresh' content=\"0;/index.php\" />";
			echo "</head>\n<body>\n<div id=\"main\"";
			echo "<h1>Success</h1>";
			echo "<p>We are now redirecting you to the member area.</p>";
			
		} else {
			echo "</head>\n<body>\n<div id=\"main\"";
			echo "<h1>Error</h1>";
			echo "<p>Sorry, an account with that email address and password combination could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
		}
		
	} else {
		echo "</head>\n<body>\n<div id=\"main\"";
		echo "<h1>Error</h1>";
		echo "<p>Sorry, no user exists with that username. Please <a href=\"index.php\">click here to try again</a>.</p>";
	}
} else {
	?>
	 
	</head>

	<body>
	<div id="main">
	<h1>Member Login</h1>
	 
	<p>Thanks for visiting! Please either login below, or <a href="php/register.php">click here to register</a>.</p>
	 
	<form method="post" action="index.php" name="loginform" id="loginform">
	<fieldset>
		<label for="username">Username</label><input type="text" name="username" id="username" /><br />
		<label for="password">Password</label><input type="password" name="password" id="password" /><br />
		<input type="submit" name="login" id="login" value="Login" />
	</fieldset>
	</form>
	 
	<?php
}
?>
 
	</div>
</body>
</html>
