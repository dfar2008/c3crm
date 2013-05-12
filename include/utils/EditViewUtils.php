<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/CommonUtils.php'); //new
require_once('include/utils/MultiFieldUtils.php');

/** This function returns the ec_field details for a given ec_fieldname.
  * Param $uitype - UI type of the ec_field
  * Param $fieldname - Form ec_field name
  * Param $fieldlabel - Form ec_field label name
  * Param $maxlength - maximum length of the ec_field
  * Param $col_fields - array contains the ec_fieldname and values
  * Param $generatedtype - Field generated type (default is 1)
  * Param $module_name - module name
  * Return type is an array
  */

function getOutputHtml($uitype, $fieldname, $fieldlabel, $maxlength, $col_fields,$generatedtype,$module_name,$mode='',$mandatory=0,$typeofdata="")
{
	global $log;
	$log->debug("Entering getOutputHtml() method ...");
	global $adb,$log;
	global $theme;
	global $mod_strings;
	global $app_strings;
	global $current_user;
	global $noof_group_rows;


	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	//$fieldlabel = from_html($fieldlabel);
	$fieldvalue = Array();
	$final_arr = Array();
	$value = $col_fields[$fieldname];
	$custfld = '';
	$ui_type[]= $uitype;
	$editview_fldname[] = $fieldname;

	if($generatedtype == 2)
		$mod_strings[$fieldlabel] = $fieldlabel;
	if(!isset($mod_strings[$fieldlabel])) {
		$mod_strings[$fieldlabel] = $fieldlabel;
	}

	if($uitype == 5)
	{	
		if($value=='')
		{
			if($mandatory == 1) {
				$disp_value = getNewDisplayDate();
			}
		}
		else
		{
			$disp_value = getDisplayDate($value);
		}
		$editview_label[] = $mod_strings[$fieldlabel];		
		$fieldvalue[] = $disp_value;
	}
	elseif($uitype == 15 || $uitype == 16 || $uitype == 111) //uitype 111 added for non editable picklist - ahmed
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		//changed by dingjianting on 2007-10-3 for cache pickListResult
		$key = "picklist_array_".$fieldname;
		$picklist_array = getSqlCacheData($key);
		if(!$picklist_array) {
			$pick_query="select colvalue from ec_picklist where colname='".$fieldname."' order by sequence asc";
			$pickListResult = $adb->getList($pick_query);			
			$picklist_array = array();
			foreach($pickListResult as $row) {
				$picklist_array[] = $row['colvalue'];
			}
			
			setSqlCacheData($key,$picklist_array);
		}

		//Mikecrowe fix to correctly default for custom pick lists
		$options = array();
		$found = false;
		foreach($picklist_array as $pickListValue)
		{
			if($value == $pickListValue)
			{
				$chk_val = "selected";	
				$found = true;
			}
			else
			{	
				$chk_val = '';
			}
			$options[] = array($pickListValue=>$chk_val );	
		}
		$fieldvalue [] = $options;
	}
    elseif($uitype == '1021'||$uitype == '1022'||$uitype == '1023'){
        $typearr=explode("::",$typeofdata);
        $multifieldid=$typearr[1];
        $editview_label[]=$mod_strings[$fieldlabel];
        $fieldvalue [] =getMultiFieldEditViewValue($multifieldid,$uitype,$col_fields);
        $fieldvalue [] =$multifieldid;
        //print_r($fieldvalue);
    }
	// Related other module id ,support new module
	/*
		CREATE TABLE ec_crmentityrel (
		`module` VARCHAR( 100 ) NOT NULL ,
		`relmodule` VARCHAR( 100 ) NOT NULL ,
		UNIQUE (`module` ,`relmodule` )
		) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci 
	*/
	elseif($uitype == 10) {
		$query = "SELECT ec_entityname.* FROM ec_crmentityrel inner join ec_entityname on ec_entityname.modulename=ec_crmentityrel.relmodule WHERE ec_crmentityrel.module='".$module_name."' and ec_entityname.entityidfield='".$fieldname."'";
		$fldmod_result = $adb->query($query);
		$rownum = $adb->num_rows($fldmod_result);
		if($rownum > 0) {
			$rel_modulename = $adb->query_result($fldmod_result,0, 'modulename');
			$rel_tablename = $adb->query_result($fldmod_result,0, 'tablename');
			$rel_entityname = $adb->query_result($fldmod_result,0, 'fieldname');
			$rel_entityid = $adb->query_result($fldmod_result,0, 'entityidfield');
		}
		if($value != '')
		{
			$module_entityname = getEntityNameForTen($rel_tablename,$rel_entityname,$fieldname,$value);
		}
		elseif(isset($_REQUEST[$fieldname]) && $_REQUEST[$fieldname] != '')
		{
			if($_REQUEST['module'] == $rel_modulename)
			{
				$module_entityname = '';
			}
			else
			{
				$value = $_REQUEST[$fieldname];
				$module_entityname = getEntityNameForTen($rel_tablename,$rel_entityname,$fieldname,$value);
			}

		}
		if(isset($app_strings[$fieldlabel])) {
			$editview_label[] = $app_strings[$fieldlabel];
		} elseif(isset($mod_strings[$fieldlabel])) {
			$editview_label[] = $mod_strings[$fieldlabel];
		} else {
			$editview_label[] = $fieldlabel;
		}
		$fieldvalue[] = $module_entityname;
		$fieldvalue[] = $value;
		$fieldvalue[] = $rel_entityname;
		$fieldvalue[] = $rel_modulename;
	} // END
	elseif($uitype == 17)
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue [] = $value;
	}
	elseif($uitype == 85) //added for Skype by Minnie
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue [] = $value;
	}
	elseif($uitype == 86) //added for qq by Minnie
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue [] = $value;
	}
	elseif($uitype == 87) //added for msn by Minnie
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue [] = $value;
	}
	elseif($uitype == 88) //added for trade by Minnie
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue [] = $value;
	}
	elseif($uitype == 89) //added for Yahoo by Minnie
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue [] = $value;
	}
	elseif($uitype == 33)
	{
		$pick_query="select colvalue from ec_picklist where colname='".$fieldname."' order by sequence asc";
				$pickListResult = $adb->getList($pick_query);			
				$picklist_array = array();
				foreach($pickListResult as $row) {
					$picklist_array[] = $row['colvalue'];
				}

		$editview_label[]=$mod_strings[$fieldlabel];
		$mulsel="select colvalue from ec_picklist where colname='".$fieldname."' order by sequence asc";
		$multiselect_result = $adb->query($mulsel);
		$noofoptions = $adb->num_rows($multiselect_result);
		$options = array();
		$found = false;
		$valur_arr = explode(' |##| ',$value);
		for($j = 0; $j < $noofoptions; $j++)
		{
			$multiselect_combo = $adb->query_result($multiselect_result,$j,"colvalue");
			if(in_array($multiselect_combo,$valur_arr))
			{
				$chk_val = "selected";
				$found = true;
			}
			else
			{
				$chk_val = '';
			}
			$options[] = array($multiselect_combo=>$chk_val );
		}
		$fieldvalue [] = $options;
	}
	elseif($uitype == 19 || $uitype == 20)
	{
		if(isset($_REQUEST['body']))
		{
			$value = ($_REQUEST['body']);
		}

		$editview_label[]=$mod_strings[$fieldlabel];
		//$value = to_html($value);
		//$value = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
		$fieldvalue [] =  $value;
	}
	elseif($uitype == 21 || $uitype == 24)
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue [] = $value;
	}
	elseif($uitype == 22)
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue[] = $value;
	}
	elseif($uitype == 52)
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		global $current_user;
		if($value != '')
		{
			$assigned_user_id = $value;	
		}
		else
		{
			$assigned_user_id = $current_user->id;
		}
		$combo_lbl_name = 'assigned_user_id';
		if($fieldlabel == 'Assigned To')
		{
			$user_array = get_user_array(FALSE, "Active", $assigned_user_id);
			$users_combo = get_select_options_array($user_array, $assigned_user_id);
		}
		else
		{
			$user_array = get_user_array(FALSE, "Active", $assigned_user_id);
			$users_combo = get_select_options_array($user_array, $assigned_user_id);
		}
		$fieldvalue [] = $users_combo;
	}
	elseif($uitype == 77)
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		global $current_user;
		if($value != '')
		{
			$assigned_user_id = $value;	
		}
		else
		{
			$assigned_user_id = $current_user->id;
		}
		
		$combo_lbl_name = 'assigned_user_id';		
		$user_array = get_user_array(FALSE, "Active", $assigned_user_id);
		$users_combo = get_select_options_array($user_array, $assigned_user_id);
		$fieldvalue [] = $users_combo;
	}
	elseif($uitype == 53)     
	{  
		$editview_label[]=$mod_strings[$fieldlabel];
		global $current_user;
		if($value != '' && $value != 0)
		{
			$assigned_user_id = $value;
	
		}
		else
		{
			$assigned_user_id = $current_user->id;
		}
		
		if($fieldlabel == 'Assigned To')
		{
			$user_array = get_user_array(FALSE, "Active", $assigned_user_id);
			$users_combo = get_select_options_array($user_array, $assigned_user_id);
		}
		else
		{
			$user_array = get_user_array(FALSE, "Active", $assigned_user_id);
			$users_combo = get_select_options_array($user_array, $assigned_user_id);
		}

		$fieldvalue[]=$users_combo;  
	}
	elseif($uitype == 1004) //display creator in editview page
	{
		if(isset($mod_strings[$fieldlabel])) {
			$editview_label[] = $mod_strings[$fieldlabel];
		} else {
			$editview_label[] = $fieldlabel;
		}
		if(empty($value)) {
			global $current_user;
			$value = $current_user->id;
		}
		$fieldvalue[] = getUserName($value);
	}
	elseif($uitype == 1008) //display approvedby in editview page
	{
		if(isset($mod_strings[$fieldlabel])) {
			$editview_label[] = $mod_strings[$fieldlabel];
		} else {
			$editview_label[] = $fieldlabel;
		}
		if(empty($value)) {
			global $current_user;
			$value = $current_user->id;
		}
		$fieldvalue[] = getUserName($value);
	}
	elseif($uitype == 51 || $uitype == 50 || $uitype == 73)
	{
		$account_name = "";
		/*$convertmode = "";
		if(isset($_REQUEST['convertmode']))
		{
			$convertmode = $_REQUEST['convertmode'];
		}
		if($convertmode != 'update_quote_val' && $convertmode != 'update_so_val')
		{
			if(isset($_REQUEST['account_id']) && $_REQUEST['account_id'] != '')
				$value = $_REQUEST['account_id'];	
		}*/
		if(isset($_REQUEST['account_id']) && $_REQUEST['account_id'] != '')
				$value = $_REQUEST['account_id'];	
		
		if($value != '')
		{		
			$account_name = getAccountName($value);	
		}
		
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue[]=$account_name; 
		$fieldvalue[] = $value; 
	}
	elseif($uitype == 54)
	{
		$options =Array();
		if($value == "") {
			$key = "currentuser_group_".$current_user->id;
			$currentuser_group = getSqlCacheData($key);
			if(!$currentuser_group) {
				$query = "select ec_groups.groupname from ec_groups left join ec_users2group on ec_users2group.groupid=ec_groups.groupid where ec_users2group.userid='".$current_user->id."' and ec_users2group.groupid!=0";
				$result = $adb->query($query);
				$noofrows = $adb->num_rows($result);
				if($noofrows > 0) {
					$currentuser_group = $adb->query_result($result,0,"groupname");
				}
				setSqlCacheData($key,$currentuser_group);
			}
			$value = $currentuser_group;
		}
		$key = "picklist_array_group";
		$picklist_array = getSqlCacheData($key);
		if(!$picklist_array) {			
			$pick_query="select * from ec_groups order by groupid";
			$pickListResult = $adb->getList($pick_query);			
			$picklist_array = array();
			foreach($pickListResult as $row) {
				$picklist_array[] = $row["groupname"];
			}			
			setSqlCacheData($key,$picklist_array);
		}
		$editview_label[]=$mod_strings[$fieldlabel];
		foreach($picklist_array as $pickListValue)
		{
			if($value == $pickListValue)
			{
				$chk_val = "selected";	
			}
			else
			{	
				$chk_val = '';	
			}
			$options[] = array($pickListValue => $chk_val );
		}
		$fieldvalue[] = $options;

	}
	elseif($uitype == 59)
	{
		
		if($value != '')
		{		
			$product_name = getProductName($value);	
		}
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue[]=$product_name;
		$fieldvalue[]=$value;
	}
	elseif($uitype == 64)
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		$date_format = parse_calendardate($app_strings['NTC_DATE_FORMAT']);
		$fieldvalue[] = $value;
	}
	elseif($uitype == 56)
	{
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue[] = $value;	
	}
	elseif($uitype == 57)
	{
        $accountid=$col_fields['account_id'];
        if(empty($accountid)){
            $convertmode = "";
            if(isset($_REQUEST['convertmode']))
            {
                $convertmode = $_REQUEST['convertmode'];
            }
            if($convertmode != 'update_quote_val' && $convertmode != 'update_so_val')
            {
                if(isset($_REQUEST['account_id']) && $_REQUEST['account_id'] != '')
                    $accountid = $_REQUEST['account_id'];	
            }
        }
		$contact_name = '';	
//		if(trim($value) != '')
//		{
//			$contact_name = getContactName($value);
//		}
//		elseif(isset($_REQUEST['contact_id']) && $_REQUEST['contact_id'] != '')
//		{
//			if(isset($_REQUEST['module']) && $_REQUEST['module'] == 'Contacts' && $fieldname = 'contact_id')
//			{
//				$contact_name = '';	
//			}
//			else
//			{
//				$value = $_REQUEST['contact_id'];
//				$contact_name = getContactName($value);		
//			}
//
//		}
        if(trim($value) == ''){
            if(isset($_REQUEST['module']) && $_REQUEST['module'] == 'Contacts' && $fieldname = 'contact_id'){
                
            }else{
                $value = $_REQUEST['contact_id'];
            }
        }
        $contactopts=getContactOptions($accountid,$value);

		//Checking for contacts duplicate

		$editview_label[]=$mod_strings[$fieldlabel];
//		$fieldvalue[] = $contact_name;
        $fieldvalue[] = $contactopts;
		$fieldvalue[] = $value;
	}
	elseif($uitype == 76)
	{
		if($value != '')
		{
			$potential_name = getPotentialName($value);
		}
		elseif(isset($_REQUEST['potential_id']) && $_REQUEST['potential_id'] != '')
		{
			$value = $_REQUEST['potental_id'];
			$potential_name = getPotentialName($value);
		}	
		elseif(isset($_REQUEST['potentialid']) && $_REQUEST['potentialid'] != '')
		{
			$value = $_REQUEST['potentalid'];
			$potential_name = getPotentialName($value);
		}
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue[] = $potential_name;
		$fieldvalue[] = $value;
	}

	elseif($uitype == 80)
	{
		if($value != '')
		{
			$salesorder_name = getSoName($value);
		}
		elseif(isset($_REQUEST['salesorder_id']) && $_REQUEST['salesorder_id'] != '')
		{
			$value = $_REQUEST['salesorder_id'];
			$salesorder_name = getSoName($value);
		}		 	
		$editview_label[]=$mod_strings[$fieldlabel];
		$fieldvalue[] = $salesorder_name;
		$fieldvalue[] = $value;
	}
	elseif($uitype == 101)
	{
		$editview_label[]=$mod_strings[$fieldlabel];
        $fieldvalue[] = getUserName($value);
        $fieldvalue[] = $value;
	}
	else
	{
		$editview_label[] = $mod_strings[$fieldlabel];
		$fieldvalue[] = $value;
	}
	$final_arr[]=$ui_type;
	$final_arr[]=$editview_label;
	$final_arr[]=$editview_fldname;
	$final_arr[]=$fieldvalue;
	$log->debug("Exiting getOutputHtml method ...");
	return $final_arr;
}

