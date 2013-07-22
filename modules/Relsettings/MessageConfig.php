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

$sql="select * from ec_systemcharges where  userid='".$current_user->id."' "; 
$row = $adb->getFirstLine($sql);
$userid = $row['userid'];
$chargetime = $row['chargetime'] ? $row['chargetime'] : '0000-00-00 00:00:00'; 
$endtime = $row['endtime'] ? $row['endtime'] : '0000-00-00 00:00:00'; 
$chargefee = $row['chargefee']? $row['chargefee'] : 0; 


$smarty->assign("chargefee", $chargefee);
$smarty->assign("endtime", $endtime);
$smarty->assign("chargetime", $chargetime);



$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);

$relsetmode = "view";
if(isset($_REQUEST['relsetmode']) && $_REQUEST['relsetmode'] != ''){
	$relsetmode = $_REQUEST['relsetmode'];
}
$smarty->assign("RELSETMODE", $relsetmode);

//$smarty->display("Relsettings/MessageConfig.tpl");


?>
