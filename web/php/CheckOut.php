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
<form id='orderform' method='POST' action='/php/PlaceOrder.php'>

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
$userResults = $mysqli->query("SELECT `Id`,`ShippingAddress` FROM `User` WHERE `Email` = '" . $email . "'");
$userArray = mysqli_fetch_array($userResults);
$userid = $userArray['Id'];
$address = $userArray['ShippingAddress'];
$checkOrder = $mysqli->query("SELECT * FROM `Order` WHERE `UserId` = " . $userid . " and `Status` = 'Pending'");
if ($checkOrder->num_rows > 0) {
while($order = mysqli_fetch_array($checkOrder)) {
$orderId = $order['Id'];

echo "<table class='order'>";
echo "<tr class='border'>";
echo "<td>Name<br/></td>";
echo "<td>Description<br/></td>";
echo "<td>Quantity</td>";
echo "<td> Price </td>";
echo "</tr>";
$orderItems = $mysqli->query("SELECT * FROM `OrderItem` WHERE `OrderId` = " . $orderId );
$i = 1;
$stax=0;
$total=0;
if ($orderItems->num_rows > 0) {

while ($itemDetail = mysqli_fetch_array($orderItems)) {
$productId = $itemDetail['ProductId'];
$quantity = $itemDetail['Quantity'];
$price = $itemDetail['Price'];
$productResult = $mysqli->query("SELECT * FROM `Product` WHERE `Id` = " . $productId );
$productDetail = mysqli_fetch_array($productResult);
$pname = $productDetail['Name'];
$description = $productDetail['Description'];
$plink = $productDetail['Picture'];
$total=$total+($price*$quantity);    
echo '<tr>';
echo '<td><img src="' . $plink . '" alt="Product Picture"><br/>' . $pname . '</td>';
echo '<td>' . $description . '</td>';
echo "<td><span id='itemQuantity'>" . $quantity . "</span> <input type='hidden' id='orderId' value=" . $orderId . "> <input type='hidden' id='productId' value=" . $productId . "></td>";
echo "<td><span id='newPrice'>" . $price * $quantity . '</span></td>';
echo '</tr>';
}
}

$stax = 0.08 * $total;
$total=$total+$stax;
   
echo "<tr> <td colspan='2'></td><td colspan='2'> Sales Tax: " . $stax . "</td></tr>";
echo "<tr> <td colspan='2'></td>  <td colspan='2'> Order Total: " . $total . "</td></tr>";
echo "<tr rowspan='2'> <td colspan='2'></td><td colspan='2'> Shipping Address: " . $address . "</td></tr>";
echo "<tr>";
echo " <td colspan='2'></td>" ;
echo " <td colspan='2'> <input type='hidden' id='total' value=" . $total . "><input type='submit' value='Confirm Order'> &nbsp; <a href ='/php/browse.php' >Continue Shopping</td>";
echo "</tr>";
echo '</table>';
}
}
} else {
echo "<h1>Error</h1>";
echo "<p> Please <a href=\"/php/login.php\">click here to sign in</a>.</p>";
}
?>
</form>
</div> <!-- End MainContent -->
</div> <!-- End Wrap -->
</body>
</html>