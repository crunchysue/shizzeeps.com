// http://groups.google.com/group/coda-users/browse_thread/thread/856c9c5bf6a6d3a0


$(document).ready(function(){

	FindShizzeeps();
	
	// Login
	$('#frmLogin').hide();	
	$('#btnShowLogin').toggle(function(){$('#frmLogin').slideDown('fast');},function(){$('#frmLogin').slideUp('fast');});
	$('#btnLogin').click(function(){
		Login();
		FindShizzeeps();
		$('#btnShowLogin').click(); // make the login toggle
		return false;
	});
	
	var refreshrate = 60000*15; // 15 minutes
	$.timer(refreshrate, FindShizzeeps);
	
	// Put Message to Room
	$('#putmsg').hide();
	$('.popup').prepend('<div class="close" title="close">x </div>');
	$('#txtMsg').keypress(function (e) {
		if (e.keyCode == 13) {
			PutMessage();
			return false;
		}
	});
	
	// All Buttons - Hover
	$('.button').hover(
	  	function () {
	    	$(this).addClass("button-on");
	  	},
	  	function () {
	    	$(this).removeClass("button-on");
	  	}
	);

	// All close buttons - MAY NEED RETHINKING
	$('.close').click(function(){ $('.popup').hide(); });
		// Logout
	$('#btnLogout').click(function(){
		$.post('/bin/ajax.php', {f:'logout'});
		$('#status').html('Log in to see all the shizzeeps everywhere; PDX and SXSW are free.');
	});
	
	// Filters
	$('#frmFilters').hide();
	$('#st').val($.cookie('st'));
	$('#btnFilters').toggle(function(){$('#frmFilters').slideDown('fast');}, function(){$('#frmFilters').slideUp('fast');});
	$('#btnSetFilters').click(function(){
		SetFilters();
		FindShizzeeps();
		return false;
	});
	$('#btnClearFilters').click(function(){
		ClearFilters();
		FindShizzeeps();
	});
	
	// PDX
	$('#btnPDX').click(function(){
		location.href = "/pdx/";
	});
	
	// AUS
	$('#btnAUS').click(function(){
		location.href = "/aus/";
	});

	
	// Help
	$('#help').hide();
	$('#btnHelp').toggle(function(){$('#help').slideDown('fast');},function(){$('#help').slideUp('fast');});

}); // doc ready



function SetFilters() {

	var st, city;
	
	st = $('#st').val();
	city = $('#city').val();
	
	$.post('/bin/ajax.php', {st:st, city:city, f:'setfilters'}); 

} // SetFilters()



function ClearFilters() {

	$('#st').val('');
	$('#city').val('');

	$.post('/bin/ajax.php', {f:'setfilters'}); 

} // SetFilters()



function Login() {

	var u, p, parms={};	
	
	u = $('#username').val();
	p = $('#password').val();	
	
	if (u && p) {
	
		//$('#frmLogin').submit();
	
		$.ajax({
		   type: "POST",
		   url: "/bin/ajax.php",
		   data: {username:u, password:p, f:'login'}
		 });
		
		$('#status').html('You are logged in as ' + u);
	}

} // Login()



function FindShizzeeps() {
			
	$.getJSON("/bin/ajax.php", {f:'shizzeeps'}, DisplayData);	
		
} // FindShizzeeps()

 			
 			