/** This function returns the detail block information of a record for given block id.
* Param $module - module name
* Param $block - block name
* Param $mode - view type (detail/edit/create)
* Param $col_fields - ec_fields array
* Param $tabid - ec_tab id
* Param $info_type - information type (basic/advance) default ""
* Return type is an object array
*/
/*
 * change by renzhen for support multi approve
 */
function getBlockInformation($module, $result, $col_fields,$tabid,$block_label,$mode,$supportmultiapprove=false)
{
	global $log;
	//changed by dingjianting on 2007-11-05 for php5.2.x
	$log->debug("Entering getBlockInformation() method ...");
	global $adb;
	$editview_arr = Array();
	$returndata = Array();

	global $current_user,$mod_strings;
    
	$noofrows = $adb->num_rows($result);

	for($i=0; $i<$noofrows; $i++)
	{
		$fieldtablename = $adb->query_result($result,$i,"tablename");	
		$fieldcolname = $adb->query_result($result,$i,"columnname");	
		$uitype = $adb->query_result($result,$i,"uitype");	
		$fieldname = $adb->query_result($result,$i,"fieldname");	
		$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
		$block = $adb->query_result($result,$i,"block");
		$maxlength = $adb->query_result($result,$i,"maximumlength");
		$generatedtype = $adb->query_result($result,$i,"generatedtype");
		$typeofdata = $adb->query_result($result,$i,"typeofdata");
        //$multifieldid=$adb->query_result($result,$i,"multifieldid");
		$mandatory = 0;
		if(substr_count($typeofdata,"~M") > 0) {
			$mandatory = 1;
		}
		$readonly = 1;
		$custfld = getOutputHtml($uitype, $fieldname, $fieldlabel, $maxlength, $col_fields,$generatedtype,$module,$mode,$mandatory,$typeofdata);
		$custfld[0][1] = $readonly;
		$custfld[0][2] = $mandatory;
		$editview_arr[$block][]=$custfld;
		//if (isset($mvAdd_flag) && $mvAdd_flag == true) {
		//	$mvAdd_flag = false;
		//}
		$i++;
		if($i<$noofrows)
		{
			$fieldtablename = $adb->query_result($result,$i,"tablename");	
			$fieldcolname = $adb->query_result($result,$i,"columnname");	
			$uitype = $adb->query_result($result,$i,"uitype");	
			$fieldname = $adb->query_result($result,$i,"fieldname");	
			$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
			$block = $adb->query_result($result,$i,"block");
			$maxlength = $adb->query_result($result,$i,"maximumlength");
			$generatedtype = $adb->query_result($result,$i,"generatedtype");
			$typeofdata = $adb->query_result($result,$i,"typeofdata");
            //$multifieldid=$adb->query_result($result,$i,"multifieldid");
			$mandatory = 0;
			if(substr_count($typeofdata,"~M") > 0) {
				$mandatory = 1;
			}
			//added by dingjianting on 2007-2-5 for approve function by read/write permittion
			$readonly = 1;
			
			$custfld = getOutputHtml($uitype, $fieldname, $fieldlabel, $maxlength, $col_fields,$generatedtype,$module,$mode,$mandatory,$typeofdata);
		    $custfld[0][1] = $readonly;
			$custfld[0][2] = $mandatory;
			
			$editview_arr[$block][]=$custfld;
		}
	}
	foreach($editview_arr as $headerid=>$editview_value)
	{
		$editview_data = Array();
		for ($i=0,$j=0;$i<count($editview_value);$i=$i+2,$j++)
		{
			$key1=$editview_value[$i];
			$key2 = null;
			if(isset($editview_value[$i+1]) && is_array($editview_value[$i+1]))
			{
				$key2 = $editview_value[$i+1];
			}
			else
			{
				$key2 = array();
			}
			$editview_data[$j]=array(0 => $key1,1 => $key2);
		}
		$editview_arr[$headerid] = $editview_data;
	}
	foreach($block_label as $blockid=>$label)
	{ 
		
		if($label == '')
		{
			if(isset($mod_strings[$curBlock])) {
				$curBlock = $mod_strings[$curBlock];
			}			$returndata[$curBlock]=array_merge((array)$returndata[$curBlock],(array)$editview_arr[$blockid]);
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
			if(isset($editview_arr[$blockid]) && is_array($editview_arr[$blockid])) {
				//$returndata[$label]=array_merge((array)$returndata[$label],(array)$editview_arr[$blockid]);
				$returndata[$label] = array_merge((array)$returndata_arr,(array)$editview_arr[$blockid]);
			}
		}
	}
	$log->debug("Exiting getBlockInformation method ...");
	return $returndata;	
	
}

