<?php
session_start();
include_once('siteinfo.php');

function removecommas($strinput) {
	return str_replace(',', '', $strinput);
}

$_POST=array_map('removecommas',$_POST);
$_POST=array_map('mysql_real_escape_string',$_POST);

$loginname = $_POST['name'];
$password = $_POST['password'];

$rating = 1600;

function success($caption) {
	echo "1,$loginname,{$_SESSION['grname']},$rating,$caption,{$_SESSION['grid']}";

	/* update all scripts to close database when done 
	mysql_close($conn);*/
	
	exit(0);
}

function failure($caption) {
	echo "0,$loginname,{$_SESSION['grname']},$rating,$caption,{$_SESSION['grid']}";

	/* update all scripts to close database when done 
	mysql_close($conn);*/
	
	exit(0);
}

if ($loginname != "" && $password != "") {
	$query = "SELECT * FROM players WHERE accountname='$loginname' AND password='$password';";
	$result = mysql_query($query) or die(mysql_error());
	
	$entries = mysql_num_rows($result);
	
	if ($entries == 0) {
		failure("No match for name and password.");
	} else {
		$row = mysql_fetch_array($result);
		
		$_SESSION['loginname'] = $loginname;
		$_SESSION['password'] = $password;
		$_SESSION['grname'] = $row['names'];
		$_SESSION['grid'] = $row['gr_id'];
		session_write_close();
		success("Name and password match found.");
	}
} else {
	failure("You haven't filled out all the required fields.");
}

?>