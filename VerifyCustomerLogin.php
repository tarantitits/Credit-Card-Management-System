<!DOCTYPE html>
<html>
<head><title> Customer Login Page </title></head>
<body>
<h1>Login</h1>
<?php
session_start();

if((!empty($_POST["cusername"])) and (!empty($_POST["cpassword"])) and $_POST["action"] == "login") {
	$_SESSION["cusername"] = $_POST["cusername"];
	$_SESSION["cpassword"] = $_POST["cpassword"];

	$cusername=$_SESSION["cusername"];
	$cpassword=$_SESSION["cpassword"];
	$_SESSION['cverified'] = 0;
	
	require "config.php";
	
	$conn = oci_connect($dbUser, $dbPass, $dbHost);

	$stmt = oci_parse($conn, "SELECT FNAME, LNAME, ACCOUNT_NUMBER FROM CUSTOMER_ACCOUNT, CUSTOMER_NAME_SSN WHERE (CUSTOMER_ACCOUNT.USERNAME = :cusername) AND (CUSTOMER_ACCOUNT.PASSWORD = :cpassword) AND (CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_NAME_SSN.SSN)");
	oci_bind_by_name($stmt, ":cusername", $cusername);
	oci_bind_by_name($stmt, ":cpassword", $cpassword);
	oci_define_by_name($stmt, "FNAME", $customerfname);
	oci_define_by_name($stmt, "LNAME", $customerlname);
	oci_define_by_name($stmt, "ACCOUNT_NUMBER", $customeracctno);
	oci_execute($stmt);
	if (oci_fetch($stmt)) {
		$_SESSION['ERROR'] = "<p>Welcome back, $customerfname $customerlname.</p>";
		$_SESSION['cverified'] = 1;
		$_SESSION['customerfname'] = $customerfname;
		$_SESSION['customerlname'] = $customerlname;
		$_SESSION['customeracctno'] = $customeracctno;
	}
	else {
		$_SESSION['ERROR'] = "<p>Username and password combination is invalid!</p>";
	}	

	oci_free_statement($stmt);
	oci_close($conn);

	if($_SESSION['cverified']) {
			echo $_SESSION['ERROR'];
			echo "<p></p>\n";
			echo "<form method='post' action='AccountSummary.php'>\n";
			echo "<input type='submit' name='submit' value='Account Summary'>\n";
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
}
else {
	echo "<p></p>";
	echo "<h3>Enter username and password</h3>\n";
	echo "<p></p>";
	echo "<hr />\n";
	echo "<b><a href = 'index.html' action = login> Login again.</a></b>\n";
}
?>
</body>
</html>