	<div class="section">
		<h3>
			<a id="link12" class="closed" href="javascript:void(0);" onclick="ReverseDisplay('section12');SwapClass('link12','opened','closed');">
				<span>Member List</span>
			</a>
		</h3>
	</div>
	<form target="" href="#" method="post" name="asdf">
	<div class="sectioncontent" id="section12" style="display:none;">

		<div class="contentz" id="memberlist_contentz">
			<table class="members sortable" cellpadding="0" cellspacing="0">
			<!--<tr>
				<th>ID</th>
				<th><a onclick="loadpage('./?page=network&sort=username','{Alliance}','network'); document.getElementById('memberlist_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" href="./?page=network&sort1=1&sort2=0">Name</a></th>
				<th> </th>
				<th><a onclick="loadpage('./?page=network&sort=ally_rank','{Alliance}','network'); document.getElementById('memberlist_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" href="./?page=network&sort1=2&sort2=0">Rank</a></th>

				<th><a onclick="loadpage('./?page=network&sort=total_points','{Alliance}','network'); document.getElementById('memberlist_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" href="./?page=network&sort1=3&sort2=0">Points</a></th>
				<th><a onclick="loadpage('./?page=network&sort=galaxy,system,planet','{Alliance}','network'); document.getElementById('memberlist_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" href="./?page=network&sort1=0&sort2=0">Coords</a></th>
				<th><a onclick="loadpage('./?page=network&sort=ally_register_time','{Alliance}','network'); document.getElementById('memberlist_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" href="./?page=network&sort1=4&sort2=0">Joined</a></th>
				<th><a onclick="loadpage('./?page=network&sort1=5&sort2=0','{Alliance}','network'); document.getElementById('memberlist_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" href="./?page=network&sort1=5&sort2=0">Online</a></th>
				<th>Function</th>
			</tr>-->
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th class="sorttable_nosort"> </th>
				<th>Rank</th>

				<th>Points</th>
				<th>Coords</th>
				<th>Joined</th>
				<th>Online</th>
				<th class="sorttable_nosort">Function</th>
			</tr>
{rows}
	 		</table>
			<div class="h10"></div>
		</div><!--contentdiv -->

		<div class="footer"></div>
	</div><!-- section11 -->
	</form>