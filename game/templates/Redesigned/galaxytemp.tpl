<!-- CONTENT AREA -->

<div id="inhalt" style="margin-top:-44px;">
<div id="rocketWrapper" style="display:none">
	    <div id="rocketattack">
        <a class="close_details" onclick="tb_remove(); return false;" href="#">
    			<img src="img/layout/pixel.gif" width="16" height="16"/>

        </a>
        <form method="post" name="rocketattack" action="./?page=galaxy&fireRocket=1">
        	<input type="hidden" name="galaxy" value="">
        	<input type="hidden" name="system" value="">
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
    </div></div>    
    <table cellpadding="0" cellspacing="0" id="galaxytable" border="0">
    <tr id="galaxyheadbg">
        <td colspan="13">
        <div style="position:relative; height:55px; width:647px;">
        <form action="./?page=galaxy" name="galaform" method="post">
		<div id="galaxyscroll">
            	<span>Galaxy</span>

                <div style="margin-top:11px;">
						            <a href="./?page=galaxy&galaxy=6&system=456" 
                onmouseover="image1.src='../img/galaxy/pfeil_links-a.gif';"
                onmouseout="image1.src='../img/galaxy/pfeil_links.gif';">
                	<img name="image1" src="../img/galaxy/pfeil_links.gif" width="25" height="24" />
                 </a>
		    					<input maxlength="3" type="text" size="1" value="7" name="galaxy" tabindex="2" onKeyPress="return submitOnEnter(this,event);" />
						            <a href="./?page=galaxy&galaxy=8&system=456"
	            onmouseover="image2.src='../img/galaxy/pfeil_rechts-a.gif';"
    	        onmouseout="image2.src='../img/galaxy/pfeil_rechts.gif';">
                	<img name="image2" src="../img/galaxy/pfeil_rechts.gif" width="25" height="24" />
                </a>
		    			                 <br class="clearfloat" />

                 </div>
            </div>            <div id="solarscroll">
				<span>System</span>
                <div style="margin-top:11px;">
					                    <a href="./?page=galaxy&galaxy=7&system=455" 
                     onmouseover="image3.src='../img/galaxy/pfeil_links-a.gif';"
	                onmouseout="image3.src='../img/galaxy/pfeil_links.gif';">
                    	<img name="image3" src="../img/galaxy/pfeil_links.gif" width="25" height="24" />
                    </a>
		    			                    <input maxlength="3" type="text" size="3" value="456" tabindex="2" name="system" onKeyPress="return submitOnEnter(this,event);" />

					                    <a href="./?page=galaxy&galaxy=7&system=457"
                    onmouseover="image4.src='../img/galaxy/pfeil_rechts-a.gif';"
	            	onmouseout="image4.src='../img/galaxy/pfeil_rechts.gif';">
                    	<img name="image4" src="../img/galaxy/pfeil_rechts.gif" width="25" height="24" />
                    </a>
		    			                    <br class="clearfloat" />
                </div>
            </div>        </form>
        <div id="showbutton" onClick="document.galaform.submit();">
	        <a href="#">

            	<span class="bleft"></span>
                <span class="text">Display</span>
                <span class="bright"></span>
            </a>
        </div>
        	<div id="expeditionbutton">
					<a href="#" onClick="errorBoxNotify('Reference','You have to research Expedition Technology first.','Ok');return false">
		                	<span class="bleft"></span>

                    <span class="text">Expedition</span>
                    <span class="bright"></span>
                </a>  
            </div>
            <div id="extendedgalaxy">
            	            </div>
		</div>
      </td>
    </tr>

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

        			    <tr class="row">
        	<td class="spacer01"></td>

            <td class="position">1</td>
            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=1&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>

            <td class="allytag"></td>
            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>
	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">2</td>

            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=2&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>

            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>
	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">3</td>
            <td class="microplanet1"></td>

            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=3&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>
            <td class="spacer04"></td>

            <td class="action"></td>
            <td class="end"></td>
	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">4</td>
            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=4&mission=7">[Colonization]</a></td>

            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>
            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>

	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">5</td>
            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=5&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>

            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>
            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>
	    </tr>
	        			    <tr class="row">

        	<td class="spacer01"></td>
            <td class="position">6</td>
            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=6&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>

            <td class="spacer03"></td>
            <td class="allytag"></td>
            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>
	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">7</td>

            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=7&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>

            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>
	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">8</td>
            <td class="microplanet1"></td>

            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=8&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>
            <td class="spacer04"></td>

            <td class="action"></td>
            <td class="end"></td>
	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">9</td>
            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=9&mission=7">[Colonization]</a></td>

            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>
            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>

	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">10</td>
            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=10&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>

            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>
            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>
	    </tr>
	        			    <tr class="row">

        	<td class="spacer01"></td>
            <td class="position">11</td>
            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=11&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>

            <td class="spacer03"></td>
            <td class="allytag"></td>
            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>
	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">12</td>

            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=12&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>

            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>
	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">13</td>
            <td class="microplanet1"></td>

            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=13&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>
            <td class="spacer04"></td>

            <td class="action"></td>
            <td class="end"></td>
	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">14</td>
            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=14&mission=7">[Colonization]</a></td>

            <td class="moon"></td>
            <td class="spacer02"></td>
            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>
            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>

	    </tr>
	        			    <tr class="row">
        	<td class="spacer01"></td>
            <td class="position">15</td>
            <td class="microplanet1"></td>
            <td class="planetname1"><a href="./?page=fleet1&galaxy=7&system=456&position=15&mission=7">[Colonization]</a></td>
            <td class="moon"></td>
            <td class="spacer02"></td>

            <td class="debris"></td>
            <td class="playername"></td>
            <td class="spacer03"></td>
            <td class="allytag"></td>
            <td class="spacer04"></td>
            <td class="action"></td>
            <td class="end"></td>
	    </tr>
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
            	<a href="#"><img src="img/icons/info.gif" /></a>
                <span class='tooltip_sticky' style='display:none;'>
               		<div class="TTInner" id="TTPlayer">
                    <table cellpadding="0" cellspacing="0" class="legende" width="100">
                    <tr><th colspan="2">Legend</th></tr>
					<tr class="body"><td class="description">Stronger Player</td><td class="abbreviation status_abbr_strong">s</td></tr>

                    <tr class="body"><td class="description">Weaker Player (newbie)</td><td class="abbreviation status_abbr_noob">n</td></tr>
                    <tr class="body"><td class="description">Vacation Mode</td><td class="abbreviation status_abbr_vacation">v</td></tr>
                    <tr class="body"><td class="description">Banned</td><td class="abbreviation status_abbr_banned">b</td></tr>
                    <tr class="body"><td class="description">7 days inactive</td><td class="abbreviation status_abbr_inactive">i</td>
                    <tr class="body"><td class="description">28 days inactive</td><td class="abbreviation status_abbr_longinactive">I</td></tr>

                    </table>
                    </div>
               </span>
            </span>
            <br class="clearfloat" />
        </td>
	</tr>    
    <tr class="footer">
    	<td colspan="13">

            <span id="probes" class="tips" title="|Espionage probes: 0">
                <span id="probeValue">0</span> 
                Spy probes            </span>     
            <span id="recycler" class="tips" title="|Available recyclers: 0">
                <span id="recyclerValue">0</span> 
                Recycler            </span>    
            <span id="rockets" class="tips" title="|Available interplanetary missiles: 0">
                <span id="missileValue">0</span> 
                Interplanetary missiles</span>

            <span id="slots" class="tips" title="|Fleet slots in use: 0 of 1">
                <span id="slotValue">0</span>/1 
                used slots            </span>
        </td>
    </tr>                                                                                            
<!--    <tr><td colspan="9"><img src="css/iepngfix/opacity.png" /></td></tr>-->
    </table>
</div><!-- END CONTENT AREA -->
