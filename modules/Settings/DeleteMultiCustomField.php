<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/MultiFieldUtils.php');
global $adb;

$multifieldid=$_REQUEST["multifieldid"];
$multifieldinfo=getMultiFieldInfo($multifieldid,false);
$fldmodule=$multifieldinfo["modulename"];

$adb->startTransaction();

deleteSingleField($multifieldinfo);

$deletesql="delete from ec_multifield where multifieldid='$multifieldid' ";
$adb->query($deletesql);
$adb->completeTransaction();
redirect("index.php?module=Settings&action=CustomMultiFieldList&fld_module=".$fldmodule."&parenttab=Settings");

function deleteSingleField($multifieldinfo){
    global $adb;
    foreach($multifieldinfo["fields"] as $eachfield){
        $id =  $eachfield["fieldid"];

        $colName = $eachfield["columnname"];
        $uitype = $eachfield["uitype"];
        //Deleting the CustomField from the Custom Field Table
        $query='delete from ec_field where fieldid="'.$id.'"';
        $adb->query($query);

        //Deleting from ec_def_org_field table
        $query='delete from ec_def_org_field where fieldid="'.$id.'"';
        $adb->query($query);

        //we have to remove the entries in customview and report related tables which have this field ($colName)
        $adb->query("delete from ec_cvcolumnlist where columnname like '%".$colName."%'");
        $adb->query("delete from ec_cvstdfilter where columnname like '%".$colName."%'");
        $adb->query("delete from ec_cvadvfilter where columnname like '%".$colName."%'");
        $adb->query("delete from ec_selectcolumn where columnname like '%".$colName."%'");
        $adb->query("delete from ec_relcriteria where columnname like '%".$colName."%'");
        $adb->query("delete from ec_reportsortcol where columnname like '%".$colName."%'");
        $adb->query("delete from ec_reportdatefilter where datecolumnname like '%".$colName."%'");
        $adb->query("delete from ec_reportsummary where columnname like '%".$colName."%'");
    }
    $tablename=$multifieldinfo["tablename"];
    $deltablequery = "drop table $tablename ";
	$adb->query($deltablequery);
}
?>
