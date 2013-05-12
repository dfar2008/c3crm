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
function getCustomBlockList(customField)
{ldelim}
	var modulename = customField.options[customField.options.selectedIndex].value;
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=CustomBlockList&fld_module='+modulename+'&parenttab=Settings&ajax=true',
			onComplete: function(response) {ldelim}
				$("cfList").innerHTML=response.responseText;
			{rdelim}
		{rdelim}
	);	
{rdelim}

{literal}
function deleteCustomBlock(blockid, fld_module)
{
        if(confirm(alert_arr.SURE_TO_DELETE))
        {
                document.form.action="index.php?module=Settings&action=DeleteCustomBlock&fld_module="+fld_module+"&blockid="+blockid;
                document.form.submit();
        }
}

function getCreateCustomBlockForm(customModule,blockid,tabid,label,order)
{
        var modulename = customModule;
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=CreateCustomBlock&fld_module='+customModule+'&parenttab=Settings&ajax=true&blockid='+blockid+'&tabid='+tabid+'&label='+label+'&order='+order,
			onComplete: function(response) {
				$("createblock").innerHTML=response.responseText;
				execJS($('blockLayer'));
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
var gselected_fieldtype = '';
function validate_block() {
		if(document.addtodb.label.value == "") {
			alert(alert_arr.BLOCK_LABEL_IS_NULL);
			document.addtodb.label.focus();
			return false;
		}
		if(document.addtodb.order.value == "") {
			alert(alert_arr.DISPLAY_ORDER_IS_NULL);
			document.addtodb.order.focus();
			return false;
		} else {
			if(isNaN(trim(document.addtodb.order.value))) {
				alert(alert_arr.LBL_ENTER_VALID_NO);
				document.addtodb.order.focus();
				return false;
			}
		}
		return true;
}
{/literal}
</script>
<div id="createblock" style="display:block;position:absolute;width:500px;"></div>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">

	<div align=center>
			{include file='SetMenu.tpl'}
			<!-- DISPLAY -->
			{if $MODE neq 'edit'}
			<b><font color=red>{$DUPLICATE_ERROR} </font></b>
			{/if}
			
				<table class="settingsSelUITopLine" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tbody><tr>
					<td rowspan="2" valign="top" width="50"><img src="{$IMAGE_PATH}blocklist.gif" alt="Users" title="Users" border="0" height="48" width="48"></td>
					<td class="heading2" valign="bottom"><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> &gt; {$MOD.LBL_BLOCK_EDITOR}</b></td>
				</tr>

				<tr>
					<td class="small" valign="top">{$MOD.LBL_BLOCK_DESCRIPTION}</td>
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
		                	<select name="pick_module" class="importBox" onChange="getCustomBlockList(this)">
                		        {foreach key=sel_value item=value from=$MODULES}
		                        {if $MODULE eq $sel_value}
                	                       	{assign var = "selected_val" value="selected"}
		                        {else}
                        	                {assign var = "selected_val" value=""}
                                	{/if}
	                                <option value="{$sel_value}" {$selected_val}>{$APP.$value}</option>
        		                {/foreach}
			                </select>
					<strong>{$MOD.LBL_CUSTOM_BLOCK_IN}</strong>
					</td>
					</tr>
				</tbody>
				</table>
				<div id="cfList">
                                {include file="Settings/CustomBlockEntries.tpl"}
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
        </tr>
</tbody>
</table>
<br>
