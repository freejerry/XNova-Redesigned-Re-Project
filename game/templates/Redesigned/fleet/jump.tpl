<script type="text/javascript">
/*function set_jump_target(){
	alert('hi');
	if(document.getElementById('slbox').value != '-'){
		var pos = document.getElementById('slbox').value.split(':');
		document.getElementById('fl_galaxy').value = pos[0];
		document.getElementById('fl_system').value = pos[1];
		document.getElementById('fl_planet').value = pos[2];
		document.getElementById('continue').className = 'on';
	}
}*/
</script>

<form name="details" id="details" method="get" action="./?page=jumpgate">

<div id="inhalt">
	<div id="planet" style="background-image:url({{skin}}img/header/fleet/fleet2.jpg)" >
		<h2>{Jumpgate} - {{planet}}</h2> 
	</div>
	<div class="c-left"></div>
	<div class="c-right"></div>	
	{fleetinfo}
	<div id="buttonz" style="height:141px;">
		<table cellpadding="0" cellspacing="0" id="mission">
		<tr>
			<th>Take off location:</th>

			<th></th>
			<th>Destination:</th>			
			<th></th>			
		</tr>
		<tr>			
			<td id="start" style="width:171px;">
				<div class="planet">{{planet}}</div>
				<div class="target">
					<a class="tips moon_selected" title="Start: Moon {{planet}}" style="margin-left:67px;">
						<span class="textlabel">Moon</span>
					</a>
				   	<br class="clearfloat" />
				</div>
				<div class="coords">
					Coordinates:
					<span style="color:#ffffff; font-weight:bold">
						<span id="thisgal">{g}</span>:<span id="thissys">{s}</span>:<span id="thispla">{p}</span>
					</span>
				</div>
			</td>
			<td id="dist" style="width:115px;vertical-align:middle;" valign="middle">
				<br />
				<div id="distance">-</div>
				<div class="coords" style="padding-top:8px;">Jump</div>
			</td>
			<td id="target" style="width:165px">
				<div class="planet" id="targetPlanetName">Target</div>

				<div class="target">
					<input type="hidden" name="planettype" id="planettype" value="{t}" />
					<a class="tips moon_selected" style="margin-left:67px;"></a>
					<br class="clearfloat" />
				</div>
				<div class="coords">Coordinates:<br />
					<input name="galaxy" id="fl_galaxy" type="text" class="galaxy" size="1" maxlength="1" value="-" readonly="true" />
					<input name="system" id="fl_system" type="text" class="system" size="3" maxlength="3" value="-" readonly="true" />
					<input name="planet" id="fl_planet" type="text" class="planet" size="2" maxlength="2" value="-" readonly="true" />
				</div>
			</td>

			<td id="shortcuts" style="width:189px;">
				<div>
					<span id="shortlinks tips">Targets:</span>
					   <select size="1" class="planets" id="slbox" style="margin-top:16px;" onchange="set_jump_target();">
						   <option value="-">-</option>
{jumptos}
					   </select>

				</div>  
				<br />
				<div>
					<a id="continue" class="off" href="#" onClick="
						if(this.className == 'on'){
							//submitform('details',document.title,'fleet3','UpdateFleet3Info()');
							mr_alert('<img height=16 width=16 src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}...','Fleet Sent');
							getAXAH(form2get('sendForm'),'errorBoxNotifyContent');
							loadpage('./?page=fleet1',document.title,'fleet1');
						}" style="margin-left:23px;">
						<span>{fl_continue}</span>
					</a>	
				</div>	
			</td>

		</tr>
		</table>
	</div>
	
	<div style="width:669px;height:15px;background-position:0px -285px;background-image:url('http://localhost/redesigned/skins/xr//img/navigation/box_h300-fleet.gif');"></div>
</div>
</form>
