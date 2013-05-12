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

require_once('data/Tracker.php');
require_once('include/utils/utils.php');
require_once('include/database/PearDatabase.php');
require_once('modules/Products/Products.php');
require_once('user_privileges/seqprefix_config.php');

global $mod_strings,$app_strings,$log,$current_user,$theme;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$focus = new Products();
//$productcode = $product_seqprefix.date("Ymd")."-".$focus->get_next_id();


$category = getParentTab();
$CreateProduct = '<div id="productLay" style="display: block;" class="layerPopup" >
    <form name="EditView" method="POST" action="index.php">
	<input type="hidden" name="record" value="'.$id.'">	
	<table width="320" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
		<tr style="cursor:move;">
			<td id="product_div_title" class="layerPopupHeading"  nowrap align="left">'.$mod_strings['LBL_NEW_FORM_TITLE'].'</td>
			<td align="right"><a href="javascript:fninvsh(\'productLay\');"><img src="'.$image_path.'close.gif" align="absmiddle" border="0"></a></td>
		</tr>
		</table>
	
	<table border=0 cellspacing=0 cellpadding=0 width=320 align=center> 
	<tr>
		<td class=small >
			<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white>
				<tr>
					<td width="30%" align="right" class="dvtCellLabel">'.$mod_strings['Product Name'].'</td>
					<td width="70%" align="left" class="dvtCellInfo"><input class="detailedViewTextBox"  onfocus="this.className=\'detailedViewTextBoxOn\'" name="productname" id="productname" onblur="this.className=\'detailedViewTextBox\'" value=""></td>
			    </tr>
				<tr>
					<td width="30%" align="right" class="dvtCellLabel">'.$mod_strings['Product Code'].'</td>
					<td width="70%" align="left" class="dvtCellInfo">
					<input class="detailedViewTextBox"  onfocus="this.className=\'detailedViewTextBoxOn\'" name="productcode" id="productcode" onblur="this.className=\'detailedViewTextBox\'" value="'.$app_strings['AUTO_GEN_CODE'].'">
                    </td>
			    </tr>
				
				<tr>
					<td width="30%" align="right" class="dvtCellLabel">'.$mod_strings['Price'].'</td>
					<td width="70%" align="left" class="dvtCellInfo"><input class="detailedViewTextBox"  onfocus="this.className=\'detailedViewTextBoxOn\'" name="price" id="price" onblur="this.className=\'detailedViewTextBox\'" value=""></td>
			    </tr>';

$CreateProduct .='</table>
			   
			</td>
		</tr>
	</table>
	<table border=0 cellspacing=0 cellpadding=5 width=320 class="layerPopupTransport">
	<tr>
			<td align="center">
				<input name="Save" value=" '.$app_strings['LBL_SAVE_BUTTON_LABEL'].' " type="button" onClick="javascript:;created(this.form)" class="crmbutton save small">&nbsp;&nbsp;
				<input type="button" name=" Cancel " value=" '.$app_strings['LBL_CANCEL_BUTTON_LABEL'].' " onClick="fninvsh(\'productLay\')" class="crmbutton cancel small">
			</td>
		</tr>
	</table></form>
</div>';
echo $CreateProduct;

?>
