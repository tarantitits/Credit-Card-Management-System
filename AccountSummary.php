<!DOCTYPE html>
<html>
<head><title> Account Summary Page </title></head>
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
	
	echo "<p><h1>Account Summary</h1></p>\n";
	
	require "config.php";
	
	$asacctno=$_SESSION['customeracctno'];
	$conn = oci_connect($dbUser, $dbPass, $dbHost);
	
	$stmt = oci_parse($conn, "SELECT COUNT(*) FROM CREDIT_CARD WHERE ACCOUNT_NUMBER = $asacctno");
	oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
	
	if ($row=oci_fetch_array($stmt, OCI_BOTH)) {
		$cissuedcd = $row[0];
		if($cissuedcd < 2) {
			$stmt = oci_parse($conn, "SELECT CD_NUMBER, TO_CHAR(ISSUE_DATE, 'YYYY-MM-DD'), STATUS FROM CREDIT_CARD WHERE ACCOUNT_NUMBER = $asacctno");
			oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
	
			if ($irow=oci_fetch_array($stmt, OCI_BOTH)) {
				$ccdnumber = $irow[0];
				$ccdissuedt = $irow[1];
				$ccdstatus =$irow[2];
			}
		 }
		else {
			$stmt = oci_parse($conn, "SELECT LAST_VALUE(CD_NUMBER) OVER (ORDER BY ISSUE_DATE), TO_CHAR(LAST_VALUE(ISSUE_DATE) OVER (ORDER BY ISSUE_DATE), 'YYYY-MM-DD'), LAST_VALUE(STATUS) OVER (ORDER BY ISSUE_DATE) FROM CREDIT_CARD WHERE ACCOUNT_NUMBER = $asacctno");
			oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);	
	
			if ($iirow=oci_fetch_array($stmt, OCI_BOTH)) {
				$ccdnumber = $iirow[0];
				$ccdissuedt = $iirow[1];
				$ccdstatus = $iirow[2];
			}
		}
	}
	if($ccdstatus == "ACTIVE") {
		if((date('Y-m-d')- $ccdissuedt) < 30 and $cissuedcd < 2) {
			$lastbilldate = $ccdissuedt;
		}
		else {
			$stmt = oci_parse($conn, "SELECT LAST_VALUE(STATEMENT_DATE) OVER (ORDER BY STATEMENT_DATE) FROM STATEMENT WHERE ACCOUNT_NUMBER = $asacctno");
			oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);

			if ($iiirow=oci_fetch_array($stmt, OCI_BOTH)) {
				$lastbilldate = $iiirow[0];
			}
		}
		
		$stmt = oci_parse($conn, "SELECT ACTIVITY_TYPE, SUM(AMOUNT) FROM ACTIVITY WHERE ACCOUNT_NUMBER = $asacctno GROUP BY ACTIVITY_TYPE");
		oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
	
		if (!($ivrow=oci_fetch_array($stmt, OCI_BOTH))) {
			$totaltnx=0;
			$totalpay=0;
		}
		
		while ($ivrow=oci_fetch_array($stmt, OCI_BOTH)) {
			if($ivrow[0] == 'T') $totaltnx=$ivrow[1];
			else $totaltnx=0;
			if($ivrow[0] == 'P') $totalpay=$ivrow[1];
			else $totalpay=0;
		}

		$stmt = oci_parse($conn, "SELECT LAST_VALUE(AMOUNT) OVER (ORDER BY ACTIVITY_DATE), LAST_VALUE(ACTIVITY_DATE) OVER (ORDER BY ACTIVITY_DATE)  FROM ACTIVITY WHERE ACCOUNT_NUMBER = $asacctno AND ACTIVITY_TYPE = 'P'");
		oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);

		if ($vrow=oci_fetch_array($stmt, OCI_BOTH)) {			
			$lastpayment = $vrow[0];
			$lastpaydate = $vrow[1];
		}
		else {
			$lastpayment = 0;
			$lastpaydate = 0;
		}
		
		if($lastpaydate > ($lastbilldate + 15)) {
			echo "past due";
		}
		// table here
	}
	else {
		echo "INACTIVE";
	}

	echo "<p>Account number: $asacctno</p>\n";
	echo "<p>Card number: $ccdnumber</p>\n";
	echo "<p>Issue date: $ccdissuedt</p>\n";
	echo "<p>Status: $ccdstatus</p>\n";
	echo "<p>Number of cards: $cissuedcd</p>\n";
	echo "<p>Last bill date: $lastbilldate</p>\n";
	echo "<p>Total transaction: $totaltnx</p>\n";
	echo "<p>Total payment: $totalpay</p>\n";
	echo "<p>Last payment date: $lastpaydate</p>\n";
	echo "<p>Latest payment: $lastpayment</p>\n";

	oci_free_statement($stmt);
	oci_close($conn);
	
	echo "<hr />\n";
	echo "<form method='post' action='ActivityHistory.php'>\n";
	echo "<input type='submit' name='submit' value='Latest Activities'>\n";
	echo "<table><tr><td>Date from:</td><td align='right'><input type='text' name='datefrom' /></td>\n";
	echo "	<td>Date to:</td><td align='right'><input type='text' name='dateto' /></td></tr></table>\n";
	echo "</form>\n";
	echo "<hr />\n";
	echo "<p></p>";

	echo "<form method='post' action='AccountProfile.php'>\n";
	echo "<input type='submit' name='submit' value='Account Profile'>\n";
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