<li id="loggedininfo">
	<ul class="box in" style="display:block;">
		<li class="min">Account: <?php echo $_SESSION['loginname'] ?></li>
		<li>Name:  <?php echo $_SESSION['grname'] ?></li>
		<li style="display:none">Rating: </li>
	</ul>
</li>
<li id="logoutbutton"><a class="in" style="display:block;" href="javascript:logout()"><img src="images/exit.png" />Logout</a>
</li>