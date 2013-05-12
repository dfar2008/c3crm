<?php
require_once("include/database/PearDatabase.php");
global $adb;
$del_id =  $_REQUEST['delete_user_id'];
$tran_id = $_REQUEST['transfer_user_id'];

if($del_id == 1) {
	redirect("index.php?module=Home&action=index");
}
//Updating the smcreatorid,smownerid, modifiedby in ec_crmentity
//$sql1 = "update ec_crmentity set smcreatorid=".$tran_id." where smcreatorid=".$del_id;
//$adb->query($sql1);
/*$sql="select tablename from ec_field where columnname='smownerid' ";
$result=$adb->query($sql);
$num_rows = $adb->num_rows($result);
for($i=0; $i<$num_rows; $i++)
{
    $ec_crmentity = $adb->query_result($result,$i,'tablename');
    $sql2 = "update $ec_crmentity set smownerid=".$tran_id." where smownerid=".$del_id;
    $adb->query($sql2);
    $sql3 = "update $ec_crmentity set modifiedby=".$tran_id." where modifiedby=".$del_id;
    $adb->query($sql3);
}*/
$tab_arr = array('ec_account','ec_notes','ec_memdays','ec_salesorder','ec_products');
foreach($tab_arr as $tab)
{
	$sql2 = "update $tab set smownerid=".$tran_id." where smownerid=".$del_id;
    $adb->query($sql2);
    $sql3 = "update $tab set modifiedby=".$tran_id." where modifiedby=".$del_id;
    $adb->query($sql3);
}
//deleting from ec_tracker
$sql4 = "delete from ec_tracker where user_id='".$del_id."'";
$adb->query($sql4);

//updating the ec_import_maps ec_table
$sql5 ="update ec_import_maps set assigned_user_id='".$tran_id."' where assigned_user_id='".$del_id."'";
$adb->query($sql5);

//update assigned_user_id in ec_users_last_import
$sql6 = "update ec_users_last_import set assigned_user_id='".$tran_id."' where assigned_user_id='".$del_id."'";
$adb->query($sql6);

//delete from user ec_table;
$sql7 = "update ec_users set deleted=1,status='Inactive' where id=".$del_id;
$adb->query($sql7);

?>
