<?php

	$limit = 7;

	require_once('lucy.php');
	if ($_GET['fp'] != FIND_SHIZZEEPS_CRON_PASS) { 
		echo 'Access denied.';
		exit;
	};
	
	$shizzowup = SHIZZOWUP;

	$url = 'https://v0.api.shizzow.com/places?populated=true';
	
	$url .= '&limit=' . $limit;

	include 'shizzow_get.php';

	echo $curl_response['http_code'];

	if ($curl_response['http_code'] == '200') {
		
		$json = $curl_response['content']; // echo data as json string
		$data = json_decode($json);
		
		
		echo '<hr />PLACES:<hr /><pre>'; 
		print_r($json);	
		echo '</pre><hr />';
		
		StoreShouts('Lgbyc9');


		$places = $data->results->places;
		$pop = $name = $city = $st = $msg = $key = $places_sql = $shouts_sql = $msg_sql = '';
		$lat = $lng = $alt = $fav = $web = $addr1 = $addr2 ='';
		$min = 1; // minimum number of people in a place necessary to generate tweet
/*

		try {
			require_once "db.php";
			$db = new db();
			$places_sql = "INSERT INTO places (places_key, places_name, addr1, addr2, city, st, latitude, longitude, altitude, fav, web) VALUES";
		
			// Put all the places and their shouts in the database
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
	
					$places_sql .= '("' . $key . '","' . $name . '","' . $addr1 . '","' . $addr2 . '","' . $city . '","' . $st;
					$places_sql .= '","' . $lat . '","' . $lng . '","' . $alt . '","' . $fav . '","' . $web . '"),';
							
					StoreShouts('Lgbyc9');
					
				} // if pop >= min			
			} // foreach
			
			$places_sql = substr($places_sql, 0, strlen($sql)-1);
			//echo $sql;
				
			//$db->query($places_sql);	
			$db = null;
			
			
		}// try
		
		
		catch (DatabaseException $e) {
		  $e->HandleError();
		}
		catch (ResultException $e) {
		  $e->HandleError();
		}
*/
		
	}// if curl response = 200
	



// For a shout, build a database entry
function StoreShouts($key) {

	global $shizzowup;
	
	$url = "https://v0.api.shizzow.com/places/$key/shouts?when=recently&who=everyone&limit=100";

	include 'shizzow_get.php';
	
	echo $curl_response['http_code'];

	if ($curl_response['http_code'] == '200') {
		
		$json = $curl_response['content']; // echo data as json string
		$data = json_decode($json);
		
		$shouts = $data->results->shouts;
		
		/*
for ($shouts as $shout) {
		
		
		}
		
*/
		
		
		
		
		echo '<hr />SHOUTS FOR "SHIZZEEPS WORLD HQ:"<hr /><pre>'; 
		print_r($json);	
		echo '</pre><hr />';
		


	}
	
	
}//GetShout()
	

/* Sample GetShout() Result */

