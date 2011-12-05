<!DOCTYPE html>
<html>
<head><title> Account Change Verification Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Account Change Verification</h1></p>\n";

	require "config.php";

	$vacssn=$_POST["vacssn"];
	$vafname=$_POST["vafname"];
	$valname=$_POST["valname"];
	$conn = oci_connect($dbUser, $dbPass, $dbHost);
	$stmt = oci_parse($conn, "SELECT ACCOUNT_NUMBER, MAX_CREDIT_LIMIT, INTEREST_RATE, SQUESTION, SANSWER, USERNAME, PASSWORD, FNAME, MNAME, LNAME, STREET, APT_NO, CITY, ZIP, PHONE FROM CUSTOMER_ACCOUNT, CUSTOMER_NAME_SSN, CUSTOMER_ADDRESS, CUSTOMER_PHONE WHERE CUSTOMER_ACCOUNT.CUSTOMER_SSN = :vacssn AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_NAME_SSN.SSN AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_ADDRESS.CUSTOMER_SSN AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_PHONE.CUSTOMER_SSN");
	oci_bind_by_name($stmt, ":vacssn", $vacssn);
	oci_execute($stmt);
	if ($row=oci_fetch_array($stmt, OCI_BOTH)) {
		$vaacctno=$row['ACCOUNT_NUMBER'];
		echo "<b><p>Existing customer.</p></b>\n";
		echo "<table><tr><td>Account: </td><td align='left'>" . $row['ACCOUNT_NUMBER'] . "</td></tr>\n";
		echo "		<tr><td>Name given: </td><td align='left'>" . $vafname . " " . $valname . " " . "</td></tr>\n";
		if($row['MNAME'] != '_') {
			echo "	<tr><td>Name in our records: </td><td align='left'>" . $row['FNAME'] . " " . $row['MNAME'] . " " . $row['LNAME'] . "</td></tr>\n";
		}
		else {
			echo "	<tr><td>Name in our records: </td><td align='left'>" . $row['FNAME'] . " " . $row['LNAME'] . "</td></tr>\n";
		}
		echo "	<tr><td>Maximum credit limit: </td><td align='left'>" . $row['MAX_CREDIT_LIMIT'] . "</td></tr>\n";
		echo "	<tr><td>Interest rate: </td><td align='left'>" . $row['INTEREST_RATE'] . "</td></tr>\n";
		if($row['APT_NO'] !=0) {
			echo "	<tr><td>Address: </td><td align='left'>" . $row['STREET'] . " " . $row['APT_NO'] . " " .  $row['CITY'] . " " .  $row['ZIP'] . "</td></tr>\n";
		}
		else {
			echo "	<tr><td>Address: </td><td align='left'>" . $row['STREET'] . " " . $row['CITY'] . " " .  $row['ZIP'] . "</td></tr>\n";
		}
		echo "		<tr><td>Phone: </td><td align='left'>" . $row['PHONE'] . "</td></tr>\n";
		echo "		<tr><td>Security Question: </td><td align='left'>" . $row['SQUESTION'] . "</td></tr>\n";
		echo "		<tr><td>Answer: </td><td align='left'>" . $row['SANSWER'] . "</td></tr></table>\n";
		echo "<p></p>";
		echo "<em><b><p>Warning: Make sure that the name given is the same as one in our records and the answer to security question is correct.</p></b></em>\n";
		echo "<em><b><p>		  Otherwise, if identity cannot be verified, click Cancel Changes!</p></b></em>\n";
		echo "<p></p>";

		echo "<form method='post' action='MakeChanges.php'>\n";
		echo "<big><b><p>Details to be changed (otherwise, leave it blank): </p></b></big>\n";
		echo "<table><tr><td>Credit Limit</td><td align='right'><input type='text' name='mcmxclimit' /></td></tr>\n";
		echo "	<tr><td>Interest Rate</td><td align='right'><input type='text' name='mcapr' /></td></tr></table>\n";
		echo "<input type='hidden' name='mcacctno' value='$vaacctno'>\n";
		echo "<input type = 'reset' name = 'reset' value = 'Reset' />\n";
		echo "<input type = 'submit' name = 'submit' value = 'Change' />\n";
		echo "</form>\n";

	}
	else {
		echo "<big><b><p>Non-existing customer! Request denied.</p></b></big>\n";
	}

	oci_free_statement($stmt);
	oci_close($conn);

	echo "<p></p>";
	echo "<form method='post' action='AccountManagement.php'>\n";
	echo "<input type='submit' name='submit' value='Cancel Changes'>\n";
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