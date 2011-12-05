<HTML>
   <HEAD>
	<TITLE>Credit Card Renewal Page</TITLE>
   </HEAD>
	<BODY>
<?php

session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Credit Card Renewal</h1></p>\n";
	
	require "config.php";

	$staff_number=$_SESSION["staffno"];

	//Retrieve the posted new location information.
	$rcacctnorenew=$_POST["rcacctnorenew"];

	//Connect to the database
	$c = oci_connect($dbUser, $dbPass, $dbHost);

	// Insert into credit_card table to generate new credit card number
	$s=oci_parse($c,"INSERT INTO CREDIT_CARD VALUES (SEQ_CD_NUMBER.NEXTVAL, :rcacctnorenew, CURRENT_DATE, CURRENT_DATE + 1095, SEQ_CVC.NEXTVAL, SEQ_PIN.NEXTVAL, 'INACTIVE')");
	oci_bind_by_name($s, ":rcacctnorenew", $rcacctnorenew);
	$result=oci_execute($s, OCI_COMMIT_ON_SUCCESS);

	if ($result)
	// Display an appropriate message on either success or failure
	{
		$s=oci_parse($c,"select * from credit_card where account_number = $rcacctnorenew order by issue_date");
		$result=oci_execute($s);
		
		if ($row=oci_fetch_array($s, OCI_BOTH)) {
			// The last row should be the latest credit card
			while ($row=oci_fetch_array($s, OCI_BOTH)) {
				$renewcdno = $row[0];
				$renewacctno = $row[1];
				$renewissuedt = $row[2];
				$renewvalidthru = $row[3];
				$renewcvc = $row[4];
				$renewpin = $row[5];
				$renewstatus = $row[6];
			}
			echo "Card number: " . $renewcdno . "<br />";
			echo "Account number: " . $renewacctno . "<br />";
			echo "Issue date: " . $renewissuedt . "<br />";
			echo "Valid thru: " . $renewvalidthru . "<br />";
			echo "CVC: " . $renewcvc . "<br />";
			echo "PIN: " . $renewpin . "<br />";
			echo "Status: " . $renewstatus . "<br />";
		}
	}
	else
	{
		echo "<p>There was a problem inserting the information!</p>";
		var_dump(oci_error($s));
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
