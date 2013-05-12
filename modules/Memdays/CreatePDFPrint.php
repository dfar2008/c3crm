<?php
require_once('include/utils/SelectTemplate.php');
set_time_limit(0);
require_once('modules/Memdays/Memdays.php');
require_once('modules/Accounts/Accounts.php');
require_once('modules/Contacts/Contacts.php');
require_once('modules/Users/Users.php');
require_once('modules/Products/Products.php');
include('include/excel/tbs_class.php');
require_once('modules/Memdays/ModuleConfig.php');

global $app_strings;
global $mod_strings;
global $currentModule;
global $adb;
$focus = new Memdays();
$focus->retrieve_entity_info($_REQUEST['record'],"Memdays");
foreach($focus->column_fields as $key=>$value) {
	$upperKey = strtoupper($key);
	$$upperKey = $value;
}

// Company information
$add_query = "select * from ec_organizationdetails";
$result = $adb->query($add_query);
$num_rows = $adb->num_rows($result);

if($num_rows == 1)
{
		$COMPANY_NAME = $adb->query_result($result,0,"organizationname");
		$COMPANY_ADDRESS = $adb->query_result($result,0,"address");
		$COMPANY_CITY = $adb->query_result($result,0,"city");
		$COMPANY_STATE = $adb->query_result($result,0,"state");
		$COMPANY_COUNTRY = $adb->query_result($result,0,"country");
		$COMPANY_CODE = $adb->query_result($result,0,"code");
		$COMPANY_PHONE = $adb->query_result($result,0,"phone");
		$COMPANY_FAX = $adb->query_result($result,0,"fax");
		$COMPANY_WEBSITE = $adb->query_result($result,0,"website");
		$COMPANY_LOGO = $adb->query_result($result,0,"logoname");
		$log_path = str_replace("-","","t-e-st/logo/");
		$COMPANY_LOGO_PATH = $log_path.$COMPANY_LOGO;
		

		$COMPANY_PERSON = $adb->query_result($result,0,"person");
		$COMPANY_BANKNAME = $adb->query_result($result,0,"bankname");
		$COMPANY_BANKACCOUNT = $adb->query_result($result,0,"bankaccount");
		$COMPANY_TAXNO = $adb->query_result($result,0,"taxno");
}

$sql="select currency_symbol from ec_currency_info";
$result = $adb->query($sql);
$currency_symbol = $adb->query_result($result,0,'currency_symbol');

$id = $_REQUEST['record'];

$account_id = $focus->column_fields["account_id"];
if(!empty($account_id)) {
	$account_focus = new Accounts();
	$account_focus->retrieve_entity_info($account_id,"Accounts");
	foreach($account_focus->column_fields as $key=>$value) {
		$upperKey = "ACCOUNT_".strtoupper($key);
		$$upperKey = $value;
	}
	$ACCOUNT_PHONE = $account_focus->column_fields["phone"];
	$ACCOUNT_FAX = $account_focus->column_fields["fax"];
	$ACCOUNT_NAME = $account_focus->column_fields["accountname"];
	$ACCOUNT_STREET = $account_focus->column_fields["bill_street"];
	$ACCOUNT_CITY = $account_focus->column_fields["bill_city"];
	$ACCOUNT_STATE = $account_focus->column_fields["bill_state"];
	$ACCOUNT_CODE = $account_focus->column_fields["bill_code"];	
} else {
	$ACCOUNT_PHONE = "";
	$ACCOUNT_NAME = "";
	$ACCOUNT_FAX = "";
	$ACCOUNT_STREET = "";
	$ACCOUNT_CITY = "";
	$ACCOUNT_STATE = "";
	$ACCOUNT_CODE = "";
}
$contact_id = $focus->column_fields['contact_id'];
if(!empty($contact_id)) {
	$contact_focus = new Contacts();
	$contact_focus->retrieve_entity_info($contact_id,"Contacts");
	foreach($contact_focus->column_fields as $key=>$value) {
		$upperKey = "CONTACT_".strtoupper($key);
		$$upperKey = $value;
	}
	$CONTACT_MOBILE = $contact_focus->column_fields["mobile"];
	$CONTACT_PHONE = $contact_focus->column_fields["phone"];
	$CONTACT_NAME = $contact_focus->column_fields["lastname"];
	$CONTACT_EMAIL = $contact_focus->column_fields["email"];
	
} else {
	$CONTACT_NAME = "";//getContactName($contact_id);
	$CONTACT_EMAIL = "";//getContactPhone($contact_id);
	$CONTACT_MOBILE = "";//getContactMBPhone($contact_id);
	$CONTACT_PHONE = "";//getContactMBPhone($contact_id);
}

