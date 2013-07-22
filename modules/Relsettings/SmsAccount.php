<?php

require_once('include/CRMSmarty.php');
require_once('Sms/SmsLib.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $current_language;
global $adb;
//Display the mail send status
$smarty = new CRMSmarty();

$query = "select * from ec_smsaccount where userid='".$current_user->id."' ";
$row = $adb->getFirstLine($query);
if(!empty($row)){
	$smarty->assign("userid", $row['userid']);
	$smarty->assign("username", $row['username']);
	$smarty->assign("password", $row['password']);
}else{
	$smarty->assign("userid", $current_user->id);
	$smarty->assign("username", '');
	$smarty->assign("password", '');
}


$result = getBalance($current_user->id);
if($result['error'] == 0){
	$smarty->assign("num", $result['balance']);
}else{
	$smarty->assign("num", $result['message']);
}

$systems = getMessageAccount($current_user->id); 

//$sys_canuse = $systems->canuse;
$sys_num = $systems->num;
$sys_monthuse = $systems->monthuse;
$sys_enddate = $systems->enddate;

if($sys_num <= $sys_monthuse){
	$weiyong = 0;
}else{
	$weiyong = $sys_num - $sys_monthuse;
}
if(empty($sys_monthuse)){
	$sys_monthuse = 0;
}
/*if(empty($sys_canuse)){
	$sys_canuse = 0;
}*/
if(empty($sys_enddate)){
	$nextclearday = '00-00';
}else{
	$d = substr($sys_enddate,-2); 
	$nextclearday=date('m',strtotime("1 month"))."-".$d;
}

$smarty->assign("sys_monthuse", $sys_monthuse);
$smarty->assign("weiyong", $weiyong);
$smarty->assign("nextclearday", $nextclearday);

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);

$relsetmode = "view";
if(isset($_REQUEST['relsetmode']) && $_REQUEST['relsetmode'] != ''){
	$relsetmode = $_REQUEST['relsetmode'];
}
$smarty->assign("RELSETMODE", $relsetmode);

//$smarty->display("Relsettings/SmsAccount.tpl");
?>
