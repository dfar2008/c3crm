<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/CommonUtils.php'); //new
require_once('include/FormValidationUtil.php');


/** This function returns the detail view form ec_field and and its properties in array format.
  * Param $uitype - UI type of the ec_field
  * Param $fieldname - Form ec_field name
  * Param $fieldlabel - Form ec_field label name
  * Param $col_fields - array contains the ec_fieldname and values
  * Param $generatedtype - Field generated type (default is 1)
  * Param $tabid - ec_tab id to which the Field belongs to (default is "")
  * Return type is an array
  */

function getDetailViewOutputHtml($uitype, $fieldname, $fieldlabel, $col_fields,$generatedtype,$tabid='')
{	
	global $log;
	$log->debug("Entering getDetailViewOutputHtml() method ...");
	global $adb;
	global $mod_strings;
	global $app_strings;
	global $current_user;
	//$fieldlabel = from_html($fieldlabel);
	$custfld = '';
	$value ='';
	$arr_data =Array();
	$label_fld = Array();
	$data_fld = Array();
	if($generatedtype == 2) $mod_strings[$fieldlabel] = $fieldlabel;
	if(!isset($mod_strings[$fieldlabel])) {
		$mod_strings[$fieldlabel] = $fieldlabel;
	}
	if($col_fields[$fieldname]=='--None--') $col_fields[$fieldname]='';
    if($uitype == 116)
	{
		$label_fld[] = $mod_strings[$fieldlabel];
        $label_fld[] = $col_fields[$fieldname];
	}
	elseif($uitype == 13)
	{
		$label_fld[] = $mod_strings[$fieldlabel];
		$temp_val = $col_fields[$fieldname];
		$label_fld[] = $temp_val;
		$linkvalue = getComposeMailUrl($temp_val);
		$label_fld["link"] = $linkvalue;
	}
	elseif($uitype == 5 || $uitype == 23 || $uitype == 70)
	{
		$label_fld[] =$mod_strings[$fieldlabel];
		$cur_date_val = $col_fields[$fieldname];

		if(!isValidDate($cur_date_val))
		{
			$display_val = '';	
		}
		else
		{
			$display_val = getDisplayDate($cur_date_val);
		}
		$label_fld[] = $display_val;
	}
	elseif($uitype == 15 || $uitype == 16 || $uitype == 115 || $uitype == 111) //uitype 111 added for non editable picklist - ahmed
	{
	    $label_fld[] = $mod_strings[$fieldlabel];
	    $label_fld[] = $col_fields[$fieldname];
	}
	elseif($uitype == 10)
	{
		if(isset($app_strings[$fieldlabel])) {
			$label_fld[] = $app_strings[$fieldlabel];
		} elseif(isset($mod_strings[$fieldlabel])) {
			$label_fld[] = $mod_strings[$fieldlabel];
		} else {
			$label_fld[] = $fieldlabel;
		}
		$value = $col_fields[$fieldname];
		$module_entityname = "";
		if($value != '')
		{
			$query = "SELECT ec_entityname.* FROM ec_crmentityrel inner join ec_entityname on ec_entityname.modulename=ec_crmentityrel.relmodule inner join ec_tab on ec_tab.name=ec_crmentityrel.module WHERE ec_tab.tabid='".$tabid."' and ec_entityname.entityidfield='".$fieldname."'";
			$fldmod_result = $adb->query($query);
			$rownum = $adb->num_rows($fldmod_result);
			if($rownum > 0) {
				$rel_modulename = $adb->query_result($fldmod_result,0,'modulename');
				$rel_tablename = $adb->query_result($fldmod_result,0,'tablename');
				$rel_entityname = $adb->query_result($fldmod_result,0,'fieldname');
				$rel_entityid = $adb->query_result($fldmod_result,0,'entityidfield');
				$module_entityname = getEntityNameForTen($rel_tablename,$rel_entityname,$fieldname,$value);
			}

		}
		$label_fld[] = $module_entityname;
		$label_fld["secid"] = $value;
		$label_fld["link"] = "index.php?module=".$rel_modulename."&action=DetailView&record=".$value;
	}
	elseif($uitype == 33) //uitype 33 added for multiselector picklist - Jeri
	{
	    $label_fld[] = $mod_strings[$fieldlabel];
	    $label_fld[] = str_ireplace(' |##| ',', ',$col_fields[$fieldname]);
	}
	elseif($uitype == 17)
	{
		$label_fld[] = $mod_strings[$fieldlabel];
		$label_fld[] = $col_fields[$fieldname];
		//$label_fld[] = '<a href="http://'.$col_fields[$fieldname].'" target="_blank">'.$col_fields[$fieldname].'</a>';
	}
	elseif($uitype == 19)
	{
		//$tmp_value = str_replace("&lt;","<",nl2br($col_fields[$fieldname]));
		//$tmp_value = str_replace("&gt;",">",$tmp_value);
		//$col_fields[$fieldname]= make_clickable($tmp_value);
		$label_fld[] = $mod_strings[$fieldlabel];
		$label_fld[] = $col_fields[$fieldname];
	}
	elseif($uitype == 20 || $uitype == 21 || $uitype == 22 || $uitype == 24) // Armando LC<scher 11.08.2005 -> B'descriptionSpan -> Desc: removed $uitype == 19 and made an aditional elseif above
	{
		//$col_fields[$fieldname]=nl2br($col_fields[$fieldname]);
		$label_fld[] = $mod_strings[$fieldlabel];
		$label_fld[] = $col_fields[$fieldname];
	}
	elseif($uitype == 51 || $uitype == 50 || $uitype == 73)
	{
		$account_id = $col_fields[$fieldname];
		$account_name = "";
		if($account_id != '')
		{
			$account_name = getAccountName($account_id);
		}
		//Account Name View
		$label_fld[] = $mod_strings[$fieldlabel];
		$label_fld[] = $account_name;
		$label_fld["secid"] = $account_id;
		$label_fld["link"] = "index.php?module=Accounts&action=DetailView&record=".$account_id;
	}
	elseif($uitype == 52 || $uitype == 77  || $uitype == 101)
	{
		$label_fld[] = $mod_strings[$fieldlabel];
		$user_id = $col_fields[$fieldname];
		$user_name = getUserName($user_id);
		$label_fld[] =$user_name;
	}
	elseif($uitype == 53)
	{
		$user_id = $col_fields[$fieldname];
		$user_name = getUserName($user_id);
		$label_fld[] =$mod_strings[$fieldlabel];
		$label_fld[] =$user_name;

	}
	elseif($uitype == 1004) //display creator in editview page
	{
		if(isset($mod_strings[$fieldlabel])) {
			$label_fld[] = $mod_strings[$fieldlabel];
		} else {
			$label_fld[] = $fieldlabel;
		}
		$value = $col_fields[$fieldname];
		$label_fld[] = getUserName($value);
	}
	elseif($uitype == 56)
	{
		$label_fld[] =$mod_strings[$fieldlabel];
		$value = $col_fields[$fieldname];
		if($value == 1)
		{
			//Since "yes" is not been translated it is given as app strings here..
			$display_val = $app_strings['yes'];
		}
		else
		{
			$display_val = '';
		}
		$label_fld[] = $display_val;
	}
	elseif($uitype == 57)
    {
		 $label_fld[] =$mod_strings[$fieldlabel];
	     $contact_id = $col_fields[$fieldname];
		 $contact_name = "";
	     if(trim($contact_id) != '')
	     {
			   $contact_name = getContactName($contact_id);
	     }
         $label_fld[] = $contact_name;
		 $label_fld["secid"] = $contact_id;
		 $label_fld["link"] = "index.php?module=Contacts&action=DetailView&record=".$contact_id;
    }
	elseif($uitype == 59)
	{
		$label_fld[] =$mod_strings[$fieldlabel];
		$product_id = $col_fields[$fieldname];
		if($product_id != '')
		{
			$product_name = getProductName($product_id);
		}
		//Account Name View
		$label_fld[] = $product_name;
		$label_fld["secid"] = $product_id;
		$label_fld["link"] = "index.php?module=Products&action=DetailView&record=".$product_id;

	}
	elseif($uitype == 71 || $uitype == 72)
	{
		$label_fld[] =$mod_strings[$fieldlabel];
		$display_val = $col_fields[$fieldname];
        $label_fld[] = $display_val;
	}
	
	elseif($uitype == 76)
        {
		 $label_fld[] =$mod_strings[$fieldlabel];
           $potential_id = $col_fields[$fieldname];
           if($potential_id != '')
           {
                   $potential_name = getPotentialName($potential_id);
           }
          $label_fld[] = $potential_name;
		$label_fld["secid"] = $potential_id;
		$label_fld["link"] = "index.php?module=Potentials&action=DetailView&record=".$potential_id;
        }
	elseif($uitype == 80)
        {
		 $label_fld[] =$mod_strings[$fieldlabel];
           $salesorder_id = $col_fields[$fieldname];
           if($salesorder_id != '')
           {
                   $salesorder_name = getSoName($salesorder_id);
           }
          $label_fld[] = $salesorder_name;
		$label_fld["secid"] = $salesorder_id;
		$label_fld["link"] = "index.php?module=SalesOrder&action=DetailView&record=".$salesorder_id;
    }
	elseif($uitype == 85) //Added for Skype by Minnie
	{
		$label_fld[] =$mod_strings[$fieldlabel];
		$label_fld[]= $col_fields[$fieldname];
	}elseif($uitype == 86) //Added for qq by Minnie
	{
		$label_fld[] =$mod_strings[$fieldlabel];
		$label_fld[]= $col_fields[$fieldname];
	}elseif($uitype == 87) //Added for msn by Minnie
	{
		$label_fld[] =$mod_strings[$fieldlabel];
		$label_fld[]= $col_fields[$fieldname];
	}elseif($uitype == 88) //Added for trade by Minnie
	{
		$label_fld[] =$mod_strings[$fieldlabel];
		$label_fld[]= $col_fields[$fieldname];
	}elseif($uitype == 89) //Added for yahoo by Minnie
	{
		$label_fld[] =$mod_strings[$fieldlabel];
		$label_fld[]= $col_fields[$fieldname];
	}
	else
	{
		 $label_fld[] =$mod_strings[$fieldlabel];
		 if($col_fields[$fieldname]=='0') $col_fields[$fieldname]='';
		 $label_fld[] = $col_fields[$fieldname];

	}
	$label_fld[]=$uitype;
	$log->debug("Exiting getDetailViewOutputHtml method ...");
	return $label_fld;
}

