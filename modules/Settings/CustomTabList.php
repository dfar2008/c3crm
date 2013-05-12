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
$custommtablist = getTabListEntries();
$smarty->assign("TABENTRIES",$custommtablist);

if($_REQUEST['mode'] !='')
	$mode = $_REQUEST['mode'];
$smarty->assign("MODE", $mode);
$smarty->display('Settings/CustomTabList.tpl');

	/**
	* Function to get customfield entries
	* @param string $module - Module name
	* return array  $cflist - customfield entries
	*/
function getTabListEntries()
{
	global $adb;
	global $theme;
	global $app_strings;
	global $mod_strings;
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";	
	$count = 1;
	$modulelist = Array();
	$query = "select * from ec_parenttab order by sequence";
	$result = $adb->getList($query);
		foreach($result as $row)
		{		
			$cf_element = Array();
			$cf_element['no'] = $count;

			//$cf_element['parenttabid'] = $row["parenttabid"];
			if(isset($app_strings[$row["parenttab_label"]])) {
				$cf_element['parenttab_label'] = $app_strings[$row["parenttab_label"]];
			} else {
				$cf_element['parenttab_label'] = $row["parenttab_label"];
			}
			$cf_element['sequence'] = $row["sequence"];
			if($row["parenttab_label"] != "Settings") {
				$cf_element['tool']='<a href="index.php?module=Settings&action=CreateTab&id='.$row["parenttabid"].'&parenttab=Settings" >'.$mod_strings['Edit'].'</a>&nbsp;|&nbsp;<a href="#" onClick="deleteTab('.$row["parenttabid"].')">'.$mod_strings['Delete'].'</a>';
			} else {
				$cf_element['tool']='<a href="index.php?module=Settings&action=CreateTab&id='.$row["parenttabid"].'&parenttab=Settings" >'.$mod_strings['Edit'].'</a>';
			}
			$modulelist[] = $cf_element;
			$count++;
		}
	return $modulelist;
}
?>
