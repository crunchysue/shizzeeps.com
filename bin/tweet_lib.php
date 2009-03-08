<?php


function send_tweet($tweet) {
	
	require_once('lucy.php');
		
	$url = 'http://twitter.com/statuses/update.json';
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, "$url");
	curl_setopt($curl_handle,CURLOPT_REFERER,"http://shizzeeps.com/");
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_handle, CURLOPT_POST, 1);
	
//	$tweet = urlencode($tweet);
	
	$tweet = html_entity_decode($tweet, ENT_QUOTES, 'UTF-8');
	
	str_replace("&", "&amp;", $tweet);
	
	$post_fields =  "source=shizzeeps&status=$tweet";
	
	
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS,$post_fields);
	curl_setopt($curl_handle, CURLOPT_USERPWD, TWITTERUP);
	$buffer = curl_exec($curl_handle);
	$info = curl_getinfo($curl_handle);
	
	
		echo '<pre><hr />sending tweet: ' . $tweet . '<br >twitter info: ';
		print_r ($info);
		echo '</pre>';

	//return $buffer;
	//echo $buffer;
	
}

?>