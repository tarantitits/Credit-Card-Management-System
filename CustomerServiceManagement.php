<!DOCTYPE html>
<html>
<head><title> Customer Service Management Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Customer Service Management</h1></p>\n";

	echo "<form method='post' action='ServiceRequest.php'>\n";
	echo "<input type='submit' name='submit' value='Service Requests'>\n";
	echo "</form>\n";
	echo "<p></p>";

	echo "<form method='post' action='UpdateCustomerDetails.php'>\n";
	echo "<input type='submit' name='submit' value='Update Customer Details'>\n";
	echo "</form>\n";
	echo "<p></p>";

	echo "<form method='post' action='CardActivation.php'>\n";
	echo "<input type='submit' name='submit' value='Card Activation'>\n";
	echo "</form>\n";
	echo "<p></p>";

	echo "<form method='post' action='CardRenewalRequest.php'>\n";
	echo "<input type='submit' name='submit' value='Card Renewal'>\n";
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