<?php // As of Feb. 2009, this file is included by functions_global.php


/* --- Custom Exception Classes --- */

require_once('lucy.php');

class DatabaseException extends Exception{
		
	public function HandleError($info=''){	
	
		$sep = ' | ';
		$nl = "\n";
		$dt = date('Y.m.d h:i:s'); 
		
		$msg = $dt . $sep . "Database Exception: " . $this->getMessage() . $sep . $info;
		$msg .= $nl;

		
		$emailto = ERR_EMAIL;
		//$writeto = str_replace('/public_html', '', $_SERVER["DOCUMENT_ROOT"]) . 'errorlog.txt';

		error_log($msg, 1, $emailto);
		//error_log($msg, 3, $writeto);
		
		echo $msg;
		
	}


};


class ResultException extends Exception{
		
	public function HandleError($info=''){	
	
		
		$sep = ' | ';
		$nl = "\n";
		$dt = date('Y.m.d h:i:s'); 
		
		$msg = $dt . $sep . "Database Exception: " . $this->getMessage() . $sep . $info;
		$msg .= $nl;
	
		echo $msg;
				
	}
	
	
};





/* -- Message Type Definitions in error_log() --

0  message  is sent to PHP's system logger, using the Operating System's system logging mechanism or a file, depending on what the error_log  configuration directive is set to. This is the default option.
1 	message is sent by email to the address in the destination parameter. This is the only message type where the fourth parameter, extra_headers is used.
2 	No longer an option.
3 	message is appended to the file destination . A newline is not automatically added to the end of the message string.
4 	message is sent directly to the SAPI logging handler. 

*/




?>