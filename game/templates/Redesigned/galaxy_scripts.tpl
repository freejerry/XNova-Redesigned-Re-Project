<script language="JavaScript">
    function galaxy_submit(value) {
      document.getElementById('auto').name = value;
      document.getElementById('galaxy_form').submit();
    }

    function fenster(target_url,win_name) {
      var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=640,height=480,top=0,left=0');
new_win.focus();
    }
  </script>
<script language="JavaScript" src="scripts/tw-sack.js"></script>
<script type="text/javascript">

/***********************************************
* Image w/ description tooltip- By Dynamic Web Coding (www.dyn-web.com)
* Copyright 2002-2007 by Sharon Paine
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

/* IMPORTANT: Put script after tooltip div or 
	 put tooltip div just before </BODY>. */

var dom = (document.getElementById) ? true : false;
var ns5 = (!document.all && dom || window.opera) ? true: false;
var ie5 = ((navigator.userAgent.indexOf("MSIE")>-1) && dom) ? true : false;
var ie4 = (document.all && !dom) ? true : false;
var nodyn = (!ns5 && !ie4 && !ie5 && !dom) ? true : false;

var origWidth, origHeight;

// avoid error of passing event object in older browsers
if (nodyn) { event = "nope" }

///////////////////////  CUSTOMIZE HERE   ////////////////////
// settings for tooltip 
// Do you want tip to move when mouse moves over link?
var tipFollowMouse= true;	
// Be sure to set tipWidth wide enough for widest image
var tipWidth= 160;
var offX= 20;	// how far from mouse to show tip
var offY= 12; 
var tipFontFamily= "Verdana, arial, helvetica, sans-serif";
var tipFontSize= "8pt";
// set default text color and background color for tooltip here
// individual tooltips can have their own (set in messages arrays)
// but don't have to
var tipFontColor= "#000000";
var tipBgColor= "#DDECFF"; 
var tipBorderColor= "#000080";
var tipBorderWidth= 3;
var tipBorderStyle= "ridge";
var tipPadding= 4;

// tooltip content goes here (image, description, optional bgColor, optional textcolor)
var messages = new Array();
// multi-dimensional arrays containing: 
// image and text for tooltip
// optional: bgColor and color to be sent to tooltip
messages[0] = new Array('red_balloon.gif','Here is a red balloon on a white background',"#FFFFFF");
messages[1] = new Array('duck2.gif','Here is a duck on a light blue background.',"#DDECFF");
messages[2] = new Array('test.gif','Test description','black','white');

////////////////////  END OF CUSTOMIZATION AREA  ///////////////////

// preload images that are to appear in tooltip
// from arrays above
if (document.images) {
	var theImgs = new Array();
	for (var i=0; i<messages.length; i++) {
  	theImgs[i] = new Image();
		theImgs[i].src = messages[i][0];
  }
}

// to layout image and text, 2-row table, image centered in top cell
// these go in var tip in doTooltip function
// startStr goes before image, midStr goes between image and text
var startStr = '<table><tr><td align="center" width="100%"><img src="';
var endStr = '" border="0"></td></tr></table>';

////////////////////////////////////////////////////////////
//  initTip	- initialization for tooltip.
//		Global variables for tooltip. 
//		Set styles
//		Set up mousemove capture if tipFollowMouse set true.
////////////////////////////////////////////////////////////
var tooltip, tipcss;
function initTip() {
	if (nodyn) return;
	tooltip = (ie4)? document.all['tipDiv']: (ie5||ns5)? document.getElementById('tipDiv'): null;
	tipcss = tooltip.style;
	if (ie4||ie5||ns5) {	// ns4 would lose all this on rewrites
		tipcss.width = tipWidth+"px";
		tipcss.fontFamily = tipFontFamily;
		tipcss.fontSize = tipFontSize;
		tipcss.color = tipFontColor;
		tipcss.backgroundColor = tipBgColor;
		tipcss.borderColor = tipBorderColor;
		tipcss.borderWidth = tipBorderWidth+"px";
		tipcss.padding = tipPadding+"px";
		tipcss.borderStyle = tipBorderStyle;
	}
	if (tooltip&&tipFollowMouse) {
		document.onmousemove = trackMouse;
	}
}

window.onload = initTip;

