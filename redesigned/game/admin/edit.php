<?php

/**
 * edit.php
 *
 * @version 1.0
 * @copyright 2008 by MadnessRed for XNova
 */



switch ($_GET['section']){
	case "user":
		if($_GET['val']){
			$data  = doquery("SELECT * FROM {{table}} WHERE `username` = '".mysql_real_escape_string($_GET['val'])."' LIMIT 1 ;",'users',true);
			$page  = "Editing user ".$data['username'].".<br /><br />\n\n";

			$page .= "<form action=\"./?page=admin&link=edit&section=submit&id=".$data['id']."\" method=\"POST\">\n";
			$page .= "<input type=\"hidden\" name=\"table\" value=\"users\" />\n";

			$page .= "<table width=\"90%\">\n";
			foreach($reslist['tech'] as $id){
				$page .= "\t<tr><td width=\"75%\">".$lang['names'][$id]."</td><td width=\"10%\">".$data[$resource[$id]]."</td><td width=\"15%\"><input type=\"text\" name=\"".$id."\" value=\"".$data[$resource[$id]]."\" size=\"4\" class=\"textInput\"  onfocus=\"javascript:if(this.value == '0') this.value='';\" onblur=\"javascript:if(this.value == '') this.value='0';\" /></td></tr>\n";
			}
			$page .= "</table>\n<br />\n";

			$page .= "<input type=\"submit\" class=\"button188\" value=\"Edit\" />";
			$page .= "</form>\n";

			die(AddUniToLinks($page));
		}else{
			$parse['up'] = 'refer';
			$parse['identifier'] = 'username';
			$parse['section'] = 'user';
			
			$template = '
Enter {identifier}:
<input name="val" type="text" id="val" style="width:150px;" onkeyup="getAXAH(\'./check.php?check={up}&{up}=\'+this.value,\'usercheck\');" value="" />
<span id="usercheck"><image src="./check/err.gif" width="16" height="14" /></span><br />

<input type="button" class="button188" value="Go" onclick="getAXAH(\'./?page=admin&link=edit&section={section}&val=\'+document.getElementById(\'val\').value,\'section\');" />';

			die(parsetemplate($template, $parse));
		}

		break;
	case "planet":
		if($_GET['g']+$_GET['s']+$_GET['p']+$_GET['t'] > 0){
		
			$g = idstring($_GET['g']);
			$s = idstring($_GET['s']);
			$p = idstring($_GET['p']);
			$t = idstring($_GET['t']);
			$data  = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$g."' AND `system` = '".$s."' AND `planet` = '".$p."' AND `planet_type` = '".$t."' LIMIT 1;", 'planets', true);
	
			$page  = "Editing planet ".$data['name'].", (".$data['galaxy'].":".$data['system'].":".$data['planet'].")<br /><br />\n\n";

			$page .= "<a href=\"./?page=admin&link=addmoon&galaxy=".$data['galaxy']."&system=".$data['system']."&planet=".$data['planet']."\">Add moon</a><br />\n";
			$page .= "<form action=\"./?page=admin&link=edit&section=submit&id=".$data['id']."\" method=\"POST\">\n";
			$page .= "<input type=\"hidden\" name=\"table\" value=\"planets\" />\n";

			$page .= "<table width=\"90%\">\n";
			foreach($reslist['build'] as $id){
				$page .= "\t<tr><td width=\"75%\">".$lang['names'][$id]."</td><td width=\"10%\">".$data[$resource[$id]]."</td><td width=\"15%\"><input type=\"text\" name=\"".$id."\" value=\"".$data[$resource[$id]]."\" size=\"4\" class=\"textInput\"  onfocus=\"javascript:if(this.value == '0') this.value='';\" onblur=\"javascript:if(this.value == '') this.value='0';\" /></td></tr>\n";
			}
			$page .= "</table>\n<br />\n";

			$page .= "<table width=\"90%\">\n";
			foreach($reslist['fleet'] as $id){
				$page .= "\t<tr><td width=\"75%\">".$lang['names'][$id]."</td><td width=\"10%\">".$data[$resource[$id]]."</td><td width=\"15%\"><input type=\"text\" name=\"".$id."\" value=\"".$data[$resource[$id]]."\" size=\"4\" class=\"textInput\"  onfocus=\"javascript:if(this.value == '0') this.value='';\" onblur=\"javascript:if(this.value == '') this.value='0';\" /></td></tr>\n";
			}
			$page .= "</table>\n<br />\n";

			$page .= "<table width=\"90%\">\n";
			foreach($reslist['defense'] as $id){
				$page .= "\t<tr><td width=\"75%\">".$lang['names'][$id]."</td><td width=\"10%\">".$data[$resource[$id]]."</td><td width=\"15%\"><input type=\"text\" name=\"".$id."\" value=\"".$data[$resource[$id]]."\" size=\"4\" class=\"textInput\"  onfocus=\"javascript:if(this.value == '0') this.value='';\" onblur=\"javascript:if(this.value == '') this.value='0';\" /></td></tr>\n";
			}
			$page .= "</table>\n<br />\n";

			$page .= "<input type=\"submit\" class=\"button188\" value=\"Edit\" />";
			$page .= "</form>\n";

			die(AddUniToLinks($page));
		}else{
			$parse['up'] = 'planetopp';
			$parse['identifier'] = 'planet co-ordinates';
			$parse['section'] = 'planet';
			
			$template = '
Enter {identifier}:

<input name="g" type="text" id="g" size="2" value="1" onkeyup="
	getAXAH(\'./check.php?check={up}&g=\'+document.getElementById(\'g\').value+\'&s=\'+document.getElementById(\'s\').value+\'&p=\'+document.getElementById(\'p\').value+\'&t=\'+document.getElementById(\'t\').options[document.getElementById(\'t\').options.selectedIndex].value,\'usercheck\');
	" />
	
<input name="s" type="text" id="s" size="3" value="1" onkeyup="
	getAXAH(\'./check.php?check={up}&g=\'+document.getElementById(\'g\').value+\'&s=\'+document.getElementById(\'s\').value+\'&p=\'+document.getElementById(\'p\').value+\'&t=\'+document.getElementById(\'t\').options[document.getElementById(\'t\').options.selectedIndex].value,\'usercheck\');
	" />
	
<input name="p" type="text" id="p" size="2" value="1" onkeyup="
	getAXAH(\'./check.php?check={up}&g=\'+document.getElementById(\'g\').value+\'&s=\'+document.getElementById(\'s\').value+\'&p=\'+document.getElementById(\'p\').value+\'&t=\'+document.getElementById(\'t\').options[document.getElementById(\'t\').options.selectedIndex].value,\'usercheck\');
	" />
	
<select name="t" id="t" onchange="
	getAXAH(\'./check.php?check={up}&g=\'+document.getElementById(\'g\').value+\'&s=\'+document.getElementById(\'s\').value+\'&p=\'+document.getElementById(\'p\').value+\'&t=\'+document.getElementById(\'t\').options[document.getElementById(\'t\').options.selectedIndex].value,\'usercheck\');
	">
	<option value="1" selected>Planet</option>
	<option value="3">Moon</option>
</select>
<span id="usercheck"><image src="./check/ok.gif" width="16" height="14" /></span><br />

<input type="button" class="button188" value="Go" onclick="getAXAH(\'./?page=admin&link=edit&section={section}&g=\'+document.getElementById(\'g\').value+\'&s=\'+document.getElementById(\'s\').value+\'&p=\'+document.getElementById(\'p\').value+\'&t=\'+document.getElementById(\'t\').options[document.getElementById(\'t\').options.selectedIndex].value,\'section\');" />';

			makeAXAH(parsetemplate($template, $parse));
		}

		break;
	case "submit":
		$count = 0;
		$query = "UPDATE {{table}} SET ";
		foreach($_POST as $key => $val){
			if(is_numeric($key)){
				if(is_numeric($val)){
					if(strlen($resource[$key]) > 0){
						$count++;
						$query .= "`".$resource[$key]."` = '".idstring($val)."' , ";
					}
				}
			}
		}
		if($count > 0){
			$query = substr_replace($query,'',-2)." WHERE `id` = '".idstring($_GET['id'])."' LIMIT 1 ;";
			doquery($query,mysql_real_escape_string($_POST['table']));
		}
		info("User Edited","Success",'./?page=admin&link=edit','<<');

		break;
	default:
		$bloc['content'] = parsetemplate(gettemplate('admin/edit_ovr'), $parse);
		$bloc['title'] = $lang['sys_overview'];

		break;
}


?>
