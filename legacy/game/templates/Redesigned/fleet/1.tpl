<div id="inhalt">
	<div id="planet" style="background-image:url({{skin}}/img/header/fleet/fleet1.jpg)">
		<h2>{FleetDispatch} I - {{planet}}</h2> 
		<div id="slots">
			<div class="fleft tips">
				<a style="postion:relative;">
					Fleets {avl_fleets}
					<span class="mrtooltip">Used/Total fleet slots</span>
				</a>
			</div>
			<div class="fright tips">
				<a style="postion:relative;">
					Expeditions {avl_exp}
					<span class="mrtooltip">Used/Total expedition slots</span>
				</a>
			</div>
		</div>
	</div>
	<div class="c-left"></div>
	<div class="c-right"></div>
	
	<div id="buttonz" style="position:relative;">
		<form name="shipsChosen" id="shipsChosen" method="get" action="./?page=fleet2">		
			<input type="hidden" name="galaxy" value="{gal}" />
			<input type="hidden" name="system" value="{sys}" />
			<input type="hidden" name="planet" value="{pla}" />
			<input type="hidden" name="planet_type" value="{typ}" />
			<input type="hidden" name="mission" value="{mis}" />
			<input type="hidden" name="speed" value="{spd}" />
			<input type="hidden" name="page" id="page" value="fleet2" />

			<div id="battleships">
				<h3>Combat ships</h3>
				<ul id="military">
					{military_ships}
				</ul>
			</div>	 
			<div id="spacer"></div>
			<div id="civilships">
				<h3>Civil ships</h3>
				<ul id="civil">
					{civil_ships}
				</ul>
			</div>
		</form>		
		<div class="clearfloat"></div>
		<div id="allornone" style="position:relative">
			<div class="allornonewrap">
					<div class="secondcol fleft" style="width:78px;">
						<span class="send_all">
							<!--<a 	href="#"
								class="tips" 
								title="|Select all ships" 
								onClick="maxShips();return false;" 
								id="sendall">

								<img src="{{skin}}/img/layout/alle_schiffe_a.gif" height="32" width="32" />
							</a>-->
							<a href="javascript:maxShips();" class="tips" id="sendall">
								<img src="{{skin}}/img/layout/alle_schiffe_a.gif" height="32" width="32" />
								<span class="mrtooltip">Select all ships</span>
							</a>
						</span>
						<span class="send_none">
							<!--<a href="#" class="tips" title="|Reset choice" onClick="return setSelectionToZero();">
								<img src="{{skin}}/img/navigation/icon-none.jpg" />
							</a>-->
							<a href="javascript:noShips();" class="tips">
								<img src="{{skin}}/img/navigation/icon-none.jpg" />
								<span class="mrtooltip">Reset choice</span>
							</a>
						</span>
						<div class="clearfloat"></div>

					</div>
				<a id="continue" class="on" href="#" onClick="document.getElementById('fleet1_store').innerHTML = document.getElementById('axah').innerHTML; submitform('shipsChosen',document.title,'fleet2','UpdateFleet2Info()');">
					<span>{fl_continue}</span>
				</a>
				<a id="continue" class="on" style="{show_jg}" href="#" onClick="document.getElementById('fleet1_store').innerHTML = document.getElementById('axah').innerHTML; document.getElementById('page').value = 'fleetjump'; submitform('shipsChosen',document.title,'fleet2','');">
					<span>{Jumpgate}</span>
				</a>
			<div class="clearfloat"></div>			
		</div>			  
		</div>
	</div>
</div>
