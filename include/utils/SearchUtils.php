<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/CommonUtils.php');
require_once('include/utils/addon_utils.php');



function getColumnOrTableArr($isColumn=true) {
	$column_key = "searchutils_column_array";
	$table_col_key = "searchutils_table_col_array";
	$column_array = getSqlCacheData($column_key);
	$table_col_array = getSqlCacheData($table_col_key);
	if(!$column_array) {
		$column_array = array('accountid','contact_id','contactid','product_id','campaignid',"vendorid","vendor_id","quoteid","salesorderid","purchaseorderid","invoiceid",'potentialid');
		$table_col_array = array('ec_account.accountname','ec_contactdetails.firstname,ec_contactdetails.lastname','ec_contactdetails.firstname,ec_contactdetails.lastname','ec_products.productname','ec_campaign.campaignname','ec_vendor.vendorname','ec_vendor.vendorname','ec_quotes.subject','ec_salesorder.subject','ec_purchaseorder.subject','ec_invoice.subject','ec_potential.potentialname');
		global $adb;
		$query_rel = "SELECT ec_entityname.* FROM ec_entityname inner join ec_tab on ec_entityname.tabid=ec_tab.tabid WHERE ec_tab.reportable='1' and ec_tab.tabid>30";
		$fldmod_result = $adb->query($query_rel);
		$rownum = $adb->num_rows($fldmod_result);
		for($i=0;$i<$rownum;$i++) {
			$rel_tablename = $adb->query_result($fldmod_result,$i,'tablename');
			$rel_entityname = $adb->query_result($fldmod_result,$i,'fieldname');
			$rel_entityid = $adb->query_result($fldmod_result,$i,'entityidfield');
			$column_array[] = $rel_entityid;
			$table_col_array[] = "$rel_tablename.$rel_entityname";
		}
		setSqlCacheData($column_key,$column_array);
		setSqlCacheData($table_col_key,$table_col_array);
	}
	if($isColumn) return $column_array;
	else return $table_col_array;
}

/**This function is used to get the list view header values in a list view during search
*Param $focus - module object
*Param $module - module name
*Param $sort_qry - sort by value
*Param $sorder - sorting order (asc/desc)
*Param $order_by - order by
*Param $relatedlist - flag to check whether the header is for listvie or related list
*Param $oCv - Custom view object
*Returns the listview header values in an array
*/

function getSearchListHeaderValues($focus, $module,$sort_qry='',$sorder='',$order_by='',$relatedlist='',$oCv='')
{
	global $log;
	//changed by dingjianting on 2007-11-05 for php5.2.x
	$log->debug("Entering getSearchListHeaderValues() method ...");
	global $adb;
	global $theme;
	global $app_strings;
	global $mod_strings,$current_user;

	$arrow='';
	$qry = getURLstring($focus);
	$search_header = Array();
	$tabid = getTabid($module);
	//added for ec_customview 27/5
	if($oCv != "" && $oCv)
	{
		if(isset($oCv->list_fields))
		{
			$focus->list_fields = $oCv->list_fields;
			$focus->list_fields_name = $oCv->list_fields_name;
		}
	}
	foreach($focus->list_fields as $name=>$tableinfo)
	{
			$fieldname = $focus->list_fields_name[$name];
			foreach($focus->list_fields[$name] as $tab=>$col)
			{
					if(isset($mod_strings[$name]))
					{
						   $name = $mod_strings[$name];
					}
			}
			if($fieldname!='parent_id')
			{
				$fld_name=$fieldname;
				$search_header[$fld_name]=$name;
			}
	}
	$log->debug("Exiting getSearchListHeaderValues method ...");	
    return $search_header;

}

/**This function is used to get the where condition for search listview query along with url_string
*Param $module - module name
*Returns the where conditions and url_string values in string format
*/

