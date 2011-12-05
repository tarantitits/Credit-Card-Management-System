<HTML>
   <HEAD>
	<TITLE>Customer Service Request Page</TITLE>
   </HEAD>
	<BODY>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Enter Customer Information</h1></p>\n";

	echo "<FORM METHOD='POST' ACTION='Customerservicerequest.php'>\n";
	echo "<P><strong>Customer SSN</strong><br><INPUT TYPE='text' name='customer_ssn' /></p>\n";
	echo "<P><strong>First Name</strong><br><INPUT TYPE='text' name='customer_fname' /></p>\n";
	echo "<P><strong>Last Name</strong><br><INPUT TYPE='text' name='customer_lname' /></p>\n";
	echo "<P><strong>Service Type</strong><br><INPUT TYPE='text' name='service_type' /></p>\n";
	echo "<P><strong>Resolution</strong><br><INPUT TYPE='text' name='resolution' /></p>\n";
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