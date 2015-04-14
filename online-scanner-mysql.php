<?php

include('askfilesize.php');

$testsize=55220;
$onlinesize = 2247;
$offlinesize = 1051;
$nopremiumiconsize = 574;
$nopremiumiconsize = 173;

// Specify the username/password to use, or leave blank for no auth
$user = NULL;
$password = NULL;

$location = "http://www.gameranger.com/indicator.cgi?";
//$location = "http://www.grbash.com/gr/ani_on_off.php?id=";
$testlocation = "http://localhost/aoesite/indicator.php?";
$iconlocation = "http://www.gameranger.com/icon.cgi?";
$testiconlocation = "http://localhost/aoesite/icon.cgi?";

//$location = $testlocation;
//$onlinesize = $testsize;


echo "========\nOLPLAYERS.PHP IS RUNNING\n========\n";


include('connect_db.php');

do {
  $size = NULL;
  $updates = 0;

  $ts = time();
  $nonline = 0;

  $query = "SELECT * FROM players WHERE ismember='1';";
  $result = mysql_query($query) or die(mysql_error());
  $tplayers = mysql_num_rows($result);
  while($row = mysql_fetch_array($result)) {
    $temprow = array();
    echo "player: ".$row[3]."\n";
    $gr_id=$row[2];
    $size = getimgsize($location.$gr_id);
    $size2 = getimgsize($iconlocation.$gr_id);
    if ($size2 == $nopremiumiconsize) {
      $ispremium = 0;
    } else {
      $ispremium = 1;
      echo "  is premium\n";
    }
    $query = "UPDATE players SET gotpremium = '$ispremium' WHERE id='".$row[0]."'";
    mysql_query($query) or die(mysql_error());
    if ($size == $onlinesize) {
      echo "  is online\n";
      $query = "UPDATE players SET isonline = '1' WHERE id='".$row[0]."'";
      mysql_query($query) or die(mysql_error());
      $nonline++;
    } else {
      echo "  is offline\n";
      if ($row[7] == 1) {
        $query = "UPDATE players SET timeoffline = '".time()."' WHERE id='".$row[0]."'";
        mysql_query($query) or die(mysql_error());
      }
      $query = "UPDATE players SET isonline = '0' WHERE id='".$row[0]."'";
      mysql_query($query) or die(mysql_error());
    }
  }

  $ts = round((time() + $ts)/2, 0);

  $newhour = 0;
  $query = "SELECT * FROM availability WHERE hourly='1' ORDER BY time DESC;";
  $result = mysql_query($query) or die(mysql_error());
  $thours = mysql_num_rows($result);
  if ($thours == 0) {
    $newhour = 1;
  }

  $query = "SELECT * FROM availability ORDER BY time DESC;";
  $result = mysql_query($query) or die(mysql_error());

  while($row = mysql_fetch_array($result) && $newhour == 0) {
    if (($ts - $row['time']) > 60 * 60) {
      $newhour = 1;
    }
  }

  $query = "INSERT INTO availability (nplayers, time, tplayers, hourly) VALUES('".$nonline."','".$ts."','".$tplayers."','".$newhour."');";
  $result = mysql_query($query) or die(mysql_error());
  echo "Availability updated.\n";

  sleep(20); //2 second sleep (dont update too fast);
} while(true);

?>
