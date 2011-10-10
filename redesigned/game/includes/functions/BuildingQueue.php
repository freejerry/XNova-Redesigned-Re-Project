<?php

//Right another blank php file, let make building queue

/**
First we must consider the data needed
Item -> What item are we building
Mode -> Construct or destruct?
Queue start time, when the first item in the queue was built


Now what functions do we need
AddToQueue(item,mode)
RemoveFromQueue(id = -1)
UpdateQueue()
ShowQueue()
**/


//Add to queue function
function AddToQueue($element,$mode){
	global $planetrow,$resources,$resource;
	
	//We need to get queue into an array
	$q = explode(";",$planetrow['build_queue']);
	if($planetrow['build_queue'] == ''){ $q = array(); }
	
	//Is this the first one in the queue, if so we should charge
	if(sizeof($q) == 0){
		//Get price
		$cost = BuildingCost($element,$planetrow[$resource[$element]] + $mode);
			
		//Can we afford
		$canafford = true;
		foreach($cost as $res => $need){
			if($planetrow[$res] < $need && $res != 'sum'){
				//We don't have enough
				$canafford = false;
			}
		}
			
		//So can we?
		if($canafford){
			//OK, we can afford it, remove the resources
			$remove = array();
			foreach($resources as $res){ $remove[] = "`".$res."` = `".$res."` - '".$cost[$res]."'"; }
			doquery("UPDATE {{table}} SET ".implode(" , ",$remove)." WHERE `id` = '".$planetrow['id']."' LIMIT 1 ;",'planets',false);
			
			//Star the queue from now
			$planetrow['build_queue_start'] = time();
		}else{
			//We can't afford it, end now
			return false;
		}
	}elseif(sizeof($q) >= MAX_BUILDING_QUEUE_SIZE){
		//Queue is full
		return false;
	}
	
	//Add the new item
	$q[] = $element.",".$mode;
	
	//Implode queue back into a string
	$planetrow['build_queue'] = implode(";",$q);
	
	//Update the table and return the result
	return doquery("UPDATE {{table}} SET `build_queue` = '".$planetrow['build_queue']."', `build_queue_start` = '".$planetrow['build_queue_start']."' WHERE `id` = '".$planetrow['id']."' LIMIT 1 ;",'planets',false);
}

//Remove from queue function
function RemoveFromQueue($id = -1){
	global $planetrow,$resources,$resource;
	
	//We need to get queue into an array
	$q = explode(";",$planetrow['build_queue']);
	if($planetrow['build_queue'] == ''){ $q = array(); }
	
	//If we are removing last item
	if($id < 0)
		$id = sizeof($q) - $id;
	
	//if we removed first item we need to charge - and refund the first one.
	if($id == 0){
		//Loop through the queue until we can afford one
		$level = array();
		foreach($q as $nid => $row){
			//Get price
			$cost = BuildingCost($row[0],$planetrow[$resource[$row[0]]] + $level[$row[0]] + $row[1]);
			
			//is this th first item?
			if($nid == 0){
				//Refund
				
				$add = array();
				foreach($resources as $res){ $add[] = "`".$res."` = `".$res."` + '".$cost[$res]."'"; }
				doquery("UPDATE {{table}} SET ".implode(" , ",$add)." WHERE `id` = '".$planetrow['id']."' LIMIT 1 ;",'planets',false);
				
			}else{
				//Charge				
				
				//Can we afford
				$canafford = true;
				foreach($cost as $res => $need){
					if($planetrow[$res] < $need && $res != 'sum'){
						//We don't have enough
						$canafford = false;
					}
				}
				
				//So can we?
				if($canafford){
					
					//OK, we can afford it, remove the resources
					$remove = array();
					foreach($resources as $res){ $remove[] = "`".$res."` = `".$res."` - '".$cost[$res]."'"; }
					doquery("UPDATE {{table}} SET ".implode(" , ",$remove)." WHERE `id` = '".$planetrow['id']."' LIMIT 1 ;",'planets',false);
				
					//Star the queue from now
					$planetrow['build_queue_start'] = time();
					
					//Stop now, break;
					break;
					
				}else{
					//We can't afford it, remove from queue and send a message to the user.
					//Remove from queue
					unset($q[$nid]);
					
					//Actually don't send coz those messages are annoying.
				}
			
			}
		}			
	}
	
	//Check item exists
	if($id >= 0 && $id < sizeof($q)){
		
		//Remove item
		unset($q[$id]);
		
		//Implode queue back into a string
		$planetrow['build_queue'] = implode(";",$q);
		
		//Update the table and return the result
		return doquery("UPDATE {{table}} SET `build_queue` = '".$planetrow['build_queue']."', `build_queue_start` = '".time()."' WHERE `id` = '".$planetrow['id']."' LIMIT 1 ;",'planets',false);
		
	}
}

