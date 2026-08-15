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
		<h3>{call_merchant}:</h3>
		<div style="position:relative; height:80px">
			<ul class="merchList">
				<li class="metal">
					<span>
						<a href="#" class="tips2"
						onclick="mrbox('./?page=trader&resource=metal&action=2&axah=1',300); return false;"
						onmouseover="mrtooltip('{Metal}<br />{sell_m}')"
						onmouseout="UnTip();">
							<img src="{{skin}}/img/layout/pixel.gif" width="80" height="80" />
						</a>
					</span>
				</li>
				<li class="crystal">
					<span>
						<a href="#" class="tips2"
						onclick="mrbox('./?page=trader&resource=crystal&action=2&axah=1',800); return false;"
						onmouseover="mrtooltip('{Crystal}<br />{sell_c}')"
						onmouseout="UnTip();">
							<img src="{{skin}}/img/layout/pixel.gif" width="80" height="80" />
						</a>
					</span>
				</li>
				<li class="deut">
					<span>
						<a href="#" class="tips2"
						onclick="mrbox('./?page=trader&resource=deuterium&action=2&axah=1',300); return false;"
						onmouseover="mrtooltip('{Deuterium}<br />{sell_d}')"
						onmouseout="UnTip();">
							<img src="{{skin}}/img/layout/pixel.gif" width="80" height="80" />
						</a>
					</span>
				</li>
			</ul>
			<br class="clearfloat" />
		</div>
		<p>
			<span class="crucial">{merchant_rates}</span>
		</p>
	</div>
</div>

<!-- END CONTENT AREA -->
