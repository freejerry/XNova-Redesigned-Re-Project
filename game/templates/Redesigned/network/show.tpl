<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link href="{{skin}}/css/toolbox.css" rel="stylesheet" type="text/css" media="screen">
	<link href="{{skin}}/css/thickbox-message.css" rel="stylesheet" type="text/css" media="screen">
	<link href="{{skin}}/css/thickbox-iframe.css" rel="stylesheet" type="text/css" media="screen">
	<link href="{{skin}}/css/jquery.cluetip.css" rel="stylesheet" type="text/css" media="screen">
	
	<script type='text/javascript' src='scripts/axah.js'></script>
</head>
<body id="showmessage">
<script type="text/javascript" src="./scripts/wz_tooltip.js"></script>
<div id="messagebox" class="read">
	<div id="wrapper">

	<div id="contentPageNavi"  class="textCenter">
		<a class="closeTB" onclick="window.parent.mrbox_close();">
			<img src="{{skin}}/img/layout/pixel.gif" width="16" height="16" />
		</a>	   
			<a style="margin-right:10px; text-decoration: none;" href="{nextlink}">
			<img alt="" src="{{skin}}/img/icons/rewind.gif" height="16" width="16" style="vertical-align:middle" />
		</a>&nbsp;
		<strong>{num}</strong> of <strong>{count}</strong>&nbsp;

		<a style="margin-left:10px; text-decoration: none;" href="{prevlink}">
			<img alt="" src="{{skin}}/img/icons/fastforward.gif" height="16" width="16" style="vertical-align:middle" />
		</a>
		</div>
		<div class="infohead">
			<table cellspacing="2" cellpadding="0">
					<tr>
						<th scope="row">From:</th>
						<td>{from}</td>
					</tr>
					<tr>
						<th scope="row">To:</th>
						<td>{username}</td>
					</tr>
					<tr>

						<th scope="row">Subject:</th>
						<td>{subject}</td>
					</tr>
					<tr>
						<th scope="row">Date:</th>
						<td>{date}</td>
					</tr>

			  </table>
		</div>
		<div class="showMsgNavi">
			<ul class="toolbar">
				<li class="delete">
					<a href="#" id="2" class="tips2 action" onmouseover="mrtooltip('Delete this message')">Delete</a>
				</li>
				<li class="reply">
					<a {l_reply} class="tips2" onmouseover="mrtooltip('Answer this message')">Reply</a>
				</li>
				<li class="notify">
					<a href="./?page=ticket&t=Issue with message: {id}" target="_parent" id="melden" class="tips2" onmouseover="mrtooltip('Report this message to a game operator')">Report</a>
				</li>
	
			</ul>
			<div class="clearfloat"></div>
		</div>
		<div class="textWrapper">
			
		<div class="note">
			<p>{message}</p>
			<br />
		</div>
 
		</div>
	</div>
</div>
</body>
</html>