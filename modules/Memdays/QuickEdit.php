<?php
require_once('include/CRMSmarty.php');
require_once('modules/Memdays/Memdays.php');
require_once('include/utils/utils.php');

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;
$focus = new Memdays();
$focus->mode = '';
$disp_view = getView($focus->mode);
$display_type_check = "ec_field.displaytype in (1,4) and ec_field.uitype not in(53,51,1004,10) and ec_field.fieldname not in('account_id','contact_id') ";

$smarty = new CRMSmarty();
$smarty->assign("IMAGE_PATH", "themes/$theme/images/");
$smarty->assign("THEME", $theme);
$smarty->assign('APP', $app_strings);
$smarty->assign('MOD', $mod_strings);
$smarty->assign('SELECT', $app_strings["--Select--"]);
$smarty->assign("BLOCKS",getBlocksForQuickEdit($currentModule,$disp_view,$mode,$focus->column_fields,$display_type_check));	
// Field Validation Information 
$tabid = getTabid($currentModule);
$data = getQuickValidationData($tabid,$display_type_check);

$smarty->assign("VALIDATION_DATA_FIELDNAME",$data['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$data['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL",$data['fieldlabel']);

$smarty->display('QuickEditForm.tpl');

/**
 * This function returns the ec_blocks and its related information for given module.
 * Input Parameter are $module - module name, $disp_view = display view (edit,detail or create),$mode - edit, $col_fields - * column ec_fields/
 * This function returns an array
 */

function getBlocksForQuickEdit($module,$disp_view,$mode,$col_fields='',$display_type_check)
{
	global $log;
	$log->debug("Entering getBlocksForQuickEdit() method ...");
	global $adb,$current_user;
	global $mod_strings;
	$tabid = getTabid($module);
	$block_detail = Array();
	$getBlockinfo = "";
	$prev_header = "";
	$query="select blockid,blocklabel,show_title from ec_blocks where tabid=$tabid and $disp_view=0 and visible = 0 order by sequence";
	$result = $adb->query($query);
	$noofrows = $adb->num_rows($result);	
	$blockid_list ='(';
	for($i=0; $i<$noofrows; $i++)
	{
		$blockid = $adb->query_result($result,$i,"blockid");
		if($i != 0) {
			$blockid_list .= ', ';
		}
		$blockid_list .= $blockid;
		$block_label[$blockid] = $adb->query_result($result,$i,"blocklabel");
	}
	$blockid_list .= ')';	
	//retreive the ec_profileList from database
	require('user_privileges/user_privileges_'.$current_user->id.'.php');
	
	if($is_admin==true)
	{
		$sql = "SELECT ec_field.* FROM ec_field INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid AND ec_def_org_field.visible=0 WHERE ec_field.tabid=".$tabid." AND ec_field.block IN ".$blockid_list." AND ".$display_type_check." ORDER BY block,sequence";
	}
	else
	{
		$profileList = getCurrentUserProfileList();
		$sql = "SELECT ec_field.*,ec_profile2field.readonly as profile_readonly FROM ec_field INNER JOIN ec_profile2field ON ec_profile2field.fieldid=ec_field.fieldid INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid  WHERE ec_field.tabid=".$tabid." AND ec_field.block IN ".$blockid_list." AND ".$display_type_check." AND ec_def_org_field.visible=0 AND ec_profile2field.visible=0 AND ec_profile2field.profileid IN ".$profileList." ORDER BY block,sequence";
	}
	$result = $adb->query($sql);
	$getBlockInfo=getBlockInformation($module,$result,$col_fields,$tabid,$block_label,$mode);
	$index_count =1;
	$max_index =0;
	if(!isset($getBlockInfo)) {
		$getBlockInfo = array();
	}
	foreach($getBlockInfo as $label=>$contents)
	{
			$no_rows = count($contents);	
			$index_count = $max_index+1;
		foreach($contents as $block_row => $elements)
		{
			$max_index= $no_rows+$index_count;
			
			for($i=0;$i<count($elements);$i++)
			{	
				if(isset($getBlockInfo[$label][$block_row][$i]) && sizeof($getBlockInfo[$label][$block_row][$i])!=0)
				{
					if($i==0)
					$getBlockInfo[$label][$block_row][$i][]=array($index_count);
					else
					$getBlockInfo[$label][$block_row][$i][]=array($max_index);
				}
			}
			$index_count++;
			
		}
	}
	$log->debug("Exiting getBlocksForQuickEdit method ...");
	return $getBlockInfo;
}

/**
* merged with getDBValidationData and split_validationdataArray functions for performance
*/

function getQuickValidationData($tabid,$display_type_check)
{
	global $log;
	$log->debug("Entering getQuickValidationData() method ...");
	$key = "quickedit_validationdata_".$tabid;
	$validationData = getSqlCacheData($key);
	if(!$validationData) {
		$sql = '';
		global $adb,$mod_strings,$current_user;
		//retreive the ec_profileList from database
		require('user_privileges/user_privileges_'.$current_user->id.'.php');

		$sql = "SELECT ec_field.* FROM ec_field INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid AND ec_def_org_field.visible=0 WHERE ec_field.tabid=".$tabid." AND ec_field.block IN ".$blockid_list." AND ".$display_type_check." ORDER BY block,sequence";
		$result = $adb->query($sql);
		$noofrows = $adb->num_rows($result);
		$fieldName_array = Array();
		for($i=0;$i<$noofrows;$i++)
		{
			$fieldlabel = $mod_strings[$adb->query_result($result,$i,'fieldlabel')];
			$fieldname = $adb->query_result($result,$i,'fieldname');
			$typeofdata = $adb->query_result($result,$i,'typeofdata');
			$fldLabel_array = Array();
			$fldLabel_array[$fieldlabel] = $typeofdata;
			$fieldName_array[$fieldname] = $fldLabel_array;
		}
		$validationData = split_validationdataArray($fieldName_array);
		setSqlCacheData($key,$validationData);
	}
	$log->debug("Exiting getQuickValidationData method ...");
	return $validationData;
}

?>
