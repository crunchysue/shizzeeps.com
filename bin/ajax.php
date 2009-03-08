<?php

if (!isset($_SESSION)) {
	session_start();
}	

// Cookie expiration time (sec * min * hours * days)
$cookie_expiration = time()+60*60*24*30;

require_once ($_SERVER['DOCUMENT_ROOT'] . "/htmlpurifier-3.3.0/library/HTMLPurifier.auto.php");
$purifier = new HTMLPurifier();

$f = $purifier->purify( $_REQUEST['f'] );


switch ($f) {
			
	case 'dets' :
		WhoIsHere();
		break;
		
	case 'getmsgs' :
		GetMessages();
		break;
		
	case 'login' :
		Login();
		break;
		
	case 'logout' :
		Logout();
		break;
		
	case 'putmsg' :
		PutMessage();
		break;
		
	case 'setfilters' :
		SetFilters();
		break;
		
	case 'shizzeeps' :
		FindShizzeeps();
		break;
	
}


function SetFilters() {
	
	global $purifier;
	
	$_SESSION['st'] =  $purifier->purify($_POST['st']);
	$_SESSION['city'] =  $purifier->purify($_POST['city']);
	
}



function Logout() {
	unset($_SESSION['u']);
	unset($_SESSION['p']);
}



function Login() {	

	global $purifier;
	
	if (!empty($_POST['username'])) {
		$_SESSION['u'] =  $purifier->purify($_POST['username']);
	}
	
	if (!empty($_POST['password'])) {
		$_SESSION['p'] =  $purifier->purify($_POST['password']);  
	}

	//header('Location: http://shizzow.com/');
}



function FindShizzeeps() {

	global $purifier;
	
	$limit = 15;

	$shizzowup = $_SESSION['u'] . ":" . $_SESSION['p'];
	
	$url = 'https://v0.api.shizzow.com/places?populated=true';

	if (!empty($_SESSION['city'])) {
		$city = $_SESSION['city'];
		$url .= '&cities=' . $city;
		setcookie("city", $city, $cookie_expiration, '/');
	}
	
	if (!empty($_SESSION['st'])) {
		$st = $_SESSION['st'];
		$url .= '&states=' . $st;
		setcookie("st", $st, $cookie_expiration, '/');
	}
	
	$url .= '&limit=' . $limit;

	include 'shizzow_get.php';
	echo $curl_response['content']; // echo data as json string
	
	if ($curl_response['http_code'] != '200') {
		echo $curl_response['http_code'];
	}
	
}


function WhoIsHere() {

	global $purifier;

	$shizzowup = $_SESSION['u'] . ":" . $_SESSION['p'];

	$key = $_GET['id'];
	
	//$url = "https://v0.api.shizzow.com//shouts?places_key=$key&shouts_by_places_key=true&when=recently&who=everyone&limit=100";
	
	$url = "https://v0.api.shizzow.com/places/$key/shouts?when=recently&who=everyone&limit=100";

	include 'shizzow_get.php';

	echo $curl_response['content']; // echo data as json string
	
}//WhoIsHere


function PutMessage() {

	global $purifier;

	require_once "db.php";
	
	$themessage =  $purifier->purify($_POST['msg']);
	$newid = GetNextMsgId();
	$fromid = $_SESSION['u'];
	$placeid =  $purifier->purify($_POST['placeid']);
	
		
	try {
		$db = new db();
		
		$sql = "INSERT INTO Messages (MsgId, MsgFrom, MsgTo, MsgText) VALUES($newid, '$fromid', '$placeid', '$themessage');";
		
		$result = $db->query($sql);
		
		$db = null;

	}// try block
	
		
	// CATCH THE BUGS
	catch (DatabaseException $e) {
	  $e->HandleError();
	}
	catch (ResultException $e) {
	  $e->HandleError();
	}

	
	
}//PutMessage


function GetNextMsgId() {

	try{
	
		$sql = "SELECT MsgId FROM Messages ORDER BY MsgId DESC Limit 1;";
		$db = new db();
		$result = $db->query($sql);
		
		$oldid = $result->fetchRow();
				
		$newid = intval($oldid['MsgId']) + 1;
		
		return $newid;
	
	}// try block
	
		
	// CATCH THE BUGS
	catch (DatabaseException $e) {
	  $e->HandleError();
	}
	catch (ResultException $e) {
	  $e->HandleError();
	}
	
}



function GetMessages() {

	require_once "db.php";
	global $purifier;
	
	if (!empty($_GET['placeid'])) {
		$places_key = $purifier->purify($_GET['placeid']);
	}
	
	try {
		$sql = "SELECT MsgFrom, MsgTime, MsgText FROM Messages ";
		$sql .= "WHERE MsgTo = '$places_key' ORDER BY MsgTime DESC;";
		//echo $sql;
		$db = new db();
		$result = $db->query($sql);
		$rows = array();

		while($row = $result->fetchRow()) {
    		$rows[] = $row;
		}

		echo json_encode($rows);
	}// try block
	
		
	// CATCH THE BUGS
	catch (DatabaseException $e) {
	  $e->HandleError();
	}
	catch (ResultException $e) {
	  $e->HandleError();
	}

}


?>