{if $smarty.request.ajax neq ''}
&#&#&#{$ERROR}&#&#&#
{/if}
<div class="pagination pagination-mini pagination-right" style="margin:-18px 0px 0px 0px"><span style="margin-right:200px">{$RECORD_COUNTS}</span>{$NAVIGATION}</div>
<div class="accordion" style="margin-top:8px">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#details_{$APP.$MODULE}" class="accordion-toggle" data-toggle="collapse"><b class=big>{$APP.$MODULE}</b>{$SEARCH_CRITERIA}</a>
		</div>
		<div id="details_{$APP.$MODULE}" class="accordion-body collapse in">
			<div class="accordion-inner">
				<table width=100% class="table table-condensed table-hover table-bordered">
					<tr>
						{if $DISPLAYHEADER eq 1}
						{foreach item=header from=$LISTHEADER}
							<th class="t">{$header}</th>
			         		{/foreach}
					{else}
						<td class="searchResultsRow" colspan=$HEADERCOUNT> {$APP.LBL_NO_DATA} </td>
					{/if}
						
					</tr>
					{foreach item=entity key=entity_id from=$LISTENTITY}
				   <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'"  >
					{foreach item=data from=$entity}	
						<td>{$data}</td>
					{/foreach}
				   </tr>
				   {/foreach}
				</table>
				
			</div>
		</div>
	</div>
</div>