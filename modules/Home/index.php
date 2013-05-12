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
 * $Header: /advent/projects/wesat/ec_crm/sugarcrm/modules/Home/index.php,v 1.28 2005/04/20 06:57:47 samk Exp $
 * Description:  Main file for the Home module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
redirect("main.php");
/*require_once('include/home.php');
require_once('include/CRMSmarty.php');
require_once('include/database/PearDatabase.php');
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
global $app_strings;
global $app_list_strings;
global $mod_strings;
global $current_user;

$smarty = new CRMSmarty();
$homeObj = new Homestuff();
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);
global $adb;
global $current_user;
$homedetails = $homeObj->getHomePageFrame();
$maxdiv = sizeof($homedetails)-1;
$smarty->assign("MAXLEN",$maxdiv);;
$smarty->assign("HOMEFRAME",$homedetails);
$user_name = $current_user->column_fields['user_name'];
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("MODULE",'Home');
$smarty->assign("CATEGORY",getParenttab('Home'));
$smarty->assign("CURRENTUSER",$user_name);
//$freetag = new freetag();
//$smarty->assign("ALL_TAG",$freetag->get_tag_cloud_html("",$current_user->id));
$smarty->display("Home/Homestuff.tpl");
*/
/*
CREATE TABLE IF NOT EXISTS `ec_homedefault` (
  `stuffid` int(19) NOT NULL default '0',
  `stuffsequence` int(19) NOT NULL default '0',
  `stufftype` varchar(100) default NULL,
  PRIMARY KEY  (`stuffid`),
  KEY `stuff_stuffid_idx` (`stuffid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `ec_homedefault` (`stuffid`, `stuffsequence`, `stufftype`) VALUES
(1, 1, 'key_customview'),
(2, 2, 'top_salesbymonth'),
(3, 3, 'top_account'),
(4, 4, 'top_calendar'),
(5, 5, 'top_performance')
(6, 6, 'note_pad');
*/

?>
