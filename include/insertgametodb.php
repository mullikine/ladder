<?php

include_once("quicksort.php");

echo "<h2>Results Submitted</h2>";
echo "<ul>Results:";
echo "<ul class='validresults'>Making sure results are valid.";
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

/* check to see if all the players are members */
/*
for ($i = 0; $i < count($players); $i++) {
	$query = "SELECT COUNT(*) FROM players WHERE gr_id='".$players[$i][0]."' AND ismember='1';";
	$result = mysql_query($query) or die(mysql_error());
	$result = mysql_result($result, 0);
	if ($result == 0) {
		echo "At least one of those players is not a member.";
		exit(0);
	}
}*/

/* check to see if all the players are activated for open tournament */

for ($i = 0; $i < count($players); $i++) {
	$query = "SELECT COUNT(*) FROM players WHERE gr_id='".$players[$i][0]."' AND open_activated='1';";
	$result = mysql_query($query) or die(mysql_error());
	$result = mysql_result($result, 0);
	if ($result == 0) {
		echo "<li>At least one of those players is not signed up.</li>";
		exit(0);
	}
}

/* check to see if there are any duplicates */

$players = quicksort($players,0);

$lastid = 0;
for ($i = 0; $i < count($players); $i++) {
	if ($players[$i][0] == $lastid) {
		echo "<li>There are duplicate entries for players.</li>";
		exit(0);
	}
	$lastid = $players[$i][0];
}

/* check to see if teams are equal */

$t1 = 0;
$t2 = 0;

for ($i = 0; $i < count($players); $i++) {
	if ($players[$i][1] == 1) {
		$t1++;
	} else {
		$t2++;
	}
}

if ($t1 != $t2) {
	echo "<li>$t1 v $t2 - Those teams are not equal.</li>";
	exit(0);
}
echo "</ul>";

/* insert game to database */
echo "<li>Inserting into database.</li>";
$players = quicksort($players,1);

/* ********** GLOBAL VARIABLE ********** */
$properties = "";
$values = "";

for ($i = 0; $i < count($players); $i++) {
	$properties .= "p".($i + 1).", ";
	$values .= "'".$players[$i][0]."', ";
}
for ($i = 0; $i < count($players) - 1; $i++) {
	$properties .= "p".($i + 1)."team, ";
	$values .= "'".$players[$i][1]."', ";
}
$properties .= "p".($i + 1)."team";
$values .= "'".$players[$i][1]."'";

$query = "INSERT INTO games (ladder, teamwon, ".$properties.") VALUES('".$ladder."','".$teamwon."',".$values.");";
$result = mysql_query($query) or die(mysql_error());

/* check to see which members are not in the particular ladder yet */
/* put them in with defaults */
echo "<ul>Checking which members are not in the ladder.";

for ($i = 0; $i < count($players); $i++) {
	echo "<li>Checking player $i.</li>";
	$query = "SELECT COUNT(*) FROM stats WHERE gr_id='".$players[$i][0]."' AND ladder='$ladder';";
	$result = mysql_query($query) or die(mysql_error());
	$result = mysql_result($result, 0);
	if ($result == 0) {
		
		/* put this player into stats with default settings */
		echo "<li>Player is new, gets 1600 points.</li>";
		$query = "INSERT INTO stats (ladder, gr_id, rank) VALUES('".$ladder."',
'".$players[$i][0]."','1600');";
$result = mysql_query($query) or die(mysql_error());
		
	}
	
	/* if ladder is a sub ladder, also insert stats into super ladder */
	if ($laddertype == 0) {
		echo "<li>Putting results into greater ladder.</li>";
		$query = "SELECT COUNT(*) FROM stats WHERE gr_id='".$players[$i][0]."' AND ladder='$unisonladder';";
		$result = mysql_query($query) or die(mysql_error());
		$result = mysql_result($result, 0);
		if ($result == 0) {
			
			/* put this player into stats with default settings */
			$query = "INSERT INTO stats (ladder, gr_id, rank) VALUES('".$unisonladder."',
'".$players[$i][0]."','1600');";
$result = mysql_query($query) or die(mysql_error());
		
		}
	}
}
echo "</ul></ul>";
?>