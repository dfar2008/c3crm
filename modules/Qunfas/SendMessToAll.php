<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');
require_once("Sms/SmsLib.php");
global $adb,$current_user;
global $currentModule;
$nowdate = date("Y-m-d");
$nowdatetime = date("Y-m-d H:i:s");
$sendtime  = $_REQUEST['sendtime'];
$message = $_REQUEST["message"];
$message = str_replace("##","&",$message);
$receiveaccountinfo = $_REQUEST["receiveaccountinfo"];
$receiveaccountinfo = str_replace("##","&",$receiveaccountinfo);
$receiveaccountarr = explode("\n",$receiveaccountinfo);
foreach($receiveaccountarr as $key=>$receiveaccount){
	if(empty($receiveaccount)){
		continue;
	}
	$receive_arr = explode("(",$receiveaccount); 
	$phone = $receive_arr[0]; //phone
	if($phone && !empty($phone)){
		$is_true = preg_match("/^1[3|4|5|8][0-9]\d{4,8}$/",$phone);
		if(!$is_true){
			echo "Phone:".$phone."不正确或不是手机号码.";die;
		}
	}else{
		echo  "Phone不能为空!";die;
	}
	$receive_name = "";
	if($receive_arr[1]){
		$receive_right_arr = explode(")",$receive_arr[1]);
		$receive_name = $receive_right_arr[0]; //name
		if($receive_name ==''){
			echo  "不能有()的姓名!";die;
		}
	}else{
		echo "格式不正确，请填写姓名！";die;
	}
	$sendresult[] = array('phone'=>$phone,'name'=>$receive_name);
}
if($sendtime && !empty($sendtime)){
	$result = sendSmsByTime($sendresult,$message,$sendtime,$current_user->id);
	if($result['error'] == 0){
		SaveSmsLogs($sendresult,$message,1,"SUCCESS");
		echo "SUCCESS";
		die;
	}else{
		SaveSmsLogs($sendresult,$message,0,$result['message']);
		echo $result['message'];
		die;
	}
}else{
	//发短信
	$result = sendMultiSMS($message,$sendresult);
	if($result['error'] == 0){
		SaveSmsLogs($sendresult,$message,1,"SUCCESS");
		echo "SUCCESS";
		die;
	}else{
		SaveSmsLogs($sendresult,$message,0,$result['message']);
		echo $result['message'];
		die;
	}
}
die;
//changed by xiaoyang on 2012-09-17 
/*
function SaveSmsLogs($sendresult,$content,$flag,$result) {
	global $adb,$current_user;
	$sendtime = date("Y-m-d H:i:s");
	foreach($sendresult as $phonenames){
		$smsobj = array();
		$smsobj['sendermobile'] = $phonenames["phone"];
		$smsobj['content'] = $content;
		$smsobj['sendtime'] = $sendtime;
		$smsobj['success'] = $flag;
		$smsobj['message'] = $result;
		$smsobj['userid'] = $current_user->id;
		$smskeyobj = array_keys($smsobj);
		$fieldsql = join(",",$smskeyobj);
		$valuesql = "'".join("','",$smsobj)."'";
		$record = $adb->getUniqueID("ec_sendsmsbox");
		$query = "insert into ec_sendsmsbox(id,{$fieldsql}) values({$record},{$valuesql}) ";
		$adb->query($query);
	}
}
*/

function SaveSmsLogs($sendresult,$content,$flag,$result) {
	global $adb,$current_user;
	$sendtime = date("Y-m-d H:i:s");
	foreach($sendresult as $phonenames){
		$smsobj = array();
		$smsobj['receiver_phone'] = $phonenames["phone"];
		$smsobj['receiver'] = $phonenames["name"];
		$smsobj['sendmsg'] = $content;
		$smsobj['sendtime'] = $sendtime;
		$smsobj['flag'] = $flag;
		$smsobj['result'] = $result;
		$smsobj['userid'] = $current_user->id;
		$smskeyobj = array_keys($smsobj);
		$fieldsql = join(",",$smskeyobj);
		$valuesql = "'".join("','",$smsobj)."'";
		$record = $adb->getUniqueID("ec_smslogs");
		$query = "insert into ec_smslogs(id,{$fieldsql}) values({$record},{$valuesql}) ";
		$adb->query($query);
	}
}
?>
