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
if($_REQUEST['fld_module'] !='') {
	$fld_module = $_REQUEST['fld_module'];
	if($fld_module == "Calendar") {
		$fld_module = "Events";
	}
}
else
	$fld_module = 'Accounts';
$smarty->assign("MODULE",$fld_module);
$smarty->assign("BLOCKSENTRY",getLayoutListEntries($fld_module));

if(isset($_REQUEST["duplicate"]) && $_REQUEST["duplicate"] == "yes")
{
	$error='Custom Field in the Name '.$_REQUEST["fldlabel"].' already exists. Please specify a different Label';
	$smarty->assign("DUPLICATE_ERROR", $error);
}

if($_REQUEST['mode'] !='')
	$mode = $_REQUEST['mode'];
$smarty->assign("MODE", $mode);
$smarty->assign("SETTYPE","LayoutList");

if($_REQUEST['ajax'] != 'true')
	$smarty->display('Settings/LayoutList.tpl');	
else
	$smarty->display('Settings/LayoutEntries.tpl');

	/**
	* Function to get customfield entries
	* @param string $module - Module name
	* return array  $cflist - customfield entries
	*/
function getLayoutListEntries($module)
{
	$tabid = getTabid($module);
	global $adb;
	global $theme;
	global $current_language;
	global $app_strings;
	if($module == "Events") {
		$module = "Calendar";
	}
	$cur_module_strings = return_specified_module_language($current_language,$module);
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	$query = "select * from ec_blocks where tabid='".$tabid."' order by sequence";
	$block_result = $adb->getList($query);
	$blcoklist = Array();
	foreach($block_result as $block_row)
	{
		$blockid = $block_row['blockid'];
		$blocklabel = $block_row['blocklabel'];
		if(isset($cur_module_strings[$blocklabel])) {
			$blocklabel = $cur_module_strings[$blocklabel];
		}
		
		$dbQuery = "select ec_field.fieldid,ec_field.fieldlabel,ec_field.block,ec_field.sequence,ec_field.typeofdata from ec_field inner join ec_def_org_field on ec_def_org_field.fieldid=ec_field.fieldid where ec_def_org_field.visible=0 and ec_field.tabid=$tabid and displaytype in(1,2,4) and ec_field.block='".$blockid."' order by ec_field.block,ec_field.sequence";
		$result = $adb->getList($dbQuery);
		$count=1;
		$cflist = Array();
			foreach($result as $row)
			{
				$cf_element = Array();
				$cf_element['no'] = $count;
				if(isset($cur_module_strings[$row["fieldlabel"]])) {
					$cf_element['fieldlabel'] = $cur_module_strings[$row["fieldlabel"]];
				} elseif(isset($app_strings[$row["fieldlabel"]])) {
					$cf_element['fieldlabel'] = $app_strings[$row["fieldlabel"]];
				} else {
					$cf_element['fieldlabel'] = $row["fieldlabel"];
				}				
				$cf_element['sequence'] = $row["sequence"];
				$typeofdata = $row["typeofdata"];
				if(strpos($typeofdata,"~M") > -1) {
					$typeofdata = "true";
				} else {
					$typeofdata = "false";
				}
				$cf_element['typeofdata'] = $typeofdata;
				//getCreateCustomBlockForm(customModule,blockid,tabid,label,order)
				$cf_element['tool']='<img src="'.$image_path.'editfield.gif" border="0" style="cursor:pointer;" onClick="getFieldLayoutForm(\''.$module.'\',\''.$row["fieldid"].'\',\''.$tabid.'\',\''.$cf_element['fieldlabel'].'\',\''.$blocklabel.'\',\''.$row["sequence"].'\',\''.$row['block'].'\',\''.$typeofdata.'\')" alt="'.$app_strings['LNK_EDIT'].'" title="'.$app_strings['LNK_EDIT'].'"/>';

				$cflist[] = $cf_element;
				$count++;
			}
		$blcoklist[$blocklabel] = $cflist;
    }
	return $blcoklist;
}


/* function to get the modules supports Custom Fields
*/

function getCustomFieldSupportedModules()
{
	global $adb;
	$sql="select distinct ec_field.tabid,name from ec_field inner join ec_tab on ec_field.tabid=ec_tab.tabid where ec_field.tabid not in(7,9,10,29)";
	$result = $adb->getList($sql);
	foreach($result as $row)
	{
		$modulelist[$row['name']] = $row['name'];
	}
	return $modulelist;
}
?>
