<?php
require_once('modules/Accounts/Accounts.php');
global $mod_strings;
global $current_user;
global $adb;

if(!isset($_REQUEST['record']))
	die($mod_strings['ERR_DELETE_RECORD']);


$adb->startTransaction();
//delete notes
$sql= "update ec_notes set deleted=1 where accountid='".$_REQUEST['record']."'";
$adb->query($sql);

//delete contacts
$sql= "update ec_contacts set deleted=1 where accountid='".$_REQUEST['record']."'";
$adb->query($sql);


//delete salesorder
$sql= "update ec_salesorder set deleted=1 where accountid='".$_REQUEST['record']."'";
$adb->query($sql);

$date_var = date('YmdHis');
$sql="update ec_account set deleted=1,modifiedby='".$current_user->id."',modifiedtime=NOW() where accountid='" .$_REQUEST['record'] ."'"; 
$adb->query($sql);
$adb->completeTransaction();

if(isset($_REQUEST['parenttab']) && $_REQUEST['parenttab'] != "") $parenttab = $_REQUEST['parenttab'];

redirect("index.php?module=".$_REQUEST['return_module']."&action=".$_REQUEST['return_action']."&record=".$_REQUEST['return_id']."&parenttab=".$parenttab."&relmodule=".$_REQUEST['module']);
?>
