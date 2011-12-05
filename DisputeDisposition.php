<HTML>
   <HEAD>
	<TITLE>Update Investigation Disposition</TITLE>
   </HEAD>
	<BODY>
<?php

session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Enter Investigation Disposition</h1></p>\n";

	echo "<FORM METHOD='POST' ACTION='UpdateInvestigate.php'>\n";
	echo "<!--<P><strong>Customer Service Number</strong><br><INPUT TYPE='text' name='customer_service_number' /></p>\n";
	echo "<P>--><strong>Investigation Number</strong><br><INPUT TYPE='text' name='up_investigation_no' /></p>\n";
	echo "<P><strong>Activity Number</strong><br><INPUT TYPE='text' name='up_activity_no' /></p>\n";
	echo "<P><strong>Investigation Date</strong><br><INPUT TYPE='text' name='up_investigation_date' /></p>\n";
	echo "<P><strong>Investigation Disposition</strong><br><INPUT TYPE='text' name='up_investigation_dispo' /></p>\n";
	echo "<p><input type='submit' name='submit' value='Submit' /></p>\n";
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
</BODY>
</HTML>