function Search($module)
{	
	global $log;
	$log->debug("Entering Search(".$module.") method ...");
	$url_string='';	
	if(isset($_REQUEST['search_field']) && $_REQUEST['search_field'] !="")
	{
		$search_column=$_REQUEST['search_field'];
	}
	if(isset($_REQUEST['search_text']) && $_REQUEST['search_text']!="")
	{
		$search_string=addslashes(ltrim(rtrim($_REQUEST['search_text'])));
	}
	if(isset($_REQUEST['searchtype']) && $_REQUEST['searchtype']!="")
	{
		$search_type=$_REQUEST['searchtype'];

		if($search_type == "BasicSearch")
		{
			$where=BasicSearch($module,$search_column,$search_string);
		}
		else if ($search_type == "AdvanceSearch")
		{
		}
		else //Global Search
		{
		}
		$url_string = "&search_field=".$search_column."&search_text=".$search_string."&searchtype=BasicSearch";
		if(isset($_REQUEST['type']) && $_REQUEST['type'] != '')
		$url_string .= "&type=".$_REQUEST['type'];
		return $where."#@@#".$url_string;
		$log->debug("Exiting Search method ...");
	}

}

/**This function is used to get user_id's for a given user_name during search
*Param $table_name - ec_tablename
*Param $column_name - columnname
*Param $search_string - searchstring value (username)
*Returns the where conditions for list query in string format
*/

function get_usersid($table_name,$column_name,$search_string)
{
	global $log;
    $log->debug("Entering get_usersid() method ...");
	$user_id = getUserId_Ol($search_string);
	$where = "$table_name.$column_name =".$user_id;	
	$log->debug("Exiting get_usersid method ...");
	return $where;
}

/**This function is used to get where conditions for a given ec_accountid or contactid during search for their respective names
*Param $column_name - columnname
*Param $search_string - searchstring value (username)
*Returns the where conditions for list query in string format
*/


function getValuesforColumns($column_name,$search_string)
{
	global $log;
	$log->debug("Entering getValuesforColumns(".$column_name.",".$search_string.") method ...");
	$column_array = getColumnOrTableArr();
	$table_col_array = getColumnOrTableArr(false);

	for($i=0; $i<count($column_array);$i++)
	{
		if($column_name == $column_array[$i])
		{
			$val=trim($table_col_array[$i]);
			if(empty($val)) return "";
			$explode_column=explode(",",$val);
			$x=count($explode_column);	
			if($x == 1 )
			{
				$where=" $val like '%".$search_string ."%'";
			}
			else 
			{
				$where="(";
				for($j=0;$j<count($explode_column);$j++)
				{
					$where .= $explode_column[$j]." like '%".$search_string."%'";
					if($j != $x-1)
					{
						$where .= " or ";
					}
				}
				$where.=")";
			}
			break 1;
		}
	}
	$log->debug("Exiting getValuesforColumns method ...");
	return $where;
}

/**This function is used to get where conditions in Basic Search
*Param $module - module name
*Param $search_field - columnname/field name in which the string has be searched
*Param $search_string - searchstring value (username)
*Returns the where conditions for list query in string format
*/

