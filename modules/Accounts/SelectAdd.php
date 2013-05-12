<?php
require_once('include/CRMSmarty.php');
require_once('modules/Accounts/Accounts.php');
require_once('include/utils/utils.php');

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;
$focus = new Accounts();
$focus->mode = '';

$smarty = new CRMSmarty();

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("MODULE",$currentModule);


$smarty->display('SelectAddForm.tpl');

?>
