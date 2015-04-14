var area = 0;
var ladder = -1;
var logininfo;
var loggedinname;
var loggedinid;

var quickinfo;

var loggedintitle;
var loggedininfo;
var logouttitle;
var logoutbutton;
var loginerror;

var loading;

var loggedin = 0;

// OnLoad
$(document).ready(function() {
	$.ajaxSetup({cache: false});
	
	$("#login").click(validatelogin);
	
	/*$("h1").FontEffect({
		outline:true,
		outlineWeight   :2     // 1=light,2=normal,3=bold
	});*/
	
	$("a.zoom").fancybox({
		'overlayOpacity'	:	0.7,
		'overlayColor'		:	'#000',
		'frameWidth'		:	400,
		'frameHeight'		:	360
	});
	
	$.post("include/getuandp.php", function(data){
		quickinfo=data.split(',');
		if (data != ",,,") {
			loggedin = 1;
			loggedinname = quickinfo[2];
			loggedinid = quickinfo[3];
		} else {
			loggedin = 0;
		}
	});
	
	disableautocomplete();
	
	loading = 0;
	
	simplePreload('images/bg90_black.png');
});

function simplePreload() {
  var args = simplePreload.arguments;
  document.imageArray = new Array(args.length);
  for(var i=0; i<args.length; i++) {
    document.imageArray[i] = new Image;
    document.imageArray[i].src = args[i];
  }
}

function changeBGColor(c,tc) {
	document.body.style.backgroundColor = "#" + c;
	/*$('table th').css('background-color',"#" + tc);*/
}

function loadArea(a) {
	if (loading == 1) return;
	
	if (a == 4) {
		// initialize report variables
		
		reportplayers = [];
		reportteams = [];
		reportrows = [];
		reportrowsn = -1;
		ndeletedrows = 0;
	}
	
	loading = 1;
	var newdata ="";/*"<p style='color:white;'>Please wait...</p>";*/
	var menuitems = document.getElementById('sidenav').getElementsByTagName('li');
	
	/* start getting the actual new data */
	$.get('include/content.php?area=' + a,function(data) {
		newdata = data;
		$("div#content").html(newdata);
		loading = 0;
		ladder = -1;
		
		menuitems[area].firstChild.className = '';
		menuitems[a].firstChild.className = 'current';
		$("div#content").fadeIn(100, function() {
		
			if ((a == 4) && (loggedin == 1)) {
				// set up report form
				fill(loggedinname, loggedinid);
				$('#btnSubmit').click(submitladdergame);
			}
			
		});
		
		
		area = a;
		disableautocomplete();
	});
	
	/* if requesting a new page ie. not refreshing */
	if (a != area)
		menuitems[a].firstChild.className = 'loading';
	
	/* change current early, regardless */
	menuitems[area].firstChild.className = '';
	menuitems[a].firstChild.className = 'current';
}

function loadArea2(a) {
	if (loading == 1) return;
	var ifinished = 0;
	
	if (a == 4) {
		// initialize report variables
		
		reportplayers = [];
		reportteams = [];
		reportrows = [];
		reportrowsn = -1;
		ndeletedrows = 0;
	}
	
	loading = 1;
	var newdata ="<p style='color:white;'>Please wait...</p>";
	var menuitems = document.getElementById('sidenav').getElementsByTagName('li');
	
	/* start getting the actual new data */
	$.get('include/content.php?area=' + a,function(data) {
		newdata = data;
		ifinished++;
		if (ifinished == 2) {
			$("div#content").html(newdata);
			loading = 0;
			ladder = -1;
			
			menuitems[area].firstChild.className = '';
			menuitems[a].firstChild.className = 'current';
			$("div#content").fadeIn(100, function() {
			
				if ((a == 4) && (loggedin == 1)) {
					// set up report form
					fill(loggedinname, loggedinid);
					$('#btnSubmit').click(submitladdergame);
				}
				
			});
			
			
			area = a;
			disableautocomplete();
		}
	});
	
	/* if requesting a new page ie. not refreshing */
	if (a != area)
		menuitems[a].firstChild.className = 'loading';
	
	$("div#content").fadeOut(100, function() {
		/* change current early, regardless */
		menuitems[area].firstChild.className = '';
		menuitems[a].firstChild.className = 'current';
		$("div#content").html(newdata).fadeIn(200, function() {
			ifinished++;
			if (ifinished == 2) {
				$("div#content").html(newdata);
				loading = 0;
				ladder = -1;
				
				$("div#content").fadeIn(100, function() {
					if ((a == 4) && (loggedin == 1)) {
						// set up report form
						fill(loggedinname, loggedinid);
						$('#btnSubmit').click(submitladdergame);
					}
					
				});
				
				
				area = a;
				disableautocomplete();
			}
		});
	});
}

function disableautocomplete() {
	if (document.getElementsByTagName) {
		var inputElements = document.getElementsByTagName("input");
		for (i=0; inputElements[i]; i++) {
			if (inputElements[i].className && (inputElements[i].className.indexOf("disableAutoComplete") != -1)) {
				inputElements[i].setAttribute("autocomplete","off");
			}//if current input element has the disableAutoComplete class set.
		}//loop thru input elements
	}//basic DOM-happiness-check 
}

