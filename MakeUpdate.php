<!DOCTYPE html>
<html>
<head><title> Make Update Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<h1><p>Update Customer Details</p></h1>\n";
	echo "<hr />";
	echo "<p></p>";

	require "config.php";

	$mustaffno=$_SESSION["staffno"];
	$mucssn=$_POST["mucssn"];
	$mustreet=$_POST["mustreet"];
	$muaptno=$_POST["muaptno"];
	$mucity=$_POST["mucity"];
	$muzip=$_POST["muzip"];
	$muphone=$_POST["muphone"];
	$mucuname=$_POST["mucuname"];
	$mucpword=$_POST["mucpword"];
	$musquestion=$_POST["musquestion"];
	$musanswer=$_POST["musanswer"];

	if((empty($_POST["mustreet"])) and (empty($_POST["muaptno"])) and (empty($_POST["mucity"])) and (empty($_POST["muzip"])) and (empty($_POST["muphone"])) and (empty($_POST["mucuname"])) and (empty($_POST["mucpword"])) and (empty($_POST["musquestion"])) and (empty($_POST["musanswer"])))
	{
		echo "<big><b><p>All fields were empty. No updates made.</p></b></big>\n";
	}
	else {
		$conn = oci_connect($dbUser, $dbPass, $dbHost);
		$stmt = oci_parse($conn, "INSERT INTO STAFF_CUSTOMER_MANAGE VALUES(:mustaffno, :mucssn)");
		oci_bind_by_name($stmt, ":mustaffno", $mustaffno);
		oci_bind_by_name($stmt, ":mucssn", $mucssn);
		oci_execute($stmt);
		if((!empty($_POST["mustreet"])) and (!empty($_POST["muaptno"])) and (!empty($_POST["mucity"])) and (!empty($_POST["muzip"])))
		{
			$stmt = oci_parse($conn, "UPDATE CUSTOMER_ADDRESS SET STREET = :mustreet, APT_NO = :muaptno, CITY = :mucity, ZIP = :muzip WHERE CUSTOMER_SSN = :mucssn");
			oci_bind_by_name($stmt, ":mucssn", $mucssn);
			oci_bind_by_name($stmt, ":mustreet", $mustreet);
			oci_bind_by_name($stmt, ":muaptno", $muaptno);
			oci_bind_by_name($stmt, ":mucity", $mucity);
			oci_bind_by_name($stmt, ":muzip", $muzip);
			oci_execute($stmt);
			echo "<big><b><p>Address updated.</p></b></big>\n";
		}
		if(!empty($_POST["muphone"]))
		{
			$stmt = oci_parse($conn, "UPDATE CUSTOMER_PHONE SET PHONE = :muphone WHERE CUSTOMER_SSN = :mucssn");
			oci_bind_by_name($stmt, ":mucssn", $mucssn);
			oci_bind_by_name($stmt, ":muphone", $muphone);
			oci_execute($stmt);
			echo "<big><b><p>Phone updated.</p></b></big>\n";
		}
		if(!empty($_POST["mucuname"]))
		{
			$stmt = oci_parse($conn, "UPDATE CUSTOMER_ACCOUNT SET USERNAME = :mucuname WHERE CUSTOMER_SSN = :mucssn");
			oci_bind_by_name($stmt, ":mucssn", $mucssn);
			oci_bind_by_name($stmt, ":mucuname", $mucuname);
			oci_execute($stmt);
			echo "<big><b><p>Username updated.</p></b></big>\n";
		}
		if(!empty($_POST["mucpword"]))
		{
			$stmt = oci_parse($conn, "UPDATE CUSTOMER_ACCOUNT SET PASSWORD = :mucpword WHERE CUSTOMER_SSN = :mucssn");
			oci_bind_by_name($stmt, ":mucssn", $mucssn);
			oci_bind_by_name($stmt, ":mucpword", $mucpword);
			oci_execute($stmt);
			echo "<big><b><p>Password updated.</p></b></big>\n";
		}
		if(!empty($_POST["musquestion"]))
		{
			$stmt = oci_parse($conn, "UPDATE CUSTOMER_ACCOUNT SET SQUESTION = :musquestion WHERE CUSTOMER_SSN = :mucssn");
			oci_bind_by_name($stmt, ":mucssn", $mucssn);
			oci_bind_by_name($stmt, ":musquestion", $musquestion);
			oci_execute($stmt);
			echo "<big><b><p>Security question updated.</p></b></big>\n";
		}
		if(!empty($_POST["musanswer"]))
		{
			$stmt = oci_parse($conn, "UPDATE CUSTOMER_ACCOUNT SET SANSWER = :musanswer WHERE CUSTOMER_SSN = :mucssn");
			oci_bind_by_name($stmt, ":mucssn", $mucssn);
			oci_bind_by_name($stmt, ":musanswer", $musanswer);
			oci_execute($stmt);
			echo "<big><b><p>Answer to security question updated.</p></b></big>\n";
		}

		oci_free_statement($stmt);
		oci_close($conn);
	}

	if ($_SESSION['stafftype'] != 'REPRESENTATIVE') {	
		echo "<p></p>";
		echo "<form method='post' action='AccountManagement.php'>\n";
		echo "<input type='submit' name='submit' value='Back to Account Management'>\n";
		echo "</form>\n";
	}
	else {
		echo "<p></p>";
		echo "<form method='post' action='CustomerServiceManagement.php'>\n";
		echo "<input type='submit' name='submit' value='Back to Customer Service Management'>\n";		
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
?>
</body>
</html>