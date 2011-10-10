
<!-- CONTENT AREA -->
<div id="inhalt">

	<!-- HEADER -->
	<div id="planet" style="background-image:url({{skin}}/img/header/preferences/preferences.jpg)">

		<h2>Options - {opt_usern_data}</h2> 
	</div>
	<div class="c-left"></div>
	<div class="c-right"></div>
	
	<!-- CONTENT -->
	<div id="content" style="color:#848484;">
		<div class="sectioncontent">
			<div class="contentzs">
				<!-- TABS -->

				<div class="tabwrapper">					
					<ul class="tabsbelow" id="tabs-pref">
						<li>
							<a href="#" onclick="
								document.getElementById('one').style.display = 'block';
								document.getElementById('two').style.display = 'none';
								document.getElementById('three').style.display = 'none';
								document.getElementById('four').style.display = 'none';
								fadeIn('one',0);
								" id="tabUserdata" title="User data">
								<span>{userdata}</span>
							</a>
						</li>
						<li>
							<a href="#" onclick="
								document.getElementById('one').style.display = 'none';
								document.getElementById('two').style.display = 'block';
								document.getElementById('three').style.display = 'none';
								document.getElementById('four').style.display = 'none';
								fadeIn('two',0);
								" id="tabGeneral" title="General settings">

								<span>{general_settings}</span>
							</a>
						</li>
						<li>
							<a href="#" onclick="
								document.getElementById('one').style.display = 'none';
								document.getElementById('two').style.display = 'none';
								document.getElementById('three').style.display = 'block';
								document.getElementById('four').style.display = 'none';
								fadeIn('three',0);
								" id="tabRepresentation" title="Display settings, e.g. galaxy view, sequence of planets...">
								<span>Display</span>
							</a>
						</li>

						<li>
							<a href="#" onclick="
								document.getElementById('one').style.display = 'none';
								document.getElementById('two').style.display = 'none';
								document.getElementById('three').style.display = 'none';
								document.getElementById('four').style.display = 'block';
								fadeIn('four',0);
								" id="tabExtended" title="Extended settings, e.g. vacation mode/delete account">
								<span>Extended</span>
							</a>
						</li>
					</ul>
				</div>
				
				<!-- BASIC FORM DATA --> 
				<form method="post" name="prefs" id="prefs" action="./?page=preferences&mode=change&p={p}" />

				<!--<input type='hidden' name='session' value='6d713a1e6a10'>
				<input type='hidden' name='page' value='preferences'>
				<input type='hidden' name='mode' value='save'>
				<input type='hidden' id='selectedTab' name='selectedTab' value='0'>-->
				
			   	<div class="content">
			   	 			   			   
					<!-- USERDATA -->
					<div id="one" class="wrap"{disp1}>
					
						<table class="prefstable">
							<tr class="alt">

							   <td class="desc">{username}</td>
							   <td class="value"><input class="textInput w150" type="text" maxlength="20" value="{opt_usern_data}" size="20" name="db_character"/></td>
							</tr>
							<tr>	
								<td class="desc">{lastpassword}</td>
								<td class="value"><input class="textInput w150" type="password" value="" size="20" name="db_password"/></td>
							</tr>
							<tr class="alt">

							   <td class="desc">{newpassword}</td>
								<td class="value"><input class="textInput w150" type="password" maxlength="40" size="20" name="newpass1"/></td>
							</tr>
							<tr>
								<td class="desc">{newpasswordagain}</td>
								<td class="value"><input class="textInput w150" type="password" maxlength="40" size="20" name="newpass2"/></td>
							</tr>
							<tr class="alt">

								<td class="desc">{emaildir}</td>
								<td class="value"><input class="textInput w150" type="text" value="{opt_mail1_data}" size="20" name="db_email"/></td>						
							</tr>
							<tr>
								<td class="info" colspan="2">{emaildir_tip}</td>
							</tr>
							<tr class="alt">
								<td class="desc">{permanentemaildir}</td>

								<td class="value">{opt_mail2_data}</td>
							</tr>
							
							<tr>
								<td class="info" colspan="2">{secqu_tip}</td>
							</tr>
							
							<tr class="alt">
								<td class="desc" colspan="2">{sec_qu_t}</td>
							</tr>
							
							<tr>
								<td class="value" colspan="2"><input class="textInput w150" name="sec_qu" maxlength="1000" size="75" value="{sec_qu}" type="text" style="width:500px" /></td>
							</tr>
							
							<tr class="alt">
								<td class="desc" colspan="2">{sec_ans_t}</td>
							</tr>
							
							<tr>
								<td class="value" colspan="2"><input class="textInput w150" name="sec_ans" maxlength="1000" size="75" value="{sec_ans}" type="text" style="width:500px" /></td>
							</tr>
							
						</table>   
						<input type="button" class="button188" value="{save_settings}" onclick="mr_alert('<img height=16 width=16 src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}...'); getAXAH(form2get('prefs'),'errorBoxNotifyContent');" />
						
					</div>

					<!-- GENERAL -->
					<div id="two" class="wrap"{disp2}>
					
						<table class="prefstable">

							<tr class="alt">
								 <td class="desc">{untoggleip}</td>
								 <td class="value"><input name="noipcheck"{opt_noipc_data} type="checkbox" /></td>
							</tr>
							<tr>
								<td class="info" colspan="2">{untoggleip_tip}</td>
							</tr>
							
						</table> 
						<input type="button" class="button188" value="{save_settings}" onclick="mr_alert('<img height=16 width=16 src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}...'); getAXAH(form2get('prefs'),'errorBoxNotifyContent');" />

					</div>
					
					<!-- REPRESENTATION -->
					<div id="three" class="wrap"{disp3}>
					
						<table class="prefstable">
							<tr>
								<td class="desc">{skins_example}</th>
								<td class="value">
								<input name="dpath" id="dpath" maxlength="80" value="{opt_dpath_data}" type="text" class="textInput w150">
								<br />
								<select name="dpaths" id="dpaths" class="textInput w150" onchange="document.getElementById('dpath').value=document.getElementById('dpaths').value;">
									<option value ='' selected>-- Select Skin --</option>
									{opt_lst_skin_data}
								</select>
								</th>
							</tr>
							<tr class="alt">
								<td class="desc">Sort planets by:</td>
								<td class="value">
									<select name="settings_sort" class="textInput w150">
										<!--<option value="0" selected>Order of emergence</option>
										<option value="1" >Coordinates</option>
										<option value="2" > Alphabet</option>-->
										{opt_lst_ord_data}
									</select>
								</td>
							</tr>
							<tr>
								<td class="desc">Sorting sequence:</td>
								<td class="value">
									<select name="settings_order" class="textInput w150">
										<!--<option value="0" selected>up</option>
										<option value="1" >down</option>-->
										{opt_lst_cla_data}
									</select>
								</td>
							</tr>
							<tr class="alt">
								<td class="desc">Number of espionage probes</td>
								<td class="value"><input type="text" class="textInput" value="{opt_probe_data}" size="3" maxlength="3" name="spio_anz"/></td>

							</tr>
							<tr>
								<td class="info" colspan="2">Number of espionage probes being sent by using the galaxy menu.</td>
							</tr>
							</table>
							<input type="button" class="button188" value="{save_settings}" onclick="mr_alert('<img height=16 width=16 src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}...'); getAXAH(form2get('prefs'),'errorBoxNotifyContent');" />
		   
					</div>
					
					<!-- EXTENDED -->

					<div id="four" class="wrap"{disp4}>
						<table class="prefstable">												
							<tr class="alt">
								<td class="desc">Activate vacation mode</td>
								<td class="value"><input type="checkbox" name="urlaubs_modus"/></td>
							</tr>						
											
							<tr>
							   <td class="info" colspan="2">Vacation mode protects you in times of longer absence. You can only activate it when there are <em>no buildings or ships in the queue</em> (fleet, buildings, defence) <strong>and</strong> <em>no research</em> is in progress and no fleets are on their way.<br/><br/>

When vacation mode is active you can not be attacked. However, attacks that have already been started will be executed. Vacation mode sets your resource income to zero which has to be changed manually after ending vacation mode. Vacation mode lasts at least 2 days, you can`t deactivate it earlier.</td>
							</tr>						
							<tr class="alt">
								<td class="desc">Delete account</td>
								<td class="value"><input type="checkbox" name="db_deaktjava"/></td>
							</tr>
							<tr>
								<td colspan="2" class="info">check here to have your account marked for automatical deletion after 7 days.</td>

							</tr>
						</table>
						<input type="button" class="button188" value="{save_settings}" onclick="mr_alert('<img height=16 width=16 src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}...'); getAXAH(form2get('prefs'),'errorBoxNotifyContent');" />
					</div>
				</div>  
				<!-- FOOTER -->
				<div class="footer"></div>
				</form>
			</div>

		</div>
	</div>
</div>

<!-- END CONTENT AREA -->
