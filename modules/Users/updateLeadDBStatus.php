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
require_once('include/utils/utils.php');

$idlist= $_REQUEST['idlist'];
$leadstatusval = $_REQUEST['leadval'];
$idval=$_REQUEST['user_id'];
$viewid = $_REQUEST['viewname'];
$return_module = $_REQUEST['return_module'];
$return_action = $_REQUEST['return_action'];
global $current_user;
global $adb;
$storearray = explode(";",trim($idlist,';'));

$ids_list = array();

$date_var = date('YmdHis');
$modulerel=getEntityTable($return_module);
$tablename=$modulerel['tablename'];
$fieldid=$modulerel['entityidfield'];

if((isset($_REQUEST['user_id']) && $_REQUEST['user_id']!=''))
{
	foreach($storearray as $id)
	{
		if(isPermitted($return_module,'EditView',$id) == 'yes')
		{
			if($_REQUEST['user_id'] != '' && $id != '')
			{
				if($return_module == "Accounts") {
					//$last_smownerid = getUserId($id);
					$ownersql = "select smownerid from ec_account where accountid='".$id."' and deleted=0";
		            $last_smownerid = $adb->getOne($ownersql);
					if($last_swownerid != $idval) {
						$sql = "update ec_account set smownerid=".$idval.",modifiedby=".$current_user->id.",modifiedtime=".$adb->formatDate(date('YmdHis'))."  where accountid='".$id."'";

						$query = "update ec_contactdetails set smownerid=".$idval.",modifiedby=".$current_user->id.", modifiedtime=".$adb->formatDate(date('YmdHis'))."  where accountid='".$id."'";
						$adb->query($query);

						$query = "update ec_notes set smownerid=".$idval.",modifiedby=".$current_user->id.", modifiedtime=".$adb->formatDate(date('YmdHis'))."  where accountid='".$id."'";
						$adb->query($query);
					}
				} else {
					//Now we have to update the smownerid
					$sql = "update ".$tablename." set modifiedby=".$current_user->id.",smownerid='" .$idval ."', modifiedtime=".$adb->formatDate(date('YmdHis'))." where ".$fieldid."='" .$id."'";
				}
				$result = $adb->query($sql);
			}
			
		}
		else
		{
			$ids_list[] = $id;
		}
	}
}
if(count($ids_list) > 0)
{
	$ret_owner = getEntityName($return_module,$ids_list);
        $errormsg = implode(',',$ret_owner);
}else
{
        $errormsg = '';
}

if($return_action == 'ActivityAjax')
{
	$view       = $_REQUEST['view'];
	$day        = $_REQUEST['day'];
	$month      = $_REQUEST['month'];
	$year       = $_REQUEST['year'];
	$type       = $_REQUEST['type'];
	$viewOption = $_REQUEST['viewOption'];
	$subtab     = $_REQUEST['subtab'];
	redirect("index.php?module=$return_module&action=".$return_action."&type=".$type."&view=".$view."&day=".$day."&month=".$month."&year=".$year."&viewOption=".$viewOption."&subtab=".$subtab);
}
else{
//redirect("index.php?module=$return_module&action=".$return_module."Ajax&file=ListView&ajax=changestate&viewname=".$viewid."&errormsg=".$errormsg);
redirect("index.php?module=Accounts&action=index"); 
}
?>
