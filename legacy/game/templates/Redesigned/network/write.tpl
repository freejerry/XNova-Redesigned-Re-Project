<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  	<link href="{{skin}}/css/thickbox-message.css" rel="stylesheet" type="text/css" media="screen">
  	<link href="{{skin}}/css/toolbox.css" rel="stylesheet" type="text/css" media="screen">
	<link href="{{skin}}/css/thickbox-iframe.css" rel="stylesheet" type="text/css" media="screen">
	<link href="{{skin}}/css/jquery.cluetip.css" rel="stylesheet" type="text/css" media="screen">	
	
	<script type='text/javascript' src='scripts/axah.js'></script>
	<script src="scripts/cntchar.js" type="text/javascript"></script>
</head>
<body id="writemessage">
<div id="messagebox" class="write">
	<div id="wrapper">
	
		<a class="closeTB" onclick="window.parent.mrbox_close();"><img src="{{skin}}/img/layout/pixel.gif" width="16" height="16" /></a>
		
		<div id="mess_content">
			<form action="./?page=messages" method="GET" id="send_message">
				<input type="hidden" name="mode" value="write" />		
				<div class="infohead">
					<table cellspacing="2">
						<tr>
							<th scope="row">From:</th>
							<td>{{user}}</td>
						</tr>
						<tr>
							<th scope="row">To:</th>
							<td>
								{username} 
								<a target="_parent" href="./?page=galaxy&galaxy={galaxy}&system={system}">
									[{galaxy}:{system}:{planet}]
								</a>
								<input type="hidden" name="id" value="{id}" />
							</td>
						</tr>
						<tr>
							<th scope="row">Subject:</th>
							<td><input type="text" name="subject" tabindex="2" maxlength="30" class="textinput" value="{subject}" /></td>
						</tr>
						<tr>
							<th scope="row">Date:</th>
							<td>{date}</td>
						</tr>
					</table>
				</div>
		
				<div class="textWrapper">
					<div class="note">
						<textarea tabindex="3" name="text" class="mailnew" onkeyup="javascript:cntchar(5000)"></textarea>
				   </div> 
				</div>
				<div class="fleft count textBeefy">
					Message (<span id="cntChars">0</span> / 5000 Characters)
				</div>
		
				<div class="fleft buttonbox">
					<input tabindex="4" type="button" class="button188" value="send" onclick="getAXAH(form2get('send_message')+'&axah=true','mess_content');" />
				</div>
			</form>
		</div>
	</div>
	
</div>
</body>
</html>