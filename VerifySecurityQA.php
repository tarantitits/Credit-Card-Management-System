<!DOCTYPE html>
<html>
<head><title> Security Verification Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Security Verification</h1></p>\n";

	require "config.php";
	$vqcssn=$_POST["vqcssn"];
	$vqfname=$_POST["vqfname"];
	$vqlname=$_POST["vqlname"];
	$conn = oci_connect($dbUser, $dbPass, $dbHost);
	$stmt = oci_parse($conn, "SELECT ACCOUNT_NUMBER, SQUESTION, SANSWER, USERNAME, PASSWORD, FNAME, MNAME, LNAME, STREET, APT_NO, CITY, ZIP, PHONE FROM CUSTOMER_ACCOUNT, CUSTOMER_NAME_SSN, CUSTOMER_ADDRESS, CUSTOMER_PHONE WHERE CUSTOMER_ACCOUNT.CUSTOMER_SSN = :vqcssn AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_NAME_SSN.SSN AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_ADDRESS.CUSTOMER_SSN AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_PHONE.CUSTOMER_SSN");
	oci_bind_by_name($stmt, ":vqcssn", $vqcssn);
	oci_execute($stmt);
	if ($row=oci_fetch_array($stmt, OCI_BOTH)) {
		echo "<b><p>Existing customer.</p></b>\n";
		echo "<table><tr><td>Account: </td><td align='left'>" . $row['ACCOUNT_NUMBER'] . "</td></tr>\n";
		echo "		<tr><td>Name given: </td><td align='left'>" . $vqfname . " " . $vqlname . " " . "</td></tr>\n";
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
		echo "<em><b><p>Warning: Make sure that the name given is the same as one in our records and the answer to security question is correct.</p></b></em>\n";
		echo "<em><b><p>		  Otherwise, if identity cannot be verified, click Cancel Update!</p></b></em>\n";
		echo "<p></p>";
		
		echo "<form method='post' action='MakeUpdate.php'>\n";
		echo "<big><b><p>Details to be updated (otherwise, leave it blank): </p></b></big>\n";
		echo "<b><p>Address: </p></b>\n";
		echo "<table><tr><td>Street</td><td align='right'><input type='text' name='mustreet' /></td></tr>\n";
		echo "	<tr><td>Apt. No.</td><td align='right'>	<input type='text' name='muaptno' /></td></tr>\n";
		echo "	<tr><td>City</td><td align='right'><input type='text' name='mucity' /></td></tr>\n";
		echo "	<tr><td>Zip</td><td align='right'><input type='text' name='muzip' /></td></tr></table>\n";
		echo "<b><p>Phone: </p></b>\n";
		echo "<table><tr><td>Phone1</td><td align='right'><input type='text' name='muphone' /></td></tr></table>\n";
		echo "<b><p>Security and login: </p></b>\n";
		echo "<table><tr><td>Username</td><td align='right'><input type='text' name='mucuname' /></td></tr>\n";
		echo "	<tr><td>Password</td><td align='right'>	<input type='text' name='mucpword' /></td></tr>\n";
		echo "	<tr><td>Security Question</td><td align='right'><input type='text' name='musquestion' /></td></tr>\n";
		echo "	<tr><td>Answer</td><td align='right'><input type='text' name='musanswer' /></td></tr></table>\n";
		echo "<input type='hidden' name='mucssn' value='$vqcssn'>\n";
		echo "<input type = 'reset' name = 'reset' value = 'Reset' />\n";
		echo "<input type = 'submit' name = 'submit' value = 'Update' />\n";
		echo "</form>\n";

	}
	else {
		echo "<big><b><p>Non-existing customer! Request denied.</p></b></big>\n";
	}

	oci_free_statement($stmt);
	oci_close($conn);

	echo "<p></p>";
	
	if ($_SESSION['stafftype'] != 'REPRESENTATIVE') {
		echo "<form method='post' action='AccountManagement.php'>\n";
		echo "<input type='submit' name='submit' value='Cancel Update'>\n";
		echo "</form>\n";
	}
	else {
		echo "<form method='post' action='CustomerServiceManagement.php'>\n";
		echo "<input type='submit' name='submit' value='Cancel Update'>\n";		
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