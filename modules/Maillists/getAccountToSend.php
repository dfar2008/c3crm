<?php

require_once('include/utils/utils.php');
require_once('modules/Qunfas/Qunfas.php');
require_once('modules/Fenzu/Fenzu.php');
require_once('modules/Accounts/Accounts.php');
global $adb,$current_user;
global $currentModule;


$focus = new Qunfas();
$oFenzu = new Fenzu("Qunfas");
$focus_acc = new Accounts();


$viewid = $_REQUEST["viewname"];

if(!$viewid || $viewid == ''){
	echo '';die;
}

$listquery = "SELECT ec_account.accountid as crmid,ec_users.user_name,ec_account.membername,ec_account.email
			  FROM ec_account
			  LEFT JOIN ec_users
				   ON ec_users.id = ec_account.smownerid
			  WHERE ec_account.deleted = 0 and ec_account.email !='' "; //and (ec_account.oneweeksendmail = 0 and ec_account.onemonthsendmail < 5)
$is_admin = $_SESSION['crm_is_admin'];
if(!$is_admin) {
	$listquery .= " and ec_users.id='".$current_user->id."'";
}
$query = $oFenzu->getModifiedCvListQuery($viewid,$listquery,"Accounts");
$result = $adb->getList($query);
$infohtml = '';
foreach($result as $row)
{
	$accountname = $row['membername'];
	$email = $row['email'];
	$infohtml .=$email."(".$accountname.")\n";
}

echo $infohtml;
exit();

?>