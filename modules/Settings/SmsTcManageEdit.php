<?php

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


$record = $_REQUEST['record'];
if(!empty($record)){
	$query = "select * from ec_smstc where id='".$record."' ";
	$row = $adb->getFirstLine($query);
	$num_rows = $adb->num_rows($row);
	if($num_rows > 0){
		$tc = $row['tc'];
		$price = $row['price'];
		$num = $row['num'];
	}
}else{
	$tc = '';
	$price = '';
	$num = '';
}


$smarty->assign("record",$record);
$smarty->assign("tc",$tc);
$smarty->assign("price",$price);
$smarty->assign("num",$num);

$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Settings/SmsTcManageEdit.tpl");



?>
