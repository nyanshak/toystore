<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
 
		<title>Update Products</title>
		<link rel="stylesheet" href="/css/styles.css" type="text/css" />
		<link rel="stylesheet" href="/css/navbar.css" type="text/css" />
		<link rel="stylesheet" href="//yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="/js/navbar.js"></script>
<?php
	$_POST = array_map('trim', $_POST);
	if (empty($_POST["name"])) {
?>
		<script src="/js/admin/products.js"></script>
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
	if (!empty($_POST["name"]) && !empty($_POST["description"]) && (!empty($_POST["price"]) && $_POST["price"] > 0) && (!empty($_POST["inventory"]) || $_POST["inventory"] === '0') && !empty($_POST["picture"])) {
		$name = $_POST["name"];
		$description = $_POST["description"];
		$price = $_POST["price"];
		$inventory = $_POST["inventory"];
		$picture = $_POST["picture"];
		if (!empty($_POST["productId"])) { // update product 
			$result = $mysqli->query("UPDATE Product SET Name='" . $name . "', Description='" . $description . "', Price='" . $price . "', Inventory='" . $inventory . "', Picture='" . $picture . "' WHERE Id='" . $mysqli->escape_string($_POST["productId"]) . "'");
			if ($result) {
?>
			<h1>Success</h1>
			<p>Product successfully updated</p>

<?php
			} else {
?>
			<h1>Error</h1>
			<p>Did not successfully update product</p>

<?php
			}
		} else { // create new product 
			$result = $mysqli->query("Insert Into Product (Name, Description, Price, Inventory, Picture) VALUES ('" . $name . "', '" . $description . "', '" . $price . "', '" . $inventory . "', '" . $picture . "')");
			if ($result) {
?>
			<h1>Success</h1>
			<p>Product successfully created</p>

<?php
			} else {
?>
			<h1>Error</h1>
			<p>Did not successfully create product</p>

<?php
			}
			
		}

		
		
	}
?>
		</div> <!-- End MainContent -->
		</div> <!-- End Wrap -->
	</body>
</html>
