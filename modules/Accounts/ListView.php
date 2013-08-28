<?php
require_once('include/CRMSmarty.php');
require_once("data/Tracker.php");
require_once('modules/Accounts/Accounts.php');
require_once('include/ListView/ListView.php');
require_once('include/database/PearDatabase.php');
require_once('include/ComboUtil.php');
require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');
require_once('modules/Accounts/Accountsrel.php');
global $app_strings;
global $list_max_entries_per_page;

global $currentModule;
global $theme;

$category = getParentTab();
$currentModule = "Accounts";

// focus_list is the means of passing data to a ListView.
global $focus_list;

if (!isset($where)) $where = "";

$url_string = '';

$focus = new Accounts();
$smarty = new CRMSmarty();
$other_text = Array();

//<<<<<<< sort ordering >>>>>>>>>>>>>
$sorder = $focus->getSortOrder();
$order_by = $focus->getOrderBy();

$_SESSION['ACCOUNTS_ORDER_BY'] = $order_by;
$_SESSION['ACCOUNTS_SORT_ORDER'] = $sorder;
//<<<<<<< sort ordering >>>>>>>>>>>>>

//if(isset($_SESSION['lvs'][$currentModule]) && !$_SESSION['lvs'][$currentModule])
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
        $smarty->assign("ERROR","The User does not have permission to Change/Delete ".$errormsg." ".$currentModule);
}else
{
        $smarty->assign("ERROR","");
}

//<<<<cutomview>>>>>>>
$oCustomView = new CustomView($currentModule);
$viewid = $oCustomView->getViewId($currentModule);
$customviewcombo_html = $oCustomView->getCustomViewCombo($viewid);
$viewnamedesc = $oCustomView->getCustomViewByCvid($viewid);
//<<<<<customview>>>>

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
	$smarty->assign("SEARCH_URL",$url_string);
	if(!isset($_SESSION['LiveViewSearch'])) $_SESSION['LiveViewSearch']=array();
	$searchopts=getSearchConditions();
	//changed by chengliang on 2012-04-17
	$_SESSION['LiveViewSearch'][$currentModule]=array($viewid,$where,$ustring,$searchopts);
}
elseif(isset($_SESSION['LiveViewSearch'][$currentModule]))
{
	if($viewid!=$_SESSION['LiveViewSearch'][$currentModule][0]){
		unset($_SESSION['LiveViewSearch'][$currentModule]);
	}else{
		$where=$_SESSION['LiveViewSearch'][$currentModule][1];
		$url_string .="&query=true".$_SESSION['LiveViewSearch'][$currentModule][2];
		$searchopts=$_SESSION['LiveViewSearch'][$currentModule][3];
		if($searchopts['searchtype']=='BasicSearch')
		{
			$smarty->assign("BASICSEARCH",'true');
			if($searchopts['type']!="alpbt"){
				$smarty->assign("BASICSEARCHVALUE",$searchopts['search_text']);
				$smarty->assign("BASICSEARCHFIELD",$searchopts['search_field']);
			}else{
				$alpbtselectedvalue=$searchopts['search_text'];
			}
		}else{
			$smarty->assign("ADVSEARCH",'true');
			$smarty->assign("SEARCHMATCHTYPE",$searchopts['matchtype']);

			$searchcons=$searchopts['conditions'];
			$searchconshtml=array();
			foreach($searchcons as $eachcon)
			{
				$column=$eachcon[0];
				$searchop=$eachcon[1];
				$searchval=$eachcon[2];

				$columnhtml = getAdvSearchfields($currentModule,$column);
				$searchophtml = getcriteria_options($searchop);

				$searchconshtml[]=array($columnhtml,$searchophtml,$searchval);
			}
			$smarty->assign("SEARCHCONSHTML",$searchconshtml);

		}
	}
}
global $current_user;
//added by xiaoyang on 2012-9-18
if(is_admin($current_user)) {
	$smarty->assign("ALL", 'All');
}
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("CUSTOMVIEW_OPTION",$customviewcombo_html);
$smarty->assign("VIEWID", $viewid);
$smarty->assign("BUTTONS",$other_text);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'Account');

//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>

if($viewid != "0")
{
	$listquery = getListQuery("Accounts");  
	$query = $oCustomView->getModifiedCvListQuery($viewid,$listquery,"Accounts");
}else
{
	$query = getListQuery("Accounts");
}


$sortview = $focus->getSortView('Accounts');
$smarty->assign("sortview", $sortview);
//<<<<<<<<customview>>>>>>>>>


if(isset($where) && $where != '')
{
        $query .= ' and '.$where;
        $_SESSION['export_where'] = $where;
}
else
   unset($_SESSION['export_where']);
$view_script = "<script language='javascript'>
	function set_selected()
	{
		len=document.massdelete.viewname.length;
		for(i=0;i<len;i++)
		{
			if(document.massdelete.viewname[i].value == '$viewid')
				document.massdelete.viewname[i].selected = true;
		}
	}
	set_selected();
	</script>";



//echo $query;
//Retreiving the no of rows
$count_result = $adb->query( mkCountQuery( $query));
$noofrows = $adb->query_result($count_result,0,"count");

//Storing Listview session object
if($_SESSION['lvs'][$currentModule])
{
	setSessionVar($_SESSION['lvs'][$currentModule],$noofrows,$list_max_entries_per_page);
}

$start = $_SESSION['lvs'][$currentModule]['start'];


//Retreive the Navigation array
$navigation_array = getNavigationValues($start, $noofrows, $list_max_entries_per_page);
//var_dump($navigation_array);
$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val'];
$_SESSION['nav_start']=$start_rec;
$_SESSION['nav_end']=$end_rec;
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

$list_result = $adb->limitQuery2($query,$limit_start_rec,$list_max_entries_per_page,$query_order_by,$sorder);
//echo $query;
//exit();
$record_string= $app_strings['LBL_SHOWING']." " .$start_rec." - ".$end_rec." " .$app_strings['LBL_LIST_OF'] ." ".$noofrows;


//Retreive the List View Table Header
if($viewid !='')
$url_string .= "&viewname=".$viewid;

 
$listview_header = getListViewHeader($focus,"Accounts",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("LISTHEADER", $listview_header);

$listview_header_search=getSearchListHeaderValues($focus,"Accounts",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("SEARCHLISTHEADER", $listview_header_search);

 
$listview_entries = getListViewEntries($focus,"Accounts",$list_result,$navigation_array,"","","EditView","Delete",$oCustomView);
$smarty->assign("LISTENTITY", $listview_entries);
$smarty->assign("SELECT_SCRIPT", $view_script);
$smarty->assign("CATEGORY",$category);

$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string,"Accounts","index",$viewid);
$fieldnames = getAdvSearchfields($currentModule);
$criteria = getcriteria_options();
$smarty->assign("CRITERIA", $criteria);
$smarty->assign("FIELDNAMES", $fieldnames);
$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("RECORD", $_REQUEST['record']);

$_SESSION[$currentModule.'_listquery'] = $query;
$smarty->assign("ISADMIN",$current_user->is_admin);
$smarty->assign("tabview", $tabview);


if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("Accounts/ListViewEntries.tpl");
else
	$smarty->display("Accounts/ListView.tpl");

?>
