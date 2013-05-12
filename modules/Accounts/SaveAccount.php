<?php
global $adb;
global $app_strings;
global $current_user;
$adb->startTransaction();
$accountname = $_REQUEST['accountname'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['phone'];
$where = " accountname like '".$accountname."%' ";
$phone = $_REQUEST['phone'];
if($phone != "") {
	$where .= " or phone like '".$phone."%' ";
}

if($email != "") {
	$where .= " or email like '".$email."%' ";
}
$query = "SELECT accountname FROM ec_account WHERE deleted=0 and (".$where.")";
$result = $adb->query($query);
if($adb->num_rows($result) > 0)
{
	echo 'REPEAT';
	die;
}
require_once("modules/Accounts/Accounts.php");
$focus = new Accounts();
$focus->column_fields["accountname"] = $accountname;
$focus->column_fields["phone"] = $phone;
$focus->column_fields["email"] = $email;
$focus->column_fields["assigned_user_id"] = $current_user->id;
require_once('user_privileges/seqprefix_config.php');
$focus->column_fields['customernum'] = $account_seqprefix."-".$focus->get_next_id();
$focus->id = "";
$focus->mode = "";
$focus->save("Accounts");
$return_id = $focus->id;
echo $return_id;
die;
?>
