//---------------------------------+
//  CARPE                     0.2  |
//  2007 - 02 - 26                 |
//  By Tom Hermansson Snickars     |
//  Copyright CARPE Design         |
//  http://carpe.ambiprospect.com/ |
//  Contact for custom scripts     |
//  or implementation help.        |
//---------------------------------+

// 
var CARPE = {
	version: '0.1',
	KEY_LEFT: 37,
	KEY_UP: 38,
	KEY_RIGHT: 39,
	KEY_DOWN: 40,
	bind: function(obj) {
		var method = this,
		temp = function() {
			return method.apply(obj, arguments);
		};
	return temp;
	},
	// getElementsByClass: Cross-browser function that returns
	// an array with all elements that have a class attribute that
	// contains className
	getElementsByClass: function(className) {
		var classElements = [];
		var els = document.getElementsByTagName("*");
		var pattern = new RegExp("(^|\\s)" + className + "(\\s|$)"); //   "\\s" + className + "\\s")
		for (var i = 0, j = 0; i < els.length; i++) {
			if (pattern.test(els[i].className) ) {
				classElements[j] = els[i];
				j++;
			}
		}
		return classElements;
	},
	// left: Cross-browser version of "element.style.left"
	// Returns or sets the horizontal position of an element.
	left: function(elmnt, pos) {
		if (!(elmnt = document.getElementById(elmnt))) {
			return 0;
		}
		if (elmnt.style && (typeof(elmnt.style.left) == 'string')) {
			if (typeof(pos) == 'number') {
				elmnt.style.left = pos + 'px';
			}
			else {
				pos = parseInt(elmnt.style.left, 10);
				if (isNaN(pos)) {
					pos = 0;
				}
			}
		}
		else if (elmnt.style && elmnt.style.pixelLeft) {
			if (typeof(pos) == 'number') { elmnt.style.pixelLeft = pos; }
			else { pos = elmnt.style.pixelLeft; }
		}
		return pos;
	},
	// carpeTop: Cross-browser version of "element.style.top"
	// Returns or sets the vertical position of an element.
	top: function(elmnt, pos) {
		if (!(elmnt = document.getElementById(elmnt))) {
			return 0;
		}
		if (elmnt.style && (typeof(elmnt.style.top) == 'string')) {
			if (typeof(pos) == 'number') {
				elmnt.style.top = pos + 'px';
			}
			else {
				pos = parseInt(elmnt.style.top, 10);
				if (isNaN(pos)) {
					pos = 0;
				}
			}
		}
		else if (elmnt.style && elmnt.style.pixelTop) {
			if (typeof(pos) == 'number') {
				elmnt.style.pixelTop = pos;
			}
			else {
				pos = elmnt.style.pixelTop;
			}
		}
		return pos;
	},
	getPos: function (obj) {
		var curleft = 0;
		var curtop = 0;
		if (obj.offsetParent) {
			curleft = obj.offsetLeft;
			curtop = obj.offsetTop;
			while ((obj = obj.offsetParent)) {
				curleft += obj.offsetLeft;
				curtop += obj.offsetTop;
			}
		}
		return { x: curleft, y: curtop };
	},
	getStyle: function(element, style) { // Modified from Prototype 1.5
		style = CARPE.camelize(style);
		var value = element.style[style];
		if (!value) {
			if (document.defaultView && document.defaultView.getComputedStyle) {
				var css = document.defaultView.getComputedStyle(element, null);
				value = css ? css[style] : null;
			} else if (element.currentStyle) {
				value = element.currentStyle[style];
			}
		}
		return value;
	},
	camelize: function(s) {
		var parts = s.split('-');
		if (parts.length == 1) return parts[0];
		var camel = parts[0];
		var len = parts.length;
		for (var i = 1; i < len; i++) {
			camel += parts[i].charAt(0).toUpperCase() + parts[i].substring(1);
		}
	    return camel;
	},
	stopEvent: function(e) {
		if (e.preventDefault) {
			e.preventDefault();
			e.stopPropagation();
		}
		else {
			e.returnValue = false;
			e.cancelBubble = true;
		}
	},
	addLoadEvent: function(func) {
		var old = window.onload;
		if (typeof window.onload != 'function') {
			window.onload = func;
		}
		else {
			window.onload = function() {
				if (old) {
					old()
				}
				func();
			};
		}
	},
	addEventListener: function(elmnt, evnt, func) {
		if (elmnt.addEventListener) {
			elmnt.addEventListener(evnt, func, false)
		}
		else if (elmnt.attachEvent) {
			elmnt.attachEvent('on' + evnt, func);
		} else return false;
	},
	removeEventListener: function(elmnt, evnt, func) {
		if (elmnt.removeEventListener) { // Remove event listeners from element (W3C).
			elmnt.removeEventListener(evnt, func, false);
			elmnt.removeEventListener(evnt, func, false);
		}
		else if (elmnt.detachEvent) { // Remove event listeners from element (IE).
			elmnt.detachEvent('on' + evnt, func);
			elmnt.detachEvent('on' + evnt, func);
		}
		return;
	},
	listObj: function(o) {
		var s = '';
		for (i in o) {
			s = s + i + ': ' + o.toString() + ',';
		}
		alert(s);
	}
};