function BasicSearch($module,$search_field,$search_string)
{
	 global $log;
     $log->debug("Entering BasicSearch() method ...");
	global $adb;
	$column_array = getColumnOrTableArr();
	$table_col_array = getColumnOrTableArr(false);

	if($search_field =='crmid')
	{
		$column_name='crmid';
		$table_name='ec_crmentity';
		$where = "$table_name.$column_name='".$search_string."'";	
	}else
	{	
		if(empty($search_field)) {
			return "";
		}
		//Check added for tickets by accounts/contacts in dashboard
		$search_field_first = $search_field;
		if($module=='HelpDesk' && ($search_field == 'contactid' || $search_field == 'account_id'))
		{
			$search_field = "parent_id";
		}
		//Check ends
		$tabid = getTabid($module);
		
		$qry="select columnname,tablename from ec_field where tabid='".$tabid."' and (fieldname='".$search_field."' or columnname='".$search_field."')";
		$result = $adb->query($qry);
		$noofrows = $adb->num_rows($result);
		if($noofrows!=0)
		{
			$column_name=$adb->query_result($result,0,'columnname');
			if(empty($column_name)) {
				return "";
			}

			//Check added for tickets by accounts/contacts in dashboard
			if ($column_name == 'parent_id')
		    {
				if ($search_field_first	== 'account_id') $search_field_first = 'accountid';
				if ($search_field_first	== 'contactid') $search_field_first = 'contact_id';
				$column_name = $search_field_first;
			}
			//Check ends
			$table_name=$adb->query_result($result,0,'tablename');
			if($column_name == "smownerid")
			{
				$where = get_usersid($table_name,$column_name,$search_string);
			}//smcreatorid
			elseif($column_name == "smcreatorid")
			{
				$where = get_usersid($table_name,$column_name,$search_string);
			}
			elseif($column_name == "approvedby")
			{
				$where = get_usersid($table_name,$column_name,$search_string);
			}
			elseif($column_name == "approved")
			{
				$search_string = getApproveIdByStatus($search_string);
				$where="$table_name.$column_name = '".$search_string."'";
			}
			elseif($table_name == "ec_activity" && $column_name == "status")
			{
				$where="$table_name.$column_name like '%".$search_string."%' or ec_activity.eventstatus like '%".$search_string."%'";
			}
			elseif($table_name == "ec_pricebook" && $column_name == "active")
			{
				if(stristr($search_string,'yes'))
					$where="$table_name.$column_name = 1";
				if(stristr($search_string,'no'))
					$where="$table_name.$column_name is NULL";
			}
			elseif($table_name == "ec_activity" && $column_name == "status")
			{
				$where="$table_name.$column_name like '%".$search_string."%' or ec_activity.eventstatus like '%".$search_string."%'";
			}
			elseif($column_name == "catalogid")
			{
				$parent_arr = explode("::",$search_string);
				$parent_count = count($parent_arr);				$catalogname = $parent_arr[$parent_count-1];				$where="($table_name.$column_name='".$catalogname."' or ec_catalog.catalogname like '%".$search_string."%' or ec_catalog.parentcatalog like '".$search_string."::%')";			}
			elseif($column_name == "faqcategoryid")
			{
				$parent_arr = explode("::",$search_string);
				$parent_count = count($parent_arr);				$categoryname = $parent_arr[$parent_count-1];				$where="($table_name.$column_name='".$categoryname."' or ec_faqcategory.faqcategoryname like '%".$search_string."%' or ec_faqcategory.parentfaqcategory like '".$search_string."::%')";			}
			elseif($module=='Accounts' && $column_name == "parentid")
			{
				$where=" ec_account2.accountname like '%".$search_string."%' ";
			}

			else if(in_array($column_name,$column_array))
			{
				$where = getValuesforColumns($column_name,$search_string);
			}
            elseif($module=='Accounts' && $column_name == "accountname")
			{
				$where=" (ec_account.accountname like '%".$search_string."%') ";
			}
			else
			{
				$where="$table_name.$column_name like '%".$search_string."%'";
			}
		} else {
			$where= $search_field." like '%".$search_string."'";
		}
	}
	if($_REQUEST['type'] == 'entchar')
	{
		$search = array('Un Assigned','%','like');
		$replace = array('','','=');
		$where= str_replace($search,$replace,$where);
	}
	if($_REQUEST['type'] == 'alpbt')
	{
//	        $where = str_replace_once("%", "", $where);
        $where= $search_field." like '".$search_string."%'";
	}
	$log->debug("Exiting BasicSearch method ...");
	return $where;
}

/**This function is used to get where conditions in Advance Search
*Param $module - module name
*Returns the where conditions for list query in string format
*/

