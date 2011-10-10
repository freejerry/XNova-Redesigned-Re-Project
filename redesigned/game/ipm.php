<?php

/**
 * ipm.php
 *
 * @version 1.0
 * @copyright 2009 by Anthony for XNova Redesigned
 */

//For the sake of good comenting, I'm gonna tell you that here we are laoding the language files.
getLang('galaxy');

//If we are submitting via ajax
if($_GET['count'] >= 1 && $_GET['galaxy'] > 0){
	$_POST = $_GET;
}

//By saying if count is less than 1, we also eliminate the change of a user trying to send negative ipms or 0 ipms.
if($_POST['count'] < 1){
	$parse=$lang;

	//Get target gal, sys and pos.
	$parse['g'] = idstring($_GET['gal']);
	$parse['s'] = idstring($_GET['sys']);
	$parse['p'] = idstring($_GET['pos']);

	//How many ipms should we allow him to send, note that this is not that important as we will check later.
	$parse['avl'] = $planetrow[$resource[503]];
	$parse['strlen'] = strlen($parse['avl']);

	//output the template
	echo AddUniToLinks(parsetemplate(gettemplate('galaxy/nuke'),$parse));
}else{
	//Where should the be redirected to?
	$redirect = "./?page=galaxy&galaxy=".$_POST['galaxy']."&system=".$_POST['system']."&mode=1";
	//We can only attack this galaxy
	if($planetrow['galaxy'] == $_POST['galaxy']){
		//Get the range
		$range = eval($formulas['ipm_range']);

		//How far are we trying to go?
		$systems = abs($planetrow['system'] - $_POST['system']);

		//Check if we target is within the range
		if($range >= $systems){
			//Get the target id
			$targetrow = doquery("SELECT `id`,`id_owner` FROM {{table}} WHERE `galaxy` = '".idstring($_POST['galaxy'])."' AND `system` = '".idstring($_POST['system'])."' AND `planet` = '".idstring($_POST['position'])."' LIMIT 1 ;",'planets',true);
			
			//Check planet exists.
			if($targetrow['id'] > 0){

				//Now check for noob protection.
				if(!ProtectNoob($target)){

					//Check vacation mode
					$urlaubs = doquery("SELECT `urlaubs_until` FROM {{table}} WHERE `id` = '".$targetrow['id_owner']."' LIMIT 1 ;",'users',true);
					if($urlaubs['urlaubs_until'] < time()){
						
						//Check he has the ipms he is sending
						if($planetrow[$resource[503]] >= idstring($_POST['count'])){
						
							//How long will it take and when will we get there?
							$duration = eval($formulas['ipm_speed']);

							//Insert fleet into out new fleets table.
							$QryInsertFleet  = "INSERT INTO {{table}} SET ";
							$QryInsertFleet .= "`mission` = '10', ";
							$QryInsertFleet .= "`shipcount` = '".idstring($_POST['count'])."', ";
							$QryInsertFleet .= "`array` = '503,".idstring($_POST['count'])."', ";
							$QryInsertFleet .= "`departure` = '".time()."', ";
							$QryInsertFleet .= "`arrival` = '".($duration + time())."', ";
							$QryInsertFleet .= "`target_userid` = '".$targetrow['id_owner']."', ";
							$QryInsertFleet .= "`target_id` = '".$targetrow['id']."', ";
							$QryInsertFleet .= "`owner_userid` = '".$planetrow['id_owner']."', ";
							$QryInsertFleet .= "`owner_id` = '".$planetrow['id']."', ";
							$QryInsertFleet .= "`target` = '".idstring($_POST['target'])."' ;";
							doquery( $QryInsertFleet, 'fleets');
						
							//Remove the sent ipms from the planet							doquery("UPDATE {{table}} SET `".$resource[503]."` = `".$resource[503]."` - '".idstring($_POST['count'])."' WHERE `id` = '".$planetrow['id']."' LIMIT 1;", 'planets');
							
							//The missiles were sent.
							die($lang['ipm_sent']);
						}else{
							//Not enough ipms
							die($lang['ipm_not_enough']);
						}
					}else{
						//He got player in vacation mode
						die($lang['ipm_he_is_in_vaca']);
					}
				}else{
					//He got a noob
					die($lang['ipm_he_is_a_noob']);
				}
			}else{
				//He got a noob
				die($lang['ipm_no_planet'].': '.$_POST['galaxy'].':'.$_POST['system'].':'.$_POST['position'].'.');
			}
		}else{
			//Them them there is an error with the range.
			die($lang['ipm_wrong_sys']);
		}
	}else{
		//Them them there is an error with the range.
		die($lang['ipm_wrong_gal']);
	}
}

//02/04/2009 - Code checked using Zend Code Analizer. 0 Errors

?>
