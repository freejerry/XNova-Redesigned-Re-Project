<?php

/**
 * errors.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 */

includeLang('admin');
$parse = $lang;


//Server root?
$server_root = "/home/evo/public_html/new/";

// Supprimer les erreurs
extract($_GET);

if($group == 1){
	$query = doquery("SELECT error_page, error_text, MAX(error_time), COUNT(error_id) FROM {{table}} GROUP BY error_page ;", 'errors');

	$parse['errors_list'] = "<tr>
	<th colspan=\"1\" style=\"border-width:1px;border-color:#888888;border-style:solid;width:25px;\">
		Count
	</th>
	<th colspan=\"4\" style=\"border-width:1px;border-color:#888888;border-style:solid;width:527px;\">
		Error
	</th>
</tr>";

	$parse['group_errors'] = '<a href="./?page=admin&link=errors&group=0">Ungroup Errors</a>';

	while ($u = mysql_fetch_array($query)) {
		$parse['errors_list'] .= "
		<tr>
			<td width=\"25\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">". $u['COUNT(error_id)'] ."</td>
			<td colspan=\"4\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">". str_replace($server_root,"./",$u['error_page']) ."</td>
		</tr>
		<tr><td colspan=\"5\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">". nl2br($u['error_text']) ."</td></tr>";
	}

}else{
	if (isset($delete)) {
		doquery("DELETE FROM {{table}} WHERE `error_id`=$delete", 'errors');
	} elseif ($deleteall == 'yes') {
		doquery("TRUNCATE TABLE {{table}}", 'errors');
	}

	// Afficher les erreurs
	$sort = $_GET['sort'];
	if(strlen($sort) == 0){ $sort = "error_id"; }
	if($_GET['ord'] == 2){
		$ord = "DESC";
		$parse['oth_ord'] = 1;
	}else{
		$ord = "ASC";
		$parse['oth_ord'] = 2;
	}

	$query = doquery("SELECT * FROM {{table}} ORDER BY `".mysql_escape_string($sort)."` ".mysql_escape_string($ord)." ;", 'errors');

	$parse['group_errors'] = '<a href="./?page=admin&link=errors&group=1">Group Errors</a>';

	$parse['errors_list'] = "
<tr>
	<th width=\"60\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">
		<a href=\"./?page=admin&link=errors&ord={oth_ord}&sort=error_id\">".$lang['adm_er_idmsg']."</a>
	</th>
	<th width=\"60\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">
		<a href=\"./?page=admin&link=errors&ord={oth_ord}&sort=error_sender\">".$lang['adm_er_user']."</a>
	</th>
	<th width=\"190\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">
		<a href=\"./?page=admin&link=errors&ord={oth_ord}&sort=error_type\">".$lang['adm_er_type']."</a>
	</th>
	<th width=\"250\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">
		<a href=\"./?page=admin&link=errors&ord={oth_ord}&sort=error_time\">".$lang['adm_er_time']."</a>
	</th>
	<th width=\"20\" style=\"border-width:1px;border-color:#888888;border-style:solid;width:20px;\">
		".$lang['adm_er_delete']."
	</th>
</tr>";

	$i = 0;
	while ($u = mysql_fetch_array($query)) {
		$i++;
		$parse['errors_list'] .= "
		<tr><td width=\"25\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">". $u['error_id'] ."</td>
		<td width=\"25\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">". $u['error_sender'] ."</td>
		<td width=\"170\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">". $u['error_type'] ."</td>
		<td width=\"230\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">". date('d/m/Y h:i:s', $u['error_time']) ."</td>
		<td width=\"70\" style=\"border-width:1px;border-color:#888888;border-style:solid;\"><a href=\"./?page=admin&link=errors&delete=". $u['error_id'] ."\"><img src=\"../images/r1.png\"></a></td></tr>
		<tr><td colspan=\"5\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">". str_replace($server_root,"./",$u['error_page']) ."</td></tr>
		<tr><td colspan=\"5\" style=\"border-width:1px;border-color:#888888;border-style:solid;\">". nl2br($u['error_text']) ."</td></tr>";
	}
	$parse['errors_list'] .= "<tr>
		<th colspan=5 style=\"border-width:1px;border-color:#888888;border-style:solid;\">". $i ." ". $lang['adm_er_nbs'] ."</th>
		</tr>";
}

$bloc['content'] = parsetemplate(gettemplate('admin/errors_body'), $parse);

?>