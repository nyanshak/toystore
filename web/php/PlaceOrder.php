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
		<script src="/js/PlaceOrder.js"></script>
	</head>

	<body>
		
		<div id="Wrap">
		 
<?php
	$_SESSION["Url"] = $_SERVER["REQUEST_URI"];
	define('INCL_HEADER_CONST', TRUE);
	ob_start();
	include('header.php');
	$result = ob_get_clean();
	echo $result;

	define('INCL_BASE_CONST', true);
	include ('base.php');
 
	unset($params);
?>
		<div id="LeftSidebar">

		</div> <!-- end "LeftSidebar" -->
		<div id="MainContent">
<?
		if (!empty($_SESSION['Email'])) {
			$email = $_SESSION['Email'];
			
			$userResults = $mysqli->query("SELECT `Id` FROM `User` WHERE `Email` = '" . $email . "'");
			$userArray = mysqli_fetch_array($userResults);
		 
			$userid = $userArray['Id'];
			
			$updateQuery= $mysqli->query("Update `Order` set `Status` = 'Confirmed' where `Status` = 'Pending' and `UserId`='" . $userid . "'");
					
			$orderItems = $mysqli->query("SELECT * FROM `OrderItem` WHERE `OrderId` = " . $orderId );
						 
			if ($orderItems->num_rows > 0) {
								
				while ($itemDetail = mysqli_fetch_array($orderItems)) {

					$orderId = $itemDetail['OrderId'];
				 	$query = $mysqli->query("UPDATE `OrderItem` SET `Quantity` = '" . $quant[$i] . "'WHERE `OrderId` = " . $orderId);
							
				}
				echo '</table>';
			} else {
				echo "<h1>Empty Cart</h1>";
				echo "<p>Sorry, There are no items in your cart. Please <a href=\"/\">Click here to look at our catalog</a>.</p>";
			}
			
		} else {
			echo "<h1>Error</h1>";
			echo "<p> Please <a href=\"/php/login.php\">click here to sign in</a>.</p>";
		}
?>
		</div> <!-- end MainContent -->
		</div> <!-- end Wrap -->
	</body>
</html>
	
