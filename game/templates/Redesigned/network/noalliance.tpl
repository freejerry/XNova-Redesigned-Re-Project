<!-- CONTENT AREA -->

<div id="netz">
	<div id="alliance">
		<div id="inhalt">
			<div id="planet" style="background-image:url({{skin}}/img/header/network/allianz_header.jpg); z-index:50;">
				<h2>Alliance</h2> 	
			</div>			
			<div class="c-left"></div>
			<div class="c-right"></div>

			{tabs}

		
    				<div id="drei">
			<div class="section">
                <h3>
                    <a id="link11" class="opened" href="#" onclick="show_hide_menus('section11'); change_class('link11');">
                    <span>Create a new alliance</span>
                    </a>
                </h3>
			</div>

			
			<script type="text/javascript">
			function sendFormData() {
			document.shipBuild.submit();
			}
			</script>
			
			<form action="./?page=network&mode=make&yes=1" method="post" name="asdf">
			<div class="sectioncontent" id="section11" style="display:block;">
			<div class="contentz">
			<table class="createnote createALLY">
                <tr>
    	            <td class="desc">{alliance_tag} (3-8 {characters}):</td>
                	<td class="value"><input class="textInput" style="padding:3px;" type="text" size="8" name="atag" maxlength="8" value=""></td>

                </tr>
                <tr>
	                <td class="desc">{allyance_name} (3-30 {characters}):</td>                
  	             	<td class="value"><input class="textInput" style="padding:3px;" type="text" size="30" name="aname" maxlength="30" value=""></td>
                </tr> 
                <tr>
               		 <td colspan="2" align="center"><input class="button188" type="submit" value="{Make}"></td>
                </tr>
			</table>

			</div><!--contentdiv -->
			<div class="footer"></div>
			</div><!-- section11 -->
			</form>       
			</div>        

		</div> 	</div> </div> <!-- END CONTENT AREA -->
