<?php
	$get = '?'; $_GET['iframe'] = '0';
	foreach($_GET as $key => $val){ $get .= "&".$key."=".$val; }
	$get = substr_replace($get,'',1,1);
	
	if($_GET['iheight'] > 0){
		$height = $_GET['iheight'];
	}else{
		$height = '100%';
	}
?>
<html>
<head>
<title>IFrame</title>
</head>
<!--
<frameset cols="100%" rows="100%">
	<frame src="./?s=<? echo $get; ?>" width="100%" height="100%" />
</frameset>
-->
<body>
<iframe src="./<? echo $get; ?>" width="100%" height="<? echo $height; ?>" />
</body>
</html>