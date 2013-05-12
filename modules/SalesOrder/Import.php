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

 * $Header$

 * Description:  TODO: To be written.

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/



//include('modules/SalesImport/index.php');



require_once('include/CRMSmarty.php');
require_once('include/utils/CommonUtils.php');

global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;

global $import_mod_strings;

$focus = 0;

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$log->info($mod_strings['LBL_MODULE_NAME'] . " Upload Step 1");

$smarty = new CRMSmarty();

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMP", $import_mod_strings);

$smarty->assign("CATEGORY", $_REQUEST['parenttab']);





$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
//$smarty->assign("PRINT_URL", "phprint.php?jt=".session_id().$GLOBALS['request_string']);

$smarty->assign("HEADER", $app_strings['LBL_IMPORT']." ". $mod_strings['LBL_MODULE_NAME']);
$smarty->assign("HAS_HEADER_CHECKED"," CHECKED");

$smarty->assign("MODULE", $_REQUEST['module']);
$smarty->assign("SOURCE", $_REQUEST['source']);

//we have set this as default. upto 4.2.3 we have Outlook, Act, SF formats. but now CUSTOM is enough to import
$lang_key = "CUSTOM";
$smarty->assign("INSTRUCTIONS_TITLE",$mod_strings["LBL_IMPORT_{$lang_key}_TITLE"]);

for($i = 1; isset($mod_strings["LBL_{$lang_key}_NUM_$i"]);$i++)
{
	$smarty->assign("STEP_NUM",$mod_strings["LBL_NUM_$i"]);
	$smarty->assign("INSTRUCTION_STEP",$mod_strings["LBL_{$lang_key}_NUM_$i"]);
}

$smarty->display("SalesOrder/ImportStep1.tpl");


?>

