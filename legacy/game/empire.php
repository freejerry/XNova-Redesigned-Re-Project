<?php

/**
 * empire.php
 *
 * @version 2.0
 * @copyright 2009 by MadnessRed for XNova
 */

getLang('empire');
getLang('names');
$parse  = $lang;

/* A bit of xnova code */
$Order = ( $user['planet_sort_order'] == 1 ) ? "DESC" : "ASC" ;
$Sort  = $user['planet_sort'];
if($_GET['type'] != '3'){
	$_GET['type'] = '1';
}
$QryPlanets  = "SELECT * FROM {{table}} WHERE `id_owner` = '". $user['id'] ."' AND `planet_type` = '".idstring($_GET['type'])."' ORDER BY ";
if( $Sort == 0 ){
	$sortby = "`id` ". $Order;
	$QryPlanets .= $sortby;
}elseif( $Sort == 1 ){
	$sortby = "`galaxy`, `system`, `planet`, `planet_type` ". $Order;
	$QryPlanets .= $sortby;
}elseif( $Sort == 2 ){
	$sortby = "`name` ". $Order;
	$QryPlanets .= $sortby;
}

if(idstring($_GET['p']) >= 1){
	$parse['tabempire'] = idstring($_GET['p']);
}else{
	$parse['tabempire'] = 1;
	$_GET['p'] = 1;
}

$parse['type'] = idstring($_GET['type']);
$parse['page'] = idstring($_GET['p']);

if(idstring($_GET['type']) == 3){
	$parse['clase_pl1'] = '';
	$parse['clase_pl2'] = 'class="tips active"';
}else{
	$parse['clase_pl1'] = 'class="tips active"';
	$parse['clase_pl2'] = '';
}

$QryPlanets .= " LIMIT ".((idstring($_GET['p'])-1)*3).",3 ;";
$planetsrow = doquery ( $QryPlanets, 'planets');


//Get the planets / moon selection
$planets = array(); $moons = array();
$qry = doquery("SELECT `planet_type`,`name` FROM {{table}} WHERE `id_owner` = '".$user['id']."' ORDER BY ".$sortby." ;",'planets');
while($row = FetchArray($qry)){
	if($row['planet_type'] == 1){
		$planets[] = $row['name'];
	}elseif($row['planet_type'] == 3){
		$moons[] = $row['name'];		
	}
}

//Make a list of planets
$parse['planet_menu'] = '';
for($pln = 1; $pln <= ceil(sizeof($planets) / 3); $pln++){
	$min = (($pln*3)-2);
	$max = ($pln*3);
	if($max > sizeof($planets)){ $max = sizeof($planets); }
	$parse['planet_menu'] .= "
			<li onclick=\"loadpage('./?page=empire&type=1&p=".($pln)."&axah=1','".$parse['Empire']."','empire'); return false;\">
				<a onmouseover=\"this.bgColor='#313131';\" onmouseout=\"this.bgColor='#1B1D1F';\">".$planets[$min-1]." - ".$planets[$max-1]."</a>
			</li>";
}

//Make a list of moons
$parse['moon_menu'] = '';
for($pln = 1; $pln <= ceil(sizeof($moons) / 3); $pln++){
	$min = (($pln*3)-2);
	$max = ($pln*3);
	if($max > sizeof($planets)){ $max = sizeof($moons); }
	$parse['moon_menu'] .= "
			<li onclick=\"loadpage('./?page=empire&type=3&p=".($pln)."&axah=1','".$parse['Empire']."','empire'); return false;\">
				<a onmouseover=\"this.bgColor='#313131';\" onmouseout=\"this.bgColor='#1B1D1F';\">".$moons[$min-1]." - ".$moons[$max-1]."</a>
			</li>";
}



$planetsTPL = '
						<td class="planetbg">
							<div id="planetname[{n}]" class="planetname">{name}</div>
							<div id="planet[{n}]" class="planet ">
								<img src="{{skin}}/img/planets{moon}/{type}_{subtype}_7.jpg" width="156" height="156" />
							</div>
							<div id="coords[{n}]" class="coords">
								<a href="./?page=galaxy&galaxy={gal}&system={sys}">[{gal}:{sys}:{pos}]</a>
							</div>
							<div id="" class="fields tips" title="|Current fields / max fields">
								<span id="space[{n}]">{current_feild}/{max_feild}</span>
							</div>
							<div class="clearfloat"></div>
						</td>';
