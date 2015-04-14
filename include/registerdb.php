<?php
session_start();
include('connect_db.php');

function removecommasandquote($strinput) {
  $strinput = str_replace("'", '', $strinput);
  return str_replace(',', '', $strinput);
}

$_POST=array_map('removecommasandquote',$_POST);
$_POST=array_map('mysql_real_escape_string',$_POST);

$loginname = $_POST['loginname'];
$grname = $_POST['grname'];
$grid = $_POST['grid'];
$password = $_POST['password'];

function success($caption) {
  global $loginname, $grname, $password, $caption;
  
  $_SESSION['loginname'] = $loginname;
  $_SESSION['grname'] = $grname;
  $_SESSION['password'] = $password;
	
  echo "1,$loginname,$grname,$caption";

  /* update all scripts to close database when done
     mysql_close($conn); */
	
  exit(0);
}

function failure($caption) {
  global $loginname, $grname, $password, $caption;

  echo "0,$loginname,$grname,$caption";

  /* update all scripts to close database when done
     mysql_close($conn); */
	
  exit(0);
}


if ($loginname != "" && $grname != "" && $grid != "" && $password != "") {
  if (intval($grid)>0) {
    $query = "SELECT * FROM players WHERE gr_id='$grid';";
    $result = mysql_query($query) or die(mysql_error());
		
    $entries = mysql_num_rows($result);
		
    if ($entries == 0) {
			
      $query = "INSERT INTO players (accountname, names, gr_id, password, open_activated) VALUES('$loginname','$grname','$grid','$password','1');";
      $result = mysql_query($query) or die(mysql_error());
			
      success("You can play ladder games now! Awesome!");
    } else {
      $row = mysql_fetch_array($result);
      if ($row['open_activated'] == 0) {
	$query = "UPDATE players SET open_activated = '1', password = '$password', names = '$grname', accountname = '$loginname' WHERE gr_id = '$grid'";
	mysql_query($query) or die(mysql_error());
				
	success("You can play ladder games now! Awesome!");
      } else {
	failure("There is already a registered member with that id.");
      }
    }
  } else {
    failure("Your GR id number (".intval($grid).") is not an integer.");
  }
} else {
  failure("You haven't filled out all the required fields.");
}
?>