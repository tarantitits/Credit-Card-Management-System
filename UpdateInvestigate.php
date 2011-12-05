<HTML>
   <HEAD>
	<TITLE>Update Investigation Disposition</TITLE>
   </HEAD>
	<BODY>

<?php

session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Dispute Disposition</h1></p>\n";
	require "config.php";

	//Connect to the database
	$c = oci_connect($dbUser, $dbPass, $dbHost);
			
	// Retrieve ssn and csn
	$up_staff_no = $_SESSION['staffno'];
	$up_investigation_no = $_POST['up_investigation_no'];
	$up_activity_no = $_POST['up_activity_no'];
	$up_investigation_date = $_POST['up_investigation_date'];
	$up_investigation_dispo = $_POST['up_investigation_dispo'];
	$disputedisposition = "'" . $up_investigation_dispo . "'";
	
	// Insert into investigation table to generate investigation_number
	$s=oci_parse($c,"update investigation set staff_number = $up_staff_no, activity_number = $up_activity_no, disposition = $disputedisposition, investigation_date = to_date($up_investigation_date, 'J') where investigation_number = $up_investigation_no");
	$result=oci_execute($s, OCI_COMMIT_ON_SUCCESS);

	// Look for investigation number
	if($result) {
		$s=oci_parse($c,"select * from investigation where investigation_number = $up_investigation_no");
		$result=oci_execute($s);

		// Display investigation details (still under investigation)
		if ($row=oci_fetch_array($s, OCI_BOTH)) {
			echo "<p><b>Please print the following for your record: </b></p>";
			echo "Investigation number: " . $row[0] . "<br />";
			echo "Customer service number: " . $row[1] . "<br />";
			echo "Customer SSN: " . $row[2] . "<br />";
			echo "Staff number: " . $row[3] . "<br />";
			echo "Activity number: " . $row[4] . "<br />";
			echo "Investigation date: " . $row[5] . "<br />";
			echo "Description: " . $row[6] . "<br />";
			echo "Disposition: " . $row[7] . "<br />";
			
			if ($row[7] == 'INVALID' OR $row[7] == 'FRAUD') {
				//$s=oci_parse($c,"delete from activity where activity_number = $row[4]");
				//$result=oci_execute($s);
				echo "<p><b>Please delete the said transaction from the records.</b></p>";
			}
		}
		else {
			echo "Investigation number non-existent. <br />";
		}
	}
	else {
		echo "Unsuccessful update. <br />";
	}
	
	oci_free_statement($s);
	oci_close($c);

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