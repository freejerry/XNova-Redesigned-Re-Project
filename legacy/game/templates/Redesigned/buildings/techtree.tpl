<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{Techinfo}</title>
	  
<link rel='stylesheet' type='text/css' href='{{skin}}/css/techtree.css' media='screen' />
<link rel='stylesheet' type='text/css' href='{{skin}}/css/jquery.cluetip.css' media='screen' />
<link rel='stylesheet' type='text/css' href='../css/madnessred.css' media='screen' />
<link rel='stylesheet' type='text/css' href='{{skin}}/css/madnessred.css' media='screen' />
 
<!--[if lt IE 7]>
	<link href="css/iefixes.css" rel="stylesheet" type="text/css" media="screen">  
<![endif]-->
</head>

<body id="techtree">

<div id="techtreenew">
	<h2 id="title">{Techtree} - {ElementName}</h2>
	<ul class="subsection_tabs">
		<li style="margin-left:5px;"><a href="#" id="tree" class="active"><span>{Techtree}</span></a></li>
		<li><a href="#" id="info" class=""><span>{Techinfo}</span></a></li>
		<br class="clearfloat" />		
	</ul>
	
	<div id="t_info" style="display:none;"></div>
		
	<div id="t_tree" style="display:block;">
		{tree}
	</div>
</div>

<!--
<script type='text/javascript' src='http://uni42.ogame.org/game/js/red-4-1_jquery-1.2.6.min.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/red-4-1_jquery.dimensions.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/red-4-1_jquery.hoverIntent.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/red-4-1_jquery.cluetip.js'></script>
<script type='text/javascript' src='http://uni42.ogame.org/game/js/red-4-1_jquery.configcluetip.js'></script>

<script type="text/javascript">
status=0;$("a#tree").click(function()
{if(status==0)
{$.get("index.php?page=techtree&session=a123f4c82cac&techID=12&site=2",function(text){$("#t_tree").css("display","block").html(text);$("#t_info").css("display","none");status=1;});}
else
{$("#t_info").css("display","none");$("#t_tree").css("display","block");}
$("a#info").toggleClass("active");$("a#tree").toggleClass("active");$("#title").html("Techtree - Fusion Reactor");return false;});$("a#info").click(function()
{if(status==0)
{$.get("index.php?page=get_techinfo&session=a123f4c82cac&techID=12&site=2",function(text){$("#t_info").css("display","block").html(text);$("#t_tree").css("display","none");status=1;});}
else
{$("#t_info").css("display","block");$("#t_tree").css("display","none");}
$("a#tree").toggleClass("active");$("a#info").toggleClass("active");$("#title").html("Techinfo on - Fusion Reactor");return false;});$(document).ready(function(){initCluetip();});
</script>
-->
</body>

</html>