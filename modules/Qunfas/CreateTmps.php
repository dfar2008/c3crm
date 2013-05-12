<?php
require_once('include/CRMSmarty.php');
require_once('modules/Qunfatmps/Qunfatmps.php');

global $mod_strings;
global $current_user;
global $adb;

$focus = new Qunfatmps();
$smarty = new CRMSmarty();

$datetime = date("Y-m-d H:i:s");

if($_REQUEST['mode'] =='save'){
	$qunfatmpname = $_REQUEST['qunfatmpname'];
	$description = $_REQUEST['description'];
	/*$qunfatmpsid = $adb->getUniqueID("ec_crmentity");
	$smownerid = $current_user->id;
	$query  = "insert into ec_qunfatmps(qunfatmpsid,qunfatmpname,description,smownerid,smcreatorid,createdtime,modifiedtime) values({$qunfatmpsid},'{$qunfatmpname}','{$description}',{$smownerid},{$smownerid},'{$datetime}','{$datetime}');";
	$adb->query($query);*/
	
	require_once('modules/Qunfatmps/Qunfatmps.php');
	$focus = new Qunfatmps();
	setObjectValuesFromRequest($focus);
	$focus->save("Qunfatmps");
	
	echo "<script>window.opener.document.getElementById('sendmessageinfo').value='".$description."';</script>";
	echo "<script>window.close();</script>>";
}





$smarty->display("Qunfas/CreateTmps.tpl");

?>
