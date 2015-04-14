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
$team = array();
for ($i=1;$i<=8;$i++) {
  $player_grid = 'Player'.$i.'grid';
  $player_team = 'Player'.$i.'Team';

  if (!(isset($_POST[$player_grid]) && isset($_POST[$player_team]))) {
    break;
  }
  $grid[] = $_POST[$player_grid];
  $team[] = $_POST[$player_team];
}

$players = array();
for ($i = 0; $i < count($grid); $i++) {
  if ($grid[$i] > 0) {
    $row = array();
    $row[] = $grid[$i];
    $row[] = $team[$i];
    $players[] = $row;
  }
}

/* $insertgame = 1; */

include("insertgametodb.php");
include("updatestats.php");

echo '<div id="page"><div id="title">Match Submitted</div>';

insert_game($players,$teamwon,$ladder);
update_stats($players, $teamwon, $ladder);

echo '</div>';

?>