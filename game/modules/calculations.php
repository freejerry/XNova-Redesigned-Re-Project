<?php
/**
 * calculations.php
 *
 * @version 1.0
 * @copyright 2010 by MadnessRed for XNova Redesigned
 */

//Create a new class for calculations
class calculations{
	
	//Missiles
	public function ipm_range($res117){
		return ($user[$resource[117]] * 5) - 1;
	}
	public function ipm_time($systems, $fleet_speed){
		return (($systems * 2) + 1) * 75000 / $fleet_speed;
	}
	
	//Resources
	public function max_storage($level){
		//return BASE_STORAGE_SIZE + ((BASE_STORAGE_SIZE / 2) * floor(pow(1.6,$level))); /* Old formula */
		return (BASE_STORAGE_SIZE / 2) * floor( 2.5 * pow( M_E,(20 * $level) / 33) );
	}
}

//Load class
$calculate = new calculations();

/**
 * 1.0 - Basic class created MadnessRed
 */
?>
