<div id="inhalt">
	<div class="contentbox">
		<div class="header"><h3>Statistics (Updated: {time_of})</h3></div>
		<div class="content">
		<form name="send" action="index.php">

		<input type="hidden" name="session" value="5ae7cb2f1c31">
		<input type="hidden" name="page" value="statistics">
		<input type="hidden" id="who" name="who" value="player">
		<input type="hidden" id="type" name="type" value="fleet">
		<input type="hidden" id="start_at" name="start_at" value="2801">
		<input type="hidden" id="sort_per_member" name="sort_per_member" value="0" />		
		<div id="row">
        <div class="buttons leftCol">
            <a id="player" class="{class_1}" onclick="loadpage('./?page=statistics&who=player&sort={sort}&axah=1','{Statistics}','statistics');" href="#">
                <img src="{{skin}}img/layout/pixel.gif" width="54" height="54">
                <span class="mrtooltip">{Show} {player} {highscores}</span>

                <span class="marker"></span>
            </a>
            <a id="alliance" class="{class_2}" onclick="loadpage('./?page=statistics&who=ally&sort={sort}&axah=1','{Statistics}','statistics');" href="#">
                <img src="{{skin}}img/layout/pixel.gif" width="54" height="54">
                <span class="mrtooltip">{Show} {alliance} {highscores}</span>
                <span class="marker"></span>
            </a>
        </div>
        <div class="buttons rightCol">

            <a id="points" class="{class_3}" onclick="loadpage('./?page=statistics&&sort=total&who={who}&axah=1','{Statistics}','statistics');" href="#">
                <img src="{{skin}}img/layout/pixel.gif" width="54" height="54">
                <span class="mrtooltip">{Show} {score}</span>
                <span class="marker"></span>
            </a>
            <a id="fleet" class="{class_4}" onclick="loadpage('./?page=statistics&sort=fleet&who={who}&axah=1','{Statistics}','statistics');" href="#">
                <img src="{{skin}}img/layout/pixel.gif" width="54" height="54">
                <span class="mrtooltip">{Show} {fleets}</span>

                <span class="marker"></span>                
            </a>
            <a id="research" class="{class_5}" onclick="loadpage('./?page=statistics&sort=research&who={who}&axah=1','{Statistics}','statistics');" href="#">
                <img src="{{skin}}img/layout/pixel.gif" width="54" height="54">
                <span class="mrtooltip">{Show} {research}</span>
                <span class="marker"></span>                    
            </a>
        </div>

			<div class="parameter">


					<span class="position">Position:</span>
					
					<select name="start" id="startfrom" onChange="loadpage('./?page=statistics&sort={sort}&who={who}&p='+document.getElementById('startfrom').value+'&axah=1','{Statistics}','statistics'); return false;">
						<option value="x">[own position]</option>
{pages}
					</select>
			</div>
			<br class="clearfloat" />
		</div>
		<div class="leftcol">
		<div id="claim">{type_stat}HIGHSCORE</div>

		
		<table cellpadding="0" cellspacing="0" id="ranks" >
			<tbody>
				<tr>
					<th class="position col1">Rank</th>
					<th class="name col2">{type_stat}</th>
					<th class="name col2"></th>
					<th class="score col5">Points</th>
				</tr>
				{rows}
			</tbody>
		</table>

		</div><!--leftcol -->
		</form>
		<div class="rightcol">
		<div class="claimsmall" style="text-align:center">
			<p style="display:inline; margin:0px; line-height:40px;">

		{top10_title}</p>
		</div>
		<table class="top10" cellpadding="0" cellspacing="0">
					{top10}
			
		</table>
		
		</div>

		<br class="clearfloat" />
		<div id="paging" style="padding:8px 0px; text-align:center; font-size:11px;">
			<a href="#" onClick="set_start(2701);document.forms['send'].submit()"><span style="color:#5E699E;">&laquo;</span> previous page</a> 
			<span>|</span>
			<a href="#" onClick="set_start(2901);document.forms['send'].submit()">next page<span style="color:#5E699E;">&raquo;</span></a>
		</div>
		</div>
		<div class="footer"></div>

	</div>
</div>
<!-- END CONTENT AREA -->
