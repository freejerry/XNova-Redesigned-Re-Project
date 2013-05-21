<?php

/**
 * fleetajax.php
 *
 * @version 2
 * @copyright 2009 By MadnessRed for XNova_Redisigned
 */

getLang("messages");

$Template = '
		<div id="message_alert_box">
			<a href="./?page=messages" onclick="loadpage(this.href,\'{messagestitle}\',\'messages\'); return false;" class="tips" onmouseover="mrtooltip(\'{messages_count} new message(s)\');" onmouseout="UnTip();" style="text-decoration: none;">
				<img src="{{skin}}/img/layout/pixel.gif" height="13" width="25"><center>{messages_count}</center>
			</a>
		</div>
		<div id="fleetajax"> 
			<div id="messages_collapsed" style="position: relative;">
				<div id="eventboxFilled" style="display: {eventboxdisplay};" onclick="">
					{fleet_table}
				</div>

				<div id="eventboxLoading" class="textCenter textBeefy" style="display: none;">
					<img height="16" width="16" src="{{skin}}/img/ajax-loader.gif" /> Loading...
				</div>

				<div id="eventboxBlank" class="textCenter" style="display: {eventboxblank};">No fleet movement</div>
			</div>
			<div id="attack_alert" style="visibility:{attack_alert};">
				<a href="./?page=movement" lass="tips thickbox" title="Attack!">
					<img src="{{skin}}img/layout/pixel.gif" height="13" width="25"/>
				</a>
			</div>
		</div>
		<br class="clearfloat" />';

$fl_tbl = GetFleetInfo($user,$planet);
if($fl_tbl){
	$parse['fleet_table'] = $fl_tbl[0];
	$parse['eventboxdisplay'] = 'block';
  $parse['eventboxblank']   = 'none';
}else{
	$parse['eventboxdisplay'] = 'none';
  $parse['eventboxblank']   = 'block';
}
if($fl_tbl[1] > 0){
	$parse['attack_alert'] = 'visible';
}else{
	$parse['attack_alert'] = 'hidden';
}


//Messages
$parse['messagestitle']=$lang['Title'];
$messages = explode(",",$user['messages']);
$mess = 0; foreach ($messages as $c){ $mess += $c; }
if($mess > 0)
	$parse['messages_count'] = pretty_number($mess);
else
  $parse['messages_count'] = 0;

die(AddUniToLinks(parsetemplate($Template,$parse)));

?>
