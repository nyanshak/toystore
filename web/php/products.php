<?php

	// this is an example of how to connect to db and perform select
	header('Content-Type: application/json');

	define('INCL_BASE_CONST', true);
	include 'base.php';

	unset($params);

	$_POST = array_map('trim', $_POST);

	if (!empty($_POST['pid']) || $_POST['id'] === '0') {
		$params[] = "P.Id = '" . $mysqli->escape_string($_POST['pid']) . "'";
	}

	if (!empty($_POST['name']) || $_POST['name'] === '0') {
		$params[] = "Name LIKE '%" . $mysqli->escape_string($_POST['name']) . "%'";
	}

	if (!empty($_POST['description']) || $_POST['description'] === '0')  {
		$params[] = "P.Description like '%" . $mysqli->escape_string($_POST['description']) . "%'";
	}

	$lowerBound = $_POST['pricelower'];
	$upperBound = $_POST['priceupper'];

	$decimalRegex = "/^\d+(\.\d+)?$/";
	if (preg_match($decimalRegex, $lowerBound) && preg_match($decimalRegex, $upperBound)) {
		if ($lowerBound > $upperBound) { // user got bounds mixed
			$temp = $lowerBound;
			$lowerBound = $upperBound;
			$upperBound = $temp;
			unset($temp);
		}
		$params[] = "P.Price BETWEEN " . $lowerBound . " AND " . $upperBound;
	}

	$query = "SELECT P.Id as PId, P.Name as PName, Inventory, Price, Picture, Description FROM Product as P";
	if (!empty($params)) {
		$query .= ' WHERE ' . implode(' AND ', $params);
	}

	if (!empty($_POST['category'])) {
		$query .= " JOIN ProductToCategory as PTC ON P.Id = PTC.ProductId JOIN Category as C ON PTC.CategoryId = C.Id WHERE C.Name LIKE '%" . $mysqli->escape_string($_POST['category']) . "%'";
	}

	$values = $mysqli->query($query);

	$foundArr = array();

	if ($values->num_rows > 0) {
		$i = 0;
		while($row = $values->fetch_assoc()) {
			$id = $row["PId"];

			if(!array_key_exists($id, $foundArr)) {
				$products[$i]["Id"] = $id;
				$products[$i]["Name"] = $row["PName"];
				$products[$i]["Description"] = $row["Description"];
				$products[$i]["Price"] = $row["Price"];
				$products[$i]["Inventory"] = $row["Inventory"];
				$products[$i]["Picture"] = $row["Picture"];
				$val = $i;
				$foundArr[$id] = $val;
				$i++;
			} else {
				$val = $foundArr[$id];
			}
		}
	}

	$data["success"] = true;

	$data["products"] = (array)$products;
	echo json_encode($data);

	$mysqli->close();
?>  
