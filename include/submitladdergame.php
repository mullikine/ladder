<?php

include("connect_db.php");

$_POST=array_map("mysql_real_escape_string",$_POST);

/* if ($_POST['moderatorpw'] != "test") {
	echo "Wrong password.";
	exit(0);
} */

$ladder = $_POST['Ladder'];
$teamwon = $_POST['Winners'];
$grid = array();
$grid[] = $_POST['Player1grid'];
$grid[] = $_POST['Player2grid'];
$grid[] = $_POST['Player3grid'];
$grid[] = $_POST['Player4grid'];
$grid[] = $_POST['Player5grid'];
$grid[] = $_POST['Player6grid'];
$grid[] = $_POST['Player7grid'];
$grid[] = $_POST['Player8grid'];
$team = array();
$team[] = $_POST['Player1Team'];
$team[] = $_POST['Player2Team'];
$team[] = $_POST['Player3Team'];
$team[] = $_POST['Player4Team'];
$team[] = $_POST['Player5Team'];
$team[] = $_POST['Player6Team'];
$team[] = $_POST['Player7Team'];
$team[] = $_POST['Player8Team'];

$players = array();
for ($i = 0; $i < count($grid); $i++) {
	if ($grid[$i] > 0) {
		$row = array();
		$row[] = $grid[$i];
		$row[] = $team[$i];
		$players[] = $row;
	}
}

$query_ladders = "SELECT * FROM ladders WHERE id='$ladder';";
$sql_ladders = mysql_query($query_ladders) or die(mysql_error());
while($row_ladder = mysql_fetch_array($sql_ladders)) {
	$laddertype = $row_ladder['laddertype'];
	$unisonladder = $row_ladder['unisonladder'];
}

$insertgame = 1;

include("insertgametodb.php");
include("updatestats.php");

?>