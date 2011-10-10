<?php

$result = AddMoon($_GET['galaxy'],$_GET['system'],$_GET['planet']);

if($result == true){
	$bloc['content'] = "A moon has been added in orbit arround planet ".$_GET['galaxy'].":".$_GET['system'].":".$_GET['planet'].".<br />".$result;
}else{
	$bloc['content'] = "A moon could not be added in orbit arround planet ".$_GET['galaxy'].":".$_GET['system'].":".$_GET['planet'].".<br />".$result;
}

$bloc['title'] = "Add moon";

?>