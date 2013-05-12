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
require_once('include/CRMSmarty.php');
require_once('include/database/PearDatabase.php');
require_once('include/CustomFieldUtil.php');

/*
CREATE TABLE `ec_multifield` (
`multifieldid` INT( 19 ) NOT NULL ,
`multifieldname` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`tablename` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
PRIMARY KEY ( `multifieldid` ) ,
UNIQUE (
`tablename` 
)
)

ALTER TABLE `ec_field` ADD `multifieldid` INT( 19 ) NULL DEFAULT '0';
ALTER TABLE `ec_multifield` ADD `totallevel` INT( 11 ) NOT NULL DEFAULT '2';
ALTER TABLE `ec_multifield` ADD `tabid` INT( 19 ) NOT NULL DEFAULT '0';
uitype : 1021 level one  1022 level two 1023 level three
*/

global $mod_strings;
global $app_strings;
$smarty = new CRMSmarty();
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty->assign("IMAGE_PATH", $image_path);
$module_array=getCustomFieldSupportedModules();

$cfimagecombo = Array($image_path."text.gif",
$image_path."number.gif",
$image_path."percent.gif",
$image_path."currency.gif",
$image_path."date.gif",
$image_path."email.gif",
$image_path."phone.gif",
$image_path."picklist.gif",
$image_path."url.gif",
$image_path."checkbox.gif",
$image_path."text.gif",
$image_path."picklist.gif");

$cftextcombo = Array($mod_strings['Text'],
$mod_strings['Number'],
$mod_strings['Percent'],
$mod_strings['Currency'],
$mod_strings['Date'],
$mod_strings['Email'],
$mod_strings['Phone'],
$mod_strings['PickList'],
$mod_strings['LBL_URL'],
$mod_strings['LBL_CHECK_BOX'],
$mod_strings['LBL_TEXT_AREA'],
$mod_strings['LBL_MULTISELECT_COMBO']
);


$smarty->assign("MODULES",$module_array);
$smarty->assign("CFTEXTCOMBO",$cftextcombo);
$smarty->assign("CFIMAGECOMBO",$cfimagecombo);
if($_REQUEST['fld_module'] !='')
	$fld_module = $_REQUEST['fld_module'];
else
	$fld_module = 'Accounts';
$smarty->assign("MODULE",$fld_module);
$smarty->assign("CFENTRIES",getCFListEntries($fld_module));
if(isset($_REQUEST["duplicate"]) && $_REQUEST["duplicate"] == "yes")
{
	$error= $mod_strings['custom_field_exists'];
	$smarty->assign("DUPLICATE_ERROR", $error);
}

if($_REQUEST['mode'] !='')
	$mode = $_REQUEST['mode'];
$smarty->assign("MODE", $mode);

if($_REQUEST['ajax'] != 'true')
	$smarty->display('Settings/MultiCustomFieldList.tpl');	
else
	$smarty->display('Settings/MultiCustomFieldEntries.tpl');

	/**
	* Function to get customfield entries
	* @param string $module - Module name
	* return array  $cflist - customfield entries
	*/
function getCFListEntries($module)
{
	$tabid = getTabid($module);
	global $adb;
	global $theme;
	global $mod_strings;
	global $app_strings;
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	//$dbQuery = "select fieldid,columnname,fieldlabel,uitype,displaytype from ec_field where tabid=".$tabid." and generatedtype=2 order by sequence";
	$dbQuery = "select multifieldid,multifieldname,totallevel from ec_multifield  where tabid=".$tabid." order by multifieldid";
	$result = $adb->getList($dbQuery);
	$count=1;
	$cflist=Array();
		foreach($result as $row)
		{
			$cf_element=Array();
			$cf_element['no']=$count;
			$cf_element['label']=$row["multifieldname"];
			$fld_type_name = $row["totallevel"];
			/*
			if(isset($mod_strings[$fld_type_name])) {
				$fld_type_name = $mod_strings[$fld_type_name];
			}
			*/
			
			$cf_element['type']=$fld_type_name;
			$cf_element['tool']='<img src="'.$image_path.'editfield.gif" border="0" style="cursor:pointer;" onClick="gotoEditCustomField(\''.$module.'\',\''.$row["multifieldid"].'\',\''.$tabid.'\',\''.$row["uitype"].'\')" alt="'.$app_strings['LBL_EDIT'].'" title="'.$app_strings['LBL_EDIT'].'"/>&nbsp;
                   |&nbsp;<img style="cursor:pointer;" onClick="deleteMultiCustomField('.$row["multifieldid"].',\''.$module.'\', \''.$row["columnname"].'\', \''.$row["uitype"].'\')" src="'.$image_path.'delete.gif" border="0"  alt="'.$app_strings['LBL_DELETE'].'" title="'.$app_strings['LBL_DELETE'].'"/>
            ';

			$cflist[] = $cf_element;
			$count++;
		}
	return $cflist;
}

/**
* Function to Lead customfield Mapping entries
* @param integer  $cfid   - Lead customfield id
* return array    $label  - customfield mapping
*/
function getListLeadMapping($cfid)
{
	global $adb;
	$sql="select * from ec_convertleadmapping where cfmid =".$cfid;
	$result = $adb->query($sql);
	$noofrows = $adb->num_rows($result);
	for($i =0;$i <$noofrows;$i++)
	{
		$leadid = $adb->query_result($result,$i,'leadfid');
		$accountid = $adb->query_result($result,$i,'accountfid');
		$contactid = $adb->query_result($result,$i,'contactfid');
		$potentialid = $adb->query_result($result,$i,'potentialfid');
		$cfmid = $adb->query_result($result,$i,'cfmid');

		$sql2="select fieldlabel from ec_field where fieldid ='".$accountid."'";
		$result2 = $adb->query($sql2);
		$accountfield = $adb->query_result($result2,0,'fieldlabel');
		$label['accountlabel'] = $accountfield;
		
		$sql3="select fieldlabel from ec_field where fieldid ='".$contactid."'";
		$result3 = $adb->query($sql3);
		$contactfield = $adb->query_result($result3,0,'fieldlabel');
		$label['contactlabel'] = $contactfield;
		$sql4="select fieldlabel from ec_field where fieldid ='".$potentialid."'";
		$result4 = $adb->query($sql4);
		$potentialfield = $adb->query_result($result4,0,'fieldlabel');
		$label['potentiallabel'] = $potentialfield;
	}
	return $label;
}

/* function to get the modules supports Custom Fields
*/

function getCustomFieldSupportedModules()
{
	global $adb;
	$sql="select distinct ec_field.tabid,name from ec_field inner join ec_tab on ec_field.tabid=ec_tab.tabid where ec_field.tabid not in(7,9,10,29)";
	$result = $adb->getList($sql);
	foreach($result as $row)
	{
		$modulelist[$row['name']] = $row['name'];
	}
	return $modulelist;
}
?>
