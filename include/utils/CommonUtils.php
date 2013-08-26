<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php'); //new
require_once('include/utils/addon_utils.php'); //new

/**
 * Check if user id belongs to a system admin.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function is_admin($user) {
	global $log;
	global $adb;
	//changed by dingjianting on 2007-11-05 for php5.2.x
	$log->debug("Entering is_admin() method ...");
	if(!$_SESSION['crm_is_admin']) {
		return false;
	} else {
		return true;
	}
}

/**
 * THIS FUNCTION IS DEPRECATED AND SHOULD NOT BE USED; USE get_select_options_with_id()
 * Create HTML to display select options in a dropdown list.  To be used inside
 * of a select statement in a form.
 * param $option_list - the array of strings to that contains the option list
 * param $selected - the string which contains the default value
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_select_options (&$option_list, $selected, $advsearch='false') {
	global $log;
	$log->debug("Entering get_select_options () method ...");
	$log->debug("Exiting get_select_options  method ...");
	return get_select_options_with_id($option_list, $selected, $advsearch);
}

/**
 * Create HTML to display select options in a dropdown list.  To be used inside
 * of a select statement in a form.   This method expects the option list to have keys and values.  The keys are the ids.  The values is an array of the datas
 * param $option_list - the array of strings to that contains the option list
 * param $selected - the string which contains the default value
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_select_options_with_id (&$option_list, $selected_key, $advsearch='false') {
	global $log;
	$log->debug("Entering get_select_options_with_id () method ...");
	$log->debug("Exiting get_select_options_with_id  method ...");
	return get_select_options_with_id_separate_key($option_list, $option_list, $selected_key, $advsearch);
}

/**
 * Create HTML to display select options in a dropdown list.  To be used inside
 * of a select statement in a form.   This method expects the option list to have keys and values.  The keys are the ids.
 * The values are the display strings.
 */
function get_select_options_array (&$option_list, $selected_key, $advsearch='false') {
	global $log;
	$log->debug("Entering get_select_options_array () method ...");
	$log->debug("Exiting get_select_options_array  method ...");
        return get_options_array_seperate_key($option_list, $option_list, $selected_key, $advsearch);
}

/**
 * Create HTML to display select options in a dropdown list.  To be used inside
 * of a select statement in a form.   This method expects the option list to have keys and values.  The keys are the ids.  The value is an array of data
 * param $label_list - the array of strings to that contains the option list
 * param $key_list - the array of strings to that contains the values list
 * param $selected - the string which contains the default value
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_options_array_seperate_key (&$label_list, &$key_list, $selected_key, $advsearch='false') {
	global $log;
	$log->debug("Entering get_options_array_seperate_key () method ...");
	global $app_strings;
	if($advsearch=='true')
	$select_options = "\n<OPTION value=''>--NA--</OPTION>";
	else
	$select_options = "";

	//for setting null selection values to human readable --None--
	$pattern = "/'0?'></";
	$replacement = "''>".$app_strings['LBL_NONE']."<";
	if (!is_array($selected_key)) $selected_key = array($selected_key);

	//create the type dropdown domain and set the selected value if $opp value already exists
	foreach ($key_list as $option_key=>$option_value) {
		$selected_string = '';
		// the system is evaluating $selected_key == 0 || '' to true.  Be very careful when changing this.  Test all cases.
		// The ec_reported bug was only happening with one of the ec_users in the drop down.  It was being replaced by none.
		if (($option_key != '' && $selected_key == $option_key) || ($selected_key == '' && $option_key == '') || (in_array($option_key, $selected_key)))
		{
			$selected_string = 'selected';
		}

		$html_value = $option_key;

		$select_options .= "\n<OPTION ".$selected_string."value='$html_value'>$label_list[$option_key]</OPTION>";
		$options[$html_value]=array($label_list[$option_key]=>$selected_string);
	}
	$select_options = preg_replace($pattern, $replacement, $select_options);

	$log->debug("Exiting get_options_array_seperate_key  method ...");
	return $options;
}

/**
 * Create HTML to display select options in a dropdown list.  To be used inside
 * of a select statement in a form.   This method expects the option list to have keys and values.  The keys are the ids.
 * The values are the display strings.
 */

function get_select_options_with_id_separate_key(&$label_list, &$key_list, $selected_key, $advsearch='false')
{
	global $log;
    $log->debug("Entering get_select_options_with_id_separate_key() method ...");
	if (!is_array($key_list)) {
		return '';
	}
    global $app_strings;
    if($advsearch=='true')
		$select_options = "\n<OPTION value=''>--NA--</OPTION>";
    else
		$select_options = "";

    $pattern = "/'0?'></";
    $replacement = "''>".$app_strings['LBL_NONE']."<";
    if (!is_array($selected_key)) $selected_key = array($selected_key);

    foreach ($key_list as $option_key=>$option_value) {
        $selected_string = '';
        if (($option_key != '' && $selected_key == $option_key) || ($selected_key == '' && $option_key == '') || (in_array($option_key, $selected_key)))
        {
            $selected_string = 'selected ';
        }

        $html_value = $option_key;

        $select_options .= "\n<OPTION ".$selected_string."value='$html_value'>$label_list[$option_key]</OPTION>";
    }
    $select_options = preg_replace($pattern, $replacement, $select_options);
    $log->debug("Exiting get_select_options_with_id_separate_key method ...");
    return $select_options;

}

/**
 * Converts localized date format string to jscalendar format
 * Example: $array = array_csort($array,'town','age',SORT_DESC,'name');
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function parse_calendardate($local_format) {
	global $log;
	$log->debug("Entering parse_calendardate() method ...");
	global $current_user;
	if($current_user->date_format == 'dd-mm-yyyy')
	{
		$dt_popup_fmt = "%d-%m-%Y";
	}
	elseif($current_user->date_format == 'mm-dd-yyyy')
	{
		$dt_popup_fmt = "%m-%d-%Y";
	}
	elseif($current_user->date_format == 'yyyy-mm-dd')
	{
		$dt_popup_fmt = "%Y-%m-%d";
	}
	$log->debug("Exiting parse_calendardate method ...");
	return $dt_popup_fmt;
	//return "%Y-%m-%d";
}

/**
 * Decodes the given set of special character
 * input values $string - string to be converted, $encode - flag to decode
 * returns the decoded value in string fromat
 */

function from_html($string, $encode=true){
	global $log;
	$log->debug("Entering from_html() method ...");
	global $toHtml;
	$string = trim($string);
	//if($encode && is_string($string))$string = html_entity_decode($string, ENT_QUOTES);
	if($encode && is_string($string)){
			$string = str_replace(array_values($toHtml), array_keys($toHtml), $string);
	}
	$log->debug("Exiting from_html method ...");
    return $string;
}

/**
 *	Function used to decodes the given single quote and double quote only. This function used for popup selection
 *	@param string $string - string to be converted, $encode - flag to decode
 *	@return string $string - the decoded value in string fromat where as only single and double quotes will be decoded
 */

function popup_from_html($string, $encode=true)
{
	global $log;
	$log->debug("Entering popup_from_html() method ...");

	$popup_toHtml = array(
        			'"' => '&quot;',
			        "'" =>  '&#039;',
			     );

        //if($encode && is_string($string))$string = html_entity_decode($string, ENT_QUOTES);
        if($encode && is_string($string))
	{
                $string = addslashes(str_replace(array_values($popup_toHtml), array_keys($popup_toHtml), $string));
        }

	$log->debug("Exiting popup_from_html method ...");
        return $string;
}

/**
 * Function to get the tabid
 * Takes the input as $module - module name
 * returns the tabid, integer type
 */

function getTabid($module)
{
	global $log;
	$log->debug("Entering getTabid() method ...");
	//changed by dingjianting on 2006-12-17 for simplized calendar usage
	if($module == "Calendar") $module = "Events";
	$key = "moduletabid_".$module;
	$tabid = getSqlCacheData($key);
	if(!$tabid) {

		global $adb;
		$sql = "select tabid from ec_tab where name='".$module."'";
		$result = $adb->query($sql);
		$tabid=  $adb->query_result($result,0,"tabid");
		setSqlCacheData($key,$tabid);
	}
	$log->debug("Exiting getTabid method ...");
	return $tabid;

}

/**
 * Function to get the tabid
 * Takes the input as $module - module name
 * returns the tabid, integer type
 */

function getSalesEntityType($crmid)
{
	global $log;
	$log->debug("Entering getSalesEntityType() method ...");
	$parent_module = "";
	if($crmid != "") {
		$log->info("in getSalesEntityType ".$crmid);
		global $adb;
		$sql = "select setype from ec_crmentity where crmid=".$crmid;
		$result = $adb->query($sql);
		$parent_module = $adb->query_result($result,0,"setype");
	}
	$log->debug("Exiting getSalesEntityType method ...");
	return $parent_module;
}

/**
 * Function to get the AccountName when a ec_account id is given
 * Takes the input as $acount_id - ec_account id
 * returns the ec_account name in string format.
 * changed by chengliang on 2012-04-05
 */

function getAccountName($account_id)
{
	global $log; 
	$log->debug("Entering getAccountName() method ...");
	global $adb;
	if($account_id != '')
	{
		$account_idarr = explode(",",$account_id);
		if(count($account_idarr) >1){
			$query = "select accountid,accountname from ec_account where accountid in ({$account_id}) and deleted=0";
			$row = $adb->getList($query);
			if(!empty($row)){
				$entries = array();
				foreach($row as $rw){
					$accountid = $rw['accountid'];
					$entries[$accountid] = $rw['accountname'];
				}
				$log->debug("Exiting getAccountName method ...");
				return $entries;
			}else{
				$log->debug("Exiting getAccountName method ...");
				return '';	
			}
		}else{
			$query = "select accountname from ec_account where accountid={$account_id} and deleted=0";
			$row = $adb->getFirstLine($query);
			if(!empty($row)){
				$accountname  = $row['accountname'];
				$log->debug("Exiting getAccountName method ...");
				return $accountname;
			}else{
				$log->debug("Exiting getAccountName method ...");
				return '';	
			}
		}
		
		
		
		$sql = "select accountname from ec_account where accountid=".$account_id;
        $result = $adb->query($sql);
		$accountname = $adb->query_result($result,0,"accountname");
		
	}
	$log->debug("Exiting getAccountName method ...");
	return $accountname;
}

/**
 * Function to get the SettingName when a ec_sfasettings id is given
 * Takes the input as $sfasettingsid - ec_sfasettings id
 * returns the ec_sfasettings name in string format.
 * add by chenglaing on 2012-04-05
 */
function getSettingName($sfasettingsid){
	global $adb;	
	global $current_user;
	global $log; 
	$log->debug("Entering getSettingName() method ...");
	if(empty($sfasettingsid)){
		$log->debug("Exiting getSettingName method ...");
		return '';
	}
	
	$sfasettingsidarr = explode(",",$sfasettingsid);
	if(count($sfasettingsidarr) >1){
		$query = "select sfasettingsid,sfasettingname from ec_sfasettings where sfasettingsid in ({$sfasettingsid}) and deleted=0";
		$row = $adb->getList($query);
		if(!empty($row)){
			$entries = array();
			foreach($row as $rw){
				$sfasettingsid = $rw['sfasettingsid'];
				$entries[$sfasettingsid] = $rw['sfasettingname'];
			}
			$log->debug("Exiting getSettingName method ...");
			return $entries;
		}else{
			$log->debug("Exiting getSettingName method ...");
			return '';	
		}
	}else{
		$query = "select sfasettingname from ec_sfasettings where sfasettingsid={$sfasettingsid} and smownerid='".$current_user->id."' and deleted=0";
		$row = $adb->getFirstLine($query);
		if(!empty($row)){
			$sfasettingname  = $row['sfasettingname'];
			$log->debug("Exiting getSettingName method ...");
			return $sfasettingname;
		}else{
			$log->debug("Exiting getSettingName method ...");
			return '';	
		}
	}
}

