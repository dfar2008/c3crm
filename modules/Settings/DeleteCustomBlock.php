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
global $mod_strings;
global $adb;

$fld_module = $_REQUEST["fld_module"];
$blockid = $_REQUEST["blockid"];

$query = "select * from ec_field where block=".$blockid;
//echo $query;
$result = $adb->query($query);
$row_num = $adb->getRowCount($result);
if($row_num > 0) {
	echo "<script language='javascript'>alert('".$mod_strings["LBL_BLOCK_WITH_FIELD"]."');";
	echo "document.location.href='index.php?module=Settings&action=CustomBlockList&fld_module=".$fld_module."&parenttab=Settings"."';";
	echo "</script>";
} else {
	//Deleting the block from the Custom Field Table
	$query = "select blocklabel from ec_blocks where blockid='".$blockid."'";
	$result = $adb->query($query);		
	$blocklabel_src = $adb->query_result($result,0,'blocklabel');
	if($blocklabel_src != 'LBL_CUSTOM_INFORMATION') { 
		$query='delete from ec_blocks where blockid="'.$blockid.'"';
		$adb->query($query);
	}
	header("Location:index.php?module=Settings&action=CustomBlockList&fld_module=".$fld_module."&parenttab=Settings");
}
?>
