		<form method="GET" action="./?page={page}&id={id}" name="shipyard" id="shipyard">
		<input type="hidden" name="fmenge" value="{id}" />
		
		<div id="detail{id}" class='detail_screen' style="display:none;">
			<div id="pic" class="pic">
				<img src="{{skin}}/img/Xlarge/xlarge_{id}.jpg" width="200" height="200" onload="document.getElementById('detail{id}').style.display='block';fadeIn('detail{id}',0);" />
			</div>
			<div id="content">
				<h2>{name}</h2>
				<span class="level">Number: {level}</span>
				<a id="close{id}" class="close_details" href="#" onclick="fadeOut('detail{id}',100,true)"></a>
				<div class="clearfloat"></div>
				<div id="costswrapper" style="margin-top:10px;">
					Costs per piece:
					<div id="costs">
						<ul id="resources">
							<li class="metal tips">
								<a>
									<img src="{skin}/img/layout/ressourcen_metall.gif"><br>
									<span class="{missing_resource_m}">{sh_cost_m}</span>
									<span class="mrtooltip">{cost_m} Metal</span>
								</a>
							</li>
							<li class="metal tips">
								<a>
									<img src="{skin}/img/layout/ressourcen_kristal.gif"><br>
									<span class="{missing_resource_c}">{sh_cost_c}</span>
									<span class="mrtooltip">{cost_c} Crystal</span>
								</a>
							</li>
							<li class="metal tips">
								<a>
									<img src="{skin}/img/layout/ressourcen_deuterium.gif"><br>
									<span class="{missing_resource_d}">{sh_cost_d}</span>
									<span class="mrtooltip">{cost_d} Deuterium</span>
								</a>
							</li>
							<li class="enter">
									<input type="text" size="5" name="{id}" id="curr{id}" value="1" />
									<p>Number<br/></p>
							</li>
						</ul>
						
						<!--<a class="{buildit_class}" href="{build_link}">
							<span class="textlabel">{build_text}</span>
						</a>-->
						<a class="{buildit_class}" href="#" onclick="loadpage('{build_link}'+document.getElementById('curr{id}').value,document.title,document.body.id)">
							<span class="textlabel">{build_text}</span>
						</a>
						<br class="all"/>
					</div>
					
					<div id="action">
						<ul>
							<li>Production duration <span class="time">{duration}</span></li>
							<li class="techtree">
								<a onclick="mrbox('./?page=techdata&opt=tree&id={id}&iframe=1&iheight=800',800)" href="#" class="tips">
									<span class="pic"></span>
									<span class="label">Techtree</span>
									<span class="mrtooltip">Open techtree</span>
								</a>
							</li>
						</ul>
					</div>
				</div>		 
			</div>
			<br clear="all"/>
			<div id="description">
				<p style="float:left">
					<a class="tips help" href="./?page=techdata&opt=detail&id={id}" title="|More details"></a>
					{shortdesc}
				</p>
			</div>
		</div>
		
		</form>