<?php
	/**
	* preferences.php
	*
	* @version 1.0
	* @copyright 2008 by ??????? for XNova
	*/


	getLang('preferences');

	$evouni = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	$evouni = preg_replace("/[^0-9]/", "", $evouni);

	$lang['PHP_SELF'] = './?page=preferences';

	$mode = $_GET['mode'];
	
	/*if ($_GET && $mode == "exit") { // Array ( [db_character]
		if (isset($_GET["exit_modus"]) && $_GET["exit_modus"] == 'on' and $user['urlaubs_until'] <= time()){
			$urlaubs_modus = "0";
			doquery("UPDATE {{table}} SET	
				`urlaubs_modus` = '0',
				`urlaubs_until` = '0'
				WHERE `id` = '".$user['id']."' LIMIT 1", "users");	
			$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
			message($lang['succeful_save'], $lang['Options'],"options.php",1);
		}else{
			$urlaubs_modus = "1";
			$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
			message($lang['You_cant_exit_vmode'], $lan['Error'] ,$lang['PHP_SELF'],1);
		}
	}*/
	if ($_GET && $mode == "change") { // Array ( [db_character]
		//echo "Change";
		$iduser = $user["id"];
		$avatar = $_GET["avatar"];
		if(strlen($_GET["banner_bg"]) > 0){ $banner_bg = $_GET["banner_bg"]; }
		else{ $banner_bg = $user['banner_source_post']; }
		
		//Skin
		if(strlen($_GET["dpath"]) > 0){
			$dpath = $_GET["dpath"];
		}else{
			$dpath = GAME_SKIN;
		}

		// Gestion des options speciales pour les admins
		if ($user['authlevel'] > 0) {
			if ($_GET['adm_pl_prot'] == 'on') {
			 doquery ("UPDATE {{table}} SET `id_level` = '".$user['authlevel']."' WHERE `id_owner` = '".$user['id']."';", 'planets');
			} else {
			 doquery ("UPDATE {{table}} SET `id_level` = '0' WHERE `id_owner` = '".$user['id']."';", 'planets');
			}
		}

		// Forum ID
		$forum_id = idstring($_GET['forum_id']);
		
		// Mostrar skin
		if (isset($_GET["design"]) && $_GET["design"] == 'on') {
			$design = "1";
		} else {
			$design = "0";
		}
		// Desactivar comprobaci? de IP
		if (isset($_GET["noipcheck"]) && $_GET["noipcheck"] == 'on') {
			$noipcheck = "1";
		} else {
			$noipcheck = "0";
		}
		// Nombre de usuario
		if (isset($_GET["db_character"]) && $_GET["db_character"] != '') {
			$username = CheckInputStrings ( $_GET['db_character'] );
		} else {
			$username = $user['username'];
		}
		// Adresse e-Mail
		if (isset($_GET["db_email"]) && $_GET["db_email"] != '') {
			$db_email = CheckInputStrings ( $_GET['db_email'] );
		} else {
			$db_email = $user['email'];
		}
		//Avatar
		if(isset($_GET["avatar"])&& $_GET["avatar"] != ''){
			$avatar = $_GET["avatar"];
		}else{
			$avatar = "../images/no_av.gif";
		}
		//Menu Scroll
		if(isset($_GET["menutype"])&& $_GET["menutype"] != ''){
			$menutype = addslashes($_GET["menutype"]);
		}else{
			$menutype = $user['menutype'];
		}
		//Secret Question
		if(isset($_GET["sec_qu"])&& $_GET["sec_qu"] != ''){
			$sec_qu = addslashes($_GET["sec_qu"]);
		}else{
			$sec_qu = $user['sec_qu'];
		}
		//Secret Answere
		if(isset($_GET["sec_ans"])&& $_GET["sec_ans"] != ''){
			$sec_ans = addslashes($_GET["sec_ans"]);
		}else{
			$sec_ans = $user['sec_ans'];
		}
		//Language
		if(isset($_GET["language"])&& $_GET["language"] != ''){
			$language = $_GET["language"];
		}else{
			$language = $user['lang'];
		}
		// Cantidad de sondas de espionaje
		if (isset($_GET["spio_anz"]) && is_numeric($_GET["spio_anz"])) {
			$spio_anz = $_GET["spio_anz"];
		} else {
			$spio_anz = "1";
		}
		// Mostrar tooltip durante
		if (isset($_GET["settings_tooltiptime"]) && is_numeric($_GET["settings_tooltiptime"])) {
			$settings_tooltiptime = $_GET["settings_tooltiptime"];
		} else {
			$settings_tooltiptime = "1";
		}
		// Maximo mensajes de flotas
		if (isset($_GET["settings_fleetactions"]) && is_numeric($_GET["settings_fleetactions"])) {
			$settings_fleetactions = $_GET["settings_fleetactions"];
		} else {
			$settings_fleetactions = "1";
		} //
		// Mostrar logos de los aliados
		if (isset($_GET["settings_allylogo"]) && $_GET["settings_allylogo"] == 'on') {
			$settings_allylogo = "1";
		} else {
			$settings_allylogo = "0";
		}
		// Espionaje
		if (isset($_GET["settings_esp"]) && $_GET["settings_esp"] == 'on') {
			$settings_esp = "1";
		} else {
			$settings_esp = "0";
		}
		// Escribir mensaje
		if (isset($_GET["settings_wri"]) && $_GET["settings_wri"] == 'on') {
			$settings_wri = "1";
		} else {
			$settings_wri = "0";
		}
		// A?dir a lista de amigos
		if (isset($_GET["settings_bud"]) && $_GET["settings_bud"] == 'on') {
			$settings_bud = "1";
		} else {
			$settings_bud = "0";
		}
		// Ataque con misiles
		if (isset($_GET["settings_mis"]) && $_GET["settings_mis"] == 'on') {
			$settings_mis = "1";
		} else {
			$settings_mis = "0";
		}
		// Ver reporte
		if (isset($_GET["settings_rep"]) && $_GET["settings_rep"] == 'on') {
			$settings_rep = "1";
		} else {
			$settings_rep = "0";
		}
		// Modo vacaciones
		if (isset($_GET["urlaubs_modus"]) && $_GET["urlaubs_modus"] == 'on') {
			die("vaca on");
			$urlaubs_modus = "1";
			$time = time() + 172800;
			doquery("UPDATE {{table}} SET	
			 `urlaubs_modus` = '$urlaubs_modus',
			 `urlaubs_until` = '$time'
			 WHERE `id` = '$iduser' LIMIT 1", "users");

			$query = doquery("SELECT * FROM {{table}} WHERE id_owner = '{$user['id']}'", 'planets');
			while($id = mysql_fetch_array($query)){
			 doquery("UPDATE {{table}} SET
					metal_perhour = '".$game_config['metal_basic_income']."',
					crystal_perhour = '".$game_config['metal_basic_income']."',
					deuterium_perhour = '".$game_config['metal_basic_income']."',
					energy_used = '0',
					energy_max = '0',
					metal_mine_porcent = '0',
					crystal_mine_porcent = '0',
					deuterium_sintetizer_porcent = '0',
					solar_plant_porcent = '0',
					fusion_plant_porcent = '0',
					solar_satelit_porcent = '0'
				 WHERE id = '{$id['id']}' AND `planet_type` = 1 ", 'planets');
			}
		} else {
			$urlaubs_modus = "0";
		}

		// Borrar cuenta
		if (isset($_GET["db_deaktjava"]) && $_GET["db_deaktjava"] == 'on') {
			$db_deaktjava = "1";
		} else {
			$db_deaktjava = "0";
		}
		$SetSort	= $_GET['settings_sort'];
		$SetOrder = $_GET['settings_order'];

		doquery("UPDATE {{table}} SET
		`forum_id` = '$forum_id',
		`sec_qu` = '$sec_qu',
		`sec_ans` = '$sec_ans',
		`email` = '$db_email',
		`avatar` = '$avatar',
		`lang` = '$language',
		`banner_source_post` = '$banner_bg',
		`skin` = '$dpath',
		`design` = '$design',
		`menutype` = '$menutype',
		`noipcheck` = '$noipcheck',
		`planet_sort` = '$SetSort',
		`planet_sort_order` = '$SetOrder',
		`spio_anz` = '$spio_anz',
		`settings_tooltiptime` = '$settings_tooltiptime',
		`settings_fleetactions` = '$settings_fleetactions',
		`settings_allylogo` = '$settings_allylogo',
		`settings_esp` = '$settings_esp',
		`settings_wri` = '$settings_wri',
		`settings_bud` = '$settings_bud',
		`settings_mis` = '$settings_mis',
		`settings_rep` = '$settings_rep',
		`urlaubs_modus` = '$urlaubs_modus',
		`db_deaktjava` = '$db_deaktjava',
		`kolorminus` = '$kolorminus',
		`kolorplus` = '$kolorplus',
		`kolorpoziom` = '$kolorpoziom'
		WHERE `id` = '$iduser' LIMIT 1", "users");

		if (isset($_GET["db_password"]) && mr_encrypt($_GET["db_password"]) == $user["password"]) {
			if (($_GET["newpass1"] == $_GET["newpass2"]) && (strlen($_GET["newpass1"]) > 5)) {
			 $newpass = mr_encrypt($_GET["newpass1"]);
			 doquery("UPDATE {{table}} SET `password` = '{$newpass}' WHERE `id` = '{$user['id']}' LIMIT 1", "users");
			 setcookie(COOKIE_NAME, "", time()-100000, "/", "", 0); //le da el expire
			 header("Location: ../");
			 die();
			}
		}
		if ($user['username'] != $_GET["db_character"]) {
			$query = doquery("SELECT id FROM {{table}} WHERE username='{$_GET["db_character"]}'", 'users', true);
			if (!$query) {
			 doquery("UPDATE {{table}} SET username='{$username}' WHERE id='{$user['id']}' LIMIT 1", "users");
			 setcookie(COOKIE_NAME, "", time()-100000, "/", "", 0); //le da el expire
			 header("Location: ../");
			 die();
			}
		}
		//header("Location: ".$_SERVER['HTTP_REFERER']."&message=".$lang['succeful_save']."&title=".$lang['Options']."&etype=note&to=./?page=preferences");
		//intercom_add($lang['succeful_save'],$user['id'],0,20);
		//header("Location: ".AddUniToString("./?page=preference&p=".$_GET['p']."&axah=1"));
		//message($lang['succeful_save'], $lang['Options'],$lang['PHP_SELF'],1);
		makeAXAH($lang['succeful_save']);
	} else {
		$parse = $lang;

		$parse['dpath'] = $dpath;
		$parse['skin'] = $user['skin'];
	
		$parse['opt_lst_skin_data'] .= "<option value =\"http://www.ugamelaplay.net/skin/xr/\">UgamelaPlay</option>";		
		$parse['opt_lst_skin_data']	= "<option value =\"http://uni42.ogame.org/game/\">OGame</option>";
		$parse['opt_lst_skin_data'] .= "<option value =\"../skins/xr/\">XNova</option>";

		
		
		$parse['opt_lst_banner_bg']	= "<option value =\"\">--Select Backgound--</option>";
		$parse['opt_lst_banner_bg'] .= "<option value =\"../../images/bann.png\">Banner 1</option>";
		$parse['opt_lst_banner_bg'] .= "<option value =\"../../images/bann2.png\">Banner 2</option>";
		$parse['opt_lst_ord_data']	 = "<option value =\"0\"". (($user['planet_sort'] == 0) ? " selected": "") .">". $lang['opt_lst_ord0'] ."</option>";
		$parse['opt_lst_ord_data']	.= "<option value =\"1\"". (($user['planet_sort'] == 1) ? " selected": "") .">". $lang['opt_lst_ord1'] ."</option>";
		$parse['opt_lst_ord_data']	.= "<option value =\"2\"". (($user['planet_sort'] == 2) ? " selected": "") .">". $lang['opt_lst_ord2'] ."</option>";

		$parse['opt_lst_cla_data']	 = "<option value =\"0\"". (($user['planet_sort_order'] == 0) ? " selected": "") .">". $lang['opt_lst_cla0'] ."</option>";
		$parse['opt_lst_cla_data']	.= "<option value =\"1\"". (($user['planet_sort_order'] == 1) ? " selected": "") .">". $lang['opt_lst_cla1'] ."</option>";

		if ($user['authlevel'] > 0) {
			$FrameTPL = gettemplate('options_admadd');
			$IsProtOn = doquery ("SELECT `id_level` FROM {{table}} WHERE `id_owner` = '".$user['id']."' LIMIT 1;", 'planets', true);
			$bloc['opt_adm_title']		 = $lang['opt_adm_title'];
			$bloc['opt_adm_planet_prot'] = $lang['opt_adm_planet_prot'];
			$bloc['adm_pl_prot_data']		 = ($IsProtOn['id_level'] > 0) ? " checked='checked'/":'';
			$parse['opt_adm_frame']		 = parsetemplate($FrameTPL, $bloc);
		}

		if(($_GET['p'] == '2') || ($_GET['p'] == '3') || ($_GET['p'] == '4')){
			$parse['disp1'] = " style='display:none;'";
		}
		if($_GET['p'] != '2'){
			$parse['disp2'] = " style='display:none;'";
		}
		if($_GET['p'] != '3'){
			$parse['disp3'] = " style='display:none;'";
		}
		if($_GET['p'] != '4'){
			$parse['disp4'] = " style='display:none;'";
		}
		
		$parse['id']			 = $user['id'];
		$parse['forum_id']		 = $user['forum_id'];
		$parse['opt_usern_data'] = $user['username'];
		$parse['sec_qu']		 = $user['sec_qu'];
		$parse['sec_ans']		 = $user['sec_ans'];
		$parse['refers_count']	 = $user['refers'];
		$parse['refid']			 = "http://darkevo.org/?refid=".$user['id']."&uni=".$evouni;
		$parse['opt_mail1_data'] = $user['email'];
		$parse['opt_mail2_data'] = $user['email_2'];
		$parse['opt_dpath_data'] = $user['skin'];
		$parse['opt_avata_data'] = $user['avatar'];
		$parse['opt_probe_data'] = $user['spio_anz'];
		$parse['opt_toolt_data'] = $user['settings_tooltiptime'];
		$parse['opt_fleet_data'] = $user['settings_fleetactions'];
		$parse['opt_sskin_data'] = ($user['design'] == 1) ? " checked='checked'":'';
		$parse['opt_noipc_data'] = ($user['noipcheck'] == 1) ? " checked='checked'":'';
		$parse['opt_allyl_data'] = ($user['settings_allylogo'] == 1) ? " checked='checked'/":'';
		$parse['opt_delac_data'] = ($user['db_deaktjava'] == 1) ? " checked='checked'/":'';
		$parse['opt_modev_data'] = ($user['urlaubs_modus'] == 1)?" checked='checked'/":'';
		$parse['opt_modev_exit'] = ($user['urlaubs_modus'] == 0)?" checked='1'/":'';
		$parse['Vaccation_mode'] = $lang['Vaccation_mode'];
		$parse['vacation_until'] = date("d.m.Y G:i:s",$user['urlaubs_until']);
		$parse['user_settings_rep'] = ($user['settings_rep'] == 1) ? " checked='checked'/":'';
		$parse['user_settings_esp'] = ($user['settings_esp'] == 1) ? " checked='checked'/":'';
		$parse['user_settings_wri'] = ($user['settings_wri'] == 1) ? " checked='checked'/":'';
		$parse['user_settings_mis'] = ($user['settings_mis'] == 1) ? " checked='checked'/":'';
		$parse['user_settings_bud'] = ($user['settings_bud'] == 1) ? " checked='checked'/":'';
		$parse['kolorminus']	= $user['kolorminus'];
		$parse['kolorplus']	= $user['kolorplus'];
		$parse['kolorpoziom'] = $user['kolorpoziom'];
		$parse['get_ip'] = $_SERVER['REMOTE_ADDR'];

		if($user['urlaubs_modus']){
			displaypage(parsetemplate(gettemplate('options_body_vmode'), $parse), 'Options', false);
		}else{
			if($_GET['axah']){
				makeAXAH(parsetemplate(gettemplate('options'), $parse));
			}else{
				displaypage(parsetemplate(gettemplate('options'), $parse), 'Options');
			}
		}
		die();
	}

?>
