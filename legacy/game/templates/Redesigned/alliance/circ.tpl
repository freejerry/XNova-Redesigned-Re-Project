{header_tpl}

<div id="drei" style="display:block;">
	<div class="section">
		<h3>
			<a id="link31" class="opened" href="javascript:void(0);" onclick="ReverseDisplay('section31'); SwapClass('link31','opened','closed');">
				<span>Send a circular message to all alliance members</span>
			</a>
		</h3>
	</div>
	<form action="./?page=network&mode=circ" method="post" name="asdf">
	<div class="sectioncontent" id="section31" style="display:block;">
		<div class="contentz allycomm">
			<table id="dissolveally">
				<tr>
					<td class="desc textBeefy">To::</td>
					<td>
						<select size="1" name="rank" class="dropdown">
							<option value="all" class="underlined">all players</option>
							{ranks}
						</select>
					</td>
				</tr>
				<tr>
					<td class="desc textBeefy">Mail text (<span id="cntChars">0</span> / 2000 characters)</td>
					<td class="textLeft"><textarea name="text" onkeyup="javascript:cntchar(2000)"></textarea></td>
				</tr>
				<tr>
					<td colspan="2"><input class="buttonSave" type="submit" value="send" name="submitMail" /></td>
				</tr>
			</table>
			<div class="h10"></div>
		</div><!--contentdiv -->
		<div class="footer"></div>
	</div><!-- section11 -->
	</form>
</div>

</div>
</div>
</div> <!-- END CONTENT AREA -->