/** This function returns the related ec_tab details for a given entity or a module.
* Param $module - module name
* Param $focus - module object
* Return type is an array
*/

function getRelatedLists($module,$focus)
{  
	
	global $log;
	//changed by dingjianting on 2007-11-05 for php5.2.x
	$log->debug("Entering getRelatedLists() method ...");
	$focus_list = array();
	$relatedLists = array();
	global $adb;
	$key = "getRelatedLists_".$module;
	$result = getSqlCacheData($key);
	if(!$result) {		
		$cur_tab_id = getTabid($module);
		$sql1 = "select ec_relatedlists.*,ec_tab.name as related_tabname from ec_relatedlists left join ec_tab on ec_tab.tabid=ec_relatedlists.related_tabid where ec_relatedlists.tabid=".$cur_tab_id." and ec_relatedlists.presence=0 order by sequence";
		$result = $adb->query($sql1);
		setSqlCacheData($key,$result);
	}	
	$num_row = $adb->num_rows($result);
	for($i=0; $i<$num_row; $i++)
	{
		$rel_tab_id = $adb->query_result($result,$i,"related_tabid"); 
		$related_tabname = $adb->query_result($result,$i,"related_tabname"); 
		$function_name = $adb->query_result($result,$i,"name");  
		$label = $adb->query_result($result,$i,"label");
		if(method_exists($focus,$function_name)) {

			if($function_name != "get_generalmodules" && $function_name != "get_child_list" && $function_name != "get_parent_list") {
				$focus_list[$label] = $focus->$function_name($focus->id);
			} else {
				$focus_list[$label] = $focus->$function_name($focus->id,$related_tabname);
			}
		}
		
	}
	/*
	$approvehistory=getApproveHistory($focus->id);
	if($approvehistory!==false){
		$focus_list['审批历史']=$approvehistory;
	}
	*/
	
	$log->debug("Exiting getRelatedLists method ...");
   
	return $focus_list;
}

