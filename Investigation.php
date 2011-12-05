<HTML>
   <HEAD>
	<TITLE>Investigation Request Page</TITLE>
   </HEAD>
	<BODY>
<?php

session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Investigation Request</h1></p>\n";

	// Retrieve ssn and csn
	$inewcsn = $_POST['inewcsn'];
	$icustomer_ssn = $_POST['icustomer_ssn'];

	// Take transaction amount, date, merchant, and description of complaint from customer
	echo "<form method='post' action='Investigate.php'>\n";
	echo "<input type='hidden' name='iicustomer_ssn' value='$icustomer_ssn'><br />";
	echo "<input type='hidden' name='iinewcsn' value='$inewcsn'><br />";
	echo "Date of transaction: <input type='text' name='dtdsdate' ><br />";
	echo "Amount of transaction: <input type='text' name='dtdsamt' ><br />";
	echo "Merchant: <input type='text' name='dtdsmerc' ><br />";
	echo "Description of complaint: <input type='text' name='dtdsdesc' ><br />";
	echo "<p></p>";
	echo "<input type = 'submit' name = 'submit' value = 'Display transaction' /><br />";
	echo "</form>\n";
	//echo "<p></p>";
	echo "<form method='post' action='CancelCustomerService.php'>\n";
	echo "<input type='hidden' name='ccsnewcsn' value='$inewcsn'><br />";
	echo "<input type='submit' name='submit' value='Cancel Request'>\n";		
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
</body>
</html>
