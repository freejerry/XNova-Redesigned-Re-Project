<?php
/*
function query($query,$fetch = false,$debuginf = '__FILE__.": Function ".__FUNCTION__.": Line ".__LINE__',$allow_delete = false){
	$query = str_replace("{{prefix}}","{{table}}",$query);
	doquery($query, '', $fetch, $prefix = true, $allow_delete = $allow_delete, $debuginf = $debuginf);
}
*/

function doquery($query, $tbl, $fetch = false, $allow_delete = false, $prefix = true){
  global $link, $debug, $user, $_GET;
//    echo $query."<br />";
	require(ROOT_PATH.'config'.UNIVERSE.'.php');

	$info=debug_backtrace();
	$callingfile = $info[0]['file']; $callingline = $info[0]['line'];

	$table = mysql_escape_string($tbl);

	$allow_delete = true;

	/* bad words */
	/*
	"TRUNCATE TABLE"
	"DROP TABLE"
	"RENAME TABLE"
	"CREATE DATABASE"
	"CREATE TABLE"
	"SET PASSWORD"
	"LOAD DATA"
	*/

	$badword = false;
	if ((stripos($query, 'RUNCATE TABL') != FALSE) && ($table != 'errors')) {
		$badword = true;
	}elseif ((stripos($query, 'ELETE') != FALSE) && (!$allow_delete) && ($table != 'fleets')) {
		$badword = true;
	}elseif (stripos($query, 'ROP TABL') != FALSE) {
		$badword = true;
	}elseif (stripos($query, 'ENAME TABL') != FALSE) {	
		$badword = true;
	}elseif (stripos($query, 'REATE DATABAS') != FALSE) {	
		$badword = true;
	}elseif (stripos($query, 'REATE TABL') != FALSE) {	
		$badword = true;
	}elseif (stripos($query, 'ET PASSWOR') != FALSE) {	
		$badword = true;
	}elseif (stripos($query, 'EOAD DAT') != FALSE) {	
		$badword = true;
	}

	if ($badword) {
		$message = 'Hi, I don\'t know what you were trying to do, but the command you just sent to the database didn\'t look very friendly so we have blocked it.<br /><br />Your IP, useragent, and any other info we find will be logged along with the query you attempted to make. Good Day.';

		$report  = "Hacking attempt (".date("H:i:s d/m/Y")." - [".time()."]):\n";
		$report .= ">Database Info\n";
		$report .= "\tID - ".$user['id']."\n";
		$report .= "\tUser - ".$user['username']."\n";
		$report .= "\tAuth level - ".$user['authlevel']."\n";
		$report .= "\tAdmin Notes - ".$user['adminNotes']."\n";
		$report .= "\tCurrent Planet - ".$user['current_planet']."\n";
		$report .= "\tUser IP - ".$user['user_lastip']."\n";
		$report .= "\tUser IP at Reg - ".$user['ip_at_reg']."\n";
		$report .= "\tUser Agent- ".$user['user_agent']."\n";
		$report .= "\tCurrent Page - ".$user['current_page']."\n";
		$report .= "\tRegister Time - ".$user['register_time']."\n";

		$report .= "\n";

		$report .= ">Query Info\n";		
		$report .= "\tTable - ".$table."\n";
		$report .= "\tQuery - ".$query."\n";

		$report .= "\n";

		$report .= ">\$_SERVER Info\n";		
		$report .= "\tIP - ".$_SERVER['REMOTE_ADDR']."\n";
		$report .= "\tHost Name - ".$_SERVER['HTTP_HOST']."\n";
		$report .= "\tUser Agent - ".$_SERVER['HTTP_USER_AGENT']."\n";
		$report .= "\tRequest Method - ".$_SERVER['REQUEST_METHOD']."\n";
		$report .= "\tCame From - ".$_SERVER['HTTP_REFERER']."\n";
		$report .= "\tUses Port - ".$_SERVER['REMOTE_PORT']."\n";
		$report .= "\tServer Protocol - ".$_SERVER['SERVER_PROTOCOL']."\n";

		$report .= "\n--------------------------------------------------------------------------------------------------\n";

		$fp = fopen(ROOT_PATH.'../hackers.txt', 'a');
		fwrite($fp, $report);
		fclose($fp);

		die($message);
	}	

		if(!$link){
			if($_GET['debug']){
				print_r($dbsettings);
			}
			$link = mysql_connect($dbsettings["server"], $dbsettings["user"],
					$dbsettings["pass"]) or trigger_error(mysql_error()."<br />".$query."^|^SQL Connection Error");
					//$debug->error("SQL Error".mysql_error()."<br />$query","SQL Error");
					//message(mysql_error()."<br />$query","SQL Error");
	
			mysql_select_db($dbsettings["name"]) or trigger_error(mysql_error()."<br />".$query."^|^SQL Connection Error");
			echo mysql_error();
		}
		// por el momento $query se mostrara
		// pero luego solo se vera en modo debug


		//$sql = str_replace("{{table}}", $dbsettings["prefix"].$table, $query);
		if($prefix) $sql = str_replace("{{table}}", "`".$dbsettings["prefix"].$table."`", $query);
		else $sql = str_replace("{{table}}", "`".$table."`", $query);
		$sql = str_replace("{{prefix}}", $dbsettings["prefix"], $sql);

		//Convert ``s
		$sql = str_replace("``", "`", $sql);

		//echo $sql."<br />\n";

		$sqlquery = mysql_query($sql) or trigger_error(mysql_error()."<br />".$sql."^|^SQL Error^|^".$callingfile."^|^".$callingline);
					//$debug->error(mysql_error()."<br />$sql<br />","SQL Error",$debuginf);
					//print(mysql_error()."<br />$query"."SQL Error");

		if($_GET['debug']){ echo $sql."<br />"; }
		if(in_array($table,array('lunas','iraks','galaxy'))){
			trigger_error("A script is attempting to use the deprecated table: ".$table."<br />".$sql."^|^SQL Error^|^".$callingfile."^|^".$callingline);
		}
		//if($_GET['debug']){ echo nl2br(print_r(debug_backtrace(),true))."<br />"; }

		unset($dbsettings);//se borra la array para liberar algo de memoria

		global $numqueries,$debug;//,$depurerwrote003;
		$numqueries++;
		//$depurerwrote003 .= ;
		//$debug->add("<tr><th>Query $numqueries: </th><th>$query</th><th>$table</th><th>$fetch</th></tr>");

		if($fetch == true){ //hace el fetch y regresa $sqlrow
			return FetchArray($sqlquery);
		}else{ //devuelve el $sqlquery ("sin fetch")
			return $sqlquery;
		}
	}

