<div id="rocketattack" style="background-image:url('{{skin}}/img/layout/raketenangriff_bg.jpg');width:649px;height:216px;">
	<a class="close_details" href="#" onclick="mrbox_close();">
		<img src="{{skin}}/img/layout/pixel.gif" width="16" height="16"/>
	</a>
	<form method="post" id="rocketForm" action="./?page=ipm">
		<input type="hidden" name="galaxy" value="{g}">
		<input type="hidden" name="system" value="{s}">
		<input type="hidden" name="position" value="{p}">
		<input type="hidden" name="planetType" value="1">

		<div id="grid">
			 <span id="target">Target: <span id="name"></span> <span id="position">[{g}:{s}:{p}]</span></span>
			 <span id="infos">
				<span id="numberrockets">
					Number of missiles <span id="number">({avl} available)</span>:
					<input type="text" maxlength="{strlen}"
						name="count" id="anz"
						onchange="if(this.value > {avl}){ this.value = {avl}; }"
						onkeyup="if(this.value > {avl}){ this.value = {avl}; }"
						class="textinput textBeefy textCenter" />

				</span>

				<span id="pziel">
					primary target:
					<select size="1" name="target" style="padding-right:0px;">
						<option value="0">all</option>
						<option value="401">Rocket Launcher</option>
						<option value="402">Light Laser</option>
						<option value="403">Heavy Laser</option>
						<option value="404">Gauss Cannon</option>
						<option value="405">Ion Cannon</option>
						<option value="406">Plasma Turret</option>
						<option value="407">Small Shield Dome</option>
						<option value="408">Large Shield Dome</option>

					</select>

				</span>
				<input type="submit" value="Fire" id="fire" onclick="mr_alert('<img height=16 width=16 src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}...'); getAXAH(form2get('rocketForm'),'errorBoxNotifyContent'); mrbox_close(); return false;" />
			</span>
		</div>
	<br class="clearfloat" />
	</form>
</div>
