{header_tpl}

  			<div id="vier">
			<div class="section">
                <h3>
                    <a id="link11" class="opened" href="#" onclick="ReverseDisplay('section11');">
                 	   <span>{apply}</span>
                    </a>
                </h3>
			</div>

			<div class="sectioncontent" id="section11" style="display: block;">
			<div class="contentz">

			<form action="./?page=network&mode=apply" method="get" id="request_form">
				<input type="hidden" name="id" value="{allyid}" />
                <table class="createnote" border="1">
                    <tbody><tr>
                 	   <td class="textCenter">{Write_application}</td>
                    </tr>
                    <tr>
                   	 	<td>
                    		<textarea name="text" rows="10" onkeyup="javascript:cntchar(6000)"></textarea>
                     	</td>
                    </tr>
                    <tr>
	                    <td class="textCenter">{Requesttext} (<span id="cntChars">0</span> / 6000 {characters})</td>
                    </tr>
                    <tr>
    	                <td><input class="buttonSave" name="send_request" value="{send}" type="button" onclick="submitform('request_form','{Alliance}','network');"></td>
                    </tr>
                </tbody></table>
			</form>
			</div><!--contentdiv -->
			<div class="footer"></div>
			</div><!-- section11 -->
			</div>
    	    

		</div> 	</div> </div> <!-- END CONTENT AREA -->

