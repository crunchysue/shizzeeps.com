<?php

	$limit = 2;

	require_once('lucy.php');
	if ($_GET['fp'] != FIND_SHIZZEEPS_CRON_PASS) { 
		echo 'Access denied.';
		exit;
	};
	
	$shizzowup = SHIZZOWUP;

	$url = 'https://v0.api.shizzow.com/places?populated=true&limit=' . $limit;
	
	include 'shizzow_get.php';

	echo $curl_response['http_code'];

	if ($curl_response['http_code'] == '200') {
		
		$json = $curl_response['content']; // echo data as json string
		$dbsafejson = addslashes($json);
		
		$places = $data->results->places;
		
		try {
			require_once "db.php";
			$db = new db();
			
			// Delete the old places
			$sql1 = "DELETE FROM Places";
			$db->query($sql1);
			
			// Delete the old shouts
			$sql2 = "DELETE FROM Shouts";
			$db->query($sql2);
			
			// Insert the new places
			$sql3 = 'INSERT INTO Places (city, json) ';
			$sql3 .= 'VALUES("all", "' . $dbsafejson . '")';
			$db->query($sql3);
			
			// Insert the shouts
			foreach($places as $place) {
			
				$key = $place->places_key;
				StoreShouts($key, "all");
				
			}// for each				
			
					
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
function StoreShouts($key, $city) {

	global $shizzowup;	
	$url = "https://v0.api.shizzow.com/places/$key/shouts?when=recently&who=everyone&limit=100";
	include 'shizzow_get.php';
	
	
	if ($curl_response['http_code'] == '200') {
		
		$json = $curl_response['content']; // echo data as json string
		$dbsafejson = addslashes($json);
		
		try {
			$db = new db();
			
			$sql = "INSERT INTO Shouts (city, places_key, json) VALUES (";
			$sql .= '"' . $key . '", "' . $city . '", "' . $dbsafejson . '")';
			echo $sql;
			$db->query($sql);
			
			$db = null;
		}
		catch (DatabaseException $e) {
		  $e->HandleError();
		}
		catch (ResultException $e) {
		  $e->HandleError();
		}
		
		
		
		
		
		/*
		echo '<hr /><pre>'; 
		print_r($data);	
		echo '</pre><hr />';
		*/


	}
	
	
}//StoreShouts()
	



?>