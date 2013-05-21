<?php

function battle_log($stringData){
	$myFile = "battle_log.txt";
	$fh = fopen($myFile, 'a') or die("can't open file");
	fwrite($fh, $stringData."\n");
	fclose($fh);
}


function MissionCaseAttack($fleetrow,$log=true){
	global $resource,$reslist;
	
	//Well here goes the main part of XNova, fingers crossed that it will work.
	
	//Get this planet
	$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = ".$fleetrow['target_id'],'planets',true);

	//Log
	if($log){
		battle_log("Attack - ".date('H:i:s').".\nFleetRow:\n".print_r($fleetrow,true)."\nCurrent planet:".print_r($CurrentPlanet,true));
	}

	//Get all fleets
	$CurrentSet = array();
	$CurrentTechno = array();
	
	//This fleet
	$CurrentTechno[$fleetrow['id']] = mysql_fetch_array(doquery("SELECT `".$resource[109]."`,`".$resource[110]."`,`".$resource[111]."` FROM {{table}} WHERE `id` = ".$fleetrow['owner_userid'],'users'),MYSQL_NUM);
	$CurrentSet[$fleetrow['id']] = array();
	$fleetarray = explode(";",$fleetrow['array']);
	foreach($fleetarray as $ships){
		if(strlen($ships) > 5){
			$ships = explode(",",$ships);
			$CurrentSet[$fleetrow['id']][$ships[0]] = $ships[1];
		}
	}
	
	//ACS?
	if($fleetrow['fleet_group'] > 0){
		//We have some acs fleets, maybe
		$acs = doquery("SELECT * FROM {{table}} WHERE `fleet_group` = '".$fleetrow['fleet_group']."' AND `mission` = 2 AND `fleet_mess` = 0",'fleets');
		while($acsrow = mysql_fetch_assoc($acs)){
			$CurrentTechno[$acsrow['id']] = mysql_fetch_array(doquery("SELECT `".$resource[109]."`,`".$resource[110]."`,`".$resource[111]."` FROM {{table}} WHERE `id` = ".$acsrow['owner_userid'],'users'),MYSQL_NUM);
			$CurrentSet[$acsrow['id']] = array();
			$fleetarray = explode(";",$acsrow['array']);
			foreach($fleetarray as $ships){
				if(strlen($ships) > 5){
					$ships = explode(",",$ships);
					$CurrentSet[$acsrow['id']][$ships[0]] = $ships[1];
				}
			}
		}
	}
	
	//Get defenders stuff
	$TargetSet = array();
	$TargetTechno = array();
	foreach($reslist['dbattle'] as $e){ $TargetSet[0][$e] = $CurrentPlanet[$resource[$e]]; }
	foreach($reslist['fleet']   as $e){ $TargetSet[0][$e] = $CurrentPlanet[$resource[$e]]; }
	$TargetTechno[0] = mysql_fetch_array(doquery("SELECT `".$resource[109]."`,`".$resource[110]."`,`".$resource[111]."`' FROM {{table}} WHERE `id` = ".$CurrentPlanet['id_owner'],'users'),MYSQL_NUM);
	
	//ACS?
		//We have some acs fleets, maybe
		$acs = doquery("SELECT * FROM {{table}} WHERE `targetid` = '".$fleetrow['targetid']."' AND `mission` = 5 AND `fleet_mess` = 0 AND `arrival` < '".$fleetrow['arrival']."' AND `arrival`+`hold_time` > '".$fleetrow['arrival']."'",'fleets');
		while($acsrow = mysql_fetch_assoc($acs)){
			$TargetTechno[$acsrow['id']] = mysql_fetch_array(doquery("SELECT `".$resource[109]."`,`".$resource[110]."`,`".$resource[111]."` FROM {{table}} WHERE `id` = ".$acsrow['owner_userid'],'users'),MYSQL_NUM);
			$TargetSet[$acsrow['id']] = array();
			$fleetarray = explode(";",$acsrow['array']);
			foreach($fleetarray as $ships){
				if(strlen($ships) > 5){
					$ships = explode(",",$ships);
					$TargetSet[$acsrow['id']][$ships[0]] = $ships[1];
				}
			}
		}

	

	//Log
	if($log){
		battle_log("Data given to the battle engine:");
		battle_log("PadaCombatSac(".$attacker_fleet.", ".$defender_fleet.", ".$CurrentTechno.", ".$TargetTechno.", ".$planeta_atacante.", ".$planeta_defensores.",  ".$FleetRow['fleet_start_time'].");");
	}

	//Do the battle
	include_once(ROOT_PATH."includes/battle_engines/padacombat.php");
	$result = PadaCombatSac($attacker_fleet, $defender_fleet, $CurrentTechno, $TargetTechno, $planeta_atacante, $planeta_defensores, $FleetRow['fleet_start_time']);
	  
	//Calculo de la probabilidad de luna...
	$MoonChance = floor(($result['debris']['metal'] + $result['debris']['crystal']) / 100000);
	if($MoonChance > 20){ $MoonChance = 20;	}

	if(mt_rand(1, 100) < $MoonChance){
		//They get a moon!!!
		//Find if there is a moon there already?
		$lunaid = doquery("SELECT `id` FROM {{table}} WHERE `galaxy` = ".$CurrentPlanet['galaxy']." AND `system` = ".$CurrentPlanet['system']." AND `planet` = ".$CurrentPlanet['planet']." AND `planet_type` = 3 ;",'planets',true);
		if(!$lunaid['id']){
			//There is no moon - lets add one
			AddMoon($CurrentPlanet['galaxy'],$CurrentPlanet['galaxy'],$CurrentPlanet['galaxy'],$MoonChance,'_DEFAULT_',$CurrentPlanet);
			$Mensaje_luna = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
		}		
	}

	$Mes_prob = sprintf($lang['sys_moonproba'], $MoonChance);
	
	
	//die("I'm tired so this file is not finished yet"); // I'm not tired, so I will finish it. And, I'm spanish, so I can understand the comments
	
	
		 
	  //Ahora viene un tochaco de 140 lineas, que se dive en dos partes principales: la primera intenta añadir los mismos recursos a todas las flotas; la segunda, rellena con los recursos sobrantes las flotas que puede....
	  if(!empty($result['attacker']) AND $result['battle_result'] == 2){
	  
		foreach ($result['attacker'] as $id => $flota){
			foreach ($flota as $Ship => $Count) {
			
				$Capacidad_flota	+= $pricelist[$Ship]['capacity'] * $Count;
			
			}
			//$Capacidad_total += $Capacidad_flota;
			$Capacidad[$id]= $Capacidad_flota;
			
			unset ($Capacidad_flota);
		}
		//Lo maximo por flota
		$f_totales = count($result[attacker]);
		$total = ($planet_def['metal']+ $planet_def['crystal']+ $planet_def['deuterium'])/2;
		
		//Losrecursos maximos a mangar...
		$maximo_total = $total/$f_totales;
		$m_metal = $planet_def['metal']/2;
		$m_cristal = $planet_def['crystal']/2;
		$m_deuterio = $planet_def['deuterium']/2;
		
		//Los recursos a robar por usuario...
		$metal = ($planet_def['metal']/2) / $f_totales;
		$cristal = ($planet_def['crystal']/2) / $f_totales;
		$deuterio = ($planet_def['deuterium']/2) / $f_totales;
		//echo "m_metal = $m_metal , m_cristal= $m_cristal , m_deuterio = $m_deuterio , metal = $metal , cristal = $cristal , deuterio= $deuterio , f_totales = $f_totales , total = $total , capacidad = print_r($Capacidad)";
		
		if($maximo_total > 0){
		//Creamos una copia del array
		$resultatac = $result[attacker];
			//Ahora hacemos el primer llenado de las flotas, con lo que se pueda (siempre que se respete la mitad de los recursos del planeta, entre el numero de atacantes supervivientes...)
			foreach ($result[attacker] as $id => $flota){
				$resultado[$id]['metal'] = 0;
				$resultado[$id]['cristal'] = 0;
				$resultado[$id]['deuterio'] = 0;
				$maximo = $maximo_total;
				if($Capacidad[$id] > 0){
					//El acero
					if (($metal) > $Capacidad[$id] / 3) {
						$resultado[$id]['metal']   = $Capacidad[$id] / 3;
						$Capacidad[$id]	 -= $resultado[$id]['metal'];
						$m_metal -= $Capacidad[$id] / 3;
					} else {
						$resultado[$id]['metal']   = $metal;
						$Capacidad[$id]	-= $resultado[$id]['metal'];
						$m_metal -= $metal;
					}
						
					//El silicio (no sicilio... XD)
					if (($cristal) > $Capacidad[$id] / 2) {
						$resultado[$id]['cristal'] = $Capacidad[$id] / 2;
						$Capacidad[$id]	 -= $resultado[$id]['cristal'];
						$m_cristal -= $Capacidad[$id] / 2;
					} else {
						$resultado[$id]['cristal'] = $cristal;
						$Capacidad[$id]	 -= $resultado[$id]['cristal'];
						$m_cristal -= $cristal;
					}
					
					//El tritio
					if (($deuterio) > $Capacidad[$id]) {
						$resultado[$id]['deuterio']  = $Capacidad[$id];
						$Capacidad[$id]	  -= $resultado[$id]['deuterio'];
						$m_deuterio -= $Capacidad[$id];
					} else {
						$resultado[$id]['deuterio']  = $deuterio;
						$Capacidad[$id]	 -= $resultado[$id]['deuterio'];
						$m_deuterio -= $deuterio;
					}
					//Si queda espacio en la flota se suma este espacio a la capacidad de recursos restantes...Sino se descarta la flota del array
					if($Capacidad[$id] > 0){
						$cap_restante += $Capacidad[$id];
					}else{
						unset ($resultatac[$id]);
					}
										
				}
			}
			//Ahora se hace otra pasada para rellenar las naves restantes con capacidad con lo que queda...
			if(!empty($resultatac)){
			
				shuffle($resultatac);  //Mezclamos para que sea mas justo para los jugadores....
				foreach ($resultatac as $id => $flota) {
					if($cap_restante == 0){
						break;
					}
					
					if($Capacidad[$id] >= ($m_metal+ $m_cristal+ $m_deuterio)){
						$resultado[$id]['metal'] += $m_metal;
						$resultado[$id]['cristal'] += $m_cristal;
						$resultado[$id]['deuterio'] += $m_deuterio;
						$cap_restante = 0;
					
					}else{
						if($m_metal > 0){
							if($m_metal >= $Capacidad[$id]){
								$resultado[$id]['metal'] += $Capacidad[$id];
								$m_metal -= $Capacidad[$id];
							}else{
							$resultado[$id]['metal'] += $m_metal;
							$cap_restante -= $Capacidad[$id];
						}
						
						if($m_metal >= 0 AND $cap_restante > 0){
							if (($m_metal ) > $Capacidad[$id] / 3) {
								$resultado[$id]['metal']   += $Capacidad[$id] / 3;
								$Capacidad[$id]	 -= $resultado[$id]['metal'];
								$cap_restante -= $resultado[$id]['metal'];
								$m_metal -= $resultado[$id]['metal'];
							} else {
								$resultado[$id]['metal']   += $m_metal;
								$Capacidad[$id]	-= $resultado[$id]['metal'];
								$cap_restante -= $resultado[$id]['metal'];
								$m_metal = 0;
							}
						}	
						if($m_cristal > 0 AND $cap_restante > 0){
							if (($m_cristal) > $Capacidad[$id] / 2) {
								$resultado[$id]['cristal'] += $Capacidad[$id] / 2;
								$Capacidad[$id]	 -= $resultado[$id]['cristal'];
								$cap_restante -= $resultado[$id]['cristal'];
								$m_cristal -= $resultado[$id]['cristal'];
							} else {
								$resultado[$id]['cristal'] += $m_cristal;
								$Capacidad[$id]	 -= $resultado[$id]['cristal'];
								$cap_restante -= $resultado[$id]['cristal'];
								$m_cristal = 0;
							}
						}	
						if($m_deuterio > 0 AND $cap_restante > 0){
							if (($m_deuterio) > $Capacidad[$id]) {
								$resultado[$id]['deuterio']  += $Capacidad[$id];
								$Capacidad[$id]	  -= $resultado[$id]['deuterio'];
								$cap_restante -= $resultado[$id]['deuterio'];
								$m_deuterio -= $resultado[$id]['deuterio'];
							} else {
								$resultado[$id]['deuterio']  += $m_deuterio;
								$Capacidad[$id]	 -= $resultado[$id]['deuterio'];
								$cap_restante -= $resultado[$id]['deuterio'];
								$m_deuterio = 0;
							}
						}
						
					}
				}
			}
		}
		
	  unset($Capacidad, $cap_restante, $resultatac, $m_deuterio, $m_cristal, $m_metal);
	}
	
	  //Si se han destruido las flotas atacantes
	  if (empty($result[attacker])){
		  doquery ("DELETE FROM {{table}} WHERE sac_id = '{$FleetRow['sac_id']}' OR  fleet_id = '{$FleetRow['fleet_id']}'", 'fleets');
	  }else{
		//Vamos una a una comprobando las flotas que se mantienen con vida. Las que no, se borran.
		foreach ($attacker_fleet as $id => $flota){
			if (empty($result[attacker][$id])){
				doquery ("DELETE FROM {{table}} WHERE fleet_id = '{$id}' LIMIT 1 ", 'fleets');
			}else{
				$FleetArray = '';
				$FleetAmount = 0 ;
				foreach ($result[attacker][$id] as $Ship => $Count) {
					if($Ship !='' OR $Count !='' ){//$FleetStorage += $pricelist[$Ship]["capacity"] * $Count['count'];
						$FleetArray   .= $Ship.",".$Count.";";
						$FleetAmount  += $Count;
					}
				}
				
				//Actualizamos la flota para que vuelva a casa con las naves debidas	
				$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
				$QryUpdateGalaxy .= " fleet_array = '{$FleetArray}' , ";
				$QryUpdateGalaxy .= " fleet_amount = '{$FleetAmount}' , ";
				$QryUpdateGalaxy .= " fleet_mess = 1 , ";
				$QryUpdateGalaxy .= " fleet_resource_metal = fleet_resource_metal + '{$resultado[$id]['metal']}', ";
				$QryUpdateGalaxy .= " fleet_resource_crystal = fleet_resource_crystal + '{$resultado[$id]['cristal']}', ";
				$QryUpdateGalaxy .= " fleet_resource_deuterium = fleet_resource_deuterium + '{$resultado[$id]['deuterio']}', ";
				$QryUpdateGalaxy .= " actualizar = fleet_end_time  ";
				$QryUpdateGalaxy .= "WHERE ";
				$QryUpdateGalaxy .= " fleet_id = '{$id}' ";
				$QryUpdateGalaxy .= "LIMIT 1 ";
				doquery( $QryUpdateGalaxy , 'fleets');
			
			}
					
		}
	  }
	  //Guardamos el valor del array del usuario defensor
	  $defender_pl = $result[defender][0];
	  unset ($result[defender][0]);
	
	  //Si se han destruido las flotas defensoras
	  if (empty($result[defender])){
		$Qry   = "DELETE FROM {{table}} ";
		$Qry  .= "WHERE ";
		$Qry  .= " fleet_mission = 5 AND ";
		$Qry  .= " fleet_end_galaxy = '{$FleetRow['fleet_end_galaxy']}' AND ";
		$Qry  .= " fleet_end_system = '{$FleetRow['fleet_end_system']}' AND ";
		$Qry  .= " fleet_end_planet = '{$FleetRow['fleet_end_planet']}' AND ";
		$Qry  .= " fleet_end_type = '{$FleetRow['fleet_end_type']}' AND ";
		$Qry  .= " staying = 1 AND fleet_mess = 0";
		doquery ($Qry, 'fleets');
	  }else{
		//Vamos una a una comprobando las flotas que se mantienen con vida. Las que no, se borran.
		foreach ($defender_fleet as $id => $flota){
			if (empty($result[defender][$id])){
				doquery ("DELETE FROM {{table}} WHERE fleet_id = '{$id}' LIMIT 1 ", 'fleets');
			}else{
				$FleetArray = '';
				$FleetAmount = 0 ;
				foreach ($result[defender][$id] as $Ship => $Count) {
					//Una comprobacion necesaria...
					if($Ship !='' OR $Count !='' ){
						//$FleetStorage += $pricelist[$Ship]["capacity"] * $Count['count'];
						$FleetArray   .= $Ship.",".$Count.";";
						$FleetAmount  += $Count;
					}
				}
				
			//Actualizamos la flota para que vuelva a casa con las naves debidas	
			$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
			$QryUpdateGalaxy .= " fleet_array = '{$FleetArray}' , ";
			$QryUpdateGalaxy .= " fleet_amount = '{$FleetAmount}' ";
			//$QryUpdateGalaxy .= " fleet_mess = 1 ";
			$QryUpdateGalaxy .= "WHERE ";
			$QryUpdateGalaxy .= " fleet_id = '{$id}' ";
			$QryUpdateGalaxy .= "LIMIT 1 ";
			doquery( $QryUpdateGalaxy , 'fleets');
			
			}
		
		}
	 }
	}
	//Actualizamos el planeta defensor...
	//print_r($defender_pl);
	//print_r($result);
	//echo $result['report'];
	
	$Message.= $result['report'];
	
	$Message.= '<br><br>La batalla ha durado '.$result['rounds'].' rondas.';
	if($result['battle_result'] == 2){
		$Message .= "<br><br><table width=100% ><tr><td><DIV ALIGN=left>".$lang['sys_attacker_won']."<br>";
		foreach ($result[attacker] as $id => $flota){
			$Message .= sprintf($lang['sys_atac_roba'], $user_atac[$id]['username'], pretty_number($resultado[$id]['metal']), pretty_number($resultado[$id]['cristal']), pretty_number($resultado[$id]['deuterio']));
		}
	}elseif($result['battle_result'] == 1){
		$Message .= $lang['sys_both_won']."<br>";
	}else{
		$Message .= $lang['sys_defender_won']."<br>";
	}
	

	//El atacante ha perdido x unidades
	$Message .= "<br>".sprintf($lang['sys_attacker_lostunits'], $result['debris']['attacker'])."<br>";
	//El defensor ha perdido x unidades
	$Message .= sprintf($lang['sys_defender_lostunits'], $result['debris']['defender'])."<br>";
	//En estas coordenadas flotan x de acero, x de silicio
	$Message .= sprintf($lang['sys_gcdrunits'], pretty_number($result['debris']['metal']), pretty_number($result['debris']['crystal']))."<br>";
	//Mensajes de la probabilidad de luna
	$Message.= "<br>".$Mes_prob.$Mensaje_luna.sprintf($lang['sys_rapport_build_time'], microtime(true)- $time)."</DIV></td></tr></table>";
	
	//AÑADIMOS EL REPORTE A LA TABLA DE RW
	//Si se ha producido solo una ronda, se pone ese valor como 1 (para lo de que se ha perdido el contacto...)
	($result['rounds'] <= 2 AND $result['battle_result'] == 3) ? $ver_o_no = 1 : $ver_o_no = 0;
	$rid   = md5($Message);
	 
	 
	 $QryInsertRapport  = "INSERT INTO {{table}} SET ";
	 $QryInsertRapport .= "`time` = UNIX_TIMESTAMP(), ";
	 $QryInsertRapport .= "`id_owner1` = '". $id_owner1txt ."', ";
	 $QryInsertRapport .= "`id_owner2` = '1', ";
	 $QryInsertRapport .= "`rid` = '". $rid ."', ";
	 $QryInsertRapport .= "`a_zestrzelona` = '".$ver_o_no."', ";
	 $QryInsertRapport .= "`raport` = '". addslashes ( $Message ) ."';";
	 doquery( $QryInsertRapport , 'rw');

	 // Creamos el mensajito coloreado que se manda a los ATACANTES
	$raport_ini  = "<a href # OnClick=\"f( 'rw.php?raport=". $rid ."', '');\" >";
	$raport_ini .= "<center>";
	if	   ($result['battle_result'] == 2) {
		$raport_ini .= "<font color=\"green\">";
	} elseif ($result['battle_result'] == 3) {
		$raport_ini .= "<font color=\"orange\">";
	} elseif ($result['battle_result'] == 1) {
		$raport_ini .= "<font color=\"red\">";
	}
	$raport .= $lang['sys_mess_attack_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br /><br />";
	$raport .= "<font color=\"red\">". $lang['sys_perte_attaquant'] .": ". pretty_number($result['debris']['attacker']) ."</font>";//Perdidas atacante
	$raport .= "<font color=\"green\">   ". $lang['sys_perte_defenseur'] .":". pretty_number($result['debris']['defender']) ."</font><br />" ; //Perdidas defensor
	//Ganancias
	$raport .= $lang['sys_debris'] ." ". $lang['Metal'] .":<font color=\"red\">". pretty_number($result['debris']['metal']) ."</font>   ". $lang['Crystal'] .":<font color=\"#ef51ef\">". pretty_number($result['debris']['crystal']) ."</font><br />";
	
	//Creamos un array en elq ue se asocie el nombre del atacante con el id de las flotas que le pertenecen...
	$check = array();
	foreach ($attacker_fleet as $id => $flota){
		$name = $user_atac[$id]['id'];
		if(!$check[$name]){
			$check[$name] = array();
		}
		$check[$name] = array_merge($check[$name],array($id) );
	}
	//Luego, para no hacer que el usuario tenga que sumar un poco (es malo para el), miramos a ver si hay flotas del mismo usuario y le ponemos en una sola linea todos los recursos obtenidos
	foreach ($check as $id => $info){
		foreach($check[$id] as $nombre => $idx){
			$metal_fin[$user_atac[$id]['id']] += $resultado[$idx]['metal'];
			$cristal_fin[$user_atac[$id]['id']] += $resultado[$idx]['cristal'];
			$deuterio_fin[$user_atac[$id]['id']] += $resultado[$idx]['deuterio'];
			$a_restar_m += $resultado[$idx]['metal'];
			$a_restar_c += $resultado[$idx]['cristal'];
			$a_restar_d += $resultado[$idx]['deuterio'];
		}
		//Se crea el mensajillo con lo que ha ganado en total
		$raport_fin = $lang['sys_gain'] ." ". $lang['Metal'] .":<font color=\"red\">". pretty_number($metal_fin[$user_atac[$id]['id']]) ."</font>   ". $lang['Crystal'] .":<font color=\"#ef51ef\">". pretty_number($cristal_fin[$user_atac[$id]['id']]) ."</font>   ". $lang['Deuterium'] .":<font color=\"#f77542\">". pretty_number($deuterio_fin[$user_atac[$id]['id']]) ."</font></center><br />";
		
		SendSimpleMessage ( $id, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $raport_ini.$raport.$raport_fin);
	}
	
	// Creamos el mensajito coloreado que se manda a los DEFENSORES
	$raport2  = "<a href # OnClick=\"f( 'rw.php?raport=". $rid ."', '');\" >";
	$raport2 .= "<center>";
	if	   ($result['battle_result'] == 2) {
		$raport2 .= "<font color=\"green\">";
	} elseif ($result['battle_result'] == 3) {
		$raport2 .= "<font color=\"orange\">";
	} elseif ($result['battle_result'] == 1) {
		$raport2 .= "<font color=\"red\">";
	}
	$raport2 .= $lang['sys_mess_attack_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br /><br />";
	//Mandamos un mensajillo a acada defensor
	foreach ($user_def as $def_fleet => $info){
		SendSimpleMessage ( $info['id'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport2 );
	}
	
	
	//Actualizamos el planeta defensor
	$QryUpdatePlanet = "UPDATE {{table}} SET ";
	$QryUpdatePlanet .= "metal = metal - '{$a_restar_m}', ";
	$QryUpdatePlanet .= "crystal = crystal - '{$a_restar_c}', ";
	$QryUpdatePlanet .= "deuterium = deuterium - '{$a_restar_d}' ";
	if ($defender_fleet[0]){
		foreach ($defender_fleet[0] as $tipo => $cantidad){
			$QryUpdatePlanet .= ', ';
			
			if($tipo > 400 AND $tipo < 500){  //Coprobamos si es flota o defensa, para la reconstruccion de defensas
				$total = floor(($defender_fleet[0][$tipo] - $defender_pl[$tipo]) * (rand(60, 75)/100) + $defender_pl[$tipo]);
				$QryUpdatePlanet .= $resource[$tipo]. " = '".$total."'  ";
			}else{
				$QryUpdatePlanet .= $resource[$tipo]. " = '".$defender_pl[$tipo]."'  ";
			}
			
		}
	}	
	
	$QryUpdatePlanet .= " WHERE id = '{$planet_def['id']}' LIMIT 1 ";
	doquery( $QryUpdatePlanet , 'planets');
		
	
	//Añadimos los puntos de flotero y las cuentas de ataques...
	if  ($result['battle_result'] == 2) {
		//GANA EL ATACANTE
		foreach ($user_atac as $fleet_id => $info){
			$QryUpdateOfficier = "UPDATE {{table}} SET ";
			$QryUpdateOfficier .= "`xpraid` = xpraid + 2 , ";
			$QryUpdateOfficier .= "`raidswin` = raidswin + 1 , ";
			$QryUpdateOfficier .= "`raids` = raids + 1 ";
			$QryUpdateOfficier .= "WHERE id = '" . $user_atac[$fleet_id]['id'] . "' ";
			$QryUpdateOfficier .= "LIMIT 1 ;";
			doquery($QryUpdateOfficier, 'users');
		}
		foreach ($user_def as $fleet_id => $info){
			$QryUpdateOfficier = "UPDATE {{table}} SET ";
			if($user_def[$fleet_id]['xpraid'] > 0){
				$QryUpdateOfficier .= "`xpraid` = xpraid - 1 , ";
			}
			$QryUpdateOfficier .= "`raidsloose` = raidsloose + 1 , ";
			$QryUpdateOfficier .= "`raids` = raids + 1 ";
			$QryUpdateOfficier .= "WHERE id = '" . $user_def[$fleet_id]['id'] . "' ";
			$QryUpdateOfficier .= "LIMIT 1 ;";
			doquery($QryUpdateOfficier, 'users');
		}
	} elseif ($result['battle_result'] == 3) {
		//GANA DEFENSOR
		foreach ($user_def as $fleet_id => $info){
			$QryUpdateOfficier = "UPDATE {{table}} SET ";
			$QryUpdateOfficier .= "`xpraid` = xpraid + 2 , ";
			$QryUpdateOfficier .= "`raidswin` = raidswin + 1 , ";
			$QryUpdateOfficier .= "`raids` = raids + 1 ";
			$QryUpdateOfficier .= "WHERE id = '" . $user_def[$fleet_id]['id'] . "' ";
			$QryUpdateOfficier .= "LIMIT 1 ;";
			doquery($QryUpdateOfficier, 'users');
		}
		foreach ($user_atac as $fleet_id => $info){
			$QryUpdateOfficier = "UPDATE {{table}} SET ";
			if($user_atac[$fleet_id]['xpraid'] > 0){
				$QryUpdateOfficier .= "`xpraid` = xpraid - 1 , ";
			}
			$QryUpdateOfficier .= "`raidsloose` = raidsloose + 1 , ";
			$QryUpdateOfficier .= "`raids` = raids + 1 ";
			$QryUpdateOfficier .= "WHERE id = '" . $user_atac[$fleet_id]['id'] . "' ";
			$QryUpdateOfficier .= "LIMIT 1 ;";
			doquery($QryUpdateOfficier, 'users');
		}
	} elseif ($result['battle_result'] == 1) {
		//EMPATE
		foreach ($user_def as $fleet_id => $info){
			$QryUpdateOfficier = "UPDATE {{table}} SET ";
			$QryUpdateOfficier .= "`xpraid` = xpraid + 1 , ";
			$QryUpdateOfficier .= "`raidsdraw` = raidsdraw + 1 , ";
			$QryUpdateOfficier .= "`raids` = raids + 1 ";
			$QryUpdateOfficier .= "WHERE id = '" . $user_def[$fleet_id]['id'] . "' ";
			$QryUpdateOfficier .= "LIMIT 1 ;";
			doquery($QryUpdateOfficier, 'users');
		}
		foreach ($user_atac as $fleet_id => $info){
			$QryUpdateOfficier = "UPDATE {{table}} SET ";
			$QryUpdateOfficier .= "`xpraid` = xpraid + 1 , ";
			$QryUpdateOfficier .= "`raidsdraw` = raidsdraw + 1 , ";
			$QryUpdateOfficier .= "`raids` = raids + 1 ";
			$QryUpdateOfficier .= "WHERE id = '" . $user_atac[$fleet_id]['id'] . "' ";
			$QryUpdateOfficier .= "LIMIT 1 ;";
			doquery($QryUpdateOfficier, 'users');
		}
	}
	
	//Actualizamos la galaxia para añadir escombros
	if(($result['debris']['metal'] + $result['debris']['crystal']) > 0){
		$QryUpdateGalaxy = "UPDATE {{table}} SET ";
		$QryUpdateGalaxy .= "metal = metal+'{$result['debris']['metal']}' , ";
		$QryUpdateGalaxy .= "crystal = crystal+'{$result['debris']['crystal']}' ";
		$QryUpdateGalaxy .= "WHERE galaxy = '{$planet_def['galaxy']}' AND ";
		$QryUpdateGalaxy .= "system = '{$planet_def['system']}' AND ";
		$QryUpdateGalaxy .= "planet = '{$planet_def['planet']}' LIMIT 1 ";
		doquery( $QryUpdateGalaxy , 'galaxy');
	}
	
/*	$attacker_fleet =
	array(
		61 =>
			array(214 => 500),
		62 =>
			array(214 => 100)
		);

	$defender_fleet =
	array(
		51 =>
			array(	402 => 50000000,
					407 => 1,
					408 => 1),
		52 =>
			array(	204 => 150000)
		);

	$CurrentTechno =
	array(61 =>
		array(
			'military_tech' => 1,
			'shield_tech' => 2,
			'defence_tech' => 3,
			'rpg_amiral' => 0
			),
		62 =>
		array(
			'military_tech' => 3,
			'shield_tech' => 2,
			'defence_tech' => 1,
			'rpg_amiral' => 0
			)
		);

	$TargetTechno =
	array(51 =>
		array('military_tech' => 1,
			'shield_tech' => 2,
			'defence_tech' => 3,
			'rpg_amiral' => 0
			),
		52 =>
		array('military_tech' => 1,
			'shield_tech' => 2,
			'defence_tech' => 3,
			'rpg_amiral' => 0
			)
		);

	$InLogin = true;
	define('INSIDE'  , true);
	define('INSTALL' , false);
	$resultnova_root_path = './';
	include($resultnova_root_path . 'extension.inc');
	include($resultnova_root_path . 'common.' . $phpEx);
*/
//die();
	if($FleetRow['fleet_end_time'] <= time()){
	
			$Message			 = sprintf ($lang['atac_return'], GetTargetAdressLink($FleetRow, ''), $FleetRow['fleet_resource_metal'], $FleetRow['fleet_resource_crystal'], $FleetRow['fleet_resource_deuterium'] );
			$result = RestoreFleetToPlanet ( $FleetRow, true );
			if($result){
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
				doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow['fleet_id'], 'fleets');
			}
	}
	
 }

	function PadaCombatSac($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno, $planeta_atacante, $planeta_defensores, $time) {
		global $pricelist, $CombatCaps, $game_config, $lang;
		
		$mtime = microtime();
		$mtime = explode(' ', $mtime);
		$mtime = $mtime[1] + $mtime[0];
		$starttime = $mtime;
		
		foreach ($CurrentSet as $UID => $arrayx) {
			foreach ($arrayx as $ShipId => $quantity) {			
				//$attacker_attack_power_left += $quantity * ($CombatCaps[$ShipId]['attack'] + $CombatCaps[$ShipId]['attack'] * (1 + (0.1 * $CurrentTechno[$UID]['military_tech']) + (0.05 * $CurrentTechno[$UID]['rpg_amiral'])));
				
				$attacker_structure[$UID][$ShipId] = $quantity;
				$attacker_start_debris['metal'] += $quantity * $pricelist[$ShipId]['metal'];
				$attacker_start_debris['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
			}
		}
		
		if(!$TargetSet){
			$TargetSet = array();
		}
		
		foreach ($TargetSet as $UID => $arrayx) {
			foreach ($arrayx as $ShipId => $quantity) {			
				//$defender_attack_power_left += $quantity * ($CombatCaps[$ShipId]['attack'] + $CombatCaps[$ShipId]['attack'] * (1 + (0.1 * $CurrentTechno[$UID]['military_tech']) + (0.05 * $CurrentTechno[$UID]['rpg_amiral'])));
				
				$defender_structure[$UID][$ShipId] = $quantity;
				
				if($ShipId < 300) {
					$defender_start_debris['metal'] += $quantity * $pricelist[$ShipId]['metal'];
					$defender_start_debris['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
				}else{
					$defender_start_debris_defense['metal'] += $quantity * $pricelist[$ShipId]['metal'];
					$defender_start_debris_defense['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
				}
			}
		}

		for ($i = 1; $i < 8; $i++) {
			$totalrounds++;
			if($i == 1){
				$mes_report .= "<br>".$lang['enfrentaron'].date('r', $time)."<br>";
				
				//Tabla con las flotas del atacante...
				$mes_report .= bodyreport($attacker_structure, $planeta_atacante, $planeta_defensores, $CurrentTechno, $TargetTechno, false);
				
				//Tabla con las flotas del defensor
				$mes_report .= bodyreport($defender_structure, $planeta_atacante, $planeta_defensores, $CurrentTechno, $TargetTechno, true);
				
			}	
			
			if (count($defender_structure) == 0){
				if (count($defender_structure) == 0 AND count($attacker_structure) == 0) {
					$battle_result = 1;
				} elseif (count($defender_structure) == 0) {
					$battle_result = 2;
				} elseif (count($attacker_structure) == 0) {
					$battle_result = 3;
				}
				
				break;
			}else if(count($attacker_structure) == 0){
				$battle_result = 3;
				break;
			}else if($totalrounds == 7){
				$battle_result = 1;
				break;
			}

			$attacker_attack_power_left = CalculateAttack ($attacker_structure);
			$defender_attack_power_left = CalculateAttack ($defender_structure);
			
			//En cada ronda empieza atacando el atacante!!
			$Simul = PadaAttack($attacker_structure, $defender_structure, $attacker_attack_power_left);
			$defender_structure = $Simul[0];
			$attacker_attack_power_used = $attacker_attack_power_left - $Simul[1];
			
			//Luego va el defensor
			$Simul = PadaAttack($defender_structure, $attacker_structure, $defender_attack_power_left);
			$attacker_structure = $Simul[0];
			$defender_attack_power_used = $defender_attack_power_left - $Simul[1];
			
			//El atacante dispara. Gracias a los escudos...
			$mes_report .= "<br><h5>".sprintf($lang['sys_atac_disp'], $attacker_attack_power_used) ;
			$mes_report .= "<br>".sprintf($lang['sys_def_disp'], $defender_attack_power_used)."</h5><br><br>";
			
			unset($Simul, $defender_attack_power_left, $attacker_attack_power_left, $defender_attack_power_used, $attacker_attack_power_used);
			
			$mes_report .= $lang['sys_tras_ronda'];
			
			//Tabla con las flotas del atacante...
			$mes_report .= bodyreport($attacker_structure, $planeta_atacante, $planeta_defensores, $CurrentTechno, $TargetTechno, false);
			
			//Tabla con las flotas del defensor
			$mes_report .= bodyreport($defender_structure, $planeta_atacante, $planeta_defensores, $CurrentTechno, $TargetTechno, true);
			
		  }	
		
		//echo $mes_report;
		$mtime = microtime();
		$mtime = explode(' ', $mtime);
		$mtime = $mtime[1] + $mtime[0];
		$endtime = $mtime;
		
		$totaltime = round($endtime - $starttime, 5);
		
		$CurrentSet = $attacker_structure;
		$TargetSet = $defender_structure;
		
		if (!is_null($CurrentSet)) {
			foreach ($CurrentSet as $UID => $arrayx) {
				foreach ($arrayx as $ShipId => $quantity) {
					$attacker_end_debris['metal'] += $quantity * $pricelist[$ShipId]['metal'];
					$attacker_end_debris['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
				}
			}
		}
		
		if (!is_null($TargetSet)) {
			foreach ($TargetSet as $UID => $arrayx) {
				foreach ($arrayx as $ShipId => $quantity) {
					if ($ShipId < 300) {
						$defender_end_debris['metal'] += $quantity * $pricelist[$ShipId]['metal'];
						$defender_end_debris['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
					} else {
						$defender_end_debris_defense['metal'] += $quantity * $pricelist[$ShipId]['metal'];
						$defender_end_debris_defense['crystal'] += $quantity * $pricelist[$ShipId]['crystal'];
					}
				}
			}
		}
		
		$debris['metal'] += (($attacker_start_debris['metal'] - $attacker_end_debris['metal']) * ($game_config['Fleet_Cdr'] / 100));
		$debris['crystal'] += (($attacker_start_debris['crystal'] - $attacker_end_debris['crystal']) * ($game_config['Fleet_Cdr'] / 100));

		$debris['metal'] += (($defender_start_debris['metal'] - $defender_end_debris['metal']) * ($game_config['Fleet_Cdr'] / 100));
		$debris['crystal'] += (($defender_start_debris['crystal'] - $defender_end_debris['crystal']) * ($game_config['Fleet_Cdr'] / 100));
		
		$debris['metal'] += (($defender_start_debris_defense['metal'] - $defender_end_debris_defense['metal'])   * ($game_config['Defs_Cdr'] / 100));
		$debris['crystal'] += (($defender_start_debris_defense['crystal'] - $defender_end_debris_defense['crystal']) * ($game_config['Defs_Cdr'] / 100));
		
		$defenseMetal = ($defender_start_debris_defense['metal'] - $defender_end_debris_defense['metal']);
		$defenseCrystal = ($defender_start_debris_defense['crystal'] - $defender_end_debris_defense['crystal']);
		
		$debris['attacker'] = (($attacker_start_debris['metal'] - $attacker_end_debris['metal']) + ($attacker_start_debris['crystal'] - $attacker_end_debris['crystal']));
		$debris['defender'] = (($defender_start_debris['metal'] - $defender_end_debris['metal']) + ($defender_start_debris['crystal'] - $defender_end_debris['crystal']) + ($defenseMetal + $defenseCrystal));
		
		return array('attacker' => $CurrentSet, 'defender' => $TargetSet, 'battle_result' => $battle_result, 'debris' => $debris, 'rounds' => ($totalrounds -1), 'totaltime' => $totaltime, 'report' => $mes_report);
		
	}
	//Lo que tengo que hacer es: modificar el bucle de las 8 rondas para que recalcule el ataque por cada ronda; modificar lo de los mensajes de los kilopondios (el calculo es malo...); modificar algunas cosas del simulador para
	//que ya no utilice el atackpowerleft...
	function PadaAttack($attacker_structure, $defender_structure, $attack_power_left){
		global $CombatCaps;
		
		if(count($attacker_structure) <= 0){
			return array($defender_structure, 0);
		}
		
		foreach ($attacker_structure as $UID => $arrayx) {
			foreach ($arrayx as $ShipId => $Quantity) {
				
				$JustShoot = 5;
				
				if($Quantity >= $JustShoot){
					$OnlyFire = round($Quantity / $JustShoot);
				}else{
					$OnlyFire = $Quantity;
				}
				// ONLY FIRE $JustShoot
				for ($j = 1; $j < $JustShoot; $j++) {
					$fire = true;
					
					// DONT CHECK RAPIDFIRE
					unset($AlreadyRF, $attack_power);
					
					while ($fire == true) {
						$fire = false;
						
						if (count($defender_structure) == 0) {
							$killed = 1;
						}
						
						if ($killed != 1) {
							srand((float) microtime() * 10000000);

							$randUser = @array_rand($defender_structure);
							$randShip = @array_rand($defender_structure[$randUser]);
							
							$selected_user = $randUser;
							$selected_shipid = $randShip;
						}
						
						// CALCULATE THE SHIP ATTACK POWER
						if(!isset($attack_power))
							$attack_power = $OnlyFire * ($CombatCaps[$ShipId]['attack'] + $CombatCaps[$ShipId]['attack'] * (1 + (0.1 * $CurrentTechno[$UID]['military_tech']) + (0.05 * $CurrentTechno[$UID]['rpg_amiral'])));
						
						//if($attack_power > $attack_power_left){
							//$attack_power = $attack_power_left;
						//}
						
						if ($killed != 1) {
							
							$DefenderShipStats = getShipStats($selected_shipid, $TargetTechno);
							
							// SHIP SHIELD POWER
							if(!isset($shield_power_per_unit))
								$shield_power_per_unit = $DefenderShipStats['shield'];  //Shiel es blindaje
							
							if(!isset($defense_power_per_unit))
								$defense_power_per_unit = $DefenderShipStats['defense'];   //Defense es escudos
							
							
							// ATTACK POWER DOSNT DESTROY THE SHIP SHIELD
							if ($attack_power <= $shield_power_per_unit) {  //Modificacion para mayor precision, al añadir = por si acaso...
								
								// DECREASE SHIP SHIELD
								$shield_power_per_unit -= $attack_power;
								
								// DECREASE TOTAL POWER ATTACK
								$attack_power_left -= $attack_power;
								
								$attack_power = 0;
								
							// SHIELD MUST BE DESTROYED
							}if ($attack_power > $shield_power_per_unit) {
								
								$ShipsToDelete = round($attack_power / ($DefenderShipStats['shield'] + $DefenderShipStats['defense'] + 1));
								
								// AVAILABLE DEFENDER SHIPS
								$AvailableShips = $defender_structure[$selected_user][$selected_shipid];
								if($ShipsToDelete > $AvailableShips){
									$ShipsToDelete = $AvailableShips;
								}
								
								// DECREASE ATTACK POWER
								$attack_power -= (($DefenderShipStats['shield'] +  $DefenderShipStats['defense']) * $ShipsToDelete);
															
								// DECREASE TOTAL POWER ATTACK
								$attack_power_left -= (($DefenderShipStats['shield'] +  $DefenderShipStats['defense']) * $ShipsToDelete);
								
								// UPDATE ARRAYS
								$defender_structure = PadaDeleteShip($defender_structure, $selected_user, $selected_shipid, $ShipsToDelete);
								
								// UNSET THE ACTUAL SHIELD AND DEFENSE
								unset($shield_power_per_unit, $defense_power_per_unit);
							}
							
							
							// IF ATTACK POWER LEFT AND HASNT RAPIDFIRE YET
							if($attack_power AND !isset($AlreadyRF)){
								
								$AlreadyRF = true;
								
								$RF = $CombatCaps[$ShipId]['sd'][$selected_shipid];
								if($RF > 1){
									$RF_ = 100 * ($RF - 1) / $RF;

									$percent = mt_rand(1, 100);

									if($percent <= $RF_){
										$fire = true;
									}
								}else{
									$fire = false;
								}
							}					
						}
					}
				}
			}
		}
		
		return array($defender_structure, $attack_power_left);
		
	}

	
function PadaDeleteShip($Arr, $UID, $ShipId, $Quantity){

	$Arr[$UID][$ShipId] -= $Quantity;
	if($Arr[$UID][$ShipId] <= 0) unset($Arr[$UID][$ShipId]);
	if(count($Arr[$UID]) <= 0) unset($Arr[$UID]);
	
	return $Arr;	
}

function getShipStats($ShipId, $TargetTechno){
	global $CombatCaps, $pricelist;
	
	$defense = ((($pricelist[$ShipId]['metal'] + $pricelist[$ShipId]['crystal']) / 10) * (1 + (0.1 * ($TargetTechno['defence_tech']) + (0.05 * $TargetTechno[$UID]['rpg_amiral']))));
	$shield = $CombatCaps[$ShipId]['shield'] * (1 + (0.1 * $TargetTechno[$UID]['shield_tech'])+ (0.05 * $TargetTechno[$UID]['rpg_amiral']));
	
	return array('defense' => $defense, 'shield' => $shield);
}

function CalculateAttack ($structure){
	global $CombatCaps;
	
	foreach ($structure as $UID => $array) {
		foreach ($array as $ShipId => $Quantity) {
		
		$attack_power += $Quantity * ($CombatCaps[$ShipId]['attack'] + $CombatCaps[$ShipId]['attack'] * (1 + (0.1 * $CurrentTechno[$UID]['military_tech']) + (0.05 * $CurrentTechno[$UID]['rpg_amiral'])));
		}
	}
	return $attack_power;
}

function bodyreport($structure, $planeta_atacante, $planeta_defensores, $CurrentTechno, $TargetTechno, $tipo = true){
//Otra superfuncion mia XD
//Structure es la estructura del defensor o del atacante (todas sus naves). $tipo true, se refiere a que la estructura es del defensor; si es false, al atacante. 
//No incluye donde se dice: el atacante dispara he hizo tanto daño...
	
	global $lang;

	$body_report .= "<table border=1 width=100%><tr><th>";
	if(!$structure OR empty($structure)){
		if($tipo){
			$body_report .= $lang['sys_def_destroyed'];
		}else{
			$body_report .= $lang['sys_atac_destroyed'];
		}
		
	}else{
		foreach ($structure as $UID => $arrayx) { 
			if($tipo){
				$body_report .= sprintf($lang['sys_attack_defender_pos'], $planeta_defensores[$UID]['usuario'], $planeta_defensores[$UID]['galaxy'], $planeta_defensores[$UID]['system'], $planeta_defensores[$UID]['planet'] );
				$body_report .= "<br>".sprintf($lang['sys_attack_techologies'], $TargetTechno[$UID]['military_tech']*10, $TargetTechno[$UID]['defence_tech']*10, $TargetTechno[$UID]['shield_tech']*10 );
			}else{
				$body_report .= sprintf($lang['sys_attack_attacker_pos'], $planeta_atacante[$UID]['usuario'], $planeta_atacante[$UID]['galaxy'], $planeta_atacante[$UID]['system'], $planeta_atacante[$UID]['planet'] );
				$body_report .= "<br>".sprintf($lang['sys_attack_techologies'], $CurrentTechno[$UID]['military_tech']*10, $CurrentTechno[$UID]['defence_tech']*10, $CurrentTechno[$UID]['shield_tech']*10 );
			}
			$body_report .= "<center><table border=1>";
			
			$body_report .= "<tr><th>{$lang['sys_ship_type']}</th>";
			foreach ($arrayx as $ShipId => $Quantity) {
				$body_report .= "<th>{$lang['tech_rc'][$ShipId]}</th>";
			}
			$body_report .= "</tr><tr><th>{$lang['sys_ship_count']}</th>";
			foreach ($arrayx as $ShipId => $Quantity) {
				$body_report .= "<th>{$Quantity}</th>";
			}	
			$body_report .= "</tr></table></center>";
		}
	}	
	$body_report .= "</th></tr></table>";
   unset ($lang);
	
	return $body_report;
}

//print_r($result);

?>
