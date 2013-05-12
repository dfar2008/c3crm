<?php
require_once('include/logging.php');
require_once('modules/Maillists/Maillists.php');
require_once('include/database/PearDatabase.php');
require_once('modules/Maillists/ModuleConfig.php');
global $adb;

$local_log =& LoggerManager::getLogger('MaillistsAjax');

$ajaxaction = $_REQUEST["ajxaction"];
if($ajaxaction == "DETAILVIEW")
{
     $crmid = $_REQUEST["recordid"];
     $tablename = $_REQUEST["tableName"];
     $fieldname = $_REQUEST["fldName"];
     $fieldvalue = utf8RawUrlDecode($_REQUEST["fieldValue"]); 
     if($crmid != "")
	 {
		 if((!isset($is_disable_approve) || (isset($is_disable_approve) && !$is_disable_approve)) && (isset($module_enable_approve) && $module_enable_approve)) {
			 $sql = "select approved from ec_maillists where deleted=0 and maillistsid='".$crmid."'";
			 $result = $adb->query($sql);
			 $approved = $adb->query_result($result,0,"approved");
			 if($approved == 1) {
				 echo ":#:FAILURE";
				 die;
			 }
		 }
		 $modObj = new Maillists();
		 $modObj->retrieve_entity_info($crmid,"Maillists");
		 $modObj->column_fields[$fieldname] = $fieldvalue;
		 $modObj->id = $crmid;
		 $modObj->mode = "edit";
		 $modObj->save("Maillists");
		 if($modObj->id != "")
		 {
			 echo ":#:SUCCESS";
		 }else
		 {
			 echo ":#:FAILURE";
		 }   
	 }else
     {
         echo ":#:FAILURE";
     }
}
?>
