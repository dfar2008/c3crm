<?php
require_once('include/CRMSmarty.php');
require_once('data/Tracker.php');
require_once('modules/SalesOrder/SalesOrder.php');
require_once('include/utils/utils.php');
require_once('include/FormValidationUtil.php');

global $app_strings,$mod_strings,$log,$theme,$currentModule,$current_user;
global $adb;
$category = getParentTab();
if(isset($_REQUEST['return_module'])) $return_module = $_REQUEST['return_module'];
else $return_module = "SalesOrder";
if(isset($_REQUEST['return_action'])) $return_action = $_REQUEST['return_action'];
else $return_action = "index";
if(isset($_REQUEST['return_id']))
{
	$return_id = $_REQUEST['return_id'];
}else
{
	if(isset($_REQUEST['record'])) $return_id = $_REQUEST['record'];
}
if (isset($_REQUEST['return_viewname'])) $return_viewname = $_REQUEST['return_viewname'];

$log->debug("Inside Sales Order EditView");
$category = getParentTab();
$focus = new SalesOrder();
$smarty = new CRMSmarty();
if(isset($_REQUEST['record']) && $_REQUEST['record'] != '') 
{
	$focus->id = $_REQUEST['record'];
	$focus->mode = 'edit'; 	
	$focus->retrieve_entity_info($_REQUEST['record'],"SalesOrder");		
	$focus->name=$focus->column_fields['subject'];
}

if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$SO_associated_prod = $focus->getAssociatedProducts();
	$focus->id = "";
    $focus->mode = ''; 
	$focus->column_fields['subject'] = "";
}
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] == 'Accounts')
{
	$account_id = $_REQUEST['return_id'];
	$focus->column_fields['account_id'] = $account_id;
}



/*
// Get Account address if ec_account is given
if(isset($_REQUEST['account_id']) && $_REQUEST['record']=='' && $_REQUEST['account_id'] != ''){
	//$focus->column_fields['account_id'] = $_REQUEST['account_id'];
	
	require_once('modules/Accounts/Accounts.php');
	$acct_focus = new Accounts();
	$acct_focus->retrieve_entity_info($_REQUEST['account_id'],"Accounts");
	$focus->column_fields['bill_city']=$acct_focus->column_fields['bill_city'];
	$focus->column_fields['ship_city']=$acct_focus->column_fields['ship_city'];
	$focus->column_fields['bill_street']=$acct_focus->column_fields['bill_street'];
	$focus->column_fields['ship_street']=$acct_focus->column_fields['ship_street'];
	$focus->column_fields['bill_state']=$acct_focus->column_fields['bill_state'];
	$focus->column_fields['ship_state']=$acct_focus->column_fields['ship_state'];
	$focus->column_fields['bill_code']=$acct_focus->column_fields['bill_code'];
	$focus->column_fields['ship_code']=$acct_focus->column_fields['ship_code'];
	$focus->column_fields['bill_country']=$acct_focus->column_fields['bill_country'];
	$focus->column_fields['ship_country']=$acct_focus->column_fields['ship_country'];
}
*/
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$disp_view = getView($focus->mode);
$mode = $focus->mode;
if($disp_view == 'edit_view')
	$smarty->assign("BLOCKS",getBlocks($currentModule,$disp_view,$mode,$focus->column_fields,'',$_REQUEST['record']));
else	
{
	$bas_block = getBlocks($currentModule,$disp_view,$mode,$focus->column_fields,'BAS');
	//$adv_block = getBlocks($currentModule,$disp_view,$mode,$focus->column_fields,'ADV');
	
	$blocks['basicTab'] = $bas_block;
	//if(is_array($adv_block ))
	//	$blocks['moreTab'] = $adv_block;

	$smarty->assign("BLOCKS",$blocks);
	$smarty->assign("BLOCKS_COUNT",count($blocks));
}
$smarty->assign("OP_MODE",$disp_view);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'SalesOrder');
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("CATEGORY",$category);
if (isset($focus->name)) $smarty->assign("NAME", $focus->name);
else $smarty->assign("NAME", "");
if($focus->mode == 'edit')
{
	$smarty->assign("UPDATEINFO",updateInfo($focus->id));
	$associated_prod = $focus->getAssociatedProducts();
	$smarty->assign("ASSOCIATEDPRODUCTS", $associated_prod);
	$smarty->assign("MODE", $focus->mode);
}
elseif(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true')
{
	$smarty->assign("ASSOCIATEDPRODUCTS", $SO_associated_prod);
	$smarty->assign("AVAILABLE_PRODUCTS", 'true');
	$smarty->assign("MODE", $focus->mode);
}

if(isset($_REQUEST['return_module'])) $smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);
else $smarty->assign("RETURN_MODULE","SalesOrder");
if(isset($_REQUEST['return_action'])) $smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
else $smarty->assign("RETURN_ACTION","index");

$smarty->assign("RETURN_ID", $return_id);
 
if (isset($_REQUEST['return_viewname'])) $smarty->assign("RETURN_VIEWNAME", $_REQUEST['return_viewname']);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("MODULE","SalesOrder");
$smarty->assign("ID", $focus->id);

$fieldlabellist = getProductFieldLabelList("SalesOrder");
$smarty->assign("PRODUCTLABELLIST",$fieldlabellist);
$fieldnamelist = getProductFieldList("SalesOrder");
$smarty->assign("PRODUCTNAMELIST",$fieldnamelist);

$tabid = getTabid("SalesOrder");
$data = getSplitDBValidationData($focus->tab_name,$tabid);

$smarty->assign("VALIDATION_DATA_FIELDNAME",$data['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$data['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL",$data['fieldlabel']);
if($focus->mode == 'edit')
	$smarty->display("SalesOrder/InventoryEditView.tpl");
else
	$smarty->display('SalesOrder/InventoryCreateView.tpl');

?>
