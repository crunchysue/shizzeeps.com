<?php


if (!isset($_SESSION)) {
	session_start();
}	

	// Find Shizzeeps
	
	require_once('lucy.php');
	$shizzowup = TWITTERUP;	
		
	$url = 'https://v0.api.shizzow.com/places?populated=true&limit=10';
	include 'shizzow_get.php';
	$json = $curl_response['content']; // data is an unserialized json strin gnow
			
	
	if ($curl_response['http_code'] != '200') {
		echo $curl_response['http_code'];
	} else {
		TweetShizzeeps();
	}
	

	
	function TweetShizzeeps() {
	
		global $json;
		
		include 'tweet_lib.php';
	
		$data = json_decode($json);
		$br = '<br />';
		$places = $data->results->places;
		$pop = $name = $city = $st = $msg = $key = $curmsg = '';
		$i = $j = 0;
		$cities = array();
		$curcity = array();
		$min = 2; // minimum number of people in a place necessary to generate tweet

		foreach($places as $place) {
			$pop = $place->population;
			
			// Only care about places with 2 or more shizzeeps in them
			if (intval($pop) >= $min) {

				$name = $place->places_name;
				$city = $place->city;
				$st = $place->state_iso;
				$cityst = $city . $st;
				
				$msg = "$name ($pop)";
			
				$cities[$cityst][] = $msg;
				
			} // if pop >= min			
		} // foreach
		
		
		// Loop through the cities and send message for each				
		foreach ($cities as $curcityname=>$curcity) {	
			foreach ($curcity as $curmsg) {
				$hashtag = "#shizzeeps$curcityname";
				$url = "http://shizzeeps.com";
				$tweet = "$hashtag $curmsg $url";
				send_tweet ($tweet);
			}
		}		
		
		
		
		//echo '<pre><hr />'; 
		//print_r($cities);	
		//echo '</pre><hr />';	
		//echo '<hr /><pre>'; 
		//print_r($data);	
		//echo '</pre><hr />';
		
		
		//$dataarray = json_decode($json, true);
		//echo '<pre>'; print_r($dataarray);	echo '</pre>';
		
	} // BuildTweets()
	
	
	
	
	/*
stdClass Object
(
    [request] => stdClass Object
        (
            [limit] => 2
            [page] => 1
            [start] => 
            [time] => 2009-02-28T12:10:29-0800
            [url] => https://v0.api.shizzow.com/places?populated=true&limit=2
        )

    [results] => stdClass Object
        (
            [count] => 7
            [places] => Array
                (
                    [0] => stdClass Object
                        (
                            [population] => 2
                            [places_key] => iunNdq
                            [places_name] => Kahler Grand Hotel
                            [address1] => 20 2nd Ave Sw
                            [address2] => 
                            [city] => Rochester
                            [state_iso] => MN
                            [state_name] => Minnesota
                            [zip] => 
                            [country_iso] => US
                            [country_name] => United States
                            [phone] => (507) 280-6200
                            [website] => http://kahler.com/
                            [latitude] => 44.02317000000000
                            [longitude] => -92.46572400000000
                            [altitude] => 0.0000000
                            [is_favorite] => 0
                        )

                    [1] => stdClass Object
                        (
                            [population] => 1
                            [places_key] => ihI5f2
                            [places_name] => Casa Del Crunchy
                            [address1] => 2734 SE 29th Ave
                            [address2] => 
                            [city] => Portland
                            [state_iso] => OR
                            [state_name] => Oregon
                            [zip] => 97202
                            [country_iso] => US
                            [country_name] => United States
                            [phone] => 
                            [website] => 
                            [latitude] => 45.50303250000000
                            [longitude] => -122.63560240000000
                            [altitude] => 0.0000000
                            [is_favorite] => 0
                        )

                )

        )

)

*/
	
// -------------------------------------------------------------------


/*
Array
(
    [request] => Array
        (
            [limit] => 2
            [page] => 1
            [start] => 
            [time] => 2009-02-28T12:10:29-0800
            [url] => https://v0.api.shizzow.com/places?populated=true&limit=2
        )

    [results] => Array
        (
            [count] => 7
            [places] => Array
                (
                    [0] => Array
                        (
                            [population] => 2
                            [places_key] => iunNdq
                            [places_name] => Kahler Grand Hotel
                            [address1] => 20 2nd Ave Sw
                            [address2] => 
                            [city] => Rochester
                            [state_iso] => MN
                            [state_name] => Minnesota
                            [zip] => 
                            [country_iso] => US
                            [country_name] => United States
                            [phone] => (507) 280-6200
                            [website] => http://kahler.com/
                            [latitude] => 44.02317000000000
                            [longitude] => -92.46572400000000
                            [altitude] => 0.0000000
                            [is_favorite] => 0
                        )

                    [1] => Array
                        (
                            [population] => 1
                            [places_key] => ihI5f2
                            [places_name] => Casa Del Crunchy
                            [address1] => 2734 SE 29th Ave
                            [address2] => 
                            [city] => Portland
                            [state_iso] => OR
                            [state_name] => Oregon
                            [zip] => 97202
                            [country_iso] => US
                            [country_name] => United States
                            [phone] => 
                            [website] => 
                            [latitude] => 45.50303250000000
                            [longitude] => -122.63560240000000
                            [altitude] => 0.0000000
                            [is_favorite] => 0
                        )

                )

        )

)


*/


	

?>