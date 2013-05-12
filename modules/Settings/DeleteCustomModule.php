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

if(isset($_REQUEST['id'])) {
	$id=$_REQUEST['id'];
	$query = "select * from ec_modules where id='".$id."'";
	//echo $query;
	$row = $adb->getFirstLine($query);
	if($row) {
		$enname = $row['enname'];
		$cnname = $row['cnname'];
		$is_accountid = $row['is_accountid'];
		$is_accountid = $is_accountid == 1 ? "checked":"";
		$is_contactid = $row['is_contactid'];
		$is_contactid = $is_contactid == 1 ? "checked":"";
		$parenttabid = $row['parenttabid'];
		$order = $row['displayorder'];
		$status = $row['status'];
		$description = $row['description'];
		global $root_directory;
		$delete_file = "modules/".ucfirst($enname)."s/delete_".$enname."s.php";
		if(is_file($root_directory.$delete_file)){
			include($delete_file);
		}
		$query = "update ec_modules set status='".$mod_strings['DelModule']."' where id='".$id."'";
	    $adb->query($query);
		//global $root_directory;
		//rmdirr($root_directory."modules/".ucfirst($enname)."s");
	}
	$query='delete from ec_modules where id="'.$id.'"';
	$adb->query($query);
}
$url = "index.php?module=Settings&action=CustomModuleList&parenttab=Settings";
redirect($url);
?>