/*

stdClass Object
(
    [request] => stdClass Object
        (
            [limit] => 100
            [page] => 1
            [start] => 
            [time] => 2009-03-08T19:48:14-0700
            [url] => https://v0.api.shizzow.com/places/ihI5f2/shouts?when=recently&who=everyone&limit=100
        )

    [results] => stdClass Object
        (
            [places] => stdClass Object
                (
                    [places_key] => ihI5f2
                    [places_name] => The House of Crunchy
                    [address1] => SE 29th & Clinton
                    [address2] => 
                    [city] => Portland
                    [state_iso] => OR
                    [state_name] => Oregon
                    [zip] => 97202
                    [country_iso] => US
                    [country_name] => United States
                    [phone] => 
                    [website] => http://shizzeeps.com
                    [latitude] => 45.50356476797762
                    [longitude] => -122.63557434082031
                    [altitude] => 0.0000000
                    [is_favorite] => 0
                )

            [count] => 2
            [shouts] => Array
                (
                    [0] => stdClass Object
                        (
                            [shouts_history_id] => 18259
                            [arrived] => 2009-03-08T16:43:57-0700
                            [modified] => 2009-03-08T19:48:06-0700
                            [shout_time] => 1 minute ago
                            [status] => here
                            [people_name] => crunchysue
                            [public] => 1
                            [profiles_name] => Sue Brown
                            [places_key] => ihI5f2
                            [places_name] => The House of Crunchy
                            [address1] => SE 29th & Clinton
                            [address2] => 
                            [city] => Portland
                            [state_iso] => OR
                            [state_name] => Oregon
                            [zip] => 97202
                            [country_iso] => US
                            [country_name] => United States
                            [phone] => 
                            [website] => http://shizzeeps.com
                            [latitude] => 45.50356476797762
                            [longitude] => -122.63557434082031
                            [altitude] => 0.0000000
                            [people_images] => stdClass Object
                                (
                                    [people_image_16] => http://people.shizzow.com/crunchysue_16.jpg
                                    [people_image_24] => http://people.shizzow.com/crunchysue_24.jpg
                                    [people_image_32] => http://people.shizzow.com/crunchysue_32.jpg
                                    [people_image_48] => http://people.shizzow.com/crunchysue_48.jpg
                                    [people_image_64] => http://people.shizzow.com/crunchysue_64.jpg
                                    [people_image_80] => http://people.shizzow.com/crunchysue_80.jpg
                                    [people_image_96] => http://people.shizzow.com/crunchysue_96.jpg
                                )

                            [shouts_messages] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [shouts_history_id] => 18259
                                            [message] => Still here, believe it or not
                                            [time] => 2009-03-08T19:48:06-0700
                                            [shout_time] => 1 minute ago
                                        )

                                    [1] => stdClass Object
                                        (
                                            [shouts_history_id] => 18259
                                            [message] => Working on stuff with crunchydev
                                            [time] => 2009-03-08T19:44:28-0700
                                            [shout_time] => 4 minutes ago
                                        )

                                )

                        )

                    [1] => stdClass Object
                        (
                            [shouts_history_id] => 18273
                            [arrived] => 2009-03-08T19:44:08-0700
                            [modified] => 2009-03-08T19:44:08-0700
                            [shout_time] => 4 minutes ago
                            [status] => here
                            [people_name] => crunchydev
                            [public] => 1
                            [profiles_name] => Sue Brown
                            [places_key] => ihI5f2
                            [places_name] => The House of Crunchy
                            [address1] => SE 29th & Clinton
                            [address2] => 
                            [city] => Portland
                            [state_iso] => OR
                            [state_name] => Oregon
                            [zip] => 97202
                            [country_iso] => US
                            [country_name] => United States
                            [phone] => 
                            [website] => http://shizzeeps.com
                            [latitude] => 45.50356476797762
                            [longitude] => -122.63557434082031
                            [altitude] => 0.0000000
                            [people_images] => stdClass Object
                                (
                                    [people_image_16] => http://people.shizzow.com/crunchydev_16.jpg
                                    [people_image_24] => http://people.shizzow.com/crunchydev_24.jpg
                                    [people_image_32] => http://people.shizzow.com/crunchydev_32.jpg
                                    [people_image_48] => http://people.shizzow.com/crunchydev_48.jpg
                                    [people_image_64] => http://people.shizzow.com/crunchydev_64.jpg
                                    [people_image_80] => http://people.shizzow.com/crunchydev_80.jpg
                                    [people_image_96] => http://people.shizzow.com/crunchydev_96.jpg
                                )

                            [shouts_messages] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [shouts_history_id] => 18273
                                            [message] => Hanging out with real crunchy, coding.
                                            [time] => 2009-03-08T19:44:08-0700
                                            [shout_time] => 4 minutes ago
                                        )

                                )

                        )

                )

        )

)



*/


?>