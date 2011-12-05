<HTML>
   <HEAD>
	<TITLE>Credit Card Renewal Verification Page</TITLE>
   </HEAD>
	<BODY>
<?php

session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Credit Card Renewal Verification</h1></p>\n";
	
	require "config.php";

	$staff_number=$_SESSION["staffno"];

	//Retrieve the posted new location information.
	$cdnorenew=$_POST["cdnorenew"];

	//Connect to the database
	$c = oci_connect($dbUser, $dbPass, $dbHost);

	//Verify if customer is existing
	$s = oci_parse($c, "SELECT * FROM CREDIT_CARD WHERE CD_NUMBER = $cdnorenew");
	oci_execute($s);
	if ($row=oci_fetch_array($s, OCI_BOTH)) {
		echo "<b><p>Check expiration date:</p></b>\n";
		echo "<table><tr><td>Credit Card Number: </td><td align='left'>" . $row[0] . "</td></tr>\n";
		$acctnorenew = $row[1];
		echo "		<tr><td>Issue Date: </td><td align='left'>" . $row[2] . "</td></tr>\n";
		echo "		<tr><td>Valid Thru: </td><td align='left'>" . $row[3] . "</td></tr>\n";
		echo "		<tr><td>Status: </td><td align='left'>" . $row[6] . "</td></tr></table>\n";
		echo "<b><p>Cancel renewal if not expired.</p></b>\n";		

		echo "<p></p>";
		echo "<form method='post' action='RenewCard.php'>\n";
		echo "<input type='hidden' name='rcacctnorenew' value='$acctnorenew'>\n";
		echo "<input type = 'submit' name = 'submit' value = 'Renew' />\n";
		echo "</form>\n";

	}
	else {
		echo "<big><b><p>Non-existing credit card! Request denied.</p></b></big>\n";
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
