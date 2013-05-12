<?php

require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/utils.php');

global $mod_strings;
global $app_strings;
global $app_list_strings;

$smarty = new CRMSmarty();


global $adb;
global $theme;
global $theme_path;
global $image_path;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$field_module = array();
$result = $adb->query("select name from ec_tab where reportable=1 order by tabid");
$num_rows = $adb->num_rows($result);
for($i=0; $i<$num_rows; $i++)
{
	$modulename = $adb->query_result($result,$i,'name');
	$field_module[] = $modulename;
		 
}
$allfields = Array();
foreach($field_module as $fld_module)
{
	$language_strings = return_module_language($current_language,$fld_module);
	$allfields[$fld_module] = getStdOutput($fld_module,$language_strings);
}

if($_REQUEST['fld_module'] != '')
	$smarty->assign("DEF_MODULE",$_REQUEST['fld_module']);
else
	$smarty->assign("DEF_MODULE",'Quotes');



/** Function to get the field label/permission array to construct the default orgnization field UI for the specified profile 
  * @param $fieldListResult -- mysql query result that contains the field label and uitype:: Type array
  * @param $lang_strings -- i18n language mod strings array:: Type array
  * @param $profileid -- profile id:: Type integer
  * @returns $standCustFld -- field label/permission array :: Type varchar
  *
 */	
function getStdOutput($fld_module, $lang_strings)
{
	global $adb;
	global $image_path;
	$standCustFld = Array();
    $tabid = getTabid($fld_module);
    $query = "SELECT ec_field.columnname,ec_field.fieldlabel,ec_relmodfieldlist.fieldname,ec_relmodfieldlist.width,ec_relmodfieldlist.module,ec_field.fieldid,ec_field.sequence
          FROM ec_field inner join ec_def_org_field on ec_def_org_field.fieldid=ec_field.fieldid left join ec_relmodfieldlist on ec_relmodfieldlist.fieldname=ec_field.columnname and ec_relmodfieldlist.module='$fld_module'
          WHERE ec_def_org_field.visible=0 and ec_field.tabid='".$tabid."' and ec_field.uitype not in(19,69,61,30,105) union SELECT ec_field.columnname,ec_field.fieldlabel,ec_relmodfieldlist.fieldname,ec_relmodfieldlist.width,ec_relmodfieldlist.module,ec_field.fieldid,ec_field.sequence
          FROM ec_field left join ec_relmodfieldlist on ec_relmodfieldlist.fieldname=ec_field.columnname and ec_relmodfieldlist.module='$fld_module'
          WHERE ec_field.columnname='total' and ec_field.displaytype=3 and ec_field.tabid='".$tabid."' order by sequence";
   //     echo $query;
	$result = $adb->query($query);
    $noofrows = $adb->num_rows($result);
	for($i=0; $i<$noofrows; $i++,$row++)
	{
		$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
		$fieldname = $adb->query_result($result,$i,"fieldname");
		$fieldwidth = $adb->query_result($result,$i,"width");
		if($lang_strings[$fieldlabel] !='')
		{
			$standCustFld []=$lang_strings[$fieldlabel];
		}
		else
		{
			$standCustFld []=$fieldlabel;
		}
		
		if( $adb->query_result($result,$i,"fieldname") !='')
		{
			$visible = "<img src=".$image_path."/prvPrfSelectedTick.gif>";
			if($fieldwidth != null)
			{
				$width = $fieldwidth;
				$width = (int)($width);
			}
			else
			{
				$width ='0';
			}
		}
		else
		{
			$visible = "<img src=".$image_path."/no.gif>";
			$width = '0';
		}
               
		$standCustFld []= $visible;
        $standCustFld []= $width;
	}
	$standCustFld=array_chunk($standCustFld,3);
	$standCustFld=array_chunk($standCustFld,4);	
	return $standCustFld;
}

$smarty->assign("FIELD_INFO",$field_module);
$smarty->assign("FIELD_LISTS",$allfields);
$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MODE",'view');
$smarty->display("Settings/RelmodFieldAccess.tpl");
?>
