<?php
define('IN_CRMONE', true);
$root_directory = dirname(__FILE__)."/";
if($calculate_response_time) {
	$startTime = microtime();
	$queryTime = 0;
	$connectTime = 0;
	$queryTimes = 0;
	$connectTimes = 0;
	$noneDBTime = 0;
}

require($root_directory.'include/init.php');
if(isset($_REQUEST['module_action']) && $_REQUEST['module_action'] != "") {
	$_REQUEST['action'] = $_REQUEST['module_action'];
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] == "Login") {
	redirect("Login.php");
	exit();
}
if (!is_file('config.inc.php')) {
	redirect("install.php");
	exit();
}

if (isset($_REQUEST['PHPSESSID'])) $log->debug("****Starting for session ".$_REQUEST['PHPSESSID']);
else $log->debug("****Starting for new session");

// We use the REQUEST_URI later to construct dynamic URLs.  IIS does not pass this field
// to prevent an error, if it is not set, we will assign it to ''
if(!isset($_SERVER['REQUEST_URI']))
{
	$_SERVER['REQUEST_URI'] = '';
}

$action = '';
if(isset($_REQUEST['action']))
{
	$action = $_REQUEST['action'];
}

$is_module = false;
if(isset($_REQUEST['module']))
{
	$module = $_REQUEST['module'];
	$module_dir = $root_directory."modules/".$module;
	if(is_dir($module_dir)) {
		$is_module = true;
	}
	if(!$is_module)
	{
		die("Module name is missing. Please check the module name.");
	}
}
//changed by dingjianting on 2007-9-13 for set default viewscope as current_user for china.travel
if(($action == "ListView" || $action == "index") && !isset($_SESSION[$module.'_viewscope'])) {
	global $default_viewscope;
	if(!empty($default_viewscope)) {
		$_SESSION[$module.'_viewscope'] = $default_viewscope;
	} else { 
		$_SESSION[$module.'_viewscope'] = "current_user";
	}
}
if(isset($_REQUEST['pagesize'])) {
	$list_max_entries_per_page = $_REQUEST['pagesize'];
	$_SESSION[$module.'_pagesize'] = $list_max_entries_per_page;	
} else {
	if(isset($_SESSION[$module.'_pagesize'])) {
		$list_max_entries_per_page = $_SESSION[$module.'_pagesize'];
	}
}
if($action == 'Export')
{
	include ($root_directory.'include/utils/export.php');
}

//Code added for 'Multiple SQL Injection Vulnerabilities & XSS issue' fixes - Philip
if(isset($_REQUEST['record']) && !is_numeric($_REQUEST['record']) && $_REQUEST['record']!='')
{
        die("An invalid record number specified to view details.");
}

// Check to see if there is an authenticated user in the session.
$use_current_login = false;
if(isset($_SESSION["authenticated_user_id"]))
{
        $use_current_login = true;
}


if($use_current_login)
{
	$log->debug("We have an authenticated user id: ".$_SESSION["authenticated_user_id"]);
}
else if(isset($action) && isset($module) && $action=="Authenticate" && $module=="Users")
{
	$log->debug("We are authenticating user now");
}
else 
{
	$log->debug("The current user does not have a session.  Going to the login page");	
	$action = "Login";
	$module = "Users";
	$_SESSION['not_login_query_string'] = $_SERVER["QUERY_STRING"];
	redirect("Login.php");
}
$skipHeaders=false;
$skipFooters=false;
$viewAttachment = false;
$skipSecurityCheck= false;
if(!empty($action) && !empty($module))
{
	$log->info("About to take action ".$action);
	
	foreach ($skipActions as $skipAction) {
		$isSkip = javaStrPos($action,$skipAction);
		if($isSkip > -1) {			
			$skipHeaders=true;
			$skipFooters=true;
			break;
		}
	}
	
	if($action == 'Save')
	{
 	         header( "Expires: Mon, 20 Dec 1998 01:00:00 GMT" );
 	         header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
 	         header( "Cache-Control: no-cache, must-revalidate" );
 	         header( "Pragma: no-cache" );        
 	}

	if($module == 'Users' || $module == 'Home' || $module == 'uploads')
	{
	    $skipSecurityCheck=true;
	}

	$currentModuleFile = 'modules/'.$module.'/'.$action.'.php';
	$currentModule = $module;
	
      	
}
elseif(isset($module))
{	
	$currentModule = $module;
	$currentModuleFile = "modules/".$currentModule."/index.php";
}
else {
	redirect("index.php?action=".$default_action."&module=".$default_module);
}

$log->info("current page is $currentModuleFile");	
$log->info("current module is $currentModule ");	


// for printing
$module = (isset($_REQUEST['module'])) ? $_REQUEST['module'] : "";
$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : "";
$record = (isset($_REQUEST['record'])) ? $_REQUEST['record'] : "";
$lang_crm = (isset($_SESSION['authenticated_user_language'])) ? $_SESSION['authenticated_user_language'] : "";
$GLOBALS['request_string'] = "&module=$module&action=$action&record=$record&lang_crm=$lang_crm";

$current_user = new Users();

