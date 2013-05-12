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

require_once("include/database/PearDatabase.php");
global $current_user;
global $adb;
$mod_strings =  return_specified_module_language("zh_cn","Settings"); 

$now = date("Y-m-d H:i:s");	

$userid=$_REQUEST['userid'];
if(empty($userid)){
	die("CurrentUser->ID is null,Please Check it!");
}
$sql = "select * from ec_users where id=$userid";
$row = $adb->getFirstLine($sql);
if(empty($row)){
	die("System Users No this Record!");
}

$deletesql = "DELETE FROM ec_users where id=$userid and id!=".$_SESSION['authenticated_user_id'];
$adb->query($deletesql); 

header("Location: index.php?module=Settings&parenttab=Settings&action=SmsUser");
?>
