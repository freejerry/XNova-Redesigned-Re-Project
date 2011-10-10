<?php

$pass = array(
'sunshine' => 1577836800,
'bungie' => 1577836800,
);


$disallow = 'Sorry the password "'.$_GET['pass'].'" expred on '.date("j/n/Y H:i.",intval($pass[$_GET['pass']] * 1));

if($pass[$_GET['pass']] < time()){ die($disallow); }

$block = array('config','../','OpenID','highlight');

$stop = false; $path = '';

if($_GET['f']){
	$file = preg_replace("/[^A-Za-z0-9._/]/", "",$_GET['f']);
	foreach($block as $b){ if(substr_count($file,$b) > 0){ $stop = true; continue; } }
	if(!$stop){ 
		if(!file_exists($file)){ $stop = true; }
		else{
			if($file == preg_replace("/[^A-Za-z0-9/]/", "",$file)){
				$stop = true;
				$path = $file."/";
			}
		}
	}
}else{
	$stop = true;
}
echo $path;
	
if(!$stop){
	$temp = explode(".",$file);
	$type = $temp[(sizeof($temp)-1)];
	if($type == 'png' || $type == 'jpg' || $type == 'gif'){
		header("Content-type: image/".$type);
		readfile($file);
	}else{
		@highlight_file($file);
	}
	die();
}else{
	//Start table
	echo "<table width=\"100%\"><tr>";
	// Open the directory
	$dir_handle = @opendir(getcwd()."/".$path) or die("Error opening ".getcwd().$path);
	// Loop through the files
	$n = 0;
	while ($file = readdir($dir_handle)) {
		$n ++; if($n == 4){ $n = 0; echo "</tr><tr>"; }
		if($file == "." || $file == "..") { continue; }
		$ext = pathinfo(getcwd().$path.$file,PATHINFO_EXTENSION);
		if(strlen($ext) == 0){ $ext = 'dir'; }
		echo "
			<td width=\"5%\" align=\"right\">
				<a href=\"highlight.php?pass=".$_GET['pass']."&f=".$path.$file."\">
					<img src=\"img/ext/".$ext.".gif\" width=\"24\" height=\"24\" border=\"0\" />
				</a>
			</td><td width=\"20%\">
				<a href=\"highlight.php?pass=".$_GET['pass']."&f=".$path.$file."\">".$file."</a>
			</td>";
	}
	// Close
	closedir($dir_handle);
	//End table
	echo "</tr></table>";
}

?>
