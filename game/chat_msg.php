<?php

/**
 * chat_msg.php
 *
 * @version 1.0
 * @version 1.2 by Ihor
 * @copyright 2008 by e-Zobar for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

includeLang('chat');

$page_limit = 30; // Chat rows Limit
if($_GET['page']>''){
	$page = $_GET['page'];
}else{
	$page = 0;
}
$start_row = $page * $page_limit;

if ($_GET) {
	if($_GET['chat_type']=='ally' && $_GET['ally_id']>''){
		if ($_GET['show']=='history') {
			showPageButtons($page,'ally');
			$query = doquery("SELECT * FROM {{table}} WHERE ally_id = '".$_GET['ally_id']."' ORDER BY messageid DESC LIMIT ".$start_row.",".$page_limit." ", "chat");
		}else{
			$query = doquery("SELECT * FROM {{table}} WHERE ally_id = '".$_GET['ally_id']."' ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
		}
	}else{
		if ($_GET['show']=='history') {
			showPageButtons($page,'all');
			$query = doquery("SELECT * FROM {{table}} WHERE ally_id < 0 ORDER BY messageid DESC LIMIT ".$start_row.",".$page_limit." ", "chat");
		}else{
			$query = doquery("SELECT * FROM {{table}} WHERE ally_id < 0 ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
		}
	}
}else{
	if($_POST['chat_type']=='ally' && $_POST['ally_id']>''){
		$query = doquery("SELECT * FROM {{table}} WHERE ally_id = '".$_POST['ally_id']."' ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
	}else{
		$query = doquery("SELECT * FROM {{table}} WHERE ally_id < 1 ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
	}
}

$buff = "";
while($v=mysql_fetch_object($query)){
	$msg = "";
    $nick=htmlentities($v->user, ENT_QUOTES, cp1251);
	$msg=htmlentities($v->message, ENT_QUOTES, cp1251);
	$msgtimestamp=htmlentities($v->timestamp, ENT_QUOTES, cp1251);
	$msgtimestamp=date("m/d H:i:s", $msgtimestamp);
	// Les différentes polices (gras, italique, couleurs, etc...)
	$msg=preg_replace("#\[url=(ft|https?://)(.+)\](.+)\[/url\]#isU", "<a href=\"$1$2\" target=\"_blank\">$3</a>", $msg);
	$msg=preg_replace("#\[b\](.+)\[/b\]#isU","<b>$1</b>",$msg);
	$msg=preg_replace("#\[i\](.+)\[/i\]#isU","<i>$1</i>",$msg);
	$msg=preg_replace("#\[u\](.+)\[/u\]#isU","<u>$1</u>",$msg);
	$msg=preg_replace("#\[img\](.+)\[/img\]#isU","<img src=$1 />",$msg);
	$msg=preg_replace("#\[c=(blue|green|yellow|red|pink|orange|white)\](.+)\[/c\]#isU","<font color=\"$1\">$2</font>",$msg);

	// Les smileys avec leurs raccourcis
	$msg=preg_replace("#:c#isU","<img src=\"../images/smileys/cry.png\" align=\"absmiddle\" title=\":c\" alt=\":c\">",$msg);
	$msg=preg_replace("#:~#isU","<img src=\"../images/smileys/confused.png\" align=\"absmiddle\" title=\":/\" alt=\":/\">",$msg);
	$msg=preg_replace("#o0#isU","<img src=\"../images/smileys/dizzy.png\" align=\"absmiddle\" title=\"o0\" alt=\"o0\">",$msg);
	$msg=preg_replace("#\^\^#isU","<img src=\"../images/smileys/happy.png\" align=\"absmiddle\" title=\"^^\" alt=\"^^\">",$msg);
	$msg=preg_replace("#:D#isU","<img src=\"../images/smileys/lol.png\" align=\"absmiddle\" title=\":D\" alt=\":D\">",$msg);
	$msg=preg_replace("#:\|#isU","<img src=\"../images/smileys/neutral.png\" align=\"absmiddle\" title=\":|\" alt=\":|\">",$msg);
	$msg=preg_replace("#:\)#isU","<img src=\"../images/smileys/smile.png\" align=\"absmiddle\" title=\":)\" alt=\":)\">",$msg);
	$msg=preg_replace("#:o#isU","<img src=\"../images/smileys/omg.png\" align=\"absmiddle\" title=\":o\" alt=\":o\">",$msg);
	$msg=preg_replace("#:p#isU","<img src=\"../images/smileys/tongue.png\" align=\"absmiddle\" title=\":p\" alt=\":p\">",$msg);
	$msg=preg_replace("#:\(#isU","<img src=\"../images/smileys/sad.png\" align=\"absmiddle\" title=\":(\" alt=\":(\">",$msg);
	$msg=preg_replace("#;\)#isU","<img src=\"../images/smileys/wink.png\" align=\"absmiddle\" title=\";)\" alt=\";)\">",$msg);
	$msg=preg_replace("#:s#isU","<img src=\"../images/smileys/shit.png\" align=\"absmiddle\" title=\":s\" alt=\":s\">",$msg);
	$msg=preg_replace("#uni1#","<a href=\"http://evo.censtudios.org/uni1\">uni1</a>",$msg);
	$msg=preg_replace("#uni2#","<a href=\"http://evo.censtudios.org/uni2\">uni2</a>",$msg);
	$msg=preg_replace("#uni3#","<a href=\"http://evo.censtudios.org/uni3\">uni3</a>",$msg);


	// Affichage du message
	$msg="<div align=\"left\" style='background-color:black;color:white;'><span style='font:menu;'>[".$msgtimestamp."]</span> <span style='width:50px;font:menu;'><b>".$nick."</b></span> : ".$msg."<br></div>";
	$buff = $msg . $buff;
}
print $buff;

function showPageButtons($curPage,$type){
	global $page_limit,$lang;
	echo "<div style='width:100%;border:1px solid red;padding:4px;' align=center>";
	echo "<b><font size=3>".$lang['AllyChat']." / ".$lang['chat_history']."</font></b> ";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<b><font size=2>".$lang['chat_page'].":</font></b> ";
	echo "<select name='page' onchange='document.location.assign(\"chat_msg.php?chat_type=".$_GET['chat_type']."&ally_id=".$_GET['ally_id']."&show=".$_GET['show']."&page=\"+this.value)'>";
	if($type=='ally'){
		$rows = doquery("SELECT count(1) AS CNT FROM {{table}} WHERE ally_id = '".$_GET['ally_id']."'", "chat",true);
		$cnt = $rows['CNT'] / $page_limit;
	    for($i = 0; $i < $cnt; $i++) {
			if($curPage==$i){
				echo "<option value=".$i." selected>".$i."</option> ";
			}else{
				echo "<option value=".$i.">".$i."</option> ";
			}
	    }
	}else{
		$rows = doquery("SELECT count(1) AS CNT FROM {{table}} WHERE ally_id < 1", "chat",true);
		$cnt = $rows['CNT'] / $page_limit;
	    for($i = 0; $i < $cnt; $i++) {
			if($curPage==$i){
				echo "<option value=".$i." selected>".$i."</option> ";
			}else{
				echo "<option value=".$i.">".$i."</option> ";
			}
	    }
	}
	echo "</select> ";
	echo "</div>";
}

// Shoutbox by e-Zobar - Copyright XNova Team 2008
?>
