<?php
require_once('include/CRMSmarty.php');
require_once('data/Tracker.php');
require_once('modules/Memdays/Memdays.php');
require_once('modules/Accounts/Accounts.php');
require_once('include/utils/utils.php');
require_once('modules/Memdays/ModuleConfig.php');

global $app_strings,$app_list_strings,$mod_strings,$theme,$currentModule;
global $adb;
$category = getParentTab();
if(isset($_REQUEST['return_module'])) $return_module = $_REQUEST['return_module'];
else $return_module = "Memdays";
if(isset($_REQUEST['return_action'])) $return_action = $_REQUEST['return_action'];
else $return_action = "index";
if(isset($_REQUEST['record'])) $return_id = $_REQUEST['record'];
if (isset($_REQUEST['return_viewname'])) $return_viewname = $_REQUEST['return_viewname'];
if((!isset($is_disable_approve) || (isset($is_disable_approve) && !$is_disable_approve)) && (isset($module_enable_approve) && $module_enable_approve)) {	$sql = "select approved from ec_memdays where deleted=0 and memdaysid='".$_REQUEST['record']."'";
	$result = $adb->query($sql);
	$approved = $adb->query_result($result,0,"approved");
	if($approved == 1) {
		echo "<script language='javascript'>alert('".$app_strings["already_approved_noedit"]."');";
		$url = "index.php?module=".$return_module."&action=".$return_action."&record=".$return_id."&return_viewname=".$return_viewname."&parenttab=".$category;
		echo "document.location.href='".$url."';";
		echo "</script>";
		die;
	}
}


$focus = new Memdays();
$smarty = new CRMSmarty();
if(isset($module_enable_product) && $module_enable_product) 
{
	$smarty->assign("MODULE_ENABLE_PRODUCT", "true");
}

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	$focus->id = $_REQUEST['record'];
	$focus->mode = 'edit';
	$focus->retrieve_entity_info($_REQUEST['record'],"Memdays");
    $focus->name=$focus->column_fields['memdayname'];	
	if(isset($module_enable_product) && $module_enable_product) 
	{
		$associated_prod = $focus->getAssociatedProducts();
		$smarty->assign("ASSOCIATEDPRODUCTS", $associated_prod);
		$smarty->assign("AVAILABLE_PRODUCTS", 'true');
	}
	if(isset($module_enable_approve) && $module_enable_approve) 
	{
		$approveProcess = getApproveStatus($focus->id);
		if($approveProcess == $app_strings['CONSTANTS_APPIN']) {
			$smarty->assign("APPIN_PROCESS", $approveProcess);
		}
	}
}





$old_id = '';
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') 
{
	$old_id = $_REQUEST['record'];
	$focus->id = "";
	$focus->mode = '';
}

/*
if(empty($focus->column_fields['memdayname'])) {
	$focus->column_fields['memdayname'] = "GD".date("Ymd")."-".$focus->get_next_id();
}
*/
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] == 'Accounts') 
{
	$account_id = $_REQUEST['return_id'];
	$focus->column_fields['account_id'] = $account_id;
}




//setting default flag value so due date and time not required
//if (!isset($focus->id)) $focus->date_due_flag = 'on';

//needed when creating a new case with default values passed in




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


$log->info("Memday detail view");

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'Memday');
//Display the FCKEditor or not? -- configure $FCKEDITOR_DISPLAY in config.php 
//$smarty->assign("FCKEDITOR_DISPLAY",$FCKEDITOR_DISPLAY);

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
	$smarty->assign("RETURN_MODULE","Memdays");

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

$datestr = $focus->column_fields["memday940"];
$datearr = explode(" ",$datestr);
$smarty->assign("curryear", $datearr[0]);
$smarty->assign("currmonth", $datearr[1]);
$smarty->assign("currdays", $datearr[2]);

$tabid = getTabid("Memdays");
$data = getSplitDBValidationData($focus->tab_name,$tabid);

$smarty->assign("VALIDATION_DATA_FIELDNAME",$data['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$data['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL",$data['fieldlabel']);
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);
if(isset($module_enable_product) && $module_enable_product) 
{
	$fieldnamelist = getProductFieldList("Memdays");
	$smarty->assign("PRODUCTNAMELIST",$fieldnamelist);
	$fieldlabellist = getProductFieldLabelList("Memdays");
	$smarty->assign("PRODUCTLABELLIST",$fieldlabellist);
}
if($focus->mode == 'edit')
    $smarty->display("Memdays/RelEditView.tpl");
else
	$smarty->display("Memdays/RelCreateView.tpl");

?>

