<!-- CONTENT AREA -->

	<div id="inhalt">

    <div id="zeuch666" style="display:none;">
        <div id="abandonplanet">
        
    <a href="./" class="close_details tips"><span class="mrtooltip">Close Window</span></a>
    <h3>abandon/rename Planet</h3>
    <div class="clearfloat"></div>
    <div id="inner">
    	<img src="../img/planets/large/jungle.jpg" alt=""/>
        <div>

            <p>Using this menu you can change planet names or completely abandon a colony.</p>
            <div style="margin-left:0px; margin-top:10px;">
                <table cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr class="head">
                    	<th colspan="3">rename</th>
                    </tr>
		    <tr>

                    	<td></td>
			<form name="planetMaintenance" method="post" action="./index.php?page=overview">
                    	<td><input class="text" type="text" maxlength="20" size="25" name="newPlanetName" value="New planet name" onFocus="clearField()" onBlur="fillField()" /></td>
                    	<td><input class="button188" type="submit" value="rename" name="aktion"/></td>
			</form>
                    </tr>
                    <tr class="head">
                    	<th colspan="3" class="second">Abandon colony</th>

                    </tr>
                    <tr>
                    	<th>Position</th><th>Name</th><th>Functions</th>
                    </tr>
                    <form name="planetMaintenanceDelete" method="post" action="index.php?page=overview&session=415ef0c90c0f">
                    <tr>
                    	<td>[1:67:11]</td>

                    	<td>Homeworld</td>
						<input type="hidden" name="abandon" value="1a0bb7418260a4d5347dd7154ce4eff7" />
                    	<td>
                        	<a id="block" class="start button188" onclick="show_hide_menus('validate')"><span>Abandon colony</span></a>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="3">

                        <div id="validate" style="display:none;">
                        	                          	<p>Please confirm deletion of planet [1:67:11] by putting in your password</p>
                        	<div>
                                <input class="text" type="password" name="password" maxlength="20" size="25" />
                                <input class="button188" type="submit" value="Confirm"/>
                            </div>
                        </div>
	                    </td>

					</tr>
					</form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        </div>
    </div>

		<div id="planet" style="background-image:url(img/planets/header/header_{planettype}.jpg);">
			<h2>Overview - {planet_name}</h2>
			<table cellpadding="0" cellspacing="0" id="planetdata">
				<tr>
		        	<td class="date" colspan="2">
                    	{date_time}
                    </td>
				</tr>

				<tr>
					<td class="desc tips" title="|Diameter, number of used and maximum usable fields">
                    	{Diameter}:
					</td>
					<td class="data">{planet_diameter}km ({planet_field_current}/{planet_field_max})</td>
				</tr>
				<tr>
					<td class="desc tips" title="|Temperature of planet">
                    	{Temperature}:

					</td>
					<td class="data">{approx} {planet_temp_min}{Centigrade} {to} {planet_temp_max}{Centigrade}</td>
				</tr>
				<tr>
					<td class="desc tips" title="|Position of planet in galaxy">
                    	{Position}:
					</td>
					<td class="data">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</td>
				</tr>

				<tr>
					<td class="desc tips" title="|Your current score">
                    	{Points}:
					</td>
					<td class="data">{total_points} ({Rank} {user_rank} {of} {players})</td>
				</tr>
				<tr>
					<td class="desc tips" title="|More options for this planet">
                    	{Options}:

					</td>
					<td class="data">{lnk_rena_dele}</td>
				</tr>				               
			</table>
		        		        
	        
		</div>	    <div class="c-left"></div>
	    <div class="c-right"></div>
			
<div class="content-box-s">
	<div class="header"><h3>Buildings</h3></div>

		<div class="content">
			<table cellpadding="0" cellspacing="0" class="construction">
																																	<tr>
							<th colspan="2">Metal Mine</th>
							<tr class="data">
							<td class="building" rowspan="2">
                            <a href="#"
                            class="tips" 
                            onclick="cancelProduction(1,1,'Cancel production of Metal Mine level 1?'); return false;"
                            title="|Cancel production of Metal Mine level 1?">
                            	<img src="img/small/small_1.jpg" alt="Metal Mine">

                            </a>
                            </td>
							<td class="desc">Improve to 
							<span class="level">Level 1</span></td>
						</tr>
						<tr>
							<td class="desc">Building duration <span id="Countdown">50s</span><br>
                                                            </td>

						</tr>
														 
										
			  
			</table>
		</div>
	<div class="footer"></div>
</div><div class="content-box-s">
	<div class="header"><h3>Research</h3></div>
	<div class="content">
		<table cellpadding="0" cellspacing="0" class="construction">
					<tr>

				<td colspan="2" class="idle">
                	<a class="tips" title="|There is no research done at the moment. Click here to get to your research lab." href="index.php?page=research&session=415ef0c90c0f">There is no research in progress at the moment.</a>
                </td>
			</tr>
			   
		</table>                   
	</div>
	<div class="footer"></div>
</div>
<div class="content-box-s">
	<div class="header"><h3>Shipyard</h3></div>

	<div class="content">
            
		<table cellpadding="0" cellspacing="0" class="construction">
					<tr>
                <td colspan="2" class="idle">
                	<a class="tips" title="|At the moment there are no ships or defence being built on this planet. Click here to get to the shipyard." href="index.php?page=shipyard&session=415ef0c90c0f">No ships/defense are built at the moment.</a>
                </td>
			</tr>	
				</table>
	</div>

	<div class="footer"></div>
</div>	     <div class="clearfloat"></div>
    </div>   

<!-- END CONTENT AREA -->