/////////////////////////////////////////////////
//  doTooltip function
//			Assembles content for tooltip and writes 
//			it to tipDiv
/////////////////////////////////////////////////
var t1,t2;	// for setTimeouts
var tipOn = false;	// check if over tooltip link
function doTooltip(evt,url) {
	if (!tooltip) return;
	if (t1) clearTimeout(t1);	if (t2) clearTimeout(t2);
	tipOn = true;
	// set colors if included in messages array
	curBgColor = tipBgColor;
	curFontColor = tipFontColor;
	if (ie4||ie5||ns5) {
		var tip = startStr + url + endStr;
		tipcss.backgroundColor = curBgColor;
	 	tooltip.innerHTML = tip;
	}
	if (!tipFollowMouse) positionTip(evt);
	else t1=setTimeout("tipcss.visibility='visible'",100);
}

var mouseX, mouseY;
function trackMouse(evt) {
	standardbody=(document.compatMode=="CSS1Compat")? document.documentElement : document.body //create reference to common "body" across doctypes
	mouseX = (ns5)? evt.pageX: window.event.clientX + standardbody.scrollLeft;
	mouseY = (ns5)? evt.pageY: window.event.clientY + standardbody.scrollTop;
	if (tipOn) positionTip(evt);
}

/////////////////////////////////////////////////////////////
//  positionTip function
//		If tipFollowMouse set false, so trackMouse function
//		not being used, get position of mouseover event.
//		Calculations use mouseover event position, 
//		offset amounts and tooltip width to position
//		tooltip within window.
/////////////////////////////////////////////////////////////
function positionTip(evt) {
	if (!tipFollowMouse) {
		standardbody=(document.compatMode=="CSS1Compat")? document.documentElement : document.body
		mouseX = (ns5)? evt.pageX: window.event.clientX + standardbody.scrollLeft;
		mouseY = (ns5)? evt.pageY: window.event.clientY + standardbody.scrollTop;
	}
	// tooltip width and height
	var tpWd = (ie4||ie5)? tooltip.clientWidth: tooltip.offsetWidth;
	var tpHt = (ie4||ie5)? tooltip.clientHeight: tooltip.offsetHeight;
	// document area in view (subtract scrollbar width for ns)
	var winWd = (ns5)? window.innerWidth-20+window.pageXOffset: standardbody.clientWidth+standardbody.scrollLeft;
	var winHt = (ns5)? window.innerHeight-20+window.pageYOffset: standardbody.clientHeight+standardbody.scrollTop;
	// check mouse position against tip and window dimensions
	// and position the tooltip 
	if ((mouseX+offX+tpWd)>winWd) 
		tipcss.left = mouseX-(tpWd+offX)+"px";
	else tipcss.left = mouseX+offX+"px";
	if ((mouseY+offY+tpHt)>winHt) 
		tipcss.top = winHt-(tpHt+offY)+"px";
	else tipcss.top = mouseY+offY+"px";
	if (!tipFollowMouse) t1=setTimeout("tipcss.visibility='visible'",100);
}

function hideTip() {
	if (!tooltip) return;
	t2=setTimeout("tipcss.visibility='hidden'",100);
	tipOn = false;
}

document.write('<div id="tipDiv" style="position:absolute; visibility:hidden; z-index:100"></div>')

</script>
<script type="text/javascript">
var ajax = new sack();
var strInfo = "";
      
function whenLoading(){
  //var e = document.getElementById('fleetstatus'); 
  //e.innerHTML = "{Sending_fleet}";
}
      
function whenLoaded(){
  //    var e = document.getElementById('fleetstatus'); 
  // e.innerHTML = "{Sent_fleet}";
}
      
function whenInteractive(){
  //var e = document.getElementById('fleetstatus'); 
  // e.innerHTML = "{Obtaining_data}";
}

/* 
   We can overwrite functions of the sack object easily. :-)
   This function will replace the sack internal function runResponse(), 
   which normally evaluates the xml return value via eval(this.response).
*/