/**
 * Function to get the ProductName when a product id is given
 * Takes the input as $product_id - product id
 * returns the product name in string format.
 */

function getProductName($product_id)
{
	global $log;
	$log->debug("Entering getProductName() method ...");
	$productname = "";
	if($product_id != "") {
		global $adb;
		$sql = "select productname from ec_products where productid=".$product_id;
			$result = $adb->query($sql);
		$productname = $adb->query_result($result,0,"productname");
	}
	$log->debug("Exiting getProductName method ...");
	return $productname;
}

/**
 * Function to get the Potentail Name when a ec_potential id is given
 * Takes the input as $potential_id - ec_potential id
 * returns the ec_potential name in string format.
 */

function getPotentialName($potential_id)
{
	global $log;
	$log->debug("Entering getPotentialName() method ...");

	global $adb;
	$potentialname = '';
	if($potential_id != '')
	{
		$sql = "select potentialname from ec_potential where potentialid=".$potential_id;
        	$result = $adb->query($sql);
		$potentialname = $adb->query_result($result,0,"potentialname");
	}
	$log->debug("Exiting getPotentialName method ...");
	return $potentialname;
}

/**
 * Function to get the Contact Name when a contact id is given
 * Takes the input as $contact_id - contact id
 * returns the Contact Name in string format.
 */

function getContactName($contact_id)
{
	global $log;
	$log->debug("Entering getContactName() method ...");
	$contact_name = "";
	if($contact_id != "") {
		global $adb;
		$sql = "select firstname,lastname from ec_contactdetails where contactid=".$contact_id;
		$result = $adb->query($sql);
		$firstname = $adb->query_result($result,0,"firstname");
		$lastname = $adb->query_result($result,0,"lastname");
		//changed by dingjianting on 2006-11-9 for simplized chinese
		//$contact_name = $lastname.' '.$firstname;
		$contact_name = $firstname.$lastname;
	}
	$log->debug("Exiting getContactName method ...");
	return $contact_name;
}

function getMainContactName($accountid)
{
	global $log;
	$log->debug("Entering getMainContactName() method ...");
	$contact_name = "";
	if($accountid != "") {
		global $adb;
		$sql = "select firstname,lastname from ec_contactdetails where deleted=0 and ismain='1' and accountid=".$accountid;
		$result = $adb->query($sql);
		$noofrows = $adb->num_rows($result);
		if($noofrows > 0) {
			$firstname = $adb->query_result($result,0,"firstname");
			$lastname = $adb->query_result($result,0,"lastname");
			$contact_name = $firstname.$lastname;
		} else {
			$sql = "select firstname,lastname from ec_contactdetails where deleted=0 and accountid=".$accountid;
			$result = $adb->query($sql);
			$noofrows = $adb->num_rows($result);
			if($noofrows > 0) {
				$firstname = $adb->query_result($result,0,"firstname");
				$lastname = $adb->query_result($result,0,"lastname");
				$contact_name = $firstname.$lastname;
			}
		}
	}
	$log->debug("Exiting getMainContactName method ...");
	return $contact_name;
}

function getContactPhone($contact_id)
{
	global $log;
	$log->debug("Entering getContactPhone() method ...");
	$phone = "";
	if($contact_id != "") {
		global $adb;
		$sql = "select phone from ec_contactdetails where contactid=".$contact_id;
		$result = $adb->query($sql);
		$phone = $adb->query_result($result,0,"phone");
	}
	$log->debug("Exiting getContactPhone method ...");
	return $phone;
}
function getContactMBPhone($contact_id)
{
	global $log;
	$log->debug("Entering getContactMBPhone() method ...");
	$phone = "";
	if($contact_id != "") {
		global $adb;
		$sql = "select mobile from ec_contactdetails where contactid=".$contact_id;
		$result = $adb->query($sql);
		$phone = $adb->query_result($result,0,"mobile");
	}
	$log->debug("Exiting getContactMBPhone method ...");
	return $phone;
}
/**
 * Function to get the Sales Order Name when a ec_salesorder id is given
 * Takes the input as $salesorder_id - ec_salesorder id
 * returns the Salesorder Name in string format.
 */

function getSoName($so_id)
{
	global $log;
	$log->debug("Entering getSoName() method ...");
	$so_name = "";
	$so_id = trim($so_id );
	if($so_id != "") {
		global $adb;
		$sql = "select subject from ec_salesorder where salesorderid=".$so_id;
		$result = $adb->query($sql);
		$so_name = $adb->query_result($result,0,"subject");
	}
	$log->debug("Exiting getSoName method ...");
	return $so_name;
}

/**
 * Get the username by giving the user id.   This method expects the user id
 */

function getUserName($userid)
{
	global $log;
	$log->debug("Entering getUserName() method ...");
	$userid = trim($userid);
	//$key = "usernamelist";
	//$userNameList = getSqlCacheData($key);
	//if(!$userNameList) {
		global $adb;
		$query = "select id,user_name from ec_users order by id";
		$result = $adb->getList($query);
		$userNameList = array();
		foreach($result as $row) {
			$userNameList[$row['id']] = $row['user_name'];
		}
		//setSqlCacheData($key,$userNameList);
	//}
	$log->debug("Exiting getUserName method ...");
	if(isset($userNameList[$userid])) return $userNameList[$userid];
	else return "";
}

/**	Function to get the user Email id based on column name and column value
  *	$name -- column name of the ec_users ec_table
  *	$val  -- column value
  */
function getUserEmailId($name,$val)
{
	global $adb,$log;
	$log->debug("Inside the function getUserEmailId");
	if($val != '')
	{
		$sql = "select email1 from ec_users where ".$name." = ".$adb->quote($val);
		$res = $adb->query($sql);
		$email = $adb->query_result($res,0,'email1');
		$log->debug("Email id is selected");
		return $email;
	}
	else
	{
		$log->debug("User id is empty. so return value is ''");
		return '';
	}
}

/**
* Get the user full name by giving the user id.   This method expects the user id
* DG 30 Aug 2006
*/

function getUserFullName($userid)
{
	global $log;
	$log->debug("Entering getUserFullName() method ...");
	$userid = trim($userid);
	//$key = "userfullnamelist";
	//$userNameList = getSqlCacheData($key);
	//if(!$userNameList) {
		global $adb;
		$query = "select id,last_name from ec_users order by id";
		$result = $adb->getList($query);
		$userNameList = array();
		foreach($result as $row) {
			$userNameList[$row['id']] = $row['last_name'];
		}
		//setSqlCacheData($key,$userNameList);
	//}
	$log->debug("Exiting getUserFullName method ...");
	if(isset($userNameList[$userid])) return $userNameList[$userid];
	else return "";
}

/**
 * Creates and returns database query. To be used for search and other text links.   This method expects the module object.
 * param $focus - the module object contains the column ec_fields
 */

function getURLstring($focus)
{
	global $log;
	//changed by dingjianting on 2007-11-05 for php5.2.x
	$log->debug("Entering getURLstring() method ...");
	$qry = "";
	foreach($focus->column_fields as $fldname=>$val)
	{
		if(isset($_REQUEST[$fldname]) && $_REQUEST[$fldname] != '')
		{
			if($qry == '')
			$qry = "&".$fldname."=".$_REQUEST[$fldname];
			else
			$qry .="&".$fldname."=".$_REQUEST[$fldname];
		}
	}
	if(isset($_REQUEST['current_user_only']) && $_REQUEST['current_user_only'] !='')
	{
		$qry .="&current_user_only=".$_REQUEST['current_user_only'];
	}
	if(isset($_REQUEST['advanced']) && $_REQUEST['advanced'] =='true')
	{
		$qry .="&advanced=true";
	}

	if($qry !='')
	{
		$qry .="&query=true";
	}
	$log->debug("Exiting getURLstring method ...");
	return $qry;

}

/** This function returns the date in user specified format.
  * param $cur_date_val - the default date format
 */

function getDisplayDate($cur_date_val)
{
	global $log;
	$log->debug("Entering getDisplayDate() method ...");
	global $current_user;
	$dat_fmt = $current_user->date_format;
	if($dat_fmt == '')
	{
		//changed by dingjianting on 2006-12-4 for simplized chinese dateformat
		$dat_fmt = 'yyyy-mm-dd';
	}

	$date_value = explode(' ',$cur_date_val);
	if(!isValidDate($date_value[0])) {
		return "";
	}
	list($y,$m,$d) = explode('-',$date_value[0]);
	if($dat_fmt == 'yyyy-mm-dd')
	{

		$display_date = $y.'-'.$m.'-'.$d;
	}
	elseif($dat_fmt == 'dd-mm-yyyy')
	{
		$display_date = $d.'-'.$m.'-'.$y;
	}
	elseif($dat_fmt == 'mm-dd-yyyy')
	{

		$display_date = $m.'-'.$d.'-'.$y;
	}
	if(isset($date_value[1]) && $date_value[1] != "" && substr_count($date_value[1],'00:00:00') == 0)
	{
		$display_date = $display_date.' '.$date_value[1];
	}
	$log->debug("Exiting getDisplayDate method ...");
	return $display_date;

}

function isValidDate($dateValue) {
	if(!empty($dateValue) && substr_count($dateValue,"0000-00-00") == 0 && substr_count($dateValue,"1900-01-01") == 0) {
		return true;
	}
	return false;

}

/** This function returns the date in user specified format.
  * param $cur_date_val - the default date format
 */

function getDisplayDate_WithTime($cur_date_val)
{
	global $log;
	$log->debug("Entering getDisplayDate_WithTime(".$cur_date_val.") method ...");
	global $current_user;
	$dat_fmt = $current_user->date_format;
	if($dat_fmt == '')
	{
		//changed by dingjianting on 2006-12-4 for simplized chinese dateformat
		$dat_fmt = 'yyyy-mm-dd';
	}

		$date_value = explode(' ',$cur_date_val);
		list($y,$m,$d) = explode('-',$date_value[0]);
		if($dat_fmt == 'dd-mm-yyyy')
		{
			$display_date = $d.'-'.$m.'-'.$y;
		}
		elseif($dat_fmt == 'mm-dd-yyyy')
		{

			$display_date = $m.'-'.$d.'-'.$y;
		}
		elseif($dat_fmt == 'yyyy-mm-dd')
		{

			$display_date = $y.'-'.$m.'-'.$d;
		}

    $log->debug("Exiting getDisplayDate_WithTime method ...");
	return $display_date;

}

/** This function returns the date in user specified format.
  * Takes no param, receives the date format from current user object
  */

function getNewDisplayDate()
{
	global $log;
	$log->debug("Entering getNewDisplayDate() method ...");
	global $current_user;
	$dat_fmt = $current_user->date_format;
	if($dat_fmt == '')
        {
		        //changed by dingjianting on 2006-12-4 for simplized chinese dateformat
                $dat_fmt = 'yyyy-mm-dd';
        }
	//echo $dat_fmt;
	//echo '<BR>';
	$display_date='';
	if($dat_fmt == 'dd-mm-yyyy')
	{
		$display_date = date('d-m-Y');
	}
	elseif($dat_fmt == 'mm-dd-yyyy')
	{
		$display_date = date('m-d-Y');
	}
	elseif($dat_fmt == 'yyyy-mm-dd')
	{
		$display_date = date('Y-m-d');
	}

	//echo $display_date;
	$log->debug("Exiting getNewDisplayDate method ...");
	return $display_date;
}

