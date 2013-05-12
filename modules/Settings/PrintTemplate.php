<?php

require_once('database/DatabaseConnection.php');
require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('data/Tracker.php');
require_once('include/utils/UserInfoUtil.php');
require_once('include/database/PearDatabase.php');

global $app_strings;
global $mod_strings;
global $current_language;

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smod_strings = return_module_language($current_language,'Settings');

$smarty = new CRMSmarty();

$smarty->assign("APP", $app_strings);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("THEME_PATH", $theme_path);
$smarty->assign("UMOD", $mod_strings);
$smarty->assign("PARENTTAB", $_REQUEST['parenttab']);
$smarty->assign("MOD", $smod_strings);
$smarty->assign("MODULE", 'Settings');

$printArray = array();
$result = $adb->query("select ec_modulelist.*,ec_tab.name from ec_modulelist inner join ec_tab on ec_tab.tabid=ec_modulelist.tabid where ec_modulelist.type='template' order by ec_tab.tabid");
$num_rows = $adb->num_rows($result);
for($i=0; $i<$num_rows; $i++)
{
	$modulename = $adb->query_result($result,$i,'name');
	$printArray[$modulename] = $app_strings[$modulename];
		 
}
$fld_module = "";
if(isset($_REQUEST['fld_module'])) $fld_module = $_REQUEST['fld_module'];
$moduleOtions = get_select_options($printArray,$fld_module);

$smarty->assign('PRINTTYPEOPTION',$moduleOtions);

$smarty->display("Settings/PrintTemplate.tpl");


?>





