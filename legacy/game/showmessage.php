<?php

/**
 * showmessage.php
 *
 * @version 1
 * @copyright 2009 by Anthony for XNova Redesigned
 */

$message = doquery("SELECT * FROM {{table}} WHERE `message_id` = '".idstring($_GET['id'])."' AND (`message_owner` = '".$user['id']."' OR `message_sender` = '".$user['id']."') LIMIT 1 ;",'messages',true);

$parse = $lang;

$bb = new Simple_BB_Code;

if($message['message_sender'] > 0){
	$messagetext = $bb->parse(htmlentities(stripslashes($message['message_text']),ENT_QUOTES));
}else{
	$messagetext = stripslashes($message['message_text']);
}

$parse['message'] = $messagetext;
$parse['subject'] = htmlentities(stripslashes($message['message_subject']),ENT_QUOTES);
$parse['from'] = htmlentities($message['message_from'],ENT_QUOTES);
$parse['username'] = htmlentities($user['username'],ENT_QUOTES);
$parse['date'] = date("jS F H:i:s",$message['message_time']);


//Thats the basic parts, now lets get previous/next message.
$parse['num'] = $_GET['n'];
$parse['count'] = $_GET['count'];
$parse['next'] = $_GET['next'];
$parse['prev'] = $_GET['prev'];

//now the mesage id
$parse['id'] = idstring($_GET['id']);

//Now links
$parse['l_reply'] = "href=\"./?page=write&to=".$message['message_sender']."&subject=RE:".$parse['subject']."\" rel=\"ibox&width=785&height=490\"";
$parse['l_reply'] = "href=\"./?page=write&to=".$message['message_sender']."&subject=RE:".$parse['subject']."\" target=\"_self\"";

echo AddUniToLinks(parsetemplate(gettemplate('network/show'), $parse));

?>
