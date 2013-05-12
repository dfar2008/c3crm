<?php
require_once('include/CRMSmarty.php');
require_once('modules/Accounts/Accounts.php');
require_once('include/utils/utils.php');

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;
$focus = new Accounts();
$focus->mode = '';

$smarty = new CRMSmarty();


$smarty->display('SelectOperateForm.tpl');

?>
