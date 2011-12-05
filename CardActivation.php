<!DOCTYPE html>
<html>
<head><title> Card Activation Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Card Activation Request</h1></p>\n";

	echo "<form method='post' action='VerifyCardQA.php'>\n";
	echo "<big><b><p>Card Details: </p></b></big>\n";
	echo "<table><tr><td>* Card number</td><td align='right'><input type='text' name='vccdno' /></td></tr>\n";
	echo "		<tr><td>* SSN</td><td align='right'><input type='text' name='vccssn' /></td></tr></table>\n";
	echo "<input type = 'reset' name = 'reset' value = 'Reset' />\n";
	echo "<input type = 'submit' name = 'submit' value = 'Verify' />\n";
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