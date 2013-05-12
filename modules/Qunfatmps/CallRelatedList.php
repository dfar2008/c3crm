<?php
require_once('include/CRMSmarty.php');
require_once('modules/Qunfatmps/Qunfatmps.php');
require_once('include/utils/utils.php');
//Redirecting Header for single page layout
require_once('user_privileges/default_module_view.php');
global $singlepane_view;
if($singlepane_view == 'true' && $_REQUEST['action'] == 'CallRelatedList' )
{
	redirect("index.php?action=DetailView&module=".$_REQUEST['module']."&record=".$_REQUEST['record']."&parenttab=".$_REQUEST['parenttab']);
}
else
{
$focus = new Qunfatmps();
$currentmodule = $_REQUEST['module'];
$RECORD = $_REQUEST['record'];
if(isset($_REQUEST['record']) && $_REQUEST['record']!='') {
    $focus->retrieve_entity_info($_REQUEST['record'],"Qunfatmps");
    $focus->id = $_REQUEST['record'];
    $focus->qunfatmpname=$focus->column_fields['qunfatmpname'];

$log->debug("id is ".$focus->id);

$log->debug("name is ".$focus->name);
}

global $mod_strings;
global $app_strings;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$smarty = new CRMSmarty();

if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
        $focus->id = "";
}
if(isset($_REQUEST['mode']) && $_REQUEST['mode'] != ' ') {
	$smarty->assign("OP_MODE",$_REQUEST['mode']);
}
 if(!$_SESSION['rlvs'][$module])
 {
       unset($_SESSION['rlvs']);
 }

$category = getParentTab();
$smarty->assign("CATEGORY",$category);
$smarty->assign("UPDATEINFO",updateInfo($focus->id));
if (isset($focus->name)) $smarty->assign("NAME", $focus->name);
$related_array=getRelatedLists("Qunfatmps",$focus);
$smarty->assign("RELATEDLISTS", $related_array);
$smarty->assign("ID",$focus->id);
$smarty->assign("MODULE",$currentmodule);
$smarty->assign("SINGLE_MOD",'Qunfatmp');
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);

$smarty->display("Qunfatmps/RelatedLists.tpl");
}
?>