if($use_current_login)
{	
	//$result = $current_user->retrieve($_SESSION['authenticated_user_id']);
	//getting the current user info from flat file
	$result = $current_user->retrieveCurrentUserInfoFromFile($_SESSION['authenticated_user_id']);
	
	if($result == null)
	{
		$_SESSION['not_login_query_string'] = $_SERVER["QUERY_STRING"];
		redirect("Login.php");
	}
	$log->debug('Current user is: '.$current_user->user_name);
}

if(isset($_SESSION['authenticated_user_theme']) && $_SESSION['authenticated_user_theme'] != '')
{
	$theme = $_SESSION['authenticated_user_theme'];
}
else 
{
	$theme = $default_theme;
}
$log->debug('Current theme is: '.$theme);

//Used for current record focus
$focus = "";

// if the language is not set yet, then set it to the default language.
if(isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != '')
{
	$current_language = $_SESSION['authenticated_user_language'];
}
else 
{
	$current_language = $default_language;
}
$log->debug('current_language is: '.$current_language);

//set module and application string arrays based upon selected language
$app_strings = return_application_language($current_language);
$app_list_strings = return_app_list_strings_language($current_language);
$mod_strings = return_module_language($current_language, $currentModule);
// Define the first day of the week for the JavaScript calendar according to setting in config.inc.php 
// Assigned in calendar-setup.js"  0 => Sunday, 1 => Monday
// This will be inserted in Header.tpl
global $monday_first;
$app_strings["FIRST_DAY_OF_WEEK"] = $monday_first ? "1" : "0";

//If DetailView, set focus to record passed in
if($action == "DetailView")
{
	if(!isset($_REQUEST['record']))
		die("A record number must be specified to view details.");
	//changed by dingjianting on 2007-11-11 for performance
	/*
	if(isset($_REQUEST['record']) && $_REQUEST['record']!='' && $_REQUEST["module"] != "Webmails") 
	{
		track_view($current_user->id,$currentModule,$_REQUEST['record']);
	}
	*/

}

//skip headers for popups, deleting, saving, importing and other actions
if(!$skipHeaders) {
	if($use_current_login)
	{
		include($root_directory.'themes/'.$theme.'/header.php');
	}
}
if(!$skipSecurityCheck)
{
	require_once($root_directory.'include/utils/UserInfoUtil.php');
	$isSkip = javaStrPos($action,'Ajax');
	if($isSkip > -1) 
	{
			$now_action=$_REQUEST['file'];
	}
	else
	{
			$now_action=$action;
	}
	

	if(isset($_REQUEST['record']) && $_REQUEST['record'] != '')
	{
			$display = isPermitted($module,$now_action,$_REQUEST['record']);
	}
	else
	{
			if($now_action == "EditView") {
				$now_action = "Create";
			}
			$display = isPermitted($module,$now_action);
	}
	
}

if($display == "no")
{
	echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
	echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='themes/$theme/images/denied.gif' ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>".$app_strings["LBL_PERMISSION"]."</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'>			   	
		<a href='javascript:window.history.back();'>".$app_strings["LBL_GO_BACK"]."</a><br>								   						     </td>
		</tr>
		</tbody></table> 
		</div>";
	echo "</td></tr></table>";
	$skipFooters = true;
}
else
{
	include($root_directory.$currentModuleFile);
}

if(!$skipFooters)
{
	// include_once($root_directory.'ecversion.php');
	// echo "<script language = 'JavaScript' type='text/javascript' src = 'include/js/popup.js'></script>";
	// echo "<br><br><br><table border=0 cellspacing=0 cellpadding=5 width=100% class=settingsSelectedUI >";
	// echo "<tr><td class=small align=left><a href='".$app_strings["LBL_BROWSER_URL"]."' target='_blank'>E-CRM".$ec_current_version."</a> </td>";
	// echo "<td class=small align=right> &copy; <a href='javascript:mypopup()'>Copyright Details</a></td></tr></table>";
			
	/*
	echo "<table align='center'><tr><td align='center'>";
	// Under the Sugar Public License referenced above, you are required to leave in all copyright statements
	// in both the code and end-user application.
	if($calculate_response_time)
	{
		$endTime = microtime();
		$deltaTime = microtime_diff($startTime, $endTime);
		$webTime = $deltaTime - $connectTime - $queryTime;
		echo('Server response time: '.$deltaTime.' seconds.<br>');
		echo('Server response connect time: '.$connectTime.' seconds.<br>');
		echo('Server response query time: '.$queryTime.' seconds.<br>');
		echo('Server response connect times: '.$connectTimes.' times.<br>');
		echo('Server response query times: '.$queryTimes.' times.<br>');
		echo('Server response web time: '.$webTime.' seconds.<br>');
		if (function_exists('memory_get_peak_usage')) {
			echo "Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB<br>";
		}
	}
	echo "</td></tr></table>\n";
	*/
	// ActivityReminder Customization for callback
	
	// if(!isset($is_disable_pm) || !$is_disable_pm) {
	// 	echo "<script type='text/javascript'>if(typeof(ActivityReminderCallback) != 'undefined') ActivityReminderCallback();</script>";
	// }
	include($root_directory.'themes/'.$theme.'/footer.php');
}
?>
