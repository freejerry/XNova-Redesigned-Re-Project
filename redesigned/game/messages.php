<?php

/**
 * messages.php
 *
 * @version 2
 * @copyright 2009 by Anthony for XNova Redesigned
 */


//Some notes
//explode(",",$user['messages']) = array(0 => PM,1 => ALLY, 2 => EXP, 3 => BATTLE,4 => ESP,5 => GENERAL);
if(strlen($user['messages']) == 0){ $user['messages'] = '0,0,0,0,0,0'; }


//Check the user exists.
if(!$user){ header("Location: logout.php");} 

//Include the language files
includeLang('messages');
getLang('messages');

//And load them into parse
$parse = $lang;

//Now, what will be done here, Writing messages, then reading messages, then deleting messages.
switch ($_GET['mode']) {
case 'write':
	//Target should be an integer (or id)
	$targetid = idstring($_GET['id']);
	
	//Get the recipient.
	$targetuser = doquery("SELECT `id`,`username`,`galaxy`,`system`,`planet` FROM {{table}} WHERE `id` = '".$targetid."' LIMIT 1;", 'users', true);
	
	//Check he exists
	if(!is_array($targetuser)){ message($lang['mess_no_owner'],$lang['mess_error']); }
	
	//Did they forget something?
	if($_GET["subject"] && $_GET["text"]){
		//Remove anything suspect.
		$message = trim(nl2br(strip_tags(addslashes($_GET['text']),'<br><a><i><p><u><table><td><tr><em><h1><h2><h3><h4><li>ul><ol><blockquote><img><span><font><tbody><sub><sup><flash><windowsmedia><object>')));
		
		$subject = trim(nl2br(strip_tags(addslashes($_GET['subject']),'<br><a><i><p><u><table><td><tr><em><h1><h2><h3><h4><li>ul><ol><blockquote><img><span><font><tbody><sub><sup><flash><windowsmedia><object>')));
			
		//Who should it says its from?
		$from = $user['username'] ." [".$user['galaxy'].":".$user['system'].":".$user['planet']."]";
			
		//Now send the message
		PM( $targetid, $user['id'], $message, $subject, $from);
		
		//Let them know it sent
		die("Message Sent");
	}else{
		//Tell then they forgot something
		//info($lang['mess_no_text_or_subject'],$lang['mess_error'],"./?page=write&to=".$targetid,"<<");
		die($lang['mess_error'].":<br />".$lang['mess_no_text_or_subject']);
	}
	
	break;
	
case 'delete':
	//messcat
	$messcat = intval(idstring($_GET['messcat']));
	
	if($messcat == 666)	{ $status = '0'; }
	else				{ $status = '1'; }
	
	//Slightly modified xnova code here:
	if($_GET['delete'] == 'all'){
		//Delete all messages well don't actually delete, just say they are deleted.
		doquery("UPDATE {{table}} SET `message_deleted` = ".$status." WHERE `message_owner` = '".$user['id']."' ;", 'messages');
	}elseif($_GET['delete'] == 'shown'){
		//Delete all messages well don't actually delete, just say they are deleted.
		doquery("UPDATE {{table}} SET `message_deleted` = ".$status." WHERE `message_owner` = '".$user['id']."' AND `message_type` = '".$messcat."' ;", 'messages');
	}elseif($_GET['delete'] == 'marked'){
		//Delete all marked messages well don't actually delete, just say they are deleted
		foreach($_GET as $Message => $Answer) {
			if (preg_match("/delmes/i", $Message) && $Answer == 'on') {
				$MessId   = str_replace("delmes", "", $Message);
				doquery("UPDATE {{table}} SET `message_deleted` = ".$status." WHERE `message_id` = '".idstring($MessId)."' AND `message_owner` = '".$user['id']."' AND `message_type` = '".$messcat."' ;", 'messages');
			}
		}
	}elseif($_GET['delete'] == 'unmarked'){
		//Delete all unmarked messages well don't actually delete, just say they are deleted.
		foreach($_GET as $Message => $Answer) {
			$CurMess    = preg_match("/showmes/i", $Message);
			$MessId     = str_replace("showmes", "", $Message);
			if (preg_match("/showmes/i", $Message) && !isset($_GET["delmes".$MessId])) {
				doquery("UPDATE {{table}} SET `message_deleted` = ".$status." WHERE `message_id` = '".idstring($MessId)."' AND `message_owner` = '".$user['id']."' AND `message_type` = '".$messcat."' ;", 'messages');
			}
		}
	}
	//info($lang['MessDeleted'],$lang['Deleted'],"./?page=messages&mode=show&messcat=".$messcat,"<<");
	die($lang['MessDeleted']);
	
	break;
	
default:
	//Now read messages... here is the fun part :)
	//What catagory?
	$messcat = idstring($_GET['messcat']);
	$usermessages = explode(",",$user['messages']);
	foreach ($usermessages as $type => $count){
		$parse['mess'.$type] = $count;
	}
	
	//Commander, do they have it?
	if(COMMANDER){		
		//Default mess cat is 0
		if(!$messcat){ $messcat = 0; }
		
		//Now we should load the message type selection.
		$parse['catag'] = parsetemplate(gettemplate('network/messtypes'), $parse);
	}else{		
		//There is not message catagories
		$messcat = 100;
		$parse['hidenc'] = 'style="display:none;"'; //(And no outbox or bin, simple remove the link)
	}
	//Some checks on messtype
	$parse["active".$messcat] = "active "; $trash = 'trash'; $Del = 'Del';
	if($messcat == 101){ $parse["activeout"] = ' aktiv'; $parse['catag'] = ''; }
	elseif($messcat == 666){ $parse["activebin"] = ' aktiv'; $parse['catag'] = ''; }
	else{ $parse["activein"] = ' aktiv'; }
	
	//Now the messcat dependant things
	if($messcat == 100){
		//Get the messages
		$messages = doquery("SELECT * FROM {{table}} WHERE `message_owner` = '".$user['id']."' AND `message_deleted` = 0 ORDER BY `message_time` DESC;", 'messages');
		
		//Set each mess type to 0 unread.
		doquery("UPDATE {{table}} SET `messages` = '0,0,0,0,0,0' WHERE `id` = '".$user['id']."' LIMIT 1 ;",'users');
	}elseif($messcat == 101){
		//Get the messages (no need to mark as read as they are not ours, and of course thwe user has read them as he wrote them)
		//How far back? 2 weeks sounds good
		$from = time() - (3600 * 24 * 7 * 2);
		$messages = doquery("SELECT * FROM {{table}} WHERE `message_sender` = '".$user['id']."' AND `message_time` > '".$from."' ORDER BY `message_time` DESC;", 'messages');
	}elseif($messcat == 666){
		//We need to get deleted mesages.
		//How far back? 2 weeks sounds good
		$from = time() - (3600 * 24 * 7 * 2);
		$messages = doquery("SELECT * FROM {{table}} WHERE `message_owner` = '".$user['id']."' AND `message_time` > '".$from."' AND `message_deleted` = '1' ORDER BY `message_time` DESC;", 'messages');
		//We don't delete here we restore
		 $trash = 'recall'; $Del = 'Res';
	}else{
		//Get the messages for this type.
		$messages = doquery("SELECT * FROM {{table}} WHERE `message_owner` = '".$user['id']."' AND `message_type` = '".idstring($messcat)."' AND `message_deleted` = 0 ORDER BY `message_time` DESC;", 'messages');
		//echo "SELECT * FROM {{table}} WHERE `message_owner` = '".$user['id']."' AND `message_type` = '".idstring($messcat)."' ORDER BY `message_time` DESC;";
		
		//Set messages of this type to 0
		$usermessages[$messcat] = 0;
		foreach ($usermessages as $type => $count){
			if($type < 0 || $type > 5 || intval($type) != $type || idstring($type) != $type){
				unset($usermessages[$type]);
			}
		}
		doquery("UPDATE {{table}} SET `messages` = '".implode(",",$usermessages)."', `menus_update` = '".time()."' WHERE `id` = '".$user['id']."' LIMIT 1 ;",'users');
	}
	
	if(mysql_num_rows($messages) > 0){
		$parse['content']  = "
			\t\t<form action=\"./?page=messages&mode=delete&messcat=".$_GET['messcat']."\" method=\"GET\" id=\"messagesform\" name=\"messagesform\">\n
			\t\t\t<input type=\"hidden\" name=\"page\" value=\"messages\" />\n
			\t\t\t<input type=\"hidden\" name=\"mode\" value=\"delete\" />\n
			\t\t\t<input type=\"hidden\" name=\"messcat\" value=\"".$_GET['messcat']."\" />\n
			\t\t\t<table class=\"list\" id=\"mailz\" cellpadding=\"0\" cellspacing=\"0\">\n
			\t\t\t<tbody>\n
			\t\t\t<tr class=\"first alt\">\n
			\t\t\t\t<th class=\"check\">\n
			\t\t\t\t\t<input class=\"checker\" id=\"checkAll\"onclick=\"likenAll(document.messagesform,'checkAll');\" type=\"checkbox\">\n
			\t\t\t\t</th>\n
			\t\t\t\t\t<th class=\"from\">Sender</th>\n
			\t\t\t\t\t<th class=\"subject\">Subject</th>\n
			\t\t\t\t<th class=\"date\">Date</th>\n
			\t\t\t\t<th class=\"action\"></th>\n
			\t\t\t</tr>\n";
		
		$n = 0;
		while($row = mysql_fetch_array($messages)){
			$n++;
			$parse['content'] .= "
				\t\t\t<input name=\"showmes".$row['message_id']."\" type=\"hidden\" value=\"1\" />
				\t\t\t<tr class=\"trigger alt new\" id=\"".$row['message_id']."TR\">\n
				\t\t\t\t<td class=\"check\">\n
				\t\t\t\t\t<input class=\"checker\" name=\"delmes".$row['message_id']."\" id=\"delmes".$row['message_id']."\" type=\"checkbox\">\n
				\t\t\t\t</td>\n
				\t\t\t\t<td class=\"from\">".$row['message_from']."</td>\n
				\t\t\t\t<td class=\"subject\">\n
				\t\t\t\t\t<a class=\"ajax_thickbox\" id=\"".$row['message_id']."\" href=\"#\" onclick=\"mrbox('./?page=showmessage&id=".$row['message_id']."&cat=".idstring($messcat)."&n=".$n."&count=".mysql_num_rows($messages)."&iframe=1&iheight=800',800)\">\n
				\t\t\t\t\t\t".$row['message_subject']."\n
				\t\t\t\t\t</a>\n
				\t\t\t\t</td>\n
				\t\t\t\t<td class=\"date\">".date("jS F H:i",$row['message_time'])."</td>\n
				\t\t\t\t<td class=\"actions\" id=\"test\">\n
				\t\t\t\t\t<a href=\"#\" rel=\"".$row['message_id']."\" class=\"del tips deleteIt\" onmouseover=\"mr_tooltip('Delete this message');\" onclick=\"document.getElementById('delmes".$row['message_id']."').checked=true;document.getElementById('delmethod').value='marked';document.getElementById('okbutton').style.display='inline';\" id=\"2\">\n
				\t\t\t\t\t\t<img src=\"".GAME_SKIN."/img/icons/".$trash.".gif\">\n
				\t\t\t\t\t</a>\n
				\t\t\t\t</td>\n
				\t\t\t</tr>\n";
		}	
		$parse['content'] .= "
			\t\t\t</tr>\n
			\t\t\t<tr class=\"last alt\">\n
			\t\t\t\t<td colspan=\"3\" align=\"left\">\n
			\t\t\t\t\t<select class=\"choose\" id=\"delmethod\" name=\"delete\" onchange=\"document.getElementById('okbutton').style.display='inline';\">\n
			\t\t\t\t\t\t<option class=\"underlined\">".$lang['DelAktion']."</option>\n
			\t\t\t\t\t\t<option class=\"method\" value=\"marked\">".$lang[$Del.'Mark']."</option>\n
			\t\t\t\t\t\t<option class=\"method\" value=\"unmarked\">".$lang[$Del.'Unmark']."</option>\n
			\t\t\t\t\t\t<option class=\"method\" value=\"shown\">".$lang[$Del.'Shown']."</option>\n
			\t\t\t\t\t\t<option class=\"method\" value=\"all\">".$lang[$Del.'All']."</option>\n
			\t\t\t\t\t\t</select>\n
			\t\t\t\t\t\t<!--<input name=\"submit\" value=\"OK2\" class=\"buttonOK deleteIt\" id=\"okbutton\" style=\"display: none;\" type=\"submit\">-->\n
			\t\t\t\t\t\t<input type=\"button\" class=\"buttonOK deleteIt\" id=\"okbutton\" value=\"OK\" onclick=\"mr_alert('<img height=16 width=16 src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}...'); getAXAH(form2get('messagesform'),'errorBoxNotifyContent');\" style=\"display: none;\" />\n
			\t\t\t\t</td>\n
			\t\t\t\t<td colspan=\"2\">\n
			\t\t\t\t\t<div class=\"selectContainer\">\n
			\t\t\t\t\t</div>\n
			\t\t\t\t</td>\n
			\t\t\t</tr>\n
			\t\t\t</tbody>\n
			\t\t\t</table>\n
			\t\t</form>\n";
	}else{
		$parse['content'] .= "No messages found";
	}
}

if($_GET['axah_section']){
	echo $parse['catag'];
	echo '<div id="messageContent" class="msg_content textBeefy textCenter">';
	echo $parse['content'];
	echo '</div>';
	die();
}elseif($_GET['axah']){
	makeAXAH(parsetemplate(gettemplate('network/messages'), $parse));
}else{
	displaypage(parsetemplate(gettemplate('network/messages'), $parse),$lang['mess_pagetitle']);
}

?>
