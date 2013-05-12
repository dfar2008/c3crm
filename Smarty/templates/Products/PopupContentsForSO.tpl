<form name="selectall" method="POST">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="small">
	<tr>
	{if $SELECT eq 'enable'}
		<td style="padding-left:10px;" align="left"><input class="crmbutton small save" type="button" value="{$APP.LBL_ADD_ITEM} {$APP[$MODULE]}" onclick="javascript:addMultiProductRow('SalesOrder');"/></td>
	{else}		
		<td>&nbsp;</td>	
	{/if}
	</tr>
   	<tr>
	    <td style="padding:5px;">
       		<input name="module" type="hidden" value="Products">
		<input name="action" type="hidden" value="PopupContentsForSO">
		<input name="pmodule" type="hidden" value="{$MODULE}">	
		<input name="entityid" type="hidden" value="">
		<input name="popuptype" id="popup_type" type="hidden" value="{$POPUPTYPE}">
		<input name="select_enable" id="select_enable" type="hidden" value="{$SELECT}">
		<input name="idlist"  id="idlist" type="hidden" value="{$IDLIST}">
		<input name="productlist"  id="productlist"  type="hidden" value="{$PRODUCTLIST}">
		<input type="hidden" name="vendor_id" id="vendor_id" value="{$VENDOR_ID}">
		<input name="search_field" type="hidden" value="{$SEARCH_FIELD}">
		<input name="search_text" type="hidden" value="{$SEARCH_TEXT}">
		<div style="overflow:auto;height:348px;">
		<table style="background-color: rgb(204, 204, 204);" class="small" border="0" cellpadding="5" cellspacing="1" width="100%">
		<tbody>
		<tr>
			{if $SELECT eq 'enable'}
				<td class="lvtCol" width="3%"><input type="checkbox" name="select_all" value="" onClick='javascript:toggleSelect(this.checked,"selected_id");UpdateIDString()'></td>
            {/if}
		    {foreach item=header from=$LISTHEADER}
		        <td class="lvtCol">{$header}</td>
		    {/foreach}
		</tr>
		{foreach key=entity_id item=entity from=$LISTENTITY}
	        <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'"  >
		   {if $SELECT eq 'enable'}
			<td><input type="checkbox" name="selected_id" value="{$entity_id}" onClick='javascript:toggleSelectAll(this.name,"select_all");UpdateIDString();'></td>
		   {/if}
                   {foreach item=data from=$entity}
		        <td>{$data}</td>
                   {/foreach}
		</tr>
                {/foreach}
	      	</tbody>
	    	</table>
			<div>
	    </td>
	</tr>

</table>
<table width="100%" border=0 cellspacing=0 cellpadding=0 class="small reportCreateBottom" >
     <tr><td style="padding:5px" align="right">{$RECORD_COUNTS}&nbsp;&nbsp;&nbsp;&nbsp;{$NAVIGATION}</td></tr>
</table>
</form>

