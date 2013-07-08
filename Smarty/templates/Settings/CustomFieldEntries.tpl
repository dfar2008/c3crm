<form action="index.php" method="post" name="form">
<input type="hidden" name="fld_module" value="{$MODULE}">
<input type="hidden" name="module" value="Settings">
<input type="hidden" name="parenttab" value="Settings">
<input type="hidden" name="mode">
<table class="listTableTopButtons" border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
<td class="small">&nbsp;</td>
<td class="small" align="right">&nbsp;&nbsp;
<input type="button" value=" {$MOD.NewCustomField} " onClick="fnvshobj(this,'createcf');getCreateCustomFieldForm('{$MODULE}','','','')" class="crmButton create small"/>
</tr>
</table>

<table class="listTable" border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
<td class="colHeader small" width="5%">#</td>
<td class="colHeader small" width="20%">{$MOD.FieldLabel}</td>
<td class="colHeader small" width="20%">{$MOD.FieldType}</td>
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