<br class="clearfloat"/>
<!--<div class="push"></div>-->
</div><!-- contentBoxBody -->
</div>
<div id="siteFooter">
	<div class="content">
		<div class="fleft textLeft">
			<a href="#" onclick="mrbox('./?page=changelog',800)" class="tips" style="position:relative;">BETA<span class="mrtooltip" style="top:-20px;">Patch notes</span></a>
			&copy; 2015 <a class="homeLink" href="https://github.com/freejerry/XNova-Redesigned-Re-Project" target="_blank">XNova Redesigned Re-Project</a>
		</div>
		<div class="fright textRight">
			<a href="./?page=help" target="_blank">{Help}</a>|
			<a href="{forum_url}" target="_blank">{Board}</a>|
			<a href="./?page=rules" target="_blank">{Rules}</a>|
			<a href="./?page=legal" target="_blank">{Imprint}</a>
		</div>
		<br class="clearfloat" />
	</div><!-- -->
</div>

<!-- Fleet dumps (for the back button) -->
<div id="fleet1_store" style="display:none;"></div>
<div id="fleet2_store" style="display:none;"></div>

<!-- Message area -->
<div style="background-image:url(./img/bg.png);position:fixed;top:-1px;left:0px;width:100%;height:101%;display:none;z-index:100;overflow:auto;" id="mrbox" ondblclick="mrbox_close();">
	<div id="mrbox_content" style="margin-left:auto;margin-right:auto;margin-top:50px;width:800px;"></div>
</div>

<div id="chatbox_holder" style="position:fixed; padding-top:2px; top:0px; right:0px; width:275px; height:350px; background-color:#000000; background-image:url('./img/chatbg.jpg'); display:none;">
	<span class="tectBeefy" style="color:#848484;">Intercom</span><br /><br />
	<div id="chatbox" style="padding-left:20px; text-align:left; overflow:auto; height:250px;"></div><br />
	<div style="margin-top:auto; margin-bottom:0px;">
		<input type="text" id="im_reply_message" /><input type="button" onclick="getAXAH('./?page=im&mode=post&message='+document.getElementById('im_reply_message').value+'&to='+document.getElementById('im_reply_to').value,'im_info');document.getElementById('im_reply_message').value='';" value="Send" /><br />
		<span id="im_info"></span><br />
		<a href="#" onclick="getAXAH('./?page=im&mode=close','im_info');" style="text-align:right;">Close</a>
	</div>
</div>

<div id="ajax_data">
<!-- Resources -->
<input type="hidden" id="ajax_metal" value="{metal}" />
<input type="hidden" id="ajax_crystal" value="{crystal}" />
<input type="hidden" id="ajax_deuterium" value="{deuterium}" />

<input type="hidden" id="ajax_energy_max" value="{energy_max}" />
<input type="hidden" id="ajax_energy_used" value="{energy_used}" />

<input type="hidden" id="ajax_matter" value="{matter}" />

<input type="hidden" id="ajax_metal_max" value="{metal_max}" />
<input type="hidden" id="ajax_crystal_max" value="{crystal_max}" />
<input type="hidden" id="ajax_deuterium_max" value="{deuterium_max}" />

<!-- Time -->
<input type="hidden" id="ajax_time" value="{ajax_time}" />

<!-- Menus update? -->
<input type="hidden" id="ajax_menus_update" value="0" />

<!-- Request time -->
<input type="hidden" id="ajax_request_time" value="0" />
</div>

<div id="javascript_data">
<!-- Menus update? -->
<input type="hidden" id="last_menu_update" value="{ajax_time}" />
<input type="hidden" id="current_timestamp" value="{ajax_time}" />
<input type="hidden" id="md5_fleets" value="d41d8cd98f00b204e9800998ecf8427e" />
</div>

<!-- JAVASCRIPT -->

<script type="text/javascript">
var DATEES = new Date();
var update_time = DATEES.getTime();
//MadnessRed Script, resize the planet list depening on windows height
document.getElementById('rechts').style.height = (window.innerHeight-175)+'px';

function FormatTime(time){
	seconds = time % 60;
	time = (time-seconds) / 60;

	minutes = time % 60;
	time = (time-minutes) / 60;

	hours = time % 24;
	time = (time-hours) / 24;

	str = '';
	if(time > 0){ str = str + time + '{d} '; }
	if(time > 0 || hours > 0){ str = str + hours + '{h} '; }
	if(time > 0 || hours > 0 || minutes > 0){ str = str + minutes + '{m} '; }
	if(time > 0 || hours > 0 || minutes > 0 || seconds > 0){ str = str + seconds + '{s} '; }
	
	return str;
}

