<!--*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
* 
 ********************************************************************************/
-->
<?php
global $theme;
$theme_path="themes/".$theme."/";
?>
<HTML>
<head>
	<link type="text/css" href="<?php echo $theme_path;?>style.css" rel="stylesheet">
</head>
<BODY marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" bottommargin="0" topmargin="0">
<FORM METHOD="post" action="index.php" enctype="multipart/form-data" onsubmit="return upuInit(this)">
<?php
	$ret_action = $_REQUEST['return_action'];
	$ret_module = $_REQUEST['return_module']; 
	$ret_id = $_REQUEST['return_id'];

?>

<INPUT TYPE="hidden" NAME="module" VALUE="uploads">
<INPUT TYPE="hidden" NAME="action" VALUE="add2db">
<INPUT TYPE="hidden" NAME="return_module" VALUE="<?php echo $ret_module ?>">
<INPUT TYPE="hidden" NAME="return_action" VALUE="<?php echo $ret_action ?>">
<INPUT TYPE="hidden" NAME="return_id" VALUE="<?php echo $ret_id ?>">
<table border=0 cellspacing=0 cellpadding=0 width=100% class="layerPopup">
<tr>
<td>
	<table border=0 cellspacing=0 cellpadding=5 width=100% class=layerHeadingULine>
		<tr>
			<td class="layerPopupHeading" align="left"><?php echo $mod_strings["LBL_ATTACH_FILE"];?></td>
			<td width="70%" align="right">&nbsp;</td>
		</tr>
	</table>
	<table border=0 cellspacing=0 cellpadding=5 width=95% align=center> 
		<tr>
			<td class=small >
				<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white class="small">
					<tr>
						<td width="30%" colspan="2" align="left">
							<b><?php echo $mod_strings["LBL_STEP_SELECT_FILE"];?></b><br>
							<?php echo $mod_strings["LBL_BROWSE_FILES"]; ?>
						</td>
					</tr>
					<tr>
						<td width="30%" colspan="2" align="left"><input type="file" name="filename"/></td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr>
						<td width="30%" colspan="2" align="left">
							<b> <?php echo $mod_strings["LBL_DESCRIPTION"];?> </b><? echo $mod_strings["LBL_OPTIONAL"];?>
						</td>
					</tr>
					<tr><td colspan="2" align="left"><textarea cols="50" rows="5"  name="txtDescription" class="txtBox"></textarea></td></tr>
				</table>
			</td>
		</tr>
	</table>
	
	<table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
		<tr>
			<td colspan="2" align="center">
					<input type="submit" name="save" value="<?php echo $app_strings["LBL_SUBMIT_BUTTON_LABEL"];?>" class="crmbutton small save" />&nbsp;&nbsp;
					<input type="button" name="cancel" value="<?php echo $app_strings["LBL_CANCEL_BUTTON_LABEL"];?>" class="crmbutton small cancel" onclick="self.close();" />
			</td>	
		</tr>
	</table>
</td>
</tr>
</table>
</FORM>
</BODY>
</HTML>
