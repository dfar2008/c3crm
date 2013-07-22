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


//$smarty->assign("CUSTOMFIELD", $cust_fld);
$smarty->assign("ID", $_REQUEST['record']);
$category = getParentTab();
$smarty->assign("CATEGORY",$category);


$moduletype = $_REQUEST['moduletype'];
$smarty->assign("type", $moduletype);
$smarty->assign("SINGLE_MOD","Account");


$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);
$smarty->assign("MODULE",$currentModule);
$related_array = getRelatedLists($currentModule,$focus); 
$relcount =  count($related_array); 
$smarty->assign("relcount", $relcount);
$smarty->assign("RELATEDLISTS", $related_array);
$smarty->assign("SinglePane_View", $singlepane_view);

$smarty->display("Accounts/Relatelists.tpl");

?>