function UpdateQueue(){
	global $planetrow,$resource,$resources;
	
	//We need to get queue into an array
	$q = explode(";",$planetrow['build_queue']);
	if($planetrow['build_queue'] == ''){ $q = array(); }
	
	//The first item is already paid for
	$chargefor = false;
	
	//Loop through the queue
	foreach($q as $id => $row){
		//Explode the row
		$row = explode(",",$row);
		
		//Are we being charged?
		if($chargefor){
			//How much?
			$cost = BuildingCost($row[0],$planetrow[$resource[$row[0]]] + $row[1]);
			
			//Can we afford that
			$canafford = true;
			foreach($cost as $res => $need){
				if($planetrow[$res] < $need && $res != 'sum'){
					//We don't have enough
					$canafford = false;
				}
			}
			
			//So can we afford it?
			if($canafford){
				
				//OK, we can afford it, remove the resources
				$remove = array();
				foreach($resources as $res){ $remove[] = "`".$res."` = `".$res."` - '".$cost[$res]."'"; }
				doquery("UPDATE {{table}} SET ".implode(" , ",$remove)." WHERE `id` = '".$planetrow['id']."' LIMIT 1 ;",'planets',false);
				
				//How long will it take?
				$willtake = BuildingTime($row[0],$planetrow[$resource[$row[0]]] + $row[1],$planetrow,$user);
		
				//Do we have that time?
				if($planetrow['build_queue_start'] + $willtake > time()){
					//Stop now
					break;
				}else{
					//we have time, build it.
					AddToPlanet($planetrow,$row[0],$row[1]);
		
					//Add that to the time?
					$planetrow['build_queue_start'] += $willtake;
			
					//Remove from the queue
					unset($q[$id]);
			
					//Next one is new so we should charge for it.
					$chargefor = true;
				}
			
			}else{
				//We can't afford it, remove from queue and send a message to the user.
				//Remove from queue
				unset($q[$id]);
				
				//Charge for next one too
				$chargefor = true;
				
				//Actually don't send coz those messages are annoying.
			}
		}else{
			//First tiem already paid for, try and build
			
			//How long will it take?
			$willtake = BuildingTime($row[0],$planetrow[$resource[$row[0]]] + $row[1],$planetrow,$user);

			//Do we have that time?
			if($planetrow['build_queue_start'] + $willtake > time()){
				//Stop now
				$chargefor = false;
				break;
			}else{
				//we have time, build it.
				AddToPlanet($planetrow,$row[0],$row[1]);
				
				//Add that to the time?
				$planetrow['build_queue_start'] += $willtake;
		
				//Remove from the queue
				unset($q[$id]);
		
				//Next one is new so we should charge for it.
				$chargefor = true;
			}
		}
	
	}
	
	//Implode queue back into a string
	$planetrow['build_queue'] = implode(";",$q);
	
	//Update the table and return the result
	return doquery("UPDATE {{table}} SET `build_queue` = '".$planetrow['build_queue']."', `build_queue_start` = '".$planetrow['build_queue_start']."' WHERE `id` = '".$planetrow['id']."' LIMIT 1 ;",'planets',false);
}

function ShowQueue($loadpage = false){
	global $planetrow,$user,$lang,$resource;
	
	//We need to get queue into an array
	$q = explode(";",$planetrow['build_queue']);
	if($planetrow['build_queue'] == ''){ $q = array(); }
	
	//Is there actually a queue?
	if(sizeof($q) > 0){
		
		//Allow create a temporary array to store hypothetical updates
		$updates = array();
		
		//Create the parse array
		$parse = $lang;
		
		//loop through the items
		foreach($q as $n => $row){
			
			//Split the row up
			$row = explode(",",$row);
			
			//Add to $updates
			$updates[$row[0]] += $row[1];
			
			//Get current level
			$level = $planetrow[$resource[$row[0]]] + $updates[$row[0]];
			
			//How should it be coloured?
			if($updates[$row[0]] > 0){
				$colour = 'lime';
			}else{
				$colour = 'red';
			}
			
			//Get name
			$name = $lang['names'][$row[0]];
			
			//Get time
			$time = BuildingTime($row[0],$level,$planetrow,$user);
			
			//If we are gonan reload the whole page there will be differnt remove links
			if($loadpage){
				$parse['remove_link'] = "loadpage('./?page=resources&cmd=remove&listid=".$n."','".$lang['Resources']."','resources')";
			}else{
				$parse['remove_link'] = "getAXAH('./?page=resources&cmd=remove&listid=".$n."&axah_box=1','resources_queue_box')";
			}
				
			if($n == 0){
				$parse['countdown'] = parsecountdown($planetrow['build_queue_start'] + $time);
				$parse['thislevel'] = pretty_number($level);
				$parse['thisname'] = $name;
				$parse['thisid'] = $row[0];
			}else{
				$parse['rest'] .= '
						<td>
							<a href="#"
								class="tips" 
								onclick="'.$parse['remove_link'].'"
								onmouseover="mrtooltip(\'Cancel expansion of '.$name.' to level '.$level.'?\');"
								onmouseout="UnTip();">
								<img class="queuePic" src="'.GAME_SKIN.'/img/tiny/tiny_'.$row[0].'.jpg" height="28" width="28" alt="'.$name.'">
							</a>
							<br>
							<span style="color: '.$colour.';">'.$level.'</span>
						</td>';
			}
		}
		
		return array('buildlist' => parsetemplate(gettemplate('buildings/resources_queue'), $parse), 'length' => sizeof($q));
	}else{
		
		$queueinfo = '';
		if(!$loadpage){
			getLang('overview');
			
			$queueinfo .= '<div class="content-box-s">';
			$queueinfo .= '<div class="header"><h3>Buildings</h3></div>';
			$queueinfo .= '<div class="content">';
			
			$queueinfo .= '<table cellpadding="0" cellspacing="0" class="construction">';
			$queueinfo .= '<tr>';
			$queueinfo .= '<td colspan="2" class="idle">';
			$queueinfo .= $lang['Free_bu'];
			$queueinfo .= '</td>';
			$queueinfo .= '</tr>';
			$queueinfo .= '</table>';
			
			$queueinfo .= '</div>';
			$queueinfo .= '<div class="footer"></div>';
		}
		
		return array('buildlist' => $queueinfo, 'length' => 0);
	}
	
}

?>
