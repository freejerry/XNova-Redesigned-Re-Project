<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>{title}</title> 
	<link rel='stylesheet' type='text/css' href='{{skin}}/css/reset.css' media='screen' /> 
	<link rel='stylesheet' type='text/css' href='{{skin}}/css/toolbox.css' media='screen' /> 
	<link rel='stylesheet' type='text/css' href='{{skin}}/css/combatreport.css' media='screen' /> 
</head> 
 
<body id="combatreport"> 
 
<div id="master">
{rounds}
<!--
<div class="combat_round"> 
	<div class="round_info"> 
		<p class="start">{start}</p> 
		<p class="start opponents">{opponents}</p> 
	</div> 
	<table cellpadding="0" cellspacing="0" style="width:100%;"> 
		<tr> 
			<td class="round_attacker textCenter"> 
				<table cellpadding="0" cellspacing="0"> 
					<tr> 
						<td class="newBack"> 
							<center> 
								<span class="name textBeefy">Attacker unique <a  href="#" onclick="javascript: window.opener.parent.location.href = 'index.php?page=galaxy&session=3bfff3493bd7&galaxy=1&system=98';">[1:98:10]</a></span> 
								<span class="weapons textBeefy">Weapons: 10% Shields: 0% Armour: 20%</span> 
								<table cellpadding="0" cellspacing="0"> 
									<tr> 
										<th class="textGrow">Type</th> 
										<th class="textGrow">S.Cargo</th> 
									</tr> 
									<tr> 
										<td>Total</td> 
										<td>7</td> 
									</tr> 
									<tr> 
										<td>Weapons</td> 
										<td>6</td> 
									</tr> 
									<tr> 
										<td>Shields</td> 
										<td>10</td> 
									</tr> 
									<tr> 
										<td>Armour</td> 
										<td>480</td> 
									</tr> 
								</table> 
							</center> 
						</td> 
					</tr> 
				</table>
			</td> 
		</tr> 
	</table> 
	<table cellpadding="0" cellspacing="0" style="width:100%;"> 
		<tr> 
			<td class="round_defender textCenter"> 
				<table cellpadding="0" cellspacing="0"> 
					<tr> 
 						<td class="newBack"> 
							<center> 
								<span class="name textBeefy">Defender Anthony <a  href="#" onclick="javascript: window.opener.parent.location.href = 'index.php?page=galaxy&session=3bfff3493bd7&galaxy=1&system=98';">[1:98:9]</a></span> 
								<span class="weapons textBeefy">Weapons: 0% Shields: 0% Armour: 20%</span> 
								<table cellpadding="0" cellspacing="0"> 
									<tr> 
										<th class="textGrow">Type</th> 
										<th class="textGrow">Esp.Probe</th> 
										<th class="textGrow">R.Launcher</th> 
									</tr> 
									<tr> 
										<td>Total</td> 
										<td>9</td> 
										<td>6</td> 
									</tr> 
									<tr> 
										<td>Weapons</td> 
										<td>0</td> 
										<td>80</td> 
									</tr> 
									<tr> 
										<td>Shields</td> 
										<td>0</td> 
										<td>20</td> 
									</tr> 
									<tr> 
										<td>Armour</td> 
										<td>120</td> 
										<td>240</td> 
									</tr> 
								</table> 
							</center> 
						</td> 
					</tr>
				</table> 
			</td> 
		</tr> 
	</table>
</div> 
<div class="combat_round"> 
	<div class="round_info"> 
		<div class="battle"> 
			<p class="action">The attacking fleet fires 16 times at the defender, with a total firepower of 80. The defender&#x27;s shields absorb 34 damage points.</p> 
			<p class="action">The defending fleet fires 15 times at the attacker, with a total firepower of 480. The attacker&#x27;s shields absorb 50 damage points.</p> 
		 </div> 
	</div> 
</div>-->
<div id="combat_result"> 
	<p class="action">{result}</p> 
	<p class="action"> 
		{alost}<br /> 
		{dlost}<br /> 
		{debris}<br /> 
		{moon}
		{moon_got}
	</p> 
 
</div><!-- combat_result --> 
</div><!-- master --> 
 
</body> 
 
</html>