function ec_number_format($number,$isEdit=false) {
	global $default_number_digits;
	global $default_number_grouping_seperator;
	global $default_number_decimal_seperator;
	if($isEdit) {
		$grouping_seperator = '';
	} else {
		if(isset($default_number_grouping_seperator) && $default_number_grouping_seperator != '') {
			$grouping_seperator = $default_number_grouping_seperator;
		} else {
			$grouping_seperator = ',';
		}

	}
	if(isset($default_number_digits)) {
		$number = number_format($number,$default_number_digits,$default_number_decimal_seperator,$grouping_seperator);
	} else {
		$number = number_format($number,2,'.',$grouping_seperator);
	}
	return $number;
}

/** This function returns a string with removed new line character, single quote, and back slash double quoute.
  * param $str - string to be converted.
  */

function br2nl($str) {
   global $log;
   $log->debug("Entering br2nl() method ...");
   $str = preg_replace("/(\r\n)/", " ", $str);
   $str = preg_replace("/'/", " ", $str);
   $str = preg_replace("/\"/", " ", $str);
   $log->debug("Exiting br2nl method ...");
   return $str;
}

/** This function returns a text, which escapes the html encode for link tag/ a href tag
*param $text - string/text
*/

function make_clickable($text)
{
   global $log;
   $log->debug("Entering make_clickable() method ...");
   $text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1&#058;", $text);
   // pad it with a space so we can match things at the start of the 1st line.
   $ret = ' ' . $text;

   // matches an "xxxx://yyyy" URL at the start of a line, or after a space.
   // xxxx can only be alpha characters.
   // yyyy is anything up to the first space, newline, comma, double quote or <
   $ret = preg_replace("#(^|[\n ])([\w]+?://.*?[^ \"\n\r\t<]*)#is", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);

   // matches a "www|ftp.xxxx.yyyy[/zzzz]" kinda lazy URL thing
   // Must contain at least 2 dots. xxxx contains either alphanum, or "-"
   // zzzz is optional.. will contain everything up to the first space, newline,
   // comma, double quote or <.
   $ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\-]+\.[\w\-.\~]+(?:/[^ \"\t\n\r<]*)?)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);

   // matches an email@domain type address at the start of a line, or after a space.
   // Note: Only the followed chars are valid; alphanums, "-", "_" and or ".".
   $ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);

   // Remove our padding..
   $ret = substr($ret, 1);

   //remove comma, fullstop at the end of url
   $ret = preg_replace("#,\"|\.\"|\)\"|\)\.\"|\.\)\"#", "\"", $ret);

   $log->debug("Exiting make_clickable method ...");
   return($ret);
}
/**
 * This function returns the ec_blocks and its related information for given module.
 * Input Parameter are $module - module name, $disp_view = display view (edit,detail or create),$mode - edit, $col_fields - * column ec_fields/
 * This function returns an array
 */
/*
 * changed by renzhen for support multi approvement
 */
function getBlocks($module,$disp_view,$mode,$col_fields='',$info_type='',$crmid='')
{
	global $log;
	$log->debug("Entering getBlocks() method ...");
	global $adb,$current_user;
	global $mod_strings;
	$tabid = getTabid($module);
	$block_detail = Array();
	$getBlockinfo = "";
	$prev_header = "";
	//block cache on 2008-12-23 for performance by dingjianting
	$key2 = "block_label_".$tabid;
	$block_label = getSqlCacheData($key2);
	if(!$block_label) {
		$block_label = array();
		$query="select blockid,blocklabel,show_title from ec_blocks where tabid=$tabid and visible = 0 order by sequence";
		$result = $adb->query($query);
		$noofrows = $adb->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
			$blockid = $adb->query_result($result,$i,"blockid");
			$block_label[$blockid] = $adb->query_result($result,$i,"blocklabel");
		}
		setSqlCacheData($key2,$block_label);
	}
	$key = "blockview_list_".$tabid."_".$disp_view."_".$mode."_".$info_type;
	//detailview blockview_list_6_detail_view__
	$blockviewList = getSqlCacheData($key);
	if(!$blockviewList) {
		if($mode == 'edit')
		{
			$display_type_check = 'ec_field.displaytype = 1';
		}else
		{
			$display_type_check = 'ec_field.displaytype in (1,4)';
		}
		if($disp_view == "detail_view")
		{			
				$sql = "SELECT ec_field.* FROM ec_field INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid AND ec_def_org_field.visible=0 WHERE ec_field.tabid=".$tabid." AND ec_field.block IN (select blockid from ec_blocks where tabid=".$tabid." and visible = 0) AND ec_field.displaytype IN (1,2,4) ORDER BY block,sequence";
		}
		else
		{
			if ($info_type != '')
			{
					$sql = "SELECT ec_field.* FROM ec_field INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid AND ec_def_org_field.visible=0 WHERE ec_field.tabid=".$tabid." AND ec_field.block IN (select blockid from ec_blocks where tabid=".$tabid." and visible = 0) AND ".$display_type_check." AND info_type = '".$info_type."' ORDER BY block,sequence";

			}
			else
			{
				$sql = "SELECT ec_field.* FROM ec_field INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid AND ec_def_org_field.visible=0 WHERE ec_field.tabid=".$tabid." AND ec_field.block IN (select blockid from ec_blocks where tabid=".$tabid." and visible = 0) AND ".$display_type_check." ORDER BY block,sequence";
				
			}

		}
		$blockviewList = $adb->query($sql);
		setSqlCacheData($key,$blockviewList);
	}

	if($disp_view == "detail_view")
	{
		
		$getBlockInfo=getDetailBlockInformation($module,$blockviewList,$col_fields,$tabid,$block_label);

	}
	else
	{
        $getBlockInfo=getBlockInformation($module,$blockviewList,$col_fields,$tabid,$block_label,$mode,$supportmultiapprove);
	}

	$index_count =1;
	$max_index =0;
	if(!isset($getBlockInfo)) {
		$getBlockInfo = array();
	}
	foreach($getBlockInfo as $label=>$contents)
	{
			$no_rows = count($contents);
			$index_count = $max_index+1;
		foreach($contents as $block_row => $elements)
		{
			$max_index= $no_rows+$index_count;

			for($i=0;$i<count($elements);$i++)
			{
				if(isset($getBlockInfo[$label][$block_row][$i]) && sizeof($getBlockInfo[$label][$block_row][$i])!=0)
				{
					if($i==0)
					$getBlockInfo[$label][$block_row][$i][]=array($index_count);
					else
					$getBlockInfo[$label][$block_row][$i][]=array($max_index);
				}
			}
			$index_count++;

		}
	}
	$log->debug("Exiting getBlocks method ...");
	//print_r($getBlockInfo);die;
	return $getBlockInfo;
}

/**
 * This function returns the ec_blocks and its related information for given module.
 * Input Parameter are $module - module name, $disp_view = display view (edit,detail or create),$mode - edit, $col_fields - * column ec_fields/
 * This function returns an array
 */
/*
 * changed by renzhen for support multi approvement
 */
function getDetailBlocks($module,$col_fields)
{
	global $log;
	$log->debug("Entering getDetailBlocks() method ...");
	global $adb,$current_user;
	global $mod_strings;
	$tabid = getTabid($module);
	$block_detail = Array();
	$getBlockinfo = "";
	$prev_header = "";

	//block cache on 2008-12-23 for performance by dingjianting
	$key = "blockid_list_".$tabid."_".$disp_view;
	$key2 = "block_label_".$tabid."_".$disp_view;
	$blockid_list = getSqlCacheData($key);
	$block_label = getSqlCacheData($key2);
	if(!$blockid_list || !$block_label) {
		$query="select blockid,blocklabel,show_title from ec_blocks where tabid=$tabid and detail_view=0 and visible = 0 order by sequence";
		$result = $adb->query($query);
		$noofrows = $adb->num_rows($result);
		$blockid_list ='(';
		for($i=0; $i<$noofrows; $i++)
		{
			$blockid = $adb->query_result($result,$i,"blockid");
			if($i != 0) {
				$blockid_list .= ', ';
			}
			$blockid_list .= $blockid;
			$block_label[$blockid] = $adb->query_result($result,$i,"blocklabel");
		}
		$blockid_list .= ')';
		setSqlCacheData($key,$blockid_list);
		setSqlCacheData($key2,$block_label);
	}
	$key = "blockview_sql_".$tabid."_detail_view";
	$sql = getSqlCacheData($key);
	if(!$sql) {
		$display_type_check = 'ec_field.displaytype in (1,4)';
		$sql = "SELECT ec_field.* FROM ec_field INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid AND ec_def_org_field.visible=0 WHERE ec_field.tabid=".$tabid." AND ec_field.block IN $blockid_list AND ec_field.displaytype IN (1,2,4) ORDER BY block,sequence";
		setSqlCacheData($key,$sql);
	}

	$result = $adb->query($sql);
	$getBlockInfo=getDetailBlockInformation($module,$result,$col_fields,$tabid,$block_label);
	$index_count =1;
	$max_index =0;
	if(!isset($getBlockInfo)) {
		$getBlockInfo = array();
	}
	foreach($getBlockInfo as $label=>$contents)
	{
		$no_rows = count($contents);
		$index_count = $max_index+1;
		foreach($contents as $block_row => $elements)
		{
			$max_index= $no_rows+$index_count;

			for($i=0;$i<count($elements);$i++)
			{
				if(isset($getBlockInfo[$label][$block_row][$i]) && sizeof($getBlockInfo[$label][$block_row][$i])!=0)
				{
					if($i==0)
					$getBlockInfo[$label][$block_row][$i][]=array($index_count);
					else
					$getBlockInfo[$label][$block_row][$i][]=array($max_index);
				}
			}
			$index_count++;
		}
	}
	$log->debug("Exiting getDetailBlocks method ...");
	return $getBlockInfo;
}

/**
 * This function is used to get the display type.
 * Takes the input parameter as $mode - edit  (mostly)
 * This returns string type value
 */

function getView($mode)
{
	global $log;
	$log->debug("Entering getView() method ...");
        if($mode=="edit")
	        $disp_view = "edit_view";
        else
	        $disp_view = "create_view";
	$log->debug("Exiting getView method ...");
        return $disp_view;
}
/**
 * This function is used to get the blockid of the customblock for a given module.
 * Takes the input parameter as $tabid - module tabid and $label - custom label
 * This returns string type value
 */

function getBlockId($tabid,$label)
{
	global $log;
	$log->debug("Entering getBlockId() method ...");
	global $adb;
	$blockid = '';
	$query = "select blockid from ec_blocks where tabid=$tabid and blocklabel = '$label'";
	$result = $adb->query($query);
	$noofrows = $adb->num_rows($result);
	if($noofrows > 0)
	{
		$blockid = $adb->query_result($result,0,"blockid");
	} else {
		$query = "select min(blockid) as blockid from ec_blocks where tabid=$tabid";
		$result = $adb->query($query);
		$blockid = $adb->query_result($result,0,"blockid");
	}
	$log->debug("Exiting getBlockId method ...");
	return $blockid;
}

/**
 * This function is used to get the Parent and Child ec_tab relation array.
 * This returns array type value
 */
