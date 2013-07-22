<?php


require_once("include/database/PearDatabase.php");
global $current_user;
global $adb;
$mod_strings =  return_specified_module_language("zh_cn","Settings"); 

$now = date("Y-m-d H:i:s");
$type = $_REQUEST['t'];
$userid = $_REQUEST['userid'];

if(empty($userid)){
	die("CurrentUser->ID is null,Please Check it!");
}
switch($type){
    case 'del':
        $sql = "update ec_users set deleted=1 where id=$userid";
    break;
    case 'on':
        $sql = "update ec_users set status='Active' where id=$userid";
    break;
    case 'off':
        $sql = "update ec_users set status='Forbidden'where id=$userid";
    break;
}
$adb->query($sql);

//$sql = "select * from ec_systemcharges where userid=$userid";
//$row = $adb->getFirstLine($sql);
//if(empty($row)){
//	die("System Charges No this Record!");
//}
//$endtime = $row['endtime'];
//
//$id = $adb->getUniqueID("ec_systemchargelogs");
//$query = "insert into ec_systemchargelogs(id,userid,modifiedby,endtime,modifiedtime,flag) values({$id},{$userid},'".$current_user->id."','".$endtime."','".$now."',0)";
//$adb->query($query);
//
//$updatesql = "update ec_systemcharges set endtime='0000-00-00 00:00:00' where userid=$userid ";
//$adb->query($updatesql); 


header("Location: index.php?module=Settings&parenttab=Settings&action=SmsUser");
?>
