<?php
	
	if (!defined('INCL_BASE_CONST')) {
		define('INCL_BASE_CONST', TRUE);
		include "base.php";
	}

	$_SESSION = array();
	session_destroy();
?>
<meta http-equiv="refresh" content="0;/index.php">

