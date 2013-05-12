<?php

require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('include/DatabaseUtil.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $current_language;

//Display the mail send status
$smarty = new CRMSmarty();

global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$mode = '';
$record = $_REQUEST['record'];


if(!empty($record)){
	$query = "select * from ec_appkey where id=$record";
	$row = $adb->getFirstLine($query);
	if(!empty($row)){
		$shopname = $row['shopname'];
		$appkey = $row['appkey'];
		$appsecret = $row['appsecret'];
		$nick = $row['nick'];
		$topsession = $row['topsession'];
		$status = $row['status'];
	}
	$mode = 'edit';
}

$smarty->assign("shopname", $shopname);
$smarty->assign("appkey", $appkey);
$smarty->assign("appsecret", $appsecret);
$smarty->assign("topsession", $topsession);
$smarty->assign("nick", $nick);
$smarty->assign("status", $status);

if($mode == 'edit'){
	$edittype = "编辑";
}else{
	$edittype = "新增";
}
$smarty->assign("record", $record);

$smarty->assign("EDITTYPE", $edittype);
$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Relsettings/EditShopapp.tpl");


?>
