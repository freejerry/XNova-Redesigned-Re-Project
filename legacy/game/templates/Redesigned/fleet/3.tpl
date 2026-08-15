<div id="inhalt">
	<div id="planet" style="background-image:url({{skin}}/img/header/fleet/fleet3.jpg)">
		<h2>Fleet dispatch III - {{planet}}</h2> 
	</div>	<div class="c-left"></div>
	<div class="c-right"></div>	
	<div id="buttonz" style="padding-top:1px;">
   		<h3>Select mission for target:</h3>

		<ul id="missions">
			{missions}
		</ul>
		<div id="missionNameWrapper">
			Mission: <span id="missionName">-</span>
		</div>	   
	</div>
	<div id="sendfleet">

		<form name="sendForm" id="sendForm" method="get" action="./?page=fleet4">
		{hidden_data}
		<input type="hidden" name="duration" id="duration_raw" value="{duration}" />
		<input type="hidden" name="mission" id="mission" />
		<div id="wrap">
			<div id="roundup">
				<h3>Briefing</h3>
				<ul>
					<li>Target: <span class="value">{target}</span></li>
					<li id="aks" style="display: none;">Anflugdauer (Verband): <span class="value"><span id="durationAKS">00:00:00</span> h</span></li>
					<li>
						Duration of flight (one way): <span class="value" id="duration">{pduration}</span>
						<input type="hidden" id="duration_raw" value="{duration}" />
					</li>
					<li>Arrival: <span class="value"><span id="arrivalTime">-</span></span></li>
					<li>Return: <span class="value"><span id="returnTime">-</span></span></li>
					<li id="holdtimeline" style="display:none">Hold time: 
						<select name="holdingtime" onChange="updateHoldingOrExpTime();updateVariables();" onKeyUp="updateHoldingOrExpTime();updateVariables();">
							<option value="0" selected>0</option>
							<option value="1" >1</option>
							<option value="2" >2</option>
							<option value="4" >4</option>
							<option value="8" >8</option>
							<option value="16" >16</option>
							<option value="32" >32</option>
						</select>
					</li>
					<li id="expeditiontimeline" style="display:none">Duration of expedition: 
						<select name="expeditiontime" onChange="updateHoldingOrExpTime();updateVariables();" onKeyUp="updateHoldingOrExpTime();updateVariables();">
						</select>
					</li>
					<li>Deuterium consumption: <span class="value"><span id="consumption">{consumption}</span> Deuterium</span></li>

				 </ul>
			</div>
			<!--
			<input name="galaxy" type="hidden" value="1" />
			<input name="system" type="hidden" value="98" />
			<input name="position" type="hidden" value="13" />
			<input name="type" type="hidden" value="1" />
			<input name="mission" type="hidden" value="4" />
			<input name="union2" type="hidden" value="0" />
			<input name="holdingOrExpTime" id="holdingOrExpTime" type="hidden" value="0" />
			<input name="speed" type="hidden" value="10" />
			<input type="hidden" name="am210" value="1" />
			-->
{hidden_data}
			<div id="resources" style="position:relative;">
				<h3>Load resources</h3>
				<div class="res" style="margin-top:15px;">
					<table cellpadding="0" cellspacing="0" border="0" width="133">
					<tr>
						<td rowspan="2" width="48"><img alt="Metal" title="Metal" src="{{skin}}/img/navigation/ressourcen_metall.gif"/></td>

						<td width="80" height="20" valign="top">
							<input type="text" name="resource1" id="resource1" tabindex="1"" value="0" onChange="updateres();checkres('1');" />
						</td>
					</tr>
					<tr>
						<td>
						<a class="min" href="#" onclick="document.getElementById('resource1').value=0; return false;">
							<img src="{{skin}}/img/navigation/icon-min-small.gif" />
							<span class="mrtooltip">Don`t fill up with metal</span>
						</a>
						<a class="max" href="#" onclick="maxres(1); return false;">
							<img src="{{skin}}/img/navigation/icon-max-small.gif" />
							<span class="mrtooltip">Fill up with metal</span>
						</a>
						</td>

					</tr>
					</table>
				</div>
				<div class="res">
					<table cellpadding="0" cellspacing="0" border="0" width="133">
					<tr>
						<td rowspan="2" width="48"><img alt="Crystal" title="Crystal" src="{{skin}}/img/navigation/ressourcen_kristal.gif"/></td>

						<td width="80" height="20" valign="top">
							<input type="text" name="resource2" id="resource2" tabindex="2" id="resource2" value="0" onChange="updateres();checkres('2');" />
						</td>
					</tr>
					<tr>
						<td>
						<a class="min" href="#" onclick="document.getElementById('resource2').value=0; return false;">
							<img src="{{skin}}/img/navigation/icon-min-small.gif" />
							<span class="mrtooltip">Don`t fill up with crystal</span>
						</a>
						<a class="max" href="#" onclick="maxres(2); return false;">
							<img src="{{skin}}/img/navigation/icon-max-small.gif" />
							<span class="mrtooltip">Fill up with crystal</span>
						</a>
						</td>

					</tr>
					</table>
				</div>
				<div class="res">
					<table cellpadding="0" cellspacing="0" border="0" width="133">
					<tr>
						<td rowspan="2" width="48"><img alt="Deuterium" title="Deuterium" src="{{skin}}/img/navigation/ressourcen_deuterium.gif"/></td>

						<td width="80" height="20" valign="top">
							<input type="text" name="resource3" id="resource3" tabindex="3" id="resource3" value="0" onChange="updateres();checkres('3');" />
						</td>
					</tr>
					<tr>
						<td>
						<a class="min" href="#" onclick="document.getElementById('resource3').value=0; return false;">
							<img src="{{skin}}/img/navigation/icon-min-small.gif" />
							<span class="mrtooltip">Don`t fill up with deuterium</span>
						</a>
						<a class="max" href="#" onclick="maxres(3); return false;">
							<img src="{{skin}}/img/navigation/icon-max-small.gif" />
							<span class="mrtooltip">Fill up with deuterium</span>
						</a>
						</td>

					</tr>
					</table>
				</div>
				<div style="text-align:center; position:absolute;top:30px; left:195px;font-size:11px;" 
					class="tips" title="|Load all resources">
					<a href="#" onclick="maxres(1); maxres(2); maxres(3); return false;" id="allresources">
						<img src="{{skin}}img/layout/pixel.gif" width="32" height="32" />
					</a>
					all resources
				</div>
				<div style="left:165px;position:absolute;top:105px; text-align:center; color:#fff; font-size:11px;">
				cargo bay: 
					<div id="capbg">
						<div id="thebar" style="background-position:-180px"></div>
					</div>

					<div class="tips" title="|Used cargo space / max. cargo space">
					<span id="remainingresources">
						<span class="undermark" id="res_total">0</span>
					</span> / <span id="maxresources">{bays}</span>
					</div>
				</div>
				<input type="hidden" id="maxresources_raw" value="{space}" />
				<input type="hidden" id="res_total_raw" value="0" />
			</div><!--#resources -->

		</div><!--#wrap -->			
		</form>
		<br class="clearfloat" />
		<div style="padding:4px 35px 0px;">
			<a onclick="document.getElementById('axah').innerHTML = document.getElementById('fleet2_store').innerHTML; document.body.id = 'fleet2'; UpdateFleet2Info();" href="#" id="back" style="float:left; margin:auto; margin:8px 0px 0px 87px;">
				<span style="font-size:12px; text-transform:uppercase;"><< Back</span>
			</a>
			<a id="start" class="off" href="#" style="margin:0px; float:right;" onclick="mr_alert('<img height=16 width=16 src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}...','Fleet Sent'); getAXAH(form2get('sendForm'),'errorBoxNotifyContent'); //loadpage('./?page=fleet1',document.title,'fleet1');">
				<span style="padding-top:18px;">Send fleet</span>
			</a>
			<br class="clearfloat" />		
		</div>		
	</div><!-- #sendfleet -->		
</div>
