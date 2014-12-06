<?php
	header('Content-Type: application/json');
	define('INCL_BASE_CONST', true);
	include 'base.php';
	unset($params);
		unset($nameStr);
		unset($descStr);
	$_POST = array_map('trim', $_POST);
	if (!empty($_POST['pid']) || $_POST['id'] === '0') {
		$params[] = "P.Id = '" . $mysqli->escape_string($_POST['pid']) . "'";
	}
	if (!empty($_POST['name']) || $_POST['name'] === '0') {
			if (!empty($_POST['split'])) {
				$_POST['name'] = preg_replace('/\s+/', '%', $_POST['name']);
			}
			$nameStr = "P.Name LIKE '%" . $mysqli->escape_string($_POST['name']) . "%'";
			if (empty($_POST['keywords'])) {
				$params[] = $nameStr;
			}
	}
	if (!empty($_POST['description']) || $_POST['description'] === '0')  {
			if (!empty($_POST['split'])) {
				$_POST['description'] = preg_replace('/\s+/', '%', $_POST['description']);
			}
			$descStr = "P.Description LIKE '%" . $mysqli->escape_string($_POST['description']) . "%'";
			if (empty($_POST['keywords']) || empty($nameStr)) {
				$params[] = $descStr;
			}
			else {
				$params[] = "(" . $nameStr . " OR " . $descStr . ")";
			}
	}
	$lowerBound = $_POST['pricelower'];
	$upperBound = $_POST['priceupper'];
	$decimalRegex = "/^\d+(\.\d+)?$/";
	if (preg_match($decimalRegex, $lowerBound)) {
		$params[] = "P.Price >= " . $lowerBound;
	}
		if (preg_match($decimalRegex, $upperBound)) {
		$params[] = "P.Price <= " . $upperBound;
	}
	$select = "SELECT P.Id as PId, P.Name as PName, Inventory, Price, Picture, Description ";
	$from = "FROM Product as P ";
	if (!empty($_POST['category'])) {
		$select .= ", C.Name as CName ";
		$from .= "JOIN ProductToCategory as PTC ON P.Id = PTC.ProductId JOIN Category as C ON PTC.CategoryId = C.Id ";
		$params[] = "C.Name LIKE '%" . $mysqli->escape_string($_POST['category']) . "%'";
	}
	if (!empty($params)) {
		$where = "WHERE " . implode(' AND ', $params);
	}
	$query = $select . $from . $where;
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

				if (!empty($_POST['category'])) {
					$products[$i]["Category"] = $row["CName"];
				}
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
