<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel='stylesheet' type='text/css' href='{{skin}}/css/thickbox-iframe.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{{skin}}/css/jquery.cluetip.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{{skin}}/css/eventList.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{{skin}}/css/toolbox.css' media='screen' />
</head>

<body>
	<div id="eventListWrap">
		<div id="eventHeader">
			<h4>
				<a class="tips" href="#" onClick="location.reload(); return false;" title="|Espionage">
					<img style="vertical-align:middle;" src="{{skin}}/img/icons/refresh.gif" />
				</a>
				Sensor report from moon on [4:27:5] (Mad King Loner)
			</h4>
			<a class="close_details" href="#" onClick="self.parent.tb_remove();">
				<img src="img/layout/pixel.gif" height="16" width="16" />
			</a>
		</div>
		<div id="eventContent" style="text-align:center">
			{rows}
		</div>
		<div id="eventFooter"></div>
	</div>

<script type='text/javascript' src='http://uni42.ogame.org/game/js/jquery.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/jquery.dimensions.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/jquery.hoverIntent.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/jquery.cluetip.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/jquery.configcluetip.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/helpers.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/countdown.js'></script>

<script type='text/javascript' src='http://uni42.ogame.org/game/js/tools.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/utilities.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/thickbox.js'></script>
<script type="text/javascript">	 
var timeDelta = 1262548651000 - (new Date()).getTime();

LocalizationStrings = new Array();
LocalizationStrings.timeunits = new Array();
LocalizationStrings.timeunits.short = new Array();
LocalizationStrings.timeunits['short'].day = 'd';
LocalizationStrings.timeunits['short'].hour = 'h';
LocalizationStrings.timeunits['short'].minute = 'm';
LocalizationStrings.timeunits['short'].second = 's';
LocalizationStrings.status = new Array();
LocalizationStrings.status.ready = 'done';

function checkEventList()
{
	var url = 'index.php?page=checkEvents&session=94a8d17d8145&ajax=1';
	var ids = '38103016'; 

	params = new Object();
	params.ids = ids;

	$.post(url, params, hideRows);
}

function hideRows(data)
{
	var rowIDs = eval('(' + data + ')');

	for (var index in rowIDs["rows"]) {
		$("#eventRow-" + rowIDs["rows"][index]).hide();
	} 
}

function initEventlist() {
	var countdowns = new Array();
	new eventboxCountdown(getElementByIdWithCache("counter-38103016"), 22);

	$('.eventFleet:odd').addClass('odd'); 
	$('.partnerInfo:even').addClass('part-even');  
}   

$(".toggleInfos").click(function() {
	id = $(this).attr("rel");

	 if ($(this).attr("class") == "toggleInfos infosOpen") {
	   $(this).removeClass("infosOpen");
	   $(this).addClass("infosClosed");  
	   $(this).children().attr("src", "img/layout/fleetOpenDetails.gif");   
	   $("." + id).attr("style", "display: none;");
	 } else {
	   $(this).addClass("infosOpen");
	   $(this).removeClass("infosClosed");
	   $(this).children().attr("src", "img/layout/fleetCloseDetails.gif"); 
	   $("." + id).attr("style", "display: block;");			   
	 }
});

$(document).ready(function() {
			initEventlist();
initCluetipEventlist();
});

 
 </script></body>

</html>
