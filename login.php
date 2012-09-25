<?php
session_start();
define('INSIDE' , true);
define('INSTALL' , false);
define('ROOT_PATH' , './game/');
define('UNIVERSE' , 1);
require_once(ROOT_PATH . 'modules/database.php');
$unis = array(1);
$sql = array();
$online = 0;
$users = 0;
$last_user = '';
$last_user_time = 0;
foreach($unis as $u){
	//Load the database settings
	require(ROOT_PATH.'config'.$u.'.php');
	//Load the database
	$sql[$u] = new database($dbsettings);
	//How many online?
	$result = $sql[$u]->doquery("SELECT COUNT('id') as `count` FROM {{table}} WHERE `onlinetime` > ".(time() - 900), 'users', true);
	$online += $result['count'];
	//How many users?
	$result = $sql[$u]->doquery("SELECT `config_value` FROM {{table}} WHERE `config_name` = 'users_amount'", 'config', true);
	$users += $result['config_value'];	
	//Newest user
	$result = $sql[$u]->doquery("SELECT `username`, `register_time` FROM {{table}} ORDER BY `register_time` DESC LIMIT 1", 'users', true);
	if(@$result['register_time'] >= $last_user_time){
		$last_user_time = $result['register_time'];
		$last_user = $result['username'];
	}
}
if(strlen($last_user) > 10){
	$last_user = substr($last_user,0,8).'...';
}
if(!empty($_COOKIE[$game_config['COOKIE_NAME']]))
  header("Location: game/login.php");
?>
<html> 
<head> 
<title>Login</title> 
<link rel="shortcut icon" href="favicon.ico"> 
<link rel="stylesheet" type="text/css" href="login/styles.css"> 
<link rel="stylesheet" type="text/css" href="login/about.css">  
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />  
<script type="text/javascript" src="game/scripts/overlib.js"></script> 
<script type="text/javascript" src="ibox.2.2/ibox.js"></script> 
<script type="text/javascript">
iBox.setPath('ibox.2.2/');
iBox.default_width = 800;
</script> 
<link rel="stylesheet" href="ibox.css" type="text/css" media="screen"/>
</head> 
<body> 
<center> 
<div id="main"> 
<center><img src="images/xnovaproject.png" border="0" style="border-width:0px;" /></center>
<div id="login"> 
<div id="login_input"> 
<form name="formular" action="game/login.php" method="post"> 
<table width="400" border="0" cellpadding="0" cellspacing="0"> 
<tbody> 
<tr style="vertical-align: top;"> 
	<td style="padding-right: 4px;"> 
		Username: <input name="username" value="" type="text"> 
		Password: <input name="password" value="" type="password"> 
	</td> 
</tr><tr> 
	<td style="padding-right: 4px;"> 
		Remember Me? <input name="rememberme" type="checkbox"> <input name="submit" value="Login" type="submit"> 
	</td> 
</tr><tr> 
	<td style="padding-right: 4px;"> 
		<a href="lostpassword.php" rel="ibox&width=800" title="Lost Password">Forgotten your password?</a> 
	</td> 
</tr> 
</tbody>
</table>
</form> 
</div> 
</div> 
<div id="mainmenu" style="margin-top: 20px;"> 
<a href="reg.php" rel="ibox&width=800" title="Join Now">Register</a> 
<a href="http://xnovauk.com/forum.php" title="Join Now">Forum</a> 
<a href="contact.html" rel="ibox&width=800" title="Contact">Contact</a> 
<a href="credits.html" rel="ibox&width=800" title="Credits">Credits</a> 
</div> 
<div id="rightmenu" class="rightmenu"> 
<div id="title">Welcome to XNova Redesigned</div> 
<div id="content"> 
<center> 
<div id="text1"> 
<div style="text-align: left;"><strong>XNova Redesigned</strong> is a free open source multiplayer online game created by the <strong>XNovaUK</strong> team. XNova Redesigned-Re-Project is a modification of XNova Redesigned, which is outdated. It is based upon the XNova script, all you need to play is a HTML compliant browser.
</div> 
</div> 
<div id="register" class="bigbutton" onclick="iBox.showURL('reg.php','Join Now',{'width':800});"><font color="#cc0000">Register Now!</font></div> 
<div id="text2"> 
<div id="text3"> 
<center><b>
<font color="#00cc00">Players online: </font> <font color="#c6c7c6"><?php echo $online; ?></font> - 
<font color="#00cc00">Latest member: </font> <font color="#c6c7c6"><?php echo $last_user; ?></font> - 
<font color="#00cc00">Number of players:</font> <font color="#c6c7c6"><?php echo $users; ?></font> 
</b></center>
</div> 
</div> 
</center> 
</div> 
</div> 
</div> 
</center>
</body> 
</html>
