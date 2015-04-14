<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="../style/register.css" media="screen" />
	<script type="text/javascript" src="../js/jquery-1.4.min.js"></script>
	<script type="text/javascript" src="../js/jquery.color.js"></script>
	<script type="text/javascript" src="../js/jquery-fonteffect-1.0.0.min.js"></script>
	<script type="text/javascript" src="../js/dom.js"></script>
	<script type="text/javascript" src="../js/register.js"></script>
</head>
<body>
<h2>New registration</h2>
<form id="regform" action="register.php" method="post">
<fieldset>
<legend align="top">
Max length 8 characters
</legend>
<input name="loginname" id="loginname" type="text" maxlength="8" />
<label for="loginname">
Login Name
</label>
</fieldset>
<fieldset>
<legend align="top">
Max length 20 characters
</legend>
<input name="grname" id="grname" type="text" maxlength="20" />
<label for="grname">
GameRanger Name
</label>
</fieldset>
<fieldset>
<legend align="top">
Max length 10 digits
</legend>
<input name="grid" id="grid" type="text" maxlength="10" />
<label for="grid">
GameRanger ID
</label>
</fieldset>
<fieldset>
<legend align="top">

</legend>
<input name="email" id="email" type="text" maxlength="20" />
<label for="email">
Email address
</label>
</fieldset>
<fieldset>
<legend align="top">
Max length 8 characters
</legend>
<input name="password" id="password" type="password" maxlength="8" />
<label for="password">
Password
</label>
</fieldset>
<fieldset>
<legend align="top">
Same as above
</legend>
<input name="password_verify" id="password_verify" type="password" maxlength="8" />
<label for="password_verify">
Retype password
</label>
</fieldset>
<fieldset>
<input style="display:none" type="reset" value="Erase form" />
<input id="submitreg" type="submit" value="Submit registration!" />
</fieldset>
</form>
</body>
</html>
