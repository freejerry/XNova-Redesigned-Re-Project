<?php

/**
 * smallimage.php
 *
 * @version 1.0
 * @copyright 2008 By Anthony for MadnessRed.co.cc
 */


function findexts ($filename){
	$filename = strtolower($filename) ;
	$exts = split("[/\\.]", $filename) ;
	$n = count($exts)-1;
	$exts = $exts[$n];
	return $exts;
} 

$file = $_GET['source'];
list($width,$height)=getimagesize($file);
$type = findexts($file);
//echo $type;

//Types
/*
1  	IMAGETYPE_GIF
2 	IMAGETYPE_JPEG
3 	IMAGETYPE_PNG
4 	IMAGETYPE_SWF
5 	IMAGETYPE_PSD
6 	IMAGETYPE_BMP
7 	IMAGETYPE_TIFF_II (intel byte order)
8 	IMAGETYPE_TIFF_MM (motorola byte order)
9 	IMAGETYPE_JPC
10 	IMAGETYPE_JP2
11 	IMAGETYPE_JPX
12 	IMAGETYPE_JB2
13 	IMAGETYPE_SWC
14 	IMAGETYPE_IFF
15 	IMAGETYPE_WBMP
16 	IMAGETYPE_XBM
*/
if($type == 'jpg'){
	$src = imagecreatefromjpeg($file);
}elseif($type == 'png'){
	$src = imagecreatefrompng($file);
	imagealphablending($src, false);
	imagesavealpha($src, true);
}elseif($type == 'gif'){
	$src = imagecreatefromgif($file);
}else{
	die("Unsupported file type (".$type.")");
}

if($width > $height){
	$newwidth=$_GET['size'];
	$newheight=($height/$width)*$newwidth;
}else{
	$newheight=$_GET['size'];
	$newwidth=($width/$height)*$newheight;
}

$tmp=imagecreatetruecolor($newwidth,$newheight);
if($type == 'png'){
	imagealphablending($tmp, false);
	imagesavealpha($tmp, true);
}

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

if($type == 'jpg'){
	header("Content-type: image/jpeg");
	imagejpeg($tmp, NULL,100);
}elseif($type == 'png'){
	header("Content-type: image/png");
	imagepng($tmp);
}elseif($type == 'gif'){
	header("Content-type: image/gif");
	imagegif($tmp, NULL,100);
}else{
	die("Unsupported file type (".$type.")");
}

imagedestroy($src);
imagedestroy($tmp);

?>