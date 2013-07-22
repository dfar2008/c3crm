<?php
require_once('modules/Memdays/Memdays.php');
$focus = new Memdays();
if($_REQUEST['memday1004'] == '农历' && $_REQUEST['memday942'] > 0){
	$montharr = array("1"=>"正","2"=>"二","3"=>"三","4"=>"四","5"=>"五",
						"6"=>"六","7"=>"七","8"=>"八","9"=>"九","10"=>"十",
							"11"=>"十一","12"=>"腊");
	$_REQUEST['memday942'] = $montharr[$_REQUEST['memday942']]."月";
}else{
	$_REQUEST['memday942'] .= "月";
}
$_REQUEST["memday940"] = "{$_REQUEST['memday940']} {$_REQUEST['memday942']} {$_REQUEST['memday944']}";
setObjectValuesFromRequest($focus);


//Save the Memdays
$focus->save("Memdays");
$return_id = $focus->id;

if(isset($_REQUEST['parenttab']) && $_REQUEST['parenttab'] != "") $parenttab = $_REQUEST['parenttab'];
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") $return_module = $_REQUEST['return_module'];
else $return_module = "Memdays";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") $return_action = $_REQUEST['return_action'];
else $return_action = "DetailView";


if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") $return_id = $_REQUEST['return_id'];

//code added for returning back to the current view after edit from list view
if($_REQUEST['return_viewname'] == '') $return_viewname='0';
if($_REQUEST['return_viewname'] != '')$return_viewname=$_REQUEST['return_viewname'];
if($_REQUEST['moduletype'] != '') $module_type = $_REQUEST['moduletype'];

if($return_action == "CallRelatedList"){
    $return_action = "RelateLists";
    redirect("index.php?action=$return_action&module=$return_module&parenttab=$parenttab&record=$return_id&viewname=$return_viewname&moduletype=$module_type");
}else{
    redirect("index.php?action=$return_action&module=$return_module&parenttab=$parenttab&record=$return_id&viewname=$return_viewname");
}
?>