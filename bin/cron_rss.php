<?php

require_once('lucy.php');
require_once('db.php');

if (empty($_GET['fp']) || $_GET['fp'] != FIND_SHIZZEEPS_CRON_PASS) { 
	echo 'Access denied.';
	exit;
}


$limit = 10;

$shizzowup = 'crunchydev3:' . RSSPASS;

// get places
$url = 'https://v0.api.shizzow.com/places?populated=truelimit=' . $limit;
include 'shizzow_get.php';
$places_json = $curl_response['content']; // echo data as json string
$places_data = json_decode($places_json);

if ($curl_response['http_code'] != '200') {
	echo'response code from getting places: ' .  $curl_response['http_code'];
	exit;
}


// store it all in the db
$serialized = serialize($places_data);

try{
	$db = new db();
	
	// delete old data
	$sql = "DELETE FROM Storage WHERE City = 'rss';";
	$db->query($sql);
	
	// add the new data
	$escaped = mysql_real_escape_string  ($serialized);
	$sql = "INSERT INTO Storage (Data, City) VALUES ('$escaped', 'rss')";
	//echo "<hr/>$sql<hr/>";
	$db->query($sql);
	$db = null;	
}
catch (DatabaseException $e) {
  $e->HandleError();
}
catch (ResultException $e) {
  $e->HandleError();
}


echo '<hr />PLACES DATA:<hr /><pre>'; 
print_r($places_data);	
echo '</pre><hr />';

?>
