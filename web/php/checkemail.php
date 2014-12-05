<?php

	if (!defined('INCL_BASE_CONST')) {
		define('INCL_BASE_CONST', TRUE);
		include "base.php";
	}

	header('Content-Type: application/json');
	
	$_POST = array_map('trim', $_POST);
	if(!empty($_POST["Email"]) || $_POST["Email"] === '0') {
		$query = "SELECT * FROM User WHERE Email = '" . $mysqli->escape_string($_POST["Email"]) . "'";
		$values = $mysqli->query($query);

		if ($values) { // query ran successfully
			$data["success"] = true;
			if ($values->num_rows > 0) {
				$data["message"] = "That email address is unavailable";
			} else {
				$data["message"] = "available";
			}
		} else {
			$data["success"] = false;
			$data["message"] = "Error connecting to DB; contact site admin";
		}

	} else {
		$data["success"] = true;
		$data["message"] = "You cannot use an empty email";
	}


	echo json_encode($data);
?>
