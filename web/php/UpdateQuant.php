<?php
$_SESSION["Url"] = $_SERVER["REQUEST_URI"];

define('INCL_BASE_CONST', true);
include ('base.php');

header('Content-Type: application/json');

unset($params);
$_POST = array_map('trim', $_POST);

if (!empty($_SESSION['Email'])) {
	$email = $_SESSION['Email'];
	$userResults = $mysqli->query("SELECT `Id` FROM `User` WHERE `Email` = '" . $email . "'");
	$userArray = mysqli_fetch_array($userResults);
	$userid = $userArray['Id'];
	$qty = $_POST['qty'];
	$orderId = $_POST['orderId'];
	$productId = $_POST['productId'];
	$row = $mysqli->query("SELECT `Price`,`Inventory` FROM `Product` WHERE `Id` = '" . $productId . "'");

	if ($row->num_rows > 0) {
		$rowdetail = mysqli_fetch_array($row);
		$inventory = $rowdetail['Inventory'];
		$price = $rowdetail['Price'];
	} else {
		$data["success"] = false;
		$data["reply"] = "Update Failed. Something went wrong";
		die(json_encode($data));
	}

	if ($qty > $inventory) {
		$data["reply"] = "We only have " . $inventory . " items. Please enter a smaller value.";
	} else {
		$myQuery = "Update `OrderItem` set `Quantity` =" . $qty . " WHERE `OrderId`='" . $orderId . "' AND `ProductId` = '" . $productId . "'";
		$updateQuery = $mysqli->query($myQuery);
		if ($updateQuery) {
			$data["success"] = true;
			$data["reply"] = "Quantity Updated";
		} else {
			$data["success"] = false;
			$data["reply"] = "Update Failed. Something went wrong";
		}
	}
} else {
	$data["success"] = false;
	$data["reply"] = "You must be logged in to change orders";
}

echo json_encode($data);
?>
