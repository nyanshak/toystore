<?php
	// This script connects to DB and adds a pending order (cart) for a particular user
	header('Content-Type: application/json');
	define('INCL_BASE_CONST', true);
	include 'base.php';
	unset($params);
	$_POST = array_map('trim', $_POST);
		// Verify user is not logged in and if not, then return error
		if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email'])) {
			// Get the price of the product
			$query = "SELECT Price FROM Product WHERE Id=" . $mysqli->escape_string($_POST['pid']);
			$values = $mysqli->query($query);
			if ($values->num_rows === 0) {
				// Generate error
			}
			$row = $values->fetch_assoc();
			$product_price = $row["Price"];
			
			// Get the user's Id
			$query = "SELECT Id FROM User WHERE Email='" . $_SESSION['Email'] . "'";
			$values = $mysqli->query($query);
			if ($values->num_rows === 0) {
				// Generate error
			}
			$row = $values->fetch_assoc();
			$user_id = $row["Id"];
			
			// Check if user has a pending order and get Id and current total
			$query = "SELECT Id, Total FROM `Order` WHERE UserId='" . $user_id . "' AND Status='Pending'";
			$values = $mysqli->query($query);
			unset($currentTotal);
                        unset($orderItemId);
                        unset($orderItemQty);
			if ($values->num_rows > 0) {
				// Get the Id of the pending order for this user
				$row = $values->fetch_assoc();
				$order_id = $row["Id"];
				$currentTotal = $row["Total"];
                                
                                // Check if they already have this item in the cart
                                $query = "SELECT Id, Quantity FROM OrderItem WHERE OrderId='" . $order_id . "' AND ProductId=" . $mysqli->escape_string($_POST['pid']);
                                unset($values);
                                $values = $mysqli->query($query);
                                if ($values->num_rows > 0) {
                                    $row = $values->fetch_assoc();
                                    $orderItemId = $row["Id"];
                                    $orderItemQty = $row["Quantity"];
                                }
			} else {
				// No pending order/cart exists so will create one and get the Id
				$query = "INSERT INTO `Order` (OrderDate, Total, Status, UserId) VALUES (CURDATE(), '" . ((int)$mysqli->escape_string($_POST['qty']) * (float)$product_price) . "', 'Pending', '" . $user_id . "')";
				$mysqli->query($query);
				
				// Now get the Id of the newly created order
				$query =  "SELECT LAST_INSERT_ID() as Id";
				unset($values);
				unset($row);
				$values = $mysqli->query($query);
				$row = $values->fetch_assoc();
				$order_id = $row["Id"];
			}
			
			// Now create orderitem tied to this order with the passed productID, desired qty, and price if the item does not exist
                        // If the item exists, then update the quantity and price
                        if (empty($orderItemId)) {
                            $query = "INSERT INTO OrderItem (OrderId, ProductId, Quantity, Price) VALUES ('" . (int)$order_id . "', '" . $mysqli->escape_string($_POST['pid']) . "', '" . (int)$mysqli->escape_string($_POST['qty']) . "', '" . $product_price . "')";
                        }
                        else {
                            $query = "UPDATE OrderItem SET Quantity='" . ((int)$orderItemQty + (int)$mysqli->escape_string($_POST['qty']) . "', Price='" . $product_price . "' WHERE Id=" . $orderItemId);
                        }
                        $mysqli->query($query);
			
			// If it is not a new order, then update order total
			if (!empty($currentTotal)) {
                            // Query to get sume of all items in order and update total
                            $query = "SELECT SUM(Total) as sum FROM (SELECT Quantity * Price as Total FROM OrderItem WHERE OrderId=" . $order_id . ") as Temp";
                            $values = $mysqli->query($query);
                            $row = $values->fetch_assoc();
                            $newTotal = $row["sum"];
                            $query = "UPDATE `Order` SET Total=" . $newTotal . " WHERE Id=" . $order_id;
                            $mysqli->query($query);
			}
			
			$data["reply"] = "success";
		} else {
			$data["reply"] = "not_logged_in";
		}
		
	echo json_encode($data);
	$mysqli->close();
?>  