function getHeaderArray()
{
	global $adb;
	global $current_user;
	$key = "getheaderarray_list";
	$resultant_array = getSqlCacheData($key);
	if(!$resultant_array) {
		$resultant_array = Array();
		$query = 'select name,tablabel,tabid from ec_tab where tabid not in (29,35,36,37,44) order by tabsequence';
		$result = $adb->query($query);
		for($i=0;$i<$adb->num_rows($result);$i++)
		{
			$modulename = $adb->query_result($result,$i,'name');
			$tablabel = $adb->query_result($result,$i,'tablabel');
			$tabid = $adb->query_result($result,$i,'tabid');
			$resultant_array[] = $modulename;			
		}
		setSqlCacheData($key,$resultant_array);
	}
	
//	if(is_admin($current_user)){  
//		$resultant_array[] = 'Settings';
//		$resultant_array[] = 'Caches';		
//	}
	return $resultant_array;
}

function getParentTabName($parenttabid)
{
	global $log;
	$log->debug("Entering getParentTabName() method ...");
	
	$parent_tabname = "";
	$key = "parenttablist";
	$resultant_array = getSqlCacheData($key);
	if(!$resultant_array) {
		global $adb;
		$sql = "select parenttabid,parenttab_label from ec_parenttab order by sequence";
		$result = $adb->query($sql);
		$num_rows=$adb->num_rows($result);
		$result_array=Array();
		for($i=0;$i<$num_rows;$i++)
		{
			$id=$adb->query_result($result,$i,'parenttabid');
			$label=$adb->query_result($result,$i,'parenttab_label');
			$resultant_array[$id]=$label;

		}
		setSqlCacheData($key,$resultant_array);
	}
	if(isset($resultant_array[$parenttabid])) {
		$parent_tabname= $resultant_array[$parenttabid];
	}
	$log->debug("Exiting getParentTabName method ...");
	return $parent_tabname;
}

/**
 * This function is used to get the Parent Tab name for a given module.
 * Takes the input parameter as $module - module name
 * This returns value string type 
 */


function getParentTabFromModule($module)
{	
	global $log;
	$log->debug("Entering getParentTabName() method ...");
	$tabid = getTabid($module);
	$parent_tabname = "";
	$key = "parenttabrellist"; 
	$resultant_array = getSqlCacheData($key);
	if(!$resultant_array) {
		global $adb;
		//$sql = "select ec_parenttab.* from ec_parenttab inner join ec_parenttabrel on ec_parenttabrel.parenttabid=ec_parenttab.parenttabid where ec_parenttabrel.tabid='".$tabid."'";
		$sql = "select * from ec_parenttabrel order by sequence";
		$result = $adb->query($sql);
		$num_rows=$adb->num_rows($result);
		$result_array=Array();
		for($i=0;$i<$num_rows;$i++)
		{
			$parenttabid=$adb->query_result($result,$i,'parenttabid');
			$tabid=$adb->query_result($result,$i,'tabid');
			$resultant_array[$tabid]=$parenttabid;

		}
		setSqlCacheData($key,$resultant_array);
	}

	//echo "tabid:".$tabid."<br>";
	if($tabid == 16) $tabid = 9;//event -> calendar
	if(isset($resultant_array[$tabid])) {		 
		$parent_tabid = $resultant_array[$tabid];
		$parent_tabname = getParentTabName($parent_tabid);
	}
	if($module == 'Settings'){
		$parent_tabname = "Settings";
	}
	$log->debug("Exiting getParentTabName method ..."); 
	return $parent_tabname;
}

/**
 * This function is used to get the Parent Tab name for a given module.
 * Takes no parameter but gets the ec_parenttab value from form request
 * This returns value string type 
 */

function getParentTab()
{
//    global $log;	
//    $log->debug("Entering getParentTab() method ...");
//	$log->debug("Exiting getParentTab method ...");
    return getParentTabFromModule($_REQUEST['module']);
//    if(isset($_REQUEST['parenttab']) && $_REQUEST['parenttab'] !='')
//    {
//	     $log->debug("Exiting getParentTab method ...");
//	     return $_REQUEST['parenttab'];
//    }
//    else
//    {
//		$log->debug("Exiting getParentTab method ...");
//        return getParentTabFromModule($_REQUEST['module']);
//    }

}
/**
 * This function is used to get the days in between the current time and the modified time of an entity .
 * Takes the input parameter as $id - crmid  it will calculate the number of days in between the
 * the current time and the modified time from the ec_crmentity ec_table and return the result as a string.
 * The return format is updated <No of Days> day ago <(date when updated)>
 */

function updateInfo($id)
{
//    global $log;
//    $log->debug("Entering updateInfo() method ...");
//
//    global $adb;
//    global $app_strings;
//	$entityArr = getEntityTableById($id);
//	$tablename = $entityArr["tablename"];
//	$entityidfield = $entityArr["entityidfield"];
//	$update_info = "";
//	if($tablename != "") {
//		$query="select modifiedtime from ".$tablename." where deleted=0 and ".$entityidfield." ='".$id."'" ;
//		$result = $adb->query($query);
//		$rownum = $adb->num_rows($result);
//		if($rownum > 0) {
//			$modifiedtime = $adb->query_result($result,0,'modifiedtime');
//			$values=explode(' ',$modifiedtime);
//			$date_info=explode('-',$values[0]);
//			$time_info=explode(':',$values[1]);
//			if(count($date_info) < 3 || count($time_info) < 3) {
//				return "";
//			}
//			$date = $date_info[2].' '.$app_strings[date("M", mktime(0, 0, 0, $date_info[1], $date_info[2],$date_info[0]))].' '.$date_info[0];
//			$time_modified = mktime($time_info[0], $time_info[1], $time_info[2], $date_info[1], $date_info[2],$date_info[0]);
//			$time_now = time();
//			$days_diff = (int)(($time_now - $time_modified) / (60 * 60 * 24));
//			if($days_diff == 0)
//				$update_info = $app_strings['LBL_UPDATED_TODAY']." (".$modifiedtime.")";
//			//changed by dingjianting on 2006-10-15 for simplized chinese
//			elseif($days_diff == 1)
//				$update_info = $days_diff.$app_strings['LBL_DAY_AGO'].$app_strings['LBL_UPDATED']." (".$modifiedtime.")";
//			else
//				$update_info = $days_diff.$app_strings['LBL_DAYS_AGO'].$app_strings['LBL_UPDATED']." (".$modifiedtime.")";
//		}
//	}
//    $log->debug("Exiting updateInfo method ...");
//    return $update_info;
}

 /**
 * This function is used to generate file name if more than one image with same name is added to a given Product.
 * Param $filename - product file name
 * Param $exist - number time the file name is repeated.
 */

function file_exist_fn($filename,$exist)
{
	global $log;
	$log->debug("Entering file_exist_fn() method ...");
	global $uploaddir;

	if(!isset($exist))
	{
		$exist=0;
	}
	$filename_path=$uploaddir.$filename;
	if (is_file($filename_path)) //Checking if the file name already exists in the directory
	{
		if($exist!=0)
		{
			$previous=$exist-1;
			$next=$exist+1;
			$explode_name=explode("_",$filename);
			$implode_array=array();
			for($j=0;$j<count($explode_name); $j++)
			{
				if($j!=0)
				{
					$implode_array[]=$explode_name[$j];
				}
			}
			$implode_name=implode("_", $implode_array);
			$test_name=$implode_name;
		}
		else
		{
			$implode_name=$filename;
		}
		$exist++;
		$filename_val=$exist."_".$implode_name;
		$testfilename = file_exist_fn($filename_val,$exist);
		if($testfilename!="")
		{
			$log->debug("Exiting file_exist_fn method ...");
			return $testfilename;
		}
	}
	else
	{
		$log->debug("Exiting file_exist_fn method ...");
		return $filename;
	}
}

/**
 * This function is used get the User Count.
 * It returns the array which has the total ec_users ,admin ec_users,and the non admin ec_users
 */

function UserCount()
{
	global $log;
	$log->debug("Entering UserCount() method ...");
	global $adb;
	$result=$adb->query("select * from ec_users where deleted =0;");
	$user_count=$adb->num_rows($result);
	$result=$adb->query("select * from ec_users where deleted =0 AND is_admin != 'on';");
	$nonadmin_count = $adb->num_rows($result);
	$admin_count = $user_count-$nonadmin_count;
	$count=array('user'=>$user_count,'admin'=>$admin_count,'nonadmin'=>$nonadmin_count);
	$log->debug("Exiting UserCount method ...");
	return $count;
}

/**
 * This function is used to create folders recursively.
 * Param $dir - directory name
 * Param $mode - directory access mode
 * Param $recursive - create directory recursive, default true
 */

function mkdirs($dir, $mode = 0777, $recursive = true)
{
	global $log;
	$log->debug("Entering mkdirs() method ...");
	if( is_null($dir) || $dir === "" ){
		$log->debug("Exiting mkdirs method ...");
		return FALSE;
	}
	if( is_dir($dir) || $dir === "/" ){
		$log->debug("Exiting mkdirs method ...");
		return TRUE;
	}
	if( mkdirs(dirname($dir), $mode, $recursive) ){
		$log->debug("Exiting mkdirs method ...");
		return mkdir($dir, $mode);
	}
	$log->debug("Exiting mkdirs method ...");
	return FALSE;
}

/**This function returns the module name which has been set as default home view for a given user.
 * Takes no parameter, but uses the user object $current_user.
 */
function DefHomeView()
{
		global $log;
		$log->debug("Entering DefHomeView() method ...");
		global $adb;
		global $current_user;
		$query="select defhomeview from ec_users where id = ".$current_user->id;
		$result=$adb->query($query);
		$defaultview=$adb->query_result($result,0,'defhomeview');
		$log->debug("Exiting DefHomeView method ...");
		return $defaultview;

}


/**
 * This function is used to set the Object values from the REQUEST values.
 * @param  object reference $focus - reference of the object
 */
function setObjectValuesFromRequest($focus)
{
	global $log;
	$log->debug("Entering setObjectValuesFromRequest() method ...");
	if(isset($_REQUEST['record']))
	{
		$focus->id = $_REQUEST['record'];
	}
	if(isset($_REQUEST['mode']))
	{
		$focus->mode = $_REQUEST['mode'];
	}
	foreach($focus->column_fields as $fieldname => $val)
	{
		if(isset($_REQUEST[$fieldname]))
		{
			//$value = from_html($_REQUEST[$fieldname]);
			$value = $_REQUEST[$fieldname];
			$focus->column_fields[$fieldname] = $value;
		}

	}
	$log->debug("Exiting setObjectValuesFromRequest method ...");
}


function getUserslist()
{
	global $log;
	$log->debug("Entering getUserslist() method ...");
	//changed by dingjianting on 2007-10-3 for cache HeaderArray
	$key = "change_owner";
	$change_owner = getSqlCacheData($key);
	if(!$change_owner) {
		global $adb;
		$result=$adb->query("select * from ec_users where deleted=0 and status='Active' order by prefix");
		for($i=0;$i<$adb->num_rows($result);$i++)
		{
			   $useridlist[$i]=$adb->query_result($result,$i,'id');
			   $usernamelist[$useridlist[$i]]=$adb->query_result($result,$i,'user_name');
		}
		$change_owner = get_select_options_with_id($usernamelist,'');
		setSqlCacheData($key,$change_owner);
	}
	$log->debug("Exiting getUserslist method ...");
	return $change_owner;
}

function getPMUserList()
{
	global $log;
	$log->debug("Entering getPMUserList() method ...");
	//changed by dingjianting on 2007-10-3 for cache HeaderArray
	$key = "pm_userlist";
	$change_owner = getSqlCacheData($key);
	if(!$change_owner) {
		global $adb;
		$usernamelist = array();
		$result=$adb->query("select * from ec_users where deleted=0 and status='Active' order by prefix");
		for($i=0;$i<$adb->num_rows($result);$i++)
		{
			$user_name = $adb->query_result($result,$i,'user_name');
			$usernamelist[$user_name]= $user_name;
		}
		$change_owner = get_select_options_with_id($usernamelist,'');
		setSqlCacheData($key,$change_owner);
	}
	$log->debug("Exiting getPMUserList method ...");
	return $change_owner;
}

