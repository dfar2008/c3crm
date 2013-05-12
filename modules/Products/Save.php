<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /cvsroot/vtigercrm/ec_crm/modules/Products/Save.php,v 1.12 2006/02/07 07:27:23 jerrydgeorge Exp $
 * Description:  Saves an Account record and then redirects the browser to the 
 * defined return URL.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Products/Products.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
global $log,$current_user;
global $adb;
global $mod_strings;

if(isset($_REQUEST['dup_check']) && $_REQUEST['dup_check'] != '')
{
	    $productcode = $_REQUEST['productcode'];
		$record = $_REQUEST['record'];
		if(empty($record)) {
			$query = "SELECT productcode FROM ec_products WHERE deleted=0 and smownerid=".$current_user->id." and productcode ='".$productcode."'";
		} else {
			$query = "SELECT productcode FROM ec_products WHERE deleted=0 and smownerid=".$current_user->id." and productid !=".$record." and productcode ='".$productcode."'";
		}
        $result = $adb->query($query);
		//changed by dingjianting on 2006-10-26 for checking username exist in dicuz database
        if($adb->num_rows($result) > 0)
        {
			echo $mod_strings['The record exists.'];
			die;
		}
		else
		{
			echo 'SUCCESS';
			die;
		}
}

$focus = new Products();
if(isset($_REQUEST['record']))
{
	$focus->id = $_REQUEST['record'];
	$record_id=$focus->id;
	$log->info("Record Id is present during Saving the product :->".$record_id);
}
if(isset($_REQUEST['mode']))
{
	$focus->mode = $_REQUEST['mode'];
  	$mode=$focus->mode;
	  $log->info("Type of 'mode' during Product Save is ".$mode);
}
foreach($focus->column_fields as $fieldname => $val)
{
	if(isset($_REQUEST[$fieldname]))
	{
		$value = $_REQUEST[$fieldname];
		$focus->column_fields[$fieldname] = $value;
	}
	if($fieldname == "description") {
		$focus->column_fields['description'] = to_html($focus->column_fields["description"]);
	}
}


if($focus->column_fields['productcode'] == $app_strings["AUTO_GEN_CODE"]) {
	require_once('user_privileges/seqprefix_config.php');
	$focus->column_fields['productcode'] = $product_seqprefix.$focus->get_next_id();
}
$focus->save("Products");
$return_id = $focus->id;
if($_REQUEST['return_viewname'] == '') $return_viewname='0';
else $return_viewname = $_REQUEST['return_viewname'];
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") $return_module = $_REQUEST['return_module'];
else $return_module = "Products";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") $return_action = $_REQUEST['return_action'];
else $return_action = "DetailView";
if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") $return_id = $_REQUEST['return_id'];

if(isset($_REQUEST['parenttab']) && $_REQUEST['parenttab'] != "") $parenttab = $_REQUEST['parenttab'];
header("Location: index.php?action=$return_action&module=$return_module&parenttab=$parenttab&record=$return_id&viewname=$return_viewname");



?>
