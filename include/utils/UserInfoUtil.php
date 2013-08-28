<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');
/** Deprecated Function. To be removed
  *
  *
  *
*/
function fetchTabId($moduleName)
{
	global $log;
	$log->debug("Entering fetchTabId() method ...");
	global $adb;
	$sql = "select id from ec_tab where name ='" .$moduleName ."'";
	$result = $adb->query($sql); 
	$tabid =  $adb->query_result($result,0,"id");
	$log->debug("Exiting fetchTabId method ...");
	return $tabid;

}

/** Function to check if the currently logged in user is permitted to perform the specified action  
  * @param $module -- Module Name:: Type varchar
  * @param $actionname -- Action Name:: Type varchar
  * @param $recordid -- Record Id:: Type integer
  * @returns yes or no. If Yes means this action is allowed for the currently logged in user. If no means this action is not allowed for the currently logged in user 
  *
 */
function isPermitted($module,$actionname,$record_id='')
{
	global $log;
	$log->debug("Entering isPermitted() method ...");
	$permission ="yes";
	if($module == "Settings" || $module == "Users" || $module == "Caches" || $actionname == "CustomView") {
		global $current_user;
		if(!is_admin($current_user)) {
			$permission ="no";
		}
	} 
	
	$log->debug("Exiting isPermitted method ...");
	return $permission;
	
}

/** Function to get userid and username of all ec_users 
  * @returns $userArray -- User Array in the following format:
  * $userArray=Array($userid1=>$username, $userid2=>$username,............,$useridn=>$username); 
 */
function getAllUserName()
{
	global $log;
	$log->debug("Entering getAllUserName() method ...");
	global $adb;
	$query="select * from ec_users where deleted=0";
	$result = $adb->query($query);
	$num_rows=$adb->num_rows($result);
	$user_details=Array();
	for($i=0;$i<$num_rows;$i++)
	{
		$userid=$adb->query_result($result,$i,'id');
		$username=$adb->query_result($result,$i,'user_name');
		$user_details[$userid]=$username;
		
	}
	$log->debug("Exiting getAllUserName method ...");
	return $user_details;

}


function constructList($array,$data_type)
{
	global $log;
	$log->debug("Entering constructList() method ...");
	$list="";
	if(sizeof($array) > 0)
	{
		$i=0;
		$list .= "(";
		foreach($array as $value)
		{
			if($i != 0)
			{
				$list .= ", ";
			}
			if($data_type == "INTEGER")
			{
				$list .= $value;
			}
			elseif($data_type == "VARCHAR")
			{
				$list .= "'".$value."'"; 
			}
			$i++;		
		}
		$list.=")";
	}
	$log->debug("Exiting constructList method ...");
	return $list;	
}


function getListViewSecurityParameter($module,$isSearchAll=false)
{
	global $log;
	$log->debug("Entering getListViewSecurityParameter() method ...");
	global $adb;
	global $current_user;
	if($isSearchAll) 
	{
		$viewscope = "all_to_me";
	}
	else 
	{
		$viewscope = get_viewscope($module);
	}
	$tabid=getTabid($module);
	$sec_query = "";
	global $current_user;
	

    //changed by dingjiant on 2007-8-17 for global share problem poted by hangtang's xiaogao

    
	
	$condition = getReportSecurityParameter($module,$viewscope,false);
	if(!empty($condition)) {
		$sec_query = " and ".$condition;
	}
		
	$log->debug("Exiting getListViewSecurityParameter method ...");
	return $sec_query;	
}


/** Function to get the permitted module name Array with presence as 0 
  * @returns permitted module name Array :: Type Array
  *
 */
function getPermittedModuleNames()
{
	global $log;
	$log->debug("Entering getPermittedModuleNames() method ...");
	$permittedModules=Array();
	$key = "moduletabseqlist";
	$tab_seq_array = getSqlCacheData($key);
	if(!$tab_seq_array) {
		global $adb;
		$sql = "select * from ec_tab order by tabid";
		$result = $adb->query($sql);
		$num_rows=$adb->num_rows($result);
		$tab_seq_array=Array();
		for($i=0;$i<$num_rows;$i++)
		{
				$id=$adb->query_result($result,$i,'tabid');
				$presence=$adb->query_result($result,$i,'presence');
				$tab_seq_array[$id]=$presence;

		}
		setSqlCacheData($key,$tab_seq_array);
	}


	foreach($tab_seq_array as $tabid=>$seq_value)
	{
		if($seq_value ==0)
		{
			$permittedModules[]=getTabModuleName($tabid);
		}
		
	}
	$log->debug("Exiting getPermittedModuleNames method ...");
	return $permittedModules;			
}

