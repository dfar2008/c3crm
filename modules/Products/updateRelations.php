<?php
require_once('include/database/PearDatabase.php');
require_once('user_privileges/default_module_view.php');
global $adb, $singlepane_view,$currentModule;
$returnmodule = $_REQUEST['return_module'];
if(isset($_REQUEST['idlist']) && $_REQUEST['idlist'] != '')
{
	if($_REQUEST['destination_module'] != "Accounts") {
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
	else {
		//split the string and store in an array
		$idlist = $_REQUEST['idlist'];
		$storearray = explode (";",$idlist);
		foreach($storearray as $id)
		{
			if($id != '')
			{
				$sql = "insert into ec_accountproductrel values (".$id.",". $_REQUEST["parentid"] .")";
				$adb->query($sql);
			}
		}
		if($singlepane_view == 'true')
			header("Location: index.php?action=DetailView&module=Products&record=".$_REQUEST["parentid"]);
		else
			header("Location: index.php?action=CallRelatedList&module=Products&record=".$_REQUEST["parentid"]);
	}
}
elseif(isset($_REQUEST['entityid']) && $_REQUEST['entityid'] != '')
{		
	$return_action = 'DetailView';
	if($_REQUEST['return_action'] != '')
		$return_action = $_REQUEST['return_action'];

	//This if will be true, when we select product from vendor related list
	if($_REQUEST['destination_module'] == 'Products')
	{
		if($_REQUEST['parid'] != '' && $_REQUEST['entityid'] != '')
		{
			$sql = "update ec_products set vendor_id=".$_REQUEST['parid']." where productid=".$_REQUEST['entityid'];
			$adb->query($sql);
		}
		header("Location:index.php?action=$return_action&module=Vendors&record=".$_REQUEST["parid"]);
		
	}
	elseif($_REQUEST['destination_module'] == 'Contacts')
	{
		if($_REQUEST['smodule']=='VENDOR')
		{
			$sql = "insert into ec_vendorcontactrel values (".$_REQUEST['parid'].",".$_REQUEST['entityid'].")";
			$adb->query($sql);
		}
		header("Location:index.php?action=$return_action&module=Vendors&record=".$_REQUEST["parid"]);
	}

	elseif($_REQUEST['destination_module'] == 'Accounts')
	{
			$sql = "insert into ec_accountproductrel values (". $_REQUEST["entityid"] .",".$_REQUEST["parid"] .")";
			$adb->query($sql);
			header("Location:index.php?action=$return_action&module=Products&record=".$_REQUEST["parid"]);
	} 
	else
	{
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
