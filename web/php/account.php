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

		</div> <!-- end "LeftSidebar" -->

		<div id="MainContent">

<?php
	if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email'])) {

		if(!empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['billingaddress']) && !empty($_POST['shippingaddress'])) {
			$email = $mysqli->escape_string($_POST['email']);
			$name = $mysqli->escape_string($_POST['name']);
			$billingaddress = $mysqli->escape_string($_POST['billingaddress']);
			$shippingaddress = $mysqli->escape_string($_POST['shippingaddress']);
			$password = password_hash($mysqli->escape_string($_POST['password']), PASSWORD_DEFAULT);


			$changeAccount = true;
			$changeEmail = true;

			if ($email === $_SESSION['Email']) {
				$changeEmail = false;
			}


			if ($changeEmail) {
				$checkemail = $mysqli->query("SELECT * FROM User WHERE Email = '" . $email . "'");

				if(!$checkemail || $checkemail->num_rows >= 1) {
					echo "<h1>Error</h1>";
					echo "<p>Sorry, there is already a user under that email address. Please go back and try again.</p>";
					$changeAccount = false;
				}
			}

			if ($changeAccount) {
				$accountChangeQuery = $mysqli->query("UPDATE User SET Email='" . $email . "', Name='" . $name . "', BillingAddress='" . $billingaddress . "', ShippingAddress='" . $shippingaddress . "', Password='" . $password . "' WHERE Email='" . $_SESSION['Email'] . "'");
				if($accountChangeQuery) {
					$_SESSION["ShippingAddress"] = $shippingaddress;
					$_SESSION["BillingAddress"] = $billingaddress;
					$_SESSION["Email"] = $email;
					$_SESSION["Name"] = $name;
					$_SESSION["LoggedIn"] = 1;
?>
				<h1>Success</h1>
				<p>Your account was successfully modified. Please <a href="/php/account.php">click here</a> to review your account details.</p>
<?php
				} else {
					echo "<h1>Error</h1>";
					echo "<p>Sorry, an error occurred while changing your account details. Please go back and try again.</p>";
				}
			}


		} else {
?>
		<form method="post" onsubmit="return validateAccountDetails()" name="changeaccount" id="myForm" class="myForm">
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
			
			<span class="weak" id="password-result"></span>

			<label>
				<span>&nbsp;</span>
				<input type="submit" id="submit" value="Change Account Details" />
			</label>
		</form>
<?php
		}
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
