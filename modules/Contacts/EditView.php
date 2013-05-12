<?php
require_once('include/CRMSmarty.php');
require_once('data/Tracker.php');
require_once('modules/Contacts/Contacts.php');
require_once('modules/Accounts/Accounts.php');
require_once('include/utils/utils.php');
require_once('modules/Contacts/ModuleConfig.php');

global $app_strings,$app_list_strings,$mod_strings,$theme,$currentModule;
global $adb;
$category = getParentTab();
if(isset($_REQUEST['return_module'])) $return_module = $_REQUEST['return_module'];
else $return_module = "Contacts";
if(isset($_REQUEST['return_action'])) $return_action = $_REQUEST['return_action'];
else $return_action = "index";
if(isset($_REQUEST['record'])) $return_id = $_REQUEST['record'];
if (isset($_REQUEST['return_viewname'])) $return_viewname = $_REQUEST['return_viewname'];

$focus = new Contacts();
$smarty = new CRMSmarty();

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	$focus->id = $_REQUEST['record'];
	$focus->mode = 'edit';
	$focus->retrieve_entity_info($_REQUEST['record'],"Contacts");
    $focus->name=$focus->column_fields['contactname'];	
}





$old_id = '';
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') 
{
	$old_id = $_REQUEST['record'];
	$focus->id = "";
	$focus->mode = '';
}

if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] == 'Accounts') 
{
	$account_id = $_REQUEST['return_id'];
	$focus->column_fields['account_id'] = $account_id;
}


$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$disp_view = getView($focus->mode);
if($disp_view == 'edit_view')
	//$smarty->assign("BLOCKS",getBlocks($currentModule,$disp_view,$focus->mode,$focus->column_fields));
	$smarty->assign("BLOCKS",getBlocks($currentModule,$disp_view,$focus->mode,$focus->column_fields,'',$_REQUEST['record']));
else	
{
	$smarty->assign("BASBLOCKS",getBlocks($currentModule,$disp_view,$focus->mode,$focus->column_fields,'BAS'));
}	
$smarty->assign("OP_MODE",$disp_view);
$category = getParentTab();
$smarty->assign("CATEGORY",$category);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'Contact');

if (isset($focus->name))
	$smarty->assign("NAME", $focus->name);
else
	$smarty->assign("NAME", "");

if($focus->mode == 'edit')
{
	$smarty->assign("UPDATEINFO",updateInfo($focus->id));
    $smarty->assign("MODE", $focus->mode);
}

if (isset($_REQUEST['return_module']))
	$smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);
else
	$smarty->assign("RETURN_MODULE","Contacts");

if (isset($_REQUEST['return_action']))
	$smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
else
	$smarty->assign("RETURN_ACTION","index");
if (isset($_REQUEST['return_id']))
$smarty->assign("RETURN_ID", $_REQUEST['return_id']);
if (isset($_REQUEST['return_viewname']))
$smarty->assign("RETURN_VIEWNAME", $_REQUEST['return_viewname']);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("ID", $focus->id);
$smarty->assign("OLD_ID", $old_id );



$tabid = getTabid("Contacts");
$data = getSplitDBValidationData($focus->tab_name,$tabid);

$smarty->assign("VALIDATION_DATA_FIELDNAME",$data['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$data['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL",$data['fieldlabel']);
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);
if($focus->mode == 'edit')
	$smarty->display("Contacts/EditView.tpl");
else
	$smarty->display("Contacts/CreateView.tpl");

?>
