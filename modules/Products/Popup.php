<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
require_once('include/CRMSmarty.php');
require_once("data/Tracker.php");

require_once('include/logging.php');
require_once('include/ListView/ListView.php');
require_once('include/database/PearDatabase.php');
require_once('include/ComboUtil.php');
require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');

global $app_strings;
global $currentModule;
global $theme;
$url_string = '';
$smarty = new CRMSmarty();
if (!isset($where)) $where = "";
//<<<<cutomview>>>>>>>
$oCustomView = new CustomView($currentModule);
$viewid = $oCustomView->getViewId($currentModule);
$customviewcombo_html = $oCustomView->getCustomViewCombo($viewid);
$viewnamedesc = $oCustomView->getCustomViewByCvid($viewid);
//<<<<<customview>>>>>

$popuptype = '';
$popuptype = $_REQUEST["popuptype"];

require_once("modules/Products/Products.php");
$focus = new Products();
$smarty->assign("SINGLE_MOD",'Product');
if(isset($_REQUEST['curr_row']))
{
	$curr_row = $_REQUEST['curr_row'];
	$smarty->assign("CURR_ROW", $curr_row);
	$url_string .="&curr_row=".$_REQUEST['curr_row'];
}
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
	$smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
$alphabetical = AlphabeticalSearch($currentModule,'Popup','productcode','true','basic',$popuptype,"","","",$viewid);

if(isset($_REQUEST['return_action'])) {
	$return_action = $_REQUEST['return_action'];
	$smarty->assign("RETURN_ACTION",$return_action);
}

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("THEME_PATH",$theme_path);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("CUSTOMVIEW_OPTION",$customviewcombo_html);
$smarty->assign("VIEWID", $viewid);
if(isPermitted($currentModule,"Create") == 'yes') {
	$smarty->assign("CREATE_PERMISSION","permitted");
}


//Retreive the list from Database
$query = "";

$recordid = "";
if(isset($_REQUEST['recordid']) && $_REQUEST['recordid'] != '')
{		
	$recordid = $_REQUEST['recordid'];
	$smarty->assign("RECORDID",$recordid);
	$url_string .='&recordid='.$recordid;
}
$return_module = "";
if(isset($_REQUEST['return_module'])) {
	$return_module = $_REQUEST['return_module'];
}
$where_relquery = getRelCheckquery($currentModule,$return_module,$recordid);
//after selecting poducts based by selected vendor
if($currentModule == 'Products' && isset($_REQUEST['vendor_id']) && $_REQUEST['vendor_id'] != '') {
	$where_relquery .= ' AND ec_products.vendor_id ='.$_REQUEST['vendor_id'];
	$url_string .="&vendor_id=".$_REQUEST['vendor_id'];
}
//$query = $focus->getListQuery($where_relquery);
$query = getListQuery("Products");
//customview begin
if($viewid != "0")
{
	$query = $oCustomView->getModifiedCvListQuery($viewid,$query,"Products",true);
}
//customview end

if(isset($_REQUEST['query']) && $_REQUEST['query'] == 'true')
{
	list($where, $ustring) = explode("#@@#",getWhereCondition($currentModule));
	$url_string .="&query=true".$ustring;
	//$smarty->assign("SEARCH_URL",$url_string);
}

if(isset($_REQUEST['search_field']) && $_REQUEST['search_field'] != '')
{

	$smarty->assign("SEARCH_FIELD",$_REQUEST['search_field']);
	$smarty->assign("SEARCH_TEXT",$_REQUEST['search_text']);
}

if(isset($where) && $where != '')
{
        $query .= ' and '.$where;
}

$upperModule = strtoupper($currentModule);
if (isset($_REQUEST['order_by']) && $_REQUEST['order_by'] != '') {
	$order_by = $_REQUEST['order_by'];
}
else {
	$order_by = (($_SESSION[$upperModule.'_ORDER_BY'] != '')?($_SESSION[$upperModule.'_ORDER_BY']):"modifiedtime");
}

if(isset($_REQUEST['sorder']) && $_REQUEST['sorder'] != '') {
	$sorder = $_REQUEST['sorder'];
} else {
	$sorder = (($_SESSION[$upperModule.'_SORT_ORDER'] != '')?($_SESSION[$upperModule.'_SORT_ORDER']):'DESC');
}
$_SESSION[$upperModule.'_ORDER_BY'] = $order_by;
$_SESSION[$upperModule.'_SORT_ORDER'] = $sorder;

