<!DOCTYPE html>
<html>
<head><title> Make Changes Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Change Account Details</h1></p>\n";

	require "config.php";
	$mcstaffno=$_SESSION['staffno'];
	$mcacctno=$_POST["mcacctno"];
	$mcmxclimit=$_POST["mcmxclimit"];
	$mcapr=$_POST["mcapr"];

	if((empty($_POST["mcmxclimit"])) and (empty($_POST["mcapr"])))
	{
		echo "<big><b><p>All fields were empty. No changes made.</p></b></big>\n";
	}
	else {
		$conn = oci_connect($dbUser, $dbPass, $dbHost);
		$stmt = oci_parse($conn, "INSERT INTO STAFF_ACCOUNT_MANAGE VALUES (:mcstaffno, :mcacctno)");
		oci_bind_by_name($stmt, ":mcstaffno", $mcstaffno);
		oci_bind_by_name($stmt, ":mcacctno", $mcacctno);
		oci_execute($stmt);
		if(!empty($_POST["mcmxclimit"]))
		{
			$stmt = oci_parse($conn, "UPDATE CUSTOMER_ACCOUNT SET MAX_CREDIT_LIMIT = :mcmxclimit WHERE ACCOUNT_NUMBER = :mcacctno");
			oci_bind_by_name($stmt, ":mcacctno", $mcacctno);
			oci_bind_by_name($stmt, ":mcmxclimit", $mcmxclimit);
			oci_execute($stmt);
			echo "<big><b><p>Credit limit changed.</p></b></big>\n";
		}
		if(!empty($_POST["mcapr"]))
		{
			$stmt = oci_parse($conn, "UPDATE CUSTOMER_ACCOUNT SET INTEREST_RATE = :mcapr WHERE ACCOUNT_NUMBER = :mcacctno");
			oci_bind_by_name($stmt, ":mcacctno", $mcacctno);
			oci_bind_by_name($stmt, ":mcapr", $mcapr);
			oci_execute($stmt);
			echo "<big><b><p>Interest rate changed.</p></b></big>\n";
		}

		oci_free_statement($stmt);
		oci_close($conn);
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