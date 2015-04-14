<?php
session_start();
unset($_SESSION['loginname']);
unset($_SESSION['password']);
unset($_SESSION['grname']);
unset($_SESSION['grid']);

include('loginmenu.html');

?>