<?php


require_once("include/database/PearDatabase.php");
global $current_user;
global $adb;
$mod_strings =  return_specified_module_language("zh_cn","Settings"); 

$type = $_REQUEST['type'];
$insertkey =",type";
$insertval =",'".$type."'";
$updatesql ="type='".$type."'";

$record = $_REQUEST['record'];
if($_REQUEST['ajax']){
	if(empty($record)){
		$query = "select * from ec_memdayconfig where type='".$type."' and smownerid ='".$current_user->id."'";
	}else{
		$query = "select * from ec_memdayconfig where type='".$type."' and smownerid ='".$current_user->id."' and id !=".$record." ";
	}

	$result = $adb->query($query);
	$num_rows  = $adb->num_rows($result);
	if($num_rows > 0){
		echo "FAILED";
	}else{
		echo "SUCCESS";	
	}
	die;
}

$sms = $_REQUEST['sms'] ? $_REQUEST['sms'] :'off';
$insertkey .=",sms";
$insertval .=",'".$sms."'";
$updatesql .=",sms='".$sms."'";

$smstoacc = $_REQUEST['smstoacc'] ? $_REQUEST['smstoacc'] :'off';
$insertkey .=",smstoacc";
$insertval .=",'".$smstoacc."'";
$updatesql .=",smstoacc='".$smstoacc."'";

$smstouser = $_REQUEST['smstouser'] ? $_REQUEST['smstouser'] :'off';
$insertkey .=",smstouser";
$insertval .=",'".$smstouser."'";
$updatesql .=",smstouser='".$smstouser."'";


$email = $_REQUEST['email'] ? $_REQUEST['email'] : 'off';
$insertkey .=",email";
$insertval .=",'".$email."'";
$updatesql .=",email='".$email."'";

$emailtoacc = $_REQUEST['emailtoacc'] ? $_REQUEST['emailtoacc'] :'off';
$insertkey .=",emailtoacc";
$insertval .=",'".$emailtoacc."'";
$updatesql .=",emailtoacc='".$emailtoacc."'";

$emailtouser = $_REQUEST['emailtouser'] ? $_REQUEST['emailtouser'] :'off';
$insertkey .=",emailtouser";
$insertval .=",'".$emailtouser."'";
$updatesql .=",emailtouser='".$emailtouser."'";


$tp = $_REQUEST['tp'];
if(!empty($tp)){
	$insertkey .=",tp";
	$insertval .=",'".$tp."'";
	$updatesql .=",tp='".$tp."'";
}else{
	$updatesql .=",tp=0";
}


$autoact_sms_sm = $_REQUEST['autoact_sms_sm'];

$autoact_email_bt = $_REQUEST['autoact_email_bt'];
$autoact_email_sm = $_REQUEST['autoact_email_sm'];


if(!empty($record)){
	
	if($sms == 'on'){	
		$updatesql .= ",autoact_sms_sm='".$autoact_sms_sm."'";
	}else{
		$updatesql .= ",autoact_sms_sm=''";
	}
	if($email == 'on'){
		$updatesql .= ",autoact_email_bt='".$autoact_email_bt."',autoact_email_sm='".$autoact_email_sm."'";
	}else{
		$updatesql .= ",autoact_email_bt='',autoact_email_sm=''";
	}
	$updatesql .= ",modifiedtime='".date("Y-m-d H:i:s")."'";
	
	$updatequery = "update ec_memdayconfig set {$updatesql} where id=$record"; 
	$adb->query($updatequery);
}else{
	if($sms == 'on'){	
		$insertkey .=",autoact_sms_sm";
		$insertval .=",'".$autoact_sms_sm."'";
	}
	if($email == 'on'){
		$insertkey .=",autoact_email_bt,autoact_email_sm";
		$insertval .=",'".$autoact_email_bt."','".$autoact_email_sm."'";
	}
	$insertkey .=",smownerid,createdtime,modifiedtime";
	$insertval .=",'".$current_user->id."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."'";
	
	$id  = $adb->getUniqueID("ec_memdayconfig");
	$insertquery = "insert into ec_memdayconfig(id{$insertkey}) values(".$id."{$insertval})";
	$adb->query($insertquery);
}




header("Location: index.php?module=Relsettings&parenttab=Settings&action=MemdayConfig");
?>
