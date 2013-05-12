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
require_once('include/CustomFieldUtil.php');

global $mod_strings;
global $app_strings;
$smarty = new CRMSmarty();
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty->assign("IMAGE_PATH", $image_path);
$module_array = getCustomFieldSupportedModules(); 
$smarty->assign("MODULES",$module_array);
if($_REQUEST['fld_module'] !='')
	$fld_module = $_REQUEST['fld_module'];
else
	$fld_module = 'Accounts';
$smarty->assign("MODULE",$fld_module);
$smarty->assign("RELATEDENTRY",getRelatedListEntries($fld_module));

if($_REQUEST['mode'] !='')
	$mode = $_REQUEST['mode'];
$smarty->assign("MODE", $mode);

if($_REQUEST['ajax'] != 'true')
	$smarty->display('Settings/RelatedList.tpl');	
else
	$smarty->display('Settings/RelatedEntries.tpl');

	/**
	* Function to get customfield entries
	* @param string $module - Module name
	* return array  $cflist - customfield entries
	*/
function getRelatedListEntries($module)
{
	$tabid = getTabid($module);
	global $adb;
	global $theme;
	global $current_language;
	global $mod_strings;
	global $app_strings;
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	$query = "select * from ec_relatedlists where tabid='".$tabid."' order by sequence";
	$related_result = $adb->getList($query);
	$relatedlist = Array();
	$count = 1;
	foreach($related_result as $related_row) {
		$cflist = array();
		$cflist['no'] = $count;
		//$cflist['relation_id'] = $related_row['relation_id'];
		//$cflist['tabid'] = $tabid;
		$label = $related_row['label'];
		if(isset($app_strings[$label])) {
			$label = $app_strings[$label];
		}
		$cflist['label'] = $label;
		$cflist['sequence'] = $related_row['sequence'];		
		$presence = $related_row['presence'];
		if($presence == 0) {
			$presence = $mod_strings['LBL_YES'];
		} else {
			$presence = $mod_strings['LBL_NO'];
		}
		$cflist['presence'] = $presence;
		$cflist['tool']='<img src="'.$image_path.'editfield.gif" border="0" style="cursor:pointer;" onClick="fnvshobj(this,\'createrelatedlist\');getCreateRelatedListForm(\''.$module.'\',\''.$related_row["relation_id"].'\',\''.$label.'\',\''.$related_row["sequence"].'\',\''.$related_row["presence"].'\')"/>';
		$relatedlist[] = $cflist;
		unset($cflist);
		$count ++;
    }
	return $relatedlist;
}


/* function to get the modules supports Custom Fields
*/

function getCustomFieldSupportedModules()
{
	global $adb;
	$sql="select distinct ec_field.tabid,name from ec_field inner join ec_tab on ec_field.tabid=ec_tab.tabid where ec_field.tabid not in(7,9,10,16,15,29)";
	$result = $adb->getList($sql);
	foreach($result as $row)
	{
		$modulelist[$row['name']] = $row['name'];
	}
	return $modulelist;
}
?>
