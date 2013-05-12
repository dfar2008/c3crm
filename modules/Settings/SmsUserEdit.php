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


$userid = $_REQUEST['userid'];
if(!empty($userid)){
	
}else{
	die("UserId is empty!");
}

$sql="select * from ec_systemcharges where  userid='".$userid."' "; 
$row = $adb->getFirstLine($sql);

if(!empty($row)){
	$chargenum = $row['chargenum'];
	$chargetime = $row['chargetime'];
	$chargefee = $row['chargefee'];
	$endtime = $row['endtime'];
}
$smarty->assign("chargenum", $chargenum);
$smarty->assign("chargetime", $chargetime);
$smarty->assign("chargefee", $chargefee);
$smarty->assign("endtime", $endtime);


$username = getUserName($userid);
$lastname = getUserFullName($userid);

$smarty->assign("currentdate",date("Y-m-d"));
$smarty->assign("user_name",$username);
$smarty->assign("last_name",$lastname);
$smarty->assign("userid",$userid);

$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Settings/SmsUserEdit.tpl");



?>