$parse['planets'] = '';
$array = array();
$n = 0;
while ($p = FetchArray($planetsrow)) {
	$n++;

	$pl = PlanetType($p['image']);
	$pl['n'] = $n;
	$pl['gal'] = $p['galaxy'];
	$pl['sys'] = $p['system'];
	$pl['pos'] = $p['planet'];
	$pl['current_feild'] = $p['field_current'];
	$pl['max_feild'] = $p['field_max'];
	$pl['name'] = $p['name'];
	$pl['moon'] = '';
	if($p['planet_type'] == 3){ $pl['moon'] = '/moon'; }
	$parse['planets'] .= parsetemplate($planetsTPL,$pl);

	$array['resources']['metal']['n'] = $lang['Metal'];
	$array['resources']['metal'][$n]  = KMnumber($p['metal'])." / ".KMnumber($p['metal_max']);
	$array['resources']['crystal']['n'] = $lang['Crystal'];
	$array['resources']['crystal'][$n]  = KMnumber($p['crystal'])." / ".KMnumber($p['crystal_max']);
	$array['resources']['deuterium']['n'] = $lang['Deuterium'];
	$array['resources']['deuterium'][$n]  = KMnumber($p['deuterium'])." / ".KMnumber($p['deuterium_max']);
	$array['resources']['energy']['n'] = $lang['Energy'];
	$array['resources']['energy'][$n]  = KMnumber($p['energy_max']);

	foreach($reslist['build'] as $id){
		if(in_array($id,$reslist['prod'])){
			//Supply
			$array['supply'][$id]['n'] = $lang['names'][$id];
			$array['supply'][$id][$n] = KMnumber($p[$resource[$id]]);
		}else{
			//Facilities
			$array['station'][$id]['n'] = $lang['names'][$id];
			$array['station'][$id][$n] = KMnumber($p[$resource[$id]]);
		}
	}
	foreach($reslist['tech'] as $id){
		//Research
		$array['research'][$id]['n'] = $lang['names'][$id];
		$array['research'][$id][$n] = KMnumber($user[$resource[$id]]);
	}
	foreach($reslist['fleet'] as $id){
		//Shipyard
		$array['shipyard'][$id]['n'] = $lang['names'][$id];
		$array['shipyard'][$id][$n] = KMnumber($p[$resource[$id]]);
	}
	foreach($reslist['defense'] as $id){
		//Defense
		$array['defense'][$id]['n'] = $lang['names'][$id];
		$array['defense'][$id][$n] = KMnumber($p[$resource[$id]]);
	}
}
for($no = $n; $no < 3; $no++){
	$parse['planets'] .= '
							<td class="planetbg">
								<div id="planetname['.$no.']" class="planetname"></div>
								<div id="planet['.$no.']" class="planet"></div>
								<div id="coords['.$no.']" class="coords"></div>
								<div id="" class="fields tips"><span id="space['.$no.']"></span></div>
								<div class="clearfloat"></div>
							</td>';
}

$rowsTPL = '

					<tr class="resource">
						<td class="switch tips"
							id="base-td"
							onclick="FlickDisplay(\'row_{type}\',\'table-row\');"
							onmouseover="this.className=\'switchhover tips\'"
							onmouseout="this.className=\'switch tips\'"
							colspan="4"
							title="{ShowHide} {name}">
							{name}
						</td>
					</tr>
					<tr class="desc-tr-alt" id="row_{type}" style="display: none;">
						<td colspan="5">
							<table class="data" cellpadding="0" cellspacing="0">
{rows}
								<tr>
									<td class="desc-footer" colspan="4"></td>
								</tr>
					   		</table>
							<!-- end table#data -->
						</td>
					</tr>';



$rows = array();
//echo "<pre>"; print_r($array); echo "</pre>";
foreach($array as $type => $stuff){
	$rows['rows'] = '';
	$rows['type'] = $type;
	$rows['name'] = $lang[$type];
	$n = 1;
	foreach($stuff as $id => $stuff){
		if($n == 1){ $alt = '-alt'; $n = 0; }else{ $alt = ''; $n = 1; }
		$rows['rows'] .= '
								<tr class="desc-tr'.$alt.'">
									<td class="desc">'.$stuff['n'].'</td>
									<td style="width:20px;"></td>
									<td class="value "><a>'.$stuff[1].'</a></td>
									<td class="value "><a>'.$stuff[2].'</a></td>
									<td class="value "><a>'.$stuff[3].'</a></td>
								</tr>';
	}
	$parse['row_'.$type] = parsetemplate($rowsTPL,$rows);
}
$page = parsetemplate(gettemplate('empire'), $parse);

if($_GET['axah']){
	makeAXAH($page);
}else{
	displaypage($page, $lang['Empire']);
}

// Created by MadnessRed. All rights reserved (C) 2009
?>
