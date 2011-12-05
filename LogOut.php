<!DOCTYPE html>
<html>
<head><title> Logout Page </title></head>
<body>
<h1>Logout</h1>
<?php
session_start();

if($_POST['action'] == "logout") {
	$_SESSION = array();
	session_destroy();
	$_SESSION['ERROR'] = "<p>You have successfully logged out.</p>";
	echo $_SESSION['ERROR'];
	echo "<hr />\n";
	echo "<b><a href = 'index.html' action = login> Login again.</a></b>\n";
}

?>
</body>
</html>