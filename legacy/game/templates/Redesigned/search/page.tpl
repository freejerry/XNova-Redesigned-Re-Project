<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{{skin}}/css/network.css" rel="stylesheet" type="text/css" media="screen"> 
<link href="{{skin}}/css/toolbox.css" rel="stylesheet" type="text/css" media="screen">        
<link href="{{skin}}/css/thickbox-message.css" rel="stylesheet" type="text/css" media="screen">
<link href="{{skin}}/css/thickbox-iframe.css" rel="stylesheet" type="text/css" media="screen">
<link href="{{skin}}/css/jquery.cluetip.css" rel="stylesheet" type="text/css" media="screen">  
<link href="{{skin}}/css/errorbox.css" rel="stylesheet" type="text/css" media="screen"> 
<link href="{{skin}}/css/jquery.cluetip.css" rel="stylesheet" type="text/css" media="screen">
<script type='text/javascript' src='scripts/axah.js'></script>
<script type="text/javascript" language="JavaScript">  
	function dosearch(term){
		getAXAH('./?page=cerca&term='+term,'ajaxContent');
		litoselected('1');
	}
	function litoselected(n){
		document.getElementById('li1').className = '';
		document.getElementById('li2').className = '';
		document.getElementById('li3').className = '';
		document.getElementById('li'+n).className = 'ui-tabs-selected';
	}
	function HideContent(d) {
		document.getElementById(d).style.display = "none";
	}
	function ShowContent(d) {
		document.getElementById(d).style.display = "block";
	}
</script>
</head>

<body id="buddies" class="searchLayer">
<script type="text/javascript" src="./scripts/wz_tooltip.js"></script>
<div id="messagebox">

	<h2>{title}</h2>
	<a onclick="self.parent.mrbox_close();" class="closeTB">
		<img width="16" height="16" src="{{skin}}/img/layout/pixel.gif"/>
	</a>        
	<div id="netz">
		<div id="message">
			<div id="inhalt">  
			
			<div class="c-left"></div>
			<div class="c-right"></div>

			<br class="clearfloat"/>
			
			<div id="vier" style="display:block;">
			
				<div class="sectioncontent" id="section41" style="display:block; overflow:hidden;">
					<div class="contentz">
						<div id="search">
							<table cellpadding="0" cellspacing="0" class="searchall">
								<tr>
	                                <td class="textCenter" style="padding-bottom:10px;">{enter_term}</td>

								</tr>
								<tr>
									<td class="ptb10 textCenter">
										<input name="searchtext" class="textInput" id="searchterm" value="" style="padding: 4px; size: 200px;" type="text"> 
										<input value="Search" name="search" class="buttonSave" onclick="dosearch(document.getElementById('searchterm').value); return false;" type="button">
									</td>
								</tr>
							</table>
							<div class="h10"></div>

						</div>
							
						<div class="searchTabs" style="display:block; padding-top:0px;">  
							<ul class="subsection_tabs" id="tabs_example_one" style="bottom: 0px;">
								<li class="ui-tabs-selected" id="li1">
									<a href="#" onclick="ShowContent('player_results');
										HideContent('planet_results');
										HideContent('alliance_results');
										litoselected('1');" class="tab" id="1">
										<span>{users}</span>

									</a>
								</li>
								<li class="" id="li2">
									<a href="#" onclick="HideContent('player_results');
										ShowContent('planet_results');
										HideContent('alliance_results');
										litoselected('2');" class="tab" id="2">
										<span>{planets}</span>
									</a>
								</li>
								<li class="" id="li3">

									<a href="#" onclick="HideContent('player_results');
										HideContent('planet_results');
										ShowContent('alliance_results');
										litoselected('3');" class="tab" id="3">
										<span>{allys}</span>
								</a>
								</li>
							</ul>

							
							<div id="ajaxContent" style="overflow: auto;">
								<div id="player_results">
									<br />
									<p class="textCenter">{no_term}</p>
								</div>
								<div id="planet_results" style="display:none;">
									<br />
									<p class="textCenter">{no_term}</p>
								</div>
								<div id="alliance_results" style="display:none;">
									<br />
									<p class="textCenter">{no_term}</p>
								</div>
							</div>
							
						</div> 
							<div class="h10"></div>     
						</div>
				</div>
			</div>     
		</div>
	</div>
</div>
</body>
</html>