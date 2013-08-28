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
require_once('modules/SalesOrder/SalesOrder.php');
require_once('include/ListView/ListView.php');
require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');


global $app_strings,$mod_strings,$list_max_entries_per_page,$currentModule,$theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

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
$smarty->assign("SINGLE_MOD",'SalesOrder');
$category = getParentTab();
$smarty->assign("CATEGORY",$category);

$focus = new SalesOrder();
$other_text = Array();
$url_string = ''; // assigning http url string
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>
$sorder = $focus->getSortOrder();
$order_by = $focus->getOrderBy();

$_SESSION['SALESORDER_ORDER_BY'] = $order_by;
$_SESSION['SALESORDER_SORT_ORDER'] = $sorder;
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>

if(!$_SESSION['lvs'][$currentModule])
{
	unset($_SESSION['lvs']);
	$modObj = new ListViewSession();
	$modObj->sorder = $sorder;
	$modObj->sortby = $order_by;
	$_SESSION['lvs'][$currentModule] = get_object_vars($modObj);
}
//<<<<cutomview>>>>>>>
$oCustomView = new CustomView("SalesOrder");
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
	$_SESSION['LiveViewSearch'][$currentModule]=array($viewid,$where,$ustring,$searchopts);
				
}else{
	$_SESSION['LiveViewSearch'][$currentModule]= array();
}


//<<<<<<<<<customview>>>>>>>>>
if($viewid != "0")
{
	$listquery = getListQuery("SalesOrder");
	$list_query = $oCustomView->getModifiedCvListQuery($viewid,$listquery,"SalesOrder");
}else
{
	$list_query = getListQuery("SalesOrder");
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
$count_result = $adb->query( mkCountQuery( $list_query));
$noofrows = $adb->query_result($count_result,0,"count");

//Storing Listview session object
if($_SESSION['lvs'][$currentModule])
{
	setSessionVar($_SESSION['lvs'][$currentModule],$noofrows,$list_max_entries_per_page);
}

$start = $_SESSION['lvs'][$currentModule]['start'];

//Retreive the Navigation array
$navigation_array = getNavigationValues($start, $noofrows, $list_max_entries_per_page);

// Setting the record count string
//modified by rdhital
$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val']; 
//By Raju Ends

//limiting the query
$query_order_by = "";
if(isset($order_by) && $order_by != '')
{	
	if($order_by == 'smownerid')
    {
		$query_order_by = 'user_name';
    }
	else
	{
		$query_order_by =  $focus->entity_table.".".$order_by;
    }
}
if ($start_rec == 0) 
	$limit_start_rec = 0;
else
	$limit_start_rec = $start_rec -1;

$list_result = $adb->limitQuery2($list_query,$limit_start_rec,$list_max_entries_per_page,$query_order_by,$sorder);

$record_string= $app_strings["LBL_SHOWING"]." " .$start_rec." - ".$end_rec." " .$app_strings["LBL_LIST_OF"] ." ".$noofrows;

//Retreive the List View Table Header
if($viewid !='')
$url_string .="&viewname=".$viewid;

$listview_header = getListViewHeader($focus,"SalesOrder",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("LISTHEADER", $listview_header);

$listview_header_search=getSearchListHeaderValues($focus,"SalesOrder",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("SEARCHLISTHEADER", $listview_header_search);

$listview_entries = getListViewEntries($focus,"SalesOrder",$list_result,$navigation_array,'','&return_module=SalesOrder&return_action=index','EditView','Delete',$oCustomView);
$smarty->assign("LISTENTITY", $listview_entries);
//$smarty->assign("SELECT_SCRIPT", $view_script);

$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string,"SalesOrder",'index',$viewid);
$fieldnames = getAdvSearchfields($module);
$criteria = getcriteria_options();
$smarty->assign("CRITERIA", $criteria);
$smarty->assign("FIELDNAMES", $fieldnames);
$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("CUSTOMVIEW_OPTION",$customviewcombo_html);
$smarty->assign("VIEWID", $viewid);
$smarty->assign("BUTTONS", $other_text);
$smarty->assign("ISADMIN",$current_user->is_admin);


if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("SalesOrder/ListViewEntries.tpl");
else	
	$smarty->display("SalesOrder/ListView.tpl");

?>