/** This function returns the data type of the ec_fields, with ec_field label, which is used for javascript validation.
* Param $validationData - array of ec_fieldnames with datatype
* Return type array 
*/


function split_validationdataArray($validationData)
{
	global $log;
	$log->debug("Entering split_validationdataArray() method ...");
	$fieldName = '';
	$fieldLabel = '';
	$fldDataType = '';
	$rows = count($validationData);
	foreach($validationData as $fldName => $fldLabel_array)
	{
		if($fieldName == '')
		{
			$fieldName="'".$fldName."'";
		}
		else
		{
			$fieldName .= ",'".$fldName ."'";
		}
		foreach($fldLabel_array as $fldLabel => $datatype)
		{
			if($fieldLabel == '')
			{
				$fieldLabel = "'".$fldLabel ."'";
			}
			else
			{
				$fieldLabel .= ",'".$fldLabel ."'";
			}
			if($fldDataType == '')
			{
				$fldDataType = "'".$datatype ."'";
			}
			else
			{
				$fldDataType .= ",'".$datatype ."'";
			}
		}
	}
	$data['fieldname'] = $fieldName;
	$data['fieldlabel'] = $fieldLabel;
	$data['datatype'] = $fldDataType;
	$log->debug("Exiting split_validationdataArray method ...");
	return $data;
}

function getContactOptions($accountid,$contactval){
    global $adb;
    $optionstr="<option value=''></option>";
    if(!empty($accountid)){
        $sql="select ec_contactdetails.contactid,ec_contactdetails.lastname from ec_contactdetails where ec_contactdetails.deleted=0 and ec_contactdetails.accountid='{$accountid}' ";
        $result=$adb->getList($sql);
		foreach($result as $row)
        {
            $selected='';
            $contactid=$row['contactid'];
            $contactname=$row['lastname'];
            if($contactid==$contactval) $selected='selected';
            $optionstr.="<option value='$contactid' $selected>$contactname</option>";
        }
    }
    return $optionstr;
}

?>
