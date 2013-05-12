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
global $adb;
$id=$_REQUEST['record'];
$dbQuery = "SELECT * FROM ec_attachments WHERE attachmentsid='" .$id."'";
$result = $adb->query($dbQuery);
if($adb->num_rows($result) == 1)
{
	$name = @$adb->query_result($result, 0, "name");
	$filepath = @$adb->query_result($result, 0, "path");
    $encode_filename = base64_encode_filename($name);
	$saved_filename = $id."_".$encode_filename;
	if(is_file($filepath.$saved_filename)) {
		unlink($filepath.$saved_filename);
	}
}
$adb->startTransaction();
$sql = "delete from ec_seattachmentsrel where attachmentsid ='".$id."'";
$adb->query($sql);

$sql = "delete from ec_attachments where attachmentsid ='".$id."'";
$adb->query($sql);

$sql = "delete from ec_crmentity where crmid ='".$id."'";
$adb->query($sql);
$adb->completeTransaction();

header("Location:index.php?module=".$_REQUEST['return_module']."&action=".$_REQUEST['return_action']."&record=".$_REQUEST['return_id']);


?>
