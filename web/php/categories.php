<?php
	header('Content-Type: application/json');
	define('INCL_BASE_CONST', true);
	include 'base.php';
	unset($params);
	$_POST = array_map('trim', $_POST);
	if (!empty($_POST['name']) || $_POST['name'] === '0') {
		$params[] = "Name LIKE '%" . $mysqli->escape_string($_POST['name']) . "%'";
	}
        $select = "SELECT C.Id as CId, C.Name as CName ";
        $from = "FROM Category as C ";
        unset($where);
	if (!empty($params)) {
                if (empty($where)) {
                    $where = "WHERE ";
                }
		$where .= implode(' AND ', $params);
	}
        $query = $select . $from . $where;
	$values = $mysqli->query($query);
	$foundArr = array();
	if ($values->num_rows > 0) {
		$i = 0;
		while($row = $values->fetch_assoc()) {
			$id = $row["CId"];
			if(!array_key_exists($id, $foundArr)) {
				$categories[$i]["Id"] = $id;
				$categories[$i]["Name"] = $row["CName"];
				$val = $i;
				$foundArr[$id] = $val;
				$i++;
			} else {
				$val = $foundArr[$id];
			}
		}
	}
	echo json_encode($categories);
	$mysqli->close();
?>  