function whenResponse(){

 /*
 *
 *  600   OK
 *  601   no planet exists there
 *  602   no moon exists there
 *  603   player is in noob protection
 *  604   player is too strong
 *  605   player is in u-mode 
 *  610   not enough espionage probes, sending x (parameter is the second return value)
 *  611   no espionage probes, nothing send
 *  612   no fleet slots free, nothing send
 *  613   not enough deuterium to send a probe
 *
 */

  // the first three digit long return value
  retVals = this.response.split(" ");
  // and the other content of the response
  // but since we only got it if we can send some but not all probes 
  // theres no need to complicate things with better parsing
  // each case gets a different table entry, no language file used :P
  switch(retVals[0]) {
  case "600":
    addToTable("done", "success");
        changeSlots(retVals[1]);
    setShips("probes", retVals[2]);
    setShips("recyclers", retVals[3]);
    setShips("missiles", retVals[4]);
        break;
  case "601":
    addToTable("{an_error_has_happened_while_it_was_sent}", "error");
    break;
  case "602":
    addToTable("{error_there_is_no_moon}", "error");
    break;
  case "603":
    addToTable("{error_the_player_is_under_the_protection_of_beginners}", "error");
    break;
  case "604":
    addToTable("{error_the_player_is_too_strong}", "error");
    break;
  case "605":
    addToTable("Nie mozna skanowac graczy bedacych na urlopie", "vacation");
    break;
  case "610":
    addToTable("{error_only_x_available_probes_sending}", "notice");
    break;
  case "611":
    addToTable("Brak sond szpiegowskich", "error");
    break;
  case "612":
    addToTable("Osiagnieta maksymalna ilosc flot", "error");
    break;
  case "613":
    addToTable("Masz za malo deuteru", "error");
    break;
  case "614":
    addToTable("Nie mozna skanowac planety nie skolonizowanej", "error");
    break;
  case "615":
    addToTable("{error_there_is_no_sufficient_fuel}", "error");
    break;
  case "616":
    addToTable("Multialarm!", "error");
    break;
  case "617":
	addToTable("Nie masz recyklerow", "error");
  break;
  }
}

function doit(order, galaxy, system, planet, planettype, shipcount){
  	if(order==2)	
	strInfo = "Wysylanie "+shipcount+" "+(shipcount>1?"sond":"sondy")+" na "+galaxy+":"+system+":"+planet+"...";
   if(order==8)	
	strInfo = "Wysylanie "+shipcount+" "+(shipcount>1?"recykler":"recyklerow")+" na "+galaxy+":"+system+":"+planet+"...";
    
    ajax.requestFile = "floten3.php?action=send";

    // no longer needed, since we don't want to write the cryptic
    // response somewhere into the output html
    //ajax.element = 'fleetstatus';
    //ajax.onLoading = whenLoading;
    //ajax.onLoaded = whenLoaded; 
    //ajax.onInteractive = whenInteractive;

    // added, overwrite the function runResponse with our own and
    // turn on its execute flag
    ajax.runResponse = whenResponse;
    ajax.execute = true;

    ajax.setVar("thisgalaxy", {tg})
    ajax.setVar("thissystem", {ts});
    ajax.setVar("thisplanet", {tp});
    ajax.setVar("thisplanettype", {tpt});
    ajax.setVar("speed210", 1000000000);
    ajax.setVar("speed209", 2000);
    ajax.setVar("mission", order);
    ajax.setVar("galaxy", galaxy);
    ajax.setVar("system", system);
    ajax.setVar("planet", planet);
    ajax.setVar("speedfactor", 1000);
    ajax.setVar("planettype", planettype);
    ajax.setVar("z_gali", 1);
    if(order==2)
    ajax.setVar("ship210", shipcount);
    if(order==8)
    ajax.setVar("ship209", shipcount);
    
    ajax.setVar("speed", 10);
    //ajax.setVar("reply", "short");
    ajax.runAJAX();

}

/*
 * This function will manage the table we use to output up to three lines of
 * actions the user did. If there is no action, the tr with id 'fleetstatusrow'
 * will be hidden (display: none;) - if we want to output a line, its display 
 * value is cleaned and therefore its visible. If there are more than 2 lines 
 * we want to remove the first row to restrict the history to not more than 
 * 3 entries. After using the object function of the table we fill the newly
 * created row with text. Let the browser do the parsing work. :D
 */
