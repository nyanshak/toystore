<?php include "base.php"; ?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Toy Store logon</title>
		<link rel="stylesheet" href="/css/styles.css" type="text/css" />
<?php
if (!empty($_SESSION['Url'])) {
	$url = $_SESSION['Url'];
} else {
	$url = "/";
}

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
	echo "<meta http-equiv='refresh' content=\"0;$url\" />";
	echo "</head>\n<body>\n<div id=\"main\"";
	echo "<h1>Success</h1>";
	echo "<p>Redirecting to main page.</p>";

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
			
			echo "<meta http-equiv='refresh' content=\"0;$url\" />";
			echo "</head>\n<body>\n<div id=\"main\"";
			echo "<h1>Success</h1>";
			echo "<p>We are now redirecting you to $url.</p>";
			
		} else {
			echo "</head>\n<body>\n<div id=\"main\"";
			echo "<h1>Error</h1>";
			echo "<p>Sorry, an account with that email address and password combination could not be found. Please <a href=\"/php/login.php\">click here to try again</a>.</p>";
		}
		
	} else {
		echo "</head>\n<body>\n<div id=\"main\"";
		echo "<h1>Error</h1>";
		echo "<p>Sorry, no user exists with that username. Please <a href=\"/\">click here to try again</a>.</p>";
	}
} else {
	?>
	 


	</head>

	<body>
	<div id="main">
	 
	<form method="post" action="" name="loginform" id="loginform" class="myForm">
		<h1>Login</h1>
		<label>
			<span>Username</span>
			<input type="text" name="username" />
		</label>

		<label>
			<span>Password</span>
			<input type="text" name="password" />
		</label>

		<label>
			<span>&nbsp;</span>
			<input type="submit" value="Send" />
		</label>
	
		<p>Don't have an account? <a href="/php/register.php">Click here to register</a>.</p>
	</form>
	 
	<?php
}
?>

</div> 
</body>
</html>
