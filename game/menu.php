<?php

/**
 * menu.php
 *
 * @version 1.2
 * @copyright 2008 By Chlorel for XNova
 * @copyright 2009 By MadnessRed for XNova Redesigned
 */

function ShowLeftMenu($cpage = 'x') {
	global $lang, $game_config, $userclass, $currentplanet, $resource;

	getLang('menu');
	//getLang('changelog');

	//Basic stuff
	$cpage						= "let_".$cpage;
	$parse						= $lang;
	$parse['forum_url']			= $game_config['forum_url'];

	//Which page is selected?
	$parse['let_overview']		= 'b';
	$parse['let_empire']		= 'b';
	$parse['let_resources']		= 'b';
	$parse['let_resources_c']	= 'c';
	$parse['let_station']		= 'b';
	$parse['let_trader']		= 'b';
	$parse['let_research']		= 'b';
	$parse['let_shipyard']		= 'b';
	$parse['let_defense']		= 'b';
	$parse['let_fleet']			= 'b';
	$parse['let_galaxy']		= 'b';
	$parse['let_network']		= 'b';
	$parse['let_premium']		= 'b';
	$parse[$cpage]				= 'b';

	//Empire row
	$EmpireTPL = '
		<li class="menubutton_table">
			<span class="menu_icon">
		  		<img src="{{skin}}/img/navigation/navi_ikon_empire_{let_empire}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" onclick="loadpage(\'./?page=empire\',\'{Empire}\',\'empire\');" href="#" title="{Empire}">
				<span class="textlabel">{Empire}</span>
			</a>
		</li>';

	if($userclass->{$resource[601]."_exp"} > time()){
		$parse['empire'] = parsetemplate($EmpireTPL,$parse);
	}else{
		$parse['empire'] = '';
	}
	
	//Don't show resources if is is a moon
	if($currentplanet->planet_type == 3){
		$parse['show_resources'] = 'none';
	}else{
		$parse['show_resources'] = 'block';
	}
	
	//Alert
	$parse['alert'] = '';
	$AlertTPL = '
	<div id="alertbox" style="float: left; position: relative; height: 20px; width: 100%; margin-top: 10px;">
		<div id="advice-bar">
			<a onclick="mrbox(\'./?page=validate&axah=1\'); return false;" href="#" class="thickbox tips3" onmouseover="mrtooltip_large(\'Your account has not been validated yet. Please go to the Settings, enter your E-Mail Address and receive a new validation link.\',\'Not validated\',250);" onmouseout="UnTip();">
				<img src="{{skin}}/img/icons/caution.gif" height="16" width="16" />
			</a>
		</div>
	</div>';
	if($userclass->validate > 0){ $parse['alert'] .= parsetemplate($AlertTPL,$parse); }
	
	if(date('nj') == '41' || $_GET['april']){
		$parse['af'] = '<a class="menubutton" style="display:block;left:10.5%;top:489px;z-index:99;background-image:url('.GAME_SKIN.'/img/navigation/link_a.png);width:135px;height:29px;text-align:center;text-docoration:none;padding-top:3px;background-repeat: no-repeat;" onmouseover="this.style.top = Math.floor(Math.random() * (window.innerHeight - 20) + 10)+\'px\';this.style.left = Math.floor(Math.random()*201 + 5)+\'px\'; this.style.position = \'fixed\';" href="./?page=freeres" title="Free Resources"><font color="Red"><strong>Free Resources</strong></font></span></a>';
	}
		

	$Menu                  = parsetemplate(gettemplate('redesigned/menu'),$parse);

	return $Menu;
}
	//$Menu = ShowLeftMenu ( $user['authlevel'] );
	//display ( $Menu, "Menu", '', false );

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Passage en fonction pour XNova version future
// 1.1 - Modification pour gestion Admin / Game OP / Modo
// 1.2 - Modified to support the new redesign. Now longer a standalone page.
// 1.3 - Uses OO user and planets
?>
