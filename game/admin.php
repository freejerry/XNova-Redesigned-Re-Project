<?php

/**
 * admin.php
 *
 * @version 1.0
 * @copyright 2009 by Anthony for XNova Redesigned
 */

if($user['authlevel'] < 1){
	info($lang['sys_noalloaw'],$lang['sys_noaccess'],'./?page=overview','./?page=overview');
}

getLang('admin');

switch ($_GET['link']) {
	case('errors'):
	//------------------------------------
		include_once(ROOT_PATH."admin/errors.php");
	break;

	case('config'):
	//------------------------------------
		include_once(ROOT_PATH."admin/settings.php");
	break;

	case('supp'):
	//------------------------------------
		include_once(ROOT_PATH."admin/support.php");
	break;

	case('edit'):
	//------------------------------------
		include_once(ROOT_PATH."admin/edit.php");
	break;

	case('addmoon'):
	//------------------------------------
		include_once(ROOT_PATH."admin/addmoon.php");
	break;

	default:
	//------------------------------------
		include_once(ROOT_PATH."admin/overview.php");
	break;
}

$page = parsetemplate(gettemplate('redesigned/admin'),$bloc);
if($_GET['axah']){
	makeAXAH($page,'Admin: '.$bloc['title']);
}else{
	displaypage($page,'Admin: '.$bloc['title']);
}