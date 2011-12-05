<!DOCTYPE html>
<html>
<head><title> Account Management Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Account Management</h1></p>\n";
	
	echo "<form method='post' action='NewAccountRequest.php'>\n";
	echo "<input type='submit' name='submit' value='New Accounts'>\n";
	echo "</form>\n";
	echo "<p></p>";

	echo "<form method='post' action='UpdateCustomerDetails.php'>\n";
	echo "<input type='submit' name='submit' value='Update Customer Details'>\n";
	echo "</form>\n";
	echo "<p></p>";

	echo "<form method='post' action='ChangeAccountDetails.php'>\n";
	echo "<input type='submit' name='submit' value='Change Account Details'>\n";
	echo "</form>\n";
	echo "<p></p>";

	echo "<form method='post' action='InputPayment.html'>\n";
	echo "<input type='submit' name='submit' value='Make Payment'>\n";
	echo "</form>\n";
	echo "<p></p>";

	echo "<form method='post' action='generateStatements.html'>\n";
	echo "<input type='submit' name='submit' value='Generate Statements'>\n";
	echo "</form>\n";
	echo "<p></p>";

	echo "<form method='post' action='trackActivity.html'>\n";
	echo "<input type='submit' name='submit' value='Track Activity'>\n";
	echo "</form>\n";
	echo "<p></p>";

	echo "<form method='post' action='DisputeDisposition.php'>\n";
	echo "<input type='submit' name='submit' value='Dispute Disposition'>\n";
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