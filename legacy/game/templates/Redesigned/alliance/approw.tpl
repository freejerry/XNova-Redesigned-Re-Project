				<tr class="alt">
					<td class="nr">{n}.</td>
					<td class="desc">{username}</td>
					<td class="desc">{applied}</td>
					<td class="action"></td>
				</tr>				
				<tr class="alt">
					<td colspan="3" class="message">{ally_request_text}</td>
			   		<td class="action">
						<a onclick="loadpage('./?page=network&mode=apps&action=acc&id={id}','{Alliance}','network'); document.getElementById('apps_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" href="#" title="Accept applicant" class="tips">
						   <img src="{{skin}}/img/icons/checkmark.gif" />
						</a>
						<a onclick="loadpage('./?page=network&mode=apps&action=dec&id={id}','{Alliance}','network'); document.getElementById('apps_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" href="#" title="Deny applicant" class="tips">
						   <img src="{{skin}}/img/icons/against.gif" />
						</a>
					</td>
				</tr>
				<tr class="alt">
					<td colspan="3" class="response">
						<a class="button188" onclick="FlickDisplay('reply{n}','table-row');" href="#">answer</a>
					</td>
					<td class="response"></td>
				</tr>
				<tr id="reply{n}" style="display:none; background-color:#1c1c1c;">
					<td colspan="4">
						<form action="./?page=network&mode=apps&id={id}" method="POST">
							<table style="width:581px;">					
								<tr>
									<td class="desc">Reason <span id="cntChars">0</span>/2000 characters</td>
									<td>
										<textarea style="width:345px; height:70px; background-color:#1c1c1c; color:#e3e3e3;" name="text" onkeyup="javascript:cntchar(2000)" id="reason{id}"></textarea>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<a onclick="loadpage('./?page=network&mode=apps&action=acc&id={id}&message='+document.getElementById('reason{id}').value,'{Alliance}','network'); document.getElementById('apps_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" href="#">
											<img src="{{skin}}/img/icons/checkmark.gif" style="border:0px;" />
										</a>
										
										<a onclick="loadpage('./?page=network&mode=apps&action=dec&id={id}&message='+document.getElementById('reason{id}').value,'{Alliance}','network'); document.getElementById('apps_contentz').innerHTML = '<p align=center><img src=\'{{skin}}/img/ajax-loader.gif\' /> {Loading}</p>'; return false;" href="#">
											<img src="{{skin}}/img/icons/against.gif" style="border:0px;" />
										</a>
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>		   
			</table> 