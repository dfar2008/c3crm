<?php

require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('include/DatabaseUtil.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;

//Display the mail send status
$smarty = new CRMSmarty();

global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$record = $_REQUEST['record'];

if(!empty($record)){
	//del 
	if(isset($_REQUEST['del']) && $_REQUEST['del']==1 ){
		if(is_admin($current_user))
		{
			$delsql = "delete from ec_memdayconfig where id={$record}";
		}
		else
		{
			$delsql = "delete from ec_memdayconfig where smownerid='".$current_user->id."' and id={$record}";
		}	
		$adb->query($delsql);
		echo "<scr"."ipt>window.location.href=\"index.php?module=Relsettings&action=MemdayConfig\";</script>";
	}
	
	//edit
	if(is_admin($current_user))
	{
		$query = "select * from ec_memdayconfig where id={$record}";
	}
	else
	{
		$query = "select * from ec_memdayconfig where smownerid='".$current_user->id."' and id={$record}";
	}		
	$result = $adb->query($query);
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		$id = $adb->query_result($result,0,"id");
		$tp = $adb->query_result($result,0,"tp");
		$sms = $adb->query_result($result,0,"sms");
		$autoact_sms_sm = $adb->query_result($result,0,"autoact_sms_sm");
		$email = $adb->query_result($result,0,"email");
		$autoact_email_bt = $adb->query_result($result,0,"autoact_email_bt");
		$autoact_email_sm = $adb->query_result($result,0,"autoact_email_sm");
		$type = $adb->query_result($result,0,"type");
		$emailtoacc = $adb->query_result($result,0,"emailtoacc");
		$emailtouser = $adb->query_result($result,0,"emailtouser");
		$smstoacc = $adb->query_result($result,0,"smstoacc");
		$smstouser = $adb->query_result($result,0,"smstouser");
	}
}else{
	$tp = '';
	$sms = 'off';	
	$email = 'off';	
	$autoact_sms_sm='';
	$autoact_email_bt='';
	$autoact_email_sm='';
	$type = '';
	$emailtoacc = 'off';
	$emailtouser = 'off';
	$smstoacc = 'off';
	$smstouser = 'off';
}

if($sms =='on'){
	$arr_sms = "checked";
}else{
	$arr_sms = "";
}

if($email == 'on'){
	$arr_email = "checked";
}else{
	$arr_email = "";
}

if($emailtoacc == 'on'){
	$arr_emailtoacc = "checked";
}else{
	$arr_emailtoacc = "";
}
if($emailtouser == 'on'){
	$arr_emailtouser = "checked";
}else{
	$arr_emailtouser = "";
}
if($smstoacc == 'on'){
	$arr_smstoacc = "checked";
}else{
	$arr_smstoacc = "";
}
if($smstouser == 'on'){
	$arr_smstouser = "checked";
}else{
	$arr_smstouser = "";
}


$typearr = getPickListVal("memday938");
$smarty->assign("typearr",$typearr);
$smarty->assign("record",$record);
$smarty->assign("arr_sms",$arr_sms);
$smarty->assign("arr_email",$arr_email);
$smarty->assign("arr_emailtoacc",$arr_emailtoacc);
$smarty->assign("arr_emailtouser",$arr_emailtouser);
$smarty->assign("arr_smstoacc",$arr_smstoacc);
$smarty->assign("arr_smstouser",$arr_smstouser);
$smarty->assign("at",$at);
$smarty->assign("tp",$tp);
$smarty->assign("autoact_sms_sm",$autoact_sms_sm);
$smarty->assign("autoact_email_bt",$autoact_email_bt);
$smarty->assign("autoact_email_sm",$autoact_email_sm);
$smarty->assign("type",$type);


$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Relsettings/MemdayConfigEdit.tpl");

function getPickListVal($col){
	global $adb;
	if($col !=''){
		$query = "select * from ec_picklist where colname='".$col."' order by sequence";
		$result = $adb->query($query);
		$num_rows = $adb->num_rows($result);
		if($num_rows > 0){
			$PickList = array();
			for($i=0;$i<$num_rows;$i++){
				$colvalue = $adb->query_result($result,$i,"colvalue");
				$PickList[] = $colvalue;
			}
			return $PickList;
		}else{
			return array();	
		}
	}else{
		return array();	
	}
}
?>
