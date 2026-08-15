				<a href="#" class="TTgalaxy" rel="#player{player_id}">
					<span class="status_abbr_inactive">{player_name}</span>
					<span class="mrtooltip" style="background-color:transparent;border:0px;top:{tooltip_height}px;left:400px;">
						<div id="player{player_id}">
							<div id="TTWrapper">
								<div id="tooltipBody" class="tooltipBody">
									<div class="TTInner" id="TTPlayer">
										<table cellpadding="0" cellspacing="0">
										<tr><th colspan="2"><span class="spacing">{player_name}</span></th></tr>
										<tr class="body">
											<td class="actions">
												<ul>
													<li class="rank">Ranking: {rank}</li>
													<li><a href="./?page=writemessage&to={player_id}&ajax=1&height=500&width={pos}50&TB_iframe=1&modal=true" class="thickbox">Message</a></li>
													<li><a href="./?page=networkbuddy&action=6&buddy_id={player_id}&site=2">Buddy request</a></li>
													<li><a href="./?page=statistics&start={player_rank}">Statistic</a></li>
												</ul>
											</td>
											<td class="actions">
												{avatar_small}
											</td>
										</tr>
										<tr class="footer" style="background:url('{{skin}}/img/tooltip/ttfooter.gif') no-repeat top center;height:11px;">
											<td colspan="2"></td>
										</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</span>
				</a>
				<!--<span class="status">(<span class='status_abbr_inactive'><span class="status_abbr_inactive">i</span></span>)</span>-->{status}
