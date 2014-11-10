<?php
	// include this file to load db connection

	$config = parse_ini_file("config.ini", true);

	if (!array_key_exists("database_credentials", $config)) {
		die("database credentials not set; please configure 'config.ini'");
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
