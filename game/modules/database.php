<?php
/**
 * database.php
 *
 * @version 1.11
 * @copyright 2010 by MadnessRed for XNova Redesigned
 * @copyright 2012 by Geodar for GitHub 
 */

//Create a new class based off mysql
class database {

  var $conn_handler;
	
	//Count number of queries
	public $num_queries = 0;
	
	//ON creation
	public function __construct($dbsettings){
		//Connect
		$this->conn_handler=mysql_connect($dbsettings['server'], $dbsettings['user'], $dbsettings['pass']);
    mysql_select_db($dbsettings['name'],$this->conn_handler);
		
		//Error?
		if (mysql_error()) {
            die('Connect Error  (' .mysql_errno() . ') ' . mysql_error());
        }
        
        //Store db settings
        $this->dbsettings = $dbsettings;
	}
	
	//Create doquery function
	public function doquery($query, $table, $fetch = false){		
		
		//Get the table
		$table = mysql_real_escape_string($table);
		
		//Parse the query
		$query = str_replace("{{table}}", "`".$this->dbsettings["prefix"].$table."`", $query);
		$query = str_replace("{{table_np}}", "`".$table."`", $query);
		$query = str_replace("{{prefix}}", $this->dbsettings["prefix"], $query);
		
		//And then run it
		if ($result = mysql_query($query)) {
			//This is another query
			$this->num_queries ++;
			
			//Should we fetch the data?
			if($fetch){
				return $this->FetchAssoc($result);
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
	
  public function FetchAssoc($results) {
	 //Check if the result is a valid resource
	 if(!is_resource($results))
		// Return false, declaring an error
		return false;
	 else {
		// Retrieve the result as an array
		$array = mysql_fetch_assoc($results);
		// Return the cleaned array
		return $array;
	 }
  }

  public function real_escape_string($string)
  {
    return mysql_real_escape_string($string);
  }
  
	//Validation function
	public function idstring($id,$decimal=false){  //MadnessRed function
		if($decimal){$d = '.'; }else{$d = ''; }
		return (preg_replace("/[^0-9".$d."]/", "", $id) * 1);
	}
	
	//Some useful database functions
	public function id_from_username($uname){
		$result = $this->doquery("SELECT `id` FROM {{table}} WHERE `username` = '".mysql_real_escape_string($uname)."' LIMIT 1 ;", 'users', true);
		$id = @intval($result['id']);
		return $id;
	}
	
	//Some useful database functions
	public function username_from_id($id){
		$result = $this->doquery("SELECT `username` FROM {{table}} WHERE `id` = '".$this->idstring($id)."' LIMIT 1 ;", 'users', true);
		return $result['username'];
	}
  
  public function insert_id()
  {
    return mysql_insert_id();
  }
	
	//Close connection
	public function __destruct(){
		mysql_close($this->conn_handler);
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
	while($row = $sql->FetchAssoc($result)){
		$game_config[$row['config_name']] = $row['config_value'];
	}
}


/**
 * 1.0  - Basic class created MadnessRed
 * 1.1  - Added better construct and the idstring function.
 * 1.11 - Using MySQL insead of MySQLi (Geodar)
 */
?>
