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
require_once('include/CRMSmarty.php');
require_once('include/utils/MultiFieldUtils.php');
global $mod_strings;
global $app_strings;
global $app_list_strings, $current_language;

//$tableName=$_REQUEST["fieldname"];
//$moduleName=$_REQUEST["fld_module"];
//$uitype=$_REQUEST["uitype"];

$multifieldid=$_REQUEST["multifieldid"];
$level=$_REQUEST["level"];
$parentfieldid=$_REQUEST["parentfieldid"];

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$smarty = new CRMSmarty();

//Added to get the strings from language files if present
/*
if($moduleName == 'Events')
	$temp_module_strings = return_module_language($current_language, 'Calendar');
else
	$temp_module_strings = return_module_language($current_language, $moduleName);
*/
$fldVal=getMultiOptsStr($multifieldid,$level,$parentfieldid);
/*
$query = "select * from ec_".$tableName." where presence=0 order by sortorderid"; 
$result = $adb->query($query);
$fldVal='';

while($row = $adb->fetch_array($result))
{
	if($temp_module_strings[$row[$tableName]] != '')
		$fldVal .= $temp_module_strings[$row[$tableName]];
	else
		$fldVal .= $row[$tableName];
	$fldVal .= "\n";	
}
*/



if($nonedit_fldVal == '')
		$smarty->assign("EDITABLE_MODE","edit");
	else
		$smarty->assign("EDITABLE_MODE","nonedit");
$smarty->assign("NON_EDITABLE_ENTRIES", $nonedit_fldVal);
$smarty->assign("ENTRIES",$fldVal);
$smarty->assign("LEVEL",$level);
$smarty->assign("PARENTID",$parentfieldid);
//First look into app_strings and then mod_strings and if not available then original label will be displayed
$temp_label = isset($app_strings[$fieldlabel])?$app_strings[$fieldlabel]:(isset($mod_strings[$fieldlabel])?$mod_strings[$fieldlabel]:$fieldlabel);
$smarty->assign("FIELDLABEL",$temp_label);
$smarty->assign("MULTIFIELDID", $multifieldid);
$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("TEMP_MOD", $temp_module_strings);

$smarty->display("Settings/EditMultiPickList.tpl");

function getMultiOptsStr($multifieldid,$level,$parentid){
    global $adb;
    $optionsstr="";
       $multifieldinfo=getMultiFieldInfo($multifieldid,false);
       $tablename=$multifieldinfo["tablename"];
       $moduleName=$multifieldinfo["modulename"];
       if($moduleName == 'Events')
            $temp_module_strings = return_module_language($current_language, 'Calendar');
        else
            $temp_module_strings = return_module_language($current_language, $moduleName);
       if($level==1){
           $sql="select * from $tablename where thelevel=1 order by sortorderid asc";
           $result=$adb->getList($sql);
           foreach($result as $row)
           {
               if($temp_module_strings[$row["actualfieldname"]] != '')
                    $optionsstr .= $temp_module_strings[$row["actualfieldname"]];
                else
                    $optionsstr .= $row["actualfieldname"];

                $optionsstr .="\n";
//               $opttxt=$row["actualfieldname"];
//               $optionsstr.="<option value='$optval'>$opttxt</options>";
           }

       }else{
           $sql="select * from $tablename where thelevel=$level and parentfieldid='$parentid' order by sortorderid asc";
           $result=$adb->getList($sql);
           foreach($result as $row)
           {
               if($temp_module_strings[$row["actualfieldname"]] != '')
                    $optionsstr .= $temp_module_strings[$row["actualfieldname"]];
                else
                    $optionsstr .= $row["actualfieldname"];

                $optionsstr .="\n";
           }
       }
       return $optionsstr;
}
?>
