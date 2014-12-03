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
			header('Content-Type: application/json');

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
			
			$checkOrder = $mysqli->query("SELECT * FROM `Order` WHERE `UserId` = " . $userid);
			
			if ($checkOrder->num_rows > 0) {
				   
				while($order = mysqli_fetch_array($checkOrder)) {
					$orderId = $order['Id'];
					$total = $order['Total'];
					$orderDate = $order['OrderDate'];
					$status = $order['Status'];
					
					echo '<table class="order">';
					echo '<tr class="border">';
					echo "<td>Order Placed<br/>" . $orderDate . "</td>";
					echo "<td>Order Status<br/>" . $status . "</td>";
					echo "<td>Total<br/>" . $total . "</td>";
					echo "<td> Order " . $orderId . "</td>";
					echo "</tr>";
					
					$orderItems = $mysqli->query("SELECT * FROM `OrderItem` WHERE `OrderId` = " . $orderId );
						 
					if ($orderItems->num_rows > 0) {
								
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
							echo '<td>Quantity: ' . $quantity .'</td>';
							echo '<td>Price: ' . $price . '</td>';
							echo '</tr>';
							   
						}
					}
					echo '</table>';
				}
			} else {
				echo "</head>\n<body>\n<div id=\"main\"";
				echo "<h1>No Orders Found</h1>";
				echo "<p>Sorry, you do not have any existing orders with us. Please <a href=\"/php/products.php\">Click here to look at our catalog</a>.</p>";
			}
			
			echo '</table>';
		} else {
			echo "</head>\n<body>\n<div id=\"main\"";
			echo "<h1>Error</h1>";
			echo "<p> Please <a href=\"/php/login.php\">click here to sign in</a>.</p>";
		}?>
		
		</div>
		</div>
	</body>
</html>
	



