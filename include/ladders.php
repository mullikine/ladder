<?php
include_once('siteinfo.php');
?>
  <div id="page"><div id="title">
  Ladder Overview
  </div>
  <table class="clear" cellpadding="0" cellspacing="0">
  <thead>
  <tr>
  <th>Ladder</th>
  <th class='noprint' style='display:none'></th>
  <th class="min">Number of Players</th>
  <th class="max"># Players</th>
  <!--<th class="min">N Matches</th>
  <th class="max"># Matches</th>-->
  <th>Top Player</th>
  <th>Score</th>
  <th class="min">Current Status</th>
  <th class="max">Status</th>
  </tr>
  </thead>
  <tbody>
  <?php

  /* algorithm:
     select ladders with no parent - sort by name =>
     for each child... {
     
     }
  */

  function echo_ladders(&$ladders,$depth,&$tablerows,$maintenance,&$clans) {
  while($laddersrow = mysql_fetch_array($ladders)) {
    $status = $laddersrow['status'];
    $identifier = $laddersrow['identifier'];

    $query = 'SELECT * FROM stats WHERE ladder=\''.$laddersrow['id'].'\' ORDER BY rank DESC;';
    $stats = mysql_query($query) or die(mysql_error());
    $nplayers = mysql_num_rows($stats);
  
    $laddername = (($depth > 0)?'<img src="images/Expand.png" width="1em" style="margin-left:'.($depth - 1).'em" />':'').$laddersrow['name'];
    	
    if (($nplayers) == 0) {
      $nplayers = "&nbsp;";
      $nmatches = "kjdghfkjlsdfljkds";
      $toprank = "&nbsp;";
      $topplayername = "&nbsp;";
      $toprank = "&nbsp;";
    } else {
      $topplayer = mysql_fetch_array($stats);

      $query = "SELECT * FROM players WHERE gr_id='{$topplayer['gr_id']}';";
      $topplayers = mysql_query($query) or die(mysql_error());
      $topplayersrow = mysql_fetch_array($topplayers);
      $topplayername = $topplayersrow['names'];
      if ($topplayersrow['clan']) {
	$topplayername = $clans[$topplayersrow['clan'] - 1][1].$topplayername;
      }
		
      $toprank = $topplayer['rank'];
      $topgrid = $topplayer['gr_id'];
      $topplayername = "<img class='playericon' src='http://www.gameranger.com/icon.cgi?$topgrid' height='1em' />".$topplayername;
		
      $query = "SELECT * FROM stats WHERE ladder='{$laddersrow['id']}' AND rank='$toprank';";
      $topstats = mysql_query($query) or die(mysql_error());
		
      if (mysql_num_rows($topstats) > 1) {
	$topplayername = "<img src='images/levels-together.png' width='1em' />Tie";
	$topplayertd =" style='font-style:italic;'";
      } else {
	$topplayertd = '';/*" class='link'";*/
      }
		
    }
    $laddername.= ' '.$identifier;
	
    if ($status == 5) {
      $maxstatus = "<span style='color:#999;'>Over</span>";
      $minstatus = "<span style='color:#999;'>Over</span>";
    } elseif ($maintenance) {
      $maxstatus = "<img src='images/phone.png' width='1em' />On hold";
      $minstatus = "<img src='images/phone.png' width='1em' />Oh hold";		
    } else {
      switch ($status) {
      case 1:
      if (($nplayers) == 0) {
	$maxstatus = "<!--<img src='images/cut.png' width='1em' />-->&nbsp;";
	$minstatus = "<!--<img src='images/cut.png' width='1em' />-->&nbsp;";
      } else {
	$maxstatus = "<!--<img src='images/Run16.png' width='1em' />-->On";
	$minstatus = "<!--<img src='images/Run16.png' width='1em' />-->On";
      }
      break;
      case 2:
      $maxstatus = "<img src='images/target_red.png' width='1em' />Run-in</span>";
      $minstatus = "<img src='images/target_red.png' width='1em' />Run-in / Practice</span>";
      break;
      default:
      $maxstatus = "<span style='color:purple;'>Unknown status</span>";
      $minstatus = "<span style='color:purple;'>Unknown status</span>";
      }
    }
    if (!$maintenance && $status !=5) {
      $submiticon = "<img class='link' onclick='gosubmitmatch({$laddersrow['id']});' src='images/Report a Match.png' title='Report match' width='16' />";
      $submiticon = '';
    } else {
      $submiticon = '';
    }
    /* if ($status != 5) { */
    $tablerows .= "<tr><td class='link' onclick='loadLadder({$laddersrow['id']});'>$laddername</td><td class='noprint' style='display:none'><img class='link' onclick='loadLadder({$laddersrow['id']});' src='images/open-icon.png' title='View stats' width='16' />$submiticon</td><td class='min'>$nplayers</td><td class='max'>$nplayers</td><td$topplayertd>$topplayername</td><td>$toprank</td><td class='min'>$minstatus</td><td class='max'>$maxstatus</td></tr>";
    /* } */

    /* recursively traverse children */

    $query = 'SELECT * FROM ladders WHERE unisonladder=\''.$laddersrow['id'].'\';';
    $subladders = mysql_query($query) or die(mysql_error());
    echo_ladders($subladders,$depth+1,$tablerows,$maintenance,$clans);

  }
  
}


$query = "SELECT * FROM ladders WHERE unisonladder IS NULL ORDER BY listorder;"; //  AND status!='5'
$ladders = mysql_query($query) or die(mysql_error());

$tablerows='';
echo_ladders($ladders,0,$tablerows,$maintenance,$clans);

echo $tablerows;
?>
</tbody>
</table>
<div class="textbox" style="display:none">
  <p class='noprint'>Click on the name of a ladder to get detailed statistics for that ladder.</p>
  <p class='noprint'><a href="include/rebuildStats.php" title="Calculate all stats from scratch.">Recalculate</a> statistics.
  </div>
  </div>