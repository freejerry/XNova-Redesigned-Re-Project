<div id="inhalt">
	<div id="planet" style="background-image:url({{skin}}/img/header/movement/movement_header.jpg)">
		<h2>{FleetManage} - {{planet}}</h2> 
	</div>
	<div class="c-left"></div>
	<div class="c-right"></div>

	
    <div class="fleetStatus">
        <span class="reload">
            <a href="#" onClick="reloadPage();">

                <img src="{{skin}}/img/icons/refresh.gif" height="16" width="16" />
                <span></span>
            </a>
        </span>
        <span class="fleetSlots">
            fleets: <span class="current">1</span> / <span class="all">2</span>

        </span>
        <span class="expSlots">
            Expeditions: <span class="current">0</span> / <span class="all">0</span>
        </span>
        <span class="closeAll tips">
            <a href="#" onclick="ReverseDisplay('flyingfleets')"><img src="{{skin}}/img/layout/fleetCloseAll.gif" /></a>
        </span>
    </div>
	<div id="flyingfleets"> 
		{fleets}
	</div>
</div>
<!-- END CONTENT AREA -->
