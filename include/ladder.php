<?php

	include_once('string_functions.php');
	
	$query = "SELECT * FROM ladders WHERE id='{$_GET['ladder']}'";
	$result = mysql_query($query) or die(mysql_error());
	$ladder = mysql_fetch_array($result);
	
	$status = $ladder['status'];
	$laddertype = $ladder['laddertype'];
	
	$h2 = $ladder['name'];
	
	if ($status == -1) {
		$query = "SELECT * FROM ladders WHERE id='{$ladder['unisonladder']}';";
		$unisonladder = mysql_query($query) or die(mysql_error());
		$unisonladderrow = mysql_fetch_array($unisonladder);
		$status = $unisonladderrow['status'];
		$identifier = $unisonladderrow['identifier'];
	} else {
		$identifier = $ladder['identifier'];
	}
	
	if ($identifier != NULL)
		$h2 .= ' '.$identifier;
	
	echo "<div id=\"title\">$h2</div><div id=\"titlefade\"><div class=\"whitetopblend\"></div></div><div id=\"page\"><div class='textbox'><h3>Rules</h3>";
	if (!$maintenance) {
		/*echo "<a href='javascript: return' id='reportgame'>Submit a game to this ladder</a>";*/
	}

	if ($ladder['rules'] != NULL) echo $ladder['rules'];
	echo "</div>";
	
		
	$query = "SELECT * FROM stats WHERE ladder='{$ladder['id']}' ORDER BY rank DESC;";
	$stats = mysql_query($query) or die(mysql_error());
	$stattrs = '';
	$nstats = mysql_num_rows($stats);
	$place = 0;
	$actualplace = 0;
	$previousrank = NULL;
	if ($nstats > 0) {
		while($statrow = mysql_fetch_array($stats)) {
			$actualplace++;
			if ($previousrank != $statrow['rank']) {
				$place = $actualplace;
				$strplace = ordinal_suffix($place, 0);
			} else {
				$strplace = ordinal_suffix($place, 0).' equal';
			}
			$previousrank = $statrow['rank'];
			$query = "SELECT * FROM players WHERE gr_id='".$statrow['gr_id']."'";
			$result = mysql_query($query) or die(mysql_error());
			$playerrow = mysql_fetch_array($result);
			$playername = $playerrow['names'];
			if ($playerrow['clan']) {
				$playername = $clans[$playerrow['clan'] - 1][1].$playername;
			}
			if ($statrow['ngames'] > 0) {
				$ngameslost = $statrow['ngames'] - $statrow['ngameswon'];
				$winaverage = intval(($statrow['ngameswon'] / $statrow['ngames']) * 100)."%";
				$rewardaverage = intval(($statrow['rank'] - 1600) / $statrow['ngames']).' points';
				if ($statrow['ngameswon'] > 0) {
					$gainaverage = intval($statrow['pointswon'] / $statrow['ngameswon']).' points';
				} else {
					$gainaverage = 'Never won';
				}
				if ($ngameslost > 0) {
					$lostaverage = intval(($statrow['rank'] - 1600 - $statrow['pointswon']) / $ngameslost).' points';
				} else {
					$lostaverage = 'Unbeaten';
				}
			} else {
				$winaverage = 'NaN';
				$rewardaverage = 'NaN';
			}
			$stattrs .= "<tr><td>$strplace</td><td><img class='playericon' src='http://www.gameranger.com/icon.cgi?{$statrow['gr_id']}' height='1em' />$playername</td><td>{$statrow['rank']}</td><td>$winaverage</td><td>$gainaverage</td><td>$lostaverage</td></tr>";
		}
		
?>
<h3>Current standings</h3>
<table class="colored" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th></th>
			<th>Name</th>
			<th>Rank</th>
			<th>Success Rate</th>
			<th>Average Earnings</th>
			<th>Average Loss</th>
		</tr>
	</thead>
	<tbody>
<?php echo $stattrs; ?>
	</tbody>
</table>
<?php
	} else {
		echo "<p>No games have been played yet, so no statistics are available.</p>";
	}
	if ($laddertype == 2) {
		
		$subquery = '';
		$query = "SELECT * FROM ladders WHERE unisonladder='{$ladder['id']}';";
		$subladders = mysql_query($query) or die(mysql_error());
		$subladderrow = mysql_fetch_array($subladders);
		$subquery .= "ladder='{$subladderrow['id']}'";
		while($subladderrow = mysql_fetch_array($subladders)) {
			$subquery .= " OR ladder='{$subladderrow['id']}'";
		}
		$query = $subquery;
	} else {
		$query = "ladder='{$ladder['id']}'";
	}
	
	$query = "SELECT * FROM games WHERE $query ORDER BY time DESC;";
	$games = mysql_query($query) or die(mysql_error());
	$gametrs = '';
	$ngames = mysql_num_rows($games);
	if ($ngames > 0) {
		while($gamerow = mysql_fetch_array($games)) {

			$nwinners = 0;
			$nlosers = 0;
			$winners = '<ul>';
			$losers = '<ul>';
			for ($i = 1; $i <= 8; $i++) {
				if ($gamerow['p'.$i] == '') {
				} else {
					$query = "SELECT * FROM players WHERE gr_id='".$gamerow['p'.$i]."'";
					$result = mysql_query($query) or die(mysql_error());
					$playerrow = mysql_fetch_array($result);
					$playername = $playerrow['names'];
					$playerid = $playerrow['gr_id'];
					if ($playerrow['clan']) {
						$playername = $clans[$playerrow['clan'] - 1][1].$playername;
					}
					$playerentry = "<img class='playericon' src='http://www.gameranger.com/icon.cgi?$playerid' height='1em' />$playername<br />";
					if ($gamerow['p'.$i.'team'] != $gamerow['teamwon']) {
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
			
			$phpdate = strtotime( $gamerow['time'] );
			$time = date( 'd M \'y', $phpdate );/*  H:i:s */
			
			if ($nwinners + $nlosers > 2) {
				$ladderinfo = '<ul><li>'.$time.'</li><li>'.$nwinners.'v'.$nlosers.'</li></ul>';
			} else {
				$ladderinfo = $time;
			}
			
			$gametrs .= "<tr><td>".$ladderinfo."</td><td>".$winners."</td><td>".$losers."</td></tr>";
		}
		
?>
<h3>Match results</h3>
<table class="colored" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th>Day</th>
			<th>Winners</th>
			<th>Losers</th>
		</tr>
	</thead>
	<tbody>
<?php echo $gametrs; ?>
	</tbody>
</table></div>
<?php
	} else {
	}
?>