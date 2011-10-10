<?php

function AddPoints($points, $perma = false, $id = false){
	global $user;
	
	if(!$id){ $id = $user['id']; }
	//echo "Adding ".$points." to user ".$user['username']."<br />";
		
	if($points < 0){ $sign = "-"; $points = mod(idstring($points)); }else{ $sign = "+"; }
	
	
	if($perma){
		$permapart = ", `perma_points` = `perma_points` ".$sign." '".idstring($points)."'";
	}
	
	
	doquery("UPDATE {{table}} SET `total_points` = `total_points` ".$sign." '".idstring($points)."'".$permapart." WHERE `id` = '".idstring($id)."' ;",'users');
}

?>