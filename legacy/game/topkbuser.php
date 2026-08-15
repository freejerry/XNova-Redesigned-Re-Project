<?php

/**
 * topkbuser.php
 *
 * @version 1.0
 * @copyright 2008 by Eumele www.x-nova.org
 * Der Mod darf nur als download bei http://xnova-germany.de/ oder www.x-nova.org angeboten werden, oder von den Teammitgliedern persönlich auf anderen Seiten.
 *
 */


define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);
 if (!isset($mode)) {
		if (isset($_GET['mode'])) {
			$mode          = $_GET['mode'];
		} else {
                       $mode = 0;
		}
	}





//start der einzel anzeige
$anzeige       = doquery("SELECT * FROM {{table}} WHERE `rid` = '". $mode ."';", 'topkb');

	includeLang('topkb');
        $BodyTPL = gettemplate('topkbanzeige');
        $RowsTPL = gettemplate('topkbanzeige_rows');
 	$parse   = $lang;



while($tabelle = mysql_fetch_assoc($anzeige))
{

$user1       = doquery("SELECT * FROM {{table}} WHERE `id` = '". $tabelle['id_owner1'] ."';", 'users');
while($user1data = mysql_fetch_assoc($user1))
{
   $bloc['useratter']               = "<th><img src=\"". $user1data['avatar'] ."\" height=100 width=100></th>";
}
$user2       = doquery("SELECT * FROM {{table}} WHERE `id` = '". $tabelle['id_owner2'] ."';", 'users');
while($user2data = mysql_fetch_assoc($user2))
{
   $bloc['userdeffer']               = "<th><img src=\"". $user2data['avatar'] ."\" height=100 width=100></th>";;
}
     $bloc['top_vs']             = "<th><b>  VS  </b></th>";
     $bloc['top_titel']          = "<td><h2>". $tabelle['angreifer'] ."<b> VS </b>". $tabelle['defender'] ."</h2></td>";
     $bloc['top_fighters']       = $tabelle['angreifer'] ."<b> VS </b>". $tabelle['defender'];
     $bloc['top_id_owner1']      = "<b>". $tabelle['id_owner1'] ."</b>";
     $bloc['top_angreifer']      = "<th>". $tabelle['angreifer'] ."</th>";
     $bloc['top_id_owner2']      = $tabelle['id_owner2'];
     $bloc['top_defender']       = "<th>". $tabelle['defender'] ."</th>";
     $bloc['top_gesamtunits']    = pretty_number( $tabelle['gesamtunits'] );
     $bloc['top_gesamttruemmer'] = $tabelle['gesamttruemmer'];
     $bloc['top_rid']            = $tabelle['rid'];
     $bloc['top_raport']         = $tabelle['raport'];
     $bloc['top_time']           = date("r", $tabelle['time']);

     $parse['top_list'] .= parsetemplate($RowsTPL, $bloc);

            }
 display(parsetemplate(gettemplate('topkbanzeige'), $parse), $lang['topkb'], false);
 
 ?>
