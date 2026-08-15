<?php

/**
 * ShowTopNavigationBar.php
 *
 * @version 1
 * @copyright 2008 By MadnessRed for XNova_Redisigned
 */

function ShowPlanetList() {
	global $lang, $_GET, $user;

	if ($user) {
		$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $users['current_planet'] ."';", 'planets', true);
		// Actualisation des ressources de la planete
		$NavigationTPL       = gettemplate('topnav');

		$dpath               = (!$users["dpath"]) ? DEFAULT_SKINPATH : $users["dpath"];
		$parse               = $lang;
		$parse['dpath']      = $dpath;
		$parse['image']      = $CurrentPlanet['image'];

		//Make a lsit of player planets.
		$planetlist = '';
		$currentplanet = '';
		$ThisUsersPlanets    = SortUserPlanets ( $users );
		while ($CurPlanet = mysql_fetch_array($ThisUsersPlanets)) {
			echo $CurPlanet['name'];
			if ($CurPlanet["destruyed"] == 0) {
				$planetlist .= "\n";
				if ($CurPlanet['id'] == $users['current_planet']) {
					$currentplanet  = "<img src=\"".$dpath."planeten/small/s_".$CurPlanet['image'].".jpg\" height=\"88\" width=\"88\"><br />";
					$currentplanet .= $CurPlanet['name']."<br /><br />";
				}else{
					$planetlist .= "<a href=\"?cp=".$CurPlanet['id']."&amp;mode=".$_GET['mode']."&amp;re=0\">";
					$planetlist .= "<img src=\"".$dpath."planeten/small/s_".$CurPlanet['image'].".jpg\" height=\"50\" width=\"50\"><br />";
					$planetlist .= $CurPlanet['name']."</a><br /><br />";
				}
			}
		}
		$return = $currentplanet.$planetlist;
		echo $return;
	} else {
		$return = "";
	}

	return $return;
}

?>
