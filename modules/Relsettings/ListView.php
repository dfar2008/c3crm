<?php
require_once('include/CRMSmarty.php');

global $app_strings;
global $app_list_strings;
$mod_strings = return_specified_module_language("zh_cn","Settings");

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new CRMSmarty();
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", 'Relsettings');
$smarty->assign("CATEGORY", 'Settings');
$smarty->assign("MOD", $mod_strings);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->display("Relsettings/Settings.tpl"); 
?>
