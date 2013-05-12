<?php
if(isset($_REQUEST['accountid']) && $_REQUEST['accountid'] != "") 
{
	require_once('modules/Accounts/Accounts.php');
	require_once("include/Zend/Json.php");
	$focus = new Accounts();
    //$focus->id = $_REQUEST['accountid'];
    //$focus->mode = 'edit'; 	
    $focus->retrieve_entity_info($_REQUEST['accountid'],"Accounts");
	$json = new Zend_Json();
	$jsonaccount = $json->encode($focus->column_fields);
	$log->info($jsonaccount);
	echo $jsonaccount;    
}

die;
?>