{*
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/ *}
<script language="JavaScript" type="text/javascript" src="include/js/customview.js"></script>
<script language="javascript">
function getCustomFieldList(customField)
{ldelim}
	var modulename = customField.options[customField.options.selectedIndex].value;
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=CustomMultiFieldList&fld_module='+modulename+'&parenttab=Settings&ajax=true',
			onComplete: function(response) {ldelim}
				$("cfList").innerHTML=response.responseText;
			{rdelim}
		{rdelim}
	);	
{rdelim}

{literal}
function deleteMultiCustomField(multifieldid, fld_module, colName, uitype)
{
        if(confirm(alert_arr.SURE_TO_DELETE))
        {
                //document.form.action="index.php?module=Settings&action=DeleteMultiCustomField&multifieldid="+multifieldid+"&parenttab=Settings";
                //document.form.submit();
                window.location.href="index.php?module=Settings&action=DeleteMultiCustomField&multifieldid="+multifieldid+"&parenttab=Settings";
        }
}

function gotoEditCustomField(customField,id,tabid,ui)
{
    window.location.href="index.php?module=Settings&action=EditMultiCustomField&multifieldid="+id+"&parenttab=Settings";
}
function getCreateCustomFieldForm(customField,id,tabid,ui)
{
        var modulename = customField;
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=CreateMultiCustomField&fld_module='+customField+'&parenttab=Settings&ajax=true&fieldid='+id+'&tabid='+tabid+'&uitype='+ui,
			onComplete: function(response) {
				$("createcf").innerHTML=response.responseText;
				gselected_fieldtype = '';
			}
		}
	);

}
function makeFieldSelected(oField,fieldid)
{
	if(gselected_fieldtype != '')
	{
		$(gselected_fieldtype).className = 'customMnu';
	}
	oField.className = 'customMnuSelected';	
	gselected_fieldtype = oField.id;	
	selFieldType(fieldid)
	document.getElementById('selectedfieldtype').value = fieldid;
}
function CustomFieldMapping()
{
        document.form.action="index.php?module=Settings&action=LeadCustomFieldMapping";
        document.form.submit();
}
var gselected_fieldtype = '';

function theformvalidate() {
	var nummaxlength = 255;
       
       
	lengthLayer=getObj("lengthdetails")
       
        var str = getObj("fldLabel").value;
        if (!emptyCheck("fldLabel",'字段标签'))
                return false;
	return true;

}

{/literal}
</script>
<div id="createcf" style="display:block;position:absolute;width:350px;"></div>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopLeft.gif"></td>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
        <br>

	<div align=center>
			{include file='SetMenu.tpl'}
			<!-- DISPLAY -->
			{if $MODE neq 'edit'}
			<b><font color=red>{$DUPLICATE_ERROR} </font></b>
			{/if}
			
				<table class="settingsSelUITopLine" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tbody><tr>
					<td rowspan="2" valign="top" width="50"><img src="{$IMAGE_PATH}relatedfield.gif" alt="Users" title="Users" border="0" height="48" width="48"></td>
					<td class="heading2" valign="bottom"><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> &gt; 级联字段</b></td>
				</tr>

				<tr>
					<td class="small" valign="top">- 创建和管理级联字段。</td>
				</tr>
				</tbody></table>
				
				<br>
				<table border="0" cellpadding="10" cellspacing="0" width="100%">
				<tbody><tr>
				<td>

				<table class="tableHeading" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tbody><tr>
					<td class="small" align="left">
					{$MOD.LBL_SELECT_CF_TEXT}
		                	<select name="pick_module" class="importBox" onChange="getCustomFieldList(this)">
                		        {foreach key=sel_value item=value from=$MODULES}
		                        {if $MODULE eq $sel_value}
                	                       	{assign var = "selected_val" value="selected"}
		                        {else}
                        	                {assign var = "selected_val" value=""}
                                	{/if}
	                                <option value="{$sel_value}" {$selected_val}>{$APP.$value}</option>
        		                {/foreach}
			                </select>
					<strong>级联字段</strong>
					</td>
					</tr>
				</tbody>
				</table>
				<div id="cfList">
                                {include file="Settings/MultiCustomFieldEntries.tpl"}
                </div>	
			<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr>

		  	<td class="small" align="right" nowrap="nowrap"><a href="#top">{$MOD.LBL_SCROLL}</a></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
		<!-- End of Display -->
		
		</td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </div>

        </td>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
        </tr>
</tbody>
</table>
<br>
