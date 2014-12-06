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
<?php
		if (!empty($_SESSION['Email'])) {
			$email = $_SESSION['Email'];
			
			$userResults = $mysqli->query("SELECT `Id` FROM `User` WHERE `Email` = '" . $email . "'");
			$userArray = mysqli_fetch_array($userResults);
		 
			$userid = $userArray['Id'];
			$qty = $_POST['qty'];
			$orderId = $_POST['orderId'];
			$productId = $_POST['productId'];
			$row = $mysqli->query("SELECT `Price`,`Inventory` FROM `Product` WHERE `Id` = " . $ProductId );
			$rowdetail = mysqli_fetch_row($row);
			$inventory = $rowdetail['Inventory'];
			$price = $rowdetail['Price'];
			if ($qty > $inventory) {
				echo "<p>We only have ". $inventory . " items. Please enter a smaller value.</p>"; 
			} else {
				$total = $price * $qty;
				
				 $updateQuery = $mysqli->query("Update `OrderItem` set `Quantity` =" . $qty . "' WHERE` OrderId`='" . $orderId . "'");
					
				 echo "<p>Quantity Updated</p>";
			}
			
		} else {
			echo "</head>\n<body>\n<div id=\"main\"";
			echo "<h1>Error</h1>";
			echo "<p> Please <a href=\"/php/login.php\">click here to sign in</a>.</p>";
		}
?>
		
		</div> <!-- End MainContent -->
		</div> <!-- End Wrap -->
	</body>
</html>
	



