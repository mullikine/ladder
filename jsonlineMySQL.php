<?php

include_once("./quicksort.php");

include('connect_db.php');

$dbname = 'ladder';
mysql_select_db($dbname);

$onlinesize = 2247;
$offlinesize = 1051;

$temp = "";


$players = array();
$query = "SELECT * FROM players WHERE isonline='1';";
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)) {
	$temprow = array();
	$temprow[] = $row[1];
	$temprow[] = $row[2];
	$players[] = $temprow;
}

$players = quicksort($players, 0);

$query = "SELECT * FROM players WHERE isonline='0' AND timeoffline>'".(time() - 60 * 60)."';";
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)) {
	$temprow = array();
	$temprow[] = $row[1] . " (offline)";
	$temprow[] = $row[2];
	$players[] = $temprow;
}

echo "<div class='data' cellspacing='0' cellpadding='0'>";
for ($i = 1; $i <= 8; $i++) {
	echo ("<div class='row requiredRow' title='This is a required field'>\n");
	/*echo ("<label for='Player".$i."grid'>".$i."</label>\n");*/
	echo ("<select id='Player".$i."grid' name='Player".$i."grid' class='required'>\n");
	
	echo ("<option value='-1'>-</option>");
		
	for ($j = 0;$j < count($players);$j++) {
		if ($i == ($j + 1)) {
			$selected = "selected='selected' ";
		} else {
			$selected = "";
		}
		echo ("<option ".$selected."value='".$players[$j][1]."'>".$players[$j][0]."</option>\n");
	}
	echo ("</select> <select id='Player".$i."Team' name='Player".$i."Team' class='required'><option value='1'>Team 1</option><option value='2'>Team 2</option></select>\n</div>\n");
}
echo "</div>";

/* update all scripts to close database when done */
mysql_close($conn);
?>