<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<title>{title}</title>
	<!-- Load new function - not skin specific -->
	<link rel='stylesheet' type='text/css' href='./css/madnessred.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='./css/ibox.css' media='screen' />
	<script type='text/javascript' src='./scripts/display.js'></script>
	<script type='text/javascript' src='./scripts/ibox.js'></script>
    <script type="text/javascript">iBox.setPath('./');</script>

	<!-- XNova Skins - CSS's --><!--
	<link rel='stylesheet' type='text/css' href='{skin}css/boxes.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/info.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/menu.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/buildings.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/forms.css' media='screen' />-->

	<!-- OGame Skins - CSS's -->
	<link rel='stylesheet' type='text/css' href='{skin}css/01style.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/research.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/fleet.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/shipyard.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/defense.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/station.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/movement.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/empire.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/statistics.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/network.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/resources.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/trader.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/galaxy.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/changelog.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/tooltip.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/toolbox.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/thickbox.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/techtree.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/jquery.cluetip.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/tutorial.css' media='screen' />
	<link rel='stylesheet' type='text/css' href='{skin}css/eventList.css' media='screen' />

	<link rel='stylesheet' type='text/css' href='{skin}css/styles.css' media='screen' />

	<!--[if lt IE 7]>
	<link href="{skin}css/iefixes.css" rel="stylesheet" type="text/css" media="screen">
	<![endif]-->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<script type='text/javascript' src='scripts/overlib.js'></script>
	<script type='text/javascript' src='scripts/axah.js'></script>
	<script type='text/javascript' src='scripts/php.js'></script>
	<script type="text/javascript" src="scripts/cntchar.js"></script>
	<script type="text/javascript" src="scripts/sorttable.js"></script>
	<script type="text/javascript" language="JavaScript">
	<!--
	function HideContent(d) {
		document.getElementById(d).style.display = "none";
	}
	function ShowContent(d) {
		document.getElementById(d).style.display = "block";
	}
	function ReverseDisplay(d) {
		if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; }
		else { document.getElementById(d).style.display = "none"; }
	}
	function FlickDisplay(d,t) {
		if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = t; }
		else { document.getElementById(d).style.display = "none"; }
	}
	function update(ntitle,pageid){
		document.title = ntitle;
		document.body.id = pageid;
	}
	function max_input(id,max){
		if(document.getElementById(id).value > max){
			document.getElementById(id).value = max;
		}
	}
	function max_input(id,max){
		if(document.getElementById(id).value > max){
			document.getElementById(id).value = max;
		}
	}
	function SwapClass(id,a,b){
		if(document.getElementById(id).className == a){
			document.getElementById(id).className = b;
		}else{
			document.getElementById(id).className = a;
		}
	}
	function tickAll(f){ for (n = 0; n < f.length; n++){ f[n].checked = false; } }
	function tickNone(f){ for (n = 0; n < f.length; n++){ f[n].checked = true; } }
	function likenAll(f,id){
		if(document.getElementById(id).checked == true){ tickNone(f); }
		else{ tickAll(f); }
	}


	function pretty_number(val){
		//note, must be an integer.
		return Comma(val);
	}
	function Comma(SS) {
	    var T = "", S = String(SS), L = S.length - 1, C, j;
	    for (j = 0; j <= L; j++) {
	        T += C = S.charAt(j);
	        if (j < L && (L - j) % 3 == 0 && (C != "-")) {
	            T += ",";
	        }
	    }
	    return T;
	}
	function KMnumber(number){	//MadnessRed function
		if(number >= 10000000)	{
			number = (number / 1000000);
			var use = 'M';
		}else if(number >= 10000){
			number = (number / 1000);
			var use = 'K';
		}else{
			var use = '';
		}
	
		return pretty_number(Math.round(number)) + use;
	}
	function colour_number(n,c){	//MadnessRed function
		if(c == 1){
			return "<font color=\"red\">"+n+"</font>";
		}else if(c == 2){
			return "<font color=\"lime\">"+n+"</font>";
		}else{
			return n;
		}
	}
	//-->
	</script>

</head>
