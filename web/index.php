<?php include "php/base.php"; ?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Toy Store logon</title>
		<link rel="stylesheet" href="/css/styles.css" type="text/css" />

<?php
$_SESSION['Url'] = "/";
if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email'])) {
	 ?>
	</head>

	<body>
		<div id="main">
 
			<h1>Member Area</h1>
			<p>Thanks for logging in! Your email address is <code><?=$_SESSION['Email']?></code>.</p>
		
	 <?php
} else {
	
	?>
	<meta http-equiv='refresh' content="0;/php/login.php" />
	 
	</head>

	<body>
	<div id="main">

	<?php
}
?>
 
	</div>
</body>
</html>
