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
					<input type="button" value=" {$MOD.LBL_NEW_BLOCK} " onClick="fnvshobj(this,'createblock');getCreateCustomBlockForm('{$MODULE}','','','','')" class="crmButton create small"/>
				</tr>
				</table>

				<table class="listTable" border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td class="colHeader small" width="5%">#</td>
						<td class="colHeader small" width="20%">{$MOD.BLOCK_LABEL}</td>
						<td class="colHeader small" width="20%">{$MOD.BLOCK_ORDER}</td>
						<td class="colHeader small" width="20%">{$MOD.LBL_CURRENCY_TOOL}</td>
					</tr>
					
					{foreach item=entries key=id from=$CFENTRIES}
					<tr>
						{foreach item=value from=$entries}
							<td class="listTableRow small" valign="top" nowrap>{$value}&nbsp;</td>
						{/foreach}
					</tr>
					{/foreach}
				</table>
				</form>
