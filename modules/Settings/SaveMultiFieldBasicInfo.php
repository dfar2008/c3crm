<?php
require_once('include/database/PearDatabase.php');
global $adb;

$multifieldid=$_REQUEST["multifieldid"];
$sql="select ec_multifield.totallevel,ec_tab.name as modulename from ec_multifield inner join ec_tab on ec_tab.tabid=ec_multifield.tabid where ec_multifield.multifieldid='{$multifieldid}'";
$result=$adb->query($sql);
$totallevel=$adb->query_result($result,0,"totallevel");
$fldmodule=$adb->query_result($result,0,"modulename");
for($i=1;$i<=$totallevel;$i++){
    saveSingleFieldInf($i,$multifieldid);
}
$multifieldname=$_REQUEST["multifieldname"];
$updatesql="update ec_multifield set multifieldname='$multifieldname' where multifieldid='{$multifieldid}' ";
$adb->query($updatesql);

redirect("index.php?module=Settings&action=CustomMultiFieldList&fld_module=".$fldmodule."&parenttab=Settings");

function saveSingleFieldInf($level,$multifieldid){
    global $adb;
    $uitype=1020+$level;
    $labelname=$_REQUEST["multifieldlabel{$level}"];
    $mustfill=$_REQUEST["multifieldcheck{$level}"];
    $typeofdata=getOriginalTypedata($level,$multifieldid);
    if(isset($mustfill)&&$mustfill=='1'){
        $typeofdata=str_replace("~O","~M",$typeofdata);
    }else{
        $typeofdata=str_replace("~M","~O",$typeofdata);
    }
    $updatesql="update ec_field set fieldlabel='$labelname',typeofdata='$typeofdata' where uitype='$uitype' and typeofdata like '%::$multifieldid%' ";
    $adb->query($updatesql);
}

function getOriginalTypedata($level,$multifieldid){
    global $adb;
    $uitype=1020+$level;
    $sql="select typeofdata from ec_field where uitype='$uitype' and typeofdata like '%::$multifieldid%' ";
    $result=$adb->query($sql);
    $typeofdata=$adb->query_result($result,0,"typeofdata");
    return $typeofdata;
}
?>