function getUserslist_Nocache($userid)
{
	global $log;
	$log->debug("Entering getUserslist_Nocache() method ...");
	global $adb;
	$result=$adb->query("select * from ec_users where deleted=0 and status='Active' order by prefix");
	for($i=0;$i<$adb->num_rows($result);$i++)
	{
		   $useridlist[$i]=$adb->query_result($result,$i,'id');
		   $usernamelist[$useridlist[$i]]=$adb->query_result($result,$i,'user_name');
	}
	$change_owner = get_select_options_with_id($usernamelist,$userid);
	$log->debug("Exiting getUserslist_Nocache method ...");
	return $change_owner;
}


function getGroupslist($groupid=0)
{
	global $log;
	$log->debug("Entering getGroupslist() method ...");
	//changed by dingjianting on 2007-10-3 for cache HeaderArray
	$key = "change_groups_owner";
	$groupnamelist = getSqlCacheData($key);
	if(!$groupnamelist) {
		global $adb;
		$result=$adb->query("select * from ec_groups");
		for($i=0;$i<$adb->num_rows($result);$i++)
		{
			   $groupidlist[$i]=$adb->query_result($result,$i,'groupid');
			   $groupnamelist[$groupidlist[$i]]=$adb->query_result($result,$i,'groupname');
		}
		setSqlCacheData($key,$groupnamelist);
	}
	$change_groups_owner = get_select_options_with_id($groupnamelist,$groupid);
	$log->debug("Exiting getGroupslist method ...");
	return $change_groups_owner;
}


/**
  *	Function to Check for Security whether the Buttons are permitted in List/Edit/Detail View of all Modules
  *	@param string $module -- module name
  *	Returns an array with permission as Yes or No
**/
function Button_Check($module)
{
	global $log;
	$log->debug("Entering Button_Check() method ...");
	global $current_user;
	$key = "button_check_".$module;
	$permit_arr = getSqlCacheData($key);
	if(!$permit_arr) {
		$permit_arr = array ('EditView' => '',
						 'Create' => '',
						 'index' => '',
						 'Import' => '',
						 'Export' => '' );

		foreach($permit_arr as $action => $perr)
		{
			 $tempPer = isPermitted($module,$action,'');
			 $permit_arr[$action] = $tempPer;
		}
		$permit_arr["Calendar"] = isPermitted("Calendar","index",'');
		setSqlCacheData($key,$permit_arr);
	}

	$log->debug("Exiting Button_Check method ...");
	return $permit_arr;

}

/**
  *	Function to Check whether the User is allowed to delete a particular record from listview of each module using
  *	mass delete button.
  *	@param string $module -- module name
  *	@param array $ids_list -- Record id
  *	Returns the Record Names of each module that is not permitted to delete
**/
function getEntityName($module, $ids_list)
{
	global $adb;
	global $log;
	$log->debug("Entering getEntityName(".$module.") method ...");
	$list = implode(",",$ids_list);
	if($module != '' && $list != '')
	{
		 $query = "select fieldname,tablename,entityidfield from ec_entityname where modulename = '$module'";
		 $result = $adb->query($query);
		 $fieldsname = $adb->query_result($result,0,'fieldname');
		 $tablename = $adb->query_result($result,0,'tablename');
		 $entityidfield = $adb->query_result($result,0,'entityidfield');
		 if(!(strpos($fieldsname,',') === false))
		 {
			 if($adb->isMssql()){
				 $fieldlists = explode(',',$fieldsname);
				 $fieldsname = "(";
				 $fieldsname = $fieldsname.implode("+' '+",$fieldlists);
				 $fieldsname = $fieldsname.")";
			 } else {
				 $fieldlists = explode(',',$fieldsname);
				 $fieldsname = "concat(";
				 $fieldsname = $fieldsname.implode(",' ',",$fieldlists);
				 $fieldsname = $fieldsname.")";
			 }
		 }
		 $query1 = "select $fieldsname as entityname from $tablename where $entityidfield in (".$list.")";
		 $result = $adb->query($query1);
		 $numrows = $adb->num_rows($result);
	  	 $account_name = array();
		 for ($i = 0; $i < $numrows; $i++)
		 {
			$entity_id = $ids_list[$i];
			$entity_info[$entity_id] = $adb->query_result($result,$i,'entityname');
		 }
		 return $entity_info;
	}
	$log->debug("Exiting getEntityName method ...");
}

/**
  *	Function to get entity name for uitype 10
  *	mass delete button.
  *	@param string rel_tablename
  *	@param string rel_entityname
  *	Returns entity name to display
**/
function getEntityNameForTen($rel_tablename,$rel_entityname,$fieldname,$value)
{
	global $adb;
	global $log;
	$log->debug("Entering getEntityName() method ...");
	$query1 = "select $rel_entityname as entityname from $rel_tablename where $fieldname='".$value."'";
	$result = $adb->query($query1);
	$numrows = $adb->num_rows($result);
	$entity_info = "";
	if($numrows > 0) {
		$entity_info = $adb->query_result($result,0,'entityname');
	}
	$log->debug("Exiting getEntityName method ...");
	return $entity_info;
}
/**Function to get all permitted modules for a user with their parent
*/

function getAllParenttabmoduleslist()
{
        global $adb;
        $resultant_array = Array();
        $query = 'select name,tablabel,parenttab_label,ec_tab.tabid from ec_parenttabrel inner join ec_tab on ec_parenttabrel.tabid = ec_tab.tabid inner join ec_parenttab on ec_parenttabrel.parenttabid = ec_parenttab.parenttabid order by ec_parenttab.sequence, ec_parenttabrel.sequence';
        $result = $adb->query($query);
        for($i=0;$i<$adb->num_rows($result);$i++)
        {
                $parenttabname = $adb->query_result($result,$i,'parenttab_label');
                $modulename = $adb->query_result($result,$i,'name');
                $tablabel = $adb->query_result($result,$i,'tablabel');
				$tabid = $adb->query_result($result,$i,'tabid');
				$resultant_array[$parenttabname][] = Array($modulename,$tablabel);
				
        }

		if($is_admin)
		{
				$resultant_array['Settings'][] = Array('Settings','Settings');
		}

	    return $resultant_array;
}

/**
 * 	This function is used to decide the File Storage Path in where we will upload the file in the server.
 * 	return string $filepath  - filepath inwhere the file should be stored in the server will be return
*/
function decideFilePath()
{
	global $log, $adb;
	$log->debug("Entering into decideFilePath() method ...");
	$filepath = 'storage/';
	//$filepath = 'storage/';

	$year  = date('Y');
	$month = date('F');
	$day  = date('j');
	$week   = '';

	if(!is_dir($filepath.$year))
	{
		//create new folder
		mkdir($filepath.$year);
	}

	if(!is_dir($filepath.$year."/".$month))
	{
		//create new folder
		mkdir($filepath."$year/$month");
	}

	if($day > 0 && $day <= 7)
		$week = 'week1';
	elseif($day > 7 && $day <= 14)
		$week = 'week2';
	elseif($day > 14 && $day <= 21)
		$week = 'week3';
	elseif($day > 21 && $day <= 28 )
		$week = 'week4';
	else
		$week = 'week5';

	if(!is_dir($filepath.$year."/".$month."/".$week))
	{
		//create new folder
		mkdir($filepath."$year/$month/$week");
	}

	$filepath = $filepath.$year."/".$month."/".$week."/";

	$log->debug("Year=$year & Month=$month & week=$week && filepath=\"$filepath\"");
	$log->debug("Exiting from decideFilePath() method ...");

	return $filepath;
}


/**
 * 	This function is used to check whether the attached file is a image file or not
 *	@param string $file_details  - ec_files array which contains all the uploaded file details
 * 	return string $save_image - true or false. if the image can be uploaded then true will return otherwise false.
*/
function validateImageFile($file_details)
{
	global $adb, $log;
	$log->debug("Entering into validateImageFile() method.");

	$savefile = 'true';
	$file_type_details = explode("/",$file_details['type']);
	$filetype = $file_type_details['1'];

	if (($filetype == "jpeg" ) || ($filetype == "png") || ($filetype == "jpg" ) || ($filetype == "pjpeg" ) || ($filetype == "x-png") || ($filetype == "gif") || ($filetype == "bmp"))
	{
		$saveimage = 'true';
	}
	else
	{
		$saveimage = 'false';
		$_SESSION['image_type_error'] .= "<br> &nbsp;&nbsp;Allowed file types - jpeg, png, jpg, pjpeg, x-png or gif.";

	}

	$log->debug("Exiting from validateImageFile( method.");
	return $saveimage;
}

/**
 * 	This function is used to get the Email Template Details like subject and content for particular template.
 *	@param integer $templateid  - Template Id for an Email Template
 * 	return array $returndata - Returns Subject, Body of Template of the the particular email template.
*/

function getTemplateDetails($templateid)
{
        global $adb,$log;
        $log->debug("Entering into getTemplateDetails() method ...");
        $returndata =  Array();
        $result = $adb->query("select * from ec_emailtemplates where templateid=$templateid");
        $returndata[] = $templateid;
        $returndata[] = $adb->query_result($result,0,'body');
        $returndata[] = $adb->query_result($result,0,'subject');
        $log->debug("Exiting from getTemplateDetails($templateid) method ...");
        return $returndata;
}

/**	Function used to retrieve a single field value from database
 *	@param string $tablename - tablename from which we will retrieve the field value
 *	@param string $fieldname - fieldname to which we want to get the value from database
 *	@param string $idname	 - idname which is the name of the entity id in the table like, inoviceid, quoteid, etc.,
 *	@param int    $id	 - entity id
 *	return string $fieldval  - field value of the needed fieldname from database will be returned
 */
function getSingleFieldValue($tablename, $fieldname, $idname, $id)
{
	global $log, $adb;
	$log->debug("Entering into function getSingleFieldValue()");
	$result = $adb->query("select $fieldname from $tablename where $idname = $id");
	$fieldval = $adb->query_result($result,0,$fieldname);

	$log->debug("Exit from function getSingleFieldValue()");

	return $fieldval;
}

function get_users_emails($userids_array) {
	global $adb;
	if(!is_array($userids_array)) {
		return ;
	}
	$user_emails = array();
	$userids = explode(",",$userids_array);
	$query = "select email1,email2 from ec_users where userid in(".$userids.")";
	$res = $adb->query($query);
	$num_rows=$adb->num_rows($res);
	for($i=0;$i<$num_rows;$i++) {
		$email = $adb->query_result($res,$i,'email1');
		if($email == '')
		{
			$email = $adb->query_result($res,$i,'email2');
		}
		if($email != '' && !in_array($email,$user_emails)) {
			$user_emails[] = $email;
		}
	}
	return $user_emails;
}