/** Function to get the list of module for which the user defined sharing rules can be defined  
  * @returns Array:: Type array
  *
  */
function getSharingModuleList()
{
	global $log;
	//changed by dingjianting on 2007-2-28 for new version to support new modules easy
	//$sharingModuleArray=Array('Accounts', 'Leads', 'Contacts', 'Potentials','HelpDesk', 'Emails', 'Campaigns', 'Quotes','PurchaseOrder', 'SalesOrder', 'Invoice');
	$sharingModuleArray = getFieldModuleAccessArray();
    $sharingModuleArray = array_keys($sharingModuleArray);

	return $sharingModuleArray;					
}
/** Function to get the ec_field access module array 
  * @returns The ec_field Access module Array :: Type Array
  *
 */
function getFieldModuleAccessArray()
{
	global $log;
	global $adb;
	$log->debug("Entering getFieldModuleAccessArray() method ...");
	//changed by dingjianting on 2007-2-28 for new version to support new modules

	$fldModArr=Array();
	$query = 'select distinct(name) from ec_field inner join ec_tab on ec_tab.tabid=ec_field.tabid';
	$result = $adb->query($query);
	$num_rows=$adb->num_rows($result);
	for($i=0;$i<$num_rows;$i++)
	{
		$fldModArr[$adb->query_result($result,$i,'name')]=$adb->query_result($result,$i,'name');
	}
	/*

	$fldModArr=Array('Leads'=>'LBL_LEAD_FIELD_ACCESS',
                'Accounts'=>'LBL_ACCOUNT_FIELD_ACCESS',
                'Contacts'=>'LBL_CONTACT_FIELD_ACCESS',
                'Potentials'=>'LBL_OPPORTUNITY_FIELD_ACCESS',
                'HelpDesk'=>'LBL_HELPDESK_FIELD_ACCESS',
                'Products'=>'LBL_PRODUCT_FIELD_ACCESS',
                'Notes'=>'LBL_NOTE_FIELD_ACCESS',
                'Calendar'=>'LBL_TASK_FIELD_ACCESS',
                'Events'=>'LBL_EVENT_FIELD_ACCESS',
                'Vendors'=>'LBL_VENDOR_FIELD_ACCESS',
                'PriceBooks'=>'LBL_PB_FIELD_ACCESS',
                'Quotes'=>'LBL_QUOTE_FIELD_ACCESS',
                'PurchaseOrder'=>'LBL_PO_FIELD_ACCESS',
                'SalesOrder'=>'LBL_SO_FIELD_ACCESS',
                'Invoice'=>'LBL_INVOICE_FIELD_ACCESS',
                'Campaigns'=>'LBL_CAMPAIGN_FIELD_ACCESS',
				'Faq'=>'LBL_FAQ_FIELD_ACCESS'
              );

	$log->debug("Exiting getFieldModuleAccessArray method ...");
	*/
	return $fldModArr;
}


/** Function to recalculate the Sharing Rules for all the ec_users 
  * This function will recalculate all the sharing rules for all the ec_users in the Organization and will write them in flat ec_files 
  *
 */
function RecalculateSharingRules()
{
	global $log;
	$log->debug("Entering RecalculateSharingRules() method ...");
	global $adb;

	$log->debug("Exiting RecalculateSharingRules method ...");	
				
}



function getDefaultFieldModuleList()
{
	global $log;
	$log->debug("Entering getDefaultFieldModuleList() method ...");
	//changed by dingjianting on 2007-2-28 for new version to support new modules easy
	//$sharingModuleArray=Array('Accounts', 'Leads', 'Contacts', 'Potentials','HelpDesk', 'Emails', 'Campaigns', 'Quotes','PurchaseOrder', 'SalesOrder', 'Invoice');
    global $adb;
	$sql="select distinct ec_field.tabid,name from ec_field inner join ec_tab on ec_field.tabid=ec_tab.tabid where ec_field.tabid not in(7,9,10,29) order by ec_field.tabid";
	$result = $adb->getList($sql);
	$modulelist = array();
	foreach($result as $row)
	{
		$modulelist[] = $row['name'];
	}
	$log->debug("Exit getDefaultFieldModuleList() method ...");
	return $modulelist;				
}		   
?>
