<?php
global $mod_strings,$app_strings,$app_list_strings,$theme,$adb;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";



$tabid=$_REQUEST['tabid'];
$label=$_REQUEST['label'];
$order=$_REQUEST['order'];
$blockid=$_REQUEST['blockid'];

$output .= '<div id="blockLayer" style="display:block;" class="layerPopup">
	<form action="index.php" method="post" name="addtodb" onSubmit="return validate_block()">
	  <input type="hidden" name="module" value="Settings">
	  <input type="hidden" name="fld_module" value="'.$_REQUEST['fld_module'].'">
	  <input type="hidden" name="parenttab" value="Settings">
      <input type="hidden" name="action" value="AddCustomBlockToDB">
	  <input type="hidden" name="blockid" value="'.$blockid.'">
	  <input type="hidden" name="mode" value="'.$mode.'">

	  
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
			<tr style="cursor:move;">';
			if($mode == 'edit')
				$output .= '<td id="blockLayer_title" width="90%" align="left" class="layerPopupHeading">'.$mod_strings['LBL_EDIT_BLOCK'].'</td>';
			else
				$output .= '<td id="blockLayer_title" width="90%" align="left" class="layerPopupHeading">'.$mod_strings['LBL_ADD_BLOCK'].'</td>';
				
			$output .= '<td width="10%" align="right"><a href="javascript:fninvsh(\'blockLayer\');"><img src="'.$image_path.'close.gif" border="0"  align="absmiddle" /></a></td>
			</tr></table>';
			
			
			$output .= '<table width="100%" border="0" cellpadding="5" cellspacing="0" class="small"><tr>
					<td width="50%" class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['LBL_BLOCK_LABEL'].'</b></td>
					<td width="50%" align="left"><input type="text" size=20 name="label" value="'.$label.'" class="txtBox"></td>
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
					<input type="button" name="cancel" value=" '.$app_strings['LBL_CANCEL_BUTTON_LABEL'].' " class="crmButton small cancel" onclick="fninvsh(\'blockLayer\');" />
				</td>
			</tr>
	</table>
	<script id="blocklayer_js" language="javascript">
	Drag.init(document.getElementById("blockLayer_title"), document.getElementById("blockLayer"));
	</script>
	</form></div>';
echo $output;
?>
