<?php
require_once('modules/Accounts/Accounts.php');
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
		$focus = new Accounts();
		$focus->retrieve_entity_info($recordid, 'Accounts');
		$focus->mode = 'edit';		
		$focus->id = $recordid;		
		$focus->column_fields[$quickedit_field] = $quickedit_value;
		$focus->save('Accounts');
		// END
	}
}

header("Location: index.php?module=$return_module&action=".$return_module."Ajax&file=ListView&ajax=changestate".$rstart."&viewname=".$viewid."&errormsg=".$errormsg.$url);
?>
