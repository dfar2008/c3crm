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
			<span class="label label-info"style="margin-bottom:8px">2. {$MOD.LBL_PICKLIST_AVAIL}{$APP.$MODULE}</span>
			<table width="100%" class="table table-bordered table-condensed table-hover" cellpadding="5" cellspacing="0">
			{foreach item=picklists from=$PICKLIST_VALUES}
			<tr>
				{foreach item=picklistfields from=$picklists}
				{if $picklistfields neq ''}
				{if $TEMP_MOD[$picklistfields.fieldlabel] neq ''}	
					<td valign="top" align="left"><strong>{$TEMP_MOD[$picklistfields.fieldlabel]}</strong>
						<button type="button" class="btn btn-primary btn-small pull-right" onclick="fetchEditPickList('{$MODULE}','{$picklistfields.fieldname}', {$picklistfields.uitype})" > 
						<i class="icon-edit icon-white"></i> {$APP.LBL_EDIT_BUTTON}
						</button>	
					</td>
				{else}
					<td valign="top" align="left"><strong>{$picklistfields.fieldlabel}</strong>
						<button type="button" class="btn btn-primary btn-small pull-right" onclick="fetchEditPickList('{$MODULE}','{$picklistfields.fieldname}', {$picklistfields.uitype})" > 
						<i class="icon-edit icon-white"></i> {$APP.LBL_EDIT_BUTTON}
						</button>	
					</td>
				{/if}
					<!--<td valign="top" align="right">
						
					</td>-->
				{else}
					<td colspan="1">&nbsp;</td>
				{/if}
				{/foreach}
			</tr>
			<tr>
				{foreach item=picklistelements from=$picklists}
				{if $picklistelements neq ''}
					<!--<td colspan="2" valign="top">-->
					<td valign="top">
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
					<td colspan="1">&nbsp;</td>
			{/if}
			{/foreach}
			</tr>
		{/foreach}
		</table> 
