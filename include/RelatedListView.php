<?php
require_once('include/utils/UserInfoUtil.php');
require_once("include/utils/utils.php");
require_once("include/ListView/ListViewSession.php");

/** Function to get related list entries in detailed array format
  * @param $module -- modulename:: Type string
  * @param $relatedmodule -- relatedmodule:: Type string
  * @param $focus -- focus:: Type object
  * @param $query -- query:: Type string
  * @param $button -- buttons:: Type string
  * @param $returnset -- returnset:: Type string
  * @param $id -- id:: Type string
  * @param $edit_val -- edit value:: Type string
  * @param $del_val -- delete value:: Type string
  * @returns $related_entries -- related entires:: Type string array
  *
  */

function GetRelatedList($module,$relatedmodule,$focus,$query,$button,$returnset,$id='',$edit_val='',$del_val='')
{   
	global $log;
	//changed by dingjianting on 2007-11-05 for php5.2.x
	$log->debug("Entering GetRelatedList() method ...");
	require_once('include/CRMSmarty.php');
	require_once('include/DatabaseUtil.php');

	global $adb;
	global $app_strings;
	global $current_language;
	$current_module_strings = return_module_language($current_language, $module);
	global $list_max_entries_per_page;
	global $urlPrefix;
	global $currentModule;
	global $theme;
	global $theme_path;
	global $mod_strings;
	$list_max_entries_per_page = 10000;
	// focus_list is the means of passing data to a ListView.
	global $focus_list;
	$smarty = new CRMSmarty();
	if (!isset($where)) $where = "";
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	$smarty->assign("MOD", $mod_strings);
	$smarty->assign("APP", $app_strings);
	$smarty->assign("IMAGE_PATH",$image_path);
	$smarty->assign("MODULE",$relatedmodule);
	if(isset($where) && $where != '')
	{
		$query .= ' and '.$where;
	}
	/*
	if(!isset($_SESSION['rlvs'][$module][$relatedmodule]) || !$_SESSION['rlvs'][$module][$relatedmodule])
	{
		$modObj = new ListViewSession();
		$modObj->sortby = $focus->default_order_by;
		$modObj->sorder = $focus->default_sort_order;
		$_SESSION['rlvs'][$module][$relatedmodule] = get_object_vars($modObj);
	}
	*/
	
	if(empty($order_by))
	{
		$order_by = $focus->entity_table.".".$focus->default_order_by;		
	}
	if(empty($sorder))
	{
		$sorder = $focus->default_sort_order;
	}
	$url_qry = "&order_by=".$order_by;	
	
	$count_query = mkCountQuery($query);
	
	$count_result = $adb->query($count_query);
	$noofrows = $adb->query_result($count_result,0,"count");
	
	//Setting Listview session object while sorting/pagination
	if(isset($_REQUEST['relmodule']) && $_REQUEST['relmodule']!='' && $_REQUEST['relmodule'] == $relatedmodule)
	{
		if(isset($_REQUEST['start']) && $_REQUEST['start'] != '')
		{
			$start = $_REQUEST['start'];
		} else {
			$start = 1;
		}
	} else {
		$start = 1;
	}
	
	$navigation_array = getNavigationValues($start, $noofrows, $list_max_entries_per_page);
	$start_rec = $navigation_array['start'];
	$end_rec = $navigation_array['end_val'];


	//limiting the query
	if ($start_rec <= 0) 
		$limit_start_rec = 0;
	else
		$limit_start_rec = $start_rec -1;
	//$list_result = $adb->limitQuery2($query,$limit_start_rec,$list_max_entries_per_page,$order_by,$sorder);
	$list_result = $adb->limitQuery($query,$limit_start_rec,$list_max_entries_per_page,$order_by,$sorder);

	//Retreive the List View Table Header
	if($noofrows == 0)
	{
		$smarty->assign('NOENTRIES',$app_strings['LBL_NONE_SCHEDULED']);
	}
	else
	{

		setRelmodFieldList($relatedmodule,$focus);//set more module field
		$id = $_REQUEST['record'];
		$listview_header = getListViewHeader($focus,$relatedmodule,'',$sorder,$order_by,$id,'',$module);//"Accounts"); 
		
		if ($noofrows > 15)
		{
			$smarty->assign('SCROLLSTART','<div style="overflow:auto;height:315px;width:100%;">');
			$smarty->assign('SCROLLSTOP','</div>');
		}
		$smarty->assign("LISTHEADER", $listview_header);
				
		
		if($relatedmodule != 'SalesOrder')
		{
			$listview_entries = getListViewEntries($focus,$relatedmodule,$list_result,$navigation_array,'relatedlist',$returnset);
		}
		else
		{			
			$listview_entries = getListViewEntries($focus,$relatedmodule,$list_result,$navigation_array,'relatedlist',$returnset,'SalesOrderEditView','DeleteSalesOrder');
		}

		$navigationOutput = Array();
		//$navigationOutput[] = $app_strings['LBL_SHOWING']." " .$start_rec." - ".$end_rec." " .$app_strings['LBL_LIST_OF'] ." ".$noofrows;
		$navigationOutput[] = $app_strings['LBL_SHOWING']." " .$start_rec." - ".$noofrows;
		$module_rel = $module.'&relmodule='.$relatedmodule.'&record='.$id;
		//$navigationOutput[] = getRelatedTableHeaderNavigation($navigation_array, $url_qry,$module_rel);
		//changed by dfar2008 on 2012-04-15 for relatedlist
		$related_entries = array('header'=>$listview_header,'entries'=>$listview_entries,'navigation'=>$navigationOutput);
		$log->debug("Exiting GetRelatedList method ...");
		return $related_entries;
	}
}


