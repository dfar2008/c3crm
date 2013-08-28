<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
require_once('include/database/PearDatabase.php');
require_once('include/CRMSmarty.php');
require_once('modules/Products/Products.php');
require_once('include/ListView/ListView.php');
require_once('include/ComboUtil.php');
require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');

global $app_strings;
global $mod_strings;
global $list_max_entries_per_page;
global $currentModule;

//unset($_SESSION['LiveViewSearch'][$currentModule]);

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$focus = new Products();

$smarty = new CRMSmarty();

global $current_user;
//added by xiaoyang on 2012-9-18
if(is_admin($current_user)) {
	$smarty->assign("ALL", 'All');
}
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'Product');
$category = getParentTab();
$smarty->assign("CATEGORY",$category);
$other_text = Array();

//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>
$sorder = $focus->getSortOrder();
$order_by = $focus->getOrderBy();

$_SESSION['PRODUCTS_ORDER_BY'] = $order_by;
$_SESSION['PRODUCTS_SORT_ORDER'] = $sorder;
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>

if(!$_SESSION['lvs'][$currentModule])
{
	unset($_SESSION['lvs']);
	$modObj = new ListViewSession();
	$modObj->sorder = $sorder;
	$modObj->sortby = $order_by;
	$_SESSION['lvs'][$currentModule] = get_object_vars($modObj);
}

if(isset($_REQUEST['errormsg']) && $_REQUEST['errormsg'] != '')
{
        $errormsg = $_REQUEST['errormsg'];
        $smarty->assign("ERROR","The User does not have permission to delete ".$errormsg." ".$currentModule);
}else
{
        $smarty->assign("ERROR","");
}
$url_string = '&smodule=PRODUCTS'; // assigning http url string


//<<<<cutomview>>>>>>>
$oCustomView = new CustomView("Products");
$viewid = $oCustomView->getViewId($currentModule);
$customviewcombo_html = $oCustomView->getCustomViewCombo($viewid);
$viewnamedesc = $oCustomView->getCustomViewByCvid($viewid);
//<<<<<customview>>>>>

//change by renzhen for save the search information
if(isset($_REQUEST['clearquery']) && $_REQUEST['clearquery'] == 'true'){
	unset($_SESSION['LiveViewSearch'][$currentModule]);
	if(isset($_REQUEST['query'])) $_REQUEST['query']='';
}

if(isset($_REQUEST['query']) && $_REQUEST['query'] == 'true')
{
	list($where, $ustring) = explode("#@@#",getWhereCondition($currentModule));
	// we have a query
	$url_string .="&query=true".$ustring;
	$log->info("Here is the where clause for the list view: $where");
	$smarty->assign("SEARCH_URL",$url_string);
	if(!isset($_SESSION['LiveViewSearch'])) $_SESSION['LiveViewSearch']=array();
	$searchopts=getSearchConditions();
	if($searchopts['type']!="others") $_SESSION['LiveViewSearch'][$currentModule]=array($viewid,$where,$ustring,$searchopts);
	else unset($_SESSION['LiveViewSearch'][$currentModule]);

}else{
	$_SESSION['LiveViewSearch'][$currentModule]= array();
}


if(isPermitted($currentModule,'EditView','') == 'yes')
{
	$other_text['quick_edit'] = $app_strings['LBL_QUICKEDIT_BUTTON_LABEL'];
}
if(isPermitted($currentModule,'Delete','') == 'yes')
{
	$other_text['del'] = $app_strings['LBL_MASS_DELETE'];
}

//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>
if($viewid != "0")
{
	$listquery = getListQuery("Products");
	$list_query = $oCustomView->getModifiedCvListQuery($viewid,$listquery,"Products");
}else
{
	$list_query = getListQuery("Products");
}

//<<<<<<<<customview>>>>>>>>>


if(isset($where) && $where != '')
{
        $list_query .= ' and '.$where;
        $_SESSION['export_where'] = $where;
}
else
   unset($_SESSION['export_where']);
//Retreiving the no of rows

$count_result = $adb->query(mkCountQuery($list_query));
$noofrows = $adb->query_result($count_result,0,"count");

//Storing Listview session object
if($_SESSION['lvs'][$currentModule])
{
	setSessionVar($_SESSION['lvs'][$currentModule],$noofrows,$list_max_entries_per_page);
}

$start = $_SESSION['lvs'][$currentModule]['start'];

//Retreive the Navigation array
$navigation_array = getNavigationValues($start, $noofrows, $list_max_entries_per_page);

//modified by rdhital
$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val'];
//By Raju Ends
$_SESSION['nav_start']=$start_rec;
$_SESSION['nav_end']=$end_rec;

//limiting the query
if(isset($order_by) && $order_by != '')
{
	$tablename = getTableNameForField($currentModule,$order_by);
	$tablename = (($tablename != '')?($tablename."."):'');
	$query_order_by =  $tablename.$order_by;
}
if ($start_rec == 0)
	$limit_start_rec = 0;
else
	$limit_start_rec = $start_rec -1;

$list_result = $adb->limitQuery2($list_query,$limit_start_rec,$list_max_entries_per_page,$query_order_by,$sorder);

$record_string= $app_strings["LBL_SHOWING"]." " .$start_rec." - ".$end_rec." " .$app_strings["LBL_LIST_OF"] ." ".$noofrows;

//Retreive the List View Table Header
if($viewid !='')
$url_string .= "&viewname=".$viewid;

$listview_header = getListViewHeader($focus,"Products",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("LISTHEADER", $listview_header);

$listview_header_search = getSearchListHeaderValues($focus,"Products",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("SEARCHLISTHEADER",$listview_header_search);

$listview_entries = getListViewEntries($focus,"Products",$list_result,$navigation_array,"","","EditView","Delete",$oCustomView);
$smarty->assign("LISTENTITY", $listview_entries);
//$smarty->assign("SELECT_SCRIPT", $view_script);

$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string,"Products","index",$viewid);
$alphabetical = AlphabeticalSearch($currentModule,'index','productcode','true','basic',"","","","",$viewid,"",$alpbtselectedvalue);
$fieldnames = getAdvSearchfields($module);
$criteria = getcriteria_options();
$smarty->assign("CRITERIA", $criteria);
$smarty->assign("FIELDNAMES", $fieldnames);
$smarty->assign("ALPHABETICAL", $alphabetical);
$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("CUSTOMVIEW_OPTION",$customviewcombo_html);
$smarty->assign("VIEWID", $viewid);
$smarty->assign("BUTTONS", $other_text);

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);
$smarty->assign("ISADMIN",$current_user->is_admin);
if(isPermitted('Vendors','index') == 'yes'){
	$smarty->assign("VENDOR_VIEW", "permitted");
}

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("Products/ListViewEntries.tpl");
else
	$smarty->display("Products/ListView.tpl");
?>
