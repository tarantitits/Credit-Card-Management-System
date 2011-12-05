<!DOCTYPE html>
<html>
<head><title> Updates Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Update Request</h1></p>\n";

	echo "<form method='post' action='VerifySecurityQA.php'>\n";
	echo "<big><b><p>Customer Details: </p></b></big>\n";
	echo "<table><tr><td>SSN</td><td align='right'><input type='text' name='vqcssn' /></td></tr>\n";
	echo "	<tr><td>First Name</td><td align='right'><input type='text' name='vqfname' /></td></tr>\n";
	echo "	<tr><td>Last Name</td><td align='right'><input type='text' name='vqlname' /></td></tr></table>\n";
	echo "<input type = 'reset' name = 'reset' value = 'Reset' />\n";
	echo "<input type = 'submit' name = 'submit' value = 'Verify' />\n";
	echo "</form>\n";

	if ($_SESSION['stafftype'] != 'REPRESENTATIVE') {	
		echo "<p></p>";
		echo "<form method='post' action='AccountManagement.php'>\n";
		echo "<input type='submit' name='submit' value='Back to Account Management'>\n";
		echo "</form>\n";
	}
	else {
		echo "<p></p>";
		echo "<form method='post' action='CustomerServiceManagement.php'>\n";
		echo "<input type='submit' name='submit' value='Back to Customer Service Management'>\n";		
		echo "</form>\n";
	}
	
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