/** Function to get related list entries in detailed array format
  * @param $parentmodule -- parentmodulename:: Type string
  * @param $query -- query:: Type string
  * @param $id -- id:: Type string
  * @returns $entries_list -- entries list:: Type string array
  * ALTER TABLE `ec_attachments` ADD `setype` VARCHAR( 50 ) NOT NULL ,
ADD `smcreatorid` INT( 10 ) NOT NULL ,
ADD `createdtime` DATETIME NOT NULL ,
ADD `deleted` INT( 1 ) NULL DEFAULT '0';
  */

function getAttachments($parentmodule,$query,$id,$sid='')
{	
	global $log;
	global $app_strings;
	$log->debug("Entering getAttachments() method ...");
	global $theme;
	$entries_list = array();
	$return_data = array();
	global $adb;
	global $mod_strings;
	global $app_strings;
	global $current_user;

	$result=$adb->query($query);
	$noofrows = $adb->num_rows($result);

	$header[] = $app_strings['LBL_CREATED_TIME'];
	$header[] = $app_strings['LBL_ATTACHMENTS'];
	$header[] = $app_strings['LBL_DESCRIPTION'];
	$header[] = $app_strings['Assigned To'];
	
    foreach($result as $row)
	{
		$entries = Array();
		
		$module = 'uploads';
		$editaction = 'upload';
		$deleteaction = 'deleteattachments';
		
		if(isValidDate($row['createdtime'],'0000-00-00'))
		{
			$created_arr = explode(" ",$row['createdtime']);
			$created_date = $created_arr[0];
			$created_time = substr($created_arr[1],0,5);
		}
		else
		{
			$created_date = '';
			$created_time = '';
		}

		$entries[] = $created_date;
		
		//$attachmentname = ltrim($row['filename'],$row['attachmentsid'].'_');//explode('_',$row['filename'],2);
		//changed by dingjianting on 2008-09-16 for attachment with number name posted by pushi
		$attachmentname = trim($row['name']);//explode('_',$row['filename'],2);

		$entries[] = '<a href="index.php?module=uploads&action=downloadfile&entityid='.$id.'&fileid='.$row['attachmentsid'].'">'.$attachmentname.'</a>';
		/*
		if(strlen($row['description']) > 40)
		{
			$row['description'] = substr($row['description'],0,40).'...';
		}
		*/
		$entries[] = nl2br($row['description']); 
		$entries[] = $row['user_name']; 
		$setype = $row['setype']; 
	    
		

	    if($current_user->column_fields['user_name'] == $row['user_name']) {
			$del_param = 'index.php?module='.$module.'&action='.$deleteaction.'&return_module='.$setype.'&return_action='.$_REQUEST['action'].'&record='.$row["attachmentsid"].'&return_id='.$_REQUEST["record"];			
			if($setype == 'Maillists'){
				$entries[] = '';
			    $header[]  = '';
			}else{
				$header[] = $app_strings['LBL_ACTION'];	
				$entries[] = '<a href=\'javascript:confirmdelete("'.$del_param.'")\'>'.$app_strings['LNK_DELETE'].'</a>';
			}
		} else {
			$entries[] = '&nbsp;';
		}
		$entries_list[] = $entries;
	}
	
	if($entries_list != '')
		$return_data = array('header'=>$header,'entries'=>$entries_list);
	$log->debug("Exiting getAttachments method ...");
	return $return_data;

}

?>
