
<?php

	// this is an example of how to connect to db and perform select
	header('Content-Type: application/json');
	include 'base.php';

	unset($params);
	if (!empty($_POST['name'])) {
		$params[] = " Name = '" . $mysqli->escape_string($_POST['name']) . "'";
	}
	if (!empty($_POST['description'])) {
		$params[] = " Description like '%" . $mysqli->escape_string($_POST['name']) . "%'";
	}

	// Note: this does not check that values are actually numeric or in proper order
	if (!empty($_POST['pricelower']) && !empty($_POST['priceupper'])) {
		$lowerBound = "'" . $mysqli->escape_string($_POST['pricelower']) . "'";
		$upperBound = "'" . $mysqli->escape_string($_POST['priceupper']) . "'";
		$params[] = " Price BETWEEN " . $lowerBound . " AND " . $priceUpper;
	}

	if (!empty($_POST['category'])) {
		// TODO: logic to deal with categories
	}

	$query = "SELECT * FROM Product";
	if (!empty($params)) {
		$query .= ' WHERE ' . implode(' AND ', $params);
	}

	$values = $mysqli->query($query);


	if ($values->num_rows > 0) {
		$i = 0;
		while($row = $values->fetch_assoc()) {
			$products[$i]["Id"] = $row["Id"];
			$products[$i]["Name"] = $row["Name"];
			$products[$i]["Price"] = $row["Price"];
			$products[$i]["Picture"] = $row["Picture"];
			$products[$i]["Description"] = $row["Description"];
			$i++;
		}
	}

	$data["products"] = (array)$products;
	$data["success"] = true;
	echo json_encode($data);

	$mysqli->close();
?>  

