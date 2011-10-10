				<a href="#" class="TTgalaxy" rel="#moon{pos}">
					<img src="{{skin}}/img/galaxy/moon_a.gif" width="30" height="30" ondblclick="sendShips(6,1,1,2,3,1);return false;"/>
					<span class="mrtooltip" style="background-color:transparent;border:0px;top:{tooltip_height}px;left:265px;">
						<div id="moon2">
							<div id="TTWrapper">
								<div id="tooltipBody" class="tooltipBody">	
									<span class='tooltip_sticky'>
									<div class="TTInner" id="TTMoon">	
										<table cellpadding="0" cellspacing="0">
											<tr>
												<th colspan="2"><span class="spacing">{moon_name}</span></th>
											</tr>
											<tr class="body">
												<td class="moonpic">
													<span id="pos-moon">[{galaxy}:{system}:{pos}]</span>
													<img src="{{skin}}/img/galaxy/moon_a.gif" alt="Mond"/>
													<span id="moonsize" title="Diameter of moon in km">{diametre} km</span>
												</td>
												<td class="actions">
													<ul>
														<li><a href="./?page=fleet1" onclick="loadpage(this.href,'{Fleet}','fleet1'); return false;">{Fleet}</a></li>
													</ul>
												</td>
											</tr>
											<tr class="footer" style="background:url('{{skin}}/img/tooltip/ttfooter.gif') no-repeat top center;height:11px;">
												<td colspan="2"></td>
											</tr>
										</table>
									</div>
									</span>
								</div>
							</div>
						</div>
					</span>
				</a>
