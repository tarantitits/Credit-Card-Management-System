<!DOCTYPE html>
<html>
<head><title> New Accounts Verification Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>New Account Request</h1></p>\n";

	require "config.php";
	$ecssn=$_POST["ecssn"];
	$efname=$_POST["efname"];
	$emname=$_POST["emname"];
	$elname=$_POST["elname"];
	$estreet=$_POST["estreet"];
	$eaptno=$_POST["eaptno"];
	$ecity=$_POST["ecity"];
	$ezip=$_POST["ezip"];
	$ephone1=$_POST["ephone1"];
	$ephone2=$_POST["ephone2"];
		
	if((!empty($_POST["ecssn"])) and (!empty($_POST["efname"])) and (!empty($_POST["elname"])) and (!empty($_POST["estreet"])) and (!empty($_POST["ecity"])) and (!empty($_POST["ezip"])) and (!empty($_POST["ephone1"])))
	{
		$conn = oci_connect($dbUser, $dbPass, $dbHost);
		$stmt = oci_parse($conn, "SELECT ACCOUNT_NUMBER, FNAME, MNAME, LNAME, STREET, APT_NO, CITY, ZIP, PHONE FROM CUSTOMER_ACCOUNT, CUSTOMER_NAME_SSN, CUSTOMER_ADDRESS, CUSTOMER_PHONE WHERE CUSTOMER_ACCOUNT.CUSTOMER_SSN = :ecssn AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_NAME_SSN.SSN AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_ADDRESS.CUSTOMER_SSN AND 	CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_PHONE.CUSTOMER_SSN");
		oci_bind_by_name($stmt, ":ecssn", $ecssn);
		oci_execute($stmt);
		if ($row=oci_fetch_array($stmt, OCI_BOTH)) {
			echo "<big><b><p>Request denied!</p></b></big>\n";
			echo "<b><p>Existing customer.</p></b>\n";
			echo "<table><tr><td>Account: </td><td align='left'>" . $row['ACCOUNT_NUMBER'] . "</td></tr>\n";
			echo "		<tr><td>Name: </td><td align='left'>" . $row['FNAME'] . " " .  $row['LNAME'] . "</td></tr>\n";
			if($row['APT_NO'] != 0) {
				echo "	<tr><td>Address: </td><td align='left'>" . $row['STREET'] . " " . $row['APT_NO'] . " " .  $row['CITY'] . " " .  $row['ZIP'] . "</td></tr>\n";
			}
			else {
				echo "	<tr><td>Address: </td><td align='left'>" . $row['STREET'] . " " .  $row['CITY'] . " " .  $row['ZIP'] . "</td></tr>\n";
			}
			echo "		<tr><td>Phone: </td><td align='left'>" . $row['PHONE'] . "</td></tr></table>\n";
		}
		else {
			echo "<big><b><p>Non-customer. Send credit score inquiry for credit score verification.</p></b></big>\n";
			echo "<big><b><p>After credit score verification, click Submit to continue.</p></b></big>\n";
			echo "<p></p>\n";
			echo "<form method='post' action='CreateAccount.php'>\n";
			echo "<input type='hidden' name='cssn' value='$ecssn'>\n";
			echo "<input type='hidden' name='cfname' value='$efname'>\n";
			echo "<input type='hidden' name='cmname' value='$emname'>\n";
			echo "<input type='hidden' name='clname' value='$elname'>\n";
			echo "<input type='hidden' name='cstreet' value='$estreet'>\n";
			echo "<input type='hidden' name='captno' value='$eaptno'>\n";
			echo "<input type='hidden' name='ccity' value='$ecity'>\n";
			echo "<input type='hidden' name='czip' value='$ezip'>\n";
			echo "<input type='hidden' name='cphone1' value='$ephone1'>\n";
			echo "<input type='hidden' name='cphone2' value='$ephone2'>\n";
			echo "<input type='submit' name='submit' value='Submit'>\n";
			echo "</form>\n";
		}
		oci_free_statement($stmt);
		oci_close($conn);
	}
	else {
		echo "<big><b><p>Some required fields are empty! Fields with * are required.</p></b></big>\n";
		echo "<p></p>";
		echo "<form method='post' action='NewAccountRequest.php'>\n";
		echo "<input type='submit' name='submit' value='Try again.'>\n";
		echo "</form>\n";
	}
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