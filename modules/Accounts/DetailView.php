<?php
require_once('include/CRMSmarty.php');
require_once('data/Tracker.php');
require_once('modules/Accounts/Accounts.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $log, $currentModule, $singlepane_view;
global $current_user;

$focus = new Accounts();
if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') {
    $focus->retrieve_entity_info($_REQUEST['record'],"Accounts");
    $focus->id = $_REQUEST['record'];
    $focus->name=$focus->column_fields['accountname'];
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

$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);

if (isset($focus->name)) $smarty->assign("NAME", $focus->name);
else $smarty->assign("NAME", "");
$smarty->assign("BLOCKS", getBlocks("Accounts","detail_view",'',$focus->column_fields));
$smarty->assign("UPDATEINFO",updateInfo($focus->id));

//$smarty->assign("CUSTOMFIELD", $cust_fld);
$smarty->assign("ID", $_REQUEST['record']);
$smarty->assign("SINGLE_MOD",'Account');
$category = getParentTab();
$smarty->assign("CATEGORY",$category);

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);
$smarty->assign("MODULE",$currentModule);
$related_array = getRelatedLists($currentModule,$focus); 
$relcount =  count($related_array); 
$smarty->assign("relcount", $relcount);
$smarty->assign("RELATEDLISTS", $related_array);
$smarty->assign("SinglePane_View", $singlepane_view);

$smarty->display("Accounts/DetailView.tpl");
?>
