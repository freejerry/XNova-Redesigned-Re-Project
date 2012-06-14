<?php

if (($_POST["sure"] == "yes") && (md5($_POST["code"]) == "0571749e2ac330a7455809c6b0e7af90")){
	$host = "localhost";
	$table = "evo_game";
	$user = "evo_game";
	$pass = "sunshine@#&";
	$con = mysql_connect($host,$user,$pass);
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }	
	mysql_select_db($table, $con);
	
	if ($_POST['id'] != ''){
		$current_planet  = mysql_query("SELECT * FROM `evo1_planets` WHERE `id_owner` =".$_POST[id]." ;");
		while ($planets = mysql_fetch_assoc($current_planet)) {
    		$fleet = explode(";", $planets['b_hangar_id']);
    		foreach ($fleet as $a => $b) {
    		    if ($b != '') {
    		        $a = explode(",", $b);
    		        $item = $resource[$a[0]];
    		        $ammount = $a[1];
    		        mysql_query("UPDATE `evo1_planets` set `".$item."` = `".$item."` + '".$ammount."' WHERE `id` = '".$planets['id']."' ;");
    		    }
    		}
		}
		
		if (mysql_query("UPDATE `evo1_planets` SET `b_hangar_id` ='' , `b_hangar` ='0' , `b_building_id` ='' , `b_building` ='0'  WHERE `id_owner` =".$_POST[id]." ;",$con)){
	  		echo "<center>Queues Cleaned for user id ".$_POST[id].".</center>";
	  	}else{
	  		echo "<center>Error cleaning queues for user id ".$_POST['id'].": " . mysql_error() . "</center>";
		}	
		
	}else{
		$current_planet  = mysql_query("SELECT * FROM `evo1_planets` ;");
		while ($planets = mysql_fetch_assoc($current_planet)) {
    		$fleet = explode(";", $planets['b_hangar_id']);
    		foreach ($fleet as $a => $b) {
    		    if ($b != '') {
    		        $a = explode(",", $b);
    		        $item = $resource[$a[0]];
    		        $ammount = $a[1];
    		        mysql_query("UPDATE `evo1_planets` set `".$item."` = `".$item."` + '".$ammount."' WHERE `id` = '".$planets['id']."' ;");
    		    }
    		}
		}
		
		if (mysql_query("UPDATE `evo1_planets` SET `b_hangar_id` ='' , `b_hangar` ='0' , `b_building_id` ='' , `b_building` ='0' ;",$con)){
	  		echo "<center>Queues Cleaned.</center>";
	  	}else{
	  		echo "<center>Error cleaning queues: " . mysql_error() . "</center>";
		}		
	}
	

	  
	  
	mysql_close($con);
} else {
	echo'	
	<center>
	Warning, if you click confirm then all queues will be stopped and anything in them, canceled.<br />
	<form action="flushqs.php" method="POST">
	<input type="hidden" name="sure" value="yes" />
	Input code <input type="password" name="code" /><br />
	Only flush queues for user id <input type="text" name="id" value="'.$_GET['id'].'" size="5" maxlength="5" /><br />
	<input type="submit" value="Confirm" />
	</form>
	</center>	
	';
}
?>