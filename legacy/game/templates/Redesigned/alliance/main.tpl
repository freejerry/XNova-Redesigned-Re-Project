{header_tpl}

<div id="eins">
	<div class="section">
		<h3>
			<a id="link11" class="opened" href="#" onclick="ReverseDisplay('section11');SwapClass('link11','opened','closed');">
				<span>Your alliance</span>
			</a>
		</h3>
	</div>

	<form target="" method="post" name="asdf">
	<div class="sectioncontent" id="section11" style="display:block;">
		<div class="contentz">
			<table class="members bborder">
				<tr class="alt">
					<td class="desc textRight">Name:</td>
					<td class="value"><span>{name}</span></td>
				</tr>
				<tr>
					<td class="desc textRight">Tag:</td>
					<td class="value"><span>{tag}</span></td>
				</tr>
				<tr class="alt">
					<td class="desc textRight">Member:</td>
					<td class="value"><span>{members}</span></td>
				</tr>
				<tr>
					<td class="desc textRight">Your Rank:</td>
					<td class="value"><span>{yourrank}</span></td>
				</tr>
				<tr class="alt">
					<td class="desc textRight">Homepage:</td>
					<td class="value"><span><a href="{www}" target="_blank">{www}</a></span></td>
				</tr>
			</table>
			<div class="h10"></div>
		</div><!--contentdiv -->
		<div class="footer"></div>
	</div><!-- section11 -->
	</form>

{memberlist}

	<div class="section">
		<h3>
			<a id="link13" class="closed" href="javascript:void(0);" onclick="ReverseDisplay('section13');SwapClass('link13','opened','closed');">
			   <span>Internal Area</span>
			</a>

		</h3>
	</div>
	<div class="sectioncontent" id="section13" style="display:none;">
		<div class="contentz">
			<div id="allypage" class="bborder">
			{internal}
			</div>
			<div class="h10"></div>
		</div><!--contentdiv -->
		<div class="footer"></div>
	</div><!-- section13 -->



	<div class="section">
		<h3>
			<a id="link14" class="closed" href="javascript:void(0);" onclick="ReverseDisplay('section14');SwapClass('link14','opened','closed');">
			   <span>External Area</span>
			</a>
		</h3>
	</div>

	<div class="sectioncontent" id="section14" style="display:none;">
		<div class="contentz">
			<div id="allypage" class="bborder">
			{external}
			</div>
			<div class="h10"></div>
		</div><!--contentdiv -->
		<div class="footer"></div>
	</div><!-- section14 -->
	
    <div class="section" style="{leave_style}">
		<h3>
			<a id="link15" class="closed" href="javascript:void(0);" onclick="ReverseDisplay('section15');SwapClass('link15','opened','closed');">
				<span>Leave alliance</span>
			</a>
		</h3>
	</div>
	<div class="sectioncontent" id="section15" style="display:none;">
		<div class="contentz">
            <div id="allyinternpage">
                <form>
                    <input class="buttonSave" type="button" value="{next}" onClick="mr_qu('Are you sure you want to leave the alliance LIS?','Leave Alliance?','\'./?page=network&mode=leave\',\'{Alliance}\',\'network\'');" />
                </form>
            </div>
            <div class="h10"></div>
        </div><!--contentdiv -->
		<div class="footer"></div>
	</div><!-- section15 -->

	
</div>

</div>
</div>
</div> <!-- END CONTENT AREA -->
