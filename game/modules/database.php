<?php

/**
 * database.php
 *
 * @version 1.1
 * @copyright 2010 by MadnessRed for XNova Redesigned
 */


//Create a new class based off mysqli
class database extends mysqli{
	
	//Count number of queries
	public $num_queries = 0;
	
	//ON creation
	public function __construct($dbsettings){
		//Connect
		parent::__construct($dbsettings['server'], $dbsettings['user'], $dbsettings['pass'], $dbsettings['name']);
		
		//Error?
		if (mysqli_connect_error()) {
            die('Connect Error  (' .mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }
        
        //Store db settings
        $this->dbsettings = $dbsettings;
	}
	
	//Create doquery function
	public function doquery($query, $table, $fetch = false){		
		
		//Get the table
		$table = parent::real_escape_string($table);
		
		//Parse the query
		$query = str_replace("{{table}}", "`".$this->dbsettings["prefix"].$table."`", $query);
		$query = str_replace("{{table_np}}", "`".$table."`", $query);
		$query = str_replace("{{prefix}}", $this->dbsettings["prefix"], $query);
		
		//And then run it
		if ($result = parent::query($query)) {
			//This is another query
			$this->num_queries ++;
			
			//Should we fetch the data?
			if($fetch){
				return $result->fetch_assoc();
			}else{
				return $result;
			}
		
		}else{
			//Backtrace for logging the error
			$info = debug_backtrace();
			$callingfile = $info[0]['file']; $callingline = $info[0]['line'];
			
			//$this->error is a bug in php, it should be parent::error. This may be fixed in a later version of php, meaning this will need editing.
			trigger_error($this->error."<br />".$query."^|^SQL Error^|^".$callingfile."^|^".$callingline);
			return false;
			
		}
	}
	
	//Validation function
	public function idstring($id,$decimal=false){  //MadnessRed function
		if($decimal){$d = '.'; }else{$d = ''; }
		return (preg_replace("/[^0-9".$d."]/", "", $id) * 1);
	}
	
	//Some useful database functions
	public function id_from_username($uname){
		$result = $this->doquery("SELECT `id` FROM {{table}} WHERE `username` = '".parent::real_escape_string($uname)."' LIMIT 1 ;", 'users', true);
		$id = @intval($result['id']);
		return $id;
	}
	
	//Some useful database functions
	public function username_from_id($id){
		$result = $this->doquery("SELECT `username` FROM {{table}} WHERE `id` = '".$this->idstring($id)."' LIMIT 1 ;", 'users', true);
		return $result['username'];
	}
	
	//Close connection
	public function __destruct(){
		parent::close();
	}
}

//Should we load config
if(@!$skip_config){
	//Load the database settings
	require(ROOT_PATH.'config'.UNIVERSE.'.php');

	//Load the database
	$sql = new database($dbsettings);

	//Remove the database settings
	unset($dbsettings);


	//Get the game config
	$result = $sql->doquery("SELECT * FROM {{table}} WHERE 1",'config');
	$game_config = array();
	while($row = $result->fetch_assoc()){
		$game_config[$row['config_name']] = $row['config_value'];
	}
}


/**
 * 1.0 - Basic class created MadnessRed
 * 1.1 - Added better construct and the idstring function.
 */
?>
