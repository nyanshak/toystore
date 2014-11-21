<?php

$page_redirected_from = $_SERVER['REQUEST_URI']; // this is especially useful with error 404 to indicate the missing page.
$server_url = "//" . $_SERVER["SERVER_NAME"] . "/";
$redirect_to = $server_url;

switch(getenv("REDIRECT_STATUS")) {

	case 200:
	# "200 - OK"
	# Note: this should only happen if they try to directly access the error page
	# Rewrite to 404 to prevent odd behavior
	$error_code = "404 - Not Found";
	$explanation = "many missing, such 404: The requested resource '" . $page_redirected_from . "' could not be found on this server. Please verify the address and try again.";
	break;

	# "400 - Bad Request"
	case 400:
	$error_code = "400 - Bad Request";
	$explanation = "The syntax of the URL submitted by your browser could not be understood. Please verify the address and try again.";
	break;

	# "401 - Unauthorized"
	case 401:
	$error_code = "401 - Unauthorized";
	$explanation = "This section requires a password or is otherwise protected. If you feel you have reached this page in error, please return to the login page and try again, or contact the webmaster if you continue to have problems.";
	break;

	# "403 - Forbidden"
	case 403:
	$error_code = "403 - Forbidden";
	$explanation = "this is not the page you were looking for";
	break;

	# "404 - Not Found"
	case 404:
	$error_code = "404 - Not Found";
	$explanation = "many missing, such 404: The requested resource '" . $page_redirected_from . "' could not be found on this server. Please verify the address and try again.";
	break;

	# "500 - Internal Server Error"
	case 500:
	$error_code = "500 - Internal Server Error";
	$explanation = "The server experienced an unexpected error. Please verify the address and try again.";
	break;
}
?>

<!doctype html>
<head>

	<link rel="Shortcut Icon" href="/favicon.ico" type="image/x-icon" />

	<meta http-equiv="Refresh" content="5; url='<?php print($redirect_to); ?>'">
	<link rel="stylesheet" href="/css/styles.css" type="text/css" />
	<title>Page not found <?php print ($page_redirected_from); ?></title>

</head>
<body>

<h1>Error Code <?php print ($error_code); ?></h1>

<p><?PHP echo($explanation); ?></p>

<p><strong>You will be automatically redirected to <a href="<?php print($redirect_to); ?>"><?php print($_SERVER["SERVER_NAME"]); ?></a> in five seconds.</p>

<hr />

<p><i>A project of <a href="<?php print($_SERVER["SERVER_NAME"]); ?>"><?php print($_SERVER["SERVER_NAME"]); ?></a>.</i></p>

</body>
</html>
