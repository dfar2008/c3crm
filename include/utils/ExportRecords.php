<?php
/*********************************************************************************

** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');
global $app_strings,$mod_strings, $list_max_entries_per_page, $currentModule, $theme, $current_language;

$smarty = new CRMSmarty();
$category = getParentTab();

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$idstring = rtrim($_REQUEST['idstring'],",");

$smarty->assign("SESSION_WHERE",$_SESSION['export_where']);
$oCustomView = new CustomView($currentModule);
$viewid = $oCustomView->getViewId($currentModule);

$smarty->assign('APP',$app_strings);
$smarty->assign('MOD',$mod_strings);
$smarty->assign("THEME", $theme_path);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("CATEGORY",$category);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("IDSTRING",$idstring);
$smarty->assign("PERPAGE",$list_max_entries_per_page);
$smarty->assign("VIEWNAME",$viewid);
$smarty->display('ExportRecords.tpl');


?>
