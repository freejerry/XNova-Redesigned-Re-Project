<?php

/*
===========================================================
 Created by Sk3y ICQ: 270270011
===========================================================
 File: support.php
-----------------------------------------------------------
 Version: 1.0 (08.07.2008)
===========================================================
*/

includeLang('supp');
$parse     = $lang;
				
if(($_GET['ticket']) == 0){
/// Deteilsanzeige des eigenen tickets
	$query = doquery("SELECT * FROM {{table}} WHERE `player_id` = '".idstring($user['id'])."'", "supp");
	while($ticket = mysql_fetch_array($query)){
		/// Status-anzeige
		if($ticket['status']==0){
			$status = colourred($lang['statusc']);
		}elseif($ticket['status']==1){
			$status = colourgreen($lang['statuso']);
		}else{
			$status = colourred($lang['statusa']);
		}
		/// Status-anzeige ende
		$parse['tickets'] .= "<tr>"
			."<td class='b'>".$ticket['ID']."</td>"
			."<td class='b'><a href='./?page=ticket&ticket=".$ticket['ID']."'>".$ticket['subject']."</a></td>"
			."<td class='b'>".$status."</td>"
			."<td class='b'>".date("j-m-Y H:i:s",$ticket['time'])."</td>"
			."</tr>";
	}
	$parse['gett'] = $_GET['t'];
	$parse['actionpage'] = 'ticket';
	displaypage(parsetemplate(gettemplate('supp'), $parse), 'Support',true);
}elseif($_GET['sendenticket'] == "1"){
	/// Eintragen eines Neuen Tickets
	$subject = $_POST['senden_ticket_subject'];
	$tickettext = $_POST['senden_ticket_text'];
	$time = time();
	
	if(empty($tickettext) OR empty($subject)){
		/// Pr�fen ob beide felder mit Text versehen sind
		info($lang['sendit_error_msg'],$lang['sendit_error'],"./?page=ticket");
	}else{
		$Qryinsertticket  = "INSERT {{table}} SET ";
		$Qryinsertticket .= "`player_id` = '". idstring($user['id']) ."',";
		$Qryinsertticket .= "`subject` = '". mysql_escape_string($subject) ."',";
		$Qryinsertticket .= "`text` = '". mysql_escape_string($tickettext) ."',";
		$Qryinsertticket .= "`time` = '". intval($time) ."',";
		$Qryinsertticket .= "`status` = '1'";
		doquery( $Qryinsertticket, "supp");
					
		info($lang['sendit_t'],$lang['supp_header'],"./?page=ticket");
	}
}elseif($_GET['sendenantwort'] == "1"){
	/// Eintragen der neuen Antwort
	$antworttext = $_POST['senden_antwort_text'];
	$antwortticketid = $_POST['senden_antwort_id'];
	
	if(empty($antworttext) OR empty($antwortticketid)){
		/// Pr�fen ob beide felder mit Text versehen sind
		$parse['actionpage'] = 'ticket';
		display(parsetemplate(gettemplate('supp_t_send_error'), $parse),'Support',true);
	}else{
	
		$query = doquery("SELECT * FROM {{table}} WHERE `id` = '".idstring($antwortticketid)."'", "supp");
		while($ticket = mysql_fetch_array($query)){
			$newtext = $ticket['text'].'<br><br><hr><br> <font color="yellow">'.$antworttext.'</font>';
	
			$QryUpdatemsg  = "UPDATE {{table}} SET ";
			$QryUpdatemsg .= "`text` = '". mysql_escape_string($newtext) ."',";
			$QryUpdatemsg .= "`status` = '2'";
			$QryUpdatemsg .= "WHERE ";
			$QryUpdatemsg .= "`id` = '". idstring($antwortticketid) ."' ";
			doquery( $QryUpdatemsg, "supp");				
		}
		$parse['actionpage'] = 'ticket';
		displaypage(parsetemplate(gettemplate('supp_answ_send'), $parse),'Support',true);
	}
}else{
/// Listenanzeige der eigenen tickets
	$query2 = doquery("SELECT * FROM {{table}} WHERE `ID` = '".idstring($_GET['ticket'])."'", "supp");
	while($ticket2 = mysql_fetch_array($query2)){
		if($ticket2['status']==0){
			$status = colourred($lang['statusc']);
			$parse['answer_new'] = $lang['close_t'];
		}elseif($ticket2['status']==1){
			$status = colourgreen($lang['statuso']);
			$parse['eintrag'] ='
			<textarea name="senden_antwort_text" class="textBox" rows="30" cols="20" onFocus="this.value=\'\'; this.onfocus=null;"></textarea>
			<center><input class="button188" type="submit" name="send" value="'.$lang['send'].'"></center>';
		}else{
			$status = colourred($lang['statusa']);
			$parse['eintrag'] ='
			<textarea name="senden_antwort_text" class="textBox" rows="30" cols="20" onFocus="this.value=\'\'; this.onfocus=null;"></textarea>
			<center><input class="button188" type="submit" name="send" value="'.$lang['send'].'"></center>';
		}
		$parse['tickets'] .= "<tr>"
			."<td class='b'>".$ticket2['ID']."</td>"
			."<td class='b'>".$ticket2['subject']."</td>"
			."<td class='b'>".$status."</td>"
			."<td class='b'>".date("j-m-Y H:i:s",$ticket2['time'])."</td>"
			."</tr>";

		$parse['text_view'] = $ticket2['text'];
		$parse['id'] = $ticket2['ID'];
		$parse['actionpage'] = 'ticket';
		displaypage(parsetemplate(gettemplate('supp_detail'), $parse),'Support',true);
	}

}

?>