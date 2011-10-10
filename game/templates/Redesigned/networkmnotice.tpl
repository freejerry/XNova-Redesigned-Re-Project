<!-- CONTENT AREA -->
<div id="netz">
<div id="message">
<div id="inhalt">  
    <div id="planet" style="background-image:url({{skin}}/img/header/network/allianz_header.jpg); z-index:50;">
        <h2>Messages</h2> 	
    </div>

    <div class="c-left"></div>
    <div class="c-right"></div>
		
    {tabs}
    
    <br class="clearfloat"/>
    <!-- Notizen -->                 
       <div id="drei" style="display:block;">

		<div class="section">
        	<h3>
            	<a id="link32" 
                title="My notes" 
                class="opened" 
                href="#" 
                onclick="show_hide_menus('section32'); change_class('link32');">
            		<span>My notes ({count})</span>
                </a>
            </h3>
		</div>		 <div class="sectioncontent" id="section32" style="display:block;">
        	<div class="contentz">

				<form method="post" action="">
				<table cellpadding="0" cellspacing="0" id="notizen">

					<tr class="alt">

						<td colspan="5" align="center">{page}</td>
					</tr>
                </table>
				</form>
                <div class="h10"></div>
            </div><!--contentdiv -->
        	<div class="footer"></div>
        </div>                         
       </div>     
	</div>

</div>
</div><!-- END CONTENT AREA -->
