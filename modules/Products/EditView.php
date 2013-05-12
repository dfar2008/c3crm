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
require_once('include/CRMSmarty.php');
require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');
require_once('modules/Products/Products.php');
require_once('include/FormValidationUtil.php');

global $app_strings;
global $mod_strings;
global $currentModule;

$focus = new Products();
$focus->mode = '';
$focus->id = "";
$smarty = new CRMSmarty();

if(isset($_REQUEST['record']) && $_REQUEST['record'] != "") 
{
    $focus->id = $_REQUEST['record'];
    $focus->mode = 'edit'; 	
    $focus->retrieve_entity_info($_REQUEST['record'],"Products");
	
    $focus->name=$focus->column_fields['productname'];
	$focus->column_fields['description'] = decode_html($focus->column_fields["description"]);
}

if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
    $focus->mode = ''; 
	$focus->column_fields['productcode'] = "";
}

//needed when creating a new product with a default ec_vendor name to passed 
if (isset($_REQUEST['name']) && is_null($focus->name)) {
	$focus->name = $_REQUEST['name'];
	
}

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$disp_view = getView($focus->mode);

$smarty->assign("BLOCKS",getBlocks($currentModule,$disp_view,$focus->mode,$focus->column_fields));
$smarty->assign("OP_MODE",$disp_view);

$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'Product');


$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
if (isset($focus->name)) $smarty->assign("NAME", $focus->name);
else $smarty->assign("NAME", "");

$smarty->assign("ID", $focus->id);
$category = getParentTab();
$smarty->assign("CATEGORY",$category);
if($focus->mode == 'edit')
{
	$smarty->assign("UPDATEINFO",updateInfo($focus->id));
	$smarty->assign("MODE", $focus->mode);
}

if(isset($_REQUEST['return_module'])) $smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);
if(isset($_REQUEST['return_action'])) $smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
if(isset($_REQUEST['return_id'])) $smarty->assign("RETURN_ID", $_REQUEST['return_id']);
if(isset($_REQUEST['activity_mode'])) $smarty->assign("ACTIVITYMODE", $_REQUEST['activity_mode']);
if(isset($_REQUEST['return_viewname'])) $smarty->assign("RETURN_VIEWNAME", $_REQUEST['return_viewname']);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);

$tabid = getTabid("Products");
$data = getSplitDBValidationData($focus->tab_name,$tabid);

$smarty->assign("VALIDATION_DATA_FIELDNAME",$data['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$data['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL",$data['fieldlabel']);
$smarty->display('Products/EditView.tpl');
?>
