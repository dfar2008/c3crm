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
switch($currentModule)
{
	case 'Contacts':
		require_once("modules/Contacts/Contacts.php");
		$focus = new Contacts();
		$log = LoggerManager::getLogger('contact_list');
		//$comboFieldNames = Array('leadsource'=>'leadsource_dom');
		//$comboFieldArray = getComboArray(//$comboFieldNames);
		$smarty->assign("SINGLE_MOD",'Contact');
		if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
			$smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
		else
			$smarty->assign("RETURN_MODULE",'Campaigns');
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','ec_contactdetails.prefix','true','basic',$popuptype,"","","",$viewid);
		break;
	case 'Campaigns':
		require_once("modules/Campaigns/Campaigns.php");
		$focus = new Campaigns();
		$log = LoggerManager::getLogger('campaign_list');
		//$comboFieldNames = Array('campaignstatus'=>'campaignstatus_dom',
					 //'campaigntype'=>'campaigntype_dom');
		//$comboFieldArray = getComboArray(//$comboFieldNames);
		$smarty->assign("SINGLE_MOD",'Campaign');
		if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
			$smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','campaignname','true','basic',$popuptype,"","","",$viewid);
		break;
	case 'Accounts':
		require_once("modules/Accounts/Accounts.php");
		$focus = new Accounts();
		$log = LoggerManager::getLogger('account_list');
		//$comboFieldNames = Array('accounttype'=>'account_type_dom'
				//,'industry'=>'industry_dom');
		//$comboFieldArray = getComboArray(//$comboFieldNames);
		$smarty->assign("SINGLE_MOD",'Account');
		if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
			$smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
		else
			$smarty->assign("RETURN_MODULE",'Campaigns');
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','ec_account.prefix','true','basic',$popuptype,"","","",$viewid);
		break;
	case 'Potentials':
		require_once("modules/Potentials/Potentials.php");
		$focus = new Potentials();
		$log = LoggerManager::getLogger('potential_list');
		//$comboFieldNames = Array('leadsource'=>'leadsource_dom'
				//,'opportunity_type'=>'opportunity_type_dom'
				//,'sales_stage'=>'sales_stage_dom');
		//$comboFieldArray = getComboArray(//$comboFieldNames);
		$smarty->assign("SINGLE_MOD",'Potential');
		if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
			$smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','potentialname','true','basic',$popuptype,"","","",$viewid);
		break;
	case 'Quotes':
		require_once("modules/Quotes/Quotes.php");	
		$focus = new Quotes();
		$log = LoggerManager::getLogger('quotes_list');
		//$comboFieldNames = Array('quotestage'=>'quotestage_dom');
		//$comboFieldArray = getComboArray(//$comboFieldNames);
		$smarty->assign("SINGLE_MOD",'Quote');
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','ec_quotes.subject','true','basic',$popuptype,"","","",$viewid);
		break;
	case 'Invoice':
		require_once("modules/Invoice/Invoice.php");
		$focus = new Invoice();
		$smarty->assign("SINGLE_MOD",'Invoice');
		if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
			$smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','ec_invoice.subject','true','basic',$popuptype,"","","",$viewid);
		break;
	/*
	case 'Products':
		require_once("modules/$currentModule/Products.php");
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
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','productname','true','basic',$popuptype,"","","",$viewid);
		break;
	*/
	case 'Vendors':
		require_once("modules/Vendors/Vendors.php");
		$focus = new Vendors();
		$smarty->assign("SINGLE_MOD",'Vendor');
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','ec_vendor.prefix','true','basic',$popuptype,"","","",$viewid);
		break;
	case 'Vcontacts':
		require_once("modules/Vcontacts/Vcontacts.php");
		$focus = new Vcontacts();
		$smarty->assign("SINGLE_MOD",'Vcontact');
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','ec_vcontacts.prefix','true','basic',$popuptype,"","","",$viewid);
		break;
	case 'SalesOrder':
		require_once("modules/SalesOrder/SalesOrder.php");
		$focus = new SalesOrder();
		$smarty->assign("SINGLE_MOD",'SalesOrder');
		if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
			$smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','ec_salesorder.subject','true','basic',$popuptype,"","","",$viewid);
		break;
	case 'PurchaseOrder':
		require_once("modules/PurchaseOrder/PurchaseOrder.php");
		$focus = new PurchaseOrder();
		$smarty->assign("SINGLE_MOD",'PurchaseOrder');
		if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
			$smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','ec_purchaseorder.subject','true','basic',$popuptype,"","","",$viewid);
		break;
	case 'PriceBooks':
		require_once("modules/PriceBooks/PriceBooks.php");
		$focus = new PriceBooks();
		$smarty->assign("SINGLE_MOD",'PriceBook');
		if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
			$smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
		if(isset($_REQUEST['fldname']) && $_REQUEST['fldname'] !='')
		{
			$smarty->assign("FIELDNAME",$_REQUEST['fldname']);
			$url_string .="&fldname=".$_REQUEST['fldname'];
		}
		if(isset($_REQUEST['productid']) && $_REQUEST['productid'] !='')
		{
			$smarty->assign("PRODUCTID",$_REQUEST['productid']);
			$url_string .="&productid=".$_REQUEST['productid'];
		}
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','bookname','true','basic',$popuptype,"","","",$viewid);
		break;
	case 'Users':
                require_once("modules/Users/Users.php");
                $focus = new Users();
                $smarty->assign("SINGLE_MOD",'Users');
                if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
                    $smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
                $alphabetical = AlphabeticalSearch($currentModule,'Popup','user_name','true','basic',$popuptype,"","","",$viewid);
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
                break;	
	case 'HelpDesk':
		require_once("modules/HelpDesk/HelpDesk.php");
		$focus = new HelpDesk();
		$smarty->assign("SINGLE_MOD",'HelpDesk');
		if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
		$smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
		$alphabetical = AlphabeticalSearch($currentModule,'Popup','ticket_title','true','basic',$popuptype,"","","",$viewid);
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		break;
	default:
		require_once("modules/$currentModule/$currentModule.php");
		$focus = new $currentModule();
		$single_module = substr($currentModule,0,(strlen($currentModule)-1));
		$smarty->assign("SINGLE_MOD",$single_module);
		if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] !='')
		$smarty->assign("RETURN_MODULE",$_REQUEST['return_module']);
		$alphabetical = AlphabeticalSearch($currentModule,'Popup',strtolower($single_module).'name','true','basic',$popuptype,"","","",$viewid);
		if (isset($_REQUEST['select'])) $smarty->assign("SELECT",'enable');
		break;


}
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


