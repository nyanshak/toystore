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

$total=0;
if (!empty($_SESSION['Email'])) {
$email = $_SESSION['Email'];
$userResults = $mysqli->query("SELECT `Id` FROM `User` WHERE `Email` = '" . $email . "'");
$userArray = mysqli_fetch_array($userResults);
$userid = $userArray['Id'];
$checkOrder = $mysqli->query("SELECT * FROM `Order` WHERE `UserId` = " . $userid . " AND `Status` = 'Pending'");
$orderArray=mysqli_fetch_array($checkOrder);
$orderId=$orderArray['Id'];

 $checkOrder = $mysqli->query("SELECT `Quantity`,`ProductId` FROM `OrderItem` WHERE `OrderId`=" . $orderId);

while ($itemArray = mysqli_fetch_array($checkOrder)) {
$productId = $itemArray['ProductId'];
 
$qty=$itemArray['Quantity'];
$prodId=$_POST['productId'];
$row = $mysqli->query("SELECT `Price`,`Inventory` FROM `Product` WHERE `Id` = " . $productId );
$rowdetail = mysqli_fetch_array($row);
$inventory = $rowdetail['Inventory'];

$updateInventory = $inventory - $qty;

$price = $rowdetail['Price'];
$total=$total+($qty*$price); 
$updateQuery = $mysqli->query("UPDATE `Product` SET `Inventory` =" . $updateInventory . " WHERE `Id`=" .$productId );
   
}
$date = date_create()->format('Y-m-d');
    echo '<br/>';
    
$updateOrder= $mysqli->query("UPDATE `Order` SET `Status`='Confirmed', `Total`= ". $total . " , `OrderDate`='" . $date . "' WHERE `Id`=" . $orderId );
  if ($updateOrder) {
    echo "<p>Your order has been placed. Please go to <a href=\"/php/OrderHistory.php\">My Orders</a> to view all your orders</p>";
}
} else {
    echo "<p>Error updating record: " . $conn->error . "</p>";
}  


?>
</div> <!-- End MainContent -->
</div> <!-- End Wrap -->
</body>
</html>
