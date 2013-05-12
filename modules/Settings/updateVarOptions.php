<?php
$ModuleVar=$_REQUEST["ModuleVar"];
global $adb;
$tabid = getTabid($ModuleVar);
$printArray = array();
$query = "select ec_field.fieldlabel,columnname from ec_field where tabid='".$tabid."' and columnname=fieldname and uitype in(1,2,11,13,15,5,70,1021,1022,1023,21,19,87,86,85,88,71,17,7,9,56,33)";
$result = $adb->query($query);
global $current_language;
$cur_module_strings = return_specified_module_language($current_language,$ModuleVar);
//echo $query;
$num_rows = $adb->num_rows($result);
$optionsstr = "<option value=0 selected> ".$app_strings["LBL_NONE"]." </option>";
$prefix = "var.";
if($ModuleVar == "Accounts" || $ModuleVar == "Accounts" || $ModuleVar == "Accounts" || $ModuleVar == "Accounts" || $ModuleVar == "Accounts") {
}
switch($ModuleVar) {
case "Accounts":
	$prefix = "var.ACCOUNT_";
    break;
case "Contacts":
	$prefix = "var.CONTACT_";
    break;
case "Vendors":
	$prefix = "var.ACCOUNT_";
    break;
case "Vcontacts":
	$prefix = "var.CONTACT_";
    break;
case "Products":
	$prefix = "product.";
    break;
}
for($i=0; $i<$num_rows; $i++)
{
	$columnname = $adb->query_result($result,$i,'columnname');
	$template = $adb->query_result($result,$i,'filename');
	$fieldlabel = $adb->query_result($result,$i,'fieldlabel');
	if(isset($cur_module_strings[$fieldlabel])) {
		$fieldlabel = $cur_module_strings[$fieldlabel];
	}
	if($ModuleVar != "Products") {
		$columnname = strtoupper($columnname);
	}
	$optionsstr .= "<option value='[".$prefix.$columnname."]'>".$fieldlabel."</option>";
		 
}
echo $optionsstr;
?>
