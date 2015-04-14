<?php
include('siteinfo.php');
include('connect_db.php');

$_SESSION['area'] = $_GET['area'];
$_SESSION['ladder'] = $_GET['ladder'];

/*echo 'Remote address: '.$_SESSION['REMOTE_ADDR'];
print_r($_SERVER);*/

switch ($_GET['area']) {
case 0:
?>
	<div id="title">
		Most Recent News
	</div><div id="titlefade"><div class="whitetopblend"></div></div>
	<div id="page">
		<div id="news">
<?php

$query = "SELECT * FROM news ORDER BY date DESC;";
$result = mysql_query($query) or die(mysql_error());
while ($newsrow = mysql_fetch_array($result)) {

	$phpdate = strtotime( $newsrow['date'] );
	$postedon = '<div class="postedon">Posted on '.date( 'd M \'y', $phpdate ).'</div>';
	echo '<div class="newsgroup"><h2>'.$newsrow['title'].'</h2>'.$newsrow['content'].$postedon.'</div>';

}

if ($browser == 'Explorer') {
	echo '<p>Hint: This website looks better on just about any other web browser!</p>';
}

?>
		</div>
	</div>
<?php
break;
case 1:
	if (isset($_GET['ladder'])) {
		include('ladder.php');
	} else {
		include('ladders.php');
	}
break;
case 2:
	include('matches.php');
break;
case 3:
	include('players.php');
break;
case 4:
	include('reportpage.php');
break;
case 5:
	include('halloffame.php');
break;
case 6:
	include('pimpmyladder.php');
break;
case 7:
	include('help.php');
break;
default:
?>
	<h2>Oops!</h2>
	<p>The page you are looking for does not exit.</p>
	<p>Please check back soon, while the website is completed.</p>
<?php
}
?>