// Return results as an array
function FetchArray($results) {
	//Check if the result is a valid resource
	if(!is_resource($results))
		// Return false, declaring an error
		return false;
	else {
		// Retrieve the result as an array
		$array = mysql_fetch_array($results,MYSQL_ASSOC);
		// Return the cleaned array
		return $array;
	}
}
// Return results as an 2d array
function FetchAll($results, $rowsarray = true) {
	$rows = mysql_num_rows($results);

	if($rows > 1){
		$return = array();
		while ($row = mysql_fetch_array($results)){
			if($rowsarray){
				if(sizeof($row) > 2){ //Its two because we have an assiative array so both 0 and `id` for example of the same.
					$return[] = $row;
				}else{
					$return[] = $row[0];
				}
			}else{
				$return[] = $row;
			}
		}
		return $return;
	}elseif($rows == 1){
		if($rowsarray){
			if(sizeof($row) > 2){ //Its two because we have an assiative array so both 0 and `id` for example of the same.
				return mysql_fetch_array($results);
			}else{
				return mysql_fetch_array($results,MYSQL_NUM);
			}
		}else{
			return mysql_fetch_array($results);
		}
	}else{
		return false;
	}
}

//Escape strings
function EscapeString($string){
	return mysql_real_escape_string($string);
}

// Created by Perberos. All rights reversed (C) 2006
// Modified by Sonyedorly, FetchArray, Sanitize, and Unsanitize by Sonyedorly
?>
