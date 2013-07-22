<?php
require_once('modules/Contacts/Contacts.php');

require_once('include/logging.php');
$log = LoggerManager::getLogger('contact_delete');

$focus = new Contacts();

if(!isset($_REQUEST['record']))
	die("A record number must be specified to delete the note.");

DeleteEntity($_REQUEST['module'],$_REQUEST['return_module'],$focus,$_REQUEST['record'],$_REQUEST['return_id']);

if(isset($_REQUEST['parenttab']) && $_REQUEST['parenttab'] != "") $parenttab = $_REQUEST['parenttab'];

if($_REQUEST['return_action']=="CallRelatedList"){
    $return_action = "RelateLists";
    $moduletype="moduletype";
}else{
    $return_action = $_REQUEST['return_action'];
}

redirect("index.php?module=".$_REQUEST['return_module']."&action=".$return_action."&record=".$_REQUEST['return_id']."&parenttab=$parenttab"."&$moduletype=".$_REQUEST['module']);
?>
