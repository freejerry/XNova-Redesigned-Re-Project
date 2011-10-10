<script language="JavaScript">
storage      = new Array(0, 48609.2028626, 55189.8419419, 39738.5180216);
factor       = new Array(0, 2.73, 2, 0.98);
offer_id     = 2;
offer_amount = 19810;
offer_costs  = 0;
your_offer_id = 0;

function trySubmit()
{
    ajaxFormSubmit('TraderForm','index.php?page=trader_work&session=6aff7033a2cc',tradeDone);
}
</script>

<div id="merchant" style="width:639px; padding:8px 15px" onKeyPress="return submitOnEnter(event);">
	<div style="margin:0px auto;">
        <a onclick="mrbox_close(); return false;" href="#" class="close_details" style="position:absolute; right:13px; top:9px;"></a>
		<h3 style="margin-top:-5px;">Trader buying crystal</h3>
    	<br class="clearfloat" />
		<form id="marchand" action="./?page=trader" method="post" id="tradeform">
			<input type="hidden" name="ress" value="crystal" />
			<table id="merchanttable" cellpadding="0" cellspacing="0">

				<tr>
					<td></td>
		            <td></td>
		            <td>Free storage capacity</td>
					<td>Exchange rate
						<a href="#" onclick="callTrader(2); return false;"
                            class="ajaxTips2"
                            title="Get new exchange rate!<br />Costs: 2.500 Dark Matter" >
		                    <img src="{{skin}}/img/icons/graph.gif" height="16" width="16" />
		                </a>
		            </td>
				</tr>
				
				<tr class="alt">
					<td>Metal</td>
    				<td>
						<input type="text" tabindex="1" class="textinput" size="9" name="metal" id="metal" value="0" style="text-align: right;" onkeyup="if(this.value < 0){ this.value = 0; } document.getElementById('crystal').innerHTML = pretty_number(Math.round({tradec} * ((document.getElementById('metal').value / {tradem}) + (document.getElementById('deut').value / {traded}))));" />
		                <a href="#" onClick="document.getElementById('metal').value={MaxMetal}; return false;" class="ajaxTips" title="Exchange maximum amount">
						    <img src="{{skin}}/img/navigation/icon-max-small.gif" width="14" height="11" />
						</a>
					</td>
					<td><span id="1_storage">48.609</span></td>
					<td class="rate ajaxTips2" title="Get new exchange rate!|1 Crystal = 1.37 Metal">2.73</td>
    			</tr>
    			
				<tr class="">
					<td>Crystal</td>
					<td><span id="crystal">0</span></td>
					<td>---</td>
					<td class="rate"><span class="ajaxTips2" title="Get new exchange rate!|2 Crystal = 2.73 Metal, 0.98 Deuterium">2</span></td>
    			</tr>
    			
				<tr class="alt">
					<td>Deuterium</td>
					<td>
						<input type="text" tabindex="2" class="textinput" size="9" name="deut" id="deut" value="0" style="text-align: right;" onkeyup="if(this.value < 0){ this.value = 0; } document.getElementById('crystal').innerHTML = pretty_number(Math.round({tradec} * ((document.getElementById('metal').value / {tradem}) + (document.getElementById('deut').value / {traded}))));" />
	                    <a href="#" onClick="document.getElementById('metal').value={MaxMetal}; return false;" class="ajaxTips" title="|Exchange maximum amount">
						    <img src="{{skin}}/img/navigation/icon-max-small.gif" width="14" height="11" />
						</a>
					</td>
					<td><span id="3_storage">39.738</span></td>
					<td class="rate ajaxTips2" title="Get new exchange rate!|1 Crystal = 0.49 Deuterium">0.98</td>
    			</tr>
    			
				<tr>
					<td colspan="3" style="padding:10px">A trader only delivers as much resources as there is free storage capacity.						<input type="button" tabindex="3" name="tradebutton" class="button188" value="Trade resources!" onClick="trySubmit(); " />
					</td>
		            <td class="rate rate2" style="padding:3px 0px;">
		                <a 	onmouseover="image.src='img/icons/graph_a.gif';"
		                	onMouseOut="image.src='img/icons/graph.gif';"
		                    href="#" onclick="callTrader(2); return false;"
		                    style="display:block;"
		                    class="" title="">
			                <span style="font-size:9px;">New exchange rate<br /><br /></span>
			                <img name="image" src="img/icons/graph.gif" height="32" width="32" />
			                <br />
			                <span style="font-size:9px;">Costs:<br />2.500 Dark Matter</span>
						</a>
		            </td>
				</tr>
			</table>
		</form>
	</div><!-- wrapper -->
</div><!-- merchant -->