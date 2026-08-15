<?php

/**
 * BinaryDecode.php
 *
 * @version 1.0
 * @copyright 2009 by MadnessRed for XNova Redesigned
 */

function BinaryDecode($bin,$bit = 'auto',$true = true,$false = false,$fill = true){
	if($bit == 'auto'){
		$bit = ceil(log($bin,2)) + 1;
	}
	$num = pow(2,($bit - 1));
	$stop = false; $return = array();
	while($stop == false){
		if($num <= $bin){
			$return[$num] = $true;
			$bin -= $num;
		}else{
			if($fill){ $return[$num] = $false; }
		}
		$num /= 2;
		$bit --;
		
		if($bit < 1){ $stop = true; }
	}
	return $return;
}

?>