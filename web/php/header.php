<?php
	// prevent direct access to this page
	if (!defined('INCL_HEADER_CONST')) {
		header('Location: /php/error.php');
		exit;
	}

	define('INCL_BASE_CONST', TRUE);
	include "base.php";
	
?>
		<nav class="clearfix">
		<ul class="clearfix">
			<li><a href="/">Home</a></li>
<?php

if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email'])) {
	 ?>
			<li><a href="/php/account.php">Your Account</a></li>
			<li><a href="/php/logout.php">Sign Out</a></li>
 
	 <?php
} else {
	
	?>
			<!-- Guest user links -->
			<li><a href="/php/login.php">Sign in</a></li>
			<li><a href="/php/register.php">Register</a></li>
	<?php
}
?>
		</ul>
		<a href="#" id="pull">Menu</a>
		</nav>

