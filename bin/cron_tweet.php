<?php


if (!isset($_SESSION)) {
	session_start();
}	

require_once('lucy.php');

if ($_GET['tp'] != TWEET_CRON_PASS) { 
	echo 'Access denied.';
	exit;
};


	// Find Shizzeeps
	
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
				if ($curcityname == 'PortlandOR') {
					$url .= '/pdx/';
				} else if ($curcityname == 'AustinTX') {
					$url .= '/aus/';
				}

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
	
	
	

	

?>