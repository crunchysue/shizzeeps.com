<?php

// http://www.devshed.com/c/a/PHP/Handling-MySQL-Data-Set-Failures-in-PHP-5/3/

error_reporting(E_ALL);

require_once "errors.php";

//include '/home/shizzeep/.htpasswds/dbconnect.php';

require_once('lucy.php');

class db {

	private $conn = null;
	private $dbhost = DBHOST;
	private $dbuser = DBUSER;
	private $dbpass = DBPASS;
	private $dbname = DBNAME;
	
	// dev values
	
	//private $dbuser = 'root';
	//private $dbpass = '';
	
		
	
	public function __construct(){
	
		$this->connectDB();
	
	}	
	
	// connect to the database	
	private function connectDB(){
	
		if (!$this->conn = mysql_connect($this->dbhost, $this->dbuser, $this->dbpass)){		
			throw new DatabaseException("Holy that's-what-she-said, Batwoman - the database is on fire!");
		}
		
		if(!mysql_select_db($this->dbname,$this->conn)){		
			throw new DatabaseException('Error selecting database');
		}
	
	}
	
	// run query	
	public function query($query){
	
		if(!$this->result=mysql_query($query,$this->conn)){
			throw new ResultException('Error performing query '.$query);		
		}
		
		return new Result($this,$this->result);
	
	}
	
	
	

}



class Result {

	private $db;	
	private $result;
	
	
	public function __construct($db,$result){
		
		$this->db = $db;		
		$this->result = $result;
	
	}

	// fetch row
	public function fetchRow(){
	
		if(!$row=mysql_fetch_assoc($this->result)){
			return false;
		}
		
		return $row;
	
	}

	// count rows
	public function countRows(){
	
		if(!$rows=mysql_num_rows($this->result)){		
			throw new ResultException('Error counting rows');		
		}
		
		return $rows;
	
	}

	// count affected rows
	public function countAffectedRows(){
	
		if(!$rows=mysql_affected_rows($this->db->conn)){		
			throw new ResultException('Error counting affected rows');		
		}
		
		return $rows;
	
	}
	
	// get ID of last-inserted row	
	public function getInsertID(){
	
		if(!$id=mysql_insert_id($this->db->conn)){		
			throw new ResultException('Error getting ID');		
		}
		
		return $id;
	
	}
	
	// seek row	
	public function seekRow($row=0){
	
		if(!is_int($row)||$row<0){		
			throw new ResultException('Invalid result set offset');		
		}
		
		if(!mysql_data_seek($this->result,$row)){		
			throw new ResultException('Error seeking data');		
		}
	
	}

}

?>
