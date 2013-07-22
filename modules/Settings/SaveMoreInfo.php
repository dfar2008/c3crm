<?php
require_once("include/database/PearDatabase.php");
require_once('modules/Users/Users.php');
global $current_user;
global $adb;
$focus = new Users();
$userid = $_REQUEST['userid'];
$nowtime = date("Y-m-d H:i:s");
if(empty($userid)){
//	$query = "SELECT count(*) as num FROM ec_users WHERE deleted=0";
//	$result = $adb->query($query);
//	$num =  $adb->query_result($result,0,"num");
//
//	if($num >= 5)
//	{
//		redirect("index.php?module=Settings&action=SmsUser&parenttab=Settings");
//		die;
//	}
	$userid = $adb->getUniqueID("ec_users");
	$encrypted_new_password = $focus->encrypt_password($_REQUEST['user_password']);
	$user_hash = strtolower(md5($_REQUEST['password']));
	$updatesql = "insert into ec_users (id,user_name,user_password,user_hash,last_name,phone_mobile,email1,is_admin,status,register_time,	date_entered,date_modified) values('".$userid."','".$_REQUEST['user_name']."','".$encrypted_new_password."','".$user_hash."','".$_REQUEST['last_name']."','".$_REQUEST['phone_mobile']."','".$_REQUEST['email1']."','".$_REQUEST['is_admin']."','Active','".$nowtime."','".$nowtime."','".$nowtime."')";
	$adb->query($updatesql);
} else {
	$user_password = $_REQUEST['user_password'];
	if(empty($user_password)){
		$updatesql = "update ec_users set last_name='".$_REQUEST['last_name']."',phone_mobile='".$_REQUEST['phone_mobile']."',email1='".$_REQUEST['email1']."',status='Active',is_admin='".$_REQUEST['is_admin']."',date_modified='".$nowtime."' where id=$userid";
	}
	else{
		$encrypted_new_password = $focus->encrypt_password($user_password);
		$user_hash = strtolower(md5($user_password));
		$updatesql = "update ec_users set user_password='".$encrypted_new_password."',user_hash='".$user_hash."',last_name='".$_REQUEST['last_name']."',phone_mobile='".$_REQUEST['phone_mobile']."',email1='".$_REQUEST['email1']."',status='Active',is_admin='".$_REQUEST['is_admin']."',date_modified='".$nowtime."' where id=$userid";
	}
	$adb->query($updatesql);
}

//redirect("index.php?module=Settings&parenttab=Settings&action=EditMoreInfo&userid=".$userid);
redirect("index.php?module=Settings&parenttab=Settings&action=SmsUser");
?>
