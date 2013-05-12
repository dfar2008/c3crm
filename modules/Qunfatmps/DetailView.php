<?php
require_once('data/Tracker.php');
require_once('include/CRMSmarty.php');
require_once('modules/Qunfatmps/Qunfatmps.php');
global $app_strings;
global $mod_strings;
global $currentModule;
$focus = new Qunfatmps();
if(isset($_REQUEST['record'])) {
   $focus->retrieve_entity_info($_REQUEST['record'],"Qunfatmps");
   $focus->id = $_REQUEST['record'];
   $focus->name=$focus->column_fields['qunfatmpname'];
}
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
}

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new CRMSmarty();
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$blocks2 = getBlocks($currentModule,"detail_view",'',$focus->column_fields);
$smarty->assign("BLOCKS", $blocks2);
$smarty->assign("UPDATEINFO",updateInfo($focus->id));

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
$smarty->assign("SINGLE_MOD", 'Qunfatmp');
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

$smarty->display("Qunfatmps/DetailView.tpl");

?>
