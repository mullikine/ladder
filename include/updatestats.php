<?php

echo "<ul>Updating ratings";
/* check to see if the ladder exists */
$query = "SELECT COUNT(*) FROM ladders WHERE id='$ladder';";
$result = mysql_query($query) or die(mysql_error());
if (mysql_result($result, 0) == 0) {
	echo "<li>Ladder doesn't exist.</li>";
	exit(0);
}

/* check to see if there are enough players */

if (!(count($players) >= 2)) {
	echo "<li>There are not enough players.</li>";
	exit(0);
}

/* check to see if teamwon is 1 or 2 */

if ($teamwon != 1 && $teamwon != 2) {
	echo "<li>Team invalid.</li>";
	exit(0);
}

for ($i = 0; $i < count($players); $i++) {
	$query = "SELECT COUNT(*) FROM stats WHERE gr_id='".$players[$i][0]."' AND ladder='$ladder';";
	$result = mysql_query($query) or die(mysql_error());
	$result = mysql_result($result, 0);
	if ($result == 0) {
		
		/* put this player into stats with default settings */
		
		$query = "INSERT INTO stats (ladder, gr_id, rank, pointswon) VALUES('".$ladder."',
'".$players[$i][0]."','1600', '0');";
$result = mysql_query($query) or die(mysql_error());
		
	}
	
	/* if ladder is a sub ladder, also insert stats into super ladder */
	if ($laddertype == 0) {
		$query = "SELECT COUNT(*) FROM stats WHERE gr_id='".$players[$i][0]."' AND ladder='$unisonladder';";
		$result = mysql_query($query) or die(mysql_error());
		$result = mysql_result($result, 0);
		if ($result == 0) {
			
			/* put this player into stats with default settings */
			
			$query = "INSERT INTO stats (ladder, gr_id, rank, pointswon) VALUES('".$unisonladder."',
'".$players[$i][0]."','1600', '0');";
$result = mysql_query($query) or die(mysql_error());
		
		}
	}
}

/* update stats for each player */

$teamrating = array();
$teamrating[] = 0;
$teamrating[] = 0;
$stats = array();
for ($i = 0; $i < count($players); $i++) {
	$query = "SELECT * FROM stats WHERE gr_id='".$players[$i][0]."' AND ladder='$ladder';";
	$result = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($result)) {
		$temprow = array();
		$teamrating[$players[$i][1] - 1] += $row['rank'];
		$temprow[] = $row['rank'];
		$temprow[] = $row['ngames'];
		$temprow[] = $row['ngameswon'];
		$temprow[] = $row['pointswon'];
		$stats[] = $temprow;
	}
}

$diffrating = $teamrating[2 - $teamwon] - $teamrating[$teamwon - 1];

$diffval = 16 + ($diffrating) * (2 / count($players))  *  (16 / 400);
if ($diffval > 31) $diffval = 31;
if ($diffval < 1) $diffval = 1;
echo "<li>Points won/lost: $diffval</li>";
for ($i = 0; $i < count($players); $i++) {
	$query = "UPDATE stats SET rank = '".($players[$i][1]==$teamwon ? $stats[$i][0]+$diffval : $stats[$i][0]-$diffval)."', pointswon = '".($players[$i][1]==$teamwon ? $stats[$i][3]+$diffval : $stats[$i][3])."', ngames = '".($stats[$i][1] + 1)."', ngameswon ='".($players[$i][1]==$teamwon ? $stats[$i][2] + 1 : $stats[$i][2])."' WHERE gr_id = '".$players[$i][0]."' AND ladder='$ladder'";
	mysql_query($query) or die(mysql_error());
}


/* if ladder is a sub ladder, also update stats for the super ladder */

if ($laddertype == 0) {
	echo "<li>Updating greater ladder.</li>";
	$teamrating = array();
	$teamrating[] = 0;
	$teamrating[] = 0;
	$stats = array();
	for ($i = 0; $i < count($players); $i++) {
		$query = "SELECT * FROM stats WHERE gr_id='".$players[$i][0]."' AND ladder='$unisonladder';";
		$result = mysql_query($query) or die(mysql_error());
		while($row = mysql_fetch_array($result)) {
			$temprow = array();
			$teamrating[$players[$i][1] - 1] += $row['rank'];
			$temprow[] = $row['rank'];
			$temprow[] = $row['ngames'];
			$temprow[] = $row['ngameswon'];
			$temprow[] = $row['pointswon'];
			$stats[] = $temprow;
		}
	}
	
	$diffrating = $teamrating[2 - $teamwon] - $teamrating[$teamwon - 1];
	
	$diffval = 16 + ($diffrating) * (2 / count($players))  *  (16 / 400);
	if ($diffval > 31) $diffval = 31;
	if ($diffval < 1) $diffval = 1;
	echo "<li>Points won/lost: $diffval</li>";
	for ($i = 0; $i < count($players); $i++) {
		$query = "UPDATE stats SET rank = '".($players[$i][1]==$teamwon ? $stats[$i][0]+$diffval : $stats[$i][0]-$diffval)."', pointswon = '".($players[$i][1]==$teamwon ? $stats[$i][3]+$diffval : $stats[$i][3])."', ngames = '".($stats[$i][1] + 1)."', ngameswon ='".($players[$i][1]==$teamwon ? $stats[$i][2] + 1 : $stats[$i][2])."' WHERE gr_id = '".$players[$i][0]."' AND ladder='$unisonladder'";
		mysql_query($query) or die(mysql_error());
	}
}

echo "</ul>";

?>