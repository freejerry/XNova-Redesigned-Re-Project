<!-- CONTENT AREA -->
<div id="inhalt">

	<!--<div id="zeuch666" style="display:none;">-->
		<div id="planet_ren_del" style="position:absolute;z-index:100;">
			<div id="abandonplanet">
				<h3>{lnk_rena_dele}</h3>
				<a onclick="change_display('planet_ren_del','none')" href="#" class="close_details tips" style="position:relative;" title="Close Window"></a>
				<div class="clearfloat"></div>
				<div id="inner">
					<img src="{{skin}}/img/planets/large/{type}.jpg" alt=""/>
					<div>

						<p>{ov_rena_dele}</p>
						<div style="margin-left:0px; margin-top:10px;">
							<form name="planetMaintenance" method="get" id="rename_form" action="./?page=overview&mode=renplanet">
								<table cellpadding="0" cellspacing="0">
									<tr class="head">
										<th colspan="3">{namer}</th>
									</tr>

									<tr>
										<td width="50%">
											<input class="text" type="text" maxlength="20" size="25" name="newPlanetName" value="{new_pl_name}" onFocus="if(this.value=='{new_pl_name}'){ this.value = ''; }" onBlur="if(this.value==''){ this.value = '{new_pl_name}'; }" />
										</td>
										<td width="50%">
											<input class="button188" type="button" value="{rename}" name="aktion" onclick="submitform('rename_form','{Overview}','overview'); document.getElementById('inner').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" />
										</td>
									</tr>
								</table>
							</form>

							<form name="planetMaintenanceDelete" method="post" action="./?page=overview&mode=delplanet" id="delete_form">
								<table cellpadding="0" cellspacing="0">

									<tr class="head">
										<th colspan="3" class="second">{colony_abandon}</th>
									</tr>

									<tr>
										<th>{Position}</th><th>{namep}</th><th>{functions}</th>
									</tr>

									<tr>
										<td>[{galaxy}:{system}:{planet}]</td>
										<td>{name}</td>
										<td width="50%">
											<a id="block" class="start button188" onclick="ReverseDisplay('validate')"><span>{colony_abandon}</span></a>
										</td>
									</tr>

									<tr>
										<td colspan="3">
											<div id="validate" style="display:none;">
											  	<p>{confirm_planet_delete} [{galaxy}:{system}:{planet}] {confirmed_with_password}</p>
												<div>
													<input type="hidden" name="planet_id" value="{planet_id}" />
													<input class="text" type="password" name="password" maxlength="20" size="25" />
													<input type="button" class="button188" value="{confirm}" onclick="mr_alert('<img height=16 width=16 src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}...'); getAXAH(form2get('delete_form'),'errorBoxNotifyContent');" />
												</div>
											</div>
										</td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!--</div>-->

	<div id="planet" style="background-image:url('{{skin}}/img/planets/header/{headerimg}');">
		<div id="planet_ovr">
{moonlink}
			<h2>{Overview} - {name}</h2>
				<table cellpadding="0" cellspacing="0" id="planetdata">
				<tr>
					<td class="desc tips">
						{Diameter}:
					</td>
					<td class="data">
						<a onmouseover="mr_tooltip('Diameter, number of used and maximum usable fields')" onmouseout="UnTip()">
							{diameter}km ({field_current}/{field_max})
							<!--<span class="mrtooltip">Diameter, number of used and maximum usable fields</span>-->
						</a>
					</td>
				</tr>

				<tr>
					<td class="desc tips">
						{Temperature}:
					</td>
					<td class="data">
						<a onmouseover="mr_tooltip('{Temperature_desc}')" onmouseout="UnTip()">
							{approx} {temp_min}{Centigrade} {to} {temp_max}{Centigrade}
						</a>
					</td>
				</tr>

				<tr>
					<td class="desc tips">
						{Position}:
					</td>
					<td class="data">
						<a onmouseover="mr_tooltip('{Position_desc}')" onmouseout="UnTip()" onclick="loadpage(this.href,'{Galaxy}','galaxy'); return false;" href="./?page=galaxy&mode=1&galaxy={galaxy}&system={system}">
							[{galaxy}:{system}:{planet}]
						</a>
					</td>
				</tr>

				<tr>
					<td class="desc tips">
						{Points}:
					</td>
					<td class="data">
						<a onmouseover="mr_tooltip('{Points_desc}')" onmouseout="UnTip()">
						<a onmouseover="mr_tooltip('{Points_desc}')" onmouseout="UnTip()" onclick="loadpage(this.href,'{Statistics}','statistics'); return false;" href="./?page=statistics&start=own">
							{total_points} ({Rank} {user_rank} {of} {players})
						</a>
					</td>
				</tr>

				<tr>
					<td class="desc tips">
						{Options}:
					</td>
					<td class="data">
						<a onclick="change_display('planet_ren_del','block')" href="#" style="position:relative;" onmouseover="mr_tooltip('{Options_desc}')" onmouseout="UnTip()">
							{lnk_rena_dele}
						</a>
					</td>
				</tr>
			</table>
		</div>

	</div><div class="c-left"></div>
		<div class="c-right"></div>

	{qbuilding}

	<div class="content-box-s">
		<div class="header"><h3>{Research}</h3></div>
		<div class="content">
			{qresearch}
		</div>
		<div class="footer"></div>
	</div>

	<div class="content-box-s">
		<div class="header"><h3>{Shipyard}</h3></div>
		<div class="content">
			{qshipyard}
		</div>
		<div class="footer"></div>
	</div>

	<div class="clearfloat"></div>
</div>

<!-- END CONTENT AREA -->