Function.prototype.bind = CARPE.bind;

/*function(obj) {
		var method = this,
		temp = function() {
			return method.apply(obj, arguments);
		};
	return temp;
	};


function sliderSetUp() // Set up the sliders and the displays.
{
	sliders = carpeGetElementsByClass(carpeSliderClassName) // Find the horizontal sliders.
	for (i = 0; i < sliders.length; i++) {
		sliders[i].onmousedown = slide; // Attach event listener.
	}
	displays = carpeGetElementsByClass(carpeSliderDisplayClassName) // Find the displays.
	for (i = 0; i < displays.length; i++) {
		displays[i].onfocus = focusDisplay; // Attach event listener.
	}
}

*/






//---------------------------------+
//  CARPE  S l i d e r      1.5.1  |
//  2008 - 07 - 09                 |
//  By Tom Hermansson Snickars     |
//  Copyright CARPE Design         |
//  http://carpe.ambiprospect.com/ |
//---------------------------------+

// Global vars. You don't need to make changes here to change your sliders.
// Changing the attributes in your (X)HTML file is enough.
var carpemouseover                = false;
var carpeDefaultSliderLength      = 100;
var carpeSliderDefaultOrientation = 'horizontal';
var carpeSliderClassName          = 'carpe_slider';
var carpeSliderDisplayClassName   = 'carpe_slider_display';
var carpesliders                  = [];
var carpedisplays                 = [];
var carpeslider                   = {};
var carpedisplay                  = {};

