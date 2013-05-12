<?php
require_once('include/CRMSmarty.php');
require_once('include/database/PearDatabase.php');
require_once('include/CustomFieldUtil.php');
require_once('include/utils/MultiFieldUtils.php');




global $mod_strings;
global $app_strings;
$smarty = new CRMSmarty();
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty->assign("IMAGE_PATH", $image_path);

$multifieldid=$_REQUEST["multifieldid"];
$fieldinfo=getMultiFieldInfo($multifieldid,false);
$smarty->assign("FieldInfo",$fieldinfo);
$tab_mod_strings = return_module_language($current_language, $fieldinfo['modulename']);
$smarty->assign("CMOD",$tab_mod_strings);
$smarty->assign("FieldInfo",$fieldinfo);
$smarty->assign("CFENTRIES",getCFListEntries($fieldinfo["fields"],$multifieldid,$tab_mod_strings));





$smarty->display('Settings/EditMultiCustomField.tpl');


	/**
	* Function to get customfield entries
	* @param string $module - Module name
	* return array  $cflist - customfield entries
	*/
function getCFListEntries($fields,$multifieldid,$tab_mod_strings)
{
	global $adb;
	global $theme;
	global $mod_strings;
	global $app_strings;
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	//$dbQuery = "select fieldid,columnname,fieldlabel,uitype,displaytype from ec_field where tabid=".$tabid." and generatedtype=2 order by sequence";
	
	$count=1;
	$cflist=Array();
    for($i=0;$i<count($fields);$i++){
            $eachfield=$fields[$i];
            $cf_element=Array();
			$cf_element['no']=$count;
            $multifieldlabel=$eachfield["fieldlabel"];
            if(isset($_REQUEST["multifieldlabel{$count}"])&&$_REQUEST["multifieldlabel{$count}"]!='') $multifieldlabel=$_REQUEST["multifieldlabel{$count}"];
			//Add for use mod_string field label
			if(!empty($multifieldlabel)&&!empty($tab_mod_strings[$multifieldlabel])) $multifieldlabel=$tab_mod_strings[$multifieldlabel];
			$cf_element['label']="<input name='multifieldlabel{$count}' id='multifieldlabel{$count}' type='text' value='$multifieldlabel'>";
            $optionsval=getMultiFieldOptions($multifieldid,$count,0,1);
			$fld_type_name = "
                <select id='multifieldvalue{$count}' name='multifieldvalue{$count}' onchange='updateChildOptions(\"$multifieldid\",\"$count\");'>$optionsval</select>
                <img src='{$image_path}editfield.gif' border='0' style='cursor:pointer;' onClick='getCreateCustomFieldForm(\"$multifieldid\",\"$count\",\"\",this);' alt='批量增加' title='批量增加'/>&nbsp;
                <img src='{$image_path}RolesEdit.gif' border='0' style='cursor:pointer;' onClick='getEditCustomFieldForm(\"$multifieldid\",\"$count\",\"\",this);' alt='修改下拉框选项' title='修改下拉框选项'/>&nbsp;
            ";


			$cf_element['type']=$fld_type_name;
            $typeofdata=$eachfield["typeofdata"];
            if(strpos($typeofdata,"~O")!==false){
                $checkedstr="";
            }else{
                $checkedstr="checked";
            }
			$cf_element['tool']="<input type='checkbox' name='multifieldcheck{$count}' $checkedstr value='1'>";

			$cflist[] = $cf_element;
			$count++;
    }
	
	
	return $cflist;
}




?>


