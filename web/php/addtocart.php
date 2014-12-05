<?php
	// This script connects to DB and adds a pending order (cart) for a particular user
	header('Content-Type: application/json');
	define('INCL_BASE_CONST', true);
	include 'base.php';
	unset($params);
	$_POST = array_map('trim', $_POST);
        // Verify user is not logged in and if not, then return error
        if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email'])) {
            
            // Get the user's Id
            $query = "SELECT Id FROM User WHERE Email='" . $_SESSION['Email'] . "'";
            $values = $mysqli->query($query);
            if ($values->num_rows === 0) {
                // Generate error
            }
            $row = $values->fetch_assoc();
            $user_id = $row["Id"];
            
            // Check if user has a pending order
            $query = "SELECT Id FROM `Order` WHERE UserId='" . $user_id . "' AND Status='pending'";
            $values = $mysqli->query($query);
            if ($values->num_rows > 0) {
                // Get the Id of the pending order for this user
                $row = $values->fetch_assoc();
                $order_id = $row["Id"];
            }
            else {
                // No pending order/cart exists so will create one and get the Id
                $query = "INSERT INTO `Order` (OrderDate, Total, Status, UserId) VALUES (CURDATE(), '" . (int)($_POST['qty'] * (float)$_POST['price']) . "', 'pending', '" . $user_id . "')";
                $mysqli->query($query);
                
                // Now get the Id of the newly created order
                $order_id = mysql_insert_id();
            }
            
            // Now create orderitem tied to this order with the passed productID, desired qty, and price
            $query = "INSERT INTO OrderItem (OrderId, ProductId, Quantity, Price) VALUES ('" . $order_id . "', '" . $_POST['pid'] . "', '" . $_POST['qty'] . "', '" . $_POST['price'] . "')";
            $mysqli->query($query);
            
            $data["reply"] = "success";
        }
        else {
            $data["reply"] = "not_logged_in";
        }
        
	echo json_encode($data);
	$mysqli->close();
?>  
