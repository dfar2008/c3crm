<?php
require_once('include/CRMSmarty.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $current_language;
global $adb;
//Display the mail send status
$smarty = new CRMSmarty();
if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'true')
{
		$user_name = trim($_REQUEST['user_name']);
		$phone = trim($_REQUEST['phone_mobile']);
		$email = $_REQUEST['email1'];
		if($user_name != "") {
			$query = "SELECT * FROM ec_users WHERE deleted=0 and user_name='".$user_name."' ";
			$result = $adb->query($query);

			if($adb->num_rows($result) > 0)
			{
				echo 'FAILEDUSER';
				die;
			}
		}
		if($phone != "") {
			$query = "SELECT * FROM ec_users WHERE deleted=0 and phone_mobile='".$phone."' ";
			$result = $adb->query($query);

			if($adb->num_rows($result) > 0)
			{
				echo 'FAILEDPHONE';
				die;
			}
		}
//		$query = "SELECT count(*) as num FROM ec_users WHERE deleted=0";
//		$result = $adb->query($query);
//		$num =  $adb->query_result($result,0,"num");
//
//		if($num >= 5)
//		{
//			echo 'FAILEDUSER';
//			die;
//		}
		if($email != "")
		{
			$query2 = "SELECT * FROM ec_users WHERE deleted=0 and email1='".$email."' ";
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

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("mode", $mode);
$smarty->assign("SETTYPE","CreateMoreInfo");

$smarty->display("Settings/CreateMoreInfo.tpl");
?>
