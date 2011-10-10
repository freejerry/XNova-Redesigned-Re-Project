<div id="merchant" style="width:639px; padding:8px 15px; margin-left:auto; margin-right:auto; position:static; margin-top:100px;">
	<div style="margin:0px auto;">
        <a onclick="mrbox_close(); return false;" href="#" class="close_details" style="position:absolute; right:13px; top:9px;"></a>
		<h3 style="margin-top:-5px;">{trader_buying} {ResourceA}</h3>
    	<br class="clearfloat" /><br />
		<form action="./?page=trader" method="post" id="tradeform">
			<input type="hidden" name="ress" value="{resa}" />
			<table id="merchanttable" cellpadding="0" cellspacing="0">

				<tr>
					<td></td>
		            <td></td>
		            <td>{free_storage}</td>
					<td>{ex_rate}
						<!--<a href="#" class="ajaxTips2" title="{new_ex_rate}!<br />Costs: 2.500 Dark Matter" >
		                    <img src="{{skin}}/img/icons/graph.gif" height="16" width="16" />
		                </a>-->
		            </td>
				</tr>
    			
				<tr class="alt">
					<td>{ResourceA}</td>
					<td><span id="trad_{resa}">0</span><input type="hidden" id="trad_{resa}_raw" value="0" /></td>
					<td>---</td>
					<td class="rate"><span class="ajaxTips2">{tradea}</span></td>
    			</tr>
				
    			
    			
				<tr class="">
					<td>{ResourceB}</td>
    				<td>
						<input type="text" tabindex="1" class="textinput" size="9" name="{resb}" id="trad_{resb}" value="0" style="text-align: right;" onkeyup="if(this.value < 0){ this.value = 0; } if(this.value > {storage_b}){ this.value = {storage_b}; } trader_update('{resa}','{resb}','{resc}','{tradea}','{tradeb}','{tradec}','b');" />
		                <a href="#" onClick="document.getElementById('trad_{resb}').value={storage_b}; trader_update('{resa}','{resb}','{resc}','{tradea}','{tradeb}','{tradec}','b');" class="ajaxTips" title="Exchange maximum amount">
						    <img src="{{skin}}/img/navigation/icon-max-small.gif" width="14" height="11" />
						</a>
					</td>
					<td><span id="b_storage">{storage_bp}</span></td>
					<td class="rate ajaxTips2" title="{tradea} {ResourceA} = {tradeb} {ResourceB}">{tradeb}</td>
    			</tr>
    			
				<tr class="alt">
					<td>{ResourceC}</td>
					<td>
						<input type="text" tabindex="2" class="textinput" size="9" name="{resc}" id="trad_{resc}" value="0" style="text-align: right;" onkeyup="if(this.value < 0){ this.value = 0; } if(this.value > {storage_c}){ this.value = {storage_c}; } trader_update('{resa}','{resb}','{resc}','{tradea}','{tradeb}','{tradec}','c');" />
		                <a href="#" onClick="document.getElementById('trad_{resc}').value={storage_c}; trader_update('{resa}','{resb}','{resc}','{tradea}','{tradeb}','{tradec}','c');" class="ajaxTips" title="Exchange maximum amount">
						    <img src="{{skin}}/img/navigation/icon-max-small.gif" width="14" height="11" />
						</a>
					</td>
					<td><span id="c_storage">{storage_cp}</span></td>
					<td class="rate ajaxTips2" title="{tradea} {ResourceA} = {tradec} {ResourceC}">{tradec}</td>
    			</tr>
    			
				<tr>
					<td colspan="4" style="padding:10px">
						{storage_info}
						<input type="button" tabindex="3" name="tradebutton" class="button188" value="Trade resources!" onClick="submitform('tradeform',document.title,document.body.id); mrbox_close();" />
					</td>
		            <!--<td class="rate rate2" style="padding:3px 0px;">
		                <a 	onmouseover="image.src='{{skin}}/img/icons/graph_a.gif';"
		                	onMouseOut="image.src='{{skin}}/img/icons/graph.gif';"
		                    href="#" onclick="callTrader(2); return false;"
		                    style="display:block;"
		                    class="" title="">
			                <span style="font-size:9px;">{new_ex_rate}<br /><br /></span>
			                <img name="image" src="{{skin}}/img/icons/graph.gif" height="32" width="32" />
			                <br />
			                <span style="font-size:9px;">Costs:<br />2.500 Dark Matter</span>
						</a>
		            </td>-->
				</tr>
			</table>
		</form>
	</div><!-- wrapper -->
</div><!-- merchant -->
