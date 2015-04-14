<?php
include_once('connect_db.php');

// Is there a posted query string?
if(!isset($queryString)) {
	if(isset($_POST['id'])) {
		$queryString = $_POST['id'];
	} else {
		exit(0);
	}
}
	
$query = "SELECT id, name FROM ladders WHERE unisonladder = '$queryString'";
$result = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($result) != 0) {
	$subladders = "<select id='SubLadder' name='SubLadder'>";
	while($row = mysql_fetch_array($result)) {
		$subladders .= "<option value=\"{$row['id']}\">{$row['name']}</li>";
	}
	$subladders .= '</select>';
	echo $subladders;
}
?>