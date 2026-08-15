<!-- CONTENT AREA -->
<div id="inhalt">
<div style="background-image: url({{skin}}/img/header/network/allianz_header.jpg); z-index: 50;" id="planet">
	<h2>{supp_header}</h2> 	
</div>
<div class="c-left"></div>
<div class="c-right"></div>

<div class="boxWrapper">
	<div class="header">
		<h3 class="textCenter textBeefy"><span style="text-align:center;">{supp_header}</span></h3>
	</div>
	<div class="content">
		<table width="100%">
			<tr>
				<td width="15%">{ticket_id}</td>
				<td width="50%">{subject}</td>
				<td width="10%">{status}</td>
				<td width="25%">{ticket_posted}</td>
			</tr>
				{tickets}
		</table>
		
		<br /><br />
		
		<form action="./?page=ticket&ticket=99999999999999999999999999&sendenticket=1" method="POST">
		<table width="100%">
			<tr>
				<th colspan="2" width="100%"><center>{ticket_new}</center><br /></th>
			</tr>
			<tr>
				<th colspan="2">
					{subject}:
					<input type="text" name="senden_ticket_subject" size="50" value="{gett}" class="textInput" style="height:16px;"><br /><center>{ticket_desc}</center><br /><br />
					{input_text}
					<textarea name="senden_ticket_text" class="textBox" rows="30" cols="20" onFocus="this.value=''; this.onfocus=null;">{startext}</textarea>
					<center><input class="button188" type="submit" name="send" value="{send}"></center>
				</th>
			</tr>
		</table>
	</div>
	<div class="footer"></div>    
</div><!-- boxWrapper -->
</div><!-- Inhalt --><!-- END CONTENT AREA -->