<?php

$testsize=55220;
$filemembers = "members.txt";
$filename = "onlinemembers.txt";
$onlinesize = 2247;
$offlinesize = 1051;

// Specify the username/password to use, or leave blank for no auth
$user = NULL;
$password = NULL;

$location = "http://www.gameranger.com/indicator.cgi?";
$testlocation = "http://localhost/aoesite/indicator.php?";

//$location = $testlocation;
//$onlinesize = $testsize;

include("./quicksort.php");

echo "========\nOLPLAYERS.PHP IS RUNNING\n========";

$players = unserialize(file_get_contents($filemembers));
$nodes=NULL;
foreach ($players as $row)
  $nodes[]=$location.$row[1];
$node_count = 2;//count($nodes);
$updates = 0;

do {
  $onlineplayers = NULL;
  $curl_arr = array();
  $master = curl_multi_init();

  for($i=0;$i<$node_count;$i++) {
    $url=$nodes[$i];
    $curl_arr[$i] = curl_init($url);
    curl_setopt($curl_arr[$i], CURLOPT_NOBODY, true);
    curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_arr[$i], CURLOPT_HEADER, true);
    curl_setopt($curl_arr[$i], CURLOPT_FOLLOWLOCATION, true);

    // provide credentials if they're established at the beginning of the script
    if(!empty($user) && !empty($password)) {
      curl_setopt($curl_arr[$i], curlOPT_HTTPproxyTUNNEL, true);
      curl_setopt($curl_arr[$i], curlOPT_proxy, 'proxy.student.otago.ac.nz:3128');
      curl_setopt($curl_arr[$i], CURLOPT_PROXYUSERPWD,$user.":".$password);
    }

    curl_multi_add_handle($master, $curl_arr[$i]);
  }


  do {
    curl_multi_exec($master, $running);
    echo $running." ";
    //echo $updates;
  } while($running > 0);

  $i = 0;
  for($i=0; $i<$node_count; $i++) {
    $results=curl_multi_getcontent($curl_arr[$i]);

    if (preg_match('/^HTTP\/1\.[01] (\d\d\d)/', $results, $matches)) {
      $status = (int)$matches[1];
    }
    if (preg_match('/Content-Length: (\d+)/', $results, $matches)) {
      $contentLength = (int)$matches[1];
    }
    if ($contentLength == $onlinesize)
      $onlineplayers[] = $players[$i];
  }

  print_r($onlineplayers);

  $fp = fopen($filename, 'w+') or die("I could not open $filename.");
  fwrite($fp, serialize($onlineplayers));
  fclose($fp);
  echo ($updates++ % 5 == 0) ? ($updates)."\n" : "";
  $updates++;
  sleep(2); //2 second sleep (dont update too fast);
} while(true);

?>