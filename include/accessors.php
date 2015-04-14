<?php

require_once('connect_db.php');

$clans = getclans();
function getclans() {

	$clans = array();
	$query = "SELECT name, insignia FROM clans";
	$result = mysql_query($query) or die(mysql_error());
	while($clanrow = mysql_fetch_array($result)) {
		$clans[] = $clanrow;
	}
	
	return $clans;
}

?>