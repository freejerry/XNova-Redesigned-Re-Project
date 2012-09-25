<html>
<body style="text-align:center;" text="#FFFFFF">
<?php
define("ROOT_PATH","./game/");
define("UNIVERSE",1);
define("INSIDE",true);
include("game/modules/database.php");
if($game_config['disable_registration'] == 0)
{
?>
<div style="width:699px;margin-left:auto;margin-right:auto;">
	<div style="background-image:url('images/top.gif');height:30px;width:670px;margin-left:auto;margin-right:auto;text-align:center;">
		<div style="margin-top:30px;margin-left:20px;margin-right:20px;padding-top:6px;">Registration</div>
	</div>
	<div style="background-image:url('images/mid.gif');width:670px;margin-left:auto;margin-right:auto;">
		<div style="margin-left:25px;margin-right:10px;">
			In order to play you only have to enter a username, a password and an E-Mail address and proceed to read the terms and conditions before activating the check box about your agreement to them.
		</div>
		<br /><br />
		<center>
			<iframe src="game/register.html" width="90%" height="400" align="center" frameborder="0" border="0" style="boder:0px;"></iframe>
		</center>
	</div>
	<div style="background-image:url('images/bot.gif');height:15px;width:670px;margin-left:auto;margin-right:auto;"></div>
</div>
<?php
}
else
{
?>
<font size="3" color="red"><strong>We are sorry, but registration to this server is disabled.</strong></font>
<?php
}
?>
</body>
</html>
