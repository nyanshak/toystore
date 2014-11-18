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

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email'])) {
	echo "<meta http-equiv='refresh' content=\"0;/\" />";
	echo "</head>\n<body>\n<div id=\"main\"";
	echo "<h1>Success</h1>";
	echo "<p>Redirecting to main page.</p>";

} elseif (!empty($_POST['email']) && !empty($_POST['password'])) {
	$email = $mysqli->escape_string($_POST['email']);
	$password = $mysqli->escape_string($_POST['password']);
	 
	$checklogin = $mysqli->query("SELECT * FROM User WHERE Email = '" . $email . "'");

	if ($checklogin->num_rows == 1) {
		$row = $checklogin->fetch_assoc();

		if (password_verify($password, $row['Password'])) {
			$shipAddr = $row['ShippingAddress'];
			$billAddr = $row['BillingAddress'];
			$name = $row['Name'];
		
			$_SESSION['Email'] = $email;
			$_SESSION['ShippingAddress'] = $shipAddr;
			$_SESSION['BillingAddress'] = $billAddr;
			$_SESSION['Name'] = $name;
			$_SESSION['LoggedIn'] = 1;
			
			echo "<meta http-equiv='refresh' content=\"0;$url\" />";
			echo "</head>\n<body>\n<div id=\"main\"";
			echo "<h1>Success</h1>";
			echo "<p>You will be redirected shortly.</p>";
			
		} else {
			echo "</head>\n<body>\n<div id=\"main\"";
			echo "<h1>Error</h1>";
			echo "<p>Sorry, an account with that email address and password combination could not be found. Please <a href=\"/php/login.php\">click here to try again</a>.</p>";
		}
		
	} else {
		echo "</head>\n<body>\n<div id=\"main\"";
		echo "<h1>Error</h1>";
		echo "<p>Sorry, no user exists under that email address. Please <a href=\"/php/login.php\">click here to try again</a>.</p>";
	}
} else {
	?>
	 


	</head>

	<body>
	<div id="main">
	 
	<form method="post" action="" name="loginform" id="loginform" class="myForm">
		<h1>Login</h1>
		<label>
			<span>Email</span>
			<input type="text" name="email" />
		</label>

		<label>
			<span>Password</span>
			<input type="password" name="password" />
		</label>

		<label>
			<span>&nbsp;</span>
			<input type="submit" value="Send" />
		</label>
	
		<span>Don't have an account? <a href="/php/register.php">Click here to register</a>.</span>
	</form>
	 
	<?php
}
?>

</div> 
</body>
</html>
