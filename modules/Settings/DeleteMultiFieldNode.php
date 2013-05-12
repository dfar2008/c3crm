<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/MultiFieldUtils.php');
global $adb;

$multifieldid=$_REQUEST["multifieldid"];
$level=$_REQUEST["level"];
$parentfieldid=$_REQUEST["parentfieldid"];

$multifieldinfo=getMultiFieldInfo($multifieldid);
$tablename=$multifieldinfo["tablename"];
$totallevel=$multifieldinfo["totallevel"];

$delfieldid =  $_REQUEST['catalogid'];

$sql="select sortorderid from $tablename where actualfieldid='$delfieldid'";
$result=$adb->query($sql);
$sortorderid=$adb->query_result($result,0,"sortorderid");
if($level==1){
    $updatesql="update $tablename set sortorderid=sortorderid-1 where thelevel=1 and sortorderid>$sortorderid";
}else{
    $updatesql="update $tablename set sortorderid=sortorderid-1 where thelevel=$level and parentfieldid='$parentfieldid' and sortorderid>$sortorderid";
}
$adb->query($updatesql);
//$deletesql="delete from $tablename where actualfieldid='$delfieldid' ";
//$adb->query($deletesql);
deleteOptionNode($multifieldid,$delfieldid ,$level,$totallevel,$tablename);

$loc = "Location: index.php?action=PopupMultiFieldTree&module=Settings&multifieldid={$multifieldid}&level={$level}&parentfieldid={$parentfieldid}";
header($loc);

?>
