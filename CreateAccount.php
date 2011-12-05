<!DOCTYPE html>
<html>
<head><title> Create New Accounts Page </title></head>
<body>

<?php
session_start();
if($_SESSION['verified']) {
	echo "<p>User: " . $_SESSION["staffname"] . "</p>\n";
	echo "<hr />";
	echo "<p></p>";

	echo "<p><h1>Create New Account</h1></p>\n";

	require "config.php";
	
	$castaffno=$_SESSION['staffno'];
	$cssn=$_POST["cssn"];
	$cfname=$_POST["cfname"];
	$cmname=$_POST["cmname"];
	$clname=$_POST["clname"];
	$cstreet=$_POST["cstreet"];
	$captno=$_POST["captno"];
	$ccity=$_POST["ccity"];
	$czip=$_POST["czip"];
	$cphone1=$_POST["cphone1"];
	$cphone2=$_POST["cphone2"];
	$conn = oci_connect($dbUser, $dbPass, $dbHost);

	if((!empty($_POST["captno"])) and (!empty($_POST["cmname"]))) {
	$stmt = oci_parse($conn, "BEGIN createNewAcct(:cssn, :cfname, :cmname, :clname, :cstreet, :captno, :ccity, :czip, :cphone1, :castaffno); END;");
	oci_bind_by_name($stmt, ":cmname", $cmname);
	oci_bind_by_name($stmt, ":captno", $captno);
	}
	else if(!empty($_POST["captno"])) {
	$stmt = oci_parse($conn, "BEGIN createNewAcct(:cssn, :cfname, '_', :clname, :cstreet, :captno, :ccity, :czip, :cphone1, :castaffno); END;");
	oci_bind_by_name($stmt, ":captno", $captno);
	}
	else if(!empty($_POST["cmname"])) {
	$stmt = oci_parse($conn, "BEGIN createNewAcct(:cssn, :cfname, :cmname, :clname, :cstreet, '0', :ccity, :czip, :cphone1, :castaffno); END;");
	oci_bind_by_name($stmt, ":cmname", $cmname);
	}
	else {
	$stmt = oci_parse($conn, "BEGIN createNewAcct(:cssn, :cfname, '_', :clname, :cstreet, '0', :ccity, :czip, :cphone1, :castaffno); END;");
	}
	oci_bind_by_name($stmt, ":cssn", $cssn);
	oci_bind_by_name($stmt, ":cfname", $cfname);
	oci_bind_by_name($stmt, ":clname", $clname);
	oci_bind_by_name($stmt, ":cstreet", $cstreet);
	oci_bind_by_name($stmt, ":ccity", $ccity);
	oci_bind_by_name($stmt, ":czip", $czip);
	oci_bind_by_name($stmt, ":cphone1", $cphone1);
	oci_bind_by_name($stmt, ":castaffno", $castaffno);
	oci_execute($stmt);

	if(!empty($_POST["cphone2"])) {
		$stmt = oci_parse($conn, "INSERT INTO CUSTOMER_PHONE VALUES (:cssn, :cphone2)");
		oci_bind_by_name($stmt, ":cssn", $cssn);
		oci_bind_by_name($stmt, ":cphone2", $cphone2);
		oci_execute($stmt);
	}
		
	$stmt = oci_parse($conn, "SELECT CUSTOMER_ACCOUNT.ACCOUNT_NUMBER, USERNAME, CD_NUMBER, ISSUE_DATE, VALID_THRU, CVC, PIN, STATUS, FNAME, MNAME, LNAME, STREET, APT_NO, CITY, ZIP, PHONE FROM CUSTOMER_ACCOUNT, CUSTOMER_NAME_SSN, CUSTOMER_ADDRESS, CUSTOMER_PHONE, CREDIT_CARD WHERE CUSTOMER_ACCOUNT.CUSTOMER_SSN = :cssn AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_NAME_SSN.SSN AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_ADDRESS.CUSTOMER_SSN AND CUSTOMER_ACCOUNT.CUSTOMER_SSN = CUSTOMER_PHONE.CUSTOMER_SSN AND CUSTOMER_ACCOUNT.ACCOUNT_NUMBER = CREDIT_CARD.ACCOUNT_NUMBER");
	oci_bind_by_name($stmt, ":cssn", $cssn);
	oci_execute($stmt);
	if ($row=oci_fetch_array($stmt, OCI_BOTH)) {
		echo "<big><b><p>Account created successfully!</p></b></big>\n";
		echo "<big><b><p>Queue for credit card printing:</p></b></big>\n";
		echo "<table><tr><td>Account number: </td><td align='left'>" . $row['ACCOUNT_NUMBER'] . "</td></tr>\n";
		echo "		<tr><td>Card number: </td><td align='left'>" . $row['CD_NUMBER'] . "</td></tr>\n";
		if(!empty($_POST["cmname"])) {
			echo "	<tr><td>Name on card: </td><td align='left'>" . $row['FNAME'] . " " . $row['MNAME'] . " " .  $row['LNAME'] . "</td></tr>\n";
		}
		else {
			echo "	<tr><td>Name on card: </td><td align='left'>" . $row['FNAME'] . " " .  $row['LNAME'] . "</td></tr>\n";
		}
		echo "		<tr><td>Valid from: </td><td align='left'>" . $row['ISSUE_DATE'] . "</td></tr>\n";
		echo "		<tr><td>Expiration date: </td><td align='left'>" . $row['VALID_THRU'] . "</td></tr>\n";
		echo "		<tr><td>CVC: </td><td align='left'>" . $row['CVC'] . "</td></tr>\n";
		echo "		<tr><td>PIN: </td><td align='left'>" . $row['PIN'] . "</td></tr>\n";
		echo "		<tr><td>Username: </td><td align='left'>" . $row['USERNAME'] . "</td></tr>\n";
		echo "		<tr><td>Card status: </td><td align='left'>" . $row['STATUS'] . "</td></tr>\n";	
		if(!empty($_POST["captno"])) {
			echo "	<tr><td>Address: </td><td align='left'>" . $row['STREET'] . " " . $row['APT_NO'] . " " .  $row['CITY'] . " " .  $row['ZIP'] . "</td></tr>\n";
		}
		else {
			echo "	<tr><td>Address: </td><td align='left'>" . $row['STREET'] . " " .  $row['CITY'] . " " .  $row['ZIP'] . "</td></tr>\n";
		}
		echo "		<tr><td>Phone: </td><td align='left'>" . $row['PHONE'] . "</td></tr></table>\n";
		echo "<p></p>";
	}
	else {
		echo "<big><b><p>Error! Account not created!</p></b></big>\n";
	}

	oci_free_statement($stmt);
	oci_close($conn);

	echo "<p></p>";
	echo "<form method='post' action='AccountManagement.php'>\n";
	echo "<input type='submit' name='submit' value='Back to Account Management'>\n";
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