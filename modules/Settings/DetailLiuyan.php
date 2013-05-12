<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('include/DatabaseUtil.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;

//Display the mail send status
$smarty = new CRMSmarty();

global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$id = $_REQUEST['id'];
if(!empty($id)){
	
}else{
	die("Id is empty!");
}


if(isset($_REQUEST['change']) && $_REQUEST['change'] == 1){
	$updatesql = "update ec_liuyan set reply=1,replytime='".date("Y-m-d H:i:s")."' where id='".$id."' ";
	$adb->query($updatesql);
}

$sql="select * from ec_liuyan where  id='".$id."' "; 
$row = $adb->getFirstLine($sql);

if(!empty($row)){
	$name = $row['name'];
	$tel = $row['tel'];
	$content = $row['content']; 
	$createdtime = $row['createdtime'];
	$reply = $row['reply'];
	$replytime = $row['replytime'];
}
$smarty->assign("ID", $id);
$smarty->assign("name", $name);
$smarty->assign("tel", $tel);
$smarty->assign("content", $content);
$smarty->assign("createdtime", $createdtime);
$smarty->assign("reply", $reply);
$smarty->assign("replytime", $replytime);


$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Settings/DetailLiuyan.tpl");



?>
