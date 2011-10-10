<!-- HEADER -->
<div id="box">
<a name='anchor'></a>
	<div id="info">
   	<a id="changelog_link" href="index.php?page=changelog&session=415ef0c90c0f">universe 681 v 0.99</a>
    <div id="bar">
		<ul>
        	<li><a href="index.php?page=preferences&session=415ef0c90c0f">Options</a></li>

        	<li><a href="index.php?page=statistics&session=415ef0c90c0f">Highscore			(416)        	</a></li>
        	<li><a href="index.php?page=networkmsearch&session=415ef0c90c0f">search</a></li>
        	<li><a href="http://tutorial.ogame.de/" target="_blank">Help</a></li>
        	<li><a href="http://board.ogame.org/" target="_blank">Board</a></li>
        	<li><a href="http://board.ogame.de/thread.php?threadid=435281" target="_blank">Rules</a></li>
        	<li><a href="http://impressum.gameforge.de/index.php?lang=en&art=impress&special=&&f_text=b1daf2&f_text_hover=ffffff&f_text_h=061229&f_text_hr=061229&f_text_hrbg=061229&f_text_hrborder=9EBDE4&f_text_font=arial%2C+arial%2C+arial%2C+sans-serif&f_bg=000000" target="_blank">Imprint</a></li>

        	<li><a href="index.php?page=logout&session=415ef0c90c0f">Log out</a></li>            
        </ul>
    </div>
    	<ul id="resources">
        	<li class="metal tips" 
            	title="|Metal: 457">
                <img src="../img/navigation/ressourcen_metall.gif" />
                    <span class="value">
                    	<font id="resources_metal" >
                    	   457                        </font>

                   </span>
            </li>
        	<li class="crystal tips" 
            	title="|Crystal: 493">
                <img src="../img/navigation/ressourcen_kristal.gif" />
                <span class="value">
                	<font  id="resources_crystal" > 
						493                    </font>
                </span>
            </li>

        	<li class="deuterium tips" 
            	title="|Deuterium: 0">
                <img src="../img/navigation/ressourcen_deuterium.gif" />
                <span class="value">
                	<font  id="resources_deuterium" > 
						0                    </font>
               	</span>
            </li>
        	<li class="energy tips" 
            	title="|Energy: 0">
				<img src="../img/navigation/ressourcen_energie.gif" />

                    <span class="value">
                    	<font  id="resources_energy"
							>0</font>                    </span>
            </li>
			<li	class="darkmatter tips" 
            	title="|Dark Matter: 0">
                		<a href="index.php?page=premium&session=415ef0c90c0f">
                    		<img src="../img/navigation/ressourcen_DM.gif" />
                    	</a>
                    <span class="value">0</span>

            </li>                                      
      </ul>
      	<div id="officers">
      	  	
			<a href="index.php?page=premium&session=415ef0c90c0f" class="tips" title="|Hire commander">
            	<img src="../img/navigation/commander_ikon_un.gif">
            </a>        
      	 
			<a href="index.php?page=premium&session=415ef0c90c0f" class="tips" title="|Hire admiral">
            	<img src="../img/navigation/admiral_ikon_un.gif">
            </a>
      	 
			<a href="index.php?page=premium&session=415ef0c90c0f" class="tips" title="|Hire engineer">

            	<img src="../img/navigation/ingenieur_ikon_un.gif">
            </a>
      	 
			<a href="index.php?page=premium&session=415ef0c90c0f" class="tips" title="|Hire geologist">
            	<img src="../img/navigation/geologe_ikon_un.gif">
            </a>
      	 
			<a href="index.php?page=premium&session=415ef0c90c0f" class="tips" title="|Hire technocrat">
            	<img src="../img/navigation/technokrat_ikon_un.gif">
            </a>
        </div>

		<div id="selectedplanet">
	
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="129" height="97">
	            <param name="movie" value="/game/img/swf/ice/ice_9.swf">
	            <param name="quality" value="high">
                <param name="wmode" value="opaque">
	            <embed src="../img/swf/ice/ice_9.swf" wmode="opaque" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="129" height="97"></embed>
	         </object>
		</div>

    		  		<div id="message-wrapper">
  			<div id="message_alert_box" style="visibility:hidden;">
        		<a 	href="index.php?page=networkm&session=415ef0c90c0f" 
                	class="tips" 
                    title="|0 new message(s)">
                    <img src="img/layout/pixel.gif" height="13" width="25"/>
                </a>
        	</div>
			<div id="messages_collapsed" style="position:relative;">
        					</div>
						<div id="attack_alert" style="visibility:hidden;">

		        <a 	href="#" 
                	onClick="mySlider.open();" 
                    class="tips" 
                    title="|Attack!">
	                    <img src="img/layout/pixel.gif" height="13" width="25"/>
                </a>
	        </div>
	        <br class="clearfloat" />
		</div><!-- #message-wrapper -->
        
        <div style="position:absolute; top:121px; left:887px; width:95px; height:16px; color:cyan; font-size:11px; text-align:center">
        	Homeworld        </div>        
 </div><!-- Info -->

<!-- ERRORBOX -->
<div id="decisionTB" style="display:none;">
	<div id="errorBoxDecision">
	    <div id="wrapper">
	        <h4 id="errorBoxDecisionHead">-</h4>
	        <p id="errorBoxDecisionContent">-</p>
	        <div id="response">
	            <div style="float:left; width:195px; height:25px;">

				    <a href="#" onClick="handleErrorBoxClick('yes');return false;" class="yes"><span id="errorBoxDecisionYes">.</span></a>
	            </div>
	            <div style="float:left; width:195px; height:25px;">
				    <a href="#" onClick="handleErrorBoxClick('no');return false;" class="no"><span id="errorBoxDecisionNo">.</span></a>
	            </div>
	            <br class="clearfloat" />
	        </div>
	    </div>    
	</div> 

</div>

<div id="notifyTB" style="display:none;">
	<div id="errorBoxNotify">
	    <div id="wrapper">
	        <h4 id="errorBoxNotifyHead">-</h4>
	        <p id="errorBoxNotifyContent">-</p>
	        <div id="response">
	            <div>

				    <a href="#" onClick="handleErrorBoxClick('ok');return false;" class="ok">
	                	<span id="errorBoxNotifyOk">.</span>
	                </a>
	            </div>
	            <br class="clearfloat" />
	        </div>
	    </div>    
	</div> 
</div>

<!-- END ERRORBOX -->

<!-- END HEADER -->
