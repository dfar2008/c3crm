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
	
global $adb;
global $log;
$log->debug("Going to update the ListPrice in (modules/Products/UpdateListPrice.php).");
$record = $_REQUEST['record'];
$pricebook_id = $_REQUEST['pricebook_id'];
$product_id = $_REQUEST['product_id'];
$listprice = $_REQUEST['list_price'];
$return_action = $_REQUEST['return_action'];
$return_module = $_REQUEST['return_module'];

$query = "update ec_pricebookproductrel set listprice=".$listprice." where pricebookid=".$pricebook_id." and productid=".$product_id;
$adb->query($query); 
header("Location: index.php?module=$return_module&action=".$return_module."Ajax&file=$return_action&ajax=updatelistprice&record=$record");
?>
