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
			
	// Retrieve ssn, csn, and service type
	$slnewcsn = $_POST['slnewcsn'];
	$slcustomer_ssn = $_POST['slcustomer_ssn'];
	$slservice_type = $_POST['slservice_type'];

	// Retrieve account number using ssn
	$s=oci_parse($c,"select account_number from customer_account where customer_ssn = $slcustomer_ssn");
	$result=oci_execute($s, OCI_COMMIT_ON_SUCCESS);

	if ($row=oci_fetch_array($s, OCI_BOTH)) {
		echo "Account number: " . $row[0] . "<br />";
		$slacctno = $row[0];
	}

	// Retrieve all credit cards associated with the account number
	$s=oci_parse($c,"select * from credit_card where account_number = $slacctno order by issue_date");
	$result=oci_execute($s, OCI_COMMIT_ON_SUCCESS);

	// The last row should be the latest credit card
	while ($row=oci_fetch_array($s, OCI_BOTH)) {
		//echo "Card number: " . $row[0] . "<br />";
		$slcdno = $row[0];
		//echo "Account number: " . $row[1] . "<br />";
		//echo "Issue date: " . $row[2] . "<br />";
		//echo "Valid thru: " . $row[3] . "<br />";
		//echo "CVC: " . $row[4] . "<br />";
		//echo "PIN: " . $row[5] . "<br />";
		//echo "Status: " . $row[6] . "<br />";
	}

	// Use service type as status for credit card (stolen or lost)
	$slcdstatus= "'" . $slservice_type . "'";

	// Replace card, use stored procedure replaceCard()
	$s=oci_parse($c,"UPDATE CREDIT_CARD SET STATUS = $slcdstatus WHERE CD_NUMBER = $slcdno");
	$result=oci_execute($s, OCI_COMMIT_ON_SUCCESS);

	$s=oci_parse($c,"INSERT INTO CREDIT_CARD VALUES (SEQ_CD_NUMBER.NEXTVAL, :slacctno, CURRENT_DATE, CURRENT_DATE + 1095, SEQ_CVC.NEXTVAL, SEQ_PIN.NEXTVAL, 'INACTIVE')");
	oci_bind_by_name($s, ":slacctno", $slacctno);
	$result=oci_execute($s, OCI_COMMIT_ON_SUCCESS);

	if($result) {
		$s=oci_parse($c,"select * from credit_card where account_number = $slacctno order by issue_date");
		$result=oci_execute($s, OCI_COMMIT_ON_SUCCESS);

		while ($row=oci_fetch_array($s, OCI_BOTH)) {
			$stlnewcdno = $row[0];
			$stlnewacctno = $row[1];
			$stlnewissuedt = $row[2];
			$stlnewvalidthru = $row[3];
			$stlnewcvc = $row[4];
			$stlnewpin = $row[5];
			$stlnewstatus = $row[6];
		}
		echo "Card number: " . $stlnewcdno . "<br />";
		echo "Account number: " . $stlnewacctno . "<br />";
		echo "Issue date: " . $stlnewissuedt . "<br />";
		echo "Valid thru: " . $stlnewvalidthru . "<br />";
		echo "CVC: " . $stlnewcvc . "<br />";
		echo "PIN: " . $stlnewpin . "<br />";
		echo "Status: " . $stlnewstatus . "<br />";
		
		// Insert record into replace_credit_card table
		$s=oci_parse($c,"INSERT INTO replace_credit_card VALUES (:slnewcsn, :slcustomer_ssn, :slcdno)");
		oci_bind_by_name($s, ":slnewcsn", $slnewcsn);
		oci_bind_by_name($s, ":slcustomer_ssn", $slcustomer_ssn);
		oci_bind_by_name($s, ":slcdno", $slcdno);
		$result=oci_execute($s, OCI_COMMIT_ON_SUCCESS);
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
