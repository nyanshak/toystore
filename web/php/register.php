<?php include "base.php"; ?>

<!doctype html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
 
<title>Toy Store Registration</title>
<link rel="stylesheet" href="/css/styles.css" type="text/css" />
</head>  
<body>  
<div id="main">
<?php

if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['billingaddress']) && !empty($_POST['shippingaddress'])) {
	$username = $mysqli->escape_string($_POST['username']);
	$email = $mysqli->escape_string($_POST['email']);
	$name = $mysqli->escape_string($_POST['name']);
	$billingaddress = $mysqli->escape_string($_POST['billingaddress']);
	$shippingaddress = $mysqli->escape_string($_POST['shippingaddress']);
	$password = password_hash($mysqli->escape_string($_POST['password']), PASSWORD_DEFAULT);
	
	 
	$checkusername = $mysqli->query("SELECT * FROM User WHERE Username = '" . $username . "' || Email ='" . $email . "'");
	  
	if(!$checkusername || $checkusername->num_rows >= 1) {
		echo "<h1>Error</h1>";
		echo "<p>Sorry, that username or email is taken. Please go back and try again.</p>";
	} else {
		$registerquery = $mysqli->query("INSERT INTO User (Username, Email, Name, BillingAddress, ShippingAddress, Password) VALUES('" . $username . "', '" . $email . "', '" . $name . "', '" . $billingaddress . "', '" . $shippingaddress . "', '" . $password . "')");
		if($registerquery) {
			echo "<h1>Success</h1>";
			echo "<p>Your account was successfully created. Please <a href=\"/index.php\">click here to login</a>.</p>";
		} else {
			echo "<h1>Error</h1>";
			echo "<p>Sorry, your registration failed. Please go back and try again.</p>";	
		}	   
	}
} else {
	?>
	 
   <h1>Register</h1>
	 
   <p>Please enter your details below to register.</p>
	 
	<form method="post" action="register.php" name="registerform" id="registerform">
	<fieldset>
		<label for="username">Username</label><input type="text" name="username" id="username" /><br />
		<label for="name">Name</label><input type="text" name="name" id="name" /><br />
		<label for="billingaddress">Billing Address</label><input type="text" name="billingaddress" id="billingaddress" /><br />
		<label for="shippingaddress">Shipping Address</label><input type="text" name="shippingaddress" id="shippingaddress" /><br />
		<label for="email">Email Address</label><input type="text" name="email" id="email" /><br />
		<label for="password">Password</label><input type="password" name="password" id="password" /><br />
		<input type="submit" name="register" id="register" value="Register" />
	</fieldset>
	</form>
	 
	<?php
}
	$mysqli->close();
?>
 
</div>
</body>
</html>

