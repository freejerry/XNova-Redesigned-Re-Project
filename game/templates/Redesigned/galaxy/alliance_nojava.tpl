				<a>
					<span class="allytagwrapper TTgalaxy" rel="#alliance{ally_id}">{ally_tag}</span>
					<span class="mrtooltip" style="background-color:transparent;border:0px;top:{tooltip_height}px;left:525px;">
						<div id="alliance{ally_id}">
							<div id="TTWrapper">
								<div id="tooltipBody" class="tooltipBody">	
									<span class='tooltip_sticky'>
										<div class="TTInner" id="TTAlly">
											<table cellpadding="0" cellspacing="0">
												<tr><th><span class="spacing">Alliance {ally_name}</span></th></tr>
			
												<tr class="body">
													<td class="actions">
														<ul>
															<li class="rank">Rank: {ally_rank}</li>
															<li class="members">Member: {ally_members}</li>
															<li><a href="./?page=ainfo&allyid={ally_id}" target="_ally">Alliance Page</a></li>
															<li><a href="./?page=statistics&who=ally&start={ally_rank}">Statistics</a></li>
			
															<li><a href="./?page=network&bewerbung={ally_id}">apply</a></li>
														</ul>
													</td>
												</tr>
												<tr class="footer" style="background:url('{{skin}}/img/tooltip/ttfooter.gif') no-repeat top center;height:11px;">
													<td></td>
												</tr>
											</table>		
										</div>
									</span>
								</div>
							</div>
						</div>
					</span>
				</a>