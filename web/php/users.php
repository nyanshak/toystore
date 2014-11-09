
<?php

	// this is an example of how to connect to db and perform select
	header('Content-Type: application/json');
	include 'database_connect.php';

	$query = "SELECT * FROM Users;";
	$values = $conn->query($query);


	if ($values->num_rows > 0) {
		$i = 0;
		while($row = $values->fetch_assoc()) {
			$users[$i]["Id"] = $row["Id"];
			$users[$i]["Username"] = $row["Username"];
			$users[$i]["Email"] = $row["Email"];
			$users[$i]["Name"] = $row["Name"];
			$users[$i]["BillingAddress"] = $row["BillingAddress"];
			$users[$i]["ShippingAddress"] = $row["ShippingAddress"];
			$users[$i]["Password"] = $row["Password"];
			$i++;
		}
	}

	$data["users"] = (array)$users;
	$data["success"] = true;
	echo json_encode($data);

	$conn->close();
?>  

