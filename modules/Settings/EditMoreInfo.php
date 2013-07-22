<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
require_once('include/CRMSmarty.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $current_language;
global $adb;
//Display the mail send status
$smarty = new CRMSmarty();
$userid = $_REQUEST['userid'];
$record = $_SESSION['authenticated_user_id'];
if(empty($userid)){
	die("Record is null!");
}

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'true')
{
		$phone = trim($_REQUEST['phone_mobile']);
		$email = $_REQUEST['email1'];
		if($phone != "") {
			$query = "SELECT * FROM ec_users WHERE deleted=0 and id !=".$userid." and phone_mobile='".$phone."' ";
			$result = $adb->query($query);

			if($adb->num_rows($result) > 0)
			{
				echo 'FAILEDPHONE';
				die;
			}
		}
		if($email != "")
		{
			$query2 = "SELECT * FROM ec_users WHERE deleted=0 and id !=".$userid." and email1='".$email."' ";
			$result2 = $adb->query($query2);

			if($adb->num_rows($result2) > 0)
			{
				echo 'FAILEDEMAIL';
				die;
			}
			else
			{
				echo 'SUCCESS';
				die;
			}
		}
}

$smarty->assign("userid", $userid);

//if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !=''){
	$mode = 'edit';
//}


$selectsql = "select is_admin,user_name,department,last_name,phone_mobile,email1 from ec_users where id=$userid";
$row = $adb->getFirstLine($selectsql);
if(!empty($row)){
	$user_name = $row['user_name'];
	$is_admin = $row['is_admin'];
	$last_name = $row['last_name'];
	$phone_mobile = $row['phone_mobile'];
	$email1 = $row['email1'];
	$department =$row['department'];
	$smarty->assign("record", $record);
	$smarty->assign("user_name", $user_name);
	$smarty->assign("last_name", $last_name);
	$smarty->assign("phone_mobile", $phone_mobile); 
	$smarty->assign("email1", $email1);
	if($is_admin =='on'){
		$smarty->assign("ISADMIN", true);
	}else{
		$smarty->assign("ISADMIN", false);
	}
}else{
	die("No this record! Please Do Login Again!");
}



global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("SETTYPE", "EditMoreInfo");//added by ligangze
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("mode", $mode);

$smarty->display("Settings/EditMoreInfo.tpl");
?>
