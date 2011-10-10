{BuildListScript}


<!-- CONTENT AREA -->

<div id="inhalt">

<!-- now the fun starts -->


{info}
<div id="planet" style="background-image:url({bg});" {extra}>
	<h2>Buildings</h2>
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


	{BuildingsList}


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