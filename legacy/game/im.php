<?php

/**
 * im.php
 *
 * @version 1.0
 * @copyright 2009 by MadnessRed for XNova Redesigned
 */

if($user['id'] < 1){
	die("Not logged in");
}

if($_GET['mode'] == 'post'){
	
	$message = EscapeString(stripslashes(htmlentities($_GET['message'])));
	$to = idstring($_GET['to']);
	
	intercom_add($message,$to,$user['id'],300);
	
	echo "Sent: ".date("H:i:s");
	
}elseif($_GET['mode'] == 'close'){
	
	$message = EscapeString(stripslashes(htmlentities($_GET['message'])));
	$to = idstring($_GET['to']);
	
	doquery("DELETE FROM {{table}} WHERE `to` = ".$user['id']." OR `from` = ".$user['id']." ;",'im');
	
}else{
	
	//Get messages
	$qry = doquery("SELECT * FROM {{table}} WHERE (`to` = ".$user['id']." OR `from` = ".$user['id'].") AND `expires` > ".time()." ORDER BY `time` ASC LIMIT 15 ;",'im');
	
	$likelyids = array($user['id'] => $user['username'],0 => $lang['System']);
	$mess = 0;
	
	while($row = FetchArray($qry)){
		//1 more message
		$mess++;
		
		//Who sent?
		if(strlen($likelyids[$row['from']]) > 0){
			$from = $likelyids[$row['from']];
		}else{
			$from = doquery("SELECT `username` FROM {{table}} WHERE `id` = ".$row['from']." LIMIT 1 ",'users',true);
			$from = $from['username'];
			$likelyids[$row['from']] = $from;
		}
		
		//Who received?
		if(strlen($likelyids[$row['to']]) > 0){
			$to = $likelyids[$row['to']];
		}else{
			$to = doquery("SELECT `username` FROM {{table}} WHERE `id` = ".$row['to']." LIMIT 1 ",'users',true);
			$to = $to['username'];
			$likelyids[$row['to']] = $to;
		}
		
		echo $from." -> ".$to.": ".date("H:i:s",$row['time'])."<br />";
		echo stripslashes($row['message'])."<br /><hr /><br />";
	}

	$ids = array_keys($likelyids);
	$to = $ids[(sizeof($ids)-1)];

	if($mess > 0){
		echo '<input type="hidden" id="im_reply_to" value="'.$to.'" />';
	}

}

if($_GET['debug']){
	echo microtime(true) - $loadstart."<br />";
}

?>