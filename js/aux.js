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
