<?php

define('INSIDE',true);
include('../game/SETUP.PHP');

//Is ther url right, if so no need to change anything
if(BASEURL.'install.php?page=2' != $_GET['url']){

	//Work out the path to files
	$ptf = str_replace(array("http://".$_SERVER['HTTP_HOST']."/",'install.php?page=2'),'',$_GET['url']);

	//Open setup.php and make the change
	$config = @file("../game/SETUP.PHP") or die($ptf);
	$config[21] = "define('PATH_TO_FILES'\t\t, \"".$ptf."\");\n";
	$config = implode('',$config);
	
	//Edit file
	$handle = @fopen("../game/SETUP.PHP", 'w') or die($ptf);
	fwrite($handle, $config) or die($ptf);
	fclose($handle) or die($ptf);
	
	//Didi that work?
	if(BASEURL.'install.php?page=2' != $_GET['url']){
		die($ptf);
	}
}


?>
