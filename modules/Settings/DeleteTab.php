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
	$query="delete from ec_parenttabrel where parenttabid='".$id."'";
	$adb->query($query);
	$query="delete from ec_parenttab where parenttabid='".$id."'";
	$adb->query($query);
}
$url = "index.php?module=Settings&action=CustomTabList&parenttab=Settings";
redirect($url);
?>
