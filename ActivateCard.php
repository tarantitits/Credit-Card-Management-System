<!DOCTYPE html>
<html>
<head><title> Activate Card Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Activate Card</h1></p>\n";

	require "config.php";
	$accdno=$_POST["accdno"];
	$conn = oci_connect($dbUser, $dbPass, $dbHost);
	$stmt = oci_parse($conn, "UPDATE CREDIT_CARD SET STATUS = 'ACTIVE' WHERE CD_NUMBER = :accdno");
	oci_bind_by_name($stmt, ":accdno", $accdno);
	oci_execute($stmt);
	echo "<big><b><p>Card activated.</p></b></big>\n";

	oci_free_statement($stmt);
	oci_close($conn);
	
	echo "<p></p>";
	echo "<form method='post' action='CustomerServiceManagement.php'>\n";
	echo "<input type='submit' name='submit' value='Back to Customer Service Management'>\n";
	echo "</form>\n";

	echo "<p></p>";
	echo "<hr />";
	echo "<form method='post' action='LogOut.php'>\n";
	echo "<input type = 'hidden' name = 'action' value = 'logout' />\n";
	echo "<input type='submit' name='submit' value='Logout'>\n";
	echo "</form>\n";
}
else {
	echo $_SESSION['ERROR'];
	echo "<hr />\n";
	echo "<b><a href = 'index.html' action = login> Login again.</a></b>\n";
}
?>
</body>
</html>