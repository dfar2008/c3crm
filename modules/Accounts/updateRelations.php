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

require_once('include/database/PearDatabase.php');
require_once('user_privileges/default_module_view.php');
global $adb, $singlepane_view,$currentModule;
$idlist = $_REQUEST['idlist'];
$returnmodule = $_REQUEST['return_module'];
if(isset($_REQUEST['idlist']) && $_REQUEST['idlist'] != '')
{
	if($_REQUEST['destination_module'] == "Products") {// && $_REQUEST['destination_module'] != "Campaigns") {
		//split the string and store in an array
		$storearray = explode (";",$idlist);
		foreach($storearray as $id)
		{
			if($id != '')
			{
				$sql = "insert into ec_accountproductrel values (". $_REQUEST["parentid"] .",".$id.")";
				$adb->query($sql);
			}
		}
		if($singlepane_view == 'true')
			header("Location: index.php?action=DetailView&module=Accounts&record=".$_REQUEST["parentid"]);
		else
			header("Location: index.php?action=CallRelatedList&module=Accounts&record=".$_REQUEST["parentid"]);
	} elseif($_REQUEST['destination_module'] == "Campaigns") {
		//split the string and store in an array
		$storearray = explode (";",$idlist);
		foreach($storearray as $id)
		{
			if($id != '')
			{
				$sql = "insert into ec_campaignaccountrel values (".$id.",".$_REQUEST["parentid"].")";
				$adb->query($sql);
			}
		}
		if($singlepane_view == 'true')
			header("Location: index.php?action=DetailView&module=Accounts&record=".$_REQUEST["parentid"]);
		else
			header("Location: index.php?action=CallRelatedList&module=Accounts&record=".$_REQUEST["parentid"]);
	} else {
		$idlist = $_REQUEST['idlist'];
		$dest_mod = $_REQUEST['destination_module'];
		$parenttab = $_REQUEST['parenttab'];
		$forCRMRecord = isset($_REQUEST['parentid'])?$_REQUEST['parentid']:$_REQUEST['parid'];
		if($singlepane_view == 'true')
			$action = "DetailView";
		else
			$action = "CallRelatedList";
		$storearray = array();
		if(!empty($_REQUEST['idlist'])) {
			// Split the string of ids
			$storearray = explode (";",trim($idlist,";"));
		}
		foreach($storearray as $id)
		{
			if($id != '')
			{
									
				if(is_file("modules/$currentModule/$currentModule.php")) {
					require_once("modules/$currentModule/$currentModule.php");
					$focus = new $currentModule();
					$focus->save_related_module($currentModule, $forCRMRecord, $dest_mod, $id);
				}
			}
		}

		header("Location: index.php?action=$action&module=$currentModule&record=".$forCRMRecord."&parenttab=".$parenttab);
	}
}
elseif(isset($_REQUEST['entityid']) && $_REQUEST['entityid'] != '')
{		
	if($_REQUEST['destination_module'] == "Products") {
		$sql = "insert into ec_accountproductrel values (". $_REQUEST["parid"] .",".$_REQUEST["entityid"] .")";
		$adb->query($sql);
		if($singlepane_view == 'true')
			header("Location: index.php?action=DetailView&module=Accounts&record=".$_REQUEST["parid"]);
		else
			header("Location: index.php?action=CallRelatedList&module=Accounts&record=".$_REQUEST["parid"]);
	} elseif($_REQUEST['destination_module'] == "Campaigns") {
		$sql = "insert into ec_campaignaccountrel values (". $_REQUEST["entityid"] .",".$_REQUEST["parid"] .")";
		$adb->query($sql);
		if($singlepane_view == 'true')
			header("Location: index.php?action=DetailView&module=Accounts&record=".$_REQUEST["parid"]);
		else
			header("Location: index.php?action=CallRelatedList&module=Accounts&record=".$_REQUEST["parid"]);
	} else{
		$dest_mod = $_REQUEST['destination_module'];
		$parenttab = $_REQUEST['parenttab'];

		$forCRMRecord = isset($_REQUEST['parentid'])?$_REQUEST['parentid']:$_REQUEST['parid'];

		if($singlepane_view == 'true')
			$action = "DetailView";
		else
			$action = "CallRelatedList";
		if(is_file("modules/$currentModule/$currentModule.php")) {
			require_once("modules/$currentModule/$currentModule.php");
			$focus = new $currentModule();
			$focus->save_related_module($currentModule, $forCRMRecord, $dest_mod, $_REQUEST['entityid']);
		}

		header("Location: index.php?action=$action&module=$currentModule&record=".$forCRMRecord."&parenttab=".$parenttab);
	}
	
	
}

?>
