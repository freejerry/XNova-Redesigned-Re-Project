<!-- LEFTMENU -->

<div id="links">

	<ul id="menuTable">

		<li class="menubutton_table">
			<span class="menu_icon">
				<img 
        onmouseover="this.src='{{skin}}/img/navigation/navi_ikon_overview_c.gif';"
				onmouseout="this.src='{{skin}}/img/navigation/navi_ikon_overview_{let_overview}.gif';"
        href="./?page=overview" title="{Overview}" src="{{skin}}/img/navigation/navi_ikon_overview_{let_overview}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" href="./?page=overview" title="{Overview}">
				
				<span class="textlabel">{Overview}</span>
			</a>
		</li>

{empire}

		<li class="menubutton_table" id="resources_menu_link" style="display:{show_resources};">
			<span class="menu_icon">
		  		<img href="./?page=resources" title="{Resources}" src="{{skin}}/img/navigation/navi_ikon_resources_{let_resources}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" href="./?page=resources" title="{Resources}">
				<span class="textlabel">{Resources}</span>
			</a>
		</li>

		<li class="menubutton_table">
			<span class="menu_icon">
		  		<img 
          onmouseover="this.src='{{skin}}/img/navigation/navi_ikon_station_c.gif';"
					onmouseout="this.src='{{skin}}/img/navigation/navi_ikon_station_{let_station}.gif';"
          href="./?page=station" title="{Facilities}" src="{{skin}}/img/navigation/navi_ikon_station_{let_station}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" href="./?page=station" title="{Facilities}">
				<span class="textlabel">{Facilities}</span>
			</a>
		</li>

		<li class="menubutton_table">
			<span class="menu_icon">
		  		<img href="./?page=trader" title="{Trader}" src="{{skin}}/img/navigation/navi_ikon_trader_{let_trader}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" href="./?page=trader" title="{Trader}">
				<span class="textlabel">{Trader}</span>
			</a>
		</li>

		<li class="menubutton_table">
			<span class="menu_icon">
		  		<img href="./?page=research" title="{Research}" src="{{skin}}/img/navigation/navi_ikon_research_{let_research}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" href="./?page=research" title="{Research}">
				<span class="textlabel">{Research}</span>
			</a>
		</li>

		<li class="menubutton_table">
			<span class="menu_icon">
		  		<img href="./?page=shipyard" title="{Shipyard}" src="{{skin}}/img/navigation/navi_ikon_shipyard_{let_shipyard}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" href="./?page=shipyard" title="{Shipyard}">
				<span class="textlabel">{Shipyard}</span>
			</a>
		</li>

		<li class="menubutton_table">
			<span class="menu_icon">
		  		<img href="./?page=defense" title="{Defence}" src="{{skin}}/img/navigation/navi_ikon_defense_{let_defense}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" href="./?page=defense" title="{Defence}">
				<span class="textlabel">{Defence}</span>
			</a>
		</li>

		<li class="menubutton_table">
			<span class="menu_icon">
		  		<a href="./?page=movement">
		  			<img src="{{skin}}/img/navigation/navi_ikon_fleet1_{let_fleet}.gif"
						onmouseover="this.src='{{skin}}/img/navigation/navi_ikon_fleet1_c.gif';"
						onmouseout="this.src='{{skin}}/img/navigation/navi_ikon_fleet1_{let_fleet}.gif';">
				</a>
			</span>
			<a class="menubutton" href="./?page=fleet1" title="{Fleet}">
				<span class="textlabel">{Fleet}</span>
			</a>
		</li>

		<li class="menubutton_table">
			<span class="menu_icon">
		  		<img src="{{skin}}/img/navigation/navi_ikon_galaxy_{let_galaxy}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" href="./?page=galaxy" title="{Galaxy}">
				<span class="textlabel">{Galaxy}</span>
			</a>
		</li>

		<li class="menubutton_table">
			<span class="menu_icon">
		  		<img src="{{skin}}/img/navigation/navi_ikon_network_{let_network}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" href="./?page=messages" title="{Network}">
				<span class="textlabel">{Network}</span>
			</a>
		</li>

		<li class="menubutton_table">
			<span class="menu_icon">
		  		<img src="{{skin}}/img/navigation/navi_ikon_premium_{let_premium}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" href="./?page=premium" title="{Officers}">
				<span class="textlabel">{RecOfficers}</span>
			</a>
		</li>

		<li class="menubutton_table">
			<span class="menu_icon">
		  		<img src="{{skin}}/img/navigation/navi_ikon_ticket_{let_premium}.gif" height="29" width="38" />
			</span>
			<a class="menubutton" href="./?page=ticket" title="{Errors}" tabindex="1">
				<span class="textlabel">{Errors}</span>
			</a>
		</li>

		<li class="menubutton_table">
			<span class="menu_icon">
		  	</span>
			<a class="menubutton" href="#" onclick="mr_alert('Please wait...','Bonus'); getAXAH('./bonus.php','errorBoxNotifyContent')" title="Click here for free commander and a moon!" tabindex="1">
				<span class="textlabel"><font color="Red">BONUS!</font></span>
			</a>
		</li>

	</ul>

{af}
{alert}

	<div class="adviceWrapper">
		<div id="advice-bar">
		</div>
	</div>

	<br class="clearfloat">
	
</div>

<!-- END LEFTMENU -->
