<center>
<br><br>
<form action="{PHP_SELF}&mode=change" method="post">
<div class="mr-bigbox">
<table width="517" style="align: left">
<tbody>
{opt_adm_frame}
<tr>
	<td class="c" colspan="2">{userdata}<input name="user_id" value="{user_id}" type="hidden" /></td>
</tr><tr>
	<th style="text-align: center">{playerip}</th>
	<th style="text-align: center">
	<input value="{get_ip}" type="text" style="width:200px" readonly /><br />
	<a href="multis.php" />{declare}</a>
	</th>
</tr><tr>
	<th style="text-align: center">{forum_con}</th>
	<th style="text-align: center"><input name="forum_id" value="{forum_id}" type="text" style="width:200px"></th>
</tr><tr>
	<th style="text-align: center">{username}</th>
	<th style="text-align: center"><input name="db_character" value="{opt_usern_data}" type="text" style="width:200px"></th>
</tr><tr>
	<th style="text-align: center">{lastpassword}</th>
	<th style="text-align: center"><input name="db_password" value="" type="password" style="width:200px"></th>
</tr><tr>
	<th style="text-align: center">{newpassword}</th>
	<th style="text-align: center"><input name="newpass1" maxlength="40" type="password" style="width:200px"></th>
</tr><tr>
	<th style="text-align: center">{newpasswordagain}</th>
	<th style="text-align: center"><input name="newpass2" maxlength="40" type="password" style="width:200px"></th>
</tr><tr>
	<th style="text-align: center"><a title="{emaildir_tip}">{emaildir}</a></th>
	<th style="text-align: center"><input name="db_email" maxlength="100" value="{opt_mail1_data}" type="text" style="width:200px"></th>
</tr><tr>
	<th style="text-align: center">{permanentemaildir}</th>
	<th style="text-align: center"><input name="db_email" value="{opt_mail2_data}" type="text" style="width:200px" disabled></th>
</tr><tr>
	<th style="text-align: center">{ref_id} ({refers_count} Referals)</th>
	<th style="text-align: center"><a href="{refid}" target="_new">{refid}</a></th>
</tr><tr>
	<td class="c" colspan="2">{secur_qs}</td>
</tr><tr>
	<th colspan="2">{sec_qu_t}<br /><input name="sec_qu" maxlength="1000" size="75" value="{sec_qu}" type="text"></td>
</tr><tr>
	<th colspan="2">{sec_ans_t}<br /><input name="sec_ans" maxlength="1000" size="75" value="{sec_ans}" type="text"></td>
</tr><tr>
	<td class="c" colspan="2">{general_settings}</td>
</tr><tr>
	<th style="text-align: center">{opt_lst_ord}</th>
	<th style="text-align: center">
		<select name="settings_sort" style="width:200px">
		{opt_lst_ord_data}
		</select>
	</th>
</tr><tr>
	<th style="text-align: center">{opt_lst_cla}</th>
	<th style="text-align: center">
		<select name="settings_order" style="width:200px">
		{opt_lst_cla_data}
		</select>
	</th>
</tr><tr>
	<th style="text-align: center">{avatar}<br></th>
	<th style="text-align: center"><input name="avatar" maxlength="80" value="{opt_avata_data}" type="text" style="width:200px"></th>
</tr><tr>
	<th style="text-align: center">{skins_example}</th>
	<th style="text-align: center"><input name="dpath" maxlength="80" value="{opt_dpath_data}" type="text" style="width:200px"> <br>
		<select name="dpaths" size="1" style="width:200px">
			<option value ='' selected>-- Select Skin --</option>
			{opt_lst_skin_data}
		</select>
	</th>
</tr><tr>
	<th style="text-align: center">{menutype}</th>
	<th style="text-align: center">
		<select name="menutype" size="1" style="width:200px">
			<option value ='' selected>-- Select Type --</option>
			<option value ='fixed'>Fixed</option>
			<option value ='scroll'>Scroll</option>
		</select>
	</th>