// carpeAddLoadEvent
function carpeAddLoadEvent(func)
{
		var oldonload = window.onload;
		if (typeof window.onload != 'function') {
			window.onload = func;
		}
		else {
			window.onload = function() {
				oldonload();
				func();
			};
		}
}
// carpeGetElementsByClass: Cross-browser function that returns
// an array with all elements that have a class attribute that
// contains className
function carpeGetElementsByClass(className)
{
	var classElements = new Array();
	var els = document.getElementsByTagName("*");
	var elsLen = els.length;
	var pattern = new RegExp("\\b" + className + "\\b");
	for (var i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}
// carpeLeft: Cross-browser version of "element.style.left"
// Returns or sets the horizontal position of an element.
function carpeLeft(elmnt, pos)
{
	if (!(elmnt = document.getElementById(elmnt))) return 0;
	if (elmnt.style && (typeof(elmnt.style.left) == 'string')) {
		if (typeof(pos) == 'number') elmnt.style.left = pos + 'px';
		else {
			pos = parseInt(elmnt.style.left);
			if (isNaN(pos)) pos = 0;
		}
	}
	else if (elmnt.style && elmnt.style.pixelLeft) {
		if (typeof(pos) == 'number') elmnt.style.pixelLeft = pos;
		else pos = elmnt.style.pixelLeft;
	}
	return pos;
}
// carpeTop: Cross-browser version of "element.style.top"
// Returns or sets the vertical position of an element.
function carpeTop(elmnt, pos)
{
	if (!(elmnt = document.getElementById(elmnt))) return 0;
	if (elmnt.style && (typeof(elmnt.style.top) == 'string')) {
		if (typeof(pos) == 'number') elmnt.style.top = pos + 'px';
		else {
			pos = parseInt(elmnt.style.top);
			if (isNaN(pos)) pos = 0;
		}
	}
	else if (elmnt.style && elmnt.style.pixelTop) {
		if (typeof(pos) == 'number') elmnt.style.pixelTop = pos;
		else pos = elmnt.style.pixelTop;
	}
	return pos;
}
// moveSlider: Handles slider and display while dragging
function moveSlider(evnt)
{
	var evnt = (!evnt) ? window.event : evnt; // The mousemove event
	if (carpemouseover) { // Only if slider is dragged
		carpeslider.x = carpeslider.startOffsetX + evnt.screenX; // Horizontal mouse position relative to allowed slider positions
		carpeslider.y = carpeslider.startOffsetY + evnt.screenY; // Horizontal mouse position relative to allowed slider positions
		if (carpeslider.x > carpeslider.xMax) carpeslider.x = carpeslider.xMax; // Limit horizontal movement
		if (carpeslider.x < 0) carpeslider.x = 0; // Limit horizontal movement
		if (carpeslider.y > carpeslider.yMax) carpeslider.y = carpeslider.yMax; // Limit vertical movement
		if (carpeslider.y < 0) carpeslider.y = 0; // Limit vertical movement
		carpeLeft(carpeslider.id, carpeslider.x);  // move slider to new horizontal position
		carpeTop(carpeslider.id, carpeslider.y); // move slider to new vertical position
		var sliderVal = carpeslider.x + carpeslider.y; // pixel value of slider regardless of orientation
		var sliderPos = (carpeslider.distance / carpedisplay.valuecount) * 
			Math.round(carpedisplay.valuecount * sliderVal / carpeslider.distance);
		var v = Math.round((sliderPos * carpeslider.scale + carpeslider.from) * // calculate display value
			Math.pow(10, carpedisplay.decimals)) / Math.pow(10, carpedisplay.decimals);
		carpedisplay.value = v; // put the new value in the slider display element
		return false;
	}
	return
}
// slide: Handles the start of a slider move.
function slide(evnt)
{
	if (!evnt) evnt = window.event; // Get the mouse event causing the slider activation.
	carpeslider = (evnt.target) ? evnt.target : evnt.srcElement; // Get the activated slider element.
	var dist = parseInt(carpeslider.getAttribute('distance')); // The allowed slider movement in pixels.
	carpeslider.distance = dist ? dist : carpeDefaultSliderLength; // Deafault distance from global var.
	var ori = carpeslider.getAttribute('orientation'); // Slider orientation: 'horizontal' or 'vertical'.
	var orientation = ((ori == 'horizontal') || (ori == 'vertical')) ? ori : carpeSliderDefaultOrientation;
		// Default orientation from global variable.
	var displayId = carpeslider.getAttribute('display'); // ID of associated display element.
	carpedisplay = document.getElementById(displayId); // Get the associated display element.
	carpedisplay.sliderId = carpeslider.id; // Associate the display with the correct slider.
	var dec = parseInt(carpedisplay.getAttribute('decimals')); // Number of decimals to be displayed.
	carpedisplay.decimals = dec ? dec : 0; // Default number of decimals: 0.
	var val = parseInt(carpedisplay.getAttribute('valuecount'))  // Allowed number of values in the interval.
	carpedisplay.valuecount = val ? val : carpeslider.distance + 1 // Default number of values: the sliding distance.
	var from = parseFloat(carpedisplay.getAttribute('from')) // Min/start value for the display.
	from = from ? from : 0 // Default min/start value: 0.
	var to = parseFloat(carpedisplay.getAttribute('to')) // Max value for the display.
	to = to ? to : carpeslider.distance // Default number of values: the sliding distance.
	carpeslider.scale = (to - from) / carpeslider.distance // Slider-display scale [value-change per pixel of movement].
	if (orientation == 'vertical') { // Set limits and scale for vertical sliders.
		carpeslider.from = to // Invert for vertical sliders. "Higher is more."
		carpeslider.xMax = 0
		carpeslider.yMax = carpeslider.distance
		carpeslider.scale = -carpeslider.scale // Invert scale for vertical sliders. "Higher is more."
	}
	else { // Set limits for horizontal sliders.
		carpeslider.from = from;
		carpeslider.xMax = carpeslider.distance;
		carpeslider.yMax = 0;
	}
	carpeslider.startOffsetX = carpeLeft(carpeslider.id) - evnt.screenX; // Slider-mouse horizontal offset at start of slide.
	carpeslider.startOffsetY = carpeTop(carpeslider.id) - evnt.screenY; // Slider-mouse vertical offset at start of slide.
	carpemouseover = true;
	document.onmousemove = moveSlider; // Start the action if the mouse is dragged.
	document.onmouseup = sliderMouseUp; // Stop sliding.
	return false;
}
// sliderMouseUp: Handles the mouseup event after moving a slider.
// Snaps the slider position to allowed/displayed value. 
function sliderMouseUp()
{
	if (carpemouseover) {
		var v = (carpedisplay.value) ? carpedisplay.value : 0 // Find last display value.
		var pos = (v - carpeslider.from)/(carpeslider.scale) // Calculate slider position (regardless of orientation).
		if (carpeslider.yMax == 0) {
			pos = (pos > carpeslider.xMax) ? carpeslider.xMax : pos;
			pos = (pos < 0) ? 0 : pos;
			carpeLeft(carpeslider.id, pos); // Snap horizontal slider to corresponding display position.
		}
		if (carpeslider.xMax == 0) {
			pos = (pos > carpeslider.yMax) ? carpeslider.yMax : pos;
			pos = (pos < 0) ? 0 : pos;
			carpeTop(carpeslider.id, pos); // Snap vertical slider to corresponding display position.
		}
		if (document.removeEventListener) { // Remove event listeners from 'document' (W3C).
			document.removeEventListener('mousemove', moveSlider, false);
			document.removeEventListener('mouseup', sliderMouseUp, false);
		}
		else if (document.detachEvent) { // Remove event listeners from 'document' (IE).
			document.detachEvent('onmousemove', moveSlider);
			document.detachEvent('onmouseup', sliderMouseUp);
			document.releaseCapture();
		}
	}
	carpemouseover = false; // Stop the sliding.
}
function focusDisplay(evnt)
{
	if (!evnt) evnt = window.event; // Get the mouse event causing the display activation.
	var carpedisplay = (evnt.target) ? evnt.target : evnt.srcElement; // Get the activated display element.
	var lock = carpedisplay.getAttribute('typelock'); // Is the user allowed to type into the display?
	if (lock == 'on') {
		carpedisplay.blur();
	}
	return;
}
function carpeInit() // Set up the sliders and the displays.
{
	carpesliders = carpeGetElementsByClass(carpeSliderClassName) // Find the horizontal sliders.
	for (var i = 0; i < carpesliders.length; i++) {
		carpesliders[i].onmousedown = slide; // Attach event listener.
	}
	carpedisplays = carpeGetElementsByClass(carpeSliderDisplayClassName) // Find the displays.
	for (var i = 0; i < carpedisplays.length; i++) {
		carpedisplays[i].value = carpedisplays[i].defaultValue; // Resets display on page reload.
		carpedisplays[i].onfocus = focusDisplay; // Attach event listener.
	}
}
carpeAddLoadEvent(carpeInit);
