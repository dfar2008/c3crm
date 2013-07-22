<form action="index.php" method="post" name="form">
	<input type="hidden" name="fld_module" value="{$MODULE}">
	<input type="hidden" name="module" value="Settings">
	<input type="hidden" name="parenttab" value="Settings">
	<input type="hidden" name="mode">
	<div class="pull-right" style="margin-bottom:10px">
	<!-- onClick="fnvshobj(this,'createcf');getCreateCustomFieldForm('{$MODULE}','','','')" -->
		<button class="btn  btn-small btn-primary"  onClick="getCreateCustomFieldForm('{$MODULE}','','','')" type="button"><i class="icon-plus icon-white"></i> {$MOD.NewCustomField}</button>
	</div><br>
	<div style="margin-top:15px" >
		<table class="listTable table table-bordered table-hover table-condensed" >
			<thead>
				<tr bgcolor="#F5F5F5">
					<td class="colHeader small" width="5%">#</td>
					<td class="colHeader small" width="20%">{$MOD.FieldLabel}</td>
					<td class="colHeader small" width="20%">{$MOD.FieldType}</td>
					<td class="colHeader small" width="20%">{$MOD.LBL_CURRENCY_TOOL}</td>
				</tr>
			</thead>
			<tbody>
			{foreach item=entries key=id from=$CFENTRIES}
				<tr>
				{foreach item=value from=$entries}
					<td class="listTableRow small" valign="top" nowrap>{$value}&nbsp;</td>
				{/foreach}
				</tr>
			{/foreach}
			</tbody>
		</table>
	</div>
</form>