<?php
define('IN_CRMONE', true);
//sae_xhprof_start();
global $root_directory;
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
	echo "<script>parent.location.href='Login.php';</script>";
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

// for printing
$module = (isset($_REQUEST['module'])) ? $_REQUEST['module'] : "";
$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : "";
$record = (isset($_REQUEST['record'])) ? $_REQUEST['record'] : "";
$lang_crm = (isset($_SESSION['authenticated_user_language'])) ? $_SESSION['authenticated_user_language'] : "";
$GLOBALS['request_string'] = "&module=$module&action=$action&record=$record&lang_crm=$lang_crm";



//Code added for 'Path Traversal/File Disclosure' security fix - Philip
$is_module = false;
if(empty($module))
{
	$module = $_REQUEST['module'];
	$module_dir = $root_directory."modules/".$module;
	if(is_dir($module_dir)) {
		$is_module = true;
	} else {
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
    echo "<script>parent.location.href='Login.php';</script>";
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

	if($module == 'Home' || $module == 'uploads')
	{
	    $skipSecurityCheck=true;
	}

	$currentModuleFile = 'modules/'.$module.'/'.$action.'.php';
	$currentModule = $module;
	
      	
}
elseif(!empty($module))
{
	
	$currentModule = $module;
	$currentModuleFile = "modules/".$currentModule."/index.php";
}
else {
    //redirect("main.php?action=".$default_action."&module=".$default_module);
	//redirect("main.php");
    //exit();
	$currentModule = $default_module;
	$currentModuleFile = "modules/".$default_module."/".$default_action.".php";
}

$log->info("current page is $currentModuleFile");	
$log->info("current module is $currentModule ");	

$current_user = new Users();

if($use_current_login)
{ 
	//$result = $current_user->retrieve($_SESSION['authenticated_user_id']);
	//getting the current user info from flat file
	$result = $current_user->retrieveCurrentUserInfoFromFile($_SESSION['authenticated_user_id']);
	if($result == null)
	{
		$_SESSION['not_login_query_string'] = $_SERVER["QUERY_STRING"];
		//echo "<script>parent.location.href='Login.php';</script>";
	    exit();
	}
	$log->debug('Current user is: '.$current_user->user_name);
}

//Used for current record focus
$focus = "";
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

}

//skip headers for popups, deleting, saving, importing and other actions
if(!$skipHeaders) {
	if($use_current_login)
	{
		include('themes/'.$theme.'/header.php');
	}
}

if(!$skipSecurityCheck)
{
	require_once($root_directory.'include/utils/UserInfoUtil.php');
	if(javaStrPos($action,'Ajax') > -1)
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
		<a href='javascript:goback();'>".$app_strings["LBL_GO_BACK"]."</a><br>								   						     </td>
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
	
	
	echo "<table align='center'><tr><td align='center'>";
	
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
	include($root_directory.'themes/'.$theme.'/footer.php');
}
//sae_xhprof_end();
?>
