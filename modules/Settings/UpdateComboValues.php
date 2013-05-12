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
$fld_module=$_REQUEST["fld_module"];
$tableName=$_REQUEST["table_name"];
$fldPickList =  $_REQUEST['listarea'];
//changed by dingjianting on 2006-10-1 for picklist editor
$fldPickList = utf8RawUrlDecode($fldPickList); 
$uitype = $_REQUEST['uitype'];

global $adb;
$delquery = "delete from ec_picklist where colname='".$tableName."'";
$adb->query($delquery);
if(substr_count($fldPickList,"br") > 0) {
	$fldPickList = str_replace("&lt;","<",$fldPickList);
	$fldPickList = str_replace("&gt;",">",$fldPickList);
	$pickArray = explode("<br />",$fldPickList);
} else {
	$pickArray = explode("\n",$fldPickList);
}
$count = count($pickArray);

for($i = 0; $i < $count; $i++)
{
	$pickArray[$i] = trim($pickArray[$i]);
	if($pickArray[$i] != '')
	{
		$id = $adb->getUniqueID('ec_picklist');
		$adb->query("insert into ec_picklist(id,colvalue,colname,sequence) values(".$id.",'".$pickArray[$i]."','".$tableName."',".$i.")");
	}
}
header("Location:index.php?action=SettingsAjax&module=Settings&directmode=ajax&file=PickList&fld_module=".$fld_module);
?>
