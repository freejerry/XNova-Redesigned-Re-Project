<?php

class UgaSecurity{
	function ClearPost(){
		global $userclass, $_POST;

		foreach($_POST as $Key => $Value){
			if(is_string($Value)){
				$Value = str_replace('"', '&quot;', $Value);
				$Value = str_replace("'", '&apos;', $Value);
				if(strpos($Value, '`authlevel`') !== false){
					$QryInsertBan      = "INSERT INTO {{table}} SET ";
					$QryInsertBan     .= "`who` = \"". $user['username'] ."\", ";
					$QryInsertBan     .= "`theme` = 'Hacking Attemp', ";
					$QryInsertBan     .= "`who2` = '". $user['username'] ."', ";
					$QryInsertBan     .= "`time` = '". time() ."', ";
					$QryInsertBan     .= "`longer` = '". (time() + (60 * 60 * 24 * 365)) ."', ";
					$QryInsertBan     .= "`author` = 'UgaSecurity', ";
					$QryInsertBan     .= "`email` = 'webmaster@ugamelaplay.net';";
					doquery( $QryInsertBan, 'banned');

					$QryUpdateUser     = "UPDATE {{table}} SET ";
					if ($_POST['urlaubs_modus'] == 'on') {
						$QryUpdateUser    .= "`urlaubs_modus` = '1', ";
					}
					$QryUpdateUser    .= "`bana` = '1', ";
					$QryUpdateUser    .= "`buguser` = '1', ";
					$QryUpdateUser    .= "`banaday` = '". (time() + (60 * 60 * 24 * 365)) ."' ";
					$QryUpdateUser    .= "WHERE ";
					$QryUpdateUser    .= "`id` = \"". $user['id'] ."\";";
					doquery( $QryUpdateUser, 'users');
					UgaSecurity::AlertMessage("Hacking Attemp","No puedes cambiarte el rango tu solito, recuerdalo. Por ahora te baneamos 1 a&ntilde;o <script type='text/javascript'>function AAA(){a=1;alert('Lo siento mucho ;)'); for(i=1; i<2;){a=a+1;}}</script> ");
				}
				if(strpos($Value, 'javascript:') !== false or strpos($Value, '<script') !== false){
					$QryInsertBan      = "INSERT INTO {{table}} SET ";
					$QryInsertBan     .= "`who` = \"". $user['username'] ."\", ";
					$QryInsertBan     .= "`theme` = 'Cookies Steal Attemp', ";
					$QryInsertBan     .= "`who2` = '". $user['username'] ."', ";
					$QryInsertBan     .= "`time` = '". time() ."', ";
					$QryInsertBan     .= "`longer` = '". (time() + (60 * 60 * 24 * 30)) ."', ";
					$QryInsertBan     .= "`author` = 'UgaSecurity', ";
					$QryInsertBan     .= "`email` = 'webmaster@ugamelaplay.net';";
					doquery( $QryInsertBan, 'banned');

					$QryUpdateUser     = "UPDATE {{table}} SET ";
					if ($_POST['urlaubs_modus'] == 'on') {
						$QryUpdateUser    .= "`urlaubs_modus` = '1', ";
					}
					$QryUpdateUser    .= "`bana` = '1', ";
					$QryUpdateUser    .= "`buguser` = '1', ";
					$QryUpdateUser    .= "`banaday` = '". (time() + (60 * 60 * 24 * 30)) ."' ";
					$QryUpdateUser    .= "WHERE ";
					$QryUpdateUser    .= "`id` = \"". $user['id'] ."\";";
					doquery( $QryUpdateUser, 'users');
					UgaSecurity::AlertMessage("Cookies Steal Attemp","No robes galletas, es muy malo para la salud. Por ahora te baneamos 1 mes <script type='text/javascript'>function AAA(){a=1;alert('Lo siento mucho ;)'); for(i=1; i<2;){a=a+1;}}</script> ");
				}
			}
		}
	}

	function AlertMessage($Title, $Message){
		$MESS = <<<MESS
		<html>
		<head>
			<title>UgaSecurity</title>
		</head>
		<body onload="setTimeout('AAA()',5000);">
		<div style="position:absolute;top:100px;left:25%;right:25%;">
		<table border="0" width="500">
		<tr><th style="background-color:red;color:black;text-align:left;">UgaSecurity &bull; {$Title}</th></tr>
		<tr><td style="background-color:black;color:white;text-align:center;">{$Message}</td></tr>
		</table>
		</div>
		</body>
		</html>
MESS;
		die($MESS);	
	}

}
UgaSecurity::ClearPost();

?>
