<?php
require_once('connect_db.php');
require_once('accessors.php');

$query = "SELECT * FROM ladders ORDER BY `id` ASC";
$sql_ladders = mysql_query($query) or die(mysql_error());
$ladders = array();
while($row = mysql_fetch_array($sql_ladders)) {
	$ladderrow = array();
	$ladderrow[] = $row['name'];
	$ladderrow[] = $row['status'];
	$ladderrow[] = $row['laddertype'];
	$ladderrow[] = $row['unisonladder'];
	$ladders[$row['id']] = $ladderrow;
}

$query = "SELECT * FROM games ORDER BY `time` DESC";
$result = mysql_query($query) or die(mysql_error());
$nmatches = mysql_num_rows($result);

if ($nmatches > 0) {
?>
<div id="title">
Some Recent Matches
</div><div id="titlefade"><div class="whitetopblend"></div></div>
<div id="page">
<table class="clear" cellpadding="0" cellspacing="0" id="gamestable" class="sortable" style="width:100%;">
	<thead>
		<tr>
			<th>Day</th>
			<th>Ladder</th>
			<th>Winners</th>
			<th>Losers</th>
		</tr>
	</thead>
	<tbody>	
<?php
while($row = mysql_fetch_array($result)) {
	if ($ladders[$row['ladder']][2] == 0) {
		$status = $ladders[$ladders[$row['ladder']][3]][1];
	} else {
		$status = $ladders[$row['ladder']][1];
	}
	if ($status != 5) {	
		$nwinners = 0;
		$nlosers = 0;
		$winners = '<ul>';
		$losers = '<ul>';
		for ($i = 1; $i <= 8; $i++) {
			if ($row['p'.$i] == '') {
			} else {
				$query = "SELECT * FROM players WHERE gr_id='".$row['p'.$i]."'";
				$result2 = mysql_query($query) or die(mysql_error());
				$playerrow = mysql_fetch_array($result2);
				$playername = $playerrow['names'];
				$playerid = $playerrow['gr_id'];
				if ($playerrow['clan']) {
					$playername = $clans[$playerrow['clan'] - 1][1].$playername;
				}
				$playerentry = "<img class='playericon' src='http://www.gameranger.com/icon.cgi?$playerid' height='1em' />$playername<br />";
				if ($row['p'.$i.'team'] != $row['teamwon']) {
					$losers .= "<li>$playerentry</li>";
					$nlosers++;
				} else {
					$winners .= "<li>$playerentry</li>";
					$nwinners++;
				}
			}
		}
		$winners .= '</ul>';
		$losers .= '</ul>';
		$phpdate = strtotime( $row['time'] );
		$time = date( 'd M \'y', $phpdate );/*  H:i:s */
		
		if ($nwinners + $nlosers > 2) {
			$ladderinfo = '<ul><li>'.$ladders[$row['ladder']][0].'</li><li>'.$nwinners.'v'.$nlosers.'</li></ul>';
		} else {
			$ladderinfo = $ladders[$row['ladder']][0];
		}
		echo ("<tr><td>".$time."</td><td>$ladderinfo</td><td>".$winners."</td><td>".$losers."</td></tr>");
	}
}
?>
	</tbody>
</table>
</div>
<?php
} else {
?>
<div id="title">
Matches Played So Far
</div><div id="titlefade"><div class="whitetopblend"></div></div>
<div id="page">
<p>This area usually shows which matches have been played. No games have been reported yet.</p>
</div>
<?php
}
?>