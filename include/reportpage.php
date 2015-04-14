<?php

if ($maintenance) {
	echo "<div class='textbox'><p>Sorry, the website is up for maintenance. You won't be able to submit games until it is fixed.</p></div>";
	exit(0);
}

if (!isset($_SESSION['loginname'])) {
	echo "<div class='textbox'><p>Sorry, you must be logged in to put games on the ladder.</p></div>";
	exit(0);
}

$options = '';

/* check to see if the ladder exists */

$query = "SELECT * FROM ladders WHERE laddertype>'0' AND status!='5' ORDER BY listorder;";
$result = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($result) == 0) {
	$options .= "<option value='-1'>*No Ladder*</option>";
	exit(0);
}
$i = 0;
$initialrules;
$subchoice = '';
while($row = mysql_fetch_array($result)) {
	if ($i == 0) {
		$queryString = $row['id'];
	}
	
	$name = $row['name'];
	if (isset($row['identifier'])) {
		$name .= ' '.$row['identifier'];
	}
	$options .= "<option value='{$row['id']}'>$name</option>";
	$i++;
}


?>
<div id="title">
Report Form
</div><div id="titlefade"><div class="whitetopblend"></div></div>
<div id="page">
<p style="display:none">You need someone from the opposing team to log in and verify these results after they have been submitted.</p>
<form id="reportform">
	<fieldset title="This is a required field">
		<legend align="top">
		Select the ladder from this list
		</legend>
		<label for="Ladder">Ladder</label>
		<select id="Ladder" name="Ladder" class="required">
	<?php echo $options; ?>
		</select>
		<!--<span id='subladders'><?php include('subchoice.php'); ?></span>-->
	</fieldset>
	<fieldset>
		<label for="inputString" style="display:none">Use this field to add players to the list:</label>
		<input class="disableAutoComplete" type="text" size="30" value="" id="inputString" onkeyup="lookup(this.value);" onclick="lookup(this.value);" />
		<div class="suggestionsBox" id="suggestions" style="display: none;"><img src="images/upArrow.png" style="position: relative; top: -13px; left: 30px;" alt="upArrow" /><ul class="suggestionList" id="autoSuggestionsList"></ul></div>
	</fieldset>
	<fieldset>
		<legend align="top">
		Fill this table up
		</legend>
		<table class="colored" cellpadding="0" cellspacing="0">
			<thead>
				<th>Name</th><th>Team</th><th>Remove</th>
			</thead>
			<tbody id="reportplayerlist">
			</tbody>
		</table>
	</fieldset>
	<fieldset title="This is a required field">
		<legend align="top">
		Select a winning team
		</legend>
		<label for="Winners">Winners</label>
		<select id="Winners" name="Winners" class="required">
			<option value="1">Team 1</option>
			<option value="2">Team 2</option>
		</select>
	</fieldset>
	<fieldset>
		<input id="btnSubmit" name="btnSubmit" value="Report results!" type="submit" class="submit" />
	</fieldset>
</form>
</div>