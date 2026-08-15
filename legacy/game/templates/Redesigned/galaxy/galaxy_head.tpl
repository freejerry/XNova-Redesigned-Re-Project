	<tr id="galaxyheadbg">
		<td colspan="13">
			<div style="position:relative; height:55px; width:647px;">
			<form action="./?page=galaxy&mode=1" name="galaxy_form" id="galaxy_form" method="post">
			<input type="hidden" id="auto" value="dr" />
				<div id="galaxyscroll">
					<span>{Galaxy}</span>
					<div style="margin-top:11px;">
						{agb}
							<img name="image1" src="{{skin}}/img/galaxy/pfeil_links.gif" width="25" height="24" />
						</a>
						<input maxlength="3" type="text" size="1" value="{cur_gal}" name="galaxy" tabindex="2" onKeyPress="return submitOnEnter(this,event);" id="gotogal" />

						{agn}
							<img name="image2" src="{{skin}}/img/galaxy/pfeil_rechts.gif" width="25" height="24" />
						</a>
					<br class="clearfloat" />

					</div>
				</div>
				<div id="solarscroll">
					<span>{Solar_system}</span>
					<div style="margin-top:11px;">
						{asb}
							<img name="image3" src="{{skin}}/img/galaxy/pfeil_links.gif" width="25" height="24" />
						</a>
						<input maxlength="3" type="text" size="3" value="{cur_sys}" tabindex="2" name="system" onKeyPress="return submitOnEnter(this,event);" id="gotosys" />
						{asn}
							<img name="image4" src="{{skin}}/img/galaxy/pfeil_rechts.gif" width="25" height="24" />
						</a>
						<br class="clearfloat" />

					</div>
				</div>
			</form>
			<!--<div id="showbutton" onClick="document.galaxy_form.submit();">-->
			<div id="showbutton" onClick="loadpage('./?page=galaxy&mode=1&galaxy='+document.getElementById('gotogal').value+'&system='+document.getElementById('gotosys').value,document.title,'galaxy');">
				<a href="#">
					<span class="bleft"></span>
					<span class="text">Display</span>
					<span class="bright"></span>
				</a>
			</div>
				<div id="expeditionbutton">
					<a>
						<span class="bleft"></span>
						<span class="text">Expedition</span>
						<span class="bright"></span>
					</a>
				</div>
				<div id="extendedgalaxy"></div>
			</div>
		</td>
	</tr>