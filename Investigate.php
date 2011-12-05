<HTML>
   <HEAD>
	<TITLE>Customer Service Request Page</TITLE>
   </HEAD>
	<BODY>
<?php

session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Customer Service Request</h1></p>\n";
	require "config.php";
	
	//Connect to the database
	$c = oci_connect($dbUser, $dbPass, $dbHost);
		
	// Retrieve ssn and csn
	$iinewcsn = $_POST['iinewcsn'];
	$iicustomer_ssn = $_POST['iicustomer_ssn'];
	$dtdsdate = $_POST['dtdsdate'];
	$dtdsamt = $_POST['dtdsamt'];
	$dtdsmerc = $_POST['dtdsmerc'];
	$dtdsdesc = $_POST['dtdsdesc'];

	// Look for the disputed transaction
	$s=oci_parse($c,"select account_number from customer_account where customer_ssn = $iicustomer_ssn");
	$result=oci_execute($s);
	if ($row=oci_fetch_array($s, OCI_BOTH)) {
		$acct_no = $row[0];
	}
	else {
		echo "<p>There was a problem with the retrieval!</p>\n";
	}

	$s=oci_parse($c,"select activity_number, activity_date, merchant, amount, cd_number from activity where activity.account_number = $acct_no and activity_type = 'T'");
	$result=oci_execute($s);

	if ($row=oci_fetch_array($s, OCI_BOTH)) {
		// Display transaction that was in our records and compare with ones from customer service report
		echo "<p><b>Please print the following for the investigator: </b></p>";
		echo "<b>Transaction details from our record. </b><br />";
		while ($row=oci_fetch_array($s, OCI_BOTH)) {
			echo "Activity number: " . $row[0] . "<br />";
			echo "Activity date: " . $row[1] . "<br />";
			echo "Merchant: " . $row[2] . "<br />";
			echo "Activity amount: " . $row[3] . "<br />";
			echo "Credit card number: " . $row[4] . "<br />";
			echo "<p></p>";
		}
		// Display transaction that was claimed by customer from customer service report
		echo "<b>Transaction details from customer. </b><br />";
		echo "Activity date: " . $dtdsdate . "<br />";
		echo "Merchant: " . $dtdsmerc . "<br />";
		echo "Activity amount: " . $dtdsamt . "<br />";
		echo "Description of dispute: " . $dtdsdesc . "<br />";
		echo "<p></p>";
		$activity_no = $row[0];
		$activity_dt = $row[1];
		$activity_mrc = $row[2];
		$activity_amt = $row[3];
		$activity_cdno = $row[4];
		$trnxdet = 'Transaction date, amount, merchant, and number: ' . $activity_dt . ', ' . $activity_amt . ', ' . $activity_mrc . ', ' . $activity_no . '. Dispute: ' . $dtdsdesc;

		// Insert into investigation table to generate investigation_number
		$s=oci_parse($c,"insert into investigation (investigation_number, customer_service_number, customer_ssn, description, disposition) values (seq_investigation.nextval, :iinewcsn, :iicustomer_ssn, :trnxdet, 'UNDER INVESTIGATION')");
		oci_bind_by_name($s, ":iinewcsn", $iinewcsn);
		oci_bind_by_name($s, ":iicustomer_ssn", $iicustomer_ssn);
		oci_bind_by_name($s, ":trnxdet", $trnxdet);
		$result=oci_execute($s, OCI_COMMIT_ON_SUCCESS);

		// Look for investigation number
		$s=oci_parse($c,"select * from investigation where customer_service_number = $iinewcsn");
		$result=oci_execute($s);

		// Display investigation details (still under investigation)
		if ($row=oci_fetch_array($s, OCI_BOTH)) {
			echo "<b>Investigation form: </b><br />";
			echo "Investigation number: " . $row[0] . "<br />";
			echo "Customer service number: " . $row[1] . "<br />";
			echo "Customer SSN: " . $row[2] . "<br />";
			echo "Description: " . $row[6] . "<br />";
			echo "Disposition: " . $row[7] . "<br />";
			echo "<p></p>";
			echo "<b>Investigator needs to provide the following during update: </b><br />";
			echo "Staff number: <br />";
			echo "Activity number: <br />";
			echo "Investigation date: <br />";
		}
		else {
			echo "Failed query. <br />";
		}
	}
	else {
		echo "No data found.<br />";
		echo "<p></p>";
		echo "<form method='post' action='CancelCustomerService.php'>\n";
		echo "<input type='hidden' name='ccsnewcsn' value='$iinewcsn'><br />";
		echo "<input type='submit' name='submit' value='Cancel Request'>\n";		
		echo "</form>\n";
	}

	oci_free_statement($s);
	oci_close($c);
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
