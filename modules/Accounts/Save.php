<?php
require_once('modules/Accounts/Accounts.php');
require_once('include/logging.php');
//require_once('database/DatabaseConnection.php');
require_once('include/database/PearDatabase.php');
global $log;
global $adb;
global $mod_strings;
global $current_user;
if(isset($_REQUEST['dup_check']) && $_REQUEST['dup_check'] != '')
{
	    $accountname = $_REQUEST['accountname'];
		$phone = $_REQUEST['phone'];
		$email = $_REQUEST['email'];
		$record = $_REQUEST['record'];
		$orsql = '';
		if(!empty($phone)){
			$orsql .=" or phone='".$phone."' ";
		}
		if(!empty($email)){
			$orsql .=" or email='".$email."' ";
		}
		
		if(empty($record)) {
			$query = "SELECT accountname FROM ec_account WHERE ec_account.deleted=0 and (accountname='".$accountname."' {$orsql} ) and smownerid=".$current_user->id." "; 
		} else {
			$query = "SELECT accountname FROM ec_account WHERE ec_account.deleted=0 and accountid !=".$record." and (accountname='".$accountname."' {$orsql}) and smownerid=".$current_user->id." ";
		}
		
        $result = $adb->query($query);
		//changed by dingjianting on 2006-10-26 for checking username exist in dicuz database
        if($adb->num_rows($result) > 0)
        {
			echo "客户:'".$accountname."'已存在或电话|Email重复！";
			die;
		}
		else
		{
			echo 'SUCCESS';
			die;
		}
}
$focus = new Accounts();
if(isset($_REQUEST['record']))
{
	$focus->id = $_REQUEST['record'];
}
if(isset($_REQUEST['mode']))
{
	$focus->mode = $_REQUEST['mode'];
}
setObjectValuesFromRequest($focus);
if($focus->column_fields['customernum'] == $app_strings["AUTO_GEN_CODE"]) {
	require_once('user_privileges/seqprefix_config.php');
	$focus->column_fields['customernum'] = $account_seqprefix."-".$focus->get_next_id();
}
$focus->save("Accounts");
$return_id = $focus->id;

if(isset($_REQUEST['parenttab']) && $_REQUEST['parenttab'] != "") $parenttab = $_REQUEST['parenttab'];
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") $return_module = $_REQUEST['return_module'];
else $return_module = "Accounts";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") $return_action = $_REQUEST['return_action'];
else $return_action = "DetailView";
if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") $return_id = $_REQUEST['return_id'];

if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] == "Potentials" && $_REQUEST['return_action'] == 'CallRelatedList') {
	$for_module = $_REQUEST['return_module'];
	$for_crmid  = $_REQUEST['return_id'];
	if(is_file("modules/$for_module/$for_module.php")) {
		require_once("modules/$for_module/$for_module.php");
		$on_focus = new $for_module();
		// Do conditional check && call only for Custom Module at present
		// TOOD: $on_focus->IsCustomModule is not required if save_related_module function
		// is used for core modules as well.
		if(method_exists($on_focus, 'save_related_module')) {
			$with_module = $module;
			$with_crmid = $focus->id;
			$on_focus->save_related_module($for_module, $for_crmid, $with_module, $with_crmid);
		}
	}
}

//code added for returning back to the current view after edit from list view
if($_REQUEST['return_viewname'] == '') $return_viewname='0';
if($_REQUEST['return_viewname'] != '')$return_viewname=$_REQUEST['return_viewname'];

redirect("index.php?action=$return_action&module=$return_module&parenttab=$parenttab&record=$return_id&viewname=$return_viewname");
?>
