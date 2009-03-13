
var g_curcity = "";

// city must be 3-digit lowercase
function FindShizzeepsStatic(city) {
			
	g_curcity = city;
	
	$.getJSON("/bin/ajax.php", {f:'shizzeepsstatic', city:city}, DisplayDataStatic);	
		
} // FindShizzeepsStatic()

 			
function DisplayDataStatic(json) {

	if (json == "") {
		$('#explanation').html("No one has shouted lately.");
		return;
	}

	var out, place, dets, id, who, megaphone, notepad, expl, city, st, errmsg, title;
	
	//var status = $('#status').html();
	var br = '<br />', sep = ' | ';
	var limit = json.request.limit;
	var places = json.results.places;
	var count = places.length;
	var when = FormatShizzowDate(json.request.time);
		
	expl = 'Top ' + count + ' Places in ';
	if (g_curcity == 'pdx') {
		expl += 'Portland, OR ';
	} else if (g_curcity == 'aus') {
		expl += 'Austin, TX ';
	}
	expl += ' Containing Shizzeeps Right Now';
	$('#explanation').html(expl);
	$('#dataout').html('');
	
	for (i=0; i<count; i++) {
	
		place = places[i];
		id = place.places_key;

		
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
		
				
		// Get the Shizzeps who are at this place
		WhoIsHereStatic(place.shouts, id);	
		
	}
	
	
		
}//DisplayDataStatic()

function WhoIsHereStatic(json, id) {
		
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
		/*
for (i=0; i<count; i++) {
			shout = shouts[i];
			person = '<div class="person" id="' + shout.people_name + '">' + shout.people_name + '</div>';
			$('#whosat'+id).append(person);
			
			pdets = '<div class="pdets balloon corners" id="shout_' + shout.shouts_history_id + '">'; 
			pdets = pdets + shout.profiles_name + '<div class="when">' + shout.shout_time + '</div>';
			if (shout.shouts_messages) {
				for (j=0; j<shout.shouts_messages.length; j++) {
					msg = shout.shouts_messages[j];
					pdets += msg.message + br;
				}
			}
			pdets += '</div>';
			$('#'+shout.people_name).append(pdets);
		}
*/	
		
		
		$('.pdets').hide();
		$('.whoshere').mouseover(function(){
			$(this).children('*').children('.pdets').show();
		});
	
		$('.whoshere').mouseout(function(){
			$(this).children('*').children('.pdets').hide();
		});
		
	


}// WhoIsHereStatic()




function FormatShizzowDate (dtime) {

	// dt looks like this: 2009-02-26T10:02:29-0800
	
	var dt, tm, tz, sep;
	
	dt = dtime.substr(0,10);
	tm = dtime.substr(11,8);
	tz = dtime.substr(19,6);
		
	return dt + ' at ' + tm + ', GMT ' + tz;

}


function ReadCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}


