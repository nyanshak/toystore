<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
 
	<title>Toy Store Registration</title>
	<link rel="stylesheet" href="/css/styles.css" type="text/css" />
	<link rel="stylesheet" href="/css/navbar.css" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="/js/navbar.js"></script>
	<script src="/js/leftsidebar.js"></script>
	<script src="/js/zxcvbn-async.js"></script>
	<script src="/js/password.js"></script>
	<script src="/js/validateAccount.js"></script>

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
<?php

if(empty($_SESSION["Url"])) {
	$_SESSION["Url"] = "/";
}

if(!empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['billingaddress']) && !empty($_POST['shippingaddress'])) {
	$email = $mysqli->escape_string($_POST['email']);
	$name = $mysqli->escape_string($_POST['name']);
	$billingaddress = $mysqli->escape_string($_POST['billingaddress']);
	$shippingaddress = $mysqli->escape_string($_POST['shippingaddress']);
	$password = password_hash($mysqli->escape_string($_POST['password']), PASSWORD_DEFAULT);
	
	 
	$checkemail = $mysqli->query("SELECT * FROM User WHERE Email = '" . $email . "'");
	  
	if(!$checkemail || $checkemail->num_rows >= 1) {
		echo "<h1>Error</h1>";
		echo "<p>Sorry, there is already a user under that email address. Please go back and try again.</p>";
	} else {
		$registerquery = $mysqli->query("INSERT INTO User (Email, Name, BillingAddress, ShippingAddress, Password) VALUES('" . $email . "', '" . $name . "', '" . $billingaddress . "', '" . $shippingaddress . "', '" . $password . "')");
		if($registerquery) {
			$_SESSION["ShippingAddress"] = $shippingaddress;
			$_SESSION["BillingAddress"] = $billingaddress;
			$_SESSION["Email"] = $email;
			$_SESSION["Name"] = $name;
			$_SESSION["LoggedIn"] = 1;
			?>
			<script>
				alert("Account successfully created. Redirecting to your previous page");
				window.location = "<?= $_SESSION_['Url'] ?>";
			</script>
			echo "<h1>Success</h1>";
			echo "<p>Your account was successfully created. Please <a href=\"" . $_SESSION['Url'] . "\">click here</a> to return to your previous page.</p>";
			<?php
		} else {
			echo "<h1>Error</h1>";
			echo "<p>Sorry, your registration failed. Please go back and try again.</p>";	
		}	   
	}
} else if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email'])) {
	?>
	<script type="text/javascript">
		window.location = "/";
	</script>

	<!-- Used if JS is disabled -->
	<h1>That's strange</h1>
	<p>You are already logged in. Please <a href="/">click here to return to the main page</a>.</p>

<?php
} else {
	?>
	 
	<form method="post" onsubmit="return validateNewAccountDetails()" name="registerform" id="registerform" class="myForm">
		<h1>Register
			<span>Please fill the fields below to register.</span>
			<span>Already have an account? <a href="/php/login.php">Click here to login</a>.</span>
		</h1>
		<label>
			<span>Name</span>
			<input type="text" name="name" id="name" />
		</label>

		<label>
			<span>Email</span>
			<input type="email" name="email" id="email" />
		</label>

		<label>
			<span>Billing Address</span>
			<input type="text" name="billingaddress" id="billingaddress" />
		</label>

		<label>
			<span>Shipping Address</span>
			<input type="text" name="shippingaddress" id="shippingaddress" />
		</label>

		<label>
			<span>Password</span>
			<input type="password" name="password" id="password" />
		</label>

		<span class="weak" id="password-result"></span>


		<label>
			<span>&nbsp;</span>
			<input type="submit" name="register" id="register" value="Register" />
		</label>
	</form>
	 
	<?php
}
	$mysqli->close();
?>
 
</div> <!-- end MainContent -->

<div id="RightSidebar">
</div> <!-- end RightSidebar -->
</div> <!-- end Wrap -->
</body>
</html>

