<!DOCTYPE html>
<html>
<head><title> New Accounts Page </title></head>
<body>
<h1>New Account Request</h1>
<form method="post" action="VerifyInitCData.php">
<h3><p>Applicant Details: </p></h3>
<table>
	<tr><td>
		First Name
		</td>
		<td align="right">
			<input type="text" name="efname" />
		</td>
	</tr>
	<tr><td>
		Middle Name
		</td>
		<td align="right">
			<input type="text" name="emname" />
		</td>
	</tr>
	<tr><td>
		Last Name
		</td>
		<td align="right">
			<input type="text" name="elname" />
		</td>
	</tr>
</table>
<h3><p>Applicant Address: </p></h3>
<table>
	<tr><td>
		Street
		</td>
		<td align="right">
			<input type="text" name="estreet" />
		</td>
	</tr>
	<tr><td>
		Apt. No.
		</td>
		<td align="right">
			<input type="text" name="eaptno" />
		</td>
	</tr>
	<tr><td>
		City
		</td>
		<td align="right">
			<input type="text" name="ecity" />
		</td>
	</tr>
	<tr><td>
		Zip
		</td>
		<td align="right">
			<input type="text" name="ezip" />
		</td>
	</tr>
</table>
<h3><p>Applicant Phone: </p></h3>
<table>
	<tr><td>
		Phone1
		</td>
		<td align="right">
			<input type="text" name="ephone1" />
		</td>
	</tr>
	<tr><td>
		Phone2
		</td>
		<td align="right">
			<input type="text" name="ephone2" />
		</td>
	</tr>
</table>
<input type = "reset" name = "reset" value = "Reset" />
<input type = "submit" name = "submit" value = "Verify" />
</form>
</body>
</html>