function DisplayData(json) {

	var out, place, dets, id, who, megaphone, notepad, expl, city, st, errmsg, title;
	
	// Error Codes
	if (json == '401') {	errmsg = "Log in to see all the shizzeeps everywhere; PDX and SXSW are free."; }
	if (json == '503') { errmsg = "Shizzow rate limit exceeded"; }
	
	if (errmsg) {
		$('#status').html(errmsg);
		return false;
	}
	
	//var status = $('#status').html();
	var br = '<br />', sep = ' | ';
	var limit = json.request.limit;
	var places = json.results.places;
	var count = places.length;
	var when = FormatShizzowDate(json.request.time);
		
	//$('#status').html(status);

	city = $('#city').val();
	st = $('#st').val();
	expl = 'Top ' + count + ' Places ';
	if (city || st) {
		expl += ' in ';
	}
	if (city) {
		expl += city;
	}
	if (st) {
		if (city) { expl += ', '; }
		expl += st;
	}
	expl += ' Containing Shizzeeps Right Now';
	$('#explanation').html(expl);
	$('#dataout').html('');
	
	for (i=0; i<count; i++) {
	
		place = places[i];
		id = place.places_key;
		
				
		// Get the Shizzeps who are at this place
		WhoIsHere(id);

		
		out = 
			'<div class="corners place" id="' + id + '">' +
			'<div class="corners population">' + place.population + '</div>' +
			place.places_name +
			'</div>';	
						
		$('#dataout').append(out);
		
		if (place.is_favorite == 1){
			$('#'+id).addClass('fav');
		}
		

		// Get the place's details from the orig. call
		$('#'+id).append('<div id="' + id + '_dets" class="dets"></div>');
				
		dets = '<div class="addr1" id="' + id + '_addr">' + place.address1 + br;
		if (place.address2 != '') {
			 dets = dets + place.address2 + br;
		} 
		dets = dets + place.city + ', ' + place.state_iso;
		//dets += '</div><div class="addr2">';
		if (place.phone > 0) {
			dets += br + place.phone;
		}
		if (place.website) {
			dets += br + '<a href="' + place.website + '" target="_blank">Website</a>';
		} 
		dets += '</div>';		
		
		$('#'+id+'_dets').append(dets);
		
		/* Messages */
		$('#'+id+'_addr').append('<div id="' + id + '_msgbuttons"><br /></div>');
		
		/* Leave Message */
		title = 'Leave an ephemeral message for this room; expires in 1 hour; 150 character max.';
		$('#'+id+'_msgbuttons').append('<div id="leavemsg_' + id + '" class="button corners" title="' + title + '">Leave Msg</div>');
		$('#leavemsg_'+id).click(ShowLeaveMessage).addClass('link');
		
		
		/* View Messages */
		$('#'+id+'_msgbuttons').append('<div id="viewmsgs_' + id + '" class="button corners">View Msgs</span>');
		$('#viewmsgs_'+id).toggle(function(){
			ShowMessages($(this).attr('id').slice(9));
		}, function() {
			$('.msgs').remove();
		}).addClass('link');	
		
		
	}
	
	
		
}

function WhoIsHere(id) {
	
	var parms = {};
	
	parms.id = id;
	parms.f = "dets";
	
	$.getJSON("/bin/ajax.php", parms, function(json){
	
		var i, j, person, peoplediv, count, shouts, shout, msg, pdets;
		var br = '<br />', sep = ' | ';
		
		count = json.results.count;
		shouts = json.results.shouts;
		peoplediv = '<div id="whosat' + id + '" class="corners whoshere"></div>';
		$('#'+id).prepend(peoplediv);
		
		for (i=0; i<count; i++) {
			shout = shouts[i];
			person = '<div class="person" id="' + shout.people_name + '"><a target="_blank" href="http://shizzow.com/people/' + shout.people_name + '">' + shout.people_name + '</a></div>';
			$('#whosat'+id).append(person);
			
			pdets = '<div class="pdets balloon corners" id="shout_' + shout.shouts_history_id + '">'; 
			pdets = pdets + '<a target="_blank" href="http://shizzow.com/people/' + shout.people_name + '">';
			pdets = pdets + shout.profiles_name + '</a><div class="when">' + shout.shout_time + '</div>';
			if (shout.shouts_messages) {
				for (j=0; j<shout.shouts_messages.length; j++) {
					msg = shout.shouts_messages[j];
					pdets += msg.message + br;
				}
			}
			pdets += '</div>';
			$('#'+shout.people_name).append(pdets);
		}	
		
		
		$('.pdets').hide();
		$('.whoshere').mouseover(function(){
			$(this).children('*').children('.pdets').show();
		});
	
		$('.whoshere').mouseout(function(){
			$(this).children('*').children('.pdets').hide();
		});
		
	}); //getJSON



}// WhoIsHere()


function ShowLeaveMessage(e) {
	var popup = $('#putmsg');
	// the button clicked has an id of 'leavemsg_xxxx' where xxxx = places_key
	popup.data('msgid', e.target.id.slice(9));
	popup.css('left', e.clientX);
	popup.css('top', e.clientY);
	
	popup.show();
}

function PutMessage() {

	var parms = {};
	var themsg = $('#txtMsg').val();
	var id = $('.popup').data('msgid');
	parms.f = 'putmsg';
	parms.placeid = id;
	parms.msg = themsg;
	
	$.post("/bin/ajax.php", parms);
	
	$('#putmsg').hide();
	
}


// I think this SHOULD hit the db every time, in case there's new ones
function ShowMessages(id) {

	var parms = {};
	var msgs = '';
	
	parms.f = 'getmsgs';
	parms.placeid = id;

	$.getJSON('/bin/ajax.php', parms, function(json){
		
		$.each(json, function(){
			msgs += '<div class="msgs balloon corners"><span class="msgfrom">' + this.MsgFrom + '</span>: ' + this.MsgText + '</div>';
		});
		
		$('#'+id).append(msgs);
	});
	
	
	// [{"MsgFrom":"crunchysue","MsgTime":"2009-02-22 13:40:40","MsgText":"Hi Ryan and Dawn!"}]

}
