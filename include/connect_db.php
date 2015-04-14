<?php


$dbhost = 'localhost';
$dbuser = 'mullikin_root';
$dbpass = 'oracle';
$dbname = 'mullikin_ladder';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '+efo0EINKwb3sTYnwzV8';
$dbname = 'ladder';
#$dbname = 'ladder_mac';


/* if ($os == 'Win') { */
/*   $dbname .= 'windows'; */
/* } */

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');

mysql_select_db($dbname);
?>