function getAdvSearchfields($module,$column='')
{
	global $log;
    $log->debug("Entering getAdvSearchfields(".$module.") method ...");
	global $current_user;
	//changed by dingjianting on 2007-10-3 for cache HeaderArray
	$key = "OPTION_SET_".$module."_".$column;
	$OPTION_SET = getSqlCacheData($key);
	if(!$OPTION_SET) {
		global $adb;		
		global $mod_strings;	
		$tabid = getTabid($module);
		
		//changed by dingjianting on 2007-9-5 for search function need not hidden fields
		$sql = "select * from ec_field inner join ec_def_org_field on ec_def_org_field.fieldid=ec_field.fieldid";
		$sql.= " where ec_def_org_field.visible=0 and ec_field.tabid=".$tabid." and";
		$sql.= " ec_field.displaytype in (1,2)";
		$sql.= " order by block,sequence";
		
		$result = $adb->query($sql);
		$noofrows = $adb->num_rows($result);
		$block = '';

		for($i=0; $i<$noofrows; $i++)
		{
			$fieldtablename = $adb->query_result($result,$i,"tablename");
			$fieldcolname = $adb->query_result($result,$i,"columnname");
			$block = $adb->query_result($result,$i,"block");
			$fieldtype = $adb->query_result($result,$i,"typeofdata");
			$fieldtype = explode("~",$fieldtype);
			$fieldtypeofdata = $fieldtype[0];
			$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
			//changed by dingjianting on 2006-10-11 for advanced search
			//$fieldlabel = str_replace(" ","_",$fieldlabel);
			if(isset($mod_strings[$fieldlabel])) {
				$fieldlabel = $mod_strings[$fieldlabel];
			}

			if($fieldlabel != 'Related to')
			{
				if ($column==$fieldtablename.".".$fieldcolname)
					$OPTION_SET .= "<option value=\'".$fieldtablename.".".$fieldcolname."\' selected>".$fieldlabel."</option>";
				elseif($fieldlabel == "Product Code")
					$OPTION_SET .= "<option value=\'".$fieldtablename.".".$fieldcolname."\'>".$mod_strings[$fieldlabel]."</option>";
				else
					$OPTION_SET .= "<option value=\'".$fieldtablename.".".$fieldcolname."\'>".$fieldlabel."</option>";
			}
		}
		setSqlCacheData($key,$OPTION_SET);
	}
	$log->debug("Exiting getAdvSearchfields method ...");
	return $OPTION_SET;
}

/**This function is returns the search criteria options for Advance Search
*takes no parameter
*Returns the criteria option in html format
*/

function getcriteria_options($searchop='')
{
	global $log;
	global $app_strings;
	//changed by dingjianting on 2006-10-11 for advanced search
	$log->debug("Entering getcriteria_options() method ...");
	if($searchop==''){
		$CRIT_OPT =$CRIT_OPT = "<option value=\'cts\'>".$app_strings['contains']."</option><option value=\'dcts\'>".$app_strings['does_not_contain']."</option><option value=\'is\'>".$app_strings['equals']."</option><option value=\'isn\'>".$app_strings['not_equal_to']."</option><option value=\'bwt\'>".$app_strings['starts_with']."</option><option value=\'grt\'>".$app_strings['greater_than']."</option><option value=\'lst\'>".$app_strings['less_than']."</option><option value=\'grteq\'>".$app_strings['greater_or_equal']."</option><option value=\'lsteq\'>".$app_strings['less_or_equal']."</option>";
		return $CRIT_OPT;
	}
	$opts=array('cts'=>'','dcts'=>'','is'=>'','isn'=>'','bwt'=>'','grt'=>'','lst'=>'','grteq'=>'','lsteq'=>'');
	foreach($opts as $optkey=>&$optval){
		if($optkey==$searchop) $optval="selected";
	}

	$CRIT_OPT = "<option value=\'cts\' ".$opts['cts']." >".$app_strings['contains']."</option>
	<option value=\'dcts\' ".$opts['dcts']." >".$app_strings['does_not_contain']."</option>
	<option value=\'is\' ".$opts['is']." >".$app_strings['equals']."</option>
	<option value=\'isn\' ".$opts['isn'].">".$app_strings['not_equal_to']."</option>
	<option value=\'bwt\' ".$opts['bwt']." >".$app_strings['starts_with']."</option>
	<option value=\'grt\' ".$opts['grt']." >".$app_strings['greater_than']."</option>
	<option value=\'lst\' ".$opts['lst'].">".$app_strings['less_than']."</option>
	<option value=\'grteq\' ".$opts['grteq']." >".$app_strings['greater_or_equal']."</option>
	<option value=\'lsteq\' ".$opts['lsteq']." >".$app_strings['less_or_equal']."</option>";
	$log->debug("Exiting getcriteria_options method ...");
	return $CRIT_OPT;
}