function getUserIDFilterHTML($module,$selected="")
{
    global $current_user;
    global $app_strings;
    global $app_list_strings;
    $shtml = "";
    $tabid = getTabid($module);
    if($is_admin == false)
    {
        $sub_userlist = getSubordinateUsersNameList();
        $users_combo = get_select_options_with_id($sub_userlist, $selected);
    }
    else
    {
        $user_array = get_user_array(FALSE, "Active", $selected);
        $users_combo = get_select_options_with_id($user_array, $selected);
    }
    if("all_to_me" == $selected)
    {
        $shtml .= "<option selected value=\"all_to_me\">".$app_strings['LBL_ALL_TO_ME'].$app_list_strings['moduleList'][$module]."</option>";
    }else
    {
        $shtml .= "<option value=\"all_to_me\">".$app_strings['LBL_ALL_TO_ME'].$app_list_strings['moduleList'][$module]."</option>";
    }
    if("sub_user" == $selected)
    {
        $shtml .= "<option selected value=\"sub_user\">".$app_strings['LBL_SUB_USER'].$app_list_strings['moduleList'][$module]."</option>";
    }else
    {
        $shtml .= "<option value=\"sub_user\">".$app_strings['LBL_SUB_USER'].$app_list_strings['moduleList'][$module]."</option>";
    }
	if("current_user" == $selected)
    {
        $shtml .= "<option selected value=\"current_user\">".$app_strings['LBL_CURRENT_USER'].$app_list_strings['moduleList'][$module]."</option>";
    }else
    {
        $shtml .= "<option value=\"current_user\">".$app_strings['LBL_CURRENT_USER'].$app_list_strings['moduleList'][$module]."</option>";
    }
    $shtml .= $users_combo ;
	/*
    if("current_group" == $selected)
    {
        $shtml .= "<option selected value=\"current_group\">".$app_strings['LBL_CURRENT_GROUP'].$app_list_strings['moduleList'][$module]."</option>";
    }else
    {
        $shtml .= "<option value=\"current_group\">".$app_strings['LBL_CURRENT_GROUP'].$app_list_strings['moduleList'][$module]."</option>";
    }
	*/
    return $shtml;
}

function getUserIDS($viewscope="all_to_me")
{
    global $log;
    $log->debug("Entering getUserIDS() method ...");
    global $current_user;

    if(empty($viewscope)) $viewscope="all_to_me";
	$key = "sqluserids_".$viewscope."_".$current_user->id;
	$userIDS = getSqlCacheData($key);
	if(!$userIDS) {
		global $adb;
		$sec_query = "";
		$userIDS = '';
		

		if($viewscope == "all_to_me") {
			
			$sec_query = "select id as userid from ec_users where status='Active'";
			
			$result = $adb->getList($sec_query);
			$userIDS .='(';
			$i=0;
			foreach($result as $row)
			{
				$userid = $row['userid'];
				if($i != 0)
				{
					$userIDS .= ', ';
				}
				$userIDS .= $userid;
				$i++;
			}
			if($userIDS != '(') {
				$userIDS .= ', '.$current_user->id;
			} else {
				$userIDS .= $current_user->id;
			}
			$userIDS .=')';
		}
		elseif($viewscope == "sub_user") {
			if(!isset($current_user_parent_role_seq) || $current_user_parent_role_seq == "") {
				$current_user_parent_role_seq = fetchUserRole($current_user->id);
			}
			$sec_query = "select ec_user2role.userid from ec_user2role inner join ec_users on ec_users.id=ec_user2role.userid inner join ec_role on ec_role.roleid=ec_user2role.roleid where ec_role.parentrole like '%".$current_user_parent_role_seq."::%'";
			$result = $adb->getList($sec_query);
			$userIDS .='(';
			$i=0;
			foreach($result as $row)
			{
				$userid = $row['userid'];
				if($i != 0)
				{
					$userIDS .= ', ';
				}
				$userIDS .= $userid;
				$i++;
			}
			$userIDS .=')';
		} elseif($viewscope == "current_user") {

				$userIDS .='('.$current_user->id;

				$userIDS .=')';
		} elseif($viewscope == "current_group") {
				$sec_query .= "select ec_users2group.userid from ec_users2group where ec_users2group.groupid in ".getCurrentUserGroupList()."";
				$result = $adb->getList($sec_query);
				$userIDS .='(';
				$i=0;
				foreach($result as $row)
				{
					$userid = $row['userid'];
					if($i != 0)
					{
						$userIDS .= ', ';
					}
					$userIDS .= $userid;
					$i++;
				}
				$userIDS .=')';

		} else {
			$userIDS .= '('.$viewscope.')';

		}
		setSqlCacheData($key,$userIDS);
	}
	if($userIDS == "()") {
		$userIDS = "(-1)";
	}

    $log->debug("Exiting getUserIDS method ...");
    return $userIDS;
}

/** call back function to change the array values in to lower case */
function lower_array(&$string){
	    $string = strtolower(trim($string));
}

/** Function to check whether the relationship entries are exist or not on elationship tables */
function is_related($relation_table,$crm_field,$related_module_id,$crmid)
{
	global $adb;
	$check_res = $adb->query("select * from $relation_table where $crm_field=$related_module_id and crmid=$crmid");
	$count = $adb->num_rows($check_res);
	if($count > 0)
		return true;
	else
		return false;
}

function decode_html($str)
{
	global $default_charset;
	if($_REQUEST['action'] == 'Popup')
		return html_entity_decode($str);
	else
		return html_entity_decode($str,ENT_QUOTES,$default_charset);
}

/** Returns the URL for Basic and Advance Search
 ** Added to fix the issue 4600
 **/
function getBasic_Advance_SearchURL()
{

	$url = '';
	if($_REQUEST['searchtype'] == 'BasicSearch')
	{
		$url .= (isset($_REQUEST['query']))?'&query='.$_REQUEST['query']:'';
		$url .= (isset($_REQUEST['search_field']))?'&search_field='.$_REQUEST['search_field']:'';
		$url .= (isset($_REQUEST['search_text']))?'&search_text='.to_html($_REQUEST['search_text']):'';
		$url .= (isset($_REQUEST['searchtype']))?'&searchtype='.$_REQUEST['searchtype']:'';
		$url .= (isset($_REQUEST['type']))?'&type='.$_REQUEST['type']:'';
	}
	if ($_REQUEST['searchtype'] == 'advance')
	{
		$url .= (isset($_REQUEST['query']))?'&query='.$_REQUEST['query']:'';
		$count=$_REQUEST['search_cnt'];
		for($i=0;$i<$count;$i++)
		{
			$url .= (isset($_REQUEST['Fields'.$i]))?'&Fields'.$i.'='.stripslashes(str_replace("'","",$_REQUEST['Fields'.$i])):'';
			$url .= (isset($_REQUEST['Condition'.$i]))?'&Condition'.$i.'='.$_REQUEST['Condition'.$i]:'';
			$url .= (isset($_REQUEST['Srch_value'.$i]))?'&Srch_value'.$i.'='.to_html($_REQUEST['Srch_value'.$i]):'';
		}
		$url .= (isset($_REQUEST['searchtype']))?'&searchtype='.$_REQUEST['searchtype']:'';
		$url .= (isset($_REQUEST['search_cnt']))?'&search_cnt='.$_REQUEST['search_cnt']:'';
		$url .= (isset($_REQUEST['matchtype']))?'&matchtype='.$_REQUEST['matchtype']:'';
	}
	return $url;

}

function getTimeFilter($filtercolumn,$startdate,$enddate)
{
	$filter_sql = "";
	if($filtercolumn != "")
	{
		if($startdate != "" && $enddate != "")
		{
			$filter_sql = $filtercolumn." between '".$startdate." 00:00:00' and '".$enddate."  23:59:00'";
		}
		elseif($startdate != "" && $enddate == "") {
			$filter_sql = $filtercolumn." >= '".$startdate." 00:00:00'";
		}
		elseif($startdate == "" && $enddate != "") {
			$filter_sql = $filtercolumn." <= '".$enddate."  23:59:00'";
		}
	}
	return $filter_sql;

}
function getStdDateFilterHtml($selcriteria = "")
{
	global $app_strings;
	$filter = array();

	$stdfilter = Array("custom"=>"".$app_strings['Custom']."",
			"prevfy"=>"".$app_strings['Previous FY']."",
			"thisfy"=>"".$app_strings['Current FY']."",
			"nextfy"=>"".$app_strings['Next FY']."",
			"prevfq"=>"".$app_strings['Previous FQ']."",
			"thisfq"=>"".$app_strings['Current FQ']."",
			"nextfq"=>"".$app_strings['Next FQ']."",
			"yesterday"=>"".$app_strings['Yesterday']."",
			"today"=>"".$app_strings['Today']."",
			"tomorrow"=>"".$app_strings['Tomorrow']."",
			"lastweek"=>"".$app_strings['Last Week']."",
			"thisweek"=>"".$app_strings['Current Week']."",
			"nextweek"=>"".$app_strings['Next Week']."",
			"lastmonth"=>"".$app_strings['Last Month']."",
			"thismonth"=>"".$app_strings['Current Month']."",
			"nextmonth"=>"".$app_strings['Next Month']."",
			"last7days"=>"".$app_strings['Last 7 Days']."",
			"last30days"=>"".$app_strings['Last 30 Days']."",
			"last60days"=>"".$app_strings['Last 60 Days']."",
			"last90days"=>"".$app_strings['Last 90 Days']."",
			"last120days"=>"".$app_strings['Last 120 Days']."",
			"next7days"=>"".$app_strings['Next 7 Days']."",
			"next30days"=>"".$app_strings['Next 30 Days']."",
			"next60days"=>"".$app_strings['Next 60 Days']."",
			"next90days"=>"".$app_strings['Next 90 Days']."",
			"next120days"=>"".$app_strings['Next 120 Days']."",
				);
    $shtml = "";
	foreach($stdfilter as $FilterKey=>$FilterValue)
	{
		if($FilterKey == $selcriteria)
		{
			$shtml .= '<option selected value="'.$FilterKey.'">'.$FilterValue.'</option>';
		}else
		{
			$shtml .= '<option value="'.$FilterKey.'">'.$FilterValue.'</option>';
		}
	}
	return $shtml;

}

/** to get the standard filter criteria scripts
  * @returns  $jsStr : Type String
  * This function will return the script to set the start data and end date
  * for the standard selection criteria
  */
