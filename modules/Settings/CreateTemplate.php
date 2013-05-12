<?php
global $mod_strings,$app_strings,$app_list_strings,$theme,$adb;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$fld_module = $_REQUEST['fld_module'];

$output .= '<div id="blockLayer" style="display:block;" class="layerPopup">
	<form action="index.php" method="post" name="addtodb" onSubmit="return validate_template()">
	  <input type="hidden" name="module" value="Settings">
	  <input type="hidden" name="fld_module" value="'.$fld_module.'">
	  <input type="hidden" name="parenttab" value="Settings">
      <input type="hidden" name="action" value="AddTemplateToDB">

	  
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
			<tr style="cursor:move;">';
			$output .= '<td id="blockLayer_title" width="90%" align="left" class="layerPopupHeading">'.$mod_strings['LBL_ADD_TEMPLATE'].'</td>';
			$output .= '<td width="10%" align="right"><a href="javascript:fninvsh(\'blockLayer\');"><img src="'.$image_path.'close.gif" border="0"  align="absmiddle" /></a></td>
			</tr></table>';
			
			
			$output .= '<table width="100%" border="0" cellpadding="5" cellspacing="0" class="small"><tr>
					<td width="25%" class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['LBL_TEMPLATE_NAME'].'</b></td>
					<td width="75%" align="left"><input type="text" size=50 name="templatename" value="" class="txtBox"></td>
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
