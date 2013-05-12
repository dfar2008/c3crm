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

$fld_module = $_REQUEST["fld_module"];

$id = $_REQUEST["fld_id"];

$colName = $_REQUEST["colName"];
$uitype = $_REQUEST["uitype"];

$adb->startTransaction();
//Deleting the CustomField from the Custom Field Table
$query='delete from ec_field where fieldid="'.$id.'"';
$adb->query($query);

//Deleting from ec_def_org_field table
$query='delete from ec_def_org_field where fieldid="'.$id.'"';
$adb->query($query);
$entityArr = getEntityTable($fld_module);
$delete_table = $entityArr["tablename"];

$dbquery = 'alter table '.$delete_table.' drop column '.$colName;
$adb->query($dbquery);


//we have to remove the entries in customview and report related tables which have this field ($colName)
$adb->query("delete from ec_cvcolumnlist where columnname like '%".$colName."%'");
$adb->query("delete from ec_cvstdfilter where columnname like '%".$colName."%'");
$adb->query("delete from ec_cvadvfilter where columnname like '%".$colName."%'");
$adb->query("delete from ec_selectcolumn where columnname like '%".$colName."%'");
$adb->query("delete from ec_relcriteria where columnname like '%".$colName."%'");
$adb->query("delete from ec_reportsortcol where columnname like '%".$colName."%'");
$adb->query("delete from ec_reportdatefilter where datecolumnname like '%".$colName."%'");
$adb->query("delete from ec_reportsummary where columnname like '%".$colName."%'");


//HANDLE HERE - we have to remove the table for other picklist type values which are text area and multiselect combo box 
if($uitype == 15 || $uitype == 33)
{
	$deltablequery = "delete from ec_picklist where colname='".$colName."'";
	$adb->query($deltablequery);
}
$adb->completeTransaction();
header("Location:index.php?module=Settings&action=CustomFieldList&fld_module=".$fld_module."&parenttab=Settings");
?>
