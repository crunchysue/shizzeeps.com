<?php
// This cron job runs once an hour, and deletes all the ephemeral messages that are too old.

	require_once "db.php";
	
	try {
	
		$sql = "DELETE FROM Messages WHERE timediff(now(), MsgTime) > '01:00:00';";
		$db = new db();
		$result = $db->query($sql);	
	}
			
	// CATCH THE BUGS
	catch (DatabaseException $e) {
	  $e->HandleError();
	}
	catch (ResultException $e) {
	  $e->HandleError();
	}

?>