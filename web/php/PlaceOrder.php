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
include ('header.php');

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
	$checkOrder = $mysqli->query("SELECT * FROM `Order` WHERE `UserId` = " . $userid);
	$orderArray = mysqli_fetch_array($checkOrder);
	$orderId = $orderArray['Id'];
	$total = 0;
	$checkOrder = $mysqli->query("SELECT `Quantity`,`ProductId` FROM `OrderItem` WHERE `OrderId`=" . $orderId);
	while ($itemArray = mysqli_fetch_array($checkOrder)) {
		$productId = $itemArray['ProductId'];
		$qty = $itemArray['Quantity'];
		$total = $_POST['total'];
		echo "total:" . $total;
		$row = $mysqli->query("SELECT `Price`,`Inventory` FROM `Product` WHERE `Id` = " . $productId);
		$rowdetail = mysqli_fetch_array($row);
		$inventory = $rowdetail['Inventory'];
		$updateInventory = $inventory - $qty;
		$price = $rowdetail['Price'];
		$updateQuery = $mysqli->query("UPDATE `Product` SET `Inventory` =" . $updateInventory . " WHERE `Id`=" . $productId);
	}

	$date = date_create()->format('Y-m-d');
	echo '<br/>';
	$updateOrder = $mysqli->query("UPDATE `Order` SET `Status`='Confirmed', `Order`= " . $total . " `OrderDate`='" . $date . "' WHERE `Id`=" . $orderId);
	if ($updateOrder) {
		echo "<p>Your order has been placed. Please go to <a href=\"/php/OrderHistory.php\">My Orders</a> to view all your orders</p>";
	}
}
else {
	echo "Error updating record: " . $conn->error;
}

?>
</div> <!-- End MainContent -->
</div> <!-- End Wrap -->
</body>
</html>
