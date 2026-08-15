<script type="text/javascript" >
function calcul() {
	var Metal   = document.forms['marchand'].elements['metal'].value;
	var Cristal = document.forms['marchand'].elements['cristal'].value;

	Metal   = Metal * {mod_ma_res_a};
	Cristal = Cristal * {mod_ma_res_b};

	var Deuterium = Metal + Cristal;
	document.getElementById("deut").innerHTML=Deuterium;

	if (isNaN(document.forms['marchand'].elements['metal'].value)) {
		document.getElementById("deut").innerHTML="{mod_ma_nbre}";
	}
	if (isNaN(document.forms['marchand'].elements['cristal'].value)) {
		document.getElementById("deut").innerHTML="{mod_ma_nbre}";
	}
}
</script>

<!-- CONTENT AREA -->

<div id="inhalt">

<!-- now the fun starts -->

<div id="planet" style="background-image:url({{skin}}/img/header/trader/handel_header.jpg); height:250px;">
	<h2>{Marchand} - {planet}</h2>
	<table cellpadding="0" cellspacing="0" id="planetdata">
		<tr>
			<td class="date" colspan="2">
				  	<!--Some stuff can go here.-->
			</td>
		</tr>
	</table>
</div>		<div class="c-left" style="top:214px;"></div>
<div class="c-right" style="top:214px;"></div>

<div id="buttonz">
	<h3>Call a trader who buys deuterium:</h3>
	
	<div style="position:relative; height:80px">
	
	<center>
	<form id="marchand" action="./?page=trader" method="post">
	<input type="hidden" name="ress" value="deuterium">
	<table width="100%">
	<tr>
		<th>{mod_ma_resource}</th>
		<th>{mod_ma_ammount}</th>
		<th>{mod_ma_cours}</th>
	</tr><tr>
		<th>{Deuterium}</th>
		<th><span id='deut'></span></th>
		<th>{mod_ma_res}</th>
	</tr><tr>
		<th>{Metal}</th>
		<th><input name="metal" type="text" value="0" onkeyup="calcul()"/></th>
		<th>{mod_ma_res_a}</th>
	</tr><tr>
		<th>{Crystal}</th>
		<th><input name="cristal" type="text" value="0" onkeyup="calcul()"/></th>
		<th>{mod_ma_res_b}</th>
	</tr><tr>
		<th colspan="6"><br /><input class="button188" type="submit" value="{mod_ma_excha}" /></th>
	</tr>
	</table>
	</form>
	</center>

	</div>
</div>

</div>

<!-- END CONTENT AREA -->