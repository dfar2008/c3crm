<?php
session_start();
unset($_SESSION['nick']); 
unset($_SESSION['authenticated_user_id']); 
unset($_SESSION['app_unique_key']); 
unset($_SESSION['topsession']); 


$root_directory = dirname(__FILE__)."/"; 
require($root_directory.'include/init.php');

define( "WB_AKEY" , '3020836644' );
define( "WB_SKEY" , 'd8a6a9c5a2053367e292801fc9234000' );
define( "WB_CALLBACK_URL" , 'http://1.crm123.sinaapp.com/callback.php' );
include_once( 'include/saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	
	$_SESSION['topsession'] = $token; 
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
	
	$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['topsession']['access_token'] );
	$ms  = $c->home_timeline(); // done
	
	$uid_get = $c->get_uid();
	
	$uid = $uid_get['uid'];
	
	$user_message = $c->show_user_by_id($uid);//根据ID获取用户等基本信息
	
	$username = $user_message["name"];
	
	if(empty($username)) {
		redirect("Login.php?login_error=".rawurlencode("error:".$user_message["error"].",error_code:".$user_message["error_code"]));
	}
	$_SESSION['nick'] = $user_message["name"];
	
	$userid = getUserIDByNick($username);
	if($userid == 0){
		$userid = InsertNickInfo($username,"weibo");
	}
	$_SESSION['authenticated_user_id'] = $userid;
	$_SESSION['app_unique_key'] = $application_unique_key;
	$_SESSION['authenticated_user_language'] = 'zh_cn';

	redirect("index.php");


} else {
	redirect("Login.php");

}
?>
