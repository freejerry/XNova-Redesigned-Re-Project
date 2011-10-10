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

	<br class="clearfloat"/>
	<div id="eins">

	<div class="section">
	<h3>
	<a id="link11" class="opened" href="#" onclick="show_hide_menus('section11'); change_class('link11');">
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
                    <td class="value"><span>{ally_name}</span></td>
                </tr>
                <tr>

                    <td class="desc textRight">Tag:</td>
                    <td class="value"><span>{ally_tag}</span></td>
                </tr>
                <tr class="alt">
                    <td class="desc textRight">Member:</td>
                    <td class="value"><span>{member_count}</span></td>
                </tr>

                <tr>
                    <td class="desc textRight">Your Rank:</td>
                    <td class="value"><span>{yourrank}</span></td>
                </tr>
                <tr class="alt">
                    <td class="desc textRight">Homepage:</td>
                    <td class="value"><span><a href="{homepage}" target="_blank">{homepage}</a></span></td>

                </tr>
            </table>
	        <div class="h10"></div>
        </div><!--contentdiv -->
        <div class="footer"></div>
	</div><!-- section11 -->
	</form>
    		<div class="section">
		<h3>
		<a id="link12" class="closed" href="javascript:void(0);" onclick="show_hide_menus('section12'); change_class('link12');">

		<span>Member List</span>
		</a>
		</h3>
		</div>
		<form target="" method="post" name="asdf">
		<div class="sectioncontent" id="section12" style="display:none;">
		<div class="contentz">
		<table class="members bborder" cellpadding="0" cellspacing="0">

			<tr>
			<th>ID</th>
			<th><a href="./?page=network&sort1=1&sort2=0">Name</a></th>
			<th> </th>
			<th><a href="./?page=network&sort1=2&sort2=0">Rank</a></th>
			<th><a href="./?page=network&sort1=3&sort2=0">Points</a></th>

			<th><a href="./?page=network&sort1=0&sort2=0">Coords</a></th>
			<th><a href="./?page=network&sort1=4&sort2=0">Joined</a></th>
	        	<th><a href="./?page=network&sort1=5&sort2=0">Online</a></th>
				<th>Function</th>
			</tr>
			<!--
	       	<tr class="">
				<td>1</td>
				<td>Anthony</td>
				<td></td>
				<td>Founder</td>
				<td>35</td>
				<td><a  href="./?page=galaxy&galaxy=1&system=98&position=9" >[1:98:9]</a></td>
				<td>2008-12-29 21:23:23</td>
				<td><span class="undermark">On</span></td>
				<td></td>
			</tr>
			-->
			{MemberList}
        </table>
        <div class="h10"></div>
		</div><!--contentdiv -->
		<div class="footer"></div>

		</div><!-- section11 -->
		</form>
    	<div class="section">
        <h3>
            <a id="link13" class="closed" href="javascript:void(0);" onclick="show_hide_menus('section13'); change_class('link13');">
               <span>Internal Area</span>
            </a>
        </h3>

	</div>
	<div class="sectioncontent" id="section13" style="display:none;">
        <div class="contentz">
            <div id="allypage" class="colour bborder">{internal_text}</div>
            <div class="h10"></div>
        </div><!--contentdiv -->
	<div class="footer"></div>
	</div><!-- section11 -->



	   <div class="section">

        <h3>
            <a id="link14" class="closed" href="javascript:void(0);" onclick="show_hide_menus('section14'); change_class('link14');">
               <span>External Area</span>
            </a>
        </h3>
    </div>
    <div class="sectioncontent" id="section14" style="display:none;">
        <div class="contentz">

            <div id="allypage" class="colour bborder">{external_text}</div>
            <div class="h10"></div>
        </div><!--contentdiv -->
    <div class="footer"></div>
    </div><!-- section11 -->


    	</div>




		</div> 	</div> </div> <!-- END CONTENT AREA -->
