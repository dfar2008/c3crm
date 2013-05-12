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
				<form action="index.php" method="post" name="form">
				<input type="hidden" name="fld_module" value="{$MODULE}">
				<input type="hidden" name="module" value="Settings">
				<input type="hidden" name="parenttab" value="Settings">
				<input type="hidden" name="mode">
				<table class="listTableTopButtons" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tr>
					<td class="small">&nbsp;</td>
					<td class="small" align="right">&nbsp;&nbsp;
					{if $MODULE eq 'Leads'}
					&nbsp;&nbsp;<input input title="{$MOD.CUSTOMFIELDMAPPING}"  class="crmButton edit small" onclick="CustomFieldMapping();" type="button" name="ListLeadCustomFieldMapping" value="{$MOD.CUSTOMFIELDMAPPING}">
					{/if}
					<input type="button" value=" {$MOD.NewCustomField} " onClick="fnvshobj(this,'createcf');getCreateCustomFieldForm('{$MODULE}','','','')" class="crmButton create small"/>
				</tr>
				</table>

				<table class="listTable" border="0" cellpadding="5" cellspacing="0" width="100%">
					{if $MODULE eq 'Leads'}
					<tr>
						<td rowspan="2" class="colHeader small" width="5%">#</td>
					        <td rowspan="2" class="colHeader small" width="20%">{$MOD.FieldLabel}</td>
					        <td rowspan="2" class="colHeader small" width="20%">{$MOD.FieldType}</td>
							<td colspan="3" class="colHeader small" valign="top"><div align="center">{$MOD.LBL_MAPPING_OTHER_MODULES}</div></td>
					        <td rowspan="2" class="colHeader small" width="20%">{$MOD.LBL_CURRENCY_TOOL}</td>
				      </tr>

					<tr>
					  <td class="colHeader small" valign="top" width="18%">{$APP.Accounts}</td>
					  <td class="colHeader small" valign="top" width="18%">{$APP.Contacts}</td>
					  <td class="colHeader small" valign="top" width="19%">{$APP.Potentials}</td>
					</tr>
					{else}
					<tr>
                      	<td class="colHeader small" width="5%">#</td>
                      	<td class="colHeader small" width="20%">{$MOD.FieldLabel}</td>
                      	<td class="colHeader small" width="20%">{$MOD.FieldType}</td>
                     	<td class="colHeader small" width="20%">{$MOD.LBL_CURRENCY_TOOL}</td>
					</tr>
					{/if}
					{foreach item=entries key=id from=$CFENTRIES}
					<tr>
						{foreach item=value from=$entries}
							<td class="listTableRow small" valign="top" nowrap>{$value}&nbsp;</td>
						{/foreach}
					</tr>
					{/foreach}
		</table>
		</form>
		<br>
		{if $MODULE eq 'Leads'}
			<strong>{$APP.LBL_NOTE}: </strong> {$MOD.LBL_CUSTOM_MAPP_INFO}
		{/if}
