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
global $adb;;	

$record = $_REQUEST['record'];

if(!empty($record)){
	$query = "delete from ec_smstc where id=$record";
	$adb->query($query);
}else{
	die("Record is null");	
}


header("Location: index.php?module=Settings&parenttab=Settings&action=SmsTcManage");
?>
