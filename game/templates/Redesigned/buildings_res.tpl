{BuildListScript}


<!-- CONTENT AREA -->

<div id="inhalt">
	{resources_section}
<!-- now the fun starts -->

<!-- Start of resources info -->
	<!--
	<div id="planet" style="display:block;background-image:url({bg});{hideres}">
		<a class="close_details" href="?page=resources">
			X
		</a>
		<div id="header_text">
            <h2>Resource settings on planet "Homeworld"</h2>
        </div>

		<p>
			<blockquote style="margin-left: 15px; margin-right: 15px; filter:alpha(opacity=75); -moz-opacity:.75; opacity:.75; background-color: #000000;">
				<div style="margin-left: 10px; margin-right: 10px; z-index: 50;">
					
				</div>
			</blockquote>
		</p>

		<br class="clearfloat" />
	</div>
	-->
<!-- End of resources info -->
<div id="planet" style="background-image:url({bg});" {extra}>
	{info}
	<h2>Buildings</h2>
        <div id="slot01" class="slot">
            <a class="thickbox" href="?page=resources&amp;mode=resources">Resource settings</a>
         </div>
	<!--
	<table cellpadding="0" cellspacing="0" id="planetdata">
		<tr>
			<td class="date" colspan="2">
	-->
	<p>
		{gebaeude_inf2}
	</p>
	<!--
			</td>
		</tr>
	</table>
	-->
</div>		<div class="c-left"></div>
<div class="c-right"></div>

{buttonz}

<div class="content-box-s">
	<div class="header"><h3>Buildings</h3></div>

	<div class="content">
		<table cellpadding="0" cellspacing="0" class="construction" width="100%" height="100%">
			<tr>
				{BuildList}
				<!--
				<td>
					<script language="JavaScript">
					TargetDate = "12/31/2008 16:00:12";
					BackColor = "transparent";
					ForeColor = "white";
					CountActive = true;
					CountStepper = -1;
					LeadingZero = true;
					DisplayFormat = "%%D%%d %%H%%h %%M%%m %%S%%s";
					FinishMessage = "It is finally here!";
					</script>
					<script language="JavaScript" src="../scripts/countdown.js"></script>
				</td>
				-->
			</tr>
		</table>
	</div>

	<div class="footer"></div>
</div>
			
<div class="clearfloat"></div>
</div>   

<!-- END CONTENT AREA -->



<!-- Old File -->
<!--
<center>
<br />
{BuildListScript}
<table width=530>
	{BuildList}
	<tr>
		<th >{bld_usedcells}</th>
		<th colspan="2" >
			<font color="#00FF00">{planet_field_current}</font> / <font color="#FF0000">{planet_field_max}</font> {bld_theyare} {field_libre} {bld_cellfree}
		</th >
	</tr>
	{BuildingsList}
</table>
<br />
</center>
-->
