<?php

	// prevent direct access to this page
	if(!defined('INCL_BASE_CONST')) {
		header('Location: /php/error.php');
		exit;
	}

	// include this file to load db connection

	$config = parse_ini_file("config.ini", true);

	if (!array_key_exists("database_credentials", $config)) {
		$response->success = false;
		$response->error = "Database credentials not set; please configure 'config.ini'";
        die(json_encode($response));
	}

	$db_creds = $config["database_credentials"];

	$servername = $db_creds["servername"];
	$username = $db_creds["username"];
	$password = $db_creds["password"];
	$dbname = $db_creds["dbname"];

	// Create connection
	$mysqli = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($mysqli->connect_error) {
		$response->success = false;
		$response->error = "Something went wrong trying to connect to the database";
        die(json_encode($response));
	}
	session_start();

?>
