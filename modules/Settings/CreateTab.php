<?php
require_once('include/CRMSmarty.php');
require_once("include/tabgroup/TemplateGroupChooser.php");
global $mod_strings,$app_strings,$app_list_strings,$theme,$adb;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$id = "";
$parenttab_label_cn = "";
$displayed_modules = array();
$system_modules = array();
if(isset($_REQUEST['id'])) {
	$id=$_REQUEST['id'];
	$query = "select * from ec_parenttab where parenttabid='".$id."'";
	$row = $adb->getFirstLine($query);
	if($row) {
		if(isset($app_strings[$row['parenttab_label']])) {
			$parenttab_label_cn = $app_strings[$row['parenttab_label']];
		} else {
			$parenttab_label_cn = $row['parenttab_label'];
		}
		$parenttab_label = $row['parenttab_label'];

		$sequence = $row['sequence'];
	}
	$query = "select ec_parenttabrel.tabid,ec_tab.name from ec_parenttab left join ec_parenttabrel on ec_parenttabrel.parenttabid=ec_parenttab.parenttabid left join ec_tab on ec_tab.tabid=ec_parenttabrel.tabid where ec_parenttab.parenttabid='".$id."' order by ec_parenttabrel.sequence";
	//echo $query;
	$result = $adb->getList($query);
	foreach($result as $row) {
		if(isset($app_strings[$row['name']])) {
			$displayed_modules[$row['tabid']] = $app_strings[$row['name']];
		} else {
			$displayed_modules[$row['tabid']] = $row['name'];
		}
	}

} else {
	$parenttab_label = "";
	$sequence = "";
}
$query = "select tabid,name from ec_tab where tabid not in(1,7,24,27,29) order by tabsequence";
//echo $query;
$result = $adb->getList($query);
foreach($result as $row) {
	if(isset($app_strings[$row['name']])) {
		$system_modules[$row['tabid']] = $app_strings[$row['name']];
	} else {
		$system_modules[$row['tabid']] = $row['name'];
	}
}
$system_modules = array_diff($system_modules,$displayed_modules);

$smarty = new CRMSmarty();

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty->assign("IMAGE_PATH", $image_path);
$parentTabArr = getParentTabs();

$output .= '
	<form action="index.php" method="post" name="addtodb" onSubmit="return validate_tab()">
	  <input type="hidden" name="module" value="Settings">
      <input type="hidden" name="action" value="AddTabToDB">
	  <input type="hidden" name="id" value="'.$id.'">
	  <input type="hidden" name="mode" value="'.$mode.'">
	  <input type="hidden" name="display_tabs_def">
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
			<tr>';
			$output .= '<table width="30%" border="0" cellpadding="5" cellspacing="0" class="small"><tr>
					<td width="50%" class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['PARENT_TAB_EN'].'</b></td>
					<td width="50%" class="dvtCellInfo" align="left"><input type="text" size=20 name="parenttab_label" value="'.$parenttab_label.'" class="txtBox"></td>
				</tr>
				<tr>
					<td width="50%" class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['PARENT_TAB_CN'].'</b></td>
					<td width="50%" class="dvtCellInfo" align="left"><input type="text" size=20 name="parenttab_label_cn" value="'.$parenttab_label_cn.'" class="txtBox"></td>
				</tr>
				<tr>
					<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['MODULE_ORDER'].'</b></td>
					<td class="dvtCellInfo" align="left"><input type="text" size=5 name="sequence" value="'.$sequence.'" class="txtBox"></td>
				</tr></table>';
			$output .= '<table width="100%" border="0" cellpadding="5" cellspacing="0" class="small"><tr><td>';
$chooser = new TemplateGroupChooser();
$chooser->args['id'] = 'edit_tabs';
//$chooser->args['values_array'] = $focus->display_tabs;
$chooser->args['values_array'][0] = $displayed_modules;
$chooser->args['values_array'][1] = $system_modules;
$chooser->args['left_name'] = 'display_tabs';
$chooser->args['right_name'] = 'hide_tabs';
$chooser->args['left_label'] =  $mod_strings['LBL_DISPLAY_TABS'];
$chooser->args['right_label'] =  $mod_strings['LBL_HIDE_TABS'];
$chooser->args['title'] =  $mod_strings['LBL_EDIT_TABS'];
/*
foreach ($chooser->args['values_array'][0] as $key=>$value)
{
	$chooser->args['values_array'][0][$key] = $app_list_strings['moduleList'][$key];
}
foreach ($chooser->args['values_array'][1] as $key=>$value)
{
	$chooser->args['values_array'][1][$key] = $app_list_strings['moduleList'][$key];
}
*/
//$xtpl->assign("TAB_CHOOSER", $chooser->display());
$output .= $chooser->display();
			
				$output .= '</td></tr></table>				
	<table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
			<tr>
				<td align="left">
					<input type="submit" name="save" onClick="set_chooser();" value=" &nbsp; '.$app_strings['LBL_SAVE_BUTTON_LABEL'].' &nbsp; " class="crmButton small save" />&nbsp;
					<input type="button" name="cancel" value=" '.$app_strings['LBL_CANCEL_BUTTON_LABEL'].' " class="crmButton small cancel" onclick="javascript:document.location.href=\'index.php?module=Settings&action=CustomTabList&parenttab=Settings\';" />
				</td>
			</tr>
	</table>
	</form></div>';
$smarty->assign("OUTPUT", $output);
$smarty->display('Settings/CreateTab.tpl');


function getParentTabs(){
	global $adb;
	global $app_strings;
	$dbQuery = "SELECT parenttabid,parenttab_label FROM ec_parenttab order by parenttabid";
	$result = $adb->getList($dbQuery);
	$parenttab_list = Array();
	foreach($result as $row)
	{
		if(isset($app_strings[$row["parenttab_label"]])) {
			$parenttab_list[$row['parenttabid']] = $app_strings[$row["parenttab_label"]];
		} else {
			$parenttab_list[$row['parenttabid']] = $row["parenttab_label"];
		}
		
	}
	return $parenttab_list;
}
?>
