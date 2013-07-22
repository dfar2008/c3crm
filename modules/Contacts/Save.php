<?php
require_once('modules/Contacts/Contacts.php');
$focus = new Contacts();
if($_REQUEST['contact1004'] == '农历' && $_REQUEST['contact942'] > 0){
	$montharr = array("1"=>"正","2"=>"二","3"=>"三","4"=>"四","5"=>"五",
						"6"=>"六","7"=>"七","8"=>"八","9"=>"九","10"=>"十",
							"11"=>"十一","12"=>"腊");
	$_REQUEST['contact942'] = $montharr[$_REQUEST['contact942']]."月";
}else{
	$_REQUEST['contact942'] .= "月";
}
$_REQUEST["contact940"] = "{$_REQUEST['contact940']} {$_REQUEST['contact942']} {$_REQUEST['contact944']}";
setObjectValuesFromRequest($focus);
//Save the Contacts
$focus->save("Contacts");
$return_id = $focus->id;

if(isset($_REQUEST['parenttab']) && $_REQUEST['parenttab'] != "") $parenttab = $_REQUEST['parenttab'];
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") $return_module = $_REQUEST['return_module'];
else $return_module = "Contacts";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") $return_action = $_REQUEST['return_action'];
else $return_action = "DetailView";
if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") $return_id = $_REQUEST['return_id'];

//code added for returning back to the current view after edit from list view
if($_REQUEST['return_viewname'] == '') $return_viewname='0';
if($_REQUEST['return_viewname'] != '')$return_viewname=$_REQUEST['return_viewname'];

if($return_action == "CallRelatedList"){
    $return_action = "RelateLists";
    redirect("index.php?action=$return_action&module=$return_module&parenttab=$parenttab&record=$return_id&viewname=$return_viewname&moduletype=Contacts");
}else{
    redirect("index.php?action=$return_action&module=$return_module&parenttab=$parenttab&record=$return_id&viewname=$return_viewname");
}
?>