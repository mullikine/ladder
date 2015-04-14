<?php
	session_start();
	echo $_SESSION['name'].','.$_SESSION['password'].','.$_SESSION['grname'].','.$_SESSION['grid'];
?>