function addToTable(strDataResult, strClass) {
  var e = document.getElementById('fleetstatusrow');
  var e2 = document.getElementById('fleetstatustable');

  // make the table row visible
  e.style.display = '';
  
  if(e2.rows.length > 2) {
    e2.deleteRow(2);
  }
  
  var row = e2.insertRow('test');

  var td1 = document.createElement("td");
  var td1text = document.createTextNode(strInfo);
  td1.appendChild(td1text);

  var td2 = document.createElement("td");

  var span = document.createElement("span");
  var spantext = document.createTextNode(strDataResult);

  var spanclass = document.createAttribute("class");
  spanclass.nodeValue = strClass;
  span.setAttributeNode(spanclass);

  span.appendChild(spantext);
  td2.appendChild(span);
  
  row.appendChild(td1);
  row.appendChild(td2);
}

function changeSlots(slotsInUse) {
  var e = document.getElementById('slots');
  e.innerHTML = slotsInUse;
}

function setShips(ship, count) {
  var e = document.getElementById(ship);
  e.innerHTML = count;
}

</script>

<script language=\"JavaScript\">
function galaxy_submit(value) {
	document.getElementById('auto').name = value;
	document.getElementById('galaxy_form').submit();
}

function fenster(target_url,win_name) {
	var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=640,height=480,top=0,left=0');
	new_win.focus();
}
</script>

<script language=\"JavaScript\" src=\"scripts/tw-sack.js\"></script>

<script type=\"text/javascript\">
var ajax = new sack();
var strInfo = \"\";

function whenResponse () {
	retVals   = this.response.split(\"|\");
	Message   = retVals[0];
	Infos     = retVals[1];
	retVals   = Infos.split(\" \");
	UsedSlots = retVals[0];
	SpyProbes = retVals[1];
	Recyclers = retVals[2];
	Missiles  = retVals[3];
	retVals   = Message.split(\";\");
	CmdCode   = retVals[0];
	strInfo   = retVals[1];
	addToTable(\"done\", \"success\");
	changeSlots( UsedSlots );
	setShips(\"probes\", SpyProbes );
	setShips(\"recyclers\", Recyclers );
	setShips(\"missiles\", Missiles );
}

function doit (order, galaxy, system, planet, planettype, shipcount) {
	ajax.requestFile = \"flotenajax.php?action=send\";
	ajax.runResponse = whenResponse;
	ajax.execute = true;
	ajax.setVar(\"thisgalaxy\", ". $CurrentPlanet["galaxy"] .");
	ajax.setVar(\"thissystem\", ". $CurrentPlanet["system"] .");
	ajax.setVar(\"thisplanet\", ". $CurrentPlanet["planet"] .");
	ajax.setVar(\"thisplanettype\", ". $CurrentPlanet["planet_type"] .");
	ajax.setVar(\"mission\", order);
	ajax.setVar(\"galaxy\", galaxy);
	ajax.setVar(\"system\", system);
	ajax.setVar(\"planet\", planet);
	ajax.setVar(\"planettype\", planettype);
	if (order == 6)
		ajax.setVar(\"ship210\", shipcount);
	if (order == 7) {
		ajax.setVar(\"ship208\", 1);
		ajax.setVar(\"ship203\", 2);
	}
	if (order == 8)
		ajax.setVar(\"ship209\", shipcount);
	ajax.runAJAX();
}

function addToTable(strDataResult, strClass) {
	var e = document.getElementById('fleetstatusrow');
	var e2 = document.getElementById('fleetstatustable');
	e.style.display = '';
	if(e2.rows.length > 2) {
		e2.deleteRow(2);
	}
	var row = e2.insertRow(0);
	var td1 = document.createElement(\"td\");
	var td1text = document.createTextNode(strInfo);
	td1.appendChild(td1text);
	var td2 = document.createElement(\"td\");
	var span = document.createElement(\"span\");
	var spantext = document.createTextNode(strDataResult);
	var spanclass = document.createAttribute(\"class\");
	spanclass.nodeValue = strClass;
	span.setAttributeNode(spanclass);
	span.appendChild(spantext);
	td2.appendChild(span);
	row.appendChild(td1);
	row.appendChild(td2);
}

function changeSlots(slotsInUse) {
	var e = document.getElementById('slots');
	e.innerHTML = slotsInUse;
}

function setShips(ship, count) {
	var e = document.getElementById(ship);
	e.innerHTML = count;
}

</script>
