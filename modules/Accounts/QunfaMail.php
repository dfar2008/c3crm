<?php
require_once('include/CRMSmarty.php');
require_once('modules/Accounts/Accounts.php');
require_once('include/utils/utils.php');

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;
$focus = new Accounts();
$focus->mode = '';

$smarty = new CRMSmarty();

$idstring = $_REQUEST['idstring'];
if(empty($idstring)){
	echo 'No One Account is checked;';
	die;
}
$idstring = substr($idstring,0,-1); 
$idstring_arr = explode(";",$idstring);
$idstring_str = implode(",",$idstring_arr);

$query = "select * from ec_account where accountid in ({$idstring_str}) and deleted=0 and email !='' ";
$rows = $adb->getList($query);
$account_str ='';
foreach($rows as $row){
		$membername = $row['membername'];
		$email = $row['email'];
		$account_str .= $email.'('.$membername.'),';
}
$smarty->assign("receiveaccountinfo",$account_str);


$adb->query("delete from ec_maillists where deleted=1");
//生成事件id
$sjid = $adb->getUniqueID("ec_crmentity");
$sql = "insert into ec_maillists(maillistsid,deleted) values(".$sjid.",1)";
$adb->query($sql);
$smarty->assign("sjid",$sjid);
$adb->query("insert into ec_crmentity (crmid,setype,smcreatorid,smownerid,createdtime,modifiedtime) values('".$sjid."','Maillists',".$current_user->id.",".$current_user->id.",'".$nowdatetime."','".$nowdatetime."')");


$key = "webmail_array_".$current_user->id;
$webmail_array = getSqlCacheData($key);
if(!$webmail_array) {
	$webmail_array = $adb->getFirstLine("select * from ec_systems where server_type='email' and smownerid='".$current_user->id."'");
	if(empty($webmail_array)) {
		echo  "No Smtp Server!";
		die;
	}
	setSqlCacheData($key,$webmail_array);	
}
$from_email = $webmail_array['from_email'];
$from_name = $webmail_array['from_name'];

$smarty->assign("from_email",$from_email);
$smarty->assign("from_name",$from_name);

$smarty->display('QunfaMailForm.tpl');

?>
