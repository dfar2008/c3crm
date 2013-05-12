<?php
require_once('data/Tracker.php');
require_once('include/CRMSmarty.php');
require_once('modules/Maillists/Maillists.php');
require_once('modules/Maillists/ModuleConfig.php');
require_once('include/utils/utils.php');
global $app_strings;
global $mod_strings;
global $currentModule;
$focus = new Maillists();
if(isset($_REQUEST['record'])) {
   $focus->retrieve_entity_info($_REQUEST['record'],"Maillists");
   $focus->id = $_REQUEST['record'];
   $focus->name=$focus->column_fields['maillistname'];
}
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
}

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$log->info("Maillist detail view");

//客户处理
$acc_arr = array();
$accountidstr = $focus->column_fields['accountid'];
$accountidarr = explode(",",$accountidstr);
if(is_array($accountidarr)){
	foreach($accountidarr as $accountid){
		if(!empty($accountid)){
			$accountname = getAccountNameInfo($accountid); 
			$acc_arr[] = $accountname;
		}
	}
}
$acc_arr_srt = implode(",",$acc_arr);

$focus->column_fields['accountid'] = $acc_arr_srt ;

$smarty = new CRMSmarty();
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$blocks2 = getBlocks($currentModule,"detail_view",'',$focus->column_fields);
$smarty->assign("BLOCKS", $blocks2);
$smarty->assign("UPDATEINFO",updateInfo($focus->id));

if(isset($module_enable_product) && $module_enable_product)
{
	$smarty->assign("MODULE_ENABLE_PRODUCT", "true");
	$smarty->assign("ASSOCIATED_PRODUCTS",$focus->getDetailAssociatedProducts());
}


if (isset($focus->name)) $smarty->assign("NAME", $focus->name);
else $smarty->assign("NAME", "");

if (isset($_REQUEST['return_module'])) $smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);
if (isset($_REQUEST['return_action'])) $smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
if (isset($_REQUEST['return_id'])) $smarty->assign("RETURN_ID", $_REQUEST['return_id']);

$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("ID", $focus->id);
$category = getParentTab();
$smarty->assign("CATEGORY",$category);
$smarty->assign("SINGLE_MOD", 'Maillist');

if(isPermitted($module,"EditView",$_REQUEST['record']) == 'yes') {
    
	$smarty->assign("EDIT","permitted");
	$smarty->assign("EDIT_PERMISSION","yes");
    
} else {
	$smarty->assign("EDIT_PERMISSION","no");
}
$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);



if(isPermitted($module,"Create",$_REQUEST['record']) == 'yes')
	$smarty->assign("EDIT_DUPLICATE","permitted");
if(isPermitted($module,"Delete",$_REQUEST['record']) == 'yes')
	$smarty->assign("DELETE","permitted");


$smarty->assign("MODULE",$currentModule);


if($module_relatedmodule != "" || (isset($module_enable_attachment) && $module_enable_attachment))
{
	if($singlepane_view == 'true')
	{
		$related_array = getRelatedLists($currentModule,$focus);
		$smarty->assign("RELATEDLISTS", $related_array);
	}
	$smarty->assign("SinglePane_View", $singlepane_view);
}

$smarty->display("Maillists/DetailView.tpl");

function getAccountNameInfo($id)
{
	global $adb;
	$query = "select accountname from ec_account where accountid='{$id}' and deleted=0";
	$row = $adb->getFirstLine($query);
	$num = $adb->num_rows($row);
	if($num > 0){
		return $row['accountname'];
	}else{
		return '';
	}	
}
?>
