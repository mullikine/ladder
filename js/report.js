var subladdervisible = 1;
var reportplayers = [];
var reportteams = [];
var reportrows = [];
var reportrowsn = -1;
var ndeletedrows = 0;

// autocomplete
function lookup(inputString) {
	if (loading == 1) return false;
	
	loading = 1;
    if(inputString.length == 0) {
        // Hide the suggestion box.
        loading = 0;
        $('#suggestions').hide();
    } else {
        $.post("include/autocompletename.php", "queryString="+inputString, function(data){
            if(data.length >0) {
                $('#suggestions').show();
                $('#autoSuggestionsList').html(data);
            }
            loading = 0;
        });
    }
} // lookup

function changeteam(sel, reportplayerid){
  /*c = confirm('You chose ' + sel.options[sel.selectedIndex].value + '\nDo you want to continue?');*/
  reportteams[reportplayerid] = sel.selectedIndex;
} 

function removerow(rowid) {
	reportplayers[rowid] = -1;
	reportteams[rowid] = -1;
	$('#reportrow' + rowid).remove();
	ndeletedrows++;	
}

function fill(gr_name, gr_id) {
	var teamoptions = '';
	var maxplayers;
	
	/* improve on this later */
	var nteams = 2;
	var maxteamsize = 4;
	
	maxplayers = maxteamsize * nteams;
	selectedteam = (((reportrowsn + 1) - ndeletedrows) % nteams);
	
	for (i = 0; i < nteams; i ++) {
		if (selectedteam == i) {
			selectedtext = "selected='selected' ";
		} else {
			selectedtext = "";
		}
		teamoptions += "<option "+selectedtext+"value='"+i+"'>Team "+(i+1)+"</option>";
	}
	
	loading = 0;
	if (reportrowsn - ndeletedrows < (maxplayers - 1)) {
		reportrowsn++;
		
		reportplayers[reportrowsn] = gr_id;
		reportteams[reportrowsn] = selectedteam;
		
		reportrows[reportrowsn] = document.createElement('tr');
		reportrows[reportrowsn].setAttribute('id', 'reportrow' + reportrowsn);
		$(reportrows[reportrowsn]).html("<td>"+gr_name+"</td><td><select onchange=\"changeteam(this,'"+reportrowsn+"');\">"+teamoptions+"</select></td><td><a href=\"javascript: removerow('"+reportrowsn+"');\"><img src='images/mt_delete.png' width='16' /></a></td>");
		/*loginerror.setAttribute('id', 'loginerror');*/
		Dom.add(reportrows[reportrowsn], 'reportplayerlist');
		/*$("#reportplayerlist")*/
		
		$('#suggestions').hide();
	} else {
		$('#suggestions').hide();
		/*alert('There is a limit of '+(maxplayers - ndeletedrows)+' players.');*/
	}
}


/*function showsubladders(ladderid) {
	if (loading == 1) return false;
	
	if (ladderid) {
		subladdervisible = 1;
		loading = 1;
		$.post("include/subchoice.php", "id="+ladderid, function(data){
			if(data.length >0) {
				$('#subladders').html(data);
				$('#subladders').show();
			}
			loading = 0;
		});
	} else {
		$('#subladders').html('');
		$('#subladders').hide();
		subladdervisible = 0;
	}
}*/

function submitladdergame() {
	var chosonladder;
	var winningteam;
	var QueryString = '';
	var nthPlayer = 0;
	var i;
	
	if (loading == 0) {		
		loading = 1;
		
		/*var sel = document.getElementById('SubLadder');*/
		
			/*alert(sel.options[sel.selectedIndex].value);*/
		/*if (subladdervisible == 1) {
			chosonladder = $('#SubLadder').val();
		} else {
			chosonladder = $('#Ladder').val();
		}*/
		chosonladder = $('#Ladder').val();
		winningteam = $('#Winners').val();
		//alert(chosonladder);
		for (i=0; i <= reportrowsn; i++) {
			if (reportplayers[i] > -1) {
				QueryString += 'Player' + (nthPlayer + 1) + 'grid=' + reportplayers[i] + '&';
				QueryString += 'Player' + (nthPlayer + 1) + 'Team=' + (reportteams[i] + 1) + '&';
				nthPlayer++;
			}
		}
		QueryString += 'Ladder=' + chosonladder + '&Winners=' + winningteam;
		$.post("include/submitladdergame.php", QueryString, function(data){
			$('#text').html("<p>" + data + "</p>");
			loading = 0;
		});
	}
	return false;
}

function validatereport() {
	/*var n;
	var p;
	
	n = $("#name").val();
	if (n == "") {
		$("#name").focus();
		return false;
	}
	
	p = $("#password").val();
	if (p == "") {
		$("#password").focus();
		return false;
	}*/
	submitladdergame();

	return false;
}