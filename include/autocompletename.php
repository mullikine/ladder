<?php
require_once('siteinfo.php');

$clans = getclans();

// Is there a posted query string?
if(isset($_POST ['queryString'])) {
	$queryString = mysql_real_escape_string($_POST['queryString']);
	// Is the string length greater than 0?
	
	if(strlen($queryString) >0) {
		// Run the query: We use LIKE '$queryString%'
		// The percentage sign is a wild-card, in my example of countries it works like this...
		// $queryString = 'Uni';
		// Returned data = 'United States, United Kindom';
		
		// YOU NEED TO ALTER THE QUERY TO MATCH YOUR DATABASE.
		// eg: SELECT yourColumnName FROM yourTable WHERE yourColumnName LIKE '$queryString%' LIMIT 10
		
		$matchstring = '';
		$query = "SELECT id,insignia FROM clans WHERE name LIKE '%$queryString%' OR  insignia LIKE '%$queryString%' LIMIT 10";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			while($row = mysql_fetch_array($result)) {
				$matchstring .= " OR clan='{$row['id']}'";
			}
			$matchstring = "(names LIKE '%$queryString%' $matchstring)";
		} else {
			$matchstring = "names LIKE '%$queryString%'";
		}
		
		$query = "SELECT names, gr_id, clan FROM players WHERE open_activated='1' AND $matchstring LIMIT 10";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			while($row = mysql_fetch_array($result)) {
				// Format the results, im using <li> for the list, you can change it.
				// The onClick function fills the textbox with the result.
				
				// YOU MUST CHANGE: $result->value to $result->your_colum
				$displayname = $row['names'];
				$dequotedname = str_replace('"','&quot;',$displayname);
				if ($row['clan']) {
					$claninsignia = $clans[$row['clan']-1][1];
					$displayname = $claninsignia.$displayname;
				}
				echo "<li onclick=\"fill('$dequotedname','{$row['gr_id']}');\">$displayname</li>";
			}
		}
	}
} else {
	echo 'There should be no direct access to this script!';
}
?>