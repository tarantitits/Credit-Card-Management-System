
<?php

require "config.php";
$err=0;
$susername=$_POST["susername"];
$spassword=$_POST["spassword"];
$conn = oci_connect("System", "root", "localhost");
	
$stmt = oci_parse($conn, "SELECT NAME FROM STAFF, STAFF_NAME_SSN WHERE (STAFF.USERNAME = :susername) AND (STAFF.PASSWORD = :spassword) AND (STAFF.SSN = STAFF_NAME_SSN.SSN)");
oci_bind_by_name($stmt, ":susername", $susername);
oci_bind_by_name($stmt, ":spassword", $spassword);
oci_define_by_name($stmt, "NAME", $staffname);
oci_execute($stmt);
if (oci_fetch($stmt)) {
	echo "<p>Welcome back, $staffname.</p>\n";
	echo "<p><a href='AccountManagement.php'>Account Management</a></p>\n";
}
else {
	echo "<p>Username and password combination is not valid.</p>\n";
	++$err;
}

?>