function getStdDateFilterJs($fieldname="jscal_field")
{


	$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
	$tomorrow  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));
	$yesterday  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));

	$currentmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m"), "01",   date("Y")));
	$currentmonth1 = date("Y-m-t");
	$lastmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m")-1, "01",   date("Y")));
	$lastmonth1 = date("Y-m-t", mktime(0, 0, 0, date("m")-1, "01",   date("Y")));
	$nextmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m")+1, "01",   date("Y")));
	$nextmonth1 = date("Y-m-t", mktime(0, 0, 0, date("m")+1, "01",   date("Y")));

	$lastweek0 = date("Y-m-d",strtotime("-2 week Sunday"));
	$lastweek1 = date("Y-m-d",strtotime("-1 week Saturday"));

	$thisweek0 = date("Y-m-d",strtotime("-1 week Sunday"));
	$thisweek1 = date("Y-m-d",strtotime("this Saturday"));

	$nextweek0 = date("Y-m-d",strtotime("this Sunday"));
	$nextweek1 = date("Y-m-d",strtotime("+1 week Saturday"));

	$next7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+6, date("Y")));
	$next30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+29, date("Y")));
	$next60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+59, date("Y")));
	$next90days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+89, date("Y")));
	$next120days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+119, date("Y")));

	$last7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-6, date("Y")));
	$last30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-29, date("Y")));
	$last60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-59, date("Y")));
	$last90days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-89, date("Y")));
	$last120days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-119, date("Y")));

	$currentFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")));
	$currentFY1 = date("Y-m-t",mktime(0, 0, 0, "12", date("d"),   date("Y")));
	$lastFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")-1));
	$lastFY1 = date("Y-m-t", mktime(0, 0, 0, "12", date("d"), date("Y")-1));

	$nextFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")+1));
	$nextFY1 = date("Y-m-t", mktime(0, 0, 0, "12", date("d"), date("Y")+1));

	if(date("m") <= 3)
	{
		$cFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")));
		$cFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")));
		$nFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
		$nFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));
		$pFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")-1));
		$pFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")-1));
	}
	else if(date("m") > 3 and date("m") <= 7)
	{
		$pFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")));
		$pFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")));
		$cFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
		$cFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));
		$nFq = date("Y-m-d",mktime(0, 0, 0, "07","01",date("Y")));
		$nFq1 = date("Y-m-d",mktime(0, 0, 0, "09","30",date("Y")));

	}
	else if(date("m") > 7 and date("m") <= 9)
	{
		$pFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
		$pFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));
		$cFq = date("Y-m-d",mktime(0, 0, 0, "07","01",date("Y")));
		$cFq1 = date("Y-m-d",mktime(0, 0, 0, "09","30",date("Y")));
		$nFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")));
		$nFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")));

	}
	else
	{
		$nFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")+1));
		$nFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")+1));
		$pFq = date("Y-m-d",mktime(0, 0, 0, "07","01",date("Y")));
		$pFq1 = date("Y-m-d",mktime(0, 0, 0, "09","30",date("Y")));
		$cFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")));
		$cFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")));
	}

	$sjsStr = '<script language="JavaScript" type="text/javaScript">
		function showDateRange_'.$fieldname.'( type )
		{
			if (type!="custom")
			{
				    document.getElementById("'.$fieldname.'_date_start").readOnly=true
					document.getElementById("'.$fieldname.'_date_end").readOnly=true
					//document.getElementById("'.$fieldname.'_date_start").style.visibility="hidden"
					//document.getElementById("'.$fieldname.'_date_end").style.visibility="hidden"
			}
			else
			{
				    document.getElementById("'.$fieldname.'_date_start").readOnly=false
					document.getElementById("'.$fieldname.'_date_end").readOnly=false
					//document.getElementById("'.$fieldname.'_date_start").style.visibility="visible"
					//document.getElementById("'.$fieldname.'_date_end").style.visibility="visible"
			}
			if( type == "today" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$today.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$today.'";
			}
			else if( type == "yesterday" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$yesterday.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$yesterday.'";
			}
			else if( type == "tomorrow" )
			{

				document.getElementById("'.$fieldname.'_date_start").value = "'.$tomorrow.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$tomorrow.'";
			}
			else if( type == "thisweek" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$thisweek0.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$thisweek1.'";
			}
			else if( type == "lastweek" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$lastweek0.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$lastweek1.'";
			}
			else if( type == "nextweek" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$nextweek0.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$nextweek1.'";
			}
			else if( type == "thismonth" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$currentmonth0.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$currentmonth1.'";
			}
			else if( type == "lastmonth" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$lastmonth0.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$lastmonth1.'";
			}
			else if( type == "nextmonth" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$nextmonth0.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$nextmonth1.'";
			}
			else if( type == "next7days" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$today.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$next7days.'";
			}
			else if( type == "next30days" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$today.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$next30days.'";
			}
			else if( type == "next60days" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$today.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$next60days.'";
			}
			else if( type == "next90days" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$today.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$next90days.'";
			}
			else if( type == "next120days" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$today.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$next120days.'";
			}
			else if( type == "last7days" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$last7days.'";
				document.getElementById("'.$fieldname.'_date_end").value =  "'.$today.'";
			}
			else if( type == "last30days" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$last30days.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$today.'";
			}
			else if( type == "last60days" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$last60days.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$today.'";
			}
			else if( type == "last90days" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$last90days.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$today.'";
			}
			else if( type == "last120days" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$last120days.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$today.'";
			}
			else if( type == "thisfy" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$currentFY0.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$currentFY1.'";
			}
			else if( type == "prevfy" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$lastFY0.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$lastFY1.'";
			}
			else if( type == "nextfy" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$nextFY0.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$nextFY1.'";
			}
			else if( type == "nextfq" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$nFq.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$nFq1.'";
			}
			else if( type == "prevfq" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$pFq.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$pFq1.'";
			}
			else if( type == "thisfq" )
			{
				document.getElementById("'.$fieldname.'_date_start").value = "'.$cFq.'";
				document.getElementById("'.$fieldname.'_date_end").value = "'.$cFq1.'";
			}
			else
			{
				document.getElementById("'.$fieldname.'_date_start").value = "";
				document.getElementById("'.$fieldname.'_date_end").value = "";
			}
		}
	</script>';

	return $sjsStr;
}

function getModulePicklistOptionsHtml($module,$selected_key="") {
	global $log;
    $log->debug("Entering getModulePicklistOptionsHtml method ...");
	global $adb,$current_language;
	$sql = "SELECT ec_field.* FROM ec_field INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid AND ec_def_org_field.visible=0 left join ec_tab on ec_tab.tabid=ec_field.tabid WHERE ec_field.uitype=15 and ec_tab.name='".$module."' ORDER BY ec_field.sequence";
	$result = $adb->query($sql);
	$rows = $adb->num_rows($result);
    $options = array();
	$cur_mod_strings = return_specified_module_language($current_language,$module);
    for($j = 0; $j < $rows; $j++)
    {
        $columnname  = $adb->query_result($result,$j,"columnname");
		$fieldlabel  = $adb->query_result($result,$j,"fieldlabel");
		if(isset($cur_mod_strings[$fieldlabel])) {
			$fieldlabel = $cur_mod_strings[$fieldlabel];
		}
        $options[$columnname] = $fieldlabel;
    }
	$html_options = get_select_options($options,$selected_key);
	$log->debug("Exit getModulePicklistOptionsHtml method ...");
	return $html_options;
}
function getFieldLabel($module,$columnname) {
	global $log;
    $log->debug("Entering getFieldLabel method ...");
	global $adb,$current_language;
	$sql = "SELECT ec_field.* FROM ec_field left join ec_tab on ec_tab.tabid=ec_field.tabid WHERE ec_field.columnname='".$columnname."' and ec_tab.name='".$module."' ORDER BY ec_field.sequence";
	$result = $adb->query($sql);
	$rows = $adb->num_rows($result);
    $fieldlabel = "";
	$cur_mod_strings = return_specified_module_language($current_language,$module);
	if($rows > 0) {
		$fieldlabel  = $adb->query_result($result,0,"fieldlabel");
	}
	if(isset($cur_mod_strings[$fieldlabel])) {
			$fieldlabel = $cur_mod_strings[$fieldlabel];
	}

	$log->debug("Exit getFieldLabel method ...");
	return $fieldlabel;
}

function javaStrPos($base,$findme)
{
	$result = stripos($base,$findme);
	if ($result === false) $result = -1;
	return $result;
}

function sendMessage($content,$touser,$fromuser='System') {
	global $log;
    $log->debug("Entering sendPM method ...");
	global $adb;
	$id = $adb->getUniqueID("ec_message");
    if($fromuser=='System'){
        $fromuserid=-1;
    }else{
        $fromuserid=getUserId_Ol($fromuser);
    }
    $touserid=getUserId_Ol($touser);
	$to_insert = "('".$id."','".$content."', 'msg', '".$fromuserid."', '".$touserid."','".date("Y-m-d H:i")."',0,0)";
	$query = "insert into ec_message(id,message, type, sender, recipient,stamp,deleted_sender,deleted_recipient) values".$to_insert;
	$adb->query($query);
	$log->debug("Exit sendPM method ...");
}
function sendMessageWithUserid($content,$touserid,$fromuserid='-1') {
	global $log;
    $log->debug("Entering sendPM method ...");
	global $adb;
	$id = $adb->getUniqueID("ec_message");
	$to_insert = "('".$id."','".$content."', 'msg', '".$fromuserid."', '".$touserid."','".date("Y-m-d H:i")."',0,0)";
	$query = "insert into ec_message(id,message, type, sender, recipient,stamp,deleted_sender,deleted_recipient) values".$to_insert;
	$adb->query($query);
	$log->debug("Exit sendPM method ...");
}
function insertPicklistValues($values, $fieldname)
{
	global $log,$adb,$app_strings;
	$log->debug("Entering insertPicklistValues() method ...");
	$i=0;
	$adb->query("delete from ec_picklist where colname='".$fieldname."'");
	foreach ($values as $val => $cal)
	{
		$id = $adb->getUniqueID('ec_picklist');
		if($cal != '')
		{
			$adb->query("insert into ec_picklist(id,colvalue,colname,sequence) values(".$id.",'".$cal."','".$fieldname."',".$i.")");
		}
		else
		{
			$adb->query("insert into ec_picklist(id,colvalue,colname,sequence) values(".$id.",'".$app_strings['LBL_NONE']."','".$fieldname."',".$i.")");
		}
		$i++;
	}
	$log->debug("Exiting insertPicklistValues method ...");
}


function setRelmodFieldList($relatedmodule,$focus) {
	global $log,$adb;
	$log->debug("Entering getRelmodFieldList() method ...");
	$key = "relmodlist_fields_".$relatedmodule;
	$key1 = "relmodlist_fields_name_".$relatedmodule;
	$key2 = "relmodlist_isconfig_".$relatedmodule;
	$list_fields = getSqlCacheData($key);
	$list_fields_name = getSqlCacheData($key1);
	$isConfig = getSqlCacheData($key2);
	if(!$isConfig) {
		$tabid = getTabid($relatedmodule);
		$query_rel = "SELECT ec_field.columnname,ec_field.fieldlabel,ec_field.fieldname,ec_field.tablename
						  FROM ec_field inner join ec_relmodfieldlist on ec_relmodfieldlist.fieldname=ec_field.columnname and ec_relmodfieldlist.module='".$relatedmodule."'
						  WHERE ec_field.tabid='".$tabid."' order by ec_relmodfieldlist.id";
		$result_rel = $adb->query($query_rel);
		$noofrows_rel = $adb->num_rows($result_rel);
		if($noofrows_rel > 0) {
			$language_strings = return_module_language($current_language,$relatedmodule);
			$list_fields = array();
			$list_fields_name = array();
			for($i=0; $i<$noofrows_rel; $i++)
			{
				$fieldlabel = $adb->query_result($result_rel,$i,"fieldlabel");
				if(isset($language_strings[$fieldlabel])) {
					$fieldlabel = $language_strings[$fieldlabel];
				}
				$fieldname = $adb->query_result($result_rel,$i,"fieldname");
				$columnname = $adb->query_result($result_rel,$i,"columnname");
				$tablename = $adb->query_result($result_rel,$i,"tablename");
				$list_fields[$fieldlabel] = Array($tablename=>$columnname);
				$list_fields_name[$fieldlabel] = $fieldname;
			}
			setSqlCacheData($key,$list_fields);
			setSqlCacheData($key1,$list_fields_name);
			setSqlCacheData($key2,1);//get module field
		} else {
			setSqlCacheData($key2,2);//get no field
		}
	} else {
		if($isConfig == 1) {
			$focus->list_fields = $list_fields;
			$focus->list_fields_name = $list_fields_name;
		}
	}

	$log->debug("Exiting getRelmodFieldList method ...");
}

