<?php
/**
 * search.php
 * @version 2
 * @copyright 2009 by MadnessREd
 */

getLang('search');

if($_GET['term']){
	$term = mysql_escape_string($_GET['term']);
	
	$parse = $lang;
	
	$userrowstpl = '
	<tr class="{alt}">
		<td class="no">{n}</td>					
		<td class="userName">{username}</td>
		<td class="allyName">
			<a target="_ally" href="ainfo.php?allyid={ally_id}">{ally_name}</a>
		</td>
		<td class="home">{name}</td>
		<td class="position text">
			<a onclick="self.parent.mrbox_close();" target="_parent" href="javascript:showGalaxy({galaxy},{system},{planet});">
				[{galaxy}:{system}:{planet}]
			</a>
		</td>
		<td class="highscore">
			<a onclick="self.parent.mrbox_close();" target="_parent" href="./?page=statistics&amp;session=b00976fbcce3&amp;start=8501">8555</a>
		 </td>

		<td class="action"></td>
	</tr>';
	
	$allyrowstpl = '
	<tr class="{alt}">
		<td class="no">{n}</td>                    
		<td class="allyTag">
			<a target="_ally" href="ainfo.php?allyid={id}">{ally_tag}</a>
		</td>
		<td class="allyName">
            <a target="_ally" href="ainfo.php?allyid={id}">{ally_name}</a>
        </td>
		<td class="allyMembers">{ally_members}</td>

		<td class="allyPoints">{ally_pts}</td>
		<td class="action">
			<a onclick="self.parent.loadpage(\'./?page=network&mode=apply&id={id}\',\'{Alliance}\',\'network\'); self.parent.mrbox_close(); return false;" target="_parent" title="Apply for this alliance" class="tips" href="./?page=network&mode=apply&id={id}">
                <img alt="Apply for this alliance" src="{{skin}}/img/icons/mail.gif">
			</a>
		</td>
    </tr>';
	
	
	//Users first
	$parse['data_titles'] = '
	<tr>
		 <th class="no">#</th>
		 <th class="userName">'.$lang['playername'].'</th>

		 <th class="allyName">'.$lang['alliance'].'</th>
		 <th class="home">'.$lang['homeworld'].'</th>
		 <th class="position">'.$lang['position'].'</th>
		 <th class="highscore">'.$lang['rank'].'</th>
		 <th class="action">'.$lang['action'].'</th>
	</tr>';
	
	$parse['data'] = '';
	$n = 0;
	$search = doquery("SELECT {{prefix}}users.id, {{prefix}}users.username, {{prefix}}users.ally_id, {{prefix}}users.ally_name, {{prefix}}users.galaxy, {{prefix}}users.system, {{prefix}}users.planet, {{prefix}}planets.name FROM {{prefix}}users, {{prefix}}planets WHERE {{prefix}}users.username LIKE '%{$term}%' AND {{prefix}}users.id_planet = {{prefix}}planets.id LIMIT ".$n.",100;",'');
	while($row = mysql_fetch_assoc($search)){
		//Row number
		$n++;
		//Alternating rows
		if($n % 2 == 1){ $row['alt'] = 'alt'; }else{ $row['alt'] = ''; }
		$row['n'] = $n;
		
		$parse['data'] .= parsetemplate($userrowstpl,$row);
	}
	if(strlen($parse['data']) == 0){
		$parse['data'] = '<td colspan="6" class="noResult textCenter textBeefy">{no_players}</td>';
	}
	$userresult = parsetemplate(gettemplate('search/results'), $parse);
	
	//Planets
	$parse['data'] = '';
	$n = 0;
	$search = doquery("SELECT {{prefix}}users.id, {{prefix}}users.username, {{prefix}}users.ally_id, {{prefix}}users.ally_name, {{prefix}}users.galaxy, {{prefix}}users.system, {{prefix}}users.planet, {{prefix}}planets.name FROM {{prefix}}users, {{prefix}}planets WHERE {{prefix}}planets.name LIKE '%{$term}%' AND {{prefix}}users.id_planet = {{prefix}}planets.id LIMIT ".$n.",100;",'');
	while($row = mysql_fetch_assoc($search)){
		//Row number
		$n++;
		//Alternating rows
		if($n % 2 == 1){ $row['alt'] = 'alt'; }else{ $row['alt'] = ''; }
		$row['n'] = $n;
		
		$parse['data'] .= parsetemplate($userrowstpl,$row);
	}
	if(strlen($parse['data']) == 0){
		$parse['data'] = '<td colspan="6" class="noResult textCenter textBeefy">{no_planets}</td>';
	}
	$planetresult = parsetemplate(gettemplate('search/results'), $parse);

	//Alliances
	$parse['data_titles'] = '
	<tr>
		<th class="no">#</th>
		<th class="allyTag">'.$lang['allytag'].'</th>

		<th class="allyName">'.$lang['allyname'].'</th>
		<th class="allyMembers">'.$lang['member'].'</th>
		<th class="allyPoints">'.$lang['points'].'</th>
		<th class="action">'.$lang['action'].'</th>
	</tr>';

	$parse['data'] = '';
	$n = 0;
	$search = doquery("SELECT * FROM {{table}} WHERE ally_tag LIKE '%{$term}%' OR ally_name LIKE '%{$term}%' LIMIT ".$n.",100;",'alliance');
	while($row = mysql_fetch_assoc($search)){
		//Row number
		$n++;
		//Alternating rows
		if($n % 2 == 1){ $row['alt'] = 'alt'; }else{ $row['alt'] = ''; }
		$row['n'] = $n;
		
		$parse['data'] .= parsetemplate($allyrowstpl,$row);
	}
	if(strlen($parse['data']) == 0){
		$parse['data'] = '<td colspan="6" class="noResult textCenter textBeefy">{no_alliances}</td>';
	}
	$allyresult = parsetemplate(gettemplate('search/results'), $parse);
	
	
	$return = '
								<div id="player_results">
'.$userresult.'
								</div>
								<div id="planet_results" style="display:none;">
'.$planetresult.'
								</div>
								<div id="alliance_results" style="display:none;">
'.$allyresult.'
								</div>';
	makeAXAH($return);
	
}else{
	makeAXAH(parsetemplate(gettemplate('search/page'), $lang));
}

?>