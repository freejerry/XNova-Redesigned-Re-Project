<form name="details" id="details" method="get" action="./?page=fleet3">
	<input name="type" id="type" type="hidden" value="1" />
	<input name="mission" type="hidden" value="0" />
	<input name="union" type="hidden" value="0" />
	<input type="hidden" name="am210" value="1" />
	<input type="hidden" name="duration" id="duration_raw" value="0" />
	<input type="hidden" name="consumption" id="consumption_raw" value="0" />

<div id="inhalt">
	<div id="planet" style="background-image:url({{skin}}img/header/fleet/fleet2.jpg)" >
		<h2>Fleet dispatch II - {{planet}}</h2> 
	</div>
	<div class="c-left"></div>
	<div class="c-right"></div>	
	{fleetinfo}
	<div id="buttonz">
		<table cellpadding="0" cellspacing="0" id="mission">
		<tr>
			<th>Take off location:</th>

			<th></th>
			<th>Destination:</th>			
			<th></th>			
		</tr>
		<tr>
			<td id="start" style="width:171px;">
				<div class="planet">{PlanetName}</div>
				<div class="target">
					<a class="tips planet{origin1}" 
						href="#" 
						title="|Start: {Planet}" 
						style="cursor:default">
							<span class="textlabel">{Planet}</span>
					</a>
					<a class="tips moon{origin3}" 
						href="#" 
						title="|Start: {Moon}" 
						style="cursor:default;">
							<span class="textlabel">{Moon}</span>
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
				<div id="distance">5</div>
				<input type="hidden" name="distance_raw" id="distance_raw" value="5" />
				<div class="coords" style="padding-top:8px;">Distance</div>
			</td>
			<td id="target" style="width:165px">
				<div class="planet" id="targetPlanetName">Homeworld</div>

				<div class="target">
					<input type="hidden" name="planettype" id="planettype" value="1" />
				  	<a class="tips planet_selected" 
						href="#" 
						onClick="document.getElementById('planettype').value=1;
						document.getElementById('pbutton').className='tips planet_selected';
						document.getElementById('mbutton').className='tips moon';
						document.getElementById('dbutton').className='tips debris';
						return false;" 
						title="Target: Planet Homeworld" 
						id="pbutton">
							<span class="textlabel">{Planet}</span>
					</a>
					<a class="tips moon" 
						href="#" 
						onClick="document.getElementById('planettype').value=3;
						document.getElementById('pbutton').className='tips planet';
						document.getElementById('mbutton').className='tips moon_selected';
						document.getElementById('dbutton').className='tips debris';
						return false;" 
						title="Target: moon Homeworld" 
						id="mbutton">
							<span class="textlabel">{Moon}</span>
					</a>
					<a class="tips debris" 
						href="#" 
						onClick="document.getElementById('planettype').value=2;
						document.getElementById('pbutton').className='tips planet';
						document.getElementById('mbutton').className='tips moon';
						document.getElementById('dbutton').className='tips debris_selected';
						return false;" 
						title="Target: Debris field at Homeworld" 
						id="dbutton">

							<span class="textlabel">{DF}</span>
					</a>
					<br class="clearfloat" />
				</div>
				<div class="coords">Coordinates:<br />
					<input name="galaxy" id="fl_galaxy" type="text" class="galaxy" size="1" maxlength="1" value="{g}" />
					<input name="system" id="fl_system" type="text" class="system" size="3" maxlength="3" value="{s}" />
					<input name="planet" id="fl_planet" type="text" class="planet" size="2" maxlength="2" value="{p}" />
				</div>
			</td>

			<td id="shortcuts" style="width:189px;">
				<div>
					<span id="shortlinks tips">Shortcuts:</span>
					   <select size="1" class="planets" id="slbox" onChange="" style="margin-top:16px;">
						   <option value="-">-</option>
					   </select>

				 </div>
		 		<div style="padding-top:12px;">
					<span id="combatunits tips">Combat forces:</span>
						<select size="1" class="combatunits" id="aksbox" onChange="">
							<option value="-">-</option>
					   </select>
				 </div>				  
			</td>

		</tr>
		</table>
		<div style="padding-top:2px;">
		  <h3>Briefing</h3>
		  	<ul style="margin:12px 0px 12px 75px;">
				<li>Speed: (<span class="value">max. <span id="maxspeed">{p_maxspeed}</span></span>):
				<input type="hidden" id="maxspeed_raw" value="{maxspeed}" />
				<select class="speed" id="speed" name="speed">

				<option selected value="10">100</option>
				<option value="9">90</option>
				<option value="8">80</option>
				<option value="7">70</option>
				<option value="6">60</option>
				<option value="5">50</option>

				<option value="4">40</option>
				<option value="3">30</option>
				<option value="2">20</option>
				<option value="1">10</option>
			   </select>%</li>
			   <li>Duration of flight (one way): <span class="value" id="duration">-</span></li>

			   <li>Deuterium consumption: <span class="value"><span id="consumption">-</span> Deuterium</span></li>
			</ul>
			<ul style="margin:12px 0px 12px 70px;">
				<li>Arrival: <span class="value"><span id="arrivalTime">-</span></span></li>
				<li>Return: <span class="value"><span id="returnTime">-</span></span></li>

				<li>Empty cargobays: <span class="value" id="storage">-</span></li>
			 </ul>
			 <br class="clearfloat" />
			<div id="steps">
				<a id="back" href="#" onClick="document.getElementById('axah').innerHTML = document.getElementById('fleet1_store').innerHTML; document.body.id = 'fleet1';">
					<span style="font-size:12px; text-transform:uppercase;">Back</span>
				</a>
				<a id="continue" class="on" href="#" onClick="document.getElementById('fleet2_store').innerHTML = document.getElementById('axah').innerHTML; submitform('details',document.title,'fleet3','UpdateFleet3Info()')">
					<span>{fl_continue}</span>
				</a>
				<br class="clearfloat" />
			</div>
		</div>
	</div>   
</div>
</form>

<script type="text/javascript">
	UpdateFleet2Info();
	alert("hi");
</script>
