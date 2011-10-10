<?php
//UGamelaPlay Pay System API v0.1 
//Copyright 2008-2010 UGamelaPlay.net

class UgamelaplayPay{
	protected $PublicKey;
	protected $PrivateKey;
	protected $CurrentUserId;
	protected $GameType;
	function __construct($PublicKey, $PrivateKey, $CurrentUserId, $GameType){
		$this->PublicKey = $PublicKey;
		$this->PrivateKey = $PrivateKey;
		$this->CurrentUserId = $CurrentUserId;
		$this->GameType = $GameType;
	}
	function RedirToPaySystem(){
		header("Location: http://pay.ugamelaplay.net/index.php?apikey=". $this->PublicKey );
		die("Redireccionando...");
	
	}
	function Comprobate($Code){
		$Result = eval($this->CallBack($Code));
		if(is_array($Result)){
				$amount = $Result['amount'];
				$type = $Result['type'];
				if($this->GameType == "xr"){
					doquery("UPDATE {{table}} SET `matter` = `matter` + ".$amount." WHERE `id` = '". $this->CurrentUserId ."' ;", 'users');
				}elseif($this->GameType == "xg"){
					doquery("UPDATE {{table}} SET `darkmatter` = `darkmatter` + ".$amount." WHERE `id` = '". $this->CurrentUserId ."' ;", 'users');				
				}elseif($this->GameType == "2m"){
					global $db;
					$db->query("UPDATE ". USERS ." SET `darkmatter` = `darkmatter` + ".$amount." WHERE `id` = '". $this->CurrentUserId ."' ;");				
				}
				return('Thank you for buying '.pretty_number($amount).' DarkMatter units.');				
		}elseif($Result == 'error_code_used'){
			return('This code have been used');	
		}elseif($Result == 'error_code_no_exist'){
			return('The code doesnt exist');
		}else{
			return('Unknown Error');
		}
	
	}
	private function CallBack($Code){
		$url = "pay.ugamelaplay.net/callback.php?code=".$Code."&privatekey=".$this->PrivateKey ;
		if($string = $this->get_web_page("http://".$url)){
			return $string['content'];
		}else{
			return 'return "error";';
		}		
	}
	
	private function get_web_page( $url ){
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_USERAGENT      => "UGamelaPlay Callback", // who am i
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
		);

		$ch      = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['content'] = $content;
		return $header;
	}

}

?>