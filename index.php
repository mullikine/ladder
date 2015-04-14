<?php
include('include/siteinfo.php');
include('include/browserdetect.php');
$nav = array("area" => isset($_GET['area'])?$_GET['area']:0);
$areas = array("Notices","Ladders","Recent Matches","Community","Report a Match","Hall of Fame","Settings","Help");/**/

/*
if (ae_detect_ie()) {
?>
It seems, that your are using MSIE.
Why not to switch to standard-complaint brower, like 
<a href="http://www.mozilla.com/firefox/">Firefox</a>
<?php
exit(0);
}
*/

include "header.html";

if ($browser != 'Explorer') {
  include "header2_firefox.html";
} else {
  include "header2_ie.html";
}
include "header3.html";

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if (preg_match('/\bmsie 6/i', $ua) && !preg_match('/\bopera/i', $ua)) {
  include "warning_ie6.html";
  exit(0);
}

?>
<div id="header">Age of Empires II Ladders</div>
<div id="logo"></div>
<ul id="sidenav"><!--Main Menu<li class='title'></li>--><?php
foreach ($areas as $i => $value) {
	echo "<li><a href='javascript: loadArea($i);' rel='history' ".(($nav['area']==$i)?" class='current'":"")."><img src='images/$value.png' />$value</a></li>";
}

if (isset($_SESSION['loginname'])) {
	include('include/logoutmenu.php');
} else {
	include('include/loginmenu.html');
?>
<li class="min out"><a class="zoom iframe" href="include/register.php"><img src="images/icon_register.png" />Register here!</a></li>
<li class="max out"><a class="zoom iframe" href="include/register.php"><img src="images/icon_register.png" />Register</a></li>
<?php
}
?>
</ul>
<div id="margin"></div>
<div id="content">
<?php include('include/content.php'); ?>
</div>
<?php
if (!detect_win()) {
?>
<div id="sponsor">
<span style='opacity:0.5;filter:alpha(opacity=50);'>Admin: </span><a href="gr://info/303529">›EX‹ mantis</a>&nbsp; <span style='opacity:0.5;filter:alpha(opacity=50);'>Forums: </span><a href="http://aoe2mac.net/">Bob&#39;s Site</a>&nbsp; <a href="http://ex.cruft.co.nz/">›Excalibur‹</a>&nbsp; <a href="http://tdk.hysteron.net/index.php">Death Knights</a>&nbsp; <a href="http://highlyevolved.webs.com/">Highly Evolved</a>&nbsp; <a href="http://www.ikotame.net/eoe/aoe.html">eØe</a><!-- &nbsp; <a href="http://tourney.ath.cx/forum/">Forums</a>-->
</div>
<?php
}
?>
</body>
</html>
