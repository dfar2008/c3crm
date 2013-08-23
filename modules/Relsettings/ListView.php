<?php
require_once('include/CRMSmarty.php');
global $app_strings;
global $app_list_strings;
global $current_user;
global $theme;
global $adb;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty = new CRMSmarty();
$mod_strings = return_specified_module_language("zh_cn","Settings");

$relsetmode = "view";
if(isset($_REQUEST['relsetmode']) && $_REQUEST['relsetmode'] != ''){
	$relsetmode = $_REQUEST['relsetmode'];
}
$smarty->assign("RELSETMODE", $relsetmode);

$relset = "EmailConfig";
if($_REQUEST['relset'] && !empty($_REQUEST['relset'])){
	$relset = $_REQUEST['relset'];
}
$relsetarray = array(
			"EmailConfig"=>$mod_strings['LBL_MAIL_SERVER_SETTINGS'],
			//"MessageConfig"=>$mod_strings['LBL_SERVER_SETTINGS'],
			"MemdayConfig"=>$mod_strings['LBL_MEMDAY_SETTING'],
			"EditPwd"=>$mod_strings['LBL_EDIT_PASSWORD'],
			"EditMoreInfo"=>$mod_strings['LBL_EDIT_MORE_INFO'],
			//"MailLogs"=>$mod_strings['LBL_MAIL_LOGS'],
			//"Taobaozushou"=>$mod_strings['TAOBAOZUSHOU'],
			//"SmsAccount"=>$mod_strings['LBL_DUANXINZHANGHAOSHEZHI']
            "SmsLogs"=>"短信日志"
	);
$relsetkeyarr = array_keys($relsetarray);
if(!empty($relset) && in_array($relset,$relsetkeyarr)){
	require_once("modules/Relsettings/{$relset}.php");
}

$smarty->assign("RELSETARRAY", $relsetarray);
$smarty->assign("RELSET", $relset);
$relsethead = $mod_strings['LBL_USER_MANAGEMENT'];
$smarty->assign("RELSETHEAD", $relsethead);

$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", 'Relsettings');
$smarty->assign("CATEGORY", 'Settings');
$smarty->assign("MOD", $mod_strings);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->display("Relsettings/Settings.tpl"); 
?>