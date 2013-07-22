<?php


require_once("include/database/PearDatabase.php");
global $current_user;
global $adb;
$mod_strings =  return_specified_module_language("zh_cn","Settings"); 


$userid = $_REQUEST['userid'];
if(empty($userid)){
	die("Error: Userid is empty!");
}

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$query = "select * from ec_smsaccount where userid='".$userid."' ";
$row = $adb->getFirstLine($query);
if(!empty($row)){
	$sql = "update ec_smsaccount set username='".$username."',password='".$password."' where userid={$userid} ";
	$adb->query($sql);
}else{
	$sql = "insert into ec_smsaccount(userid,username,password) values({$userid},'".$username."','".$password."') ";
	$adb->query($sql);
}

header("Location: index.php?module=Relsettings&parenttab=Settings&action=index&relset=SmsAccount");
?>
