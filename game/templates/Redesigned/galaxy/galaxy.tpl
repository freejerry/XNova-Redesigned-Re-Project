{galaxy_scripts}

<script language="JavaScript">
function galaxy_submit(value) {
	document.getElementById('auto').name = value;
	document.getElementById('galaxy_form').submit();
}

function fenster(target_url,win_name) {
	var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=640,height=480,top=0,left=0');
	new_win.focus();
}

document.onkeydown=function(e){
	var Galaxy = document.getElementById('cgal').value;
	var System = document.getElementById('csys').value;
	switch(e.which){
		case 37:
		// Key left.
		//galaxy_submit('systemLeft');
		loadpage('./?page=galaxy&mode=1&galaxy='+Galaxy+'&system='+(System - 1),document.title,'galaxy');
		break;
		case 38:
		// Key up.
		//galaxy_submit('galaxyLeft');
		loadpage('./?page=galaxy&mode=1&galaxy='+(Galaxy - 1)+'&system='+System,document.title,'galaxy');
		break;
		case 39:
		// Key right.
		//galaxy_submit('systemRight');
		loadpage('./?page=galaxy&mode=1&galaxy='+Galaxy+'&system='+((System * 1) + 1),document.title,'galaxy');
		break;
		case 40:
		// Key down.
		//galaxy_submit('galaxyRight');
		loadpage('./?page=galaxy&mode=1&galaxy='+((Galaxy * 1) + 1)+'&system='+System,document.title,'galaxy');
		break;
	}
}


</script>
<script type='text/javascript' src='../scripts/wz_tooltip.js'></script>


<!-- CONTENT AREA -->

<div id="inhalt" style="margin-top:-44px;">
<div id="rocketWrapper" style="display:none">
		<div id="rocketattack">
		<a class="close_details" onclick="tb_remove(); return false;" href="#">
				<img src="img/layout/pixel.gif" width="16" height="16"/>

		</a>
		<form method="post" name="rocketattack" action="./?page=galaxy&fireRocket=1">
			<input type="hidden" name="galaxy" id="cgal" value="{cgal}">
			<input type="hidden" name="system" id="csys" value="{csys}">
			<input type="hidden" name="position" value="">
			<input type="hidden" name="planetType" value="">
			<div id="grid">
			 <span id="target">Target: <span id="name"></span> <span id="position"></span></span>

			 <span id="infos">
				<span id="numberrockets">
					Number of missiles <span id="number">( available)</span>:
					<input type="text" name="anz" id="anz" onFocus="checkOk('anz',0)" onKeyUp="checkOk('anz',0)" class="textinput textBeefy textCenter" />
				</span>
				<span id="pziel">
					primary target:
					<select size="1" name="pziel" style="padding-right:0px;">
						<option value="0">all</option>

						<option value="401">Rocket Launcher</option>
						<option value="402">Light Laser</option>
						<option value="403">Heavy Laser</option>
						<option value="404">Gauss Cannon</option>
						<option value="405">Ion Cannon</option>
						<option value="406">Plasma Turret</option>

						<option value="407">Small Shield Dome</option>
						<option value="408">Large Shield Dome</option>
					</select>
				</span>
				<input value="Fire" id="fire" type="submit" />
			</span>
		</div>
		<br class="clearfloat" />

		</form>
	</div>
