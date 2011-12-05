<HTML>
   <HEAD>
	<TITLE>Credit Card Renewal Request Page</TITLE>
   </HEAD>
	<BODY>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Enter Credit Card Information</h1></p>\n";

	echo "<FORM METHOD='POST' ACTION='VerifyCardRenewal.php'>\n";
	echo "<P><strong>Credit Card Number</strong><br><INPUT TYPE='text' name='cdnorenew' /></p>\n";
	echo "<p><input type='submit' name='submit' value='Submit' /></p>\n";
	echo "</form>\n";
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
</BODY>
</HTML>