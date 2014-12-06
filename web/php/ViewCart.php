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
			
			$checkOrder = $mysqli->query("SELECT * FROM `Order` WHERE `UserId` = " . $userid . " and `Status` = 'Pending'");
			
			if ($checkOrder->num_rows > 0) {
				 
				while($order = mysqli_fetch_array($checkOrder)) {
					$orderId = $order['Id'];
?>
			<table class="order">
				<tr class="border">
					<th>Name</th>
					<th>Description</th>
					<th>Quantity</th>
					<th>Price</th>
				</tr>
<?php
					$quantity = 1;
					$orderItems = $mysqli->query("SELECT * FROM `OrderItem` WHERE `OrderId` = " . $orderId );
						 
					if ($orderItems->num_rows > 0) {
						$i = 1;	
						while($itemDetail = mysqli_fetch_array($orderItems)){
							$productId = $itemDetail['ProductId'];
							$quantity = $itemDetail['Quantity'];
							$price = $itemDetail['Price'];
							$productResult = $mysqli->query("SELECT * FROM `Product` WHERE `Id` = " . $productId );
							$productDetail = mysqli_fetch_array($productResult);
							$pname = $productDetail['Name'];
							$description = $productDetail['Description'];
							$plink = $productDetail['Picture']; 
							
									
							echo '<tr>';
							echo '<td><img src="' . $plink . '" alt="Product Picture"><br/>' . $pname . '</td>';
							echo '<td>' . $description . '</td>';
							echo "<td>Quantity: <input type='text' id='itemQuantity" . $i . "' size='2' maxLength='3' value=" . $quantity . '>&nbsp;<input type="submit" id="validQuant" value="Update"/></td>';
							echo '<td>Price: ' . $price * $quantity . '</td>';
							echo '</tr>';
							$i++;	 
						}
					}
					echo "<input type='hidden' id='quantI' value=" . $i . "'>'" ;
					
					echo "<tr> <td colspan='4'> <input type='submit' action='PlaceOrder.php' value='Place Order'></td></tr>";
					echo '</table>';
				}
			} else {
				echo "</head>\n<body>\n<div id=\"main\"";
				echo "<h1>Empty Cart</h1>";
				echo "<p>Sorry, There are no items in your cart. Please <a href=\"/\">Click here to look at our catalog</a>.</p>";
			}
			
			echo '</table>';
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
	



