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

	echo "<p><h1>Cancel Customer Service Request</h1></p>\n";
	require "config.php";

	//Retrieve the csn to cancel
	$ccsnewcsn=$_POST["ccsnewcsn"];

	//Connect to the database
	$c = oci_connect($dbUser, $dbPass, $dbHost);

	// Update the customer_service 
	$s=oci_parse($c,"update customer_service set resolution = 'CANCELED SERVICE REQUEST' where customer_service_number = $ccsnewcsn");
	$result=oci_execute($s, OCI_COMMIT_ON_SUCCESS);

	if ($result)
	// Display an appropriate message on either success or failure
	{
		echo "<p>Customer service request canceled!</p>";
	}
	else
	{
		echo "<p>There was a problem updating customer service table!</p>";
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
