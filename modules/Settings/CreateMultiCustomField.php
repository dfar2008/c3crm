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
 
require_once('include/CustomFieldUtil.php');
require_once('include/CRMSmarty.php');


global $mod_strings,$app_strings,$app_list_strings,$theme,$adb;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";



$tabid=$_REQUEST['tabid'];
$fieldid=$_REQUEST['fieldid'];
if(isset($_REQUEST['uitype']) && $_REQUEST['uitype'] != '')
	$uitype=$_REQUEST['uitype'];
else
	$uitype=1;
$readonly = '';
$smarty = new CRMSmarty();
/*
if(isset($fieldid) && $fieldid!='')
{
	$mode='edit';
	$customfield_columnname=getCustomFieldData($tabid,$fieldid,'columnname');
	$customfield_typeofdata=getCustomFieldData($tabid,$fieldid,'typeofdata');
	$customfield_fieldlabel=getCustomFieldData($tabid,$fieldid,'fieldlabel');
	if(substr_count($customfield_typeofdata,"~M") > 0) {
		$customfield_fieldmandatory = "checked";
	} else {
		$customfield_fieldmandatory = "";
	}
	$customfield_typename=getCustomFieldTypeName($uitype);
	$fieldtype_lengthvalue=getFldTypeandLengthValue($customfield_typename,$customfield_typeofdata);
	list($fieldtype,$fieldlength,$decimalvalue)= explode(";",$fieldtype_lengthvalue);
	$readonly = "readonly";
	if($fieldtype == '7' || $fieldtype == '11')
	{
		$query = "select * from ec_".$customfield_columnname;
		$result = $adb->query($query);
		$fldVal='';
		while($row = $adb->fetch_array($result))
		{
			$fldVal .= $row[$customfield_columnname];
			$fldVal .= "\n";
		}
		$smarty->assign("PICKLISTVALUE",$fldVal);
	}
	$selectedvalue = $typeVal[$fieldtype];
}
*/
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("FLD_MODULE", $_REQUEST['fld_module']);
if(isset($_REQUEST["duplicate"]) && $_REQUEST["duplicate"] == "yes")
{
	//changed by dingjianting on 2006-10-30 for chinese label
	//$error='Custom Field in the Name '.$_REQUEST["fldlabel"].' already exists. Please specify a different Label';
	$error= $mod_strings['custom_field_exists'];
	$smarty->assign("DUPLICATE_ERROR", $error);
	$customfield_fieldlabel=$_REQUEST["fldlabel"];
	$fieldlength=$_REQUEST["fldlength"];
	$decimalvalue=$_REQUEST["flddecimal"];
	$fldVal = $_REQUEST["fldPickList"];
	$selectedvalue = $typeVal[$_REQUEST["fldType"]];
}
elseif($fieldid == '')
{
	$selectedvalue = "0";
}

if($mode == 'edit')
	$disable_str = 'disabled' ;
else
	$disable_str = '' ;

$output = '';

$combo_output = '';
for($i=0;$i<count($cftextcombo);$i++)
{
        if($selectedvalue == $i && $fieldid != '')
                $sel_val = 'selected';
        else
                $sel_val = '';
	$combo_output.= '<a href="javascript:void(0);" onClick="makeFieldSelected(this,'.$i.');" id="field'.$i.'" style="text-decoration:none;background-image:url('.$cfimagecombo[$i].');" class="customMnu" '.$disable_str.'>'.$cftextcombo[$i].'</a>';

}
$output .= '<div id="orgLay" style="display:block;width:350px" class="layerPopup"><script language="JavaScript" type="text/javascript" src="include/js/customview.js"></script>
	<form action="index.php" method="post" name="addtodb" onSubmit="return theformvalidate()">
	  <input type="hidden" name="module" value="Settings">
	  <input type="hidden" name="fld_module" value="'.$_REQUEST['fld_module'].'">
	  <input type="hidden" name="parenttab" value="Settings">
          <input type="hidden" name="action" value="AddMultiCustomFieldToDB">
	  <input type="hidden" name="fieldid" value="'.$fieldid.'">
	  <input type="hidden" name="column" value="'.$customfield_columnname.'">
	  <input type="hidden" name="mode" id="cfedit_mode" value="'.$mode.'">
	  <input type="hidden" name="cfcombo" id="selectedfieldtype" value="">

	  
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
			<tr>';
			if($mode == 'edit')
				$output .= '<td width="60%" align="left" class="layerPopupHeading">'.$mod_strings['LBL_EDIT_FIELD_TYPE'].' - '.$mod_strings[$customfield_typename].'</td>';
			else
				$output .= '<td width="60%" align="left" class="layerPopupHeading">'.'新增级联字段'.'</td>';
				
			$output .= '<td width="40%" align="right"><a href="javascript:fninvsh(\'orgLay\');"><img src="'.$image_path.'close.gif" border="0"  align="absmiddle" /></a></td>
			</tr>';
			$output .='</table><table border=0 cellspacing=0 cellpadding=5 width=95% align=center> 
							<tr>
								<td class=small >
									<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white>
										<tr>';
			
			$output .='<td width="50%">
					<table width="100%" border="0" cellpadding="5" cellspacing="0">
					    
						<tr>
							<td class="dataLabel" nowrap="nowrap" align="right" width="30%"><b>'.'字段标签'.' </b></td>
							<td align="left" width="70%"><input name="fldLabel" value="'.$customfield_fieldlabel.'" type="text" class="txtBox"></td>
						</tr>';
					
					
						$output .= '<tr id="lengthdetails">
							<td class="dataLabel" nowrap="nowrap" align="right"><b>'.'级联字段数'.'</b></td>
							<td align="left">
							<select id="fldLength" name="fldLength">
							<option value="2">2</option>
							<option value="3">3</option>
							</select></td>
						</tr>
						<tr id="decimaldetails" style="display:none;">
							<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['LBL_DECIMAL_PLACES'].'</b></td>
							<td align="left"><input type="text" name="fldDecimal" value="'.$decimalvalue.'" '.$readonly.' class="txtBox"></td>
						</tr>
						<tr id="picklist" style="display:none;">
							<td class="dataLabel" nowrap="nowrap" align="right" valign="top"><b>'.$mod_strings['LBL_PICK_LIST_VALUES'].'</b></td>
							<td align="left" valign="top"><textarea name="fldPickList" rows="10" class="txtBox" '.$readonly.'>'.$fldVal.'</textarea></td>
							<!--td style="padding-left:10px"><img src="themes/Aqua/images/picklist_hint.gif"/></td-->
						</tr>';
					
				$output .= '	
					</table>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	<table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
			<tr>
				<td align="center">
					<input type="submit" name="save" value=" &nbsp; '.$app_strings['LBL_SAVE_BUTTON_LABEL'].' &nbsp; " class="crmButton small save" />&nbsp;
					<input type="button" name="cancel" value=" '.$app_strings['LBL_CANCEL_BUTTON_LABEL'].' " class="crmButton small cancel" onclick="fninvsh(\'orgLay\');" />
				</td>
			</tr>
	</table>
		<input type="hidden" name="fieldType" id="fieldType" value="'.$selectedvalue.'">
	</form></div>';
echo $output;
?>
