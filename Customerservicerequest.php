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

	$staff_number=$_SESSION["staffno"];

	//Retrieve the posted new location information.
	$customer_ssn=$_POST["customer_ssn"];
	$customer_fname=$_POST["customer_fname"];
	$customer_lname=$_POST["customer_lname"];
	$service_type=$_POST["service_type"];
	$resolution=$_POST["resolution"];

	//Connect to the database
	$c = oci_connect($dbUser, $dbPass, $dbHost);

	//Verify if customer is existing
	$s = oci_parse($c, "SELECT ACCOUNT_NUMBER, SQUESTION, SANSWER, USERNAME, PASSWORD, FNAME, MNAME, LNAME, STREET, APT_NO, CITY, ZIP, PHONE FROM CUSTOMER_ACCOUNT, CUSTOMER_NAME_SSN, CUSTOMER_ADDRESS, CUSTOMER_PHONE WHERE CUSTOMER_ACCOUNT.CUSTOMER_SSN = $customer_ssn AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_NAME_SSN.SSN AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_ADDRESS.CUSTOMER_SSN AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_PHONE.CUSTOMER_SSN");
	oci_execute($s);
	if ($row=oci_fetch_array($s, OCI_BOTH)) {
		echo "<b><p>Existing customer.</p></b>\n";
		echo "<table><tr><td>Account: </td><td align='left'>" . $row['ACCOUNT_NUMBER'] . "</td></tr>\n";
		echo "		<tr><td>Name given: </td><td align='left'>" . $customer_fname . " " . $customer_lname . " " . "</td></tr>\n";
		if($row['MNAME'] != '_') {
			echo "	<tr><td>Name in our record: </td><td align='left'>" . $row['FNAME'] . " " . $row['MNAME'] . " " . $row['LNAME'] . "</td></tr>\n";
		}
		else {
			echo "	<tr><td>Name in our record: </td><td align='left'>" . $row['FNAME'] . " " . $row['LNAME'] . "</td></tr>\n";
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
			
		// Insert the customer_service information into the customer_service table.
		$s=oci_parse($c,"insert into customer_service (customer_service_number,customer_ssn,staff_number,service_type,service_date,resolution) values(seq_csn.nextval,:customer_ssn,:staff_number,:service_type,current_date,:resolution)");
		oci_bind_by_name($s, ":customer_ssn", $customer_ssn);
		oci_bind_by_name($s, ":staff_number", $staff_number);
		oci_bind_by_name($s, ":service_type", $service_type);
		oci_bind_by_name($s, ":resolution", $resolution);
		$result=oci_execute($s, OCI_COMMIT_ON_SUCCESS);

		if ($result)
		// Display an appropriate message on either success or failure
		{
			echo "<p>Customer information successfully inserted!</p>";
			$s=oci_parse($c,"select customer_service_number from customer_service where customer_ssn = $customer_ssn");
			$result=oci_execute($s);

			if ($row=oci_fetch_array($s, OCI_BOTH)) {
				echo "<p></p>";
				echo "Customer service number: " . $row[0] . "<br />";
				$newcsn = $row[0];

				if($service_type == 'dispute') {
					echo "<p></p>";
					echo "<form method='post' action='Investigation.php'>\n";
					echo "<input type='hidden' name='inewcsn' value='$newcsn'>\n";
					echo "<input type='hidden' name='icustomer_ssn' value='$customer_ssn'>\n";
					echo "<input type = 'submit' name = 'submit' value = 'Request Investigation' />\n";
					echo "</form>\n";
				}
				else {
					echo "<p></p>";
					echo "<form method='post' action='StolenLostCard.php'>\n";
					echo "<input type='hidden' name='slnewcsn' value='$newcsn'>\n";
					echo "<input type='hidden' name='slcustomer_ssn' value='$customer_ssn'>\n";
					echo "<input type='hidden' name='slservice_type' value='$service_type'>\n";
					echo "<input type = 'submit' name = 'submit' value = 'Request Card Replacement' />\n";
					echo "</form>\n";
					}
				echo "<p></p>";
				echo "<form method='post' action='CancelCustomerService.php'>\n";
				echo "<input type='hidden' name='ccsnewcsn' value='$newcsn'>\n";
				echo "<input type='submit' name='submit' value='Cancel Request'>\n";		
				echo "</form>\n";
			}
		}
		else
		{
			echo "<p>There was a problem inserting the information!</p>";
			var_dump(oci_error($s));
		}
	}
	else {
		echo "<big><b><p>Non-existing customer! Request denied.</p></b></big>\n";
	}
	oci_free_statement($s);
	oci_close($c);

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
