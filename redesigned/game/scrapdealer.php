<?php

define('INSIDE'  , true);
define('INSTALL' , false);

define('ROOT_PATH' , '');
include(ROOT_PATH . 'common.php');

includeLang('scrapdealer');

if (array_key_exists('shiptypeid', $_POST)) {
	$res_id = $_POST['shiptypeid'];
} else {
	$res_id = 202;	
}

if (array_key_exists('number_ships_sell', $_POST)) {
	$number_ships_sell = $_POST['number_ships_sell'];
} else {
	$number_ships_sell = 0;	
}

// Variable Angebote
$offer_valid_minutes = 1; // Gültigkeitsdauer des Angebots in Minuten
$offer_changed = false; // Flag für zwischenzeitliche Änderung des Angebots
$scrap_rate_met_min = 50; $scrap_rate_met_max = 80; // Rückgewinnung Metall - Minimum - Maximum - in Prozent
$scrap_rate_crys_min = 50; $scrap_rate_crys_max = 80; // Rückgewinnung Kristall - Minimum - Maximum - in Prozent
$scrap_rate_deut_min = 30; $scrap_rate_deut_max = 60; // Rückgewinnung Deuterium - Minimum - Maximum - in Prozent
$scrapdealer_id = 1; // Id des Schrotthändler; z. Zt. nur ein Schrotthändler


$sql_query = "SELECT * FROM {{table}} WHERE id = $scrapdealer_id";
$result = doquery($sql_query, 'scrapdealer');
$result_row = mysql_fetch_array($result);

if ($result_row['offer_expires'] < time()) {
	$offer_expires = time() + $offer_valid_minutes * 60;
	$scrap_rate_met = mt_rand($scrap_rate_met_min, $scrap_rate_met_max);
	$scrap_rate_crys = mt_rand($scrap_rate_crys_min, $scrap_rate_crys_max);
	$scrap_rate_deut = mt_rand($scrap_rate_deut_min, $scrap_rate_deut_max);
	$sql_query = "UPDATE {{table}} SET
		scrap_rate_met = $scrap_rate_met,
		scrap_rate_crys = $scrap_rate_crys,
		scrap_rate_deut = $scrap_rate_deut,
		offer_expires = $offer_expires
		WHERE id = $scrapdealer_id";
	doquery($sql_query, 'scrapdealer');
	$offer_changed = true;
} else {
	$scrap_rate_met = $result_row['scrap_rate_met'];
	$scrap_rate_crys = $result_row['scrap_rate_crys'];
	$scrap_rate_deut = $result_row['scrap_rate_deut'];
}

// Herstellungskosten des Schifftyps ermitteln
$price_met = $pricelist[$res_id]['metal'];  // Metal
$price_crys = $pricelist[$res_id]['crystal'];  // Crystal
$price_deut = $pricelist[$res_id]['deuterium'];  // Deuterium

// Rückgewinnungswerte pro Schiff
$scrap_met = $price_met * ($scrap_rate_met / 100);
$scrap_crys = $price_crys * ($scrap_rate_crys / 100);
$scrap_deut = $price_deut * ($scrap_rate_deut / 100);

if($_POST){

	if($number_ships_sell > 0 && $planetrow[$resource[$res_id]]!=0 && !$offer_changed){

		if($number_ships_sell > $planetrow[$resource[$res_id]]){
			$number_ships_sell = $planetrow[$resource[$res_id]];
		}

		$planetrow['metal'] += $number_ships_sell * $scrap_met;
		$planetrow['crystal'] += $number_ships_sell * $scrap_crys;
		$planetrow['deuterium'] += $number_ships_sell * $scrap_deut;
		$planetrow[$resource[$res_id]] -= $number_ships_sell;

		doquery("UPDATE {{table}} SET
			metal='{$planetrow['metal']}',
			crystal='{$planetrow['crystal']}',
			deuterium='{$planetrow['deuterium']}',
			{$resource[$res_id]}='{$planetrow[$resource[$res_id]]}'
			WHERE id='{$user['current_planet']}'",'planets');

	}
}

$parse = $lang;

$parse['shiplist'] = '';
foreach ($reslist['fleet'] as $value) {
	$parse['shiplist'] .= "\n<option ";
	if ($res_id == $value) {
		$parse['shiplist'] .= "selected=\"selected\" ";
	}
	$parse['shiplist'] .= "value=\"".$value."\">";
	$parse['shiplist'] .= $lang['tech'][$value];
	$parse['shiplist'] .= "</option>";
}

$parse['image'] = $res_id;
$parse['dpath'] = $dpath;
$parse['scrap_met'] = $scrap_met;
$parse['scrap_crys'] = $scrap_crys;
$parse['scrap_deut'] = $scrap_deut;
$parse['shiptype_id'] = $res_id;
$parse['max_ships_to_sell'] = $planetrow[$resource[$res_id]];
$parse_temp = str_replace('%scrap_rate_met', $scrap_rate_met, $lang['Merchant_text_descript']);
$parse_temp = str_replace('%scrap_rate_crys', $scrap_rate_crys, $parse_temp);
$parse['Merchant_text_descript'] = str_replace('%scrap_rate_deut', $scrap_rate_deut, $parse_temp);
$parse['Merchant_give_Met'] = str_replace('%met', gettemplate('scrap_met'), $lang['Merchant_give_Met']);
$parse['Merchant_give_Crys'] = str_replace('%crys', gettemplate('scrap_crys'), $lang['Merchant_give_Crys']);
$parse['Merchant_give_Deut'] = str_replace('%deut', gettemplate('scrap_deut'), $lang['Merchant_give_Deut']);
$page = parsetemplate(gettemplate('scrapdealer'), $parse);

display($page,$lang['Intergalactic_scrapdealer']);

?>
