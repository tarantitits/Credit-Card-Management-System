<!DOCTYPE html>
<html>
<head><title> Customer Login Page </title></head>
<body>
<h1>Customer Login</h1>
<form method="post" action="VerifyCustomerLogin.php">
<p>Username <input type="text" name="cusername" /></p>
<p>Password <input type="password" name="cpassword" /></p>
<input type = "reset" name = "reset" value = "Reset" />
<input type = "hidden" name = "action" value = "login" />
<input type = "submit" value = "Login" />
</form>
</body>
</html>