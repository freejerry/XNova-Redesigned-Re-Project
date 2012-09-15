<!--<body id="{bodyid}" style="display:none;" onload="document.body.style.display='block';fadeIn('{bodyid}',0);">-->
<body id="{bodyid}">
<script type="text/javascript" src="./scripts/wz_tooltip.js"></script>

<input type="hidden" id="planet_ext" value="{planet_ext}" />
<input type="hidden" id="cur_page" value="" />

<div class="contentBoxBody">

<!-- HEADER -->
<div id="box">
<!--<a name='anchor'></a>-->
	<div id="info">
	<!--<div id="clearAdvice"></div>-->
   	<a id="changelog_link" href="#" onclick="mrbox('./?page=changelog',800)"><!--Universe Number could go here-->{game_name}</a>
   	<div id="playerName">Player Name: <span class="textBeefy">{user_name}</span></div>
	<div id="bar">
		<ul>
			<li><a href="#" onclick="mrbox('./?page=amici_pop_up&iframe=1&iheight=800',800)">{Buddys}</a></li>
			
			<li><a href="#" onclick="loadpage('./?page=notes','{Notes}','networkm');">{Notes}</a></li>

			<li><a onclick="loadpage('./?page=statistics','{Statistics}','statistics');" href="#">{Highscore} ({players})</a></li>
			<li><a href="#" onclick="mrbox('./?page=cerca&iframe=1&iheight=800',800)">{Search}</a></li>

			<li><a onclick="loadpage('./?page=preferences','{Options}','preferences');" href="#">{Options}</a></li>

			<li><a href="./?page=admin">{Admin}</a></li>

			<li><a href="./?page=logout" onclick="mr_qu_link('{Logout_confirm}','{Logout}',this.href); return false;">{Logout}</a></li>
		</ul>
	</div>
	<div id="OGameClock"><span id="datetime">{date_time}</span></div>
	<ul id="resources">
	   	<li class="metal tips">
	   		<a onmouseover=´mrtooltip('<div align="center">Metal</div><hr size="3" align="center" width="100%" color="#FFF">Available:<span id="pretty_metal">{metal}</span><br />Storage capacity:{metal_max}');´ onmouseout="UnTip();">
				<img src="{skin}/img/navigation/ressourcen_metall.gif" />
				<span class="value">
					<font id="resources_metal">{kmetal}</font>
				</span>
			</a>
		</li>
		<li class="crystal tips">
			<a onmouseover=´mrtooltip('<div align="center">Crystal</div><hr size="3" align="center" width="100%" color="#FFF">Available:<span id="pretty_crystal">{crystal}</span><br />Storage capacity:{crystal_max}');´ onmouseout="UnTip();">
				<img src="{skin}/img/navigation/ressourcen_kristal.gif" />
				<span class="value">
					<font id="resources_crystal">{kcrystal}</font>
				</span>
			</a>
		</li>
		<li class="deuterium tips">
			<a onmouseover=´mrtooltip('<div align="center">Deuterium</div><hr size="3" align="center" width="100%" color="#FFF">Available:<span id="pretty_deut">{deut}</span><br />Storage capacity:{deut_max}');´ onmouseout="UnTip();">
				<img src="{skin}/img/navigation/ressourcen_deuterium.gif" />
				<span class="value">
					<font id="resources_deuterium">{kdeut}</font>
			   	</span>
			</a>
		</li>
		<li class="energy tips">
			<a onmouseover=´mrtooltip('<div align="center">Energy</div><hr size="3" align="center" width="100%" color="#FFF">Available:<font id="resources_energy_detil" {energy_green}>{energy}</font><br />Production:<font id="pretty_energy" color="green">{energy_max}</font><br />Consumption:<font id="pretty_energy_used" color=\"red\">{energy_used}</font>');´ onmouseout="UnTip();">
				<img src="{skin}/img/navigation/ressourcen_energie.gif" />
				<span class="value">
					<font id="resources_energy"{energy_red}>{energy}</font>
				</span>
			</a>
		</li>
		<li	class="darkmatter tips">
			<a href="./?page=premium" onmouseover=´mrtooltip('<div align="center">Dark Matter (Click to buy)</div><hr size="3" align="center" width="100%" color="#FFF">Available:<span id="pretty_matter">{matter}</span>');´ onmouseout="UnTip();">
				<img src="{skin}/img/navigation/ressourcen_DM.gif" />
				<span class="value">
					<span id="resources_matter">{matter}</span>
				</span>
			</a>
		</li>
	</ul>
  	<div id="officers">
		<a href="./?page=premium&offi=601" class="tips" style="position:relative;">
			<img src="{skin}/img/layout/commander_ikon{un601}.gif">
			<span class="mrtooltip">{hire601}</span>
		</a>

		<a href="./?page=premium&offi=605" class="tips" style="position:relative;">
			<img src="{skin}/img/layout/admiral_ikon{un602}.gif">
			<span class="mrtooltip">{hire602}</span>
		</a>

		<a href="./?page=premium&offi=603" class="tips" style="position:relative;">
			<img src="{skin}/img/layout/ingenieur_ikon{un603}.gif">
			<span class="mrtooltip">{hire603}</span>
		</a>

		<a href="./?page=premium&offi=604" class="tips" style="position:relative;">
			<img src="{skin}/img/layout/geologe_ikon{un604}.gif">
			<span class="mrtooltip">{hire604}</span>
		</a>

		<a href="./?page=premium&offi=605" class="tips" style="position:relative;">
			<img src="{skin}/img/layout/technokrat_ikon{un605}.gif">
			<span class="mrtooltip">{hire605}</span>
		</a>
	</div>

	<div id="message-wrapper">
		<div id="message_alert_box" style="visibility: {showmail};">
			<a href="./?page=messages" onclick="loadpage(this.href,\'{Messages}\',\'messages\'); return false;" class="tips" onmouseover="mrtooltip(\'{messages_count} new message(s)\');" onmouseout="UnTip();">
				<img src="{{skin}}/img/layout/pixel.gif" height="13" width="25">
			</a>
		</div>
		<div id="fleetajax">
			<div id="messages_collapsed" style="position: relative;">
				<div id="eventboxFilled" style="display: {eventboxdisplay};" onclick="">
					{fleet_table}
				</div>

				<div id="eventboxLoading" class="textCenter textBeefy" style="display: none;">
					<img height="16" width="16" src="{{skin}}/img/ajax-loader.gif" /> Loading...
				</div>

				<div id="eventboxBlank" class="textCenter" style="display: block;">No fleet movement</div>
			</div>
			<div id="attack_alert" style="visibility:{attack_alert};">
				<a 	href="index.php?page=eventList&session=ef580060082c&ajax=1&height=500&width=650&TB_iframe=1&modal=true"
					class="tips thickbox"
					title="|Attack!">
					<img src="{{skin}}img/layout/pixel.gif" height="13" width="25"/>
				</a>
			</div>
		</div>
		<br class="clearfloat" />
	</div>
	<!-- #message-wrapper -->
	<div id="helper"><a class="tips" href="./?page=achievements" onclick="loadpage(this.href,'{Achievements}','tutorial'); return false;" title="{Achievements}"></a></div> 
 </div>
