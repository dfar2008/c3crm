<?php

/*********************************************************************************
 ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
 ********************************************************************************/
require_once('modules/Memdays/Memdays.php');
require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');

$idlist= $_REQUEST['idlist'];
$viewid = $_REQUEST['viewname'];
$return_module = $_REQUEST['return_module'];
$return_action = $_REQUEST['return_action'];
global $rstart;
//Added to fix 4600
$url = getBasic_Advance_SearchURL();

if(isset($_REQUEST['start']) && $_REQUEST['start']!=''){
	$rstart = "&start=".$_REQUEST['start'];
}

$quickedit_field = $_REQUEST['quickedit_field'];
$quickedit_value = $_REQUEST['quickedit_value'];
global $log;
$log->info("quickedit_field=".$quickedit_field.",quickedit_value=".$quickedit_value);

if(isset($idlist)) {
	$recordids = explode(';', $idlist);
	$_REQUEST['ajxaction'] = "DETAILVIEW";
	for($index = 0; $index < count($recordids); ++$index) {
		$recordid = $recordids[$index];
		$log->info("recordid=".$recordid);
		if($recordid == '') continue;
		// Save each module record with update value.
		$focus = new Memdays();
		$focus->retrieve_entity_info($recordid, 'Memdays');
		$focus->mode = 'edit';		
		$focus->id = $recordid;		
		$focus->column_fields[$quickedit_field] = $quickedit_value;
		$focus->save('Memdays');
		// END
	}
}

redirect("index.php?module=$return_module&action=".$return_module."Ajax&file=ListView&ajax=changestate".$rstart."&viewname=".$viewid."&errormsg=".$errormsg.$url);
?>
