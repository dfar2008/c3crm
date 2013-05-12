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
require_once('include/database/PearDatabase.php');
require_once('include/CRMSmarty.php');
global $mod_strings;
global $app_strings;
global $app_list_strings, $current_language;

$tableName=$_REQUEST["fieldname"];
$moduleName=$_REQUEST["fld_module"];
$uitype=$_REQUEST["uitype"];


global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$smarty = new CRMSmarty();

//Added to get the strings from language files if present
if($moduleName == 'Events')
	$temp_module_strings = return_module_language($current_language, 'Calendar');
else
	$temp_module_strings = return_module_language($current_language, $moduleName);

//To get the Editable Picklist Values 
//changed by dingjianting on 2007-2-20 for picklist ,some items used in codes can note be changed such as close win.
/*
if($uitype != 111)
{
	$query = "select * from ec_".$tableName ;
	$result = $adb->query($query);
	$fldVal='';

	while($row = $adb->fetch_array($result))
	{
		if($temp_module_strings[$row[$tableName]] != '')
			$fldVal .= $temp_module_strings[$row[$tableName]];
		else
			$fldVal .= $row[$tableName];
		$fldVal .= "\n";	
	}
}
else
{
	$query = "select * from ec_".$tableName." where presence=0"; 
	$result = $adb->query($query);
	$fldVal='';

	while($row = $adb->fetch_array($result))
	{
		if($temp_module_strings[$row[$tableName]] != '')
			$fldVal .= $temp_module_strings[$row[$tableName]];
		else
			$fldVal .= $row[$tableName];
		$fldVal .= "\n";	
	}
}
*/
$query = "select colvalue from ec_picklist where colname='".$tableName."' order by sequence";
$result = $adb->getList($query);
$fldVal='';
foreach($result as $row)
{
	if($temp_module_strings[$row['colvalue']] != '')
		$fldVal .= $temp_module_strings['colvalue'];
	else
		$fldVal .= $row['colvalue'];
	$fldVal .= "\n";	
}

//To get the Non Editable Picklist Entries
/*
if($uitype == 111) 
{
	$qry = "select * from ec_".$tableName." where presence=1"; 
	$res = $adb->query($qry);
	$nonedit_fldVal='';

	while($row = $adb->fetch_array($res))
	{
		if($temp_module_strings[$row[$tableName]] != '')
			$nonedit_fldVal .= $temp_module_strings[$row[$tableName]];
		else
			$nonedit_fldVal .= $row[$tableName];
		$nonedit_fldVal .= "<br>";	
	}
}

$query = "select colvalue from ec_picklist where colname='".$tableName."' order by sequence";
$qry = "select * from ec_".$tableName." where presence=1 order by sortorderid"; 
$res = $adb->query($qry);
$nonedit_fldVal='';

while($row = $adb->fetch_array($res))
{
	if($temp_module_strings[$row[$tableName]] != '')
		$nonedit_fldVal .= $temp_module_strings[$row[$tableName]];
	else
		$nonedit_fldVal .= $row[$tableName];
	$nonedit_fldVal .= "<br>";	
}*/
$query = "select fieldlabel from ec_tab inner join ec_field on ec_tab.tabid=ec_field.tabid where ec_tab.name='".$moduleName."' and fieldname='".$tableName."' ";
$result = $adb->query($query);
$fieldlabel = $adb->query_result($result,0,'fieldlabel'); 

if($nonedit_fldVal == '')
		$smarty->assign("EDITABLE_MODE","edit");
	else
		$smarty->assign("EDITABLE_MODE","nonedit");
$smarty->assign("NON_EDITABLE_ENTRIES", $nonedit_fldVal);
$smarty->assign("ENTRIES",$fldVal);
$smarty->assign("MODULE",$moduleName);
$smarty->assign("FIELDNAME",$tableName);
//First look into app_strings and then mod_strings and if not available then original label will be displayed
$temp_label = isset($app_strings[$fieldlabel])?$app_strings[$fieldlabel]:(isset($mod_strings[$fieldlabel])?$mod_strings[$fieldlabel]:$fieldlabel);
$smarty->assign("FIELDLABEL",$temp_label);
$smarty->assign("UITYPE", $uitype);
$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("TEMP_MOD", $temp_module_strings);

$smarty->display("Settings/EditPickList.tpl");
?>