function loadLadder(l) {
	if (loading == 1) return;
	ifinished = 0;
	
	loading = 1;
	var newdata =""/*"<p style='color:white;'>Please wait...</p>";*/
	
	ladder = l;
	
	$.get('include/content.php?area=' + area + '&ladder=' + l,function(data) {
		newdata = data;
		$("div#content").html(newdata);
		loading = 0;
	});
}

function loadLadder2(l) {
	if (loading == 1) return;
	ifinished = 0;
	
	loading = 1;
	var newdata ="";/*"<p style='color:white;'>Please wait...</p>";*/
	
	$.get('include/content.php?area=' + area + '&ladder=' + l,function(data) {
		newdata = data;
		ifinished++;
		if (ifinished == 2) {
			$("div#content").html(newdata);
			loading = 0;
		}
	});
	
	$("div#content").fadeOut(200, function() {
		ladder = l;
		
		$("div#content").html(newdata).fadeIn(200, function() {
			ifinished++;
			if (ifinished == 2) loading = 0;
		});
	});
}

function loginboxmax() {
	$('#loginform').parent().removeClass('min');
	$('#maxloginbutton').remove();
	$('#name').focus();
}

function validatelogin() {
	var n;
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
	}

	return login(n, p);
}

function login(n, p) {
	// validate and process form here
	if (loading == 1) return false;
	loading = 1;
	
	var dataString = 'name='+ n + '&password=' + p;
	//alert (dataString);return false;
	$.post('include/login.php',dataString,function(data) {
		logininfo=data.split(',');
		loggedinname = logininfo[2];
		loggedinid = logininfo[5];
		
		if (logininfo[0]=='1') {
			
			$(".out").remove();
			
			loggedintitle = document.createElement('li');
			$(loggedintitle).attr("id","loggedintitle");
			$(loggedintitle).addClass("title");
			loggedintitle.innerHTML = 'Signed in';
			/*Event.add(loggedintitle, 'click', function(e) {
			  Dom.remove(this);
			});*/
			
			loggedininfo = document.createElement('li');
			$(loggedininfo).attr("id","loggedininfo");
			
			var returntext = "<ul class='box in'><li class='min'>Account: "+n+"</li>";
			returntext += "<li>Name: " + logininfo[2] + "</li>";
			/*returntext += "<li>Rating: " + logininfo[3] + "</li></ul>";*/
			returntext += "</ul>";
			
			loggedininfo.innerHTML = returntext;
			
			logouttitle = document.createElement('li');
			$(logouttitle).attr("id","logouttitle");
			$(logouttitle).addClass("min");
			$(logouttitle).addClass("title");
			logouttitle.innerHTML = 'Logout';
			
			logoutbutton = document.createElement('li');
			$(logoutbutton).attr("id","logoutbutton");
			var temp = document.createElement('a');
			Event.add(temp, 'click', function(e) {
			  logout();
			});
			$(temp).addClass("in");
			temp.innerHTML = "<img src='images/exit.png' />Logout";
			$(logoutbutton).append(temp);
			
			
			Dom.add(loggedintitle, 'sidenav');
			Dom.add(loggedininfo, 'sidenav');
			Dom.add(logouttitle, 'sidenav');
			Dom.add(logoutbutton, 'sidenav');
			$('.in').hide();
			loggedin = 1;
			$('.in').fadeIn(500, function() {
				loggedin = 1;
				loadArea(area);				
			});
		} else {
			if ($('#loginerror').length == 0) {
				var loginerror = document.createElement('div');
				loginerror.setAttribute('id', 'loginerror');
				Dom.add(loginerror, 'loginform');
				$('#loginerror').hide();
				$('#loginerror').html(logininfo[4]);
				$("#loginerror").slideDown(200, function() {
					
				});
				$('#loginform').parent().removeClass('min');
				$('#maxloginbutton').remove();
			} else {
				$('#loginerror').html(logininfo[4]);
				$('#loginerror').css('color', '#fff');
				$('#loginerror').animate({color: '#faa'}, 300);
			}
		}
		loading = 0;
	});
	
	/*var dataString = 'name='+ name + '&password=' + password;
	//alert (dataString);return false;
	$.ajax({
		type: "POST",
		url: "include/login.php",
		data: dataString,
		success: function() {
			$.get('include/logininfo.php' + ,function(data) {
				$("#loginform").html(data).hide().fadeIn('500');
			});
			
			$('#loginform').html("<div id='message'></div>");
			$('#message').html("<h4>Login Completed!</h4>")
			.append("<p>This will be gone soon.</p>")
			.hide()
			.fadeIn(1500, function() {
				$('#message').append("<img id='checkmark' src='images/Matches.png' />");
			});
			
		}
	});*/
	return false;
	
}

function logout() {
	$.ajax({
	  url: "include/logout.php",
	  cache: false,
	  success: function(success){
		if(success!='') {
			Dom.remove(document.getElementById('loggedintitle'));
			Dom.remove(document.getElementById('loggedininfo'));
			Dom.remove(document.getElementById('logouttitle'));
			Dom.remove(document.getElementById('logoutbutton'));
			$('#sidenav').append(success);
			$("#login").click(validatelogin);
			loadArea(area);
		} else {
			alert('You have already logged out.');
		}
	  }
	});
	loggedin = 0;
}