/**This function is returns the where conditions for each search criteria option in Advance Search
*Param $criteria - search criteria option
*Param $searchstring - search string
*Param $searchfield - ec_fieldname to be search for 
*Returns the search criteria option (where condition) to be added in list query
*/

function getSearch_criteria($criteria,$searchstring,$searchfield)
{
	global $log;
	$log->debug("Entering getSearch_criteria(".$criteria.",".$searchstring.",".$searchfield.") method ...");
	$where_string = '';
	switch($criteria)
	{
		case 'cts':
			$where_string = $searchfield." like '%".$searchstring."%' ";
			if($searchstring == NULL)
			$where_string = $searchfield." is NULL";
			break;
		
		case 'dcts':
			$where_string = $searchfield." not like '%".$searchstring."%' ";
			if($searchstring == NULL)
			$where_string = $searchfield." is not NULL";
			break;
			
		case 'is':
			$where_string = $searchfield." = '".$searchstring."' ";
			if($searchstring == NULL)
			$where_string = $searchfield." is NULL";
			break;
			
		case 'isn':
			$where_string = $searchfield." <> '".$searchstring."' ";
			if($searchstring == NULL)
			$where_string = $searchfield." is not NULL";
			break;
			
		case 'bwt':
			$where_string = $searchfield." like '".$searchstring."%' ";
			if($searchstring == NULL)
			$where_string = $searchfield." is NULL";
			break;

		case 'ewt':
			$where_string = $searchfield." like '%".$searchstring."' ";
			if($searchstring == NULL)
			$where_string = $searchfield." is NULL";
			break;

		case 'grt':
			$where_string = $searchfield." > '".$searchstring."' ";
			break;

		case 'lst':
			$where_string = $searchfield." < '".$searchstring."' ";
			break;

		case 'grteq':
			$where_string = $searchfield." >= '".$searchstring."' ";
			break;

		case 'lsteq':
			$where_string = $searchfield." <= '".$searchstring."' ";
			break;


	}
	$log->debug("Exiting getSearch_criteria method ...");
	return $where_string;
}

/**This function is returns the where conditions for search
*Param $currentModule - module name
*Returns the where condition to be added in list query in string format
*/

