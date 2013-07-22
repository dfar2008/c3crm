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

require_once($theme_path.'layout_utils.php');

$tabid=$_REQUEST['tabid'];
$fieldid=$_REQUEST['fieldid'];
if(isset($_REQUEST['uitype']) && $_REQUEST['uitype'] != '')
	$uitype=$_REQUEST['uitype'];
else
	$uitype=1;
$readonly = '';
$smarty = new CRMSmarty();
$cfimagecombo = Array($image_path."text.gif",
                        $image_path."number.gif",
                        $image_path."percent.gif",
                        $image_path."cfcurrency.gif",
                        $image_path."date.gif",
                        $image_path."email.gif",
                        $image_path."phone.gif",
                        $image_path."cfpicklist.gif",
                        $image_path."url.gif",
                        $image_path."checkbox.gif",
                        $image_path."text.gif",
                        $image_path."cfpicklist.gif",
						$image_path."qq.gif",
						$image_path."msn.jpg",
						$image_path."trade.jpg",
						$image_path."yahoo.gif",
			            $image_path."skype.gif"						
						);//$image_path."text.gif",$image_path."text.gif" account,contact

$cftextcombo = Array($mod_strings['Text'],                        
                        $mod_strings['Number'],
                        $mod_strings['Percent'],
                        $mod_strings['Currency'],
                        $mod_strings['Date'],
                        $mod_strings['Email'],
                        $mod_strings['Phone'],
                        $mod_strings['PickList'],
                        $mod_strings['LBL_URL'],
                        $mod_strings['LBL_CHECK_BOX'],
                        $mod_strings['LBL_TEXT_AREA'],
                        $mod_strings['LBL_MULTISELECT_COMBO'],
						$mod_strings['QQ'],
						$mod_strings['Msn'],
						$mod_strings['Trade'],
						$mod_strings['Yahoo'],
			            $mod_strings['Skype']						
				);//$mod_strings['ACCOUNT_NAME'],$mod_strings['CONTACT_NAME']
