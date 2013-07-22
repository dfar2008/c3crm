<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>

<tr><td colspan="4" align="left">

<table  class="table table-bordered table-hover table-condensedforev dvtable" id="proTab">
   <tr>
	<td colspan="20" class="dvInnerHeader1">
		<b>{$APP.LBL_PRODUCT_DETAILS}</b>
	</td>
   </tr>

   <!-- Header for the Product Details -->
   <tr valign="top" class="lvtCol3">
	<td width=5% valign="top" class="lvtCol" align="left"><b>{$APP.LBL_TOOLS}</b></td>
	{foreach key=row_no item=data from=$PRODUCTLABELLIST}
	<td width="{$data.LABEL_WIDTH}" class="lvtCol"><b>{$data.LABEL}</b></td>
	{/foreach}
	<td width=8% class="lvtCol" align="left"><b>{$APP.LBL_QTY}</b></td>
	<td width=12% class="lvtCol" align="left"><b>{$APP.LBL_LIST_PRICE}</b></td>
	<td width=15% valign="top" class="lvtCol" align="left"><b>{$APP.LBL_COMMENT}</b></td>
	<td width=10% nowrap class="lvtCol" align="right"><b>{$APP.LBL_PRODUCT_TOTAL}</b></td>
   </tr>
   

   {foreach key=row_no item=data from=$ASSOCIATEDPRODUCTS}
	{assign var="deleted" value="deleted"|cat:$row_no}
	{assign var="hdnProductId" value="hdnProductId"|cat:$row_no}
	{assign var="productName" value="productName"|cat:$row_no}
	{assign var="comment" value="comment"|cat:$row_no}
	{assign var="qty" value="qty"|cat:$row_no}
	{assign var="listPrice" value="listPrice"|cat:$row_no}
	{assign var="productTotal" value="productTotal"|cat:$row_no}
	{assign var="netPrice" value="netPrice"|cat:$row_no}


   <tr id="row{$row_no}" valign="top" class="lineOnTop2">

	<!-- column 1 - delete link - starts -->
	<td  class="crmTableRow small lineOnTop">
		<img src="{$IMAGE_PATH}delete.gif" border="0" onclick="deleteRow('{$MODULE}',{$row_no})">
		<input type="hidden" id="{$deleted}" name="{$deleted}" value="0">
	</td>
	{foreach item=fieldname from=$PRODUCTNAMELIST}
	        {assign var="itemfield" value=$fieldname|cat:$row_no}
		{if $fieldname eq "productname"}
		<td class="crmTableRow small lineOnTop">		
		<input type="text" id="{$productName}" name="{$productName}" value="{$data.$itemfield}" class="small" readonly />
		<input type="hidden" id="{$hdnProductId}" name="{$hdnProductId}" value="{$data.$hdnProductId}">
		</td>
		{else}
		<td class="crmTableRow small lineOnTop" valign="top" nowrap>&nbsp;<span id="{$itemfield}">{$data.$itemfield}</span></td>
		{/if}
	{/foreach}
	<td class="crmTableRow small lineOnTop" valign="top" align="left">
	<input id="{$qty}" name="{$qty}" type="text" class="small " style="width:50px" onfocus="this.className='detailedViewTextBoxOn'" onBlur="FindDuplicate(); settotalnoofrows(); calcTotal();" value="{$data.$qty}"/>
	</td>

	<td class="crmTableRow small lineOnTop" align="left" valign="top">
	   <input id="{$listPrice}" name="{$listPrice}" value="{$data.$listPrice}" type="text" class="small " style="width:70px" onBlur="calcTotal();"/>
	</td>
     
	<td class="crmTableRow small lineOnTop" align="left">
		<input id="{$comment}" name="{$comment}" style="width:150px" type="text" value="{$data.$comment}">
	</td>
	<span style="display:none" id="netPrice{$row_no}"><b>{$data.$netPrice}</b></span>
	

	
	<td class="crmTableRow small lineOnTop" align="right">
		<table class="table table-bordered " >
		   <tr>
			<td id="productTotal{$row_no}" align="right" style="font-size:12px;">{$data.$productTotal}</td>
		   </tr>
		</table>
	</td>
	
   </tr>
   <!-- Product Details First row - Ends -->
   {/foreach}
</table>
</td>
</tr>
<tr><td colspan="9">
<table  class="table table-bordered table-hover table-condensedforev dvtable">
   <tr valign="top">
	<td class="crmTableRow big lineOnTop" style="border-right:1px #dadada;" align="right" width="90%"><b>{$APP.LBL_GRAND_TOTAL}</b></td>
	<td id="grandTotal" name="grandTotal" class="crmTableRow big lineOnTop" align="right" width="10%">{$FINAL.grandTotal}</td>
   </tr>
</table>
<table  class="table table-bordered table-hover table-condensedforev dvtable"  style="margin-top:5px;">
   <!-- Add Product Button -->
   <tr>
	<td colspan="3">
	<button type="button" name="Button" class="btn btn-primary btn-small"  onclick="selectProductRows();" >
		<i class="icon-plus icon-white"></i> {$APP.LBL_ADD_PRODUCT}
	</button>
	</td>
	<td id="netTotal" style="display:none">0.00</td>
   </tr>
   </table>   
		<input type="hidden" name="totalProductCount" id="totalProductCount" value="{$row_no}">
		<input type="hidden" name="subtotal" id="subtotal" value="">
		<input type="hidden" name="total" id="total" value="">
<script>calcTotal();</script>
