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

<!-- CONTENT AREA -->

<div id="inhalt" style="margin-top:-44px;">


<table cellpadding="0" cellspacing="0" id="galaxytable" border="0" style="overflow:visible;">
	{galaxy_head}
</table>
<div id="galaxytablediv" style="padding-left:8px;">
	<div id="galaxyheadbg2" style="font-size:12px; font-weight:700px;">
		<div style="float:left; width:75px; text-align:center; padding-top:6px; width:74px;">Planet</div>
		<div style="float:left; width:160px; text-align:center; padding-top:6px;">Name</div>
		<div style="float:left; width:50px; text-align:center; padding-top:6px;">Moon</div>
		<div style="float:left; width:33px; text-align:center; padding-top:6px;">DF</div>
		<div style="float:left; width:150px; text-align:center; padding-top:6px;">Player (status)</div>

		<div style="float:left; width:110px; text-align:center; padding-top:6px;">Alliance</div>
		<div style="float:left; width:70px; text-align:center; padding-top:6px;">Action</div>
	</div>

	{galaxy_rows}
</div>
	
	<table cellpadding="0" cellspacing="0" id="galaxytable" border="0" style="overflow:visible;">
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
