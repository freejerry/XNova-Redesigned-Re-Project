<?php

/**
 * error_handler.php
 *
 * @version 1.0
 * @copyright 2008 by Anthony for XNova Redesigned
 */

//This will log error to the database

$error_types = array(
'1' => 'E_ERROR',
'2' => 'E_WARNING',
'4' => 'E_PARSE',
'8' => 'E_NOTICE',
'16' => 'E_CORE_ERROR',
'32' => 'E_CORE_WARNING',
'64' => 'E_COMPILE_ERROR',
'128' => 'E_COMPILE_WARNING',
'256' => 'E_USER_ERROR',
'512' => 'E_USER_WARNING',
'1024' => 'E_USER_NOTICE',
'6143' => 'E_ALL',
'2048' => 'E_STRICT',
'4096' => 'E_RECOVERABLE_ERROR',
'8192' => 'E_DEPRECATED',
'16384' => 'E_USER_DEPRECATED');

function err_handler($num, $str, $file, $line) {
	global $user,$error,$error_types,$sql;
	
	//errors not to record
	$silent = array(8,2048,8192);
	
	if(in_array($num,$silent))
		return true;
	
	
	include(ROOT_PATH . 'config'.UNIVERSE.'.php');
	$error = array();
	
	//errors to die from
	$fatal = array(256);

	$err = explode("^|^",$str,4);
	$str = $err[0];
	$error['type'] = @$err[1];

	if(@strlen($err[2]) > 0){ $file = $err[2]; }
	if(@intval($err[3]) > 0){ $line = $err[3]; }

	$die = true;
	if(!$error['type']){
		$error['type'] = $error_types[$num];
		if(!in_array($num,$fatal)){
			$die = false;
		}
	}

	if(($error['type'] == 'E_NOTICE') || ($error['type'] == 'E_STRICT') || (error_reporting() == 0)){
		//Its a minor thing, or we have be told not to notice it.
	}else{
		echo $str.'-'.$file.'-'.$line."-".$error_types[$num]."<br />";
		$query = "INSERT INTO {{table}} SET
			`error_sender` = '".intval($user['id'])."' ,
			`error_time` = '".time()."' ,
			`error_type` = '".mysql_real_escape_string($error['type'])."' ,
			`error_text` = '".mysql_real_escape_string($str)."' ,
			`error_page` = '".mysql_real_escape_string($file).": Line ".intval($line)."';";
			//`error_text` = '".mysql_escape_string($error['message'])."' ,
		
		
	
		if(isset($sql)){
			$sql->doquery($query, 'errors') or die($sql->error);
			$q = $sql->insert_id();
		}else{
			if(@!$link){
				$link = mysql_connect($dbsettings["server"], $dbsettings["user"],$dbsettings["pass"]) or die(mysql_error());
				mysql_select_db($dbsettings["name"]) or die(mysql_error());
			}
			$sqlquery = mysql_query(str_replace("{{table}}", $dbsettings["prefix"].'errors',$query)) or die('error fatal: '.mysql_error());
			$query = "explain select * from {{table}}";
			$q = mysql_fetch_array(mysql_query(str_replace("{{table}}", $dbsettings["prefix"].'errors', $query))) or die('error fatal: '.mysql_error());
			$q = $q['rows'];
		}

		$message = "Sorry, there has been an error, please give the following error code to an admin and tell him what you were doing: <b>".$q."</b>";

		if($die){
			if (!function_exists('message')){ die($message); }
			else{ message($message,"Error (".$error['type'].")"); }
		}else{
			//echo $message."<br />";
		}
	}

    /* Don't execute PHP internal error handler */
    return true;
}

set_error_handler("err_handler");

function ReportError($message,$title,$backtrace = 0){
	$info = debug_backtrace();
	trigger_error($message."^|^".$title."^|^".$info[$backtrace]['file']."^|^".$info[$backtrace]['line']);
}

?>
