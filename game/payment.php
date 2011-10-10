<?php

/**
 * paypal.php
 *
 * @version 1.0
 * @copyright 2008 by Anthony for XNova Redesigned
 */

//paypal email
$paypal_email = "qwerty.anthony@gmail.com";
//$paypal_email = "madnessred@gmail.com";

// Setup class
require_once('paypal.class.php');  // include the class file
$p = new paypal_class;			 // initiate an instance of the class
$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';	 // paypal url
			
// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

function logerror_mr($time,$error,$sql,$file){
	$newrow = $time.",".$error.",".$file.",".$sql."\n";
	$csv = fopen('paypal_error.csv', 'a');
	fwrite($csv, $newrow);
	fclose($csv);
}

//Costs.
$cost = $_GET['a'].".00";

switch ($_GET['action']) {
case 'success':
	// Order was successful...

	if(intval($_GET['id']) == $user['id']){
		$username = $user['username'];
	}else{
		$username = 'id '.intval($_GET['id']);
	}
	
	echo "<html><head><title>Success</title></head><body><h3>Thank you for sending $".$cost."</h3>";
	//foreach ($_POST as $key => $value) { echo "$key: $value<br>"; }
	echo "</body></html>";
	
	break;
	  
case 'cancel':
	// Order was canceled...
 
	echo "<html><head><title>Canceled</title></head><body><h3>The order was canceled.</h3><br />";
	echo "<a href=\"./?s=".UNIVERSE."\">Continue</a>";
	echo "</body></html>";
	  
	break;
	  
case 'ipn':
	// Paypal is calling page for IPN validation...
	
	/*
		It's important to remember that paypal calling this script.  There
		is no output here.  This is where you validate the IPN data and if it's
		valid, update your database to signify that the user has payed.  If
		you try and use an echo or printf function here it's not going to do you
		a bit of good.  This is on the "backend".  That is why, by default, the
		class logs all IPN data to a text file.
	*/
	  
	if ($p->validate_ipn()) {
		// Payment has been recieved and IPN is verified.  This is where you
	  
		// For this example, we'll just email ourselves ALL the data.
		$subject = 'Instant Payment Notification - Recieved Payment';
		$to = $paypal_email;	//  your email
		$body =  "An instant payment notification was successfully recieved\n";
		$body .= "from ".$p->ipn_data['payer_email']." (GET = ".$_GET['id'].")(USER = ".$user['id'].") on ".date('m/d/Y');
		$body .= " at ".date('g:i A')."\n\nDetails:\n";
		
		foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
		mail($to, $subject, $body);

		$payer_email = $p->ipn_data['payer_email'];
		$newrow = "UPDATE {{table}} SET `matter`=`matter` + '".intval($_GET['amount'])."' WHERE `id` = '".intval($_GET['id'])."' LIMIT 1 ;"."\n";
		//doquery($newrow,'users') or logerror_mr(time(),mysql_error(),$newrow,__FILE__.",".__LINE__);
	}
	break;
		
default:	  // Process and order...
	  
	$p->add_field('business', $paypal_email);
	$p->add_field('return', $this_script.'&action=success&id='.$user['id'].'&amount='.$amount);
	$p->add_field('cancel_return', $this_script.'&action=cancel');
	$p->add_field('notify_url', $this_script.'&action=ipn&id='.$user['id'].'&amount='.$amount);
	$p->add_field('item_name', ' Dark Matter Units for account '.$user['username'].' in Universe '.UNIVERSE);
	$p->add_field('item_number', $amount.'_DARKMATTER');
	$p->add_field('amount', $cost);

	$p->submit_paypal_post(); // submit the fields to paypal
	//$p->dump_fields();	  // for debugging, output a table of all the fields
	break;
}


?>