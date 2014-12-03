<?php
	$_SESSION['Url'] = $_SERVER["REQUEST_URI"];
?>
<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Toy Store</title>
		<link rel="stylesheet" href="/css/styles.css" type="text/css" />
		<link rel="stylesheet" href="/css/navbar.css" type="text/css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="/js/navbar.js"></script>
		<script src="/js/leftsidebar.js"></script>
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

		</div> <!-- end "LeftSidebar" -->

		<div id="MainContent">

<?php
	if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email'])) {
		?>
		<form method="post" action="" name="changeaccount" id="accountform" class="myForm">
			<h1>Your Account</h1>
			<label>
				<span>Name</span>
				<input type="text" name="name" id="name" value="<?=$_SESSION['Name'] ?>" />
			</label>

			<label>
				<span>Email</span>
				<input type="email" name="email" id="email" value="<?=$_SESSION['Email'] ?>" />
			</label>

			<label>
				<span>Billing Address</span>
				<input type="text" name="billingaddress" id="billingaddress" value="<?=$_SESSION['BillingAddress'] ?>" />
			</label>

			<label>
				<span>Shipping Address</span>
				<input type="text" name="shippingaddress" id="shippingaddress" value="<?=$_SESSION['ShippingAddress'] ?>" />
			</label>
	
			<label>
				<span>Password</span>
				<input type="password" name="password" id="password" />
			</label>

			<label>
				<span>&nbsp;</span>
				<input type="submit" name="register" id="register" value="Register" value="<?=$_SESSION['Name'] ?>" />
			</label>
		</form>
		<?php
	} else {
		?>
		<h1>Error</h1>
		<p>You must be logged in to make changes to your account. Please click <a href="/php/login.php">here</a> to sign in or <a href="/php/register.php">here</a> to register.</p>
		<?php
	}
?>

		</div> <!-- end "MainContent" -->

		<div id="RightSidebar">

		</div> <!-- end "RightSidebar" -->

		</div> <!-- end "Wrap" -->
 
	</div>
</body>
</html>
