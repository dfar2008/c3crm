<?php
session_start();
require_once('config.php');
require_once('include/utils/utils.php');
require_once('include/database/PearDatabase.php');
global $adb;
global $current_user;

function getCurlResult($parameters,$method){
	
	$sms_url = "http://c3sms.sinaapp.com";
	
	$url = $sms_url.'/rest.php';
	$curl = curl_init($url); 
	curl_setopt($curl, CURLOPT_POST, true); 
	curl_setopt($curl, CURLOPT_HEADER, false); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	
	$json = '['.json_encode($parameters).']'; 
	$postArgs = 'method='.$method.'&rest_data=' . $json; 
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postArgs); 
	$response = curl_exec($curl);
	 
	curl_close($curl);  
	$result = json_decode($response); 	
	//$result = str_replace("(","",$result);
	//$result = str_replace(")","",$result);
	
	return $result;
}

/**
 * 创建client实例
 */
function getSingleInfo($id=''){
        global $adb;
		global $current_user;
		if(!empty($id) && $id >0){
			$userid = $id;
		}elseif(empty($id) && $current_user->id > 0){
			$userid = $current_user->id;
		}else{
			return array('error'=>1,'message'=>'UserId is empty!');
		}
		
        $sql="select * from ec_smsaccount";
		$result = $adb->query($sql);
		$num_rows = $adb->num_rows($result);
		$arr = array();
		if($num_rows > 0){
			$username = trim($adb->query_result($result,0,'username'));
			$password = trim($adb->query_result($result,0,'password'));
			$arr['userid'] = $userid;
			$arr['username'] = $username;
			$arr['password'] = $password;
		}
		return $arr;
}

/**
 * 登录 用例
 */
function loginSMS($userid='')
{
	//获取用户信息
	if(!is_array($userinfo) || empty($userinfo)){
		$userinfo = getSingleInfo($userid);
	}
	
	$parameters = array( 
		'user_name' => $userinfo['username'],
		'password' => $userinfo['password'],
	); 
	$method = "sms_login";
	$result = getCurlResult($parameters,$method);
	if($result->id > 0){
		return array("error"=>0);
	}else{
		return array("error"=>1,"message"=>$result);
	}
	
}

function getBalance($userid='') {
	//获取用户信息
	if(!is_array($userinfo) || empty($userinfo)){
		$userinfo = getSingleInfo($userid);
	}
	$info = loginSMS($userid); 
    //var_dump($userinfo);
	if($info['error'] == 1){
		return array("error"=>1,"message"=>$info['message']);
	}
	
	$parameters = array( 
		'user_name' => $userinfo['username'],
	); 
	
	$result = getCurlResult($parameters,'sms_get_canuse'); 
	
	if(isset($result->canuse)){
            return array("error"=>0,"balance"=>$result->canuse);	
    }else{
		return array("error"=>1,"message"=>"获取余额出错");
	}
	
}


/**
 * 注销登录 用例
 */
function logout($userid='')
{	
	//获取用户信息
	if(!is_array($userinfo) || empty($userinfo)){
		$userinfo = getSingleInfo($userid);
	}
	
	$parameters = array( 
		'user_name' => $userinfo['username'],
	); 
	$method = "sms_logout";
	getCurlResult($parameters,$method);
}


//异步发送短信
function sendSMS($msg,$phonename,$userid='') {
	//获取用户信息
	if(!is_array($userinfo) || empty($userinfo)){
		$userinfo = getSingleInfo($userid);
	}
	
	$info = getBalance($userid); 
	if($info['error'] == 1){
		return array("error"=>1,"message"=>"查询余额出错");
	}elseif($info['error'] == 0 && $info['balance'] ==0){
		return array("error"=>1,"message"=>"没有可用于发送短信的条数");
	}	
	$phonenames = array($phonename);
	$parameters = array( 
		'phonenames' => $phonenames,
		'msg' => $msg,
		'user_name' => $userinfo['username'],
	); 
	$method = "sms_send"; 
	$result = getCurlResult($parameters,$method);
	
	return array("error"=>0);
}

//同步发送短信
function sendMultiSMS($msg,$phonenames,$userid='') {
		//获取用户信息
		if(!is_array($userinfo) || empty($userinfo)){
			$userinfo = getSingleInfo($userid);
		}
		
        $info = getBalance($userid);
		if($info['error'] == 1){
			return array("error"=>1,"message"=>"查询余额出错");
		}elseif($info['error'] == 0 && $info['balance'] ==0){
			return array("error"=>1,"message"=>"没有可用于发送短信的条数");
		}
		
		$parameters = array( 
			'phonenames' => $phonenames,
			'msg' => $msg,
			'user_name' => $userinfo['username'],
		); 
		$method = "sms_send";
		
		$result = getCurlResult($parameters,$method);
		
		
        return array("error"=>0);
}

function getMessageAccount($userid){ 
		//获取用户信息
		if(!is_array($userinfo) || empty($userinfo)){
			$userinfo = getSingleInfo($userid);
		}
		
        $info = getBalance($userid);
		if($info['error'] == 1){
			return array("error"=>1,"message"=>"查询余额出错");
		}elseif($info['error'] == 0 && $info['balance'] ==0){
			return array("error"=>1,"message"=>"没有可用于发送短信的条数");
		}
		
		$parameters = array( 
			'user_name' => $userinfo['username'],
		); 
		$method = "sms_getMessageAccount";
		
		$result = getCurlResult($parameters,$method);	
		
		return $result;
}
function sendSmsByTime($message,$phonenames,$sendtime,$userid) {
	//获取用户信息
	if(!is_array($userinfo) || empty($userinfo)){
		$userinfo = getSingleInfo($userid);
	}
	
	$info = getBalance($userid);
	if($info['error'] == 1){
		return array("error"=>1,"message"=>"查询余额出错");
	}elseif($info['error'] == 0 && $info['balance'] ==0){
		return array("error"=>1,"message"=>"没有可用于发送短信的条数");
	}
	$parameters = array(
		'sendresult' => $phonenames,
		'message' => $message,
		'sendtime' => $sendtime,
		'user_name' => $userinfo['username'],
	);
	$method = "sms_sendSmsByTime";
	$result = getCurlResult($parameters,$method);
	return array("error"=>0);
}

function getUserSmsLogs($userid,$phone){
	//获取用户信息
	if(!is_array($userinfo) || empty($userinfo)){
		$userinfo = getSingleInfo($userid);
	}
	//loginSMS($userid); 
	$parameters = array(
		'phone' => $phone,
		'user_name' => $userinfo['username'],
	); 
	$method = "sms_getSmslogs";  
	$result = getCurlResult($parameters,$method); 
	return $result;
}

//added by ligangze on 2013-10-23
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


