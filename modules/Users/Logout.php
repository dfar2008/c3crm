<?php
session_start();
////参数数组
//$param = array (
//	/* API系统级输入参数 Start */
//		'timestamp' => date('Y-m-d H:i:s'),
//		'app_key' => $_SESSION['appKey'], //Appkey
//		'sign_method' => 'md5' //签名方式
//
//);
//$paramArr = array_merge($param);
//
//$sign = createSign($paramArr, $_SESSION['appSecret']);
//
////组织参数
//$strParam = createStrParam($paramArr);
//$strParam .= 'sign=' . $sign;
//
//
//$rooturl = "http://container.api.taobao.com/container/logoff?";
//
////构造Url
//$url = $rooturl . $strParam;


//unset($_SESSION['sign']); 
unset($_SESSION['nick']); 
unset($_SESSION['authenticated_user_id']); 
unset($_SESSION['app_unique_key']); 
unset($_SESSION['topsession']);
unset($_SESSION['authenticated_user_language']);
redirect("Login.php");
?>
