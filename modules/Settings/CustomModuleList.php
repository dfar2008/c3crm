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
require_once('include/database/PearDatabase.php');

global $mod_strings;
global $app_strings;
global $adb;
$smarty = new CRMSmarty();
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty->assign("IMAGE_PATH", $image_path);
$custommodulelist = getModuleListEntries();
$smarty->assign("MODULEENTRIES",$custommodulelist);

if($_REQUEST['mode'] !='')
	$mode = $_REQUEST['mode'];
$smarty->assign("MODE", $mode);
$smarty->display('Settings/CustomModuleList.tpl');

	/**
	* Function to get customfield entries
	* @param string $module - Module name
	* return array  $cflist - customfield entries
	*/
function getModuleListEntries()
{
	global $adb;
	global $theme;
	global $app_strings;
	global $mod_strings;
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";	
	$count = 1;
	$modulelist = Array();
	$query = "select ec_modules.*,ec_parenttab.parenttabid,ec_parenttab.parenttab_label from ec_modules left join ec_parenttab on ec_parenttab.parenttabid=ec_modules.parenttabid order by ec_modules.id desc";
	$result = $adb->getList($query);
		foreach($result as $row)
		{		
			$cf_element = Array();
			$cf_element['no'] = $count;

			$cf_element['enname'] = $row["enname"];
			$cf_element['cnname'] = $row["cnname"];
			if(isset($app_strings[$row["parenttab_label"]])) {
				$cf_element['parenttabid'] = $app_strings[$row["parenttab_label"]];
			} else {
				$cf_element['parenttabid'] = $row["parenttab_label"];
			}
			$is_accountid = $row['is_accountid'];
			if($is_accountid == 1) {
				$cf_element['is_accountid'] = $mod_strings['LBL_YES'];
			} else {
				$cf_element['is_accountid'] = $mod_strings['LBL_NO'];
			}
			$is_contactid = $row['is_contactid'];
			if($is_contactid == 1) {
				$cf_element['is_contactid'] = $mod_strings['LBL_YES'];
			} else {
				$cf_element['is_contactid'] = $mod_strings['LBL_NO'];
			}
			$cf_element['displayorder'] = $row["displayorder"];
			$status = $row["status"];
			$cf_element['status'] = $status;
			
			$tool = '';
			//edit module <a href="#" onClick="fnvshobj(this,\'createmodule\');getCreateCustomModuleForm('.$row["id"].')" >'.$mod_strings['Edit'].'</a>&nbsp;|&nbsp;
			$tool ='<a href="#" onClick="deleteCustomModule('.$row["id"].')">'.$mod_strings['Delete'].'</a>&nbsp;|&nbsp;';
			if($status == $mod_strings['AddModule']) {
				$tool .= '<a href="#" onClick="installCustomModule('.$row["id"].')">'.$mod_strings['Install'].'</a>&nbsp;|&nbsp;'.$mod_strings['Uninstall'].'&nbsp;|&nbsp;'.$mod_strings['Export'];
			} elseif($status == $mod_strings['Install']) {
				$tool .= ''.$mod_strings['Install'].'&nbsp;|&nbsp;<a href="#" onClick="uninstallCustomModule('.$row["id"].')">'.$mod_strings['Uninstall'].'</a>&nbsp;|&nbsp;<a href="#" onClick="exportCustomModule('.$row["id"].')">'.$mod_strings['Export'].'</a>';
			} elseif($status == $mod_strings['Uninstall']) {
				$tool .= '<a href="#" onClick="installCustomModule('.$row["id"].')">'.$mod_strings['Install'].'</a>&nbsp;|&nbsp;'.$mod_strings['Uninstall'].'&nbsp;|&nbsp;'.$mod_strings['Export'];
			} elseif($status == $mod_strings['Export']) {
				$tool .= ''.$mod_strings['Install'].'&nbsp;|&nbsp;<a href="#" onClick="uninstallCustomModule('.$row["id"].')">'.$mod_strings['Uninstall'].'</a>&nbsp;|&nbsp;<a href="#" onClick="exportCustomModule('.$row["id"].')">'.$mod_strings['Export'].'</a>';
			}
			$cf_element['tool'] = $tool;
			$modulelist[] = $cf_element;
			$count++;
		}
	return $modulelist;
}
?>
