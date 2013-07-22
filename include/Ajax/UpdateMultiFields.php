<?php
require_once('include/database/PearDatabase.php');
require_once('include/CustomFieldUtil.php');
require_once('include/utils/MultiFieldUtils.php');

$multifieldid=$_REQUEST["multifieldid"];
$level=$_REQUEST["level"];
$parentfieldid=$_REQUEST["parentfieldid"];

global $adb;
$options=getMultiFieldOptions($multifieldid,$level+1,$parentfieldid,2); 
if(empty($options)) die;
$resstr="$(function(){"; 
//$resstr="<script>"; 
foreach($options as $eachopt){
    $fieldname=$eachopt[0];
    $optvalue=$eachopt[1];
     $resstr.="$('#$fieldname').html('$optvalue');";
}
//$resstr.="</script>";
$resstr .= "});";
echo $resstr;
?>
