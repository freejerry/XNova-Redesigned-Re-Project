<div class="content-box-s">
	<div class="header"><h3>Buildings</h3></div>
	
	<div class="content">
		<table cellpadding="0" cellspacing="0" class="construction">

			<tr>
				<th colspan="2">{thisname}</th>
			</tr>

			<tr class="data">
				<td class="building" style="width:40px;" valign="middle">

					<a href="#"
						class="tips" 
						onclick="{remove_link}"
						title="Cancel expansion of {thisname} to level {thislevel}?">
						<img class="queuePic" src="{{skin}}/img/small/small_{thisid}.jpg" alt="{thisname}">
					</a>
					
					<a href="#"
						class="tips abortNow" 
						onclick="{remove_link}"
						title="Cancel expansion of {thisname} to level {thislevel}?">
						<img src="{{skin}}/img/layout/pixel.gif" height="15" width="15" />
					</a>
					
				</td>
				<td class="desc">
					Improve to <span class="level">{Level} {thislevel}</span><br />
					{Duration}:<br />
					{countdown}
				</td>
			</tr>

			<tr class="queue">
				<td colspan="2">
					<table>
						<tr>
{rest}
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<div class="footer"></div>
</div>