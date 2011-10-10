<!-- CONTENT AREA -->


<div id="inhalt">
	<div id="planet" class="">
		<h2>{Empire}</h2>
	</div>
	<div class="c-left"></div>
	<div class="c-right"></div>
	<div id="wrapper">

	<div id="planets_select" style="display:none;">
		<ul style="cursor:pointer;">
{planet_menu}
		</ul>
	</div>
	<div id="moons_select" style="display:none;">
		<ul style="cursor:pointer;">
{moon_menu}
		</ul>
	</div>
	
		<div id="planet_1" style="display: block;">
			<!--<div id="tabs">
				<ul id="switch" class="tabEmpire{tabempire}">
					<li style="margin-left:25px;">
						<select name="p" id="startfrom" onChange="loadpage('./?page=empire&type={type}&p='+document.getElementById('startfrom').value+'&axah=1','{Empire}','empire'); return false;" class="textInput w150">
{pages}
						</select>
					</li>
					<li style="width:75px;">
						<a href="./?page=empire&p=1&type={type}" onclick="loadpage(this.href,'{Empire}','empire');return false;" class="tips">
							<img src="{{skin}}/img/layout/pixel.gif" height="25" width="35" />
						</a>
					</li>
					<li style="width:50px;">
						<a href="./?page=empire&p=2&type={type}" onclick="loadpage(this.href,'{Empire}','empire');return false;" class="tips">
							<img src="{{skin}}/img/layout/pixel.gif" height="25" width="35" />
						</a>
					</li>
					<li style="width:50px;">
						<a href="./?page=empire&p=3&type={type}" onclick="loadpage(this.href,'{Empire}','empire');return false;" class="tips">
							<img src="{{skin}}/img/layout/pixel.gif" height="25" width="35" />
						</a>
					</li>
					<li style="width:50px;">
						<a href="./?page=empire&p=all&type={type}" onclick="loadpage(this.href,'{Empire}','empire');return false;" class="tips" title="|Show all">
							<img src="{{skin}}/img/layout/pixel.gif" width="35" height="25" />
						</a>
					</li>
				</ul>
			</div>-->

			<div class="content" id="content1">
				<table id="planets" cellpadding="0" cellspacing="0" border="0" style="width:667px;">
					<tr class="alt">
						<td style="width:188px;">
							<div id="tab-left">
								<a id="planetsTab"
									onclick="loadpage(this.href,'{Empire}','empire'); return false;"
									href="./?page=empire&type=1" 
									{clase_pl1} 
									onmouseover="TagToTip('planets_select', TITLEPADDING,5,FOLLOWMOUSE,false,FONTCOLOR,'#FFFFFF',BGCOLOR,'#1B1D1F',BORDERCOLOR,'#313131',PADDING,5,WIDTH,150,FADEIN,500,FADEOUT,500,STICKY,true,FIX, ['planetsTab', 98, -74]);"
									>
								</a>
								<a id="moonsTab"
									onclick="loadpage(this.href,'{Empire}','empire'); return false;"
									href="./?page=empire&type=3" 
									{clase_pl2} 
									onmouseover="TagToTip('moons_select', TITLEPADDING,5,FOLLOWMOUSE,false,FONTCOLOR,'#FFFFFF',BGCOLOR,'#1B1D1F',BORDERCOLOR,'#313131',PADDING,5,WIDTH,150,FADEIN,500,FADEOUT,500,STICKY,true,FIX, ['moonsTab', 98, -74]);"
									>
								</a>
							</div>
						</td>

						{planets}

					</tr>

{row_resources}
{row_supply}
{row_station}
{row_research}
{row_shipyard}
{row_defense}

				</table>
			</div>
		</div>

	</div>
</div>
<!-- END CONTENT AREA -->
