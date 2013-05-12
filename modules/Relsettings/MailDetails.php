<?php

require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('include/DatabaseUtil.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $list_max_entries_per_page;

//Display the mail send status
$smarty = new CRMSmarty();

global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$maillistsid = $_REQUEST['maillistsid'];
if(!isset($maillistsid) || empty($maillistsid)){
	die("The Maillists ID is Empty!");
}

$query= "select * from ec_maillists where maillistsid =$maillistsid and deleted=0";
$row = $adb->getFirstLine($query);

$maillistname = $row['maillistname'];
$from_name  = $row['from_name'];
$from_email  = $row['from_email'];
$receiverinfo = $row['receiverinfo'];
$subject = $row['subject'];
$mailcontent  = $row['mailcontent'];
$successrate = $row['successrate'];
$readrate  = $row['readrate'];
$createdtime = $row['createdtime'];


$smarty->assign("maillistname", $maillistname);
$smarty->assign("from_name", $from_name);
$smarty->assign("from_email", $from_email);
$smarty->assign("receiverinfo", $receiverinfo);
$smarty->assign("subject", $subject);
$smarty->assign("mailcontent", $mailcontent);
$smarty->assign("successrate", $successrate);
$smarty->assign("readrate", $readrate);
$smarty->assign("createdtime", $createdtime);

$smarty->assign("MOD", return_module_language($current_language,'Settings'));

$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Relsettings/MailDetails.tpl");
?>
