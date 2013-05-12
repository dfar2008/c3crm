<?php
require_once('include/CustomFieldUtil.php');
global $mod_strings,$app_strings,$app_list_strings,$theme,$adb;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


require_once('include/utils/CommonUtils.php');

$tabid=$_REQUEST['tabid'];
$fieldid=$_REQUEST['fieldid'];
$fieldlabel=$_REQUEST['fieldlabel'];
$order=$_REQUEST['order'];
$blockid=$_REQUEST['blockid'];
$blocklabel=$_REQUEST['blocklabel'];
$typeofdata=$_REQUEST['typeofdata'];
$fieldmandatory = "";
if($typeofdata == "true") {
	$fieldmandatory = "checked";
}


$blockArr = getCustomBlocks($_REQUEST['fld_module'],$tabid);
//print_r($blockArr);
$output .= '<div id="layoutLayer" style="display:block;" class="layerPopup">
	<form action="index.php" method="post" name="addtodb" onSubmit="return validate_layout()">
	  <input type="hidden" name="module" value="Settings">
	  <input type="hidden" name="fld_module" value="'.$_REQUEST['fld_module'].'">
	  <input type="hidden" name="parenttab" value="Settings">
      <input type="hidden" name="action" value="AddCustomLayoutToDB">
	  <input type="hidden" name="blockid" value="'.$blockid.'">
	  <input type="hidden" name="fieldid" value="'.$fieldid.'">
	  <input type="hidden" name="mode" value="'.$mode.'">

	  
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
			<tr style="cursor:move;">';
			if($mode == 'edit')
				$output .= '<td id="layoutLayer_title" width="90%" align="left" class="layerPopupHeading">'.$mod_strings['LBL_EDIT_LAYOUT'].'</td>';
			else
				$output .= '<td id="layoutLayer_title" width="90%" align="left" class="layerPopupHeading">'.$mod_strings['LBL_ADD_LAYOUT'].'</td>';
				
			$output .= '<td width="10%" align="right"><a href="javascript:fninvsh(\'layoutLayer\');"><img src="'.$image_path.'close.gif" border="0"  align="absmiddle" /></a></td>
			</tr></table>';
			
			
			$output .= '<table width="100%" border="0" cellpadding="5" cellspacing="0" class="small"><tr>
					<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['FIELD_LABEL'].'</b></td>
					<td align="left"><input type="text" size=20 name="fieldlabel" value="'.$fieldlabel.'" class="txtBox"></td>
				</tr>
				<tr>
					<td width="50%" class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['LBL_LAYOUT_LABEL'].'</b></td>
					<td width="50%" align="left"><select name="blockid">'.get_select_options($blockArr, $blockid).'</select></td>
				</tr>
				<tr>
					<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['LBL_MANDATORY'].'</b></td>
					<td align="left"><input name="fldMandatory" value="1" '.$fieldmandatory.' type="checkbox" class="txtBox"></td>
				</tr>
				<tr>
					<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['LBL_BLOCK_ORDER'].'</b></td>
					<td align="left"><input type="text" size=20 name="order" value="'.$order.'" class="txtBox"></td>
				</tr>';
			
				$output .= '	
					</table>
	<table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
			<tr>
				<td align="center">
					<input type="submit" name="save" value=" &nbsp; '.$app_strings['LBL_SAVE_BUTTON_LABEL'].' &nbsp; " class="crmButton small save" />&nbsp;
					<input type="button" name="cancel" value=" '.$app_strings['LBL_CANCEL_BUTTON_LABEL'].' " class="crmButton small cancel" onclick="fninvsh(\'layoutLayer\');" />
				</td>
			</tr>
	</table>
	<script id="blocklayer_js" language="javascript">
	Drag.init(document.getElementById("layoutLayer_title"), document.getElementById("layoutLayer"));
	</script>
	</form></div>';
echo $output;

function getCustomBlocks($module,$tabid){
   	//$tabid = getTabid($module);
	global $adb;
	global $theme;
	global $current_language;
	$cur_module_strings = return_specified_module_language($current_language,$module);
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	$dbQuery = "select blockid,blocklabel,sequence from ec_blocks where tabid=$tabid and visible = 0 order by sequence";
	$result = $adb->getList($dbQuery);
	$cflist = Array();
	foreach($result as $row)
	{
		if(isset($cur_module_strings[$row["blocklabel"]])) {
			$cflist[$row['blockid']] = $cur_module_strings[$row["blocklabel"]];
		} else {
			$cflist[$row['blockid']] = $row["blocklabel"];
		}
		
	}
	return $cflist;
}
?>
