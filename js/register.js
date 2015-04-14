var reginfo;
var regerror;

function isInt(x) { 
   var y=parseInt(x);
   if (isNaN(y)) return false; 
   return x==y && x.toString()==y.toString(); 
} 

function failure(info) {
	if ($('#regerror').length == 0) {
		var regerror = document.createElement('div');
		regerror.setAttribute('id', 'regerror');
		Dom.add(regerror, 'regform');
		$('#regerror').html(info);
		$("#regerror").slideDown(200, function() {
			
		});
	} else {
		$('#regerror').html(info);
		$('#regerror').css('color', '#fff');
		$('#regerror').animate({color: '#f66'}, 300);
	}
}

// OnLoad
$(document).ready(function() {
	/*parent.$('#fancy_overlay').focus();*/
	$('#loginname').focus();
	$('#submitreg').live('click',function(){
		// validate and process form here
		
		var loginname = $("input#loginname").val();
		if (loginname == "") {
			$("input#loginname").focus();
			return false;
		}
		var grname = $("input#grname").val();
		if (grname == "") {
			$("input#grname").focus();
			return false;
		}
		var grid = $("input#grid").val();
		if (grid == "" || !isInt(grid)) {
			$("input#grid").focus();
			failure('You need to enter a valid id.');
			return false;
		}
		if ($('#regerror').length != 0) {
			$('#regerror').remove();
		}
		var password = $("input#password").val();
		if (password == "") {
			$("input#password").focus();
			return false;
		}
		
		var dataString = 'loginname='+ loginname + '&grname='+ grname + '&grid='+ grid + '&password=' + password;
		
		$.post('registerdb.php',dataString,function(data) {
			reginfo=data.split(',');
			if (reginfo[0]=='1') {
				parent.login(loginname, password);
				parent.$.fn.fancybox.close();
			} else {
				failure(reginfo[3]);
			}
			return false;
		});
		return false; //we don’t want the form to get submitted do we?
	});
});