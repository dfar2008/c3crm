				<form action="index.php" method="post" name="form">
				<input type="hidden" name="fld_module" value="{$MODULE}">
				<input type="hidden" name="module" value="Settings">
				<input type="hidden" name="parenttab" value="Settings">
				<input type="hidden" name="mode">

				<table class="dvtContentSpace" border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr><td>
					{foreach key=header item=detail from=$BLOCKSENTRY}
					     <table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
					     <tr>
						<td width="50%">&nbsp;</td><td width="50%">&nbsp;</td>						
					     </tr>						 
					     <tr>{strip}
					     <td colspan=2 class="dvInnerHeader">
						<b>
							{$header}
						</b>
					     </td>{/strip}
					     </tr>
						<tr style="height:25px">
						{foreach name="fieldlist" item=entries key=id from=$detail}						        
							<td class="dvtCellLabel" align=left>							
							#{$entries.sequence}&nbsp;
							{if $entries.typeofdata eq "true"}
								<font color="red">*</font>
							{/if}
							{$entries.fieldlabel}&nbsp;&nbsp;{$entries.tool}</td>
							{if $entries.no%2 == 0}
							        {if $entries.no != $smarty.foreach.fieldlist.total}
								</tr><tr style="height:25px">
								{/if}
							{/if}
						
						{/foreach}
						</tr>
						</table>
					{/foreach}
					</td></tr>
				</table>
				</form>
