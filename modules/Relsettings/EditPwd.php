<?php

require_once('include/CRMSmarty.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $current_language;
global $adb;
//Display the mail send status
$smarty = new CRMSmarty();

$record = $_SESSION['authenticated_user_id'];
$user_name = $_SESSION['nick'];
$smarty->assign("record", $record);
$smarty->assign("user_name", $user_name);
 if(empty($record)){
	die("Record is null!");
} 

$query = "select department from ec_users where id=$record";
$row = $adb->getFirstLine($query);
if(!empty($row)){
	$smarty->assign("department", $row['department']);
}else{
	die("No this record! Please Try To Login Again!");
}


global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);

//$smarty->display("Relsettings/EditPwd.tpl");
?>
