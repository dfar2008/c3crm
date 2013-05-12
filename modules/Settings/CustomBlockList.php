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

$cfimagecombo = Array($image_path."text.gif",
$image_path."number.gif",
$image_path."percent.gif",
$image_path."currency.gif",
$image_path."date.gif",
$image_path."email.gif",
$image_path."phone.gif",
$image_path."picklist.gif",
$image_path."url.gif",
$image_path."checkbox.gif",
$image_path."text.gif",
$image_path."picklist.gif");

$cftextcombo = Array($mod_strings['Text'],
$mod_strings['Number'],
$mod_strings['Percent'],
$mod_strings['Currency'],
$mod_strings['Date'],
$mod_strings['Email'],
$mod_strings['Phone'],
$mod_strings['PickList'],
$mod_strings['LBL_URL'],
$mod_strings['LBL_CHECK_BOX'],
$mod_strings['LBL_TEXT_AREA'],
$mod_strings['LBL_MULTISELECT_COMBO']
);


$smarty->assign("MODULES",$module_array);
$smarty->assign("CFTEXTCOMBO",$cftextcombo);
$smarty->assign("CFIMAGECOMBO",$cfimagecombo);
if($_REQUEST['fld_module'] !='')
	$fld_module = $_REQUEST['fld_module'];
else
	$fld_module = 'Accounts';
$smarty->assign("MODULE",$fld_module);
$smarty->assign("CFENTRIES",getBlockListEntries($fld_module));
if(isset($_REQUEST["duplicate"]) && $_REQUEST["duplicate"] == "yes")
{
	$error= $mod_strings['custom_field_exists'];
	$smarty->assign("DUPLICATE_ERROR", $error);
}

if($_REQUEST['mode'] !='')
	$mode = $_REQUEST['mode'];
$smarty->assign("MODE", $mode);

if($_REQUEST['ajax'] != 'true')
	$smarty->display('Settings/CustomBlockList.tpl');	
else
	$smarty->display('Settings/CustomBlockEntries.tpl');

	/**
	* Function to get customfield entries
	* @param string $module - Module name
	* return array  $cflist - customfield entries
	*/
function getBlockListEntries($module)
{
	$tabid = getTabid($module);
	global $adb;
	global $theme;
	global $current_language;
	if($module == "Events") {
		$module = "Calendar";
	}
	$cur_module_strings = return_specified_module_language($current_language,$module);
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	$dbQuery = "select blockid,blocklabel,sequence from ec_blocks where tabid=$tabid and visible = 0 order by sequence";
	$result = $adb->getList($dbQuery);
	$count=1;
	$cflist = Array();
	foreach($result as $row)
	{
			$cf_element = Array();
			$cf_element['no'] = $count;
			if(isset($cur_module_strings[$row["blocklabel"]])) {
				$cf_element['label'] = $cur_module_strings[$row["blocklabel"]];
			} else {
				$cf_element['label'] = $row["blocklabel"];
			}
			
			$cf_element['sequence'] = $row["sequence"];
			//getCreateCustomBlockForm(customModule,blockid,tabid,label,order)
			$cf_element['tool']='<img src="'.$image_path.'editfield.gif" border="0" style="cursor:pointer;" onClick="fnvshobj(this,\'createblock\');getCreateCustomBlockForm(\''.$module.'\',\''.$row["blockid"].'\',\''.$tabid.'\',\''.$cf_element['label'].'\',\''.$row["sequence"].'\')" alt="Edit" title="Edit"/>&nbsp;|&nbsp;<img style="cursor:pointer;" onClick="deleteCustomBlock('.$row["blockid"].',\''.$module.'\', \''.$row["columnname"].'\', \''.$row["uitype"].'\')" src="'.$image_path.'delete.gif" border="0"  alt="Delete" title="Delete"/></a>';

			$cflist[] = $cf_element;
			$count++;
	}
	return $cflist;
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
