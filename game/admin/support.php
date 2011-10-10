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
	
if($_GET['ticket'] == 0){
/// Deteilsanzeige des eigenen tickets
	$query = doquery("SELECT * FROM {{table}} WHERE status >= '0' ORDER BY time", "supp");
	while($ticket = mysql_fetch_array($query)){
		/// Status-anzeige
		if($ticket['status']==0){
			$status = colourgreen($lang['statusc']);
		}elseif($ticket['status']==1){
			$status = colourred($lang['statuso']);
		}elseif($ticket['status']==2){
			$status = colourred($lang['statusa']);
		}elseif($ticket['status']==3){
			$status = colourgreen($lang['statusa']);
		}else{
			$status = '?';
		}
		$qry = doquery("SELECT * FROM {{table}} WHERE id = '".idstring($ticket['player_id'])."' LIMIT 1 ;","users",true);	
		$playername = $qry['username'];
		
		if($ticket['status']==0){
			$closelink = "<a href=\"./?page=admin&link=supp&open=1&ticket=".$ticket['ID']."\">".$lang['open']."</a>";
		}else{
			$closelink = "<a href=\"./?page=admin&link=supp&schliessen=1&ticket=".$ticket['ID']."\">".$lang['close']."</a>";		
		}

		/// Status-anzeige ende
		$parse['tickets'.$ticket['status']] .= "<tr>\n"
			."<td class='b'>".$ticket['ID']."</td>\n"
			."<td class='b'>".$playername."</td>\n"
			."<td class='b'><a href='./?page=admin&link=supp&ticket=".$ticket['ID']."'>".$ticket['subject']."</a></td>\n"
			."<td class='b'>".$status."</td>\n"
			."<td class='b'>".date("j-m-Y H:i:s",$ticket['time'])."</td>\n"
			."<td class='b'>".$closelink."</td>\n"
			."</tr>\n\n";
	}
	$parse['tickets']  = $parse['tickets1'].$parse['tickets2'];
	$parse['tickets'] .= "<tr><td colspan=\"6\" align=\"center\">----------</td></tr>\n\n";
	$parse['tickets'] .= $parse['tickets3'];
	$parse['tickets'] .= "<tr><td colspan=\"6\" align=\"center\">----------</td></tr>\n\n";
	$parse['tickets'] .= $parse['tickets0'];
	$parse['actionpage'] = 'admin&link=supp';
	displaypage(parsetemplate(gettemplate('admin/supp'), $parse), 'Support',true);
}elseif($_GET['sendenticket'] =="1"){
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
}elseif($_GET['sendenantwort'] =="1"){
	/// Eintragen der neuen Antwort
	$antworttext = $_POST['senden_antwort_text'];
	$antwortticketid = $_POST['senden_antwort_id'];
	
	if(empty($antworttext) OR empty($antwortticketid)){
		/// Pr�fen ob beide felder mit Text versehen sind
		$parse['actionpage'] = 'admin&link=supp';
		display(parsetemplate(gettemplate('supp_t_send_error'), $parse),'Support',true);
	}else{
		$query = doquery("SELECT * FROM {{table}} WHERE `id` = '".idstring($antwortticketid)."'", "supp");
		while($ticket = mysql_fetch_array($query)){
			$newtext = $ticket['text'].'<br><br><hr><br> <font color="yellow">'.$antworttext.'</font>';
	
			$QryUpdatemsg  = "UPDATE {{table}} SET ";
			$QryUpdatemsg .= "`text` = '". mysql_escape_string($newtext) ."',";
			$QryUpdatemsg .= "`status` = '3'";
			$QryUpdatemsg .= "WHERE ";
			$QryUpdatemsg .= "`id` = '". idstring($antwortticketid) ."' ";
			doquery( $QryUpdatemsg, "supp");				
		}
		$parse['actionpage'] = 'admin&link=supp';
		displaypage(parsetemplate(gettemplate('supp_answ_send'), $parse),'Support',true);
	}
}elseif($_GET['schliessen'] =="1"){
	$QryUpdatemsg  = "UPDATE {{table}} SET `status` = '0' WHERE `id` = '".idstring($_GET['ticket'])."' ";
	doquery( $QryUpdatemsg, "supp");
	info($lang['close_t'],$lang['close_ticket'],"./?page=admin&link=supp");
}elseif($_GET['open'] =="1"){
	$QryUpdatemsg  = "UPDATE {{table}} SET `status` = '2' WHERE `id` = '".idstring($_GET['ticket'])."' ";
	doquery( $QryUpdatemsg, "supp");
	info($lang['open_t'],$lang['open_ticket'],"./?page=admin&link=supp");
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
		$parse['actionpage'] = 'admin&link=supp';

		displaypage(parsetemplate(gettemplate('supp_detail'), $parse),'Support',true);
	}
}
?>