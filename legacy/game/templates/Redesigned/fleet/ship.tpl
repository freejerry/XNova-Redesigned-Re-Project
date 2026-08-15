			<li class="{class}" id="button{id}">
				<div class="buildingimg">
					<a href="javascript:maxShip('ship{id}');" class="tips" onmouseover="mrtooltip('{name} ({avl_ships})');" onmouseout="UnTip();">
						<span class="ecke">
							<span class="level"><span class="textlabel">{name} </span>{avl_ships}</span>
						</span>
					</a>
				</div>

				<input name="maxship{id}" type="hidden" value="{avl_ships}" />
				<input name="ship{id}" value="0" onfocus="javascript:if(this.value == '0') this.value='';" onblur="javascript:if(this.value == '') this.value='0';" type="text" {readonly} />

				<a class="max" href="javascript:maxShip('ship{id}');" onmouseover="mrtooltip('Select all ships of this type');" onmouseout="UnTip();"></a>
			</li>

