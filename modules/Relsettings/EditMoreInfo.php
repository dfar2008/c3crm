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
$record = $_SESSION['authenticated_user_id'];
$user_name = $_SESSION['nick'];
if(empty($record)){
	die("Record is null!");
}

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'true')
{
		$phone = $_REQUEST['phone_mobile'];
		$email = $_REQUEST['email1'];

		$query = "SELECT * FROM ec_users WHERE deleted=0 and id !=".$record." and phone_mobile='".$phone."' ";
        $result = $adb->query($query);

        if($adb->num_rows($result) > 0)
        {
			echo 'FAILEDPHONE';
			die;
		}
		else
		{
			$query2 = "SELECT * FROM ec_users WHERE deleted=0 and id !=".$record." and email1='".$email."' ";
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

$smarty->assign("record", $record);
$smarty->assign("user_name", $user_name);

//if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !=''){
	$mode = 'edit';
//}


$selectsql = "select department,last_name,phone_mobile,email1 from ec_users where id=$record";
$row = $adb->getFirstLine($selectsql);
if(!empty($row)){
	$last_name = $row['last_name'];
	$phone_mobile = $row['phone_mobile'];
	$email1 = $row['email1'];
	$department =$row['department'];
	
	$smarty->assign("last_name", $last_name);
	$smarty->assign("phone_mobile", $phone_mobile); 
	$smarty->assign("email1", $email1);
//	if($department =='weibo'){
//		$smarty->assign("readonly", '');
//	}else{
//		$smarty->assign("readonly", 'readonly');
//	}
}else{
	die("No this record! Please Do Login Again!");
}



global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("mode", $mode);

$relsetmode = "view";
if(isset($_REQUEST['relsetmode']) && $_REQUEST['relsetmode'] != ''){
	$relsetmode = $_REQUEST['relsetmode'];
}
$smarty->assign("RELSETMODE", $relsetmode);

//$smarty->display("Relsettings/EditMoreInfo.tpl");
?>
