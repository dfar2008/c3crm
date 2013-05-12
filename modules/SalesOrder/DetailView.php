<?php
require_once('include/CRMSmarty.php');
require_once('data/Tracker.php');
require_once('modules/SalesOrder/SalesOrder.php');
require_once('include/database/PearDatabase.php');
global $mod_strings,$app_strings,$theme,$currentModule;

$focus = new SalesOrder();

if(isset($_REQUEST['record']) && isset($_REQUEST['record'])) {
    $focus->retrieve_entity_info($_REQUEST['record'],"SalesOrder");
    $focus->id = $_REQUEST['record'];
    $focus->name=$focus->column_fields['subject'];
}

if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
}

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new CRMSmarty();

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);

$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
if (isset($focus->name))
$smarty->assign("NAME", $focus->name);
else
$smarty->assign("NAME", "");
$smarty->assign("BLOCKS", getBlocks($currentModule,"detail_view",'',$focus->column_fields));
$smarty->assign("UPDATEINFO",updateInfo($focus->id));

$smarty->assign("ID", $_REQUEST['record']);
$smarty->assign("SINGLE_MOD", 'SalesOrder');
$category = getParentTab();
$smarty->assign("CATEGORY",$category);
$smarty->assign("MODULE", $currentModule);
$smarty->assign("ASSOCIATED_PRODUCTS",$focus->getDetailAssociatedProducts());
if($singlepane_view == 'true')
{
	$related_array = getRelatedLists($currentModule,$focus);
	$smarty->assign("RELATEDLISTS", $related_array);
}

$smarty->assign("SinglePane_View", $singlepane_view);

$smarty->display("SalesOrder/InventoryDetailView.tpl");

?>
