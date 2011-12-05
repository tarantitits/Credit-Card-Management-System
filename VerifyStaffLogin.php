<!DOCTYPE html>
<html>
<head><title> Staff Login Page </title></head>
<body>
<h1>Login</h1>
<?php
session_start();

if((!empty($_POST["susername"])) and (!empty($_POST["spassword"])) and $_POST["action"] == "login") {
	$_SESSION["susername"] = $_POST["susername"];
	$_SESSION["spassword"] = $_POST["spassword"];

	$susername=$_SESSION["susername"];
	$spassword=$_SESSION["spassword"];
	$_SESSION['verified'] = 0;
	
	require "config.php";
	
	$conn = oci_connect($dbUser, $dbPass, $dbHost);

	$stmt = oci_parse($conn, "SELECT NAME, STAFF_NUMBER, STAFF_TYPE FROM STAFF, STAFF_NAME_SSN WHERE (STAFF.USERNAME = :susername) AND (STAFF.PASSWORD = :spassword) AND (STAFF.SSN = STAFF_NAME_SSN.SSN)");
	oci_bind_by_name($stmt, ":susername", $susername);
	oci_bind_by_name($stmt, ":spassword", $spassword);
	oci_define_by_name($stmt, "NAME", $staffname);
	oci_define_by_name($stmt, "STAFF_NUMBER", $staffno);
	oci_define_by_name($stmt, "STAFF_TYPE", $stafftype);
	oci_execute($stmt);
	if (oci_fetch($stmt)) {
		$_SESSION['ERROR'] = "<p>Welcome back, $staffname.</p>";
		$_SESSION['verified'] = 1;
		$_SESSION['staffname'] = $staffname;
		$_SESSION['staffno'] = $staffno;
		$_SESSION['stafftype'] = $stafftype;
	}
	else {
		$_SESSION['ERROR'] = "<p>Username and password combination is invalid!</p>";
	}	

	oci_free_statement($stmt);
	oci_close($conn);

	if($_SESSION['verified']) {
			echo $_SESSION['ERROR'];
			echo "<p></p>\n";
			if ($_SESSION['stafftype'] != 'REPRESENTATIVE') {
				echo "<form method='post' action='AccountManagement.php'>\n";
				echo "<input type='submit' name='submit' value='Account Management'>\n";
				echo "</form>\n";
			}
			else {
				echo "<form method='post' action='CustomerServiceManagement.php'>\n";
				echo "<input type='submit' name='submit' value='Customer Service Management'>\n";		
				echo "</form>\n";
			}
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