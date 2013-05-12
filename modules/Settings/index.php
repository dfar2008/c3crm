<?php

require_once('include/CRMSmarty.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$smarty = new CRMSmarty();
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", 'Settings');
$smarty->assign("CATEGORY", 'Settings');
$smarty->assign("MOD", $mod_strings);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->display("Settings.tpl");
?>