$user_id = $focus->column_fields['assigned_user_id'];
if(!empty($user_id)) {
	$user_focus = new Users();
	$user_focus->retrieve_entity_info($user_id,"Users");
	foreach($user_focus->column_fields as $key=>$value) {
		$upperKey = "USER_".strtoupper($key);
		$$upperKey = $value;
	}
	$USER_MOBILE = $user_focus->column_fields["phone_mobile"];
	$USER_NAME = $user_focus->column_fields["last_name"];
	$USER_EMAIL = $user_focus->column_fields["email1"];
	
} else {
	$USER_NAME = "";
	$USER_EMAIL = "";
	$USER_MOBILE = "";
}
$smcreatorid = $focus->column_fields['smcreatorid'];
if(!empty($smcreatorid)) {
	$user_focus = new Users();
	$user_focus->retrieve_entity_info($smcreatorid,"Users");
	foreach($user_focus->column_fields as $key=>$value) {
		$upperKey = "CREATOR_".strtoupper($key);
		$$upperKey = $value;
	}
	$CREATOR_MOBILE = $user_focus->column_fields["phone_mobile"];
	$CREATOR_NAME = $user_focus->column_fields["last_name"];
	$CREATOR_EMAIL = $user_focus->column_fields["email1"];
} else {
	$CREATOR_NAME = "";
	$CREATOR_EMAIL = "";
	$CREATOR_OBILE = "";
}
$focus->id = $focus->column_fields["record_id"];
if(isset($module_enable_product) && $module_enable_product) 
{
	$associated_products = getAssociatedProducts_NoPrice("Memdays",$focus);
	$num_products = count($associated_products);
	//This is to get all prodcut details as row basis
	for($i=1,$j=$i-1;$i<=$num_products;$i++,$j++)
	{
		$product_name[$i] = $associated_products[$i]['productName'.$i];
		$imagename[$i] = $associated_products[$i]['imagename'.$i];
		$prod_description[$i] = $associated_products[$i]['comment'.$i];
		$product_id[$i] = $associated_products[$i]['hdnProductId'.$i];
		$qty[$i] = ec_number_format($associated_products[$i]['qty'.$i]);
		$unit_price[$i] = ec_number_format($associated_products[$i]['unitPrice'.$i]);
		$list_price[$i] = ec_number_format($associated_products[$i]['listPrice'.$i]);
		$list_pricet[$i] = $associated_products[$i]['listPrice'.$i];
		$usageunit[$i] = $associated_products[$i]['usageunit'.$i];
		$serial_no[$i] = $associated_products[$i]['serial_no'.$i];
		$productcode[$i] = $associated_products[$i]['productcode'.$i];	
		$producttotal = $qty[$i]*$list_pricet[$i];
		$prod_total[$i] = ec_number_format($producttotal);
		$product_focus = new Products();
		$product_focus->retrieve_entity_info($product_id[$i],"Products");
		foreach($product_focus->column_fields as $key=>$value) {		 
			$product_line[$j][$key] = $value;
		}
		$product_line[$j]["name"] = $product_name[$i];
		$product_line[$j]["spec"] = $serial_no[$i];
		$product_line[$j]["code"] = $productcode[$i];
		$product_line[$j]["imagename"] = $imagename[$i];
		$product_line[$j]["unit"] = $usageunit[$i];
		$product_line[$j]["qty"] = $qty[$i].$usageunit[$i];
	    $product_line[$j]["num"] = $qty[$i];
		$product_line[$j]["price"] = $list_price[$i];
		$product_line[$j]["total"] = $prod_total[$i];
		$product_line[$j]["description"] = $prod_description[$i];		
		$product_focus = null;
	}
	$price_total = ec_number_format($focus->column_fields["total"]);
	$TOTAL = $price_total;//金额
	$TOTAL_BIG = toCNcap($price_total);//大写金额
	$TOTAL_BIG = iconv_ec("GBK","UTF-8",$TOTAL_BIG);
}

$MODULE_LABEL = $app_strings["Memdays"];

$TBS = new clsTinyButStrong;
$TBS->NoErr = true; // no more error message displayed. 

// Load the template
if(isset($module_enable_product) && $module_enable_product) 
{
	$TBS->LoadTemplate('modules/Memdays/'.$templatefile.'.html','UTF-8');
	$TBS->MergeBlock('product',$product_line);
} else {
	$TBS->LoadTemplate('modules/Memdays/'.$templatefile.'.html','UTF-8');
}
// Final merge and download file
$TBS->Show();

?>