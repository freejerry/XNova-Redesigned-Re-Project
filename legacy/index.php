<?php

//Is the game installed?
$info = file('./status');

if(substr($info[0],0,9) != "INSTALLED"){
	//Not Installed
	header("Location: install.php");
	die();
}

//Now login page
header("Location: login.php");
die();

?>
