<?php

/**
 * PlanetList.php
 *
 * @version 1
 * @copyright 2008 By MadnessRed for XNova_Redisigned
 */

function ShowPlanetList($axah = false,$debug = false) {
	global $lang, $_GET, $user, $formulas, $resource;
	if($debug){
		echo "Started function<br /><br />";
	}
	if ($user) {

		//Make a lsit of player planets.
		$planetlist = '<br />';
		$ThisUsersPlanets    = SortUserPlanets($user);
		if($debug){
			print_r(mysql_fetch_array($ThisUsersPlanets));
		}
		$c = 0;
		while ($CurPlanet = mysql_fetch_array($ThisUsersPlanets)) {
			if ($CurPlanet["destruyed"] == 0) {
				if($CurPlanet['planet_type'] == 1){
					$CurMoon = doquery("SELECT `id`,`name`,`galaxy`,`system`,`planet`,`image` FROM {{table}} WHERE `galaxy` = '".$CurPlanet['galaxy']."' AND `system` = '".$CurPlanet['system']."' AND `planet` = '".$CurPlanet['planet']."' AND `planet_type` = '3' LIMIT 1 ;",'planets',true);
					if($CurPlanet['id'] == $user['current_planet'] || $CurMoon['id'] == $user['current_planet']){ $active = ' active'; }else{ $active = ''; }
					
					$c++;
					$img = PlanetType($CurPlanet['image']);
					$pl_img = "/img/planets/".$img['type']."_".$img['subtype']."_{size}.gif";
					
					//is there a moon
					if($CurMoon['id'] > 0){
						$moon_type_array = PlanetType($CurMoon['image']);
						$moonlink  = "\t\t\t\t<a class=\"moonlink\" onclick=\"loadpage(this.href,'".$lang['Overview']." - ".$CurMoon['name']."','overview'); document.getElementById('planet_ext').value = '-moon'; document.getElementById('resources_menu_link').style.display = 'none'; return false;\" href=\"./?cp=".$CurMoon['id']."&re=0\" onmouseover=\"mrtooltip_large('".$CurMoon['name']." [".$CurMoon['galaxy'].":".$CurMoon['system'].":".$CurMoon['planet']."]')\" onmouseout=\"UnTip()\">\n";
						$moonlink .= "\t\t\t\t\t<img class=\"icon-moon\" src=\"".GAME_SKIN."/img/planets/moon/".$moon_type_array['type']."_".$moon_type_array['subtype']."_small.gif\" />\n";
						$moonlink .= "\t\t\t\t</a>\n";
					}else{
						$moonlink  = "";
					}
					
					$planetlist .= "\n";
					$planetlist .= "\t\t\t<div class=\"smallplanet\">\n";
					$planetlist .= "\t\t\t\t<a onclick=\"loadpage(this.href,'".$lang['Overview']." - ".$CurPlanet['name']."','overview'); document.getElementById('planet_ext').value = ''; document.getElementById('resources_menu_link').style.display = 'block'; return false;\" href=\"./?cp=".$CurPlanet['id']."&re=0\" onmouseover=\"mrtooltip_large('".$CurPlanet['name']." [".$CurPlanet['galaxy'].":".$CurPlanet['system'].":".$CurPlanet['planet']."]')\" onmouseout=\"UnTip()\" class=\"planetlink".$active." tips reloadTips\">\n";
					$planetlist .= "\t\t\t\t\t<img class=\"planetPic\" src=\"".GAME_SKIN.$pl_img."\" />\n";
					$planetlist .= "\t\t\t\t\t<span class=\"planet-name\">".$CurPlanet['name']."</span>\n";
					$planetlist .= "\t\t\t\t\t<span class=\"planet-koords\">[".$CurPlanet['galaxy'].":".$CurPlanet['system'].":".$CurPlanet['planet']."]</span>\n";
					$planetlist .= "\t\t\t\t</a>\n";
					$planetlist .= $moonlink;
					$planetlist .= "\t\t\t</div>\n";
				}
			}
		}
		
		if($c > 5){
			$mode = 'cutty';
			$name = 'myPlanets';
			$size = '1';
		}else{
			$mode = 'norm';
			$name = 'myWorlds';
			$size = '3';
		}
		
		$planetlist = str_replace('{size}',$size,$planetlist);
				
		if($axah){			
			$return = "\t<div id=\"".$mode."\">\n\t\t<div id=\"".$name."\">\n\n\t\t\t<div id=\"countColonies\">\n\t\t\t\t<p class=\"textCenter tips\" title=\"|\">\n\t\t\t\t\t<span>".$c."/".eval($formulas['max_planets'])."</span> Planets\n\t\t\t\t</p>\n\t\t\t</div>".$planetlist."\n\n\t\t</div>\n\t</div>\n";
		}else{
			$return = "<!-- RIGHTMENU -->\n<div id=\"rechts\">\n\n\t<div id=\"".$mode."\">\n\t\t<div id=\"".$name."\">\n\n\t\t\t<div id=\"countColonies\">\n\t\t\t\t<p class=\"textCenter tips\" title=\"|\">\n\t\t\t\t\t<span>".$c."/".eval($formulas['max_planets'])."</span> Planets\n\t\t\t\t</p>\n\t\t\t</div>".$planetlist."\n\n\t\t</div>\n\t</div>\n</div>\n<!-- END RIGHTMENU -->\n";
		}

	} else {
		$return = "";
		if($debug){
			echo "\$user returned <font color=blue><b>false</b></font><br /><br />";
			print_r($user);
		}
	}

	return $return;
}
if($_GET['debug'] || $_GET['show'] || $_GET['axah']){
	echo ShowPlanetList($_GET['axah'],$_GET['debug']);
}

?>

