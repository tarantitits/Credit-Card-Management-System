<!DOCTYPE html>
<html>
<head><title> Card Verification Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Card Verification</h1></p>\n";
	
	require "config.php";
	$vccdno=$_POST["vccdno"];
	$vccssn=$_POST["vccssn"];
	if((!empty($_POST["vccdno"])) and (!empty($_POST["vccssn"])))
	{
		$conn = oci_connect($dbUser, $dbPass, $dbHost);
		$stmt = oci_parse($conn, "SELECT STATUS FROM CUSTOMER_ACCOUNT, CREDIT_CARD WHERE CREDIT_CARD.CD_NUMBER = :vccdno AND CREDIT_CARD.ACCOUNT_NUMBER = CUSTOMER_ACCOUNT.ACCOUNT_NUMBER AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = :vccssn");
		oci_bind_by_name($stmt, ":vccdno", $vccdno);
		oci_bind_by_name($stmt, ":vccssn", $vccssn);
		oci_execute($stmt);
		if ($row=oci_fetch_array($stmt, OCI_BOTH)) {
			if($row['STATUS'] == "INACTIVE") {
				echo "<form method='post' action='ActivateCard.php'>\n";
				echo "<input type='hidden' name='accdno' value='$vccdno'>\n";
				echo "<input type = 'submit' name = 'submit' value = 'Activate' />\n";
				echo "</form>\n";
				echo "<p></p>";
			}
			else {
				echo "<p></p>";
				echo "<big><b><p>Card has already been activated.</p></b></big>\n";
				echo "<p></p>";
			}
		}
		else {
			echo "<big><b><p>Non-existing customer! Request denied.</p></b></big>\n";

			
		}
		oci_free_statement($stmt);
		oci_close($conn);
	}
	else {
		echo "<big><b><p>Some required fields are empty! Fields with * are required.</p></b></big>\n";
		echo "<form method='post' action='CardActivation.php'>\n";
		echo "<input type='submit' name='submit' value='Try again.'>\n";
		echo "</form>\n";
		echo "<p></p>";
	}
	echo "<p></p>";
	echo "<form method='post' action='CustomerServiceManagement.php'>\n";
	echo "<input type='submit' name='submit' value='Cancel activation'>\n";
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