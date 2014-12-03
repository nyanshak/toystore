<?php
	define('INCL_BASE_CONST', TRUE);
	include "base.php";
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>Toy Store</title>
		<link rel="stylesheet" href="/css/styles.css" type="text/css" />
		<link rel="stylesheet" href="/css/navbar.css" type="text/css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="/js/navbar.js"></script>
		<script src="/js/leftsidebar.js"></script>
<?php
if (!empty($_SESSION['Url'])) {
	$url = $_SESSION['Url'];
} else {
	$url = "/";
}

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email'])) {
	?>
	<meta http-equiv="refresh" content="0;/" />
	</head>

	<body>
	<div id="Wrap">
	<h1>Success</h1>
	<p>Redirecting to main page.</p>
	<?php

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
			
?>
	<meta http-equiv="refresh" content="0;/" />
	</head>
	<body>
	<div id="Wrap">
	<h1>Success</h1>
	<p>You will be redirected shortly.</p>
<?php
			
		} else {
?>
	</head>
	<body>
	<div id="Wrap">
	<h1>Error</h1>
	<p>Sorry, an account with that email address and password combination could not be found. Please <a href="/php/login.php">click here to try again</a>.</p>
<?php
		}
		
	} else {
?>
	</head>
	<body>
	<div id="Wrap"
	<h1>Error</h1>
	<p>Sorry, no user exists under that email address. Please <a href="/php/login.php">click here to try again</a>.</p>
<?php
	}
} else {
	?>

	</head>

	<body>
	<div id="Wrap">
<?php
	define('INCL_HEADER_CONST', TRUE);
	ob_start();
	include('header.php');
	$result = ob_get_clean();
	echo $result;
?>
	<div id="LeftSidebar">
		&nbsp;
	</div>
	 
	<div id="MainContent">
	<form method="post" action="" name="loginform" id="loginform" class="myForm">
		<h1>
			Login
			<span>Don't have an account? <a href="/php/register.php">Click here to register</a>.</span>
		</h1>
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
	
	</form>
	</div>

	<div id="RightSidebar">
		&nbsp;
	</div>
	 
	<?php
}
?>

	</div> 
	</body>
</html>
