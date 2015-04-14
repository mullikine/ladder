<?php
session_start();
$name = isset($_SESSION['name'])?$_SESSION['name']:'';
$pass = isset($_SESSION['password'])?$_SESSION['password']:'';
$grname = isset($_SESSION['grname'])?$_SESSION['grname']:'';
$grid = isset($_SESSION['grid'])?$_SESSION['grid']:'';
echo $name.','.$pass.','.$grname.','.$grid;
?>