function InsertNickInfo($nick,$source=""){ 
	global $log,$adb;
	require_once('modules/Users/Users.php');
	$focus = new Users();
	$log->debug("Entering InsertNickInfo() method ...");
	$focus->column_fields["user_name"] = $nick;
	$focus->column_fields["is_admin"] = "off";
	$focus->column_fields['status'] = "Active";
	$focus->column_fields['is_online'] = "1";
	$focus->column_fields['department'] = $source;
	$focus->save("Users");
	$return_id = $focus->id; 

	$log->debug("Exiting InsertNickInfo method ...");
	if(!empty($return_id) && $return_id != 0){
		return $return_id;
	}else{
		return "0";
	}
}
function getUserIDByNick($nick){
	global $adb,$log;
	$log->debug("Entering getUserIDByNick() method ...");
	$query = "select * from ec_users where deleted=0 and user_name ='".$nick."' ";
	$result = $adb->query($query);
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0 ){
		$id = $adb->query_result($result,0,"id");
	}else{
		$id = 0;
	}
	$log->debug("Exiting getUserIDByNick method ...");
	return $id;
}
function InsertNichengInfo($nick,$source=""){ 
	global $log,$adb;
	$log->debug("Entering InsertNichengInfo() method ...");
	$id = $adb->getUniqueID("ec_users");	
	$query = "insert into ec_users(id,nicheng,department,is_online,is_admin ) values('".$id."','".$nick."','".$source."',1,'off');";
	$eof = $adb->query($query);
	$log->debug("Exiting InsertNichengInfo method ...");
	if($eof){
		return $id;
	}else{
		return "0";
	}
}
function getUserIDByNicheng($nick){
	global $adb,$log;
	$log->debug("Entering getUserIDByNicheng() method ...");
	$query = "select * from ec_users where deleted=0 and nicheng ='".$nick."' ";
	$result = $adb->query($query);
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0 ){
		$id = $adb->query_result($result,0,"id");
	}else{
		$id = 0;
	}
	$log->debug("Exiting getUserIDByNicheng method ...");
	return $id;
}

function getProductFieldList($basemodule)
{
	global $log;
	//$fieldlist = array("productname","productcode","serialno","unit_price","catalogname");
	$log->debug("Entering getProductFieldList() method ...");
	$key = "inventory_product_fieldlist_".$basemodule;
	$$fieldlist = getSqlCacheData($key);
	if(!$fieldlist) {
		global $adb;
		$fieldlist = Array();
		$sql = "select fieldname from ec_productfieldlist where module='".$basemodule."' order by id";
		$result = $adb->query($sql);
		$noofrows = $adb->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
			$fieldname = $adb->query_result($result,$i,"fieldname");
			if($fieldname == "catalogid") $fieldname = "catalogname";
			elseif($fieldname == "vendor_id") $fieldname = "vendorname";
			$fieldlist[] = $fieldname; 
		}
		setSqlCacheData($key,$fieldlist);
	}
	$log->debug("Exiting getProductFieldList method ...");
	return $fieldlist;
}

function getProductFieldLabelList($basemodule)
{
	$fieldLabelList = array();
	global $log;
	//$fieldlist = array("productname","productcode","serialno","unit_price","catalogname");
	$log->debug("Entering getProductFieldLabelList() method ...");
	$key = "inventory_product_fieldlabellist_".$basemodule;
	$fieldLabelList = getSqlCacheData($key);
	if(!$fieldLabelList) {
		global $adb;
		global $current_language;
		$product_mod_strings = return_specified_module_language($current_language,"Products");
		$fieldLabelList = Array();
		$sql = "select ec_productfieldlist.*,ec_field.fieldlabel from ec_productfieldlist inner join ec_field on ec_field.columnname=ec_productfieldlist.fieldname where ec_productfieldlist.module='".$basemodule."' and ec_field.tabid=14 order by ec_productfieldlist.id";
		$result = $adb->query($sql);
		$noofrows = $adb->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
			$fieldarr = array();
			//$fieldname = $adb->query_result($result,$i,"fieldname");
			//if($fieldname == "catalogid") $fieldname = "catalogname";
			//elseif($fieldname == "vendor_id") $fieldname = "vendorname";
			$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
			if(isset($product_mod_strings[$fieldlabel])) {
				$fieldlabel = $product_mod_strings[$fieldlabel];
			}
			$width = $adb->query_result($result,$i,"width");
			$fieldarr["LABEL"] = $fieldlabel;
			$fieldarr["LABEL_WIDTH"] = $width;
			$fieldLabelList[] = $fieldarr;
			unset($fieldarr);
		}
		setSqlCacheData($key,$fieldLabelList);
	}
	$log->debug("Exiting getProductFieldLabelList method ...");
	return $fieldLabelList;
}

/**	Function used to retrieve the rate converted into dollar tobe saved into database
 *	The function accepts the price in the current currency
 *	return integer $conv_price  - 
 */
 function getConvertedPrice($price) 
 {
	 //global $current_user;
	 //$currencyid=fetchCurrency($current_user->id);
	 //$rate_symbol = getCurrencySymbolandCRate($currencyid);
	 //$conv_price = convertToDollar($price,1);
	 $price = ec_number_format($price,true);
	 return $price;
 }


/**	Function used to get the converted amount from dollar which will be showed to the user
 *	@param float $price - amount in dollor which we want to convert to the user configured amount
 *	@return float $conv_price  - amount in user configured currency
 */
function getConvertedPriceFromDollar($price) 
{
	/*
	global $current_user;
	$currencyid=fetchCurrency($current_user->id);
	$rate_symbol = getCurrencySymbolandCRate($currencyid);
	$conv_price = convertFromDollar($price,$rate_symbol['rate']);
	return $conv_price;
	*/
	//$conv_price = convertFromDollar($price,1);
	$price = ec_number_format($price,true);
	return $price;
}

function convertToDollar($amount,$crate){
	/*
	global $log;
	if($crate == 0) {
		return $amount;
	}
	$log->debug("Entering convertToDollar(".$amount.",".$crate.") method ...");
	$log->debug("Exiting convertToDollar method ...");
    return $amount / $crate;
	*/
	$amount = ec_number_format($amount);
	return $amount;
}

/** This function returns the amount converted from dollar.
  * param $amount - amount to be converted.
    * param $crate - conversion rate.
      */
function convertFromDollar($amount,$crate){
	/*
	global $log;
	if($crate == 0) {
		return $amount;
	}
	$log->debug("Entering convertFromDollar(".$amount.",".$crate.") method ...");
	$log->debug("Exiting convertFromDollar method ...");
	$amount = $amount * $crate;
	*/
	$amount = ec_number_format($amount);
    return $amount;
}

function deleteInventoryProductDetails($objectid, $return_old_values='')
{
	global $log, $adb;
	$log->debug("Entering into function deleteInventoryProductDetails().");
	//begin:changed by dingjianting on 2006-12-3 for qinjie's newbug
	$query2 = "delete from ec_inventoryproductrel where id=".$objectid;
	$adb->query($query2);
	//end:changed by dingjianting on 2006-12-3 for qinjie's newbug

	$log->debug("Exit from function deleteInventoryProductDetails().");
	return $ext_prod_arr;
}



// grabs client ip address and returns its value
function query_client_ip()
{
	global $_SERVER;
	$clientIP = false;
	if(isset($_SERVER['HTTP_CLIENT_IP']))
	{
		$clientIP = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches))
	{
		// check for internal ips by looking at the first octet
		foreach($matches[0] AS $ip)
		{
			if(!preg_match("#^(10|172\.16|192\.168)\.#", $ip))
			{
				$clientIP = $ip;
				break;
			}
		}

	}
	elseif(isset($_SERVER['HTTP_FROM']))
	{
		$clientIP = $_SERVER['HTTP_FROM'];
	}
	else
	{
		$clientIP = $_SERVER['REMOTE_ADDR'];
	}
	return $clientIP;
}
function clean_string($str, $filter = "STANDARD") {
	$filters = Array(
	"STANDARD"        => '#[^A-Z0-9\-_\.\@]#i',
	"STANDARDSPACE"   => '#[^A-Z0-9\-_\.\@\ ]#i',
	"FILE"            => '#[^A-Z0-9\-_\.]#i',
	"NUMBER"          => '#[^0-9\-]#i',
	"SQL_COLUMN_LIST" => '#[^A-Z0-9,_\.]#i',
	"PATH_NO_URL"     => '#://#i',
	"SAFED_GET"		  => '#[^A-Z0-9\@\=\&\?\.\/\-_~]#i', /* range of allowed characters in a GET string */
	"UNIFIED_SEARCH"	=> "#[\\x00]#", /* cn: bug 3356 & 9236 - MBCS search strings */
	"AUTO_INCREMENT"	=> '#[^0-9\-,\ ]#i',
	"ALPHANUM"        => '#[^A-Z0-9\-]#i',
	);
	if (preg_match($filters[$filter], $str)) {
		die("Bad data passed in");
	}
	else {
		return $str;
	}
}
function getJSONObj() {
	static $json = null;
	if(!isset($json)) {
		require_once('service/utils/JSON.php');
		$json = new JSON(JSON_LOOSE_TYPE);
	}
	return $json;
}

function convertPriceIntoRen($price,$rate) 
{
	if(!empty($rate) && $rate != 0) {
		$price = $price * $rate;
	}
	$price = ec_number_format($price,true);
	return $price;
}

function doAlipayInfo($out_trade_no,$trade_no,$total_fee){
	session_start();
	global $adb;
	$current_user_id = $_SESSION['authenticated_user_id'];
	$query = "select * from ec_systemchargetmps where order_no = '".$out_trade_no."' ";
	$row = $adb->getFirstLine($query);
	if(!empty($row)){
		$now = date("Y-m-d H:i:s");
		$userid   = $row['userid'];
		$chargetime   = $row['chargetime'];
		$endtime   = $row['endtime'];
		//$total_fee   = $row['chargefee'];

		$query2 = "select * from ec_systemcharges where userid = '".$userid."' ";
		$result = $adb->getFirstLine($query2);
		
		if(!empty($result)){
			$updatesql = "update ec_systemcharges set chargefee='".$total_fee."',endtime='".$endtime."',chargetime='".$chargetime."',chargenum=chargenum+1 where userid=$userid ";
		}else{
			$updatesql = "insert into ec_systemcharges(userid,chargenum,chargefee,chargetime,endtime) values({$userid},'1','".$total_fee."','".$chargetime."','".$endtime."')";
		}
		$adb->query($updatesql);
		
		$id = $adb->getUniqueID("ec_systemchargelogs");
		$totalnum = $canuse - $extra;
		$insertsql = "insert into ec_systemchargelogs(id,userid,chargetime,endtime,flag,order_no,total_fee,trade_no,modifiedby,modifiedtime) values({$id},{$userid},'".$chargetime."','".$endtime."',1,'".$out_trade_no."','".$total_fee."','".$trade_no."',{$userid},'".$now."')";
		$adb->query($insertsql);	
		
		$adb->query("delete from ec_systemchargetmps where userid=$userid");	
	}
}

/**
 * 通过模块名取到当前模块的表名、编号名、id名
 */
function getModTabName($modname) {
	global $log;
	$log->debug("Entering getModTabName({$modname}) method ...");
	$key = "getModTabName_{$modname}";
	$entityname = getSqlCacheData($key);
	if(!$entityname) {
		global $adb;
		$entityname = array();
		$query = "select tabid,tablename,fieldname,entityidfield 
					from ec_entityname where modulename = '{$modname}' ";
		$result = $adb->query($query);
		$tabid = $adb->query_result($result,0,"tabid");
		$tablename = $adb->query_result($result,0,"tablename");
		$fieldname = $adb->query_result($result,0,"fieldname");
		$entityidfield = $adb->query_result($result,0,"entityidfield");
		$entityname['tabid'] = $tabid;
		$entityname['tablename'] = $tablename;
		$entityname['fieldname'] = $fieldname;
		$entityname['entityidfield'] = $entityidfield;
		setSqlCacheData($key,$entityname);
	}
	$log->debug("Exiting getModTabName method ...");
	return $entityname;
}

?>
