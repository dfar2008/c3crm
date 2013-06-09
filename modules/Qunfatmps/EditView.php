<?php
require_once('include/CRMSmarty.php');
require_once('data/Tracker.php');
require_once('modules/Qunfatmps/Qunfatmps.php');
require_once('modules/Accounts/Accounts.php');

global $app_strings,$app_list_strings,$mod_strings,$theme,$currentModule;
global $adb;
$category = getParentTab();
if(isset($_REQUEST['return_module'])) $return_module = $_REQUEST['return_module'];
else $return_module = "Qunfatmps";
if(isset($_REQUEST['return_action'])) $return_action = $_REQUEST['return_action'];
else $return_action = "index";
if(isset($_REQUEST['record'])) $return_id = $_REQUEST['record'];
if (isset($_REQUEST['return_viewname'])) $return_viewname = $_REQUEST['return_viewname'];
$focus = new Qunfatmps();
$smarty = new CRMSmarty();
if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	$focus->id = $_REQUEST['record'];
	$focus->mode = 'edit';
	$focus->retrieve_entity_info($_REQUEST['record'],"Qunfatmps");
    $focus->name=$focus->column_fields['qunfatmpname'];	
}
$old_id = '';
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') 
{
	$old_id = $_REQUEST['record'];
	$focus->id = "";
	$focus->mode = '';
}
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$qunfatmpname = $focus->column_fields['qunfatmpname'];
$description = $focus->column_fields['description'];
$smarty->assign("qunfatmpname",$qunfatmpname);
$smarty->assign("description",$description);


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


$log->info("Qunfatmp detail view");

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'Qunfatmp');
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
	$smarty->assign("RETURN_MODULE","Qunfatmps");

if (isset($_REQUEST['return_action']))
	$smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
else
	$smarty->assign("RETURN_ACTION","index");
if (isset($_REQUEST['return_id']))
$smarty->assign("RETURN_ID", $_REQUEST['return_id']);

if (isset($_REQUEST['record']))
{
         $smarty->assign("CANCELACTION", "DetailView");
}
else
{
         $smarty->assign("CANCELACTION", "index");
}
if (isset($_REQUEST['return_viewname']))
$smarty->assign("RETURN_VIEWNAME", $_REQUEST['return_viewname']);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("ID", $focus->id);
$smarty->assign("OLD_ID", $old_id );




$tabid = getTabid("Qunfatmps");
$data = getSplitDBValidationData($focus->tab_name,$tabid);

$smarty->assign("VALIDATION_DATA_FIELDNAME",$data['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$data['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL",$data['fieldlabel']);
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);
if(isset($module_enable_product) && $module_enable_product) 
{
	$fieldnamelist = getProductFieldList("Qunfatmps");
	$smarty->assign("PRODUCTNAMELIST",$fieldnamelist);
	$fieldlabellist = getProductFieldLabelList("Qunfatmps");
	$smarty->assign("PRODUCTLABELLIST",$fieldlabellist);
}
if($focus->mode == 'edit')
	$smarty->display("Qunfatmps/EditView.tpl");
else
	$smarty->display("Qunfatmps/CreateView.tpl");

?>
