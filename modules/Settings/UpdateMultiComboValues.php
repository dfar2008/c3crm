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
require_once('include/utils/MultiFieldUtils.php');
$multifieldid=$_REQUEST["multifieldid"];
$level=$_REQUEST["level"];
$parentfieldid=$_REQUEST["parentfieldid"];
$fldPickList =  $_REQUEST['listarea'];
//changed by dingjianting on 2006-10-1 for picklist editor
$fldPickList = utf8RawUrlDecode($fldPickList); 
$multifieldinfo=getMultiFieldInfo($multifieldid,false);
$tablename=$multifieldinfo["tablename"];
$moduleName=$multifieldinfo["modulename"];
$totallevel=$multifieldinfo["totallevel"];

global $adb;


//changed by dingjianting on 2007-2-20 for picklist ,some items used in codes can not be changed such as close win.
if($level==1){
    $delquery="delete from $tablename ";
    $adb->query($delquery);
}else{
//    $delquery="delete from $tablename where thelevel>$level or (thelevel=$level and parentfieldid=$parentfieldid)";
    deleteSubOptionNode($multifieldid,$level,$totallevel,$parentfieldid,$tablename);
}

if(substr_count($fldPickList,"br") > 0) {
	$fldPickList = str_replace("&lt;","<",$fldPickList);
	$fldPickList = str_replace("&gt;",">",$fldPickList);
	$pickArray = explode("<br />",$fldPickList);
} else {
	$pickArray = explode("\n",$fldPickList);
}
$count = count($pickArray);
$tabname=explode('cf_',$tableName);

if($tabname[1]!='')
       	$custom=true;

for($i = 0; $i < $count; $i++)
{
	$pickArray[$i] = trim($pickArray[$i]);
	if($pickArray[$i] != '')
	{
		/*
		if($uitype == 111)
			$query = "insert into ec_".$tableName." values('','".$pickArray[$i]."',".$i.",0)";
		else
			$query = "insert into ec_".$tableName." values('','".$pickArray[$i]."',".$i.",1)";
        */
		//changed by dingjianting on 2007-2-20 for picklist ,some items used in codes can not be changed such as close win.
		$id = $adb->getUniqueID($tablename);
		$query = "insert into $tablename values('".$id."','".$pickArray[$i]."',".$i.",0,'$level','$parentfieldid')";
		//echo $query."<br>";
	    $adb->query($query);
	}
}
header("Location:index.php?action=SettingsAjax&module=Settings&directmode=ajax&file=PickList&fld_module=".$fld_module);
?>
