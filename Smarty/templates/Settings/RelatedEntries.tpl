				<form action="index.php" method="post" name="form">
				<input type="hidden" name="fld_module" value="{$MODULE}">
				<input type="hidden" name="module" value="Settings">
				<input type="hidden" name="parenttab" value="Settings">
				<input type="hidden" name="mode">

				<table class="dvtContentSpace" border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td class="colHeader small" width="5%">#</td>
					        <td class="colHeader small" width="20%">{$MOD.RELATED_MODULE}</td>
					        <td class="colHeader small" width="20%">{$MOD.MODULE_ORDER}</td>
						<td class="colHeader small" valign="top">{$MOD.IS_PRESENSE}</td>
					        <td class="colHeader small" width="20%">{$MOD.LBL_CURRENCY_TOOL}</td>
				      </tr>
					{foreach key=id item=detail from=$RELATEDENTRY}					    
						<tr style="height:25px">
						{foreach item=entries from=$detail}						        
							<td class="listTableRow small" valign="top" nowrap>{$entries}&nbsp;</td>
						{/foreach}
						</tr>
					{/foreach}
						
				</table>
				</form>
