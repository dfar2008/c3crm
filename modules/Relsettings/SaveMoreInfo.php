<?php
require_once("include/database/PearDatabase.php");
global $current_user;
global $adb;

$record = $_REQUEST['record'];
if(empty($record)){
	die("Record is null!");
}

$updatesql = "update ec_users set last_name='".$_REQUEST['last_name']."',phone_mobile='".$_REQUEST['phone_mobile']."',email1='".$_REQUEST['email1']."',status='Active' where id=$record";
$adb->query($updatesql);



redirect("index.php?module=Relsettings&parenttab=Settings&action=index&relset=EditMoreInfo");
?>
