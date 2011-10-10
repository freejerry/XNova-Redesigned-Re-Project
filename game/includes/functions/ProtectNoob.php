<?php

/**
 * ProtectNoob.php
 *
 * @version 1
 * @copyright 2009 By MadnessRed for XNova Redesigned
 */

function ProtectNoob($input,$currentuser = false){
	if($currentuser){
		global $game_config;

		//We need to get the current user.
		if(is_array($currentuser)){
			//We have co-ords
			$qry = doquery("SELECT `id_owner` FROM {{table}} WHERE `galaxy` = '".idstring($input[0])."' AND `galaxy` = '".idstring($input[1])."' AND `galaxy` = '".idstring($input[2])."' LIMIT 1 ;",'planets',true);
			$uid = $qry['id_owner'];
		}else{
			//We have an id.
			$uid = $currentuser;
		}

		$user = doquery("SELECT `total_points` FROM {{table}} WHERE `id` = '".idstring($uid)."' LIMIT 1 ;",'users',true);
	}else{
		global $user,$game_config;
	}

	if(is_array($input)){
		//We have co-ords
		$qry = doquery("SELECT `id_owner` FROM {{table}} WHERE `galaxy` = '".idstring($input[0])."' AND `galaxy` = '".idstring($input[1])."' AND `galaxy` = '".idstring($input[2])."' LIMIT 1 ;",'planets',true);
		$id = $qry['id_owner'];
	}else{
		//We have an id.
		$id = $input;
	}

	//How many poitns does the attack have?
	$att_pts = $user['total_points'];

	//How many points does the defender have?
	$def_pts = doquery("SELECT `total_points` FROM {{table}} WHERE `id` = '".idstring($id)."' LIMIT 1 ;",'users',true);
	$def_pts = $def_pts['total_points'];

	//Now what the the noob protection threshold?
	$th = ($game_config['stat_settings'] * $game_config['noobprotectiontime']);

	if($def_pts >= $th && ($def_pts * $game_config['noobprotectionmulti']) <= $att_pts){
		//The defender is under the threshold and is less than 20% of the attackers score
		return true;
	}elseif($att_pts >= $th && ($att_pts * $game_config['noobprotectionmulti']) <= $def_pts){
		//The attacker is under the threshold and is less than 20% of the defenders score
		return true;
	}else{
		//Neither of hte above to, we are clear to attack.
		return false;
	}
}

?>