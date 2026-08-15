<script language="JavaScript" type="text/javascript">
var chat_type = "{chat_type}";
var ally_id = "{ally_id}";
</script>
<script language="JavaScript" type="text/javascript" src="scripts/chat.js"></script>


	<br><br>
	
	<form action="chat_add.php" method="POST">
	
	<table align="center" width='100%'><tbody>
	
	<tr><td class="c"><b>{chat_disc} {ally_id}</b></td></tr>
	
	<tr><th><div id="shoutbox" style="margin: 5px; vertical-align: text-top; height: 360px; overflow:auto;"></div></th></tr>
	
	<tr><th nowrap>
	{chat_message}: <input name="msg" type="text" id="msg" style="width:80%" maxlength="120" onKeyPress="if(event.keyCode == 13){ addMessage(); } if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"> 
	<div nowrap>
	<img src="../images/smileys/img.png" align="absmiddle" title="img" alt="img" width="12" height="12" onClick="addSmiley('[img]{Enter URL}[/img]&nbsp;&nbsp;')">
	<img src="../images/smileys/url.png" align="absmiddle" title="url" alt="url" width="12" height="12" onClick="addSmiley('[url={Enter URL}]{Enter Text}[/img]&nbsp;&nbsp;')">
	&nbsp;&nbsp;
	<img src="../images/smileys/b.png" align="absmiddle" title="b" alt="b" width="12" height="12" onClick="addSmiley('[b] {Enter Text} [/b]&nbsp;&nbsp;')">
	<img src="../images/smileys/i.png" align="absmiddle" title="i" alt="i" width="12" height="12" onClick="addSmiley('[i] {Enter Text} [/i]&nbsp;&nbsp;')">
	<img src="../images/smileys/u.png" align="absmiddle" title="u" alt="u" width="12" height="12" onClick="addSmiley('[u] {Enter Text} [/u]&nbsp;&nbsp;')">
	&nbsp;&nbsp;
	<img src="../images/smileys/cry.png" align="absmiddle" title=":c" alt=":c" width="12" height="12" onClick="addSmiley(':c')">
	<img src="../images/smileys/confused.png" align="absmiddle" title=":/" alt=":/" width="12" height="12" onClick="addSmiley(':/')">
	<img src="../images/smileys/dizzy.png" align="absmiddle" title="o0" alt="o0" width="12" height="12" onClick="addSmiley('o0')">
	<img src="../images/smileys/happy.png" align="absmiddle" title="^^" alt="^^" width="12" height="12" onClick="addSmiley('^^')">
	<img src="../images/smileys/lol.png" align="absmiddle" title=":D" alt=":D" width="12" height="12" onClick="addSmiley(':D')">
	<img src="../images/smileys/neutral.png" align="absmiddle" title=":|" alt=":|" width="12" height="12" onClick="addSmiley(':|')">
	<img src="../images/smileys/smile.png" align="absmiddle" title=":)" alt=":)" width="12" height="12" onClick="addSmiley(':)')">
	<img src="../images/smileys/omg.png" align="absmiddle" title=":o" alt=":o" width="12" height="12" onClick="addSmiley(':o')">
	<img src="../images/smileys/tongue.png" align="absmiddle" title=":p" alt=":p" width="12" height="12" onClick="addSmiley(':p')">
	<img src="../images/smileys/sad.png" align="absmiddle" title=":(" alt=":(" width="12" height="12" onClick="addSmiley(':(')">
	<img src="../images/smileys/wink.png" align="absmiddle" title=";)" alt=";)" width="12" height="12" onClick="addSmiley(';)')">
	<img src="../images/smileys/shit.png" align="absmiddle" title=":s" alt=":s" width="12" height="12" onClick="addSmiley(':s')">
	&nbsp;&nbsp;
	<select name="colour">
		<option value="white">White</option>
		<option value="blue">Blue</option>
		<option value="yellow">Yellow</option>
		<option value="green">Green</option>
		<option value="pink">Pink</option>
		<option value="red">Red</option>
		<option value="orange">Orange</option>
	</select>
	&nbsp;&nbsp;
	<!--
	<input type="button" name="send" value="{chat_send}" id="send" onClick="addMessage()">
	&nbsp;&nbsp;
	&nbsp;&nbsp;
	-->
	<input type="hidden" name="ally_id" value="{ally_id}" />
	<input type="hidden" name="chat_type" value="{chat_type}" />
	<input type="submit" name="send" value="{chat_send}" id="send" />
	&nbsp;&nbsp;
	&nbsp;&nbsp;
	<input type="button" name="send" value="{chat_history}" id="send" onClick="MessageHistory()">
	</div>
	</th></tr>
	</tbody></table>