if(!isset($order_by) || empty($order_by))
{
	$order_by = 'modifiedtime';
	$sorder = "DESC";
}
//Retreiving the start value from request
if(isset($_REQUEST['start']) && $_REQUEST['start'] != '')
{
        $start = $_REQUEST['start'];
}
else
{

        $start = 1;
}
//Retreiving the no of rows
$count_result = $adb->query(mkCountQuery($query));
$noofrows = $adb->query_result($count_result,0,"count");

//Retreive the Navigation array
$navigation_array = getNavigationValues($start, $noofrows, $list_max_entries_per_page);
// Setting the record count string
$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val']; 
if($navigation_array['start'] != 0)
	$record_string= $app_strings['LBL_SHOWING']." " .$start_rec." - ".$end_rec." " .$app_strings['LBL_LIST_OF'] ." ".$noofrows;

if ($start_rec == 0) 
	$limit_start_rec = 0;
else
	$limit_start_rec = $start_rec -1;
$query_order_by = "";
if(isset($order_by) && $order_by != '')
{	
	
	$tablename = getTableNameForField($currentModule,$order_by);
	$tablename = (($tablename != '')?($tablename."."):'');
	$query_order_by =  $tablename.$order_by;
}
$list_result = $adb->limitQuery2($query,$limit_start_rec,$list_max_entries_per_page,$query_order_by,$sorder);
//Retreive the List View Table Header

$focus->list_mode="search";
$focus->popup_type=$popuptype;
$url_string .='&popuptype='.$popuptype;
if(isset($_REQUEST['select']) && $_REQUEST['select'] == 'enable')
	$url_string .='&select=enable';
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != '')
	$url_string .='&return_module='.$_REQUEST['return_module'];

$smarty->assign("URLSTRING", $url_string);

if($viewid != '') 
{
	$url_string .= "&viewname=".$viewid;
}
$listview_header_search=getSearchListHeaderValues($focus,"$currentModule",$url_string,$sorder,$order_by);
$smarty->assign("SEARCHLISTHEADER", $listview_header_search);

$smarty->assign("ALPHABETICAL", $alphabetical);


$listview_header = getSearchListViewHeader($focus,"$currentModule",$url_string,$sorder,$order_by);
$smarty->assign("LISTHEADER", $listview_header);


$listview_entries = getSearchListViewEntries($focus,"$currentModule",$list_result,$navigation_array);
$smarty->assign("LISTENTITY", $listview_entries);

$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string,$currentModule,"Popup",$viewid);
$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("POPUPTYPE", $popuptype);

//display catalog tree
//Retreiving the hierarchy
$hquery = "select * from ec_catalog order by parentcatalog asc";
$hr_res = $adb->query($hquery);
$num_rows = $adb->num_rows($hr_res);
$hrarray= Array();

for($l=0; $l<$num_rows; $l++)
{
	$catalogid = $adb->query_result($hr_res,$l,'catalogid');
	$parent = $adb->query_result($hr_res,$l,'parentcatalog');
	$temp_list = explode('::',$parent);
	$size = sizeof($temp_list);
	$i=0;
	$k= Array();
	$y=$hrarray;
	if(sizeof($hrarray) == 0)
	{
		$hrarray[$temp_list[0]]= Array();
	}
	else
	{
		while($i<$size-1)
		{
			$y=$y[$temp_list[$i]];
			$k[$temp_list[$i]] = $y;
			$i++;

		}
		$y[$catalogid] = Array();
		$k[$catalogid] = Array();

		//Reversing the Array
		$rev_temp_list=array_reverse($temp_list);
		$j=0;
		//Now adding this into the main array
		foreach($rev_temp_list as $value)
		{
			if($j == $size-1)
			{
				$hrarray[$value]=$k[$value];
			}
			else
			{
				$k[$rev_temp_list[$j+1]][$value]=$k[$value];
			}
			$j++;
		}
	}

}
//Constructing the Catalogdetails array

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("Products/PopupContents.tpl");
else
	$smarty->display("Products/Popup.tpl");

?>