</tr><tr>
	<th style="text-align: center">{sel_lang}</th>
	<th style="text-align: center">
		<select name="language" size="1" style="width:200px">
			<option value ='' selected>-- Select Language --</option>
			<option value ="en">English (Default)</option>
			<option value ="de">German (beta)</option>
			<option value ="fr">French (beta)</option>
			<!--
			<option value ="es">Spanish (beta)</option>
			<option value ="du">Dutch (beta)</option>
			<option value ="ro">Romaniun (beta)</option>
			-->
		</select>
	</th>
</tr><tr>
	<th style="text-align: center">{opt_chk_skin}	</th>
	<th style="text-align: center"><input name="design"{opt_sskin_data} type="checkbox"></th>
</tr><tr>
	<th style="text-align: center"><a title="{untoggleip_tip}">{untoggleip}</a></th>
	<th style="text-align: center"><input name="noipcheck"{opt_noipc_data} type="checkbox" /></th>
</tr><tr>
	<td class="c" colspan="2">{galaxyvision_options}</td>
</tr><tr>
	<th style="text-align: center"><a title="{spy_cant_tip}">{spy_cant}</a></th>
	<th style="text-align: center"><input name="spio_anz" maxlength="3" value="{opt_probe_data}" type="text" style="width:75px"></th>
</tr><tr>
	<th style="text-align: center">{tooltip_time}</th>
	<th style="text-align: center"><input name="settings_tooltiptime" maxlength="2" value="{opt_toolt_data}" type="text" style="width:20px"><input value="{seconds}" type="text" style="width:55px" disabled> </th>
</tr><tr>
	<th style="text-align: center">{mess_ammount_max}</th>
	<th style="text-align: center"><input name="settings_fleetactions" maxlength="2" value="{opt_fleet_data}" type="text" style="width:75px"></th>
</tr><tr>
	<th style="text-align: center">{show_ally_logo}</th>
	<th style="text-align: center"><input name="settings_allylogo"{opt_allyl_data} type="checkbox" /></th>
</tr><tr>
	<td class="c" colspan="2">{shortcut}</th>
</tr><tr>
	<th style="text-align: center"><img src="{dpath}img/e.gif" alt="">   {spy}</th>
	<th style="text-align: center"><input name="settings_esp"{user_settings_esp} type="checkbox" /></th>
</tr><tr>
	<th style="text-align: center"><img src="{dpath}img/m.gif" alt="">   {write_a_messege}</th>
	<th style="text-align: center"><input name="settings_wri"{user_settings_wri} type="checkbox" /></th>
</tr><tr>
	<th style="text-align: center"><img src="{dpath}img/b.gif" alt="">   {add_to_buddylist}</th>
	<th style="text-align: center"><input name="settings_bud"{user_settings_bud} type="checkbox" /></th>
</tr><tr>
	<th style="text-align: center"><img src="{dpath}img/r.gif" alt="">   {attack_with_missile}</th>
	<th style="text-align: center"><input name="settings_mis"{user_settings_mis} type="checkbox" /></th>
</tr><tr>
	<th style="text-align: center"><img src="{dpath}img/s.gif" alt="">   {show_report}</th>
	<th style="text-align: center"><input name="settings_rep"{user_settings_rep} type="checkbox" /></th>
</tr><tr>
	<td class="c" colspan="2">{banner_bg}</td>
</tr><tr>
	<th colspan="2">
	<img src="scripts/createbanner.php?id={id}" border="0" alt="User Banner" /><br />
	<select name="banner_bg">
		{opt_lst_banner_bg}
	</select>
	</th>
</tr><tr>
	<td class="c" colspan="2">{delete_vacations}</td>
</tr><tr>
	<th style="text-align: center"><a title="{vacations_tip}">{mode_vacations}</a></th>
	<th style="text-align: center"><input name="urlaubs_modus"{opt_modev_data} type="checkbox" /></th>
</tr><tr>
	<th style="text-align: center"><a title="{deleteaccount_tip}">{deleteaccount}</a></th>
	<th style="text-align: center"><input name="db_deaktjava"{opt_delac_data} type="checkbox" /></th>
</tr><tr>
	<th colspan="2"><input value="{save_settings}" type="submit"></th>
</tr>
</tbody>
</table>
</div>
</form>
</center>