<!-- Info -->


<!-- ERRORBOX -->
<div id="decisionTB" style="display:{desc_show};left:auto;right:auto;">
	<div id="errorBoxDecision">
		<div id="wrapper">
			<h4 id="errorBoxDecisionHead">{nhead}</h4>
			<p id="errorBoxDecisionContent">{ncont}</p>
			<div id="response">
				<div style="float:left; width:195px; height:25px;">
					<a href="{go_yes}" class="yes" id="decisionTB_button1">
						<span id="errorBoxDecisionYes">{Yes}</span>
					</a>
				</div>
				<div style="float:left; width:195px; height:25px;">
					<a href="{go_no}" class="no" id="decisionTB_button2">
						<span id="errorBoxDecisionNo">{No}</span>
					</a>
				</div>
				<br class="clearfloat" />
			</div>
		</div>	
	</div> 
</div>

<div id="notifyTB" style="display:{note_show};left:auto;right:auto;">
	<div id="errorBoxNotify">
		<div id="wrapper">
			<h4 id="errorBoxNotifyHead">{nhead}</h4>
			<p id="errorBoxNotifyContent">{ncont}</p>
			<div id="response">
				<div>
					<a href="{go_ok}" class="ok" id="notifyTB_button">
						<span id="errorBoxNotifyOk">{OK}</span>
					</a>
				</div>
				<br class="clearfloat" />
			</div>
		</div>	
	</div> 
</div>

<!-- END ERRORBOX -->

<!-- END HEADER -->

