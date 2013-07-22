<?php
session_start(); 
header("Content-type:text/html;charset=utf-8");
unset($_SESSION['nick']); 
unset($_SESSION['authenticated_user_id']); 
unset($_SESSION['app_unique_key']); 
unset($_SESSION['topsession']);

require_once('config.php');
require_once('modules/Users/Users.php');
require_once('include/logging.php');

global $mod_strings;
global $app_strings;


$focus = new Users();

// Add in defensive code here.
$focus->column_fields["user_name"] = to_html($_REQUEST['user_name']);
$user_password = $_REQUEST['user_password'];
$theme = $_REQUEST['login_theme'];
$focus->load_user($user_password);



if($focus->is_authenticated()) {
	$query = "UPDATE ec_users SET is_online='1', last_ping='".time()."' WHERE user_name='".$focus->column_fields["user_name"]."'";
	$adb->query($query);
	$usip=$_SERVER['REMOTE_ADDR'];
	$intime=date("Y/m/d H:i:s");
	require_once('modules/Users/LoginHistory.php');
	$loghistory=new LoginHistory();
	$Signin = $loghistory->user_login($focus->column_fields["user_name"],$usip,$intime);
	
	unset($_SESSION['login_password']);
	unset($_SESSION['login_error']);
	unset($_SESSION['login_user_name']);
	unset($_SESSION['login_theme']);
	$_SESSION['login_company_name'] = $company_name;
	$_SESSION['authenticated_user_id'] = $focus->id;
	$_SESSION['app_unique_key'] = $application_unique_key;
	$_SESSION['nick'] = $_REQUEST['user_name'];
	$_SESSION['topsession'] = $application_unique_key;

	// store the user's theme in the session
	if (isset($_REQUEST['login_theme'])) {
		$authenticated_user_theme = $_REQUEST['login_theme'];
	}
	else {
		$authenticated_user_theme = $default_theme;
	}
	
	// store the user's language in the session
	if (isset($_REQUEST['login_language'])) {
		$authenticated_user_language = $_REQUEST['login_language'];
	}
	else {
		$authenticated_user_language = $default_language;
	}

	$_SESSION['authenticated_user_theme'] = $authenticated_user_theme;
	$_SESSION['authenticated_user_language'] = $authenticated_user_language;
    redirect("index.php?module=Home&action=index"); 
} else {
	$_SESSION['login_user_name'] = $focus->column_fields["user_name"];
	$_SESSION['login_password'] = $user_password;
	$_SESSION['login_theme'] = $theme;
	//$_SESSION['login_error'] = $mod_strings['ERR_INVALID_PASSWORD'];
	
	// go back to the login screen.	
	// create an error message for the user.
	redirect("Login.php?login_error=".rawurlencode("用户名和密码不对"));
}
?>
