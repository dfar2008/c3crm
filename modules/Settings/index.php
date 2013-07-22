<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
require_once('include/CRMSmarty.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty = new CRMSmarty();

$settingmode = "view";
if(isset($_REQUEST['settingmode']) && $_REQUEST['settingmode'] != ''){
	$settingmode = $_REQUEST['settingmode'];
}
$smarty->assign("SETTINGMODE", $settingmode);

$settype = "SmsUser";
if($_REQUEST['settype'] && !empty($_REQUEST['settype'])){
	$settype = $_REQUEST['settype'];
}
$settypearray = array(
			"SmsUser"=>$mod_strings['LBL_SMS_USER'],
			"CustomBlockList"=>$mod_strings['LBL_BLOCK_EDITOR'],
			"CustomFieldList"=>$mod_strings['LBL_CUSTOM_FIELDS'],
			"PickList"=>$mod_strings['LBL_PICKLIST_EDITOR'],
			"SmsTcManage"=>$mod_strings['LBL_SMS_TC_MANAGE'],
			"CustomTabList"=>$mod_strings['LBL_TAB_EDITOR'],
			"LayoutList"=>$mod_strings['LBL_LAYOUT_EDITOR'],
			"DefaultFieldPermissions"=>$mod_strings['LBL_FIELDS_ACCESS'],
			"RelatedList"=>$mod_strings['LBL_RELATED_LIST'],
			"Liuyan"=>$mod_strings['LBL_LIUYAN_LIST']
	);
$settypekeyarr = array_keys($settypearray);
if(!empty($settype) && in_array($settype,$settypekeyarr)){
	require_once("modules/Settings/{$settype}.php");
}

$smarty->assign("SETTYPEARRAY", $settypearray);
$smarty->assign("SETTYPE", $settype);
$relsethead = $app_strings['Settings'];
$smarty->assign("RELSETHEAD", $relsethead);


$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", 'Settings');
$smarty->assign("CATEGORY", 'Settings');
$smarty->assign("MOD", $mod_strings);
$smarty->assign("IMAGE_PATH", $image_path);
//$smarty->display("Settings.tpl");
?>