//madnessRed countdown
function countdown(){
	var countdowns = document.getElementsByName('mrcountdown');
	for (var n = 0; n < countdowns.length; n++){

		var cd = countdowns[n];
		var time = cd.className - document.getElementById('current_timestamp').value;

		formatted = FormatTime(Math.round(time));

		if(formatted == ''){ formatted = '{fin}'; }

		cd.innerHTML = formatted;
	}
}

//Check for incoming fleets and messages
function chatbox_update(){
	if(document.getElementById('chatbox').innerHTML == ''){
		document.getElementById('chatbox_holder').style.display = 'none';
	}else{
		document.getElementById('chatbox_holder').style.display = 'block';
	}
}

//manage ajax
function manage_ajax(){

	//Do we need to update the menus or fleets?
	if(document.getElementById('last_menu_update').value < document.getElementById('ajax_menus_update').value){
		getAXAH('./?page=planetlist&axah=1','rechts');
		document.getElementById('last_menu_update').value = document.getElementById('ajax_time').value;
		getAXAH('./?page=fleetajax','message-wrapper');
	}

}

//resource counter.
var load = new Date();
var metal = 0; var crystal = 0; var deut= 0; var seconds = 0; var metared = 0; var crysred = 0; var deutred = 0;
function update_resources(seconds){	//MadnessRed function

	//Resources
	metal = parseFloat(document.getElementById('ajax_metal').value);
	crystal = parseFloat(document.getElementById('ajax_crystal').value);
	deut = parseFloat(document.getElementById('ajax_deuterium').value);

	//Energy
	energy_max = document.getElementById('ajax_energy_max').value;
	energy_used = document.getElementById('ajax_energy_used').value;
	energy_left = (energy_max * 1.0) + (energy_used * 1.0);

	//Storage
	metal_max = parseFloat(document.getElementById('ajax_metal_max').value);
	crystal_max = parseFloat(document.getElementById('ajax_crystal_max').value);
	deuterium_max = parseFloat(document.getElementById('ajax_deuterium_max').value);

	//Matter
	matter = document.getElementById('ajax_matter').value;

	//By default we are not in the red
	metared = 0;
	crysred = 0;
	deutred = 0;
	engyred = 0;
	engygreen = 0;

	//See if we are in the red though
	if(metal >= metal_max){ metared = 1; }
	if(crystal >= crystal_max){ crysred = 1; }
	if(deut >= deuterium_max){ deutred = 1; }
	if(energy_left <= 0){ engyred = 1; }else{ engygreen = 2; }

	document.getElementById('pretty_metal').innerHTML = pretty_number(Math.round(metal));
	document.getElementById('pretty_crystal').innerHTML = pretty_number(Math.round(crystal));
	document.getElementById('pretty_deut').innerHTML = pretty_number(Math.round(deut));
	document.getElementById('pretty_matter').innerHTML = pretty_number(Math.round(matter));

	document.getElementById('resources_metal').innerHTML = colour_number(KMnumber(Math.round(metal)),metared);
	document.getElementById('resources_crystal').innerHTML = colour_number(KMnumber(Math.round(crystal)),crysred);
	document.getElementById('resources_deuterium').innerHTML = colour_number(KMnumber(Math.round(deut)),deutred);
	document.getElementById('resources_matter').innerHTML = KMnumber(Math.round(matter));

	document.getElementById('resources_energy').innerHTML = colour_number(KMnumber(Math.round(energy_left)),engyred);
	document.getElementById('resources_energy_detil').innerHTML = colour_number(KMnumber(Math.round(energy_left)),engyred);
	document.getElementById('pretty_energy').innerHTML = colour_number(KMnumber(Math.round(energy_max)));	
	document.getElementById('pretty_energy_used').innerHTML = colour_number(KMnumber(Math.round(energy_used)));	

	window.setTimeout('update_resources();',2000);
}

//Update time
function updatetime(){
	update_time = update_time + 1000;
	//alert(update_time);
	document.getElementById('current_timestamp').value = update_time / 1000;
	document.getElementById('datetime').innerHTML = displayDate(update_time);
	countdown();
	t=setTimeout('updatetime()',999);
}
updatetime();

//now start all the live stuff
//variables

//ajax
ajax('./?page=ajax','ajax_data',5000,'manage_ajax()');
ajax('./?page=im','chatbox',3000,'chatbox_update()');

//load fleetajax
getAXAH('./?page=fleetajax','message-wrapper');

//resources and time
update_resources();
</script>

<script type='text/javascript' src='./scripts/trader.js'></script>
<script type='text/javascript' src='./scripts/fleet.js'></script>
<script type='text/javascript' src='./scripts/madnessred.js'></script>

    </body>

</html>

