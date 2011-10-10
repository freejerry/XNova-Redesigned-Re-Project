<?php

$types = array('gas','normal','jungle','ice','water','dry');

/*
echo "<table>";
foreach ($types as $type){
	echo "<tr>";
	for($no=1;$no<=10;$no++){
		echo "<td><img src=\"".$_GET['path']."/".$type.$_GET['between'].$no.$_GET['end']."\" />";
	}
	echo "</tr>";
}
echo "</table>";
*/

$types = array('gas','normal','jungle','ice','water','dry');
$set = array('1','2','3','4','1_2','1_3','1_4','2_3','2_3','3_4','1_2_3','1_2_4','1_3_4','2_3_4','1_2_3_4');

foreach ($types as $type){
	foreach ($types as $type){
	for($no=1;$no<=10;$no++){
		echo "<td><img src=\"".$_GET['path']."/".$type.$_GET['between'].$no.$_GET['end']."\" />";
	}
	echo "</tr>";
}

?>
