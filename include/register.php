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
GameRanger ID Number
</label>
</fieldset>
<fieldset>
<legend align="top">
Max length 8 characters
</legend>
<input name="password" id="password" type="text" maxlength="8" />
<label for="password">
Password
</label>
</fieldset>
<input style="display:none" type="reset" value="Erase form" />
<input id="submitreg" type="submit" value="Submit registration!" />
</form>

<?php
/*
switch ($_SESSION['section']) {
case 0:
	if (isset($_SESSION['area'])) {
		if (isset($_SESSION['learninglevel'])) {
			
			include('db_connect.php');
			
			$query = "SELECT * FROM learningareas WHERE id = '{$_SESSION['area']}'";
			$result = mysql_query($query) or die(mysql_error());
			$row = mysql_fetch_array($result);
			$laname = ucwords($row['name']);
			
			mysql_close($conn);
			
			echo "<p style='font-size:smaller'>You are currently in level {$_SESSION['learninglevel']} $laname.</p><p style='font-size:smaller'>Click on a strand and then an objective to refine your search.</p>";
			if ($_SESSION['learninglevel'] > 5) {
				echo "<p>Click on an NCEA standard to see material that relates directly to that standard.</p>";
			}
		} else {
		echo "<h2>Step 2</h2>Choose a learning level from one of the blue buttons inside that coloured box on your left that links most closely to the class that you're planning for today.<br /><br /><p style='font-size:smaller'>Each learning level button will take you to a page that will display all relevant material that has been uploaded and a way of dynamically searching for what you want.</p>";
		}
	} else {
		echo "<h2>Step 1</h2>Click on a learning area - one of the coloured buttons on the left of the screen.<br /><br /><h4>From anywhere on this website you can:</h3><ul style='font-size:smaller'><li>Click on the suitcase to find staff presentation material.</li><li>Click on the TMPL8 button to find documents that will help you layout your plans.</li><li>Email us with your questions and ideas.</li></ul>";
	}
	
	break;
	
case 1:
	if (isset($_SESSION['area'])) {
		if (isset($_SESSION['learninglevel'])) {
			echo "You have selected a learning level, now you can upload and download documents to this learning level.";
		} else {
			echo "You have selected a learning area, now please choose a learning level.";
		}
	} else {
		echo "<h2>Step 1</h2>Staff meetings have traditionally been boring so click on the Teaching Area you want to discuss with other staff members, or one of the headings in the centre of this page to find what other teachers have talked about.";
	}
	
	break;
case 5:
	echo "This is a powerpoint presentation...";
	break;
default:
	echo "Section: ".$_SESSION['section']; 
	echo "<br />Area: ".$_SESSION['area'];
	echo "<br />LL: ".$_SESSION['learninglevel'];
}
*/
?>
</body>
</html>
