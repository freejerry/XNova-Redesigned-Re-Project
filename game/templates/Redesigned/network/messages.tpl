<script language="JavaScript">
function f(target_url, win_name) {
	var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
	new_win.focus();
}
</script>


<!-- CONTENT AREA -->

<div id="netz">
<div id="message">
<div id="inhalt">
	<div id="planet" class="">
		<h2>Messages</h2>
	</div>
	<div class="c-left"></div>
	<div class="c-right"></div>
		
	<div id="tabs">
		<ul id="tabsabove">
			<li>
				<a href="#" onclick="loadpage('./?page=messages','{Messages}','messages');" title="{Messages}">
					<span>{Messages}</span>
				</a>
			</li>
			<li>
				<a href="#" onclick="loadpage('./?page=network','{Alliance}','network');" title="{Alliance}">
					<span>{Alliance}</span>
				</a>
			</li>
			<li>
				<a href="#" onclick="mrbox('./?page=cerca&iframe=1&iheight=800',800)" title="{Search}" class="ajax_thickbox">
					<span>{Search}</span>
				</a>
			</li>
		</ul>

		<ul class="tabsbelow" id="tab-msg">
			<li class="msgNavi{activein}" id="1" value="6">
				<a href="#" onclick="
					document.getElementById('mailWrapper').innerHTML = '<div id=\'messageContent\' class=\'msg_content textBeefy textCenter\'><img src=\'{{skin}}/img/ajax-loader.gif\' /> Loading</div>';
					getAXAH('./?page=messages&messcat=0&axah_section=1','mailWrapper');
					document.getElementById('1').className = 'msgNavi aktiv'
					document.getElementById('2').className = 'msgNavi'
					document.getElementById('3').className = 'msgNavi'
					" title="{Inbox}">
					<span>{Inbox}</span>
				</a>
			</li>
			<li class="msgNavi{activeout}" id="2" value="3" {hidenc}>
				<a href="#" onclick="
					document.getElementById('mailWrapper').innerHTML = '<div id=\'messageContent\' class=\'msg_content textBeefy textCenter\'><img src=\'{{skin}}/img/ajax-loader.gif\' /> Loading</div>';
					getAXAH('./?page=messages&messcat=101&axah_section=1','mailWrapper');
					document.getElementById('1').className = 'msgNavi'
					document.getElementById('2').className = 'msgNavi aktiv'
					document.getElementById('3').className = 'msgNavi'
					" title="{Outbox}">
					<span>{Outbox}</span>
				</a>
			</li>
			<li class="msgNavi{activebin}" id="3" value="3" {hidenc}>
				<a href="#" onclick="
					document.getElementById('mailWrapper').innerHTML = '<div id=\'messageContent\' class=\'msg_content textBeefy textCenter\'><img src=\'{{skin}}/img/ajax-loader.gif\' /> Loading</div>';
					getAXAH('./?page=messages&messcat=666&axah_section=1','mailWrapper');
					document.getElementById('1').className = 'msgNavi'
					document.getElementById('2').className = 'msgNavi'
					document.getElementById('3').className = 'msgNavi aktiv'
					" title="{RecycleBin}">
					<span>{RecycleBin}</span>
				</a>
			</li>
		</ul>
	</div>

	<div id="vier">
		<div class="sectioncontent" id="section2">
			<div class="contentz" style="background-position:7px 0px;">
				<div class="mailWrapper" id="mailWrapper">
					{catag}
					<div id="messageContent" class="msg_content textBeefy textCenter">
						{content}
					</div>			   
				</div>
				<div class="h10"></div>
			</div><!-- contentz -->
			<div class="footer" style="margin-left:2px;"></div>
		</div>
	</div>

</div></div></div>

<!-- END CONTENT AREA -->