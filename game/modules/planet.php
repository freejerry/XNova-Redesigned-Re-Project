<?php

/**
 * user.php
 *
 * @version 1.0
 * @copyright 2010 by MadnessRed for XNova Redesigned
 */
 

//Create a new user class
class planet{
	
	//ID
	public $id = 0;
	
	//Load user stuff
	public function reload($usesql = true){
		global $sql;
		
		//Get the user array
		if($usesql)
			$this->parray = $sql->doquery("SELECT * FROM {{table}} WHERE `id` = '".$sql->idstring($this->id)."' LIMIT 1 ;", 'planets', true);
		
		//And parse it into the class
		foreach($this->parray as $key => $val){
			$this->{$key} = $val;
		}
	}
	
	//Initiate
	public function __construct(){
		global $sql;
		
		//Arguments
		$this->args = func_get_args();
		
		//Did we get an id?
		if(sizeof($this->args) == 1){
			$this->parray = $sql->doquery("SELECT * FROM {{table}} WHERE `id` = '".$sql->idstring($this->args[0])."' LIMIT 1 ;", 'planets', true);
		}
		//Or galaxy,system,planet, planet_type
		elseif(sizeof($this->args) >= 3){
			$this->galaxy = $sql->idstring($this->args[0]);
			$this->system = $sql->idstring($this->args[1]);
			$this->planet = $sql->idstring($this->args[2]);
			$this->planet_type = ($sql->idstring($this->args[3]) > 0 ? $sql->idstring($this->args[3]) : 1);
			$this->parray = $sql->doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$this->galaxy."' AND `system` = '".$this->system."' AND `planet` = '".$this->planet."' AND `planet_type` = '".$this->planet_type."' LIMIT 1 ;", 'planets', true);
		}
		//Else
		else{
			die(nl2br(print_r($this->args,true)));
		}
		
		//Should we load the data?
		$load = true;
		if(sizeof($this->args) >= 5)
			$load = $this->args[4];
		
