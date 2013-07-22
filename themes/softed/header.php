<?php
require_once('include/CRMSmarty.php');
require_once("include/utils/utils.php");

global $currentModule;
global $app_strings;
global $app_list_strings;
global $moduleList;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new CRMSmarty();
$header_array = getHeaderArray();
$smarty->assign("HEADERS",$header_array);
$smarty->assign("THEME",$theme);
$smarty->assign("IMAGEPATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE_NAME", $currentModule);
$smarty->assign("DATE", getDisplayDate(date("Y-m-d H:i")));
$smarty->assign("CURRENT_USER", $current_user->user_name);
$smarty->assign("CURRENT_USER_ID", $current_user->id);
$smarty->assign("MODULELISTS",$app_list_strings['moduleList']);
$smarty->assign("IS_ADMIN",$current_user->is_admin);

$module_path="modules/".$currentModule."/";

///auth
$nowdate = date("Ymd");
$auth = md5($nowdate.$current_user->email2);
$smarty->assign("AUTH",$auth);


//Assign the entered global search string to a variable and display it again
if(isset($_REQUEST['query_string']) && $_REQUEST['query_string'] != '')
	$smarty->assign("QUERY_STRING",$_REQUEST['query_string']);
else
	$smarty->assign("QUERY_STRING",$app_strings["LBL_SEARCH_STRING"]);
$smarty->display("Header.tpl");
?>
