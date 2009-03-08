<?php
   
   //echo "userpass = " . $userid_and_password;
   
require_once('lucy.php');
	
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, $shizzowup);

$content = curl_exec( $curl );
$err     = curl_errno( $curl );
$errmsg  = curl_error( $curl );
$curl_response  = curl_getinfo( $curl );
curl_close( $curl );

$curl_response['errno']   = $err;
$curl_response['errmsg']  = $errmsg;
$curl_response['content'] = $content;


// shizzow response codes:

/* 
    * 200 - Successful request.
    * 301 - Moved permanently.
    * 304 - Not modified. There is no new data to return.
    * 400 - Bad request. The syntax of this request could not be understood by the server.
    * 401 - Unauthorized to access this resource. Must provide the proper login credentials to access this resource.
    * 403 - Forbidden. The server understood the request, but refuses to fulfill the request.
    * 404 - Resource not found.
    * 405 - Method not supported.
    * 409 - Conflict. Used when one or more of the parameters passed is invalid or incorrect.
    * 503 - Service unavailable. The Shizzow API is currently handling too many requests, the Shizzow API is offline for maintenance, or the logged-in user has exceeded his/her request quota.

*/

?>   