		//And get the data
		if($load)
			$this->reload(false);
	}
	
	public function get_level($id){
		return $this->{$resource[$id]};
	}
	
	public function type(){
		
		//Get the basic type
		$de_planettype = preg_replace("/[^a-z]/", "", $this->image);
		if($de_planettype == "mond"){
			$array['type'] = "moon";
		}elseif($de_planettype == "dschjungelplanet"){
			$array['type'] = "jungle";
		}elseif($de_planettype == "eisplanet"){
			$array['type'] = "ice";
		}elseif($de_planettype == "gasplanet"){
			$array['type'] = "gas";
		}elseif($de_planettype == "trockenplanet"){
			$array['type'] = "dry";
		}elseif($de_planettype == "wasserplanet"){
			$array['type'] = "water";
		}elseif($de_planettype == "wuestenplanet"){
			$array['type'] = "desert";
		}else{
			$array['type'] = "normal";
		}
		
		//To get planet sub type (01 to 10) well will remove all except numbers. To remove the leading zeros, times by 1.
		$array['subtype'] = (preg_replace("/[^0-9]/", "", $this->image)) * 1;
		
		//Return
		return $array;
	}
	
	public function is_moon(){
		return ($this->planet_type == 3);
	}
	
	public function has_moon(){
		global $sql;
		
		$result = $sql->doquery("SELECT `id` FROM {{table}} WHERE `galaxy` = '".$this->galaxy."' AND `system` = '".$this->system."' AND `planet` = '".$this->planet."' AND `id` <> '".$this->id."' AND `planet_type` <> '2' LIMIT 1 ;",'planets',true);
		
		$this->moon_id = @intval($result['id']);
		
		return ($this->moon_id > 0);		
	}
	
	public function get_moon(){
		if(!isset($this->moon_id)){ $this->has_moon(); }
		if($this->moon_id > 0){
			return new planet($this->moon_id);
		}else{
			return false;
		}
	}
	
	//Function to generate resources income.
	public function production_rates($thisuser){
		global $ProdArray, $game_config, $resource, $resources, $sql, $calculate;
		
		//Need to get the rate of production on this planet
		$production = array();
		
		//If we are not in vacation mode
		if($thisuser->urlaubs_modus == 0){
		
			//See how full the storage is
			$space = array();
			foreach($resources as $res){
				$production[$res.'_max'] = $calculate->max_storage($this->{$res.'_store'});
				if($this->{$res} >= $production[$res.'_max']){
					$space[$res] = false;
				}else{
					$space[$res] = true;
				}
			}
		
			//Loop through all the elements which contribute to the production of resources
			foreach($ProdArray as $element => $prod){
		
				//Some values for the evaluated formulas
				$BuildTemp = $this->temp_max;
				$BuildLevelFactor = $this->{$resource[$element]."_porcent"};
				$BuildLevel = $this->{$resource[$element]};
		
				//Loop through the basic resources
				foreach($resources as $res){
			
					//How much does this particular element give
					if($space[$res]){
						$production[$element][$res.'_perhour'] = eval($ProdArray[$element][$res]) * ($game_config['resource_multiplier']) * (1 + ( $thisuser->{$resource[604]}  * 0.1));
					}else{
						$production[$element][$res.'_perhour'] = 0;
					}
				
					//Add this elements production to the total
					$production[$res.'_perhour'] += $production[$element][$res.'_perhour'];
				}
			
				//Now for energy
				$Energy = eval($ProdArray[$element]['energy']) * $game_config['resource_multiplier'];
			
				//Are we consuming energy or producing
				if($Energy > 0){
					//Producing energy
					$production[$element]['energy_max'] = $Energy * (1 + ($thisuser->{$resource[603]} * 0.1));
					$production['energy_max'] += $production[$element]['energy_max'];
				}else{
					//Using energy
					$production[$element]['energy_used'] = $Energy;
					$production['energy_used'] += $Energy;
				}
			}
			
			//Production factor.
			$production['factor'] = 1;
			
			//If we are using more energy than we have
			if($production['energy_used'] + $production['energy_max'] < 0){
			
				//Work out the amount we need to scale down to, to meet the energy available.
				$production['factor'] = abs($production['energy_max'] / $production['energy_used']);
				
				//Now reduce all production by this much, for each resource
				foreach($resources as $res){
					
					//Overall production
					$production[$res.'_perhour'] *= $production['factor'];
					
					//Foreach element
					foreach($ProdArray as $element => $prod){
					
						//Production for each element
						$production[$element][$res.'_perhour'] *= $production['factor'];
					}
				}
			}
		}
		
		//Basic income.
		if((BASE_PROD_ON_MOONS && $this->planet_type == 3) || $this->planet_type == 1){
			foreach($resources as $res){
				$production['base'][$res.'_perhour'] = $game_config[$res.'_basic_income'];
				$production[$res.'_perhour'] += $production['base'][$res.'_perhour'];
			}
		}
		
		//Update the object and the database
		$updates = array();
		
		//Resources
		foreach($resources as $res){
			//Make sure they are all numbers
			$production[$res.'_perhour'] = $sql->idstring($production[$res.'_perhour']);
			$production[$res.'_max'] = $sql->idstring($production[$res.'_max']);
		
			//Database
			$updates[] = '`'.$res.'_perhour'.'` = \''.$production[$res.'_perhour'].'\'';
			$updates[] = '`'.$res.'_max'.'` = \''.$production[$res.'_max'].'\'';
			
			//Object
			$this->{$res.'_perhour'} = $production[$res.'_perhour'];
			$this->{$res.'_max'} = $production[$res.'_max'];
		}
		
		//Energy
		//Make sure they are all numbers
		$production['energy_used'] = $sql->idstring($production['energy_used']);
		$production['energy_max'] = $sql->idstring($production['energy_max']);
		
		//Database
		$updates[] = '`energy_used` = \''.$production['energy_used'].'\'';
		$updates[] = '`energy_max` = \''.$production['energy_max'].'\'';
			
		//Object
		$this->{'energy_used'} = $production['energy_used'];
		$this->{'energy_max'} = $production['energy_max'];
		
		//Commit database updates
		$query = 'UPDATE {{table}} SET ' . implode(' , ',$updates) . ' WHERE `id` = \''.$this->id.'\' ;';
		$sql->doquery($query,'planets');
		
		//Return production
		return $production;
	}
	
	
	//Update resources on the planet
	public function resource_update($time=false){
		global $resources;
		
		//Update resource production
		
		
		//How long since last update?
		if(!$time){ $time = time(); }
		$productiontime = $time - $this->last_update;
		
		//How many resources have been produces
		$produced = array();
		foreach($resources as $res){
			$produced[$res] = $this->{$res.'_perhour'} * $productiontime / 3600;
		}
		
	}
}


/**
 * 1.0 - Basic class created MadnessRed
 */
?>
