<!DOCTYPE html>
<html>
<head><title> Account Profile Page </title></head>
<body>

<?php
session_start();
if($_SESSION['cverified']) {
	echo "<p>User: " . $_SESSION["customerfname"] . " " . $_SESSION["customerlname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";
	echo "<form method='post' action='LogOut.php'>\n";
	echo "<input type = 'hidden' name = 'action' value = 'logout' />\n";
	echo "<input type='submit' name='submit' value='Logout'>\n";
	echo "</form>\n";
	echo "<p></p>";
	echo "<hr />";
	
	echo "<p><h1>Account Profile</h1></p>\n";
	
	require "config.php";
	
	$apacctno=$_SESSION['customeracctno'];

	$conn = oci_connect($dbUser, $dbPass, $dbHost);
	
	$stmt = oci_parse($conn, "SELECT ACCOUNT_NUMBER, SQUESTION, SANSWER, USERNAME, PASSWORD, FNAME, MNAME, LNAME, STREET, APT_NO, CITY, ZIP, PHONE FROM CUSTOMER_ACCOUNT, CUSTOMER_NAME_SSN, CUSTOMER_ADDRESS, CUSTOMER_PHONE WHERE CUSTOMER_ACCOUNT.ACCOUNT_NUMBER = $apacctno AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_NAME_SSN.SSN AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_ADDRESS.CUSTOMER_SSN AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_PHONE.CUSTOMER_SSN");
	oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
	
	if ($row=oci_fetch_array($stmt, OCI_BOTH)) {
		echo "<table><tr><td>Account: </td><td align='left'>" . $row['ACCOUNT_NUMBER'] . "</td></tr>\n";
		if($row['MNAME'] != '_') {
			echo "	<tr><td>Name in our records: </td><td align='left'>" . $row['FNAME'] . " " . $row['MNAME'] . " " . $row['LNAME'] . "</td></tr>\n";
		}
		else {
			echo "	<tr><td>Name in our records: </td><td align='left'>" . $row['FNAME'] . " " . $row['LNAME'] . "</td></tr>\n";
		}
		if($row['APT_NO'] != 0) {
			echo "	<tr><td>Address: </td><td align='left'>" . $row['STREET'] . " " . $row['APT_NO'] . " " .  $row['CITY'] . " " .  $row['ZIP'] . "</td></tr>\n";
		}
		else {
			echo "	<tr><td>Address: </td><td align='left'>" . $row['STREET'] . " " .  $row['CITY'] . " " .  $row['ZIP'] . "</td></tr>\n";
		}
		echo "		<tr><td>Phone: </td><td align='left'>" . $row['PHONE'] . "</td></tr>\n";
		echo "		<tr><td>Security Question: </td><td align='left'>" . $row['SQUESTION'] . "</td></tr>\n";
		echo "		<tr><td>Answer: </td><td align='left'>" . $row['SANSWER'] . "</td></tr></table>\n";
		echo "<p></p>";
	}
	else {
		echo "Query failed.<br />\n";
	}
			
	oci_free_statement($stmt);
	oci_close($conn);

	
	echo "<p></p>";
	echo "<form method='post' action='AccountSummary.php'>\n";
	echo "<input type='submit' name='submit' value='Account Summary'>\n";
	echo "</form>\n";
	echo "<p></p>";
}
else {
	echo $_SESSION['ERROR'];
	echo "<hr />\n";
	echo "<b><a href = 'index.html' action = login> Login again.</a></b>\n";
}
?>
</body>
</html>