/** This function returns the detailed block information of a record in a module.
* Param $module - module name
* Param $block - block id
* Param $col_fields - column ec_fields array for the module
* Param $tabid - ec_tab id
* Return type is an array
*/

function getDetailBlockInformation($module, $result,$col_fields,$tabid,$block_label)
{
	global $log;
	//changed by dingjianting on 2007-11-05 for php5.2.x
	$log->debug("Entering getDetailBlockInformation() method ...");
	global $adb;
	global $mod_strings;
	$label_data = Array();
	$returndata = Array();
	$noofrows = $adb->num_rows($result);
	
	for($i=0; $i<$noofrows; $i++)
	{	
		$fieldtablename = $adb->query_result($result,$i,"tablename");
		$fieldcolname = $adb->query_result($result,$i,"columnname");
		$uitype = $adb->query_result($result,$i,"uitype");
		$fieldname = $adb->query_result($result,$i,"fieldname"); 
		$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
		$maxlength = $adb->query_result($result,$i,"maximumlength");
		$block = $adb->query_result($result,$i,"block");
		$generatedtype = $adb->query_result($result,$i,"generatedtype");
		$displaytype = $adb->query_result($result,$i,"displaytype");
		$tabid = $adb->query_result($result,$i,"tabid");
		$custfld = getDetailViewOutputHtml($uitype, $fieldname, $fieldlabel, $col_fields,$generatedtype,$tabid);
		if(is_array($custfld))
		{
			$link = isset($custfld["link"]) ? $custfld["link"] : "";
			$label_data[$block][] = array($custfld[0]=>array("value"=>$custfld[1],"ui"=>$custfld[2],"link"=>$link,"fldname"=>$fieldname));
		}
		$i++; 
		if($i<$noofrows)
		{
			$fieldtablename = $adb->query_result($result,$i,"tablename");
			$fieldcolname = $adb->query_result($result,$i,"columnname");
			$uitype = $adb->query_result($result,$i,"uitype");
			$fieldname = $adb->query_result($result,$i,"fieldname");
			$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
			$maxlength = $adb->query_result($result,$i,"maximumlength");
			$block = $adb->query_result($result,$i,"block");
			$generatedtype = $adb->query_result($result,$i,"generatedtype");
			$displaytype = $adb->query_result($result,$i,"displaytype");
			$tabid = $adb->query_result($result,$i,"tabid"); 
			$custfld = getDetailViewOutputHtml($uitype, $fieldname, $fieldlabel, $col_fields,$generatedtype,$tabid);

			if(is_array($custfld))
			{

				$link = isset($custfld["link"]) ? $custfld["link"] : "";
				$label_data[$block][] = array($custfld[0]=>array("value"=>$custfld[1],"ui"=>$custfld[2],"link"=>$link,"fldname"=>$fieldname));
			}
		}
		
	}  
	foreach($label_data as $headerid=>$value_array)
	{
		$detailview_data = Array();
		for ($i=0,$j=0;$i<count($value_array);$i=$i+2,$j++)
		{
			$key2 = null;
			$keys=array_keys($value_array[$i]);
			$key1=$keys[0];
			if(isset($value_array[$i+1]) && is_array($value_array[$i+1]))
			{
				$keys= array_keys($value_array[$i+1]);
				$key2= $keys[0];
			}
			$value_ke2 = "";
			if(isset($value_array[$i+1][$key2])) {
				$value_ke2 = $value_array[$i+1][$key2];
			}
			$detailview_data[$j]=array($key1 => $value_array[$i][$key1],$key2 => $value_ke2);
		}
		$label_data[$headerid] = $detailview_data;
	}
	foreach($block_label as $blockid=>$label)
	{
		if($label == '')
		{
			if(isset($mod_strings[$curBlock])) {
				$curBlock = $mod_strings[$curBlock];
			}
			$returndata[$curBlock] = array_merge((array)$returndata[$curBlock],(array)$label_data[$blockid]);
		}
		else
		{
			$curBlock = $label;
			if(isset($mod_strings[$label])) {
				$label = $mod_strings[$label];
			}

			if(isset($returndata[$label]) && is_array($returndata[$label])) {
				$returndata_arr = $returndata[$label];
			} else {
				$returndata_arr = array();
			}
			if(isset($label_data[$blockid]) && is_array($label_data[$blockid])) {
				$returndata[$label] = array_merge((array)$returndata_arr,(array)$label_data[$blockid]);
			}
		}
	}
	$log->debug("Exiting getDetailBlockInformation method ...");
	return $returndata;


}

function detailViewNavigation($module,$record,$isNext=false){
	if(isset($_SESSION[$module.'_listquery'])){
		global $list_max_entries_per_page,$adb,$log;
		$query = $_SESSION[$module.'_listquery'];
		/*
		$noofrows = $_SESSION[$module.'_listrows'];
		$start = $_SESSION['lvs'][$module]['start'];
		//Retreive the Navigation array
		$navigation_array = getNavigationValues($start, $noofrows, $list_max_entries_per_page);
		//Postgres 8 fixes
		if( $adb->dbType == "pgsql")
			 $query = fixPostgresQuery( $query, $log, 0);

		$start_rec = $navigation_array['start'];
		$end_rec = $navigation_array['end_val'];
		//limiting the query
		if ($start_rec == 0)
			$limit_start_rec = 0;
		//elseif($start_rec == 1)
		//	$limit_start_rec = 0;
		else
			$limit_start_rec = $start_rec - 1;//for previous record if record is first , then get last of previous page
		//$max_entries = $list_max_entries_per_page + 1;//for next record if record is last , then get first of next page
		$max_entries = $list_max_entries_per_page;
		 if( $adb->dbType == "pgsql")
			 $list_result = $adb->query($query. " OFFSET ".$limit_start_rec." LIMIT ".$max_entries);
		 else {
			 $query = $query. " LIMIT ".$limit_start_rec.",".$max_entries;
			 $list_result = $adb->query($query);
		 }
		 */
		 $list_result = $adb->query($query);
		 $num_row1 = $adb->num_rows($list_result);
		 for($i=0;$i<$num_row1;$i++) {
			 $crmid = $adb->query_result($list_result,$i,"crmid");
			 if($crmid == $record) {
				 if($isNext) {
					 if($i == ($num_row1-1)) {//last record,no next record
						 return false;
					 }
					 $nextcrmid = $adb->query_result($list_result,($i+1),"crmid");
					 return $nextcrmid;
				 } else {
					 if($i == 0) {//first record , no previous record
						return false;
					 }
					 $precrmid = $adb->query_result($list_result,($i-1),"crmid");
					 return $precrmid;
				 }

			 }
		 }
	}
	return false;
}

?>
