// -- general --


// -- fleet1 --
function maxShip(id) {
	if (document.getElementsByName(id)[0]) {
		document.getElementsByName(id)[0].value = document.getElementsByName("max" + id)[0].value;
	}
}

function maxShips() {
	var id;
	for (i = 200; i < 220; i++) {
		id = "ship"+i;
		maxShip(id);
	}
}


function noShip(id) {
	if (document.getElementsByName(id)[0]) {
		document.getElementsByName(id)[0].value = 0;
	}
}


function noShips (){
	var id;
	for (i = 200; i < 220; i++) {
		id = "ship"+i;
		noShip(id);
	}
}


// -- fleet2 --
function UpdateFleet2Info(){
	//Check we are on right page
	if(document.body.id == 'fleet2'){
		
		//Current timestamp
		now = document.getElementById('current_timestamp').value;
	
	
		//Where are we?
		thisGalaxy = document.getElementById("thisgal").innerHTML;
		thisSystem = document.getElementById("thissys").innerHTML;
		thisPlanet = document.getElementById("thispla").innerHTML;

		targetGalaxy = document.getElementById("fl_galaxy").value;
		targetSystem = document.getElementById("fl_system").value;
		targetPlanet = document.getElementById("fl_planet").value;

	
		//Work out distance
		if ((targetGalaxy - thisGalaxy) != 0) {
			dist = Math.abs(targetGalaxy - thisGalaxy) * 20000;
		} else if ((targetSystem - thisSystem) != 0) {
			dist = Math.abs(targetSystem - thisSystem) * 95 + 2700;
		} else if ((targetPlanet - thisPlanet) != 0) {
			dist = Math.abs(targetPlanet - thisPlanet) * 5 + 1000;
		} else {
			dist = 5;
		}

		document.getElementById('distance_raw').value = dist;
		document.getElementById('distance').innerHTML = pretty_number(dist);
		
	
		//Now time
		factor = document.getElementsByName("speed")[0].value * 10;
		maxspeed = document.getElementById("maxspeed_raw").value;
	
		//How long	
		time = 10 + Math.round(35000 / factor * Math.sqrt((dist * 1000) / maxspeed));
		document.getElementById('duration_raw').value = time;
		document.getElementById('duration').innerHTML = FormatTime(time);
	
		//Arrival / return time
		document.getElementById('arrivalTime').innerHTML = date('D M j H:i:s',document.getElementById('current_timestamp').value - (time * -1));
		document.getElementById('returnTime').innerHTML = date('D M j H:i:s',document.getElementById('current_timestamp').value - (time * -2));
		
	
		//Fuel costs over didstance
		fuel = document.getElementById('fleet_fuel').value;
		fuel_used = 1 + Math.round(fuel * ((dist / 1000) / 35) * (factor / 100 + 1) * (factor / 100 + 1));
		document.getElementById('consumption_raw').value = fuel_used;
		document.getElementById('consumption').innerHTML = pretty_number(fuel_used);
	
		//Cargo space
		space = document.getElementById('fleet_cargo').value - fuel_used;
		document.getElementById('storage').innerHTML = pretty_number(space);
	
		t = setTimeout('UpdateFleet2Info()',500);
	}
}


// -- jumpgate
function set_jump_target(){
	if(document.getElementById('slbox').value != '-'){
		var pos = document.getElementById('slbox').value.split(':');
		document.getElementById('fl_galaxy').value = pos[0];
		document.getElementById('fl_system').value = pos[1];
		document.getElementById('fl_planet').value = pos[2];
		document.getElementById('continue').className = 'on';
	}
}


// -- fleet3 --
function UpdateFleet3Info(){
	//Check we are on right page
	if(document.body.id == 'fleet3'){

		//Current timestamp
		now = document.getElementById('current_timestamp').value;
	
		//Duration
		time = document.getElementById('duration_raw').value;
		document.getElementById('duration').innerHTML = FormatTime(time);
	
		//Arrival / return time
		document.getElementById('arrivalTime').innerHTML = date('D M j H:i:s',document.getElementById('current_timestamp').value - (time * -1));
		document.getElementById('returnTime').innerHTML = date('D M j H:i:s',document.getElementById('current_timestamp').value - (time * -2));
	
	
		t = setTimeout('UpdateFleet3Info()',500);
	}
}

function updateres(){
	 document.getElementById('res_total_raw').value = document.getElementById('resource1').value - -document.getElementById('resource2').value - -document.getElementById('resource3').value
	 document.getElementById('res_total').innerHTML = pretty_number(document.getElementById('res_total_raw').value)
	 document.getElementById('thebar').style.backgroundPosition = Math.round((document.getElementById('res_total_raw').value / document.getElementById('maxresources_raw').value) * 180) - 180 + 'px 0px'
	 style="background-position:-180px"
}

function checkres(r){
	//Check for negative values
	if(parseFloat(document.getElementById('resource'+r).value) < 0){ document.getElementById('resource'+r).value = 0; }
	
	//Check that we are not exceedting storage limit
	if(parseFloat(document.getElementById('res_total_raw').value) > parseFloat(document.getElementById('maxresources_raw').value)){
		change = parseFloat(document.getElementById('res_total_raw').value) - parseFloat(document.getElementById('maxresources_raw').value);
		document.getElementById('resource'+r).value = parseFloat(document.getElementById('resource'+r).value) - change;
		if(parseFloat(document.getElementById('resource'+r).value) < 0){ document.getElementById('resource'+r).value = 0; }
		updateres();
	}
	
	//Check we have those resources
	res = ''
	switch(r){
		case 1:
			res = 'metal';
			break;
		case 2:
			res = 'crystal';
			break;
		case 3:
			res = 'deuterium';
			break;
	}
	
	if(parseFloat(document.getElementById('resource'+r).value) > parseFloat(document.getElementById('ajax_'+res).value)){
		document.getElementById('resource'+r).value = Math.floor(document.getElementById('ajax_'+res).value);
		updateres();
	}
}

function maxres(r){
	res = ''
	switch(r){
		case 1:
			res = 'metal';
			break;
		case 2:
			res = 'crystal';
			break;
		case 3:
			res = 'deuterium';
			break;
	}
		
	document.getElementById('resource'+r).value = Math.floor(document.getElementById('ajax_'+res).value);
	checkres(r);
	updateres();
}


// -- fleet movement --
function UpdateFleetMInfo(){
	if(document.body.id == 'movement'){
		//alert(date('U'));
		rows = document.getElementsByName('fleetm_fleetrow');
		for(var n = 0; n < rows.length; n++){
			fleet_id = rows[n].id.substring(5);
			start = document.getElementById('start'+fleet_id).value;
			
			dur = document.getElementById('end'+fleet_id).value - start;
			pos = document.getElementById('current_timestamp').value - start;
			pc = pos / dur;
			
			if(pc > 1){
				pc = 1;
				loadpage(document.getElementById('cur_page').value,document.title,document.body.id);
			}
			if(parseFloat(document.getElementById('dir'+fleet_id).value) > 0){
				pc = 1 - pc;
			}
			
			margin = Math.round(pc * 273);
			//alert(fleet_id+','+dur+','+pos+','+pc+','+margin);
			document.getElementById('route_'+fleet_id).style.marginLeft = margin + 'px';
		}
		t = setTimeout('UpdateFleetMInfo()',500);
	}
}
