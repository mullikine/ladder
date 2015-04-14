<?php


include_once("./quicksort.php");

include('connect_db.php');

/* if ($_GET['moderatorpw'] != "test") {
	echo "Wrong password.";
	exit(0);
} */

$query = "TRUNCATE TABLE stats;";
$result = mysql_query($query) or die(mysql_error());

$query_ladders = "SELECT * FROM ladders;";
$sql_ladders = mysql_query($query_ladders) or die(mysql_error());
echo "<ul>";
while($row_ladder = mysql_fetch_array($sql_ladders)) {
	$ladder = $row_ladder['id'];
	echo "<li>Ladder $ladder";
	$laddertype = $row_ladder['laddertype'];
	$unisonladder = $row_ladder['unisonladder'];
	$query_games = "SELECT * FROM games WHERE ladder='".$ladder."' ORDER BY id;";
	$sql_games = mysql_query($query_games) or die(mysql_error());
	echo "<ul>";
	while($game = mysql_fetch_array($sql_games)) {
		echo "<li>Game {$game['id']}<br />";
		$teamwon = $game['teamwon'];
		$grid = array();
		$grid[] = $game['p1'];
		$grid[] = $game['p2'];
		$grid[] = $game['p3'];
		$grid[] = $game['p4'];
		$grid[] = $game['p5'];
		$grid[] = $game['p6'];
		$grid[] = $game['p7'];
		$grid[] = $game['p8'];
		
		$team = array();
		$team[] = $game['p1team'];
		$team[] = $game['p2team'];
		$team[] = $game['p3team'];
		$team[] = $game['p4team'];
		$team[] = $game['p5team'];
		$team[] = $game['p6team'];
		$team[] = $game['p7team'];
		$team[] = $game['p8team'];
		
		$insertgame = 0;
		
		/* make array of competing players */

		$players = array();
		for ($i = 0; $i < count($grid); $i++) {
			if ($grid[$i] > 0) {
				$row = array();
				$row[] = $grid[$i];
				$row[] = $team[$i];
				$players[] = $row;
			}
		}

		include("updatestats.php");
		echo "</li>";
	}
	echo "</ul></li>";
}

/* update all scripts to close database when done */
mysql_close($conn);

?>