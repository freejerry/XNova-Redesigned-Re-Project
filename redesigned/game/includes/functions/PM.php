<?php

/**
 * PM.php
 *
 * @version 1.1
 * @copyright 2009 by MadnessRed for XNova Redeisgned
 */

function PM($to,$from,$message,$subject='',$sender='',$type=0) {
	
	//Add the message to the databas (xnova code) with a bit of security modification
	$QryInsertMessage  = "INSERT INTO {{table}} SET ";
	$QryInsertMessage .= "`message_owner` = '".idstring($to)."', ";
	$QryInsertMessage .= "`message_sender` = '".idstring($from)."', ";
	$QryInsertMessage .= "`message_text` = '".mysql_real_escape_string(addslashes($message))."', ";
	$QryInsertMessage .= "`message_subject` = '".mysql_escape_string(addslashes($subject))."', ";
	$QryInsertMessage .= "`message_from` = '".mysql_real_escape_string(addslashes($sender))."', ";
	$QryInsertMessage .= "`message_type` = '".idstring($type)."', ";
	$QryInsertMessage .= "`message_time` = '" .time(). "';";
	doquery( $QryInsertMessage, 'messages');
	
	//Get the target
	$target = doquery("SELECT `id`,`messages` FROM {{table}} WHERE `id` = '".idstring($to)."' LIMIT 1 ;",'users',true);
	
	//Set messages of this type to +1
	if(strlen($target['messages']) == 0){ $target['messages'] = '0,0,0,0,0,0'; }
	$messages = explode(",",$target['messages'],6);
	if($type < 0 || $time > 5){ $type = 5; }
	$messages[$type] += 1;
	$newmessages = implode(",",$messages);
	//$newmessages = $messages[0].",".$messages[1].",".$messages[2].",".$messages[3].",".$messages[4].",".$messages[5];
	doquery("UPDATE {{table}} SET `messages` = '".$newmessages."', `menus_update` = '".time()."' WHERE `id` = '".$target['id']."' LIMIT 1 ;",'users');

}

function GroupPM($recipricants,$from,$message,$subject='',$sender='',$type=1){
	foreach($recipricants as $to){
		PM($to,$from,$message,$subject,$sender,$type);
	}
}

// Changelog:
// 1.0 - First release for XNova Redesigned (MadnessRed)
// 1.1 - Group PM added (MadnessRed)

?>
