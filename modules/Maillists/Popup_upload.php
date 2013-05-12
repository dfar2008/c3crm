<?php
require_once('include/CRMSmarty.php');
global $mod_strings;

$smarty = new CRMSmarty();
$sjid = $_REQUEST['sjid'];
$smarty->assign("sjid",$sjid);
$smarty->display('Maillists/upload-attach.tpl');

?>