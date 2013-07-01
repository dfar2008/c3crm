{*<!--

/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

-->*}

	<table  class="tableHeading" border="0" cellpadding="5" cellspacing="0" width="100%"><tr><td><strong>2. {$MOD.LBL_PICKLIST_AVAIL} {$APP.$MODULE} </strong></td>
		<td class="small" align=right>&nbsp;</td>
		</tr>
	</table>
	<table border=0 cellspacing=0 cellpadding=0 width=100% class="listTable">
	<tr>
		<td valign=top width="50%">
			<table width="100%" class="listTable" cellpadding="5" cellspacing="0">
			{foreach item=picklists from=$PICKLIST_VALUES}
			<tr>
				{foreach item=picklistfields from=$picklists}
				{if $picklistfields neq ''}
				{if $TEMP_MOD[$picklistfields.fieldlabel] neq ''}	
					<td class="listTableTopButtons small" valign="top" align="left"><b>{$TEMP_MOD[$picklistfields.fieldlabel]}</b></td>
				{else}
					<td class="listTableTopButtons small" valign="top" align="left"><b>{$picklistfields.fieldlabel}</b></td>
				{/if}
					<td class="listTableTopButtons" valign="top" align="right">
						<input type="button" value="{$APP.LBL_EDIT_BUTTON}" class="crmButton small edit" onclick="fetchEditPickList('{$MODULE}','{$picklistfields.fieldname}', {$picklistfields.uitype});posLay(this,'editdiv');$('editdiv').style.display='inline';" > 
					</td>
				{else}
					<td class="listTableTopButtons small" colspan="2">&nbsp;</td>
				{/if}
				{/foreach}
			</tr>
			<tr>
				{foreach item=picklistelements from=$picklists}
				{if $picklistelements neq ''}
					<td colspan="2" valign="top">
					<ul style="list-style-type: none;">
						{foreach item=elements from=$picklistelements.value}
							{if $TEMP_MOD[$elements] neq ''}
								<li>{$TEMP_MOD[$elements]}</li>
							{else}
								<li>{$elements}</li>
							{/if}
						{/foreach}
					</ul>	
					</td>
				{else}
					<td colspan="2">&nbsp;</td>
			{/if}
			{/foreach}
			</tr>
		{/foreach}
		</table> 
		</td></tr>
		</table>
