			<td rel="#planet{pos}" class="TTgalaxy microplanet" style="position:relative; background:url({{skin}}/{micro_planet_img}) no-repeat top center;">
				<a>
					<img src="{{skin}}/img/layout/pixel.gif" width="30" height="30" />
					<span class="mrtooltip" style="background-color:transparent;border:0px;top:{tooltip_height}px;left:70px;">
						<div id=planet{pos}>
							<div id=TTWrapper>
								<div id=tooltipBody class=tooltipBody>	
									<span class=tooltip_sticky>
									<div class=TTInner id=TTPlanet>
										<table cellpadding=0 cellspacing=0>
											<tr>
												<th colspan=2><span class=spacing>Planet {planet_name} {activity} Activity: 28m </span></th>
											</tr>
											<tr class=body>
												<td class=planetimg>
													<span id=pos-planet>[{galaxy}:{system}:{pos}]</span>		
													<img src={{skin}}/{micro_planet_img} alt={planet_name} height=30 width=30/>
												</td>
												<td class=actions>
													<ul>
														<li><a href=./?page=fleet1&galaxy={galaxy}&system={system}&position={pos}&type=1&mission=1>Attack</a></li>
														<li><a href=./?page=fleet1&galaxy={galaxy}&system={system}&position={pos}&type=1&mission=5>ACS Defend</a></li>
														<li><a href=./?page=fleet1&galaxy={galaxy}&system={system}&position={pos}&type=1&mission=3>Transport</a></li>
													</ul>
												</td>
											</tr>
											<tr class=footer style="background:url('{{skin}}/img/tooltip/ttfooter.gif') no-repeat top center;height:11px;">
												<td colspan=2></td>
											</tr>
										</table>
		
									</div>
									</span>
								</div>
							</div>
						</div>
					</span>
				</a>				
			</td>