<?php

/**
 * user.php
 *
 * @version 1.0
 * @copyright 2010 by MadnessRed for XNova Redesigned
 */
 

//Create a new user class
class user{
	
	//ID
	public $id = 0;
	
	//Load user stuff
	public function reload(){
		global $sql;
		
		//Get the user array
		$this->uarray = $sql->doquery("SELECT * FROM {{table}} WHERE `id` = '".$sql->idstring($this->id)."' LIMIT 1 ;", 'users', true);
		
		//And parse it into the class
		foreach($this->uarray as $key => $val){
			$this->{$key} = $val;
		}
	}
	
	//Initiate
	public function __construct($id){
		global $sql;
		
		//And get the data
		$this->id = $id;
		$this->reload();
	}
	
	//Get owned planets
	public function get_planets(){
		global $sql;
		
		//Get planets
		$planets = $sql->doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '".$this->id."'", 'planets');
		
		//Parse into an array
		$ids = array();
		while($row = $planets->fetch_assoc())
			$ids[] = $row['id'];
		
		//Return
		return $ids;
	}
	
	//Get current planet
	public function get_cp(){
		return new planet($this->current_planet);
	}
	
	//Set current planet
	public function set_cp($cp){
		global $sql;
		
		//Check we own the planet we are moving to.
		$owned = $this->get_planets();
		if(in_array($cp, $owned)){
			//Set the current planet
			$this->current_planet = $sql->idstring($cp);
			$this->menus_update = time();
			
			//And update in database
			$sql->doquery("UPDATE {{table}} SET `current_planet` = '". $this->current_planet ."', `menus_update` = '".$this->menus_update."' WHERE `id` = '".$this->id."';", 'users');
			
			//And update the array
			$this->uarray['current_planet'] = $this->current_planet;
			$this->uarray['menus_update'] = $this->menus_update;
		}else{
			die('Planet not owned');
		}
		
	}
	
	//Ban user
	public function ban($days, $reason, $admin){
		global $sql;
		
		//Ban the user
		$QryUpdateUser	 = "UPDATE {{table}} SET ";
		$QryUpdateUser	.= "`banned_by` = '". $admin->username ."', ";
		$QryUpdateUser	.= "`banned_until` = '". time() + ($days * 24 * 3600) ."', ";
		$QryUpdateUser	.= "`banned_reason` = '". $reason ."' ";
		$QryUpdateUser	.= "WHERE ";
		$QryUpdateUser	.= "`id` = \"". $this->id ."\";";
		$sql -> doquery($QryUpdateUser, 'users');
	}

}


/**
 * 1.0 - Basic class created MadnessRed
 */
?>
