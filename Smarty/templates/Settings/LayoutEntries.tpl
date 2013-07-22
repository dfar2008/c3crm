<form action="index.php" method="post" name="form">
	<input type="hidden" name="fld_module" value="{$MODULE}">
	<input type="hidden" name="module" value="Settings">
	<input type="hidden" name="parenttab" value="Settings">
	<input type="hidden" name="mode">

	<div class="accordion" id="layout_accordion">
	{foreach key=header item=detail from=$BLOCKSENTRY}
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse"  href="#accordion_{$header}">{$header}</a>
			</div>
			<div class="accordion-body collapse in" id="accordion_{$header}">
				<div class="accordion-inline">
					
					<table class="table table-bordered table-hover table-consdened">
							<tr>
							{foreach name="fieldlist" item=entries key=id from=$detail}						        
								<td align=left>							
								#{$entries.sequence}&nbsp;
								{if $entries.typeofdata eq "true"}
									<font color="red">*</font>
								{/if}
								{$entries.fieldlabel}&nbsp;&nbsp;{$entries.tool}</td>
								{if $entries.no%2 == 0}
										{if $entries.no != $smarty.foreach.fieldlist.total}
									</tr><tr>
									{/if}
								{/if}
							{/foreach}
							</tr>
					</table>
				</div>
			</div>
		</div>
		{/foreach}
	</div>
</form>


