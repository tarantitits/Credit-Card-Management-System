<!DOCTYPE html>
<html>
<head><title> New Accounts Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>New Account Request</h1></p>\n";

	echo "<form method='post' action='VerifyInitCData.php'>\n";
	echo "<big><b><p>Applicant Details: </p></b></big>\n";
	echo "<table><tr><td>* SSN</td><td align='right'><input type='text' name='ecssn' /></td></tr>\n";
	echo "	<tr><td>* First Name</td><td align='right'><input type='text' name='efname' /></td></tr>\n";
	echo "	<tr><td>  Middle Name</td><td align='right'><input type='text' name='emname' /></td></tr>\n";
	echo "	<tr><td>* Last Name</td><td align='right'><input type='text' name='elname' /></td></tr></table>\n";
	echo "<big><b><p>Applicant Address: </p></b></big>\n";
	echo "<table><tr><td>* Street</td><td align='right'><input type='text' name='estreet' /></td></tr>\n";
	echo "	<tr><td>  Apt. No.</td><td align='right'>	<input type='text' name='eaptno' /></td></tr>\n";
	echo "	<tr><td>* City</td><td align='right'><input type='text' name='ecity' /></td></tr>\n";
	echo "	<tr><td>* Zip</td><td align='right'><input type='text' name='ezip' /></td></tr></table>\n";
	echo "<big><b><p>Applicant Phone: </p></b></big>\n";
	echo "<table><tr><td>* Day Phone</td><td align='right'><input type='text' name='ephone1' /></td></tr>\n";
	echo "	<tr><td> Evening Phone</td><td align='right'><input type='text' name='ephone2' /></td></tr></table>\n";
	echo "<input type = 'reset' name = 'reset' value = 'Reset' />\n";
	echo "<input type = 'submit' name = 'submit' value = 'Verify' />\n";
	echo "</form>\n";

	echo "<p></p>";
	echo "<form method='post' action='AccountManagement.php'>\n";
	echo "<input type='submit' name='submit' value='Back to Account Management'>\n";
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