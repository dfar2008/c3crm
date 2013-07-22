<?php
require_once('modules/Memdays/Memdays.php');

require_once('include/logging.php');
$log = LoggerManager::getLogger('memday_delete');

$focus = new Memdays();

if(!isset($_REQUEST['record']))
	die("A record number must be specified to delete the note.");

DeleteEntity($_REQUEST['module'],$_REQUEST['return_module'],$focus,$_REQUEST['record'],$_REQUEST['return_id']);

if(isset($_REQUEST['parenttab']) && $_REQUEST['parenttab'] != "") $parenttab = $_REQUEST['parenttab'];

//added by ligangze 2013-08-07
$moduletype="relmodule";
if($_REQUEST['return_action']=="CallRelatedList"){
    $return_action = "RelateLists";
    $moduletype="moduletype";
}else{
    $return_action = $_REQUEST['return_action'];
}
redirect("index.php?module=".$_REQUEST['return_module']."&action=".$return_action."&record=".$_REQUEST['return_id']."&parenttab=$parenttab"."&$moduletype=".$_REQUEST['module']);

//redirect("index.php?module=".$_REQUEST['return_module'].");
?>
