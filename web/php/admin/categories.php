<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
 
		<title>Update Categories</title>
		<link rel="stylesheet" href="/css/styles.css" type="text/css" />
		<link rel="stylesheet" href="/css/navbar.css" type="text/css" />
		<link rel="stylesheet" href="//yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="/js/navbar.js"></script>
<?php
	$_POST = array_map('trim', $_POST);
	if (empty($_POST["name"])) {
?>
		<script src="/js/admin/categories.js"></script>
<?php
	}
?>
	</head>
	<body>
		<div id="Wrap">
			<?php
				define('INCL_HEADER_CONST', TRUE);
				ob_start();
				include('header.php');
				$result = ob_get_clean();
				echo $result;
			?>
			<div id="LeftSidebar">
				&nbsp;
			</div> <!-- end "LeftSidebar" -->
			<div id="MainContent">
<?php
	if (!empty($_POST["name"])) {
		if (!empty($_POST["categoryId"])) { // update category
			$result = $mysqli->query("UPDATE Category SET Name='" . $mysqli->escape_string($_POST["name"]) . "' WHERE Id='" . $mysqli->escape_string($_POST["categoryId"]) . "'");
			if ($result) {
?>
			<h1>Success</h1>
			<p>Category successfully updated</p>

<?php
			} else {
?>
			<h1>Error</h1>
			<p>Did not successfully update category</p>

<?php
			}
		} else { // create new category
			$result = $mysqli->query("INSERT INTO Category (Name) VALUES ('" . $mysqli->escape_string($_POST["name"]) . "')");
			if ($result) {
?>
			<h1>Success</h1>
			<p>Category successfully created</p>

<?php
			} else {
?>
			<h1>Error</h1>
			<p>Did not successfully create category</p>

<?php
			}
			
		}

		
		
	}
?>
		</div> <!-- End MainContent -->
		</div> <!-- End Wrap -->
	</body>
</html>
