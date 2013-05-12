<?php
require_once('include/database/PearDatabase.php');
require_once('include/CustomFieldUtil.php');
require_once('include/utils/MultiFieldUtils.php');

$multifieldid=$_REQUEST["multifieldid"];
$level=$_REQUEST["level"];
$parentfieldid=$_REQUEST["parentfieldid"];

global $adb;
$optionsval=getMultiFieldOptions($multifieldid,$level+1,$parentfieldid,1);
echo $optionsval;
?>
