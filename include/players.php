<?php

	require_once('connect_db.php');

	$nplayers = 0;
	$finalhtml = '';

	$query = "SELECT * FROM clans";
	$result = mysql_query($query) or die(mysql_error());
	$nclans = mysql_num_rows($result);
	
	
	$finalhtml .= <<<EOD
		<div id="page"><div id="title">Members of AoK Ladders</div>
EOD;
	
	while($clanrow = mysql_fetch_array($result)) {
	
		$query = "SELECT * FROM players WHERE open_activated='1' AND clan='{$clanrow['id']}'";
		$result2 = mysql_query($query) or die(mysql_error());
		$nplayersinclan = mysql_num_rows($result2);
		$nplayers += $nplayersinclan;
		
		$finalhtml .= <<<EOD
		<table class='playersgroup colored' cellpadding='0' cellspacing='0'>
			<thead>
				<tr>
					<th>{$clanrow['name']}</th>
				</tr>
			</thead>
		<tbody>
EOD;
		
        while($playerrow = mysql_fetch_array($result2)) {
            $playername = $clanrow['insignia'].$playerrow['names'];
			$finalhtml .= "<tr><td><img class='playericon' src='http://www.gameranger.com/icon.cgi?{$playerrow['gr_id']}' height='1em' />$playername</td></tr>";
		}
		$finalhtml .= <<<EOD
		</tbody>
		</table>
EOD;
	}
	
	$query = "SELECT * FROM players WHERE open_activated='1' AND clan IS NULL";
	$result = mysql_query($query) or die(mysql_error());
	$nplayersremaining = mysql_num_rows($result);
	$nplayers += $nplayersremaining;
	
	$finalhtml .= <<<EOD
	<table class='playersgroup colored' cellpadding='0' cellspacing='0'>
		<thead>
			<tr>
				<th>Others</th>
			</tr>
		</thead>
	<tbody>
EOD;

	while($playerrow = mysql_fetch_array($result)) {
		$finalhtml .= "<tr><td><img class='playericon' src='http://www.gameranger.com/icon.cgi?{$playerrow['gr_id']}' height='1em' />{$playerrow['names']}</td></tr>";
	}
	$finalhtml .= <<<EOD
	</tbody>
	</table>
	</div>
EOD;
	/*$finalhtml = "<h2>$nplayers Members</h2>".$finalhtml;*/
	echo $finalhtml;
?>
