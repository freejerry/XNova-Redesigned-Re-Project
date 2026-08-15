<?php

/**
 * SendSimpleMessage.php
 *
 * @version 1.3
 * @copyright 2008 by Chlorel for XNova
 */

// Envoi d'un message simple
//
// $Owner   -> destinataire
// $Sender  -> ID de l'emeteur
// $Time    -> Heure theorique a laquelle l'evenement s'est produit
// $Type    -> Type de message (pour classement dans les onglets message plus tard)
// $From    -> Description de l'emeteur
// $Subject -> Sujet
// $Message -> Le message lui meme !!
//
function SendSimpleMessage ( $Owner, $Sender, $Time, $Type, $From, $Subject, $Message) {
	global $messfields;

	if ($Time == '') {
		$Time = time();
	}

	//explode(",",$user['messages']) = array(0 => PM,1 => ALLY, 2 => EXP, 3 => BATTLE,4 => ESP,5 => GENERAL);
	$newtype = array(
		't1'  => 0,
		't2'  => 1,
		't15' => 2,
		't3'  => 3,
		't0'  => 4,
		't99' => 5
	);
	
	if($newtype['t'.$Type]){
		$messtype = $newtype['t'.$Type];
	}else{
		$messtype = 5;
	}
	
	PM($Owner,$Sender,$Message,$Subject,$Sender,$messtype);
	
	//now report this rogue function
	$error = 'The function SendSimpleMessage has been called. This function is no longer in use, please ammend the file to use the new PM function instead.';
	ReportError($error,'Deprecated Function',1);

}

// Revision history :
// 1.0 - Initial release (mise en fonction generique)
// 1.1 - Ajout gestion des messages par type pour le module de messages
// 1.2 - Correction bug (addslashes pour les zone texte pouvant contenir une apostrophe)
// 1.3 - Correction bug (integration de la variable $Time pour afficher l'heure exacte de l'evenement pour les flottes)
// 1.4 - Rewritten in PM.php, now this file is just a manager.

?>