	    <div id="fleet{fleet_id}" name="fleetm_fleetrow" class="fleetDetails detailsOpened">
	        <span class="timer" id="timer_{fleet_id}"></span>
	        <span class="absTime">{depart}</span>
	        <span class="mission hostile textBeefy">{mission_t}</span>
	        <span class="allianceName"></span>
	        <span class="originData">
	        <span class="originCoords"><a href="./?page=galaxy&galaxy={startplanet_galaxy}&system={startplanet_system}&planet={startplanet_planet}">[{startplanet_galaxy}:{startplanet_system}:{startplanet_planet}]</a></span>
	        <span class="originPlanet">{startplanet_name}</span>
	        </span>
	        <span class="quantity basic2" rel="#details{fleet_id}" title="Fleet details">{fleet_amount}</span>
	        <span class="reversal tips" title="|Recall">
	            <a onclick="mr_alert('<img height=16 width=16 src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}...','Fleet Recall'); getAXAH(this.href,'errorBoxNotifyContent'); loadpage('./?page=movement',document.title,document.body.id); return false;" href="./?page=fleetrecall&fleet_id={fleet_id}&passkey={passkey}">
	                <img src="{{skin}}/img/icons/recall.gif" height="16" width="16" />
	            </a>
	        </span>

	        <span class="starStreak">
	            <div style="position: relative;">
	                <div class="origin fixed">
	                    <img class="tips4" height="30" width="30" src="{{skin}}/img/planets/jungle_8_1.gif" title="{t_depart}<br />{depart_d}<br />{depart}"/>
	                </div>

	                <div class="route fixed">
	                    <img height="16" width="16" style="margin-left: {progress}px;" rel="#details{fleet_id}" onmouseover="mrtooltip_large('{details}','{fl_details}',200);" onmouseout="UnTip();" class="basic2" src="{{skin}}/img/navigation/{image}" id="route_{fleet_id}" />
	                </div>

	                <div class="destination fixed">
	                    <img class="tips4" height="30" width="30" src="{{skin}}/img/planets/water_9_1.gif" title="{t_arrival}<br />{arrive_d}<br />{arrive}"/>
	                </div>

	            </div>
	        </span><!-- Starstreak -->
	        <span class="destinationData">
              <span class="destinationCoords"><a href="./?page=galaxy&galaxy={targetplanet_galaxy}&system={targetplanet_system}&planet={targetplanet_planet}">[{targetplanet_galaxy}:{targetplanet_system}:{targetplanet_planet}]</a></span>
              <span class="destinationPlanet">{startplanet_name}</span>
	        </span>

	        <span class="nextTimer" id="timerNext_{fleet_id}"></span>
	        <span class="nextabsTime">{arrive}</span>
	        <span class="nextMission friendly textBeefy">Return</span>
	        <span class="sendMail">
	            <a class="thickbox tips"
	                href="index.php?page=writemessage&session=b0e9ef2290a7&to=109245&ajax=1&height=500&width=750&TB_iframe=1"
	                title="|Send a message to ZDragS.">
	                <img src="{{skin}}/img/icons/mail.gif" height="16" width="16" />
	            </a>
	        </span>

	        <span class="fedAttack">
	            <a class="thickbox tips"
	               href="#"
	               title="Fleet union"
	               onClick="return false;">
	                <img src="{{skin}}/img/icons/allianceattack.gif" height="16" width="16" />
	            </a>
	        </span>
	        <span class="openDetails">
	            <a href="#" onClick="openCloseDetails('{fleet_id}',1234801154);">
	                <img src="{{skin}}/img/layout/fleetCloseDetails.gif" height="18" width="16" />
	            </a>
	        </span>

	        <input type="hidden" id="start{fleet_id}" value="{departure}" />
	        <input type="hidden" id="end{fleet_id}" value="{arrival}" />
	        <input type="hidden" id="dir{fleet_id}" value="{fleet_mess}" />
	    </div>
