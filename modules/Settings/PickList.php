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
global $app_list_strings;
global $current_language, $currentModule;

if(isset($_REQUEST['fld_module']) && $_REQUEST['fld_module'] != '')
	$fld_module = $_REQUEST['fld_module'];
else	
	$fld_module = 'Accounts';

if(isset($_REQUEST['uitype']) && $_REQUEST['uitype'] != '')
	$uitype = $_REQUEST['uitype'];

$smarty = new CRMSmarty();
$smarty->assign("MODULE_LISTS",getPickListModules());

$picklists_entries = getUserFldArray($fld_module);
if((sizeof($picklists_entries) %3) != 0)
	$value = (sizeof($picklists_entries) + 3 - (sizeof($picklists_entries))%3); 
else
	$value = sizeof($picklists_entries);

if($fld_module == 'Events')

	$temp_module_strings = return_module_language($current_language, 'Calendar');
else
	$temp_module_strings = return_module_language($current_language, $fld_module);

$smarty->assign("TEMP_MOD", $temp_module_strings);
if(is_array($picklists_entries) && count($picklists_entries) > 0) {
	$picklist_fields = array_chunk(array_pad($picklists_entries,$value,''),3);
}
$smarty->assign("MODULE",$fld_module);
$smarty->assign("PICKLIST_VALUES",$picklist_fields);
$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("UITYPE", $uitype);
$smarty->assign("SETTYPE","PickList");

if($_REQUEST['directmode'] != 'ajax')
	$smarty->display("Settings/PickList.tpl");
else
	$smarty->display("Settings/PickListContents.tpl");
	
	/** Function to get picklist fields for the given module 
	 *  @ param $fld_module
	 *  It gets the picklist details array for the given module in the given format
	 *  			$fieldlist = Array(Array('fieldlabel'=>$fieldlabel,'generatedtype'=>$generatedtype,'columnname'=>$columnname,'fieldname'=>$fieldname,'value'=>picklistvalues))	
	 */

function getUserFldArray($fld_module)
{
	global $adb;
	$user_fld = Array();
	$tabid = getTabid($fldmodule);
	$query = "select fieldlabel,generatedtype,columnname,fieldname,uitype from ec_field inner join ec_def_org_field on ec_def_org_field.fieldid=ec_field.fieldid where  (ec_field.tabid = ".getTabid($fld_module)." AND ec_field.uitype IN (15,16, 111,33)) OR (ec_field.tabid = ".getTabid($fld_module)." AND ec_field.fieldname='salutationtype')";
	$result = $adb->query($query);
	$noofrows = $adb->num_rows($result);
    if($noofrows > 0)
    {
		$fieldlist = Array();
    	for($i=0; $i<$noofrows; $i++)
    	{
			$user_fld = Array();
			$fld_name = $adb->query_result($result,$i,"fieldname");
			if($fld_module == 'Events')	
			{
				if($adb->query_result($result,$i,"fieldname") != 'recurringtype' && $adb->query_result($result,$i,"fieldname") != 'activitytype' && $adb->query_result($result,$i,"fieldname") != 'visibility')	
				{	
					$user_fld['fieldlabel'] = $adb->query_result($result,$i,"fieldlabel");	
					$user_fld['generatedtype'] = $adb->query_result($result,$i,"generatedtype");	
					$user_fld['columnname'] = $adb->query_result($result,$i,"columnname");	
					$user_fld['fieldname'] = $adb->query_result($result,$i,"fieldname");	
					$user_fld['uitype'] = $adb->query_result($result,$i,"uitype");	
					$user_fld['value'] = getPickListValues($user_fld['fieldname']); 
					$fieldlist[] = $user_fld;
				}
			}
			else
			{
					$user_fld['fieldlabel'] = $adb->query_result($result,$i,"fieldlabel");	
					$user_fld['generatedtype'] = $adb->query_result($result,$i,"generatedtype");	
					$user_fld['columnname'] = $adb->query_result($result,$i,"columnname");	
					$user_fld['fieldname'] = $adb->query_result($result,$i,"fieldname");	
					$user_fld['uitype'] = $adb->query_result($result,$i,"uitype");	
					$user_fld['value'] = getPickListValues($user_fld['fieldname']); 
					$fieldlist[] = $user_fld;
			}
    	}
    }
    return $fieldlist;
}

	/** Function to get picklist values for the given field  
	 *  @ param $tablename
	 *  It gets the picklist values for the given fieldname
	 *  			$fldVal = Array(0=>value,1=>value1,-------------,n=>valuen)	
	 */

function getPickListValues($tablename)
{
	global $adb;	
	$query = "select colvalue from ec_picklist where colname='".$tablename."' order by sequence";
	$result = $adb->getList($query);
	$fldVal = Array();
	foreach($result as $row)
	{
		$fldVal []= $row['colvalue'];
	}
	return $fldVal;
}
	/** Function to get modules which has picklist values  
	 *  It gets the picklist modules and return in an array in the following format 
	 *  			$modules = Array($tabid=>$tablabel,$tabid1=>$tablabel1,$tabid2=>$tablabel2,-------------,$tabidn=>$tablabeln)	
	 */
function getPickListModules()
{
	global $adb;
	$query = 'select distinct ec_field.fieldname,ec_field.tabid,tablabel,uitype from ec_field inner join ec_tab on ec_tab.tabid=ec_field.tabid where uitype IN (15,16, 111,33) and ec_field.tabid not in(7,9,10,29)';
	$result = $adb->getList($query);
	foreach($result as $row)
	{
		$modules[$row['tabid']] = $row['tablabel']; 
	}
	return $modules;
}
?>
