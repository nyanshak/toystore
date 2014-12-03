<?php
	$_SESSION['Url'] = "/";
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Toy Store</title>
		<link rel="stylesheet" href="/css/styles.css" type="text/css" />
		<link rel="stylesheet" href="/css/navbar.css" type="text/css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="/js/navbar.js"></script>
		<script src="/js/leftsidebar.js"></script>
	</head>

	<body>

		<div id="Wrap">
<?php
	define('INCL_HEADER_CONST', TRUE);
	ob_start();
	include('php/header.php');
	$result = ob_get_clean();
	echo $result;
?>

		<div id="LeftSidebar">

		</div> <!-- end "LeftSidebar" -->

		<div id="MainContent">

		</div> <!-- end "MainContent" -->

		<div id="RightSidebar">

		</div> <!-- end "RightSidebar" -->

		</div> <!-- end "Wrap" -->
 
	</div>
</body>
</html>
