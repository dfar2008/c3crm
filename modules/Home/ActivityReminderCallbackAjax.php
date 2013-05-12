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

global $app_strings,$mod_strings;
global $currentModule,$image_path,$theme,$adb, $current_user;
require_once('config.php');
require_once('include/CRMSmarty.php');
require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');
require_once('include/logging.php');
$log = LoggerManager::getLogger('Reminder');
$log->debug("****Starting for reminder1");
//start create new PM by reminder filter defined
$reminderFilterFilesDir = "Reminders";
$exceptions=array('.','..');
if(is_dir($reminderFilterFilesDir) && is_readable($reminderFilterFilesDir)) {
	$handle=opendir($reminderFilterFilesDir);
	while (false !== ($item = readdir($handle))) {
		if (!in_array($item,$exceptions)) {
			$reminderFile = $reminderFilterFilesDir."/".$item;
			if (is_file($reminderFile) && strpos($item,".php")>-1) {
				include($reminderFile);
			}
		}
	}
}
//end create new PM by reminder filter defined
$smarty = new CRMSmarty;

//set online status and ping time
$query = "UPDATE ec_users SET is_online='1', last_ping='".time()."' WHERE user_name='".$current_user->user_name."'";
$adb->query($query);
// cleanup logged-in users in database? [30% chance] //
if(rand(1, 100) <= 30) {
   // yes, cleanup! //
   $expire_time = time() - 60; // idle for more than 60 seconds? //
   if($adb->isMssql()){
       $query = "UPDATE ec_users SET is_online=0 WHERE cast(cast(last_ping as varchar(200)) as int) < '$expire_time' AND is_online >0";
   }else{
       $query = "UPDATE ec_users SET is_online=0 WHERE last_ping < '$expire_time' AND is_online >0";
   }
   $adb->query($query);
}

// Get the list of activity for which reminder needs to be sent
//step1: get uncomplieted calendar and smownerid today
//step2: compare timestart and reminder time 
//step3: send reminder to smownerid or groupname or inviter

$dateTimeNow = date('Y-m-d H:i:s');

//New Reminder
$query = "select * from ec_reminders where userid ='$current_user->id' and isused=0 and remindertime >= '".$dateTimeNow."'";
$result = $adb->getList($query);
    foreach($result as $result_set)
	{
		$reminderid = $result_set['reminderid'];				
		$remindertime = $result_set['remindertime'];
		$comments = $result_set['comments'];
		$crmid = $result_set['crmid'];
		$userid = $result_set['userid'];
		$subject = $app_strings["LBL_REMINDER"].":<a href=\"index.php?module=CustomReminder&action=PopupReminders\" target=\"_blank\">".$comments."</a>,".$remindertime;
		if($crmid != "0" && $crmid != "" && $crmid != NULL) {
			$accountname = getAccountName($crmid);
			$subject = $subject.",".$app_strings["Accounts"].":<a href=\"index.php?module=Accounts&action=DetaiView&record=".$crmid."\" target=\"_blank\">".$accountname."</a>";
			
		}
	    $curr_time = strtotime(date("Y-m-d H:i"))/60;
		$current_date = date('Y-m-d');

		$activity_time = strtotime(date("$remindertime"))/60;
		$needed_remindertime = $activity_time - $curr_time;
		$reminder_time = 60;
		
		//$log->debug("****new remindertime:".$remindertime);
		//$log->debug("****new reminder_time:".$reminder_time);
		//$log->debug("****new activity_time:".$activity_time);
		//$log->debug("****new curr_time:".$curr_time);
		//$log->debug("****new needed_remindertime:".$needed_remindertime);
		

		if ($needed_remindertime > 0  &&  $needed_remindertime <= $reminder_time)
		{
			$upd_query = "UPDATE ec_reminders SET isused=1 where reminderid=".$reminderid;
			$adb->query($upd_query);
			sendMessage($subject,$current_user->user_name);
			
		}
	}

//new msg reminder
//$today = strtotime(date('Y-m-d'));
$query = "SELECT count(*) as msgcount FROM ec_message where recipient='".$current_user->id."' and deleted_recipient=0 and received=0";
$result = $adb->query($query);
$msgcount = $adb->query_result($result,0,"msgcount");
if($msgcount >= 1)
{		
	$subject = $mod_strings["REMINDER_NEWMSG_1"].$msgcount.$mod_strings["REMINDER_NEWMSG_2"];
	$crmid = $current_user->id;

	$log->debug("****Starting for msg reminder start");
	$smarty->assign("theme", $theme);
	$smarty->assign("MOD", $mod_strings);
	$popupid = time()."_".$crmid;
	$smarty->assign("popupid", $popupid);
	$smarty->assign("recordid", $crmid);
	$smarty->assign("cbsubject", $subject);
	$smarty->assign("REMINDER_MODULE", "Home");
	$smarty->assign("REMINDER_ACTION", "PopupPM");
	$smarty->display("ActivityReminderCallback.tpl");
	$log->debug("****Exiting for msg reminder end");
}


echo "<script type='text/javascript'>if(typeof(ActivityReminderRegisterCallback) != 'undefined') ActivityReminderRegisterCallback(".$default_reminder_interval.");</script>";

/*
CREATE TABLE IF NOT EXISTS `ec_activity_reminder_popup` (
  `reminderid` int(19) NOT NULL auto_increment,
  `semodule` varchar(100) NOT NULL,
  `recordid` int(19) NOT NULL,
  `reminder_time` int(11) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY  (`reminderid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
 * 
CREATE TABLE IF NOT EXISTS `ec_message` (
  `recipient` int(19) default NULL,
  `sender` int(19) default NULL,
  `message` text,
  `type` text,
  `stamp` text,
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `received` int(1) default '0',
  `deleted_sender` int(10) default '0',
  `deleted_recipient` int(10) default '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8
*/

?>