$typeVal = Array(
	'0'=>'Text',
	'1'=>'Number',
	'2'=>'Percent',
	'3'=>'Currency',
	'4'=>'Date',
	'5'=>'Email',
	'6'=>'Phone',
	'7'=>'Picklist',
	'8'=>'URL',
	'11'=>'MultiSelectCombo',
	'13'=>'QQ',
	'14'=>'Msn',
	'15'=>'Trade',
	'16'=>'Yahoo',
	'12'=>'Skype'
	);//'17'=>'Account','18'=>'Contact'
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
	//$readonly = "readonly";
	$readonly = "";
	if($fieldtype == '7' || $fieldtype == '11')
	{
		$query = "select colvalue from ec_picklist where colname='".$customfield_columnname."' order by sequence";
		$result = $adb->query($query);
		$fldVal='';
		while($row = $adb->fetch_array($result))
		{
			$fldVal .= $row['colvalue'];
			$fldVal .= "\n";
		}
		$smarty->assign("PICKLISTVALUE",$fldVal);
	}
	$selectedvalue = $typeVal[$fieldtype];
}
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
$output .= '<div id="orgLay" style="display:block;" class="layerPopup"><script language="JavaScript" type="text/javascript" src="include/js/customview.js"></script>
	<form action="index.php" method="post" name="addtodb" onSubmit="return validate()">
	  <input type="hidden" name="module" value="Settings">
	  <input type="hidden" name="fld_module" value="'.$_REQUEST['fld_module'].'">
	  <input type="hidden" name="parenttab" value="Settings">
          <input type="hidden" name="action" value="AddCustomFieldToDB">
	  <input type="hidden" name="fieldid" value="'.$fieldid.'">
	  <input type="hidden" name="column" value="'.$customfield_columnname.'">
	  <input type="hidden" name="mode" id="cfedit_mode" value="'.$mode.'">
	  <input type="hidden" name="cfcombo" id="selectedfieldtype" value="">

	  
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
			<tr>';
			if($mode == 'edit')
				$output .= '<td width="60%" align="left" class="layerPopupHeading">'.$mod_strings['LBL_EDIT_FIELD_TYPE'].' - '.$mod_strings[$customfield_typename].'</td>';
			else
				$output .= '<td width="60%" align="left" class="layerPopupHeading">'.$mod_strings['LBL_ADD_FIELD'].'</td>';
				
			$output .= '<td width="40%" align="right"><a href="javascript:fninvsh(\'orgLay\');"><img src="'.$image_path.'close.gif" border="0"  align="absmiddle" /></a></td>
			</tr>';
			$output .='</table><table border=0 cellspacing=0 cellpadding=5 width=95% align=center> 
							<tr>
								<td class=small >
									<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white>
										<tr>';
			if($mode != 'edit')
			{	
				$output .= '<td><table>
						<tr><td>'.$mod_strings['LBL_SELECT_FIELD_TYPE'].'</td></tr>
						<tr><td>
							<div name="cfcombo" id="cfcombo" class=small  style="width:205px;height:150px;overflow-y:auto;overflow-x:hidden;overflow:auto;border:1px solid #CCCCCC;">'.$combo_output.'</div>
						</td></tr>
						</table></td>';
			}
			$output .='<td width="50%">
					<table width="100%" border="0" cellpadding="5" cellspacing="0">
					    <tr>
							<td class="dataLabel" nowrap="nowrap" align="right" width="30%"><b>'.$mod_strings['LBL_MANDATORY'].' </b></td>
							<td align="left" width="70%"><input name="fldMandatory" value="1" '.$customfield_fieldmandatory.' type="checkbox" class="txtBox"></td>
						</tr>
						<tr>
							<td class="dataLabel" nowrap="nowrap" align="right" width="30%"><b>'.$mod_strings['LBL_LABEL'].' </b></td>
							<td align="left" width="70%"><input name="fldLabel" value="'.$customfield_fieldlabel.'" type="text" class="txtBox"></td>
						</tr>';
					if($mode == 'edit')
					{
						switch($uitype)
						{
							case 1:
								$output .= '<tr id="lengthdetails">
									<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['LBL_LENGTH'].'</b></td>
									<td align="left"><input type="text" name="fldLength" value="'.$fieldlength.'" '.$readonly.' class="txtBox"></td>
								</tr>';
								break;
							case 71:
							case 9:
							case 7:
								$output .= '<tr id="lengthdetails">
									<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['LBL_LENGTH'].'</b></td>
									<td align="left"><input type="text" name="fldLength" value="'.$fieldlength.'" '.$readonly.' class="txtBox"></td>
								</tr>';
								$output .= '<tr id="decimaldetails">
									<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['LBL_DECIMAL_PLACES'].'</b></td>
									<td align="left"><input type="text" name="fldDecimal" value="'.$decimalvalue.'" '.$readonly.' class="txtBox"></td>
								</tr>';
								break;
							case 33:
							case 15:
								$output .= '<tr id="picklist">
									<td class="dataLabel" nowrap="nowrap" align="right" valign="top"><b>'.$mod_strings['LBL_PICK_LIST_VALUES'].'</b></td>
									<td align="left" valign="top"><textarea name="fldPickList" rows="10" class="txtBox" >'.$fldVal.'</textarea></td>
									<!--td style="padding-left:10px"><img src="themes/Aqua/images/picklist_hint.gif"/></td-->
								</tr>';
								break;
								
						}
					}
					else
					{
						$output .= '<tr id="lengthdetails">
							<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['LBL_LENGTH'].'</b></td>
							<td align="left"><input type="text" name="fldLength" value="'.$fieldlength.'" '.$readonly.' class="txtBox"></td>
						</tr>
						<tr id="decimaldetails" style="visibility:hidden;">
							<td class="dataLabel" nowrap="nowrap" align="right"><b>'.$mod_strings['LBL_DECIMAL_PLACES'].'</b></td>
							<td align="left"><input type="text" name="fldDecimal" value="'.$decimalvalue.'" '.$readonly.' class="txtBox"></td>
						</tr>
						<tr id="picklist" style="visibility:hidden;">
							<td class="dataLabel" nowrap="nowrap" align="right" valign="top"><b>'.$mod_strings['LBL_PICK_LIST_VALUES'].'</b></td>
							<td align="left" valign="top"><textarea name="fldPickList" rows="10" class="txtBox" '.$readonly.'>'.$fldVal.'</textarea></td>
							<!--td style="padding-left:10px"><img src="themes/Aqua/images/picklist_hint.gif"/></td-->
						</tr>';
					}
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
