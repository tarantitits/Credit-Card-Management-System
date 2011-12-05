<!DOCTYPE html>
<html>
<head><title> Latest Activities Page </title></head>
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
	
	echo "<p><h1>Latest Activities</h1></p>\n";
	
	require "config.php";
	
	$ahacctno=$_SESSION['customeracctno'];
	$datefrom=$_POST["datefrom"];
	$dateto=$_POST["dateto"];

	if((!empty($_POST["datefrom"])) and (!empty($_POST["dateto"]))) {
		$conn = oci_connect($dbUser, $dbPass, $dbHost);
		
		$stmt = oci_parse($conn, "SELECT * FROM ACTIVITY WHERE ACCOUNT_NUMBER = $ahacctno AND ACTIVITY_DATE BETWEEN to_date(to_char($datefrom), 'J') AND to_date(to_char($dateto), 'J')");
		oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
		
		if ($row=oci_fetch_array($stmt, OCI_BOTH)) {
			echo "<table><tr><td align='center'>Number</td><td align='center'>Date</td><td align='center'>Type</td><td align='center'>Merchant</td><td align='center'>Amount</td></tr>\n";
			while ($row=oci_fetch_array($stmt, OCI_BOTH)) {
				echo "	<tr><td align='center'>$row[0]</td><td align='center'>$row[3]</td><td align='center'>$row[4]</td><td align='center'>$row[5]</td><td align='center'>$row[6]</td></tr>\n";
			}
			echo "</table>\n";
		}
		else {
			echo "No transactions found.<br />\n";
		}
				
		oci_free_statement($stmt);
		oci_close($conn);
	}
	else {
		echo "No date range specified.<br />\n";
	}
	
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