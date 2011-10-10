<?php
/**
 * alliance_stat.php
 *
 * @version 1
 * @copyright 2008 By Eumele for XNova
 */
/*
//Playercardmod Eumele
	$membercount    = 0;
	$gesamtkaempfe  = 0;
	$gesamtwins	    = 0;
	$gesamtdraw	    = 0;
	$gesamtloos     = 0;
	$gesamtmetal    = 0;
	$gesamtkbcrystal= 0;
	$gesamtlostunits= 0;
	$gesamtdesunits = 0;
	$allymember = doquery("SELECT * FROM {{table}} WHERE ally_id='{$seeallyid}'", 'users');
		while($usid = mysql_fetch_array($allymember)){
		        $gesamtkaempfe        		= $gesamtkaempfe + $usid['wons'] + $usid['loos'] +  $usid['draws'];
				$gesamtwins					= $gesamtwins + $usid['wons'];
				$gesamtdraw					= $gesamtdraw + $usid['draws'];
				$gesamtloos					= $gesamtloos + $usid['loos'];
				$gesamtmetal				= $gesamtmetal + $usid['kbmetal'];
				$gesamtkbcrystal			= $gesamtkbcrystal + $usid['kbcrystal'];
				$gesamtlostunits			= $gesamtlostunits + $usid['lostunits'];
				$gesamtdesunits				= $gesamtdesunits + $usid['desunits']; 
				$membercount++;
											}
		$siegprozent				= 100 / $gesamtkaempfe * $gesamtwins;
		$loosprozent				= 100 / $gesamtkaempfe * $gesamtloos;
        $drawsprozent				= 100 / $gesamtkaempfe * $gesamtdraw;
		$lang['quota'] = "<tr><th>{$lang['Quote']}</th><th>" . round($siegprozent, 2) . " %</th></tr>";									
		$lang['allystat'] = "
		<tr><th>{$lang['Gesamtk']}</th><th align=\"right\">" . pretty_number( $gesamtkaempfe ) . "</th></tr>
		<tr><th>{$lang['Siege']}</th><th>" . pretty_number( $gesamtwins ) . " (" . round($siegprozent, 2) . " % )</th></tr>
		<tr><th>{$lang['Loosi']}</th><th>" . pretty_number( $gesamtloos ) . " (" . round($loosprozent, 2) . " % )</th></tr>
		<tr><th>{$lang['Drawp']}</th><th>" . pretty_number( $gesamtdraw ) . " (" . round($drawsprozent, 2) . " % )</th></tr>
		<tr><th>{$lang['unitsshut']}</th><th>" . pretty_number( $gesamtdesunits	 ) . "</th></tr>
		<tr><th>{$lang['unitsloos']}</th><th>" . pretty_number( $gesamtlostunits ) . "</th></tr>
		<tr><th>{$lang['tfmetall']}</th><th>" . pretty_number( $gesamtmetal ) . "</th></tr>
		<tr><th>{$lang['tfkristall']}</th><th>" . pretty_number( $gesamtkbcrystal ) . "</th></tr>";
		//Playercardmod Eumele ende
	*/	
		
		?>