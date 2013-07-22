<?php
require_once('modules/SalesOrder/SalesOrder.php');

$focus = new SalesOrder();
setObjectValuesFromRequest($focus);
if($focus->column_fields['subject'] == $app_strings["AUTO_GEN_CODE"]) {
	require_once('user_privileges/seqprefix_config.php');
	$focus->column_fields['subject'] = $salesorder_seqprefix.date("Ymd")."-".$focus->get_next_id();
}

$focus->column_fields['is_threeD'] = $_REQUEST['is_threeD'];

$focus->save("SalesOrder"); 

$return_id = $focus->id;

if(isset($_REQUEST['parenttab']) && $_REQUEST['parenttab'] != "") $parenttab = $_REQUEST['parenttab'];
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") $return_module = $_REQUEST['return_module'];
else $return_module = "SalesOrder";
//if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") $return_action = $_REQUEST['return_action'];
//else 
$return_action = "DetailView";
if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") $return_id = $_REQUEST['return_id'];

//code added for returning back to the current view after edit from list view
if($_REQUEST['return_viewname'] == '') $return_viewname='0';
if($_REQUEST['return_viewname'] != '')$return_viewname=$_REQUEST['return_viewname'];

if($_REQUEST['return_action']=="CallRelatedList"){
header("Location:index.php?action=$return_action&module=SalesOrder&parenttab=$parenttab&record=$focus->id");
}else{
    header("Location:index.php?action=$return_action&module=$return_module&parenttab=$parenttab&record=$return_id&viewname=$return_viewname&smodule=SO");
}

?>
