<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/ec_crm/sugarcrm/index.php,v 1.93 2005/04/21 16:17:25 ray Exp $
 * Description: Main file and starting point for the application.  Calls the 
 * theme header and footer files defined for the user as well as the module as 
 * defined by the input parameters.
 ********************************************************************************/
// Allow for the session information to be passed via the URL for printing.
if(isset($_REQUEST['PHPSESSID']))
{
	session_id($_REQUEST['PHPSESSID']);
	//Setting the same session id to Forums as in CRM
        $sid=$_REQUEST['PHPSESSID'];
}
// Create or reestablish the current session
session_start();
if(isset($_REQUEST['module_action']) && $_REQUEST['module_action'] != "") {
	$_REQUEST['action'] = $_REQUEST['module_action'];
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] == "Login") {
	header("Location: Login.php");
	exit();
}
if (!is_file('config.php')) {
	header("Location: install.php");
	exit();
}

require_once('config.php');

if ((!isset($dbconfig['db_hostname']) || $dbconfig['db_status']=='_DB_STAT_') && ((isset($_REQUEST['action']) && $_REQUEST['action'] != "Authenticate" && $_REQUEST['action'] != "Login") || !isset($_REQUEST['action']))) {
		header("Location: Login.php");
		exit();
}
/*
if (is_file('config_override.php')) 
{
	require_once($root_directory.'config_override.php');
}

if($calculate_response_time) {
	$startTime = microtime();
	$queryTime = 0;
	$connectTime = 0;
	$queryTimes = 0;
	$connectTimes = 0;
	$noneDBTime = 0;
}
*/			
// load up the config_override.php file.  This is used to provide default user settings


global $entityDel;
global $display;
global $category;
require_once($root_directory.'include/utils/utils.php');
global $currentModule;

 
if(isset($_SESSION['authenticated_user_theme']) && $_SESSION['authenticated_user_theme'] != '')
{
	$theme = $_SESSION['authenticated_user_theme'];
}
else 
{
	$theme = $default_theme;
}



$Ajx_module= $module;
if($module == 'Events')
	$Ajx_module = 'Calendar';
if((!$viewAttachment) &&  $action != $Ajx_module."Ajax" && $action != "HeadLines" && $action != 'massdelete'  &&  $action != "ActivityAjax")
{
	if(!$skipFooters && $action != "ChangePassword" && $action != "body" && $action != $module."Ajax" && $action!='Popup' && $action != 'ImportStep3' && $action != 'ActivityAjax')	
	{
		//echo $copyrightstatement;
		include_once($root_directory.'ecversion.php');
		echo "<script language = 'JavaScript' type='text/javascript' src = 'include/js/popup.js'></script>";
		echo "<br><br><br><table border=0 cellspacing=0 cellpadding=5 width=100% class=settingsSelectedUI >";
		echo "<tr><td class=small align=left><a href='".$app_strings["LBL_BROWSER_URL"]."' target='_blank'>E-CRM".$ec_current_version."</a> </td>";
		echo "<td class=small align=right> &copy; <a href='javascript:mypopup()'>Copyright Details</a></td></tr></table>";
			
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
	}
	// ActivityReminder Customization for callback
	
	if(!$skipFooters && (!isset($is_disable_pm) || !$is_disable_pm)) {
		//if($current_user->id !=NULL && isPermitted('Calendar','index') == 'yes')
			echo "<script type='text/javascript'>if(typeof(ActivityReminderCallback) != 'undefined') ActivityReminderCallback();</script>";
	}
	if((!$skipFooters) && ($action != "body") && ($action != $module."Ajax") && ($action != "ActivityAjax"))
		include($root_directory.'themes/'.$theme.'/footer.php');
}
?>
