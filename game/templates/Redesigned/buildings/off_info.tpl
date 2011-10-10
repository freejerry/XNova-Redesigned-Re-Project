			<div class="detail_screen" id="detail" style="display:block;position:relative;background-image:url('{{skin}}/img/navigation/detail-bg250.gif');">
				<div id="pic{id}">
					<img src="{{skin}}/img/layout/pixel.gif" width="200" height="200"/>
				</div>
				<div id="content">	
					<h2 style="padding-left:0px;">{name}</h2>
										
					<span class="level"><font color="red">[inactive]</font></span>
					<a href="./?page=premium" class="close_details tips" id="close1"><span class="textlabel">close window</span></a>
					<br class="clearfloat">
					<div id="wrapper">
						<div id="features">
							<p>{long_desc}</p>
							<a href="./?page=premium&mode=2&time=1&offi={offi}" 
								class="build-it tips" title="|Hire {name}">
								<span class="textlabel tips">
									{1week}<br /> {oneweekcost} <br />{Matter}
								</span>
							</a>
							<a href="./?page=premium&mode=2&time=2&offi={offi}" 
								class="build-it tips" title="|Hire {name}">
								<span class="textlabel tips">
									{3month}<br /> {threemonthcost} <br />{Matter}
								</span>
							</a>
							<br class="clearfloat"/>
						</div>
					</div>
				</div>	 
				<br clear="all"/>
					<div id="description">
					<p>{sdesc}</p>
					<br clear="all"/>
				</div>
			</div>
			