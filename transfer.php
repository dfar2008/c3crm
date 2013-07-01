<?php
session_start();
unset($_SESSION['nick']); 
unset($_SESSION['authenticated_user_id']); 
unset($_SESSION['app_unique_key']); 
unset($_SESSION['appKey']); 
unset($_SESSION['appSecret']); 
unset($_SESSION['topsession']); 


$root_directory = dirname(__FILE__)."/"; 
require($root_directory.'include/init.php');


$top_appkey = $_GET['top_appkey'];
$top_parameters = $_GET['top_parameters'];
$top_session = $_GET['top_session'];
$top_sign = $_GET['top_sign'];


if(empty($top_sign)){
	header("Location: Login.php");
}


$appKey =$top_appkey;
$appSecret ="86a95918f231189563c9fceefe6e99cc";


$md5 = md5( $top_appkey . $top_parameters . $top_session . $appSecret, true );
$sign = base64_encode( $md5 );


if ( $sign != $top_sign ) {
	echo "<script>alert(\"signature invalid.\");window.location.href=\"Login.php\"</script>";
	die;
}
$_SESSION['sign'] = $sign;

$parameters = array();
parse_str( base64_decode( $top_parameters ), $parameters ); 

/* $now = time();
$ts = $parameters['ts'] / 1000;    
if ( $ts > ( $now + 60 * 10 ) || $now > ( $ts + 60 * 30 ) ) {
	echo "<script>alert(\"request out of date.\");window.location.href=\"Login.php\"</script>";die;
} */

$_SESSION['topsession'] = $_REQUEST['top_session'];
$_SESSION['nick'] = iconv_ec("GBK","UTF-8",$parameters['visitor_nick']);



$userid = getUserIDByNick($_SESSION['nick']);
if($userid == 0){
	$userid = InsertNickInfo($_SESSION['nick'],"taobao");
}
$_SESSION['authenticated_user_id'] = $userid;
$_SESSION['app_unique_key'] = $application_unique_key;

$_SESSION['appKey'] = $appKey;
$_SESSION['appSecret'] = $appSecret;

$_SESSION['authenticated_user_language'] = 'zh_cn';

header("Location: index.php");
?>
