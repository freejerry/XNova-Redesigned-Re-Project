<div id="ResourceLayer" style="{hideres}">
	<div id="RessLayer">
		<a class="close_details" href="#" onclick="ReverseDisplay('planet');ReverseDisplay('ResourceLayer');"></a>
		<h3><span><!--Resource settings on planet "Homeworld"-->{Production_of_resources_in_the_planet}</span></h3>

		<form method="POST" action="./?page=resources&mode=resources">

		<table cellpadding="0" cellspacing="0" style="margin-top:15px;">
			<tr>
				<td colspan="7" id="factor">
					<div class="secondcol">
						<div style="width:376px; margin: 0px auto;">

							<span class="factorkey">{Production_level}: {production_level}</span>
							<span class="factorbutton">
								<input class="button188" style="" type="submit" value="{Recalc}" name="submit" /></span>
							<br class="clearfloat" />
						</div>
					</div>
				</td>
			</tr>

			<tr>
				<th colspan="2"></th>
				<th>{Metal}</th>
				<th>{Crystal}</th>
				<th>{Deuterium}</th>
				<th>{Energy}</th>
				<th></th>

			</tr>
			<tr class="alt">
				<td colspan="2" class="label">{Basic_income}</td>
						<td style="color:grey;" class="textRight">
					{metal_basic_income}		</td>
						<td style="color:grey;" class="textRight">
					{crystal_basic_income}		</td>

						<td style="color:grey;" class="textRight">
					{deuterium_basic_income}		</td>
						<td style="color:grey;" class="textRight">
					{energy_basic_income}		</td>
						<td></td>
			</tr>

			{resource_row}

			<tr class="">

				<td colspan="2" class="label">{Stores_capacity}</td>
				<td class="left2">{metal_max}</td>
				<td class="left2">{crystal_max}</td>
				<td class="left2">{deuterium_max}</td>
				<td>-</td>
				<td></td>

			</tr>
			<tr class="summary">
				<td colspan="2" class="label"><em>{hourly}</em></td>
				<td class="undermark">{metal_total}</td>
				<td class="undermark">{crystal_total}</td>
				<td class="undermark">{deuterium_total}</td>
				<td class="undermark">{energy_total}</td>
				<td></td>
			</tr>
			<tr class="alt">
				<td colspan="2" class="label"><em>{dayly}</em></td>
				<td class="undermark">{daily_metal}</td>
				<td class="undermark">{daily_crystal}</td>
				<td class="undermark">{daily_deuterium}</td>
				<td class="undermark">{energy_total}</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2" class="label"><em>{weekly}</em></td>
				<td class="undermark">{weekly_metal}</td>
				<td class="undermark">{weekly_crystal}</td>
				<td class="undermark">{weekly_deuterium}</td>
				<td class="undermark">{energy_total}</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2" class="label"><em>{monthly}</em></td>
				<td class="undermark">{monthly_metal}</td>
				<td class="undermark">{monthly_crystal}</td>
				<td class="undermark">{monthly_deuterium}</td>
				<td class="undermark">{energy_total}</td>
				<td></td>
			</tr>
		</table>
		</form>

		<br class="clearfloat" />
	</div>
</div>