</div>

	<table cellpadding="0" cellspacing="0" id="galaxytable" border="0" style="overflow:visible;">

	{galaxy_head}

	<tr id="galaxyheadbg2">
		<th colspan="3" style="text-align:center; width:74px; overflow:hidden;">Planet</th>
		<th>Name</th>
		<th colspan="2" style="text-align:left;">moon</th>
		<th>DF</th>
		<th>Player (status)</th>

		<th colspan="2">Alliance</th>
		<th></th>
		<th>Action</th>
		<th></th>
	</tr>

	{galaxy_rows}

	<tr class="footer" style="display:none" id="fleetstatusrow">

		<td colspan="13">
		<table style="font-weight: bold;" width=100% id="fleetstatustable">
		<!-- will be filled with content later on while processing ajax replys -->
		</table>
			<br class="clearfloat" />
		</td>
	</tr>
	<tr class="footer">
		<td colspan="13">

			<span id="colonized" style="float:left;">0 Planets colonized</span>
			<span id="legend" style="float:right; padding:6px 6px 0px">
				<a href="#" onmouseover="Tip('<div id=\'TTWrapper\'>\n\t\t<div id=\'tooltipBody\' class=\'tooltipBody\'>\t\n\t\t\t<span class=\'tooltip_sticky\'>\n\t\t\t\t<div class=\'TTInner\' id=\'TTAlly\'>\n\t\t\t\t\t<table cellpadding=\'0\' cellspacing=\'0\' class=\'legende\' width=\'100\'>\n\t\t\t\t\t<tr><th colspan=\'2\'><span class=\'spacing\'>Legend</span></th></tr>\n\t\t\t\t\t<tr class=\'body\'><td class=\'description\'>Stronger Player</td><td><span class=\'abbreviation status_abbr_strong\'>s</span></td></tr>\n\t\t\t\t\t<tr class=\'body\'><td class=\'description\'>Weaker Player (newbie)</td><td><span class=\'abbreviation status_abbr_noob\'>n</span></td></tr>\n\t\t\t\t\t<tr class=\'body\'><td class=\'description\'>Vacation Mode</td><td><span class=\'abbreviation status_abbr_vacation\'>v</span></td></tr>\n\t\t\t\t\t<tr class=\'body\'><td class=\'description\'>Banned</td><td><span class=\'abbreviation status_abbr_banned\'>b</span></td></tr>\n\t\t\t\t\t<tr class=\'body\'><td class=\'description\'>7 days inactive</td><td><span class=\'abbreviation status_abbr_inactive\'>i</td>\n\t\t\t\t\t<tr class=\'body\'><td class=\'description\'>28 days inactive</td><td><span class=\'abbreviation status_abbr_longinactive\'>I</span></td></tr>\n\t\t\t\t\t<tr class=\'footer\' style=\'background:url({{skin}}/img/tooltip/ttfooter.gif) no-repeat top center;height:11px;width:250px !important;\'><td></span></td></tr>\n\t\t\t\t\t</table>\t\t\n\t\t\t\t</div>\n\t\t\t</span>\n\t\t</div>\n\t</div>\n</div>',BGCOLOR,'',FONTCOLOR,'#FFFFFF',BORDERWIDTH,0,FOLLOWMOUSE,false,STICKY,true,DURATION,5000)" onmouseout="UnTip()">
					<img src="{{skin}}/img/icons/info.gif" />
					<!--<span class="mrtooltip" style="background-color:transparent;border:0px;top:400px;left:525px;padding:0px;">
						<div id="TTWrapper">
								<div id="tooltipBody" class="tooltipBody">
									<span class='tooltip_sticky'>
										<div class="TTInner" id="TTAlly">
											<table cellpadding="0" cellspacing="0" class="legende" width="100">
											<tr><th colspan="2"><span class="spacing">Legend</span></th></tr>
											<tr class="body"><td class="description">Stronger Player</td><td><span class="abbreviation status_abbr_strong">s</span></td></tr>
											<tr class="body"><td class="description">Weaker Player (newbie)</td><td><span class="abbreviation status_abbr_noob">n</span></td></tr>
											<tr class="body"><td class="description">Vacation Mode</td><td><span class="abbreviation status_abbr_vacation">v</span></td></tr>
											<tr class="body"><td class="description">Banned</td><td><span class="abbreviation status_abbr_banned">b</span></td></tr>
											<tr class="body"><td class="description">7 days inactive</td><td><span class="abbreviation status_abbr_inactive">i</td>
											<tr class="body"><td class="description">28 days inactive</td><td><span class="abbreviation status_abbr_longinactive">I</span></td></tr>
											<tr class="footer" style="background:url('{{skin}}/img/tooltip/ttfooter.gif') no-repeat top center;height:11px;width:250px !important;"><td></span></td></tr>
											</table>
										</div>
									</span>
								</div>
							</div>
						</div>
					</span>-->
			   </a>
			</span>
			<br class="clearfloat" />
		</td>
	</tr>
	<tr class="footer">
		<td colspan="13">

			<span id="probes" class="tips" title="|Espionage probes: 0">
				<span id="probeValue">{res210}</span> Spy probes
			</span>
			<span id="recycler" class="tips" title="|Available recyclers: 0">
				<span id="recyclerValue">{res209}</span> Recycler
			</span>
			<span id="rockets" class="tips" title="|Available interplanetary missiles: 0">
				<span id="missileValue">{res503}</span> Interplanetary missiles
			</span>

			<span id="slots" class="tips" title="|Fleet slots in use: 0 of 1">
				<span id="slotValue">{curfleets}</span>/1 used slots
			</span>
		</td>
	</tr>
<!--	<tr><td colspan="9"><img src="css/iepngfix/opacity.png" /></td></tr>-->
	</table>
</div><!-- END CONTENT AREA -->