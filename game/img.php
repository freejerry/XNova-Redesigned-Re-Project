<?php

$types = array("ice","dry","jungle","water","gas","normal");

$bs = array("1","2","3","4","1_2","1_3","1_4","2_3","2_4","3_4","1_2_3","1_2_4","1_3_4","2_3_4","1_2_3_4");

/*
foreach($types as $t){
	foreach($bs as $b){
		$img = "http://uni42.ogame.org/headerCache/resources/".$t."_".$b.".png";
		echo "<img src=\"".$img."\" width=654 height=300 /><br />";
	}
	echo "<br />";
}
*/

/*
$types = array("ice","dry","jungle","water","gas","normal");
foreach($types as $t){
	for($n = 1; $n <= 10; $n++){
		for($s = 1; $s <= 7; $s++){
			$img = "http://uni42.ogame.org/game/img/planets/".$t."_".$n."_".$s.".gif";
			echo "<img src=\"".$img."\" /><br />";
		}
	}
	echo "<br />";
}
*/

/*
for($n = 1; $n <= 600; $n++){
	$img = "http://uni42.ogame.org/game//img/medium/tech_".$n."_a.jpg";
	echo "<img src=\"".$img."\" /><br />";
	$img = "http://uni42.ogame.org/game//img/medium/tech_".$n."_b.jpg";
	echo "<img src=\"".$img."\" /><br />";
	$img = "http://uni42.ogame.org/game//img/medium/tech_".$n."_c.jpg";
	echo "<img src=\"".$img."\" /><br />";
}
echo "<br />";
*/

$arrows = array('http://uni42.ogame.org/game/img/techtree/arrows/A1G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A1R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A2G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A2R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A3G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A3R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A4G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A4R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A5G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A5R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A6G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A6R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A7G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A7R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A8G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A8R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A9G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A9R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A10G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A10R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A11G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A11R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A12G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A12R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A13G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A13R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A14G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A14R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A15G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A15R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A16G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A16R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A17G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A17R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A18G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A18R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A19G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A19R.gif','http://uni42.ogame.org/game/img/techtree/arrows/A20G.gif','http://uni42.ogame.org/game/img/techtree/arrows/A20R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L1G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L1R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L2G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L2R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L3G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L3R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L4G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L4R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L5G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L5R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L6G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L6R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L7G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L7R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L8G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L8R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L9G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L9R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L10G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L10R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L11G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L11R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L12G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L12R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L13G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L13R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L14G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L14R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L15G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L15R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L16G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L16R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L17G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L17R.gif','http://uni42.ogame.org/game/img/techtree/arrows/L18G.gif','http://uni42.ogame.org/game/img/techtree/arrows/L18R.gif');
foreach($arrows as $a){
	echo "<img src=\"".$a."\" /><br />";
}
?>