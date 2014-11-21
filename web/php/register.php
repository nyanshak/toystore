<?php
	define('INCL_BASE_CONST', true);
	include "base.php";
?>

<!doctype html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
 
<title>Toy Store Registration</title>
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>  
<body>  
<div id="main">
<?php

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
			echo "<h1>Success</h1>";
			echo "<p>Your account was successfully created. Please <a href=\"/index.php\">click here to login</a>.</p>";
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
	 
	 
	 
	<form method="post" action="" name="registerform" id="registerform" class="myForm">
		<h1>Register
			<span>Please fill the fields below to register.</span></h1>
		
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

		<label>
			<span>&nbsp;</span>
			<input type="submit" name="register" id="register" value="Register" />
		</label>
		<span>Already have an account? <a href="/php/login.php">Click here to login</a>.</span>
	</form>
	 
	<?php
}
	$mysqli->close();
?>
 
</div>
</body>
</html>

