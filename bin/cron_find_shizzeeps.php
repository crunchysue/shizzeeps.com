<?php

	$limit = 7;

	require_once('lucy.php');
	
	$shizzowup = SHIZZOWUP;

	$url = 'https://v0.api.shizzow.com/places?populated=true';
	
	$url .= '&limit=' . $limit;

	include 'shizzow_get.php';

	echo $curl_response['http_code'];

	if ($curl_response['http_code'] == '200') {
		
		$json = $curl_response['content']; // echo data as json string
		$data = json_decode($json);
		$places = $data->results->places;
		$pop = $name = $city = $st = $msg = $key = $sql = $lat = $lng = $alt = $fav = $web = $addr1 = $addr2 ='';
		$min = 1; // minimum number of people in a place necessary to generate tweet

		try {
			require_once "db.php";
			$db = new db();
			$sql = "INSERT INTO places (places_key, places_name, addr1, addr2, city, st, latitude, longitude, altitude, fav, web) VALUES";
		
			foreach($places as $place) {
				$pop = $place->population;
				
				// Only care about places with [min] or more shizzeeps in them
				if (intval($pop) >= $min) {
	
					$key = $place->places_key;
					$name = mysql_real_escape_string($place->places_name);
					$addr1 = mysql_real_escape_string($place->address1);
					$addr2 = mysql_real_escape_string($place->address2);
					$city = mysql_real_escape_string($place->city);
					$st = $place->state_iso;
					$lat = $place->latitude;
					$lng = $place->longitude;
					$alt = $place->altitude;
					$fav = $place->is_favorite;
					$web = mysql_real_escape_string($place->website);
	
					$sql .= '("' . $key . '","' . $name . '","' . $addr1 . '","' . $addr2 . '","' . $city . '","' . $st;
					$sql .= '","' . $lat . '","' . $lng . '","' . $alt . '","' . $fav . '","' . $web . '"),';
					
				} // if pop >= min			
			} // foreach
			
			$sql = substr($sql, 0, strlen($sql)-1);
			//echo $sql;
				
			$result = $db->query($sql);
	
			// Loop through the places and get their shouts
			while($row = $result->fetchRow()) {
	    		
			}
			
			$db = null;
		}// try
		
		
		catch (DatabaseException $e) {
		  $e->HandleError();
		}
		catch (ResultException $e) {
		  $e->HandleError();
		}
		
	}// if curl response = 200
	



// For a shout, build a database entry
function GetShout($key) {

	global $shizzowup;
	
	$url = "https://v0.api.shizzow.com/places/$key/shouts?when=recently&who=everyone&limit=100";

	include 'shizzow_get.php';

	//echo $curl_response['content']; // echo data as json string
	
	echo $curl_response['http_code'];

	if ($curl_response['http_code'] == '200') {
		
		$json = $curl_response['content']; // echo data as json string
		$data = json_decode($json);

	
	
	
}//GetShout()

?>