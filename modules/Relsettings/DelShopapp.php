<?php

require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('include/DatabaseUtil.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $current_language;


$record = $_REQUEST['record'];

if(!empty($record)){
	$query = "delete from ec_appkey where id=$record";
	$adb->query($query);
}else{
	die("Record is empty!");	
}

redirect("index.php?module=Relsettings&parenttab=Settings&action=Taobaozushou");

?>
