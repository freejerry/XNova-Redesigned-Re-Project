<?php

/**
 * validate.php
 *
 * @version 1.0
 * @copyright 2009 by MadnessRed for XNova Redesigned
 */

getLang('validate');

if($_GET['axah']){	//Are we loading this page via ajax?
	if($userclass->validate > 0){
		
		$validation_code = mt_rand(10000000,99999999);
		$sql->doquery("UPDATE {{table}} SET `validate` = ".$validation_code." WHERE `id` = ".$userclass->id,'users',true);
		
		$head   = '';
		$head  .= "Content-Type: text/html \n";
		$head  .= "Date: " . date('r') . " \n";
		$head  .= "Return-Path: ".ADMINEMAIL." \n";
		$head  .= "From: ".ADMINEMAIL." \n";
		$head  .= "Sender: ".ADMINEMAIL." \n";
		$head  .= "Reply-To: ".ADMINEMAIL." \n";
		$head  .= "Organization: ".$game_config['game_name']." \n";
		$head  .= "X-Sender: ".ADMINEMAIL." \n";
		$head  .= "X-Priority: 3 \n";
		
		$parse = $lang;
		$parse['password']	= $user['password'];
		$parse['username']	= $user['username'];
		$parse['game']		= $game_config['game_name'];
		$parse['GAMEURL']	= GAMEURL;
		$parse['ADMIN_NAME']= ADMIN_NAME;
		
		$parse['validate_url'] = GAMEURL.'/login.php?GET_LOGIN=1&username='.$userclass->username.'&password='.$userclass->password.'&UNI=1&go=./?page=validate--code='.$validation_code;
		
		//die(parsetemplate(gettemplate('emails/reg'), $parse));
		
		mail($userclass->email, $lang['mail_title'].$parse['game'], parsetemplate(gettemplate('emails/newcode'), $parse), $head);
		
		$ContentTPL = '
						{validation_sent} {email}.<br />
               			{if_wrong_email}<br />
               			{note_new}<br />';
		$lang['email'] = $userclass->email;
		$lang['validate_content'] = parsetemplate($ContentTPL, $lang);
	}else{
		$lang['validate_content'] = $lang['already_validated'];
	}
	$page = parsetemplate(gettemplate('redesigned/validate'), $lang);
	makeAXAH($page);

}elseif($userclass->validate > 0){	
	//Is user already validated?
	//Need to validate ths account
	//Do we have a code?
	if($_GET['code']){
		if($_GET['code'] == $userclass->validate){
			$sql->doquery("UPDATE {{table}} SET `validate` = '0' WHERE `id` = '".$sql->idstring($userclass->id)."' LIMIT 1 ;",'users');
			intercom_add($lang['acc_validated'],$userclass->id,0,20);
			header("Location: " . GAMEURL);
		}else{
			intercom_add($lang['bad_code'],$userclass->id,0,20);
			header("Location: " . GAMEURL);
		}
	}else{
		die("No code");
		header("Location: " . GAMEURL);
	}
	
}else{
	//He is already validated
	intercom_add($lang['already_validated'],$userclass->id,0,20);
	header("Location: " . GAMEURL);
}

?>
