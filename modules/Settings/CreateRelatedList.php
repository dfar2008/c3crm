<?php
global $mod_strings,$theme;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";



$fld_module=$_REQUEST['fld_module'];
$label=$_REQUEST['label'];
$sequence=$_REQUEST['sequence'];
$relation_id=$_REQUEST['relation_id'];
$presence = $_REQUEST['presence'];
if($presence == '0') {
	$presence = "checked";
} else {
	$presence = "";
}

$output .= '<div id="createRelatedListLayer" style="display:block;" class="layerPopup">
	<form action="index.php" method="post" name="addtodb" onSubmit="return validate_relatedlist()">
	  <input type="hidden" name="module" value="Settings">
	  <input type="hidden" name="fld_module" value="'.$fld_module.'">
	  <input type="hidden" name="parenttab" value="Settings">
      <input type="hidden" name="action" value="AddRelatedListToDB">
	  <input type="hidden" name="relation_id" value="'.$relation_id.'">
	  <input type="hidden" name="mode" value="'.$mode.'">

	  
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
			<tr style="cursor:move;">';
			$output .= '<td id="createRelatedListLayer_title" width="90%" align="left" class="layerPopupHeading">'.$mod_strings['LBL_EDIT_RELEATEDLIST'].'</td>';
			$output .= '<td width="10%" align="right"><a href="javascript:fninvsh(\'createRelatedListLayer\');"><img src="'.$image_path.'close.gif" border="0"  align="absmiddle" /></a></td>
			</tr></table>';
			
			
			$output .= '<table width="100%" border="0" cellpadding="5" cellspacing="0" class="small"><tr>
					<td width="50%" class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['RELATED_MODULE'].'</b></td>
					<td width="50%" align="left"><input type="text"  readonly=true size=20 name="label" value="'.$label.'" class="txtBox"></td>
				</tr>
				<tr>
					<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['MODULE_ORDER'].'</b></td>
					<td align="left"><input type="text" size=20 name="sequence" value="'.$sequence.'" class="txtBox"></td>
				</tr>
				<tr>
					<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['IS_PRESENSE'].'</b></td>
					<td align="left"><input type="checkbox" size=20 name="presence" value="1" '.$presence.' class="txtBox"></td>
				</tr>';
			
				$output .= '	
					</table>
	<table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
			<tr>
				<td align="center">
					<input type="submit" name="save" value=" &nbsp; '.$app_strings['LBL_SAVE_BUTTON_LABEL'].' &nbsp; " class="crmButton small save" />&nbsp;
					<input type="button" name="cancel" value=" '.$app_strings['LBL_CANCEL_BUTTON_LABEL'].' " class="crmButton small cancel" onclick="fninvsh(\'createRelatedListLayer\');" />
				</td>
			</tr>
	</table>
	<script id="createRelatedListLayer_js" language="javascript">
	Drag.init(document.getElementById("createRelatedListLayer_title"), document.getElementById("createRelatedListLayer"));
	</script>
	</form></div>';
echo $output;
?>
