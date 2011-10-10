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
				<td colspan="4" class="c" width="50%"><center>{supp_header}</center></td>
			</tr>
			<tr>
				<td class="c" width="15%">{ticket_id}</td>
				<td class="c" width="50%">{subject}</td>
				<td class="c" width="10%">{status}</td>
				<td class="c" width="25%">{ticket_posted}</td>
			</tr>
			{tickets}
		</table>
		<br /><br />
		<table width="100%">
			<tr>
				<th><center>{text}</center></th>
			</tr>
			<tr>
				<td><center>{text_view}</center></td>
			</tr>
		</table>
		<br /><br />
		<table width="100%">
			<tr>
				<th colspan="2">
					<center>{answer_new}</center>
					<form action="./?page={actionpage}&ticket={id}&sendenantwort=1" method="POST">
						<input type="hidden" name="senden_antwort_id" value="{id}">
						{eintrag}
					</form>
				</th>
			</tr>
		</table>
		
	</div>
	<div class="footer"></div>    
</div><!-- boxWrapper -->
</div><!-- Inhalt --><!-- END CONTENT AREA -->


