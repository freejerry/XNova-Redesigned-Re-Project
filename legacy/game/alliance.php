<?php
/**
 * alliance.php
 *
 * @version 2.0
 * @copyright 2009 by MadnessRed for XNova Redesigned
 */

//right a blank php file, let make an alliance page :)

//Get the language
getLang('alliance');

//Load the bbcode class
$bb = new Simple_BB_Code;


if ($_GET['page'] == 'ainfo') {
	$a = intval($_GET['allyid']);
	$tag =  addslashes($_GET['tag']);
	// Evitamos errores casuales xD
	// query
	$parse = array();
	$parse['Alliance_information'] = $lang['ainfo'];

	if (isset($_GET['tag']) and $_GET['tag'] != '') {
		$allyrow = doquery("SELECT * FROM {{table}} WHERE ally_tag='{$tag}'", "alliance", true);
	} elseif (is_numeric($a) && $a != 0) {
		$allyrow = doquery("SELECT * FROM {{table}} WHERE id='{$a}'", "alliance", true);
	} else {
		message($lang["NoSuchAlliance"], "Error");
	}
	// Si no existe
	if (!$allyrow) {
		message($lang["NoSuchAlliance"], "Error");
	}
	extract($allyrow);

	if ($ally_image != "") {
		$ally_image = "<tr><th colspan=2><img src=\"{$ally_image}\"></td></tr>";
	}

       if ($ally_description != "") {
          $ally_description = $ally_description;
       } else{
          $ally_description = $lang["NoAllyDesc"];
       }

	if ($ally_web != "") {
		$ally_web = "<tr>
		<th>{$parse['Initial_page']}</th>
		<th><a href=\"{$ally_web}\">{$ally_web}</a></th>
		</tr>";
	}

	$parse['ally_member_scount'] = $ally_members;
	$parse['ally_name'] = $ally_name;
	$parse['ally_tag'] = $ally_tag;
    $ally_description = nl2br($ally_description);

	$parse['ally_description'] = nl2br($ally_description);
	$parse['ally_image'] = $ally_image;
	$parse['ally_web'] = $ally_web;

	$parse['bewerbung'] = "<tr>
	  <th>Unirse</th>
	  <th><a href=\"alliance.php?mode=apply&allyid=" . $allyrow['id'] . "\">Unete a esta alianza</a></th>

	</tr>";

	$page .= parsetemplate(gettemplate('alliance_ainfo'), $parse);
	if($_GET['axah']){
		makeAXAH($page);
	}else{
		displaypage($page, str_replace('%s', $ally_name, $lang['Info_of_Alliance']));
	}
	die();
	
}

$parse = $lang;
//Firstly are they in an alliance?
if($user['ally_id'] == 0){
	//no
	
	//Are we trying to join an alliance?
	if($_GET['mode'] == 'apply'){
		//Load the headers
		$parse['search_ally'] = $parse['apply'];
		$parse['onclick2'] = "mrbox('./?page=cerca&iframe=1&iheight=800',800)";
		$parse['header_tpl'] = parsetemplate(gettemplate('alliance/header_noally'),$parse);
		
		if(strlen($_GET['text']) * idstring($_GET['id']) > 0){
			doquery("UPDATE {{table}} SET `ally_request` = '".idstring($_GET['id'])."', `ally_request_text` = '".htmlentities(mysql_real_escape_string($_GET['text']))."', `ally_register_time` = '".time()."' WHERE `id` = ".$user['id'],'users',true);
			header("Location: ".AddUniToString('./?page=network&axah='.$_GET['axah']));
			die();
		}else{
			//They haven't submitted the form, lets give it to them.
			$parse['allyid'] = $_GET['id'];
			if($_GET['axah']){
				makeAXAH(parsetemplate(gettemplate('alliance/apply'),$parse));
			}else{
				displaypage(parsetemplate(gettemplate('alliance/apply'),$parse),$lang['title']);
			}
		}
		
	}else{
		//We must be creating then or waiting to be acepted/rejected
		//have we applied?
		if($user['ally_request'] > 0 && $_GET['mode'] != 'create'){
			//Load the headers
			$parse['search_ally'] = $parse['application'];
			$parse['onclick2'] = "loadpage('./?page=network','".$parse['Alliance']."','network')";
			$parse['header_tpl'] = parsetemplate(gettemplate('alliance/header_noally'),$parse);
			
			$allyrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['ally_request']."' LIMIT 1 ;",'alliance',true);
			$parse['ally_tag'] = $allyrow['ally_tag'];
			
			if($_GET['axah']){
				makeAXAH(parsetemplate(gettemplate('alliance/applied_notin'),$parse));
			}else{
				displaypage(parsetemplate(gettemplate('alliance/applied_notin'),$parse),$lang['title']);
			}
			
			
		}else{
			//we are creating
			
			//Load the headers
			if($user['ally_request'] > 0){
				$parse['search_ally'] = $parse['application'];
				$parse['onclick2'] = "loadpage('./?page=network','".$parse['Alliance']."','network')";
			}else{
				$parse['onclick2'] = "mrbox('./?page=cerca&iframe=1&iheight=800',800)";
			}
			$parse['header_tpl'] = parsetemplate(gettemplate('alliance/header_noally'),$parse);
			
			//They are creating an alliance.
			if($_POST['tag'] && $_POST['name']){
				//ok we are gonna create an alliance. First check if the tag already exists.
				$query = doquery("SELECT * FROM {{table}} 
					WHERE `ally_name` = '".mysql_real_escape_string(cleanstring($_POST['name']))."' LIMIT 1 ;", 'alliance');
				if(mysql_num_rows($query) > 0){ 
					info($lang['name_in_use'],$lang['create_error'],'./?page=network&mode=create','<<');
				}
				$query = doquery("SELECT * FROM {{table}} 
					WHERE `ally_tag`  = '".mysql_real_escape_string(cleanstring($_POST['tag']))."'  LIMIT 1 ;", 'alliance');
				if(mysql_num_rows($query) > 0){ 
					info($lang['tag_in_use'],$lang['create_error'],'./?page=network&mode=create','<<');
				}
				//nope it doesn't exist. Now we add it into the table
				doquery("INSERT INTO {{table}} SET
					`ally_name`='".mysql_real_escape_string($_POST['name'])."',
					`ally_tag`='".mysql_real_escape_string($_POST['tag'])."' ,
					`ally_owner`='".$user['id']."',
					`ally_register_time`=" . time() , "alliance") or die("Error code: ".__LINE__);
				
				$allyquery = doquery("SELECT `id`,`ally_name`,ally_owner_range FROM {{table}} WHERE ally_tag='".mysql_real_escape_string($_POST['tag'])."'", 'alliance', true);
				
				doquery("UPDATE {{table}} SET `ally_id`='".$allyquery['id']."', 
					`ally_name`='".$allyquery['ally_name']."',
					`ally_register_time`='".time()."', 
					`ally_rank_name` = '".$allyquery['ally_owner_range']."', 
					`ally_rank` = '511'
					WHERE `id`='".$user['id']."'", "users") or die("Error code: ".__LINE__);
				
				//Lets report the sucess.
				info($lang['ally_made'],$lang['create_done'],'./?page=network','<<');
			}else{
				//They haven't submitted the form, lets give it to them.
				if($_GET['axah']){
					makeAXAH(parsetemplate(gettemplate('alliance/noally'),$parse));
				}else{
					displaypage(parsetemplate(gettemplate('alliance/noally'),$parse),$lang['title']);
				}
			}
			
		}
		
	}
}else{
	//Load the headers
	$parse['header_tpl'] = parsetemplate(gettemplate('alliance/header'),$parse);
	
	//yes they are
	//lets get there rank...
	$user['permisions'] = BinaryDecode($user['ally_rank'],9);
	$permisions = array(
		  1 => 'View memberlist',
		  2 => 'View online status',
		  4 => 'Circular Message',
		  8 => 'Show Applications',
		 16 => 'Process Applications',
		 32 => 'Kick users',
		 64 => 'Mange alliance',
		128 => 'Right hand',
		256 => 'Disband Alliance'
	);
	$allyrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['ally_id']."' LIMIT 1 ;",'alliance',true);
	
	//ok what page are the on
	switch ($_GET['mode']){
	case 'admin':
		
		if(!$user['permisions'][64]){
			header("Location: ".AddUniToString('./?page=network&axah='.$_GET['axah']));
			die();
		}
		
		$parse['name'] = $allyrow['ally_name'];
		$parse['tag'] = $allyrow['ally_tag'];
		$parse['www'] = addslashes($allyrow['ally_web']);
		
		$parse['request']  = addslashes($allyrow['ally_request']);
		$parse['internal'] = addslashes($allyrow['ally_text']);
		$parse['external'] = addslashes($allyrow['ally_description']);
		
		$parse['image'] = addslashes($allyrow['ally_image']);
		
		$admin = doquery("SELECT `id`,`ally_rank_name` FROM {{table}} WHERE `id` = '".$allyrow['ally_owner']."' LIMIT 1;",'users',true);
		$parse['foundername'] = $admin['ally_rank_name'];
		
		if($_GET['change']){
			switch($_GET['change']){
			case "ranks":
				$ranks = array();
				foreach($_GET as $id => $val){
					$r = explode(",",$id);
					if(sizeof($r) == 2){
						if(($r[1] == idstring($r[1])) && ($val == 1)){
							$ranks[$r[0]] += ($val * $r[1]);
						}
						if($r[1] == 'rankname'){
							doquery("UPDATE {{table}} SET `ally_rank_name` = '".mysql_real_escape_string($val)."' WHERE `ally_id` = '".$allyrow['id']."' AND `id` = '".mysql_real_escape_string($r[0])."' AND `ally_rank_name` <> '".mysql_real_escape_string($val)."' LIMIT 1;",'users');
						}
					}
				}
				foreach($ranks as $name => $perm){
					//doquery("UPDATE {{table}} SET `ally_rank` = '".$perm."' WHERE `ally_id` = '".$allyrow['id']."' AND `ally_rank_name` = '".$name."' ;",'users');
					if($allyrow['ally_owner'] != $name){
						doquery("UPDATE {{table}} SET `ally_rank` = '".idstring($perm)."' WHERE `ally_id` = '".$allyrow['id']."' AND `id` = '".$name."' ;",'users');
					}
				}
				break;
			case "texts":
				$allyrow_query = "UPDATE {{table}} SET ";
				if(mysql_real_escape_string(strip_tags($_GET['ally_internal'])) != $allyrow['ally_text']){
					$allyrow_query .= "`ally_text` = '".mysql_real_escape_string(strip_tags($_GET['ally_internal']))."', ";
				}
				if(mysql_real_escape_string(strip_tags($_GET['ally_external'])) != $allyrow['ally_description']){
					$allyrow_query .= "`ally_description` = '".mysql_real_escape_string(strip_tags($_GET['ally_external']))."', ";
				}
				if(mysql_real_escape_string(strip_tags($_GET['ally_request'])) != $allyrow['ally_request']){
					$allyrow_query .= "`ally_request` = '".mysql_real_escape_string(strip_tags($_GET['ally_request']))."', ";
				}
				$allyrow_query .= "`id` = '".$allyrow['id']."' WHERE `id` = '".$allyrow['id']."' LIMIT 1 ;";
				doquery($allyrow_query,'alliance');
				break;
			case "basic":
				//ally_join,logo,homepage,foundername
				doquery("UPDATE {{table}} SET `ally_web` = '".mysql_escape_string(strip_tags($_GET['homepage']))."', `ally_image` = '".mysql_escape_string(strip_tags($_GET['logo']))."', `ally_request_notallow` = '".mysql_escape_string(strip_tags($_GET['ally_closed']))."' WHERE `id` = '".$allyrow['id']."' LIMIT 1 ;",'alliance');
				doquery("UPDATE {{table}} SET `ally_rank_name` = '".mysql_escape_string(strip_tags($_GET['foundername']))."' WHERE `id` = '".$allyrow['ally_owner']."' AND `ally_id` = '".$allyrow['id']."' LIMIT 1;",'users');
				break;
			case "tag":
				//Change name or tag
				if(strlen($_GET['newtag']) > 1){
					doquery("UPDATE {{table}} SET `ally_tag` = '".substr(mysql_escape_string(strip_tags($_GET['newtag'])), 0, 8)."' WHERE `id` = '".$allyrow['id']."' LIMIT 1;",'alliance');
				}
				if(strlen($_GET['newname']) > 1){
					doquery("UPDATE {{table}} SET `ally_name` = '".substr(mysql_escape_string(strip_tags($_GET['newname'])), 0, 32)."' WHERE `id` = '".$allyrow['id']."' LIMIT 1;",'alliance');
				}
				break;
			case "delete":
				//Change name or tag
				if($user['permisions'][256]){
					if(sha($_GET['confirm']) == $user['password']){
						//Deal with users
						$members = array();
						$memberquery = doquery("SELECT `id` FROM {{table}} WHERE `ally_id` = '".$user['ally_id']."' ;",'users',false);
						while($row = FetchArray($memberquery)){ $members[] = $row['id']; }
						
						//Set the members to have no alliance
						doquery("UPDATE {{table}} SET `ally_id` = '0' , `ally_name` = '' , `ally_register_time` = '0' , `ally_rank` = '0' , `ally_rank_name` = 'Newbie' WHERE `ally_id` = '".$user['ally_id']."' ;",'users');
						
						//Delete the alliance
						doquery("DELETE FROM {{table}} WHERE `id` = '".$user['ally_id']."' LIMIT 1",'alliances');
						
						//Message everyone
						$message = "On ".date("j[\s\up]S[/\s\up] F Y \a\t H:i:s",time())." the alliance '".$user['ally_name']."' was disbanded. You can now apply to join another alliance or create your own. This is an automated message. Any replies will be sent to ".$user['username'].".";
						GroupPM($members,$user['id'],$message,'Alliance Disbanded',$allyrow['ally_name'],1);
						
						//Back to main page
						header("Location: ".AddUniToString('./?page=network&axah='.$_GET['axah']));	
					}					
				}else{
					$message = "On ".date("j[\s\up]S[/\s\up] F Y \a\t H:i:s",time())." the player '".$user['username']."' attempted to delete your alliance '".$allyrow['ally_name']."'. The deletion was rejected as he did not have the nescisery permissions to do so. This is an automated messaging, and replies will be sent to ".$user['username'].".";
					PM($allyrow['ally_owner'],$user['id'],$message,"ATTEMPTED DELETION OF ALLIANCE",$allyrow['ally_name'],1);
				}
				break;
			case "newleader":
				//Change name or tag
				if($user['permisions'][128]){
					//Who are they nomination to take over?
					$CurrentUser = doquery("SELECT `id`,`ally_rank`,`ally_rank_name`,`ally_id` FROM {{table}} WHERE `id` = '".idstring($_GET['next'])."' LIMIT 1 ;",'users',true);
					$CurrentAdmin = doquery("SELECT `id`,`ally_rank`,`ally_rank_name`,`ally_id` FROM {{table}} WHERE `id` = '".idstring($allyrow['ally_owner'])."' LIMIT 1 ;",'users',true);
					
					//Can they take over?
					$CurrentUser['permissions'] = BinaryDecode($CurrentUser['ally_rank'],9);
					if($CurrentUser['permissions'][128] && $CurrentUser['ally_id'] == $user['ally_id']){
						//Seems legit - do it
						doquery("UPDATE {{table}} SET `ally_rank` = '".$CurrentAdmin['ally_rank']."', `ally_rank_name` = '".$CurrentAdmin['ally_rank_name']."' WHERE `id` = '".$CurrentUser['id']."' LIMIT 1 ;",'users');
						doquery("UPDATE {{table}} SET `ally_rank` = '".$CurrentUser['ally_rank']."', `ally_rank_name` = '".$CurrentUser['ally_rank_name']."' WHERE `id` = '".$CurrentAdmin['id']."' LIMIT 1 ;",'users');
						doquery("UPDATE {{table}} SET `ally_owner` = '".$CurrentUser['id']."' WHERE `id` = '".$allyrow['id']."' LIMIT 1 ;",'alliance');
					}
					
				}
				break;
			}
		}
		//Now get the $allrow updated
		$allyrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['ally_id']."' LIMIT 1 ;",'alliance',true);
		$parse['name'] = $allyrow['ally_name'];
		$parse['tag'] = $allyrow['ally_tag'];
		$parse['www'] = addslashes($allyrow['ally_web']);
		$parse['request']  = addslashes($allyrow['ally_request']);
		$parse['internal'] = addslashes($allyrow['ally_text']);
		$parse['external'] = addslashes($allyrow['ally_description']);
		$parse['image'] = addslashes($allyrow['ally_image']);
		
		$memberquery = doquery("SELECT `id`,`username`,`ally_rank_name`,`ally_rank` FROM {{table}} 
			WHERE `ally_id` = '".$allyrow['id']."' ORDER BY `ally_rank` DESC ;",'users');
		
		if($user['ally_rank'] >= 128){
			if($user['permisions'][256]){
				$parse['del_link'] = '
				<li>
					<a onclick="ShowContent(\'oneAllyQuit\');HideContent(\'twoAllyQuit\');" id="tabIntern">
						<span>Delete this alliance</span>
					</a>
				</li>';
			}
			if($user['permisions'][128]){
				$parse['hand_link'] = '
				<li>
					<a onclick="HideContent(\'oneAllyQuit\');ShowContent(\'twoAllyQuit\');" id="tabExtern">
						<span>Handover alliance</span>
					</a>
				</li>';
				
				$sucessors = doquery("SELECT `id`,`username` FROM {{table}} WHERE `ally_id` = '".$allyrow['id']."' AND `ally_rank` >= 128 AND (`ally_rank` < 256 OR `ally_rank` >= (256+128)) AND `id` <> '".$allyrow['ally_owner']."' ;",'users');
				
				$parse['next_list'] = "<select name=\"next\">\n"; $n = 0;
				while($row = mysql_fetch_array($sucessors)){
					$parse['next_list'] .= "<option value=\"".$row['id']."\">".$row['username']."</option>\n"; $n++;
				}
				if($n == 0){
					$parse['next_list'] = "Alliance can not be passed on. You need a successor ranked \"right hand\"\n";
				}else{
					$parse['next_list'] .= "</select>\n";
				}
			}
		}else{
			$parse['stop_delete'] = 'style="display:none;"';
		}
		
		$n = 0;
		$parse['ranks'] = '';
		while ($row = FetchArray($memberquery)){
			$n++;
			
			$lastclick = time() - $row['onlinetime'];
			if($lastclick > 20){
				$activeon = 'Off';
				$activeover = 'over';
			}else{
				$activeon = 'On';
				$activeover = 'under';	
			}
			$perm = array();
			if($allyrow['ally_owner'] == $row['id']){
				$dis = " disabled=\"disabled\"";
				for($p = 1; $p <= 256; $p += $p){
					$perm[$p] = " checked=\"checked\"";
				}
			}else{
				$dis = "";
				$perm = BinaryDecode($row['ally_rank'],9," checked=\"checked\"");
			}
			$parse['ranks'] .= "
				<tr id=\"rankRights".$n."\" class=\"\">
					<td class=\"desc\" style=\"width:100px;\">".$row['username']."</td>
					<td class=\"desc\" style=\"width:100px;\">
						<input type=\"text\" class=\"textInput\" maxlength=\"32\" name=\"".$row['id'].",rankname\" value=\"".$row['ally_rank_name']."\" style=\"width:90px;\" />
					</td>
					<td class=\"check\"><input type=\"checkbox\" name=\"".$row['id'].",256\" value=\"1\" ".$perm[256].$dis." /></td>
					<td class=\"check\"><input type=\"checkbox\" name=\"".$row['id'].",32\"  value=\"1\" ".$perm[32] .$dis." /></td>
					<td class=\"check\"><input type=\"checkbox\" name=\"".$row['id'].",8\"   value=\"1\" ".$perm[8]  .$dis." /></td>
					<td class=\"check\"><input type=\"checkbox\" name=\"".$row['id'].",16\"  value=\"1\" ".$perm[16] .$dis." /></td>
					<td class=\"check\"><input type=\"checkbox\" name=\"".$row['id'].",1\"   value=\"1\" ".$perm[1]  .$dis." /></td>
					<td class=\"check\"><input type=\"checkbox\" name=\"".$row['id'].",2\"   value=\"1\" ".$perm[2]  .$dis." /></td>
					<td class=\"check\"><input type=\"checkbox\" name=\"".$row['id'].",64\"  value=\"1\" ".$perm[64] .$dis." /></td>
					<td class=\"check\"><input type=\"checkbox\" name=\"".$row['id'].",4\"   value=\"1\" ".$perm[4]  .$dis." /></td>
					<td class=\"check\"><input type=\"checkbox\" name=\"".$row['id'].",128\" value=\"1\" ".$perm[128].$dis." /></td>
				</tr>
			";
		}
		
		if($_GET['axah']){
			makeAXAH(parsetemplate(gettemplate('alliance/admin'),$parse));
		}else{
			displaypage(parsetemplate(gettemplate('alliance/admin'),$parse),$lang['title']);
		}
		break;
	case 'circ':
		
		if(!$user['permisions'][4]){
			header("Location: ".AddUniToString('./?page=network&axah='.$_GET['axah']));
			die();
		}
		
		if($_POST['text']){
			if($_POST['rank'] == 'all'){
				$reciprecants = FetchAll(doquery("SELECT `id` FROM {{table}} WHERE `ally_id` = '".$allyrow['id']."' ;",'users'));
			}elseif(strlen($_POST['rank']) > 0){
				$reciprecants = FetchAll(doquery("SELECT `id` FROM {{table}} WHERE `ally_id` = '".$allyrow['id']."' AND `ally_rank_name` = '".mysql_real_escape_string($_POST['rank'])."' ;",'users'));
			}else{
				info("Circular message was not sent","Error",'./?page=network&mode=circ','./?page=network&mode=circ');
				die();
			}
			
			$message = "Player ".$user['username']." tells you the following:\n".mysql_real_escape_string(htmlentities($_POST['text']));
			$subject = "Circular mail of alliance [".$allyrow['ally_tag']."]";
				
			GroupPM($reciprecants,$user['id'],$message,$subject,$user['username'],1);
			info("Circular message has been sent","Reference",'./?page=network&mode=circ','./?page=network&mode=circ');
			die();
		}else{
			$ranks = FetchAll(doquery("SELECT `ally_rank_name` FROM {{table}} WHERE `ally_id` = '".$allyrow['id']."' GROUP BY `ally_rank_name` ;",'users'));
			
			$parse['ranks'] = '';
			foreach($ranks as $rank){
				$parse['ranks'] .= '<option value="'.$rank.'">Only rank: '.$rank.'</option>';
			}
			
			if($_GET['axah']){
				makeAXAH(parsetemplate(gettemplate('alliance/circ'),$parse));
			}else{
				displaypage(parsetemplate(gettemplate('alliance/circ'),$parse),$lang['title']);
			}
		}
		
		//On send, info("Circular message has been sent","Reference",'./?page=network&mode=circ','<<');
		break;
		
	case 'apps':
		
		if(!$user['permisions'][8]){
			header("Location: ".AddUniToString('./?page=network&axah='.$_GET['axah']));
			die();
		}

		$appid = idstring($_GET['id']);
		if($appid > 0 && ($_GET['action'] == 'acc' || $_GET['action'] == 'dec') && $user['permisions'][16]){
			
			//Get teh user being dealt with
			$CurrentUser = doquery("SELECT * FROM {{table}} WHERE `id` = '".$appid."' LIMIT 1 ;",'users',true);
			
			//Does this person actually want to join the alliance?
			if($CurrentUser['ally_request'] == $user['ally_id']){
				//Are we accepting or rejecting
				if($_GET['action'] == 'acc'){
					doquery("UPDATE {{table}} SET `ally_id` = '".$user['ally_id']."' , `ally_name` = '".$user['ally_name']."' , `ally_rank` = '0' , `ally_rank_name` = 'Newbie' , `ally_register_time` = '".time()."' , `ally_request` = '0' WHERE `id` = '".$appid."' AND `ally_request` = '".$allyrow['id']."' LIMIT 1 ;",'users');
				
					//If it worked
					if(mysql_affected_rows() == 1){
						doquery("UPDATE {{table}} SET `ally_members` = `ally_members` + 1 WHERE `id` = '".$user['ally_id']."' LIMIT 1 ;",'alliance');
					}
					
				}else{
					doquery("UPDATE {{table}} SET `ally_request` = 0 WHERE `id` = '".$appid."' LIMIT 1 ;",'users');
				}
				
				//Do we have a message to send to the user?
				if(strlen($_GET['message']) > 0){
					$subject = $lang['YourApp'].$allyrow['ally_name'];
					PM($appid,$user['id'],mysql_real_escape_string(htmlentities($_GET['message'])),$subject,$allyrow['ally_name'],1);
				}
				
			}			
		}
		
		//And display other apps as normal
		
		$apps = doquery("SELECT `id`,`username`,`ally_request_text` FROM {{table}} WHERE `ally_request` = '".$user['ally_id']."' ;",'users');
		if(mysql_num_rows($apps) > 0){
			$parse['table']  = "\t\t\t<table class=\"members\">\n";
			$parse['table'] .= "\t\t\t\t<tr class=\"alt\">\n";
			$parse['table'] .= "\t\t\t\t\t<th class=\"nr\">#</td>\n";
			$parse['table'] .= "\t\t\t\t\t<th class=\"desc\">Name:</td>\n";
			$parse['table'] .= "\t\t\t\t\t<th class=\"desc\">Application date:</td>\n";
			$parse['table'] .= "\t\t\t\t\t<th class=\"action\">Action</td>\n";
			$parse['table'] .= "\t\t\t\t</tr>\n\n";
			$n = 0;
			while($row = FetchArray($apps)){
				$n++;
				$row['n'] = $n;
				$row['Alliance'] = $lang['Alliance'];
				$row['applied'] = date("j<\s\up>S</\s\up> F Y",$row['ally_register_time']);
				$parse['table'] .= parsetemplate(gettemplate('alliance/approw'),$row);
			}
			$parse['table'] .= "\t\t\t</table>\n";
		}else{
			$parse['table']  = '
			<table class="members">
				<tr>
					<td class="nr" align="center">- No applications found -</td>
				</tr>				 
			</table>';
		}
			
		if($_GET['axah']){
			makeAXAH(parsetemplate(gettemplate('alliance/apps'),$parse));
		}else{
			displaypage(parsetemplate(gettemplate('alliance/apps'),$parse),$lang['title']);
		}
		
		
		break;
		
	case "leave":
		
		//So they want to leave?
		if($user['id'] != $allyrow['ally_owner']){	//Admin can't leave
			doquery("UPDATE {{table}} SET `ally_id` = '0' , `ally_name` = '' , `ally_register_time` = '0' , `ally_rank` = '0' , `ally_rank_name` = 'Newbie' WHERE `id` = '".$user['id']."' ;",'users');
			doquery("UPDATE {{table}} SET `ally_members` = `ally_members` - 1 WHERE `id` = '".$user['ally_id']."' LIMIT 1 ;",'alliance');
		}
		
		//Back to alliance page
		header("Location: ".AddUniToString('./?page=network&axah='.$_GET['axah']));
		die();
		
		break;
		
	case "kick":
		
		//So they want to remove this guy?
		if(idstring($_GET['id']) != $allyrow['ally_owner']){	//Admin can't leave
			doquery("UPDATE {{table}} SET `ally_id` = '0' , `ally_name` = '' , `ally_register_time` = '0' , `ally_rank` = '0' , `ally_rank_name` = 'Newbie' WHERE `id` = '".idstring($_GET['id'])."' AND `ally_id` = '".$user['ally_id']."' LIMIT 1 ;",'users');
			doquery("UPDATE {{table}} SET `ally_members` = `ally_members` - ".mysql_affected_rows()." WHERE `id` = '".$user['ally_id']."' LIMIT 1 ;",'alliance');
		}
		
		//Back to alliance page
		header("Location: ".AddUniToString('./?page=network&axah='.$_GET['axah']));
		die();
		
		break;
		
	default:
		
		$parse['name'] = $allyrow['ally_name'];
		$parse['tag'] = $allyrow['ally_tag'];
		$parse['www'] = addslashes($allyrow['ally_web']);
		$parse['members'] = idstring($allyrow['ally_members']);
		$parse['yourrank'] = addslashes($user['ally_rank_name']);
		$parse['internal'] = $bb->parse(addslashes($allyrow['ally_text']));
		$parse['external'] = $bb->parse(addslashes($allyrow['ally_description']));
		$parse['image'] = addslashes($allyrow['ally_image']);
		
		$members = $lang;
		$membersort = 'ally_register_time';
		$memberquery = doquery("SELECT 
			`id`,`username`,`galaxy`,`system`,`planet`,
			`ally_register_time`,`ally_rank_name`,`total_points`,`onlinetime` 
			FROM {{table}} WHERE `ally_id` = '".$allyrow['id']."' ORDER BY `".$membersort."` ASC ;",'users');
		$n = 0;
		while ($row = FetchArray($memberquery)){
			$n++;
			
			$lastclick = time() - $row['onlinetime'];
			if(!$user['permisions'][2]){
				$activeon = ' - ';
				$activeover = '';			
			}elseif($lastclick > 20){
				$activeon = 'Off';
				$activeover = 'overmark';
			}else{
				$activeon = 'On';
				$activeover = 'undermark';	
			}
			
			if($user['permisions'][32] && $row['id'] != $user['id']){
				$kick = "<a title=\"Kick user\" class=\"tips thickbox\" onclick=\"loadpage('./?page=network&mode=kick&id=".$row['id']."','{Alliance}','network'); document.getElementById('memberlist_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;\" href=\"#\">
							<img alt=\"Kick user\" src=\"".GAME_SKIN."/img/icons/against.gif\" />
						</a>";
			}
			
			if($row['id'] == $user['id']){
				$hideselfactions = "display:none;";
			}else{
				$hideselfactions = "";
			}
			
			$members['rows'] .= "
			<tr class=\"\">
				<td>".$n."</td>
				<td>".$row['username']."</td>
				<td></td>
				<td>".$row['ally_rank_name']."</td>
				<td>".pretty_number($row["total_points"] / $game_config['stat_settings'])."</td>
				<td>
					<a href=\"./?page=galaxy&galaxy=".$row['galaxy']."&system=".$row['system']."\" >
						[".$row['galaxy'].":".$row['system'].":".$row['planet']."]
					</a>
				</td>
				<td>".date("j<\s\up>S</\s\up> F Y",$row['ally_register_time'])."</td>
				<td><span class=\"".$activeover."\">".$activeon."</span></td>
				<td>
					<span style=\"".$hideselfactions."\">
						<a title=\"Write Message\" class=\"tips thickbox\" onclick=\"mrbox(\'./?page=write&to=".$row['id']."&iframe=1&iheight=800\',800); return false;\" href=\"#\">
							<img alt=\"Write Message\" src=\"".GAME_SKIN."/img/icons/mail.gif\" />
						</a>
						".$kick."
					</span>
				</td>
			</tr>
			";
		}
		
		if($user['permisions'][1]){
			$parse['memberlist'] = parsetemplate(gettemplate('alliance/memberlist'),$members);
		}
		
		if($user['id'] == $allyrow['ally_owner']){
			$parse['leave_style'] = 'display:none;';
		}
		
		if($_GET['axah']){
			makeAXAH(parsetemplate(gettemplate('alliance/main'),$parse));
		}else{
			displaypage(parsetemplate(gettemplate('alliance/main'),$parse),$lang['title']);
		}
		
		break;
	}
}


?>