//Retreive the list from Database
$query = "";
if($currentModule == 'PriceBooks')
{
	$productid=$_REQUEST['productid'];
	$query = 'select ec_pricebook.*, ec_pricebookproductrel.productid, ec_pricebookproductrel.listprice from ec_pricebook inner join ec_pricebookproductrel on ec_pricebookproductrel.pricebookid = ec_pricebook.pricebookid where ec_pricebookproductrel.productid='.$productid.' and deleted=0';
}
else
{
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
		//after selecting account,select contact based by selected account
		if($currentModule == 'Contacts' && isset($_REQUEST['account_id']) && $_REQUEST['account_id'] != '') {
			$where_relquery .= ' AND ec_contactdetails.accountid='.$_REQUEST['account_id'];
			$url_string .="&account_id=".$_REQUEST['account_id'];
		}
		elseif($currentModule == 'SalesOrder' || $currentModule == 'PurchaseOrder' || $currentModule == 'Invoice') {
			//if(!isset($is_disable_approve) || (isset($is_disable_approve) && !$is_disable_approve)) {
			//	$where_relquery .= ' AND ec_salesorder.approved=1 ';
			//}
			if(isset($_REQUEST['account_id']) && $_REQUEST['account_id'] != '' && $currentModule == 'SalesOrder') {
				$where_relquery .= ' AND ec_salesorder.accountid='.$_REQUEST['account_id'];
			}else if(isset($_REQUEST['account_id']) && $_REQUEST['account_id'] != '' && $currentModule == 'Invoice') {
				$where_relquery .= ' AND ec_invoice.accountid='.$_REQUEST['account_id'];
			}
		}elseif($currentModule == 'Potentials' && isset($_REQUEST['account_id']) && $_REQUEST['account_id'] != '') {
			$where_relquery .= ' AND ec_potential.accountid='.$_REQUEST['account_id'];
			$url_string .="&account_id=".$_REQUEST['account_id'];
		}
		/*
		//after selecting poducts based by selected vendor
		if($currentModule == 'Products' && isset($_REQUEST['vendor_id']) && $_REQUEST['vendor_id'] != '') {
			$where_relquery .= ' AND ec_products.vendor_id ='.$_REQUEST['vendor_id'];
			$url_string .="&vendor_id=".$_REQUEST['vendor_id'];
		}
		*/
        $query = getListQuery($currentModule,$where_relquery,true);//viewscope = all_to_me
		if(empty($query)) {
			$query = $focus->getListQuery($where_relquery,true);//viewscope = all_to_me
		}
		//customview begin
		if($viewid != "0")
		{
			$query = $oCustomView->getModifiedCvListQuery($viewid,$query,$currentModule,true);
		}
		//customview end
}

if(isset($_REQUEST['query']) && $_REQUEST['query'] == 'true')
{
	list($where, $ustring) = split("#@@#",getWhereCondition($currentModule));
	$url_string .="&query=true".$ustring;
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
$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val'];
if($start_rec != 0)
	$record_string= $app_strings['LBL_SHOWING']." " .$start_rec." - ".$end_rec." " .$app_strings['LBL_LIST_OF'] ." ".$noofrows;

if ($start_rec == 0) 
	$limit_start_rec = 0;
else
	$limit_start_rec = $start_rec -1;
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
$listview_header_search=getSearchListHeaderValues($focus,$currentModule,$url_string,$sorder,$order_by);
$smarty->assign("SEARCHLISTHEADER", $listview_header_search);

$smarty->assign("ALPHABETICAL", $alphabetical);


$listview_header = getSearchListViewHeader($focus,$currentModule,$url_string,$sorder,$order_by);
$smarty->assign("LISTHEADER", $listview_header);


$listview_entries = getSearchListViewEntries($focus,$currentModule,$list_result,$navigation_array);
$smarty->assign("LISTENTITY", $listview_entries);

$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string,$currentModule,"Popup",$viewid);
$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("POPUPTYPE", $popuptype);


if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("PopupContents.tpl");
else
	$smarty->display("Popup.tpl");

?>