function getWhereCondition($currentModule)
{	
	global $log;
	$column_array = getColumnOrTableArr();
	$table_col_array = getColumnOrTableArr(false);
    $log->debug("Entering getWhereCondition(".$currentModule.") method ...");	
	if($_REQUEST['searchtype'] != 'advance')
	{
		$where=Search($currentModule); 
	}
	else 
	{
		$adv_string='';
		$url_string='';
		if(isset($_REQUEST['search_cnt']))
		$tot_no_criteria = $_REQUEST['search_cnt'];
		if($_REQUEST['matchtype'] == 'all')
			$matchtype = "and";
		else
			$matchtype = "or";
			
		for($i=0; $i<$tot_no_criteria; $i++)
		{
			if($i == $tot_no_criteria-1)
			$matchtype= "";
			
			$table_colname = 'Fields'.$i;
			$search_condition = 'Condition'.$i;
			$search_value = 'Srch_value'.$i;
			
			$tab_col = ''; 
			$tab_col = str_replace('\'','',stripslashes($_REQUEST[$table_colname])); 
			$tab_col = str_replace('\\','',$tab_col);  
			$srch_cond = str_replace('\'','',stripslashes($_REQUEST[$search_condition]));
			$srch_cond = str_replace('\\','',$srch_cond); 
			$srch_val = $_REQUEST[$search_value];
			list($tab_name,$column_name) = split("[.]",$tab_col);
			$url_string .="&Fields".$i."=".$tab_col."&Condition".$i."=".$srch_cond."&Srch_value".$i."=".$srch_val;
			if($tab_col == "smownerid")
			{
				$adv_string .= getSearch_criteria($srch_cond,$srch_val,'ec_users.user_name').$matchtype;	
			}
			elseif($tab_col == "smcreatorid")
			{
				$user_id = getUserId_Ol($srch_val);
				$adv_string .= " smcreatorid='".$user_id."' ".$matchtype;
			}
			elseif($tab_col == "approvedby")
			{
				$user_id = getUserId_Ol($srch_val);
				$adv_string .= " approvedby='".$user_id."' ".$matchtype;	
			}
			elseif($tab_col == "approved")
			{
				$srch_val = getApproveIdByStatus($srch_val);
				$adv_string .= " approved='".$srch_val."' ".$matchtype;	
			}
			elseif($tab_col == "ec_activity.status")
			{
				$adv_string .= " (".getSearch_criteria($srch_cond,$srch_val,'ec_activity.status')." or";	
				$adv_string .= " ".getSearch_criteria($srch_cond,$srch_val,'ec_activity.eventstatus')." )".$matchtype;	
			}
			elseif($tab_col == "ec_cntactivityrel.contactid")
			{
				$adv_string .= " (".getSearch_criteria($srch_cond,$srch_val,'ec_contactdetails.firstname')." or";	
				$adv_string .= " ".getSearch_criteria($srch_cond,$srch_val,'ec_contactdetails.lastname')." )".$matchtype;	
			}
			elseif($tab_col == "ec_products.catalogid")
			{
				$adv_string .= getSearch_criteria($srch_cond,$srch_val,'ec_catalog.catalogname')." ".$matchtype;	
			}
			elseif($tab_col == "ec_faq.faqcategoryid")
			{
				$adv_string .= getSearch_criteria($srch_cond,$srch_val,'ec_faqcategory.faqcategoryname')." ".$matchtype;	
			}
			elseif(in_array($column_name,$column_array))
			{
					$adv_string .= getValuesforColumns($column_name,$srch_val)." ".$matchtype;
			}
			else
			{
				$adv_string .= " ".getSearch_criteria($srch_cond,$srch_val,$tab_col)." ".$matchtype;	
			}
		}
		$where="(".$adv_string.")#@@#".$url_string."&searchtype=advance&search_cnt=".$tot_no_criteria."&matchtype=".$_REQUEST['matchtype'];
	}
	/*
	elseif($_REQUEST['type']=='dbrd')
	{
		$where = getdashboardcondition();
	}
	
	else
	{
 		$where=Search($currentModule);
	}
	*/
	$log->info("getWhereCondition method where condition:".$where);
	$log->debug("Exiting getWhereCondition method ...");
	return $where;

}

/**This function is used to replace only the first occurence of a given string
Param $needle - string to be replaced
Param $replace - string to be replaced with
Param $replace - given string
Return type is string
*/
function str_replace_once($needle, $replace, $haystack)
{
	// Looks for the first occurence of $needle in $haystack
	// and replaces it with $replace.
	$pos = strpos($haystack, $needle);
	if ($pos === false) {
		// Nothing found
		return $haystack;
	}
	return substr_replace($haystack, $replace, $pos, strlen($needle));
}

//add by renzhen for save search
function getSearchConditions() {
	$searchopts=array();
	$searchopts['searchtype']=$_REQUEST['searchtype'];
	if($_REQUEST['searchtype'] != 'advance')
	{
		$searchopts['search_field']=$_REQUEST['search_field'];
		$searchopts['search_text']=$_REQUEST['search_text'];
		$searchopts['type']=$_REQUEST['type'];
	}else{
		if(isset($_REQUEST['search_cnt'])) $searchopts['search_cnt'] = $_REQUEST['search_cnt']; 
		$searchopts['matchtype'] = $_REQUEST['matchtype'];
		$searchcons=array();
		for($i=0; $i<$searchopts['search_cnt']; $i++)
		{
			$table_colname = 'Fields'.$i;
			$search_condition = 'Condition'.$i;
			$search_value = 'Srch_value'.$i;

			$tab_col = str_replace('\'','',stripslashes($_REQUEST[$table_colname]));
			$srch_cond = str_replace('\'','',stripslashes($_REQUEST[$search_condition]));
			$srch_val = $_REQUEST[$search_value];
			$searchcons[]=array($tab_col,$srch_cond,$srch_val);
		}
		
		$searchopts['conditions']=$searchcons;
	}

	return $searchopts;
}
?>
