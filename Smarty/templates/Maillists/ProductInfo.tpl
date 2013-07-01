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

<script type="text/javascript" src="include/js/general.js"></script>

<tr><td colspan="4" align="left">

<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" class="crmTable" id="proTab">
   <tr>   	
	<td colspan="9" class="dvInnerHeader">	
		<b>{$APP.LBL_PRODUCT_DETAILS}</b>
	</td>
   </tr>

   <!-- Header for the Product Details -->
   <tr valign="top">
	<td width=5% valign="top" class="lvtCol" align="right"><b>{$APP.LBL_TOOLS}</b></td>
	{foreach key=row_no item=data from=$PRODUCTLABELLIST}
	<td width="{$data.LABEL_WIDTH}" class="lvtCol"><b>{$data.LABEL}</b></td>
	{/foreach}
	<td width=8% class="lvtCol" align="left"><b>{$APP.LBL_QTY}</b></td>
	<td width=12% class="lvtCol" align="left"><b>{$APP.LBL_LIST_PRICE}</b></td>
	<td width=15% valign="top" class="lvtCol" align="left"><b>{$APP.LBL_COMMENT}</b></td>
	<td width=10% nowrap class="lvtCol" align="right"><b>{$APP.LBL_PRODUCT_TOTAL}</b></td>
   </tr>
   {assign var="PRODUCT_READONLY" value="readonly"}
   {foreach key=row_no item=data from=$ASSOCIATEDPRODUCTS}
	{assign var="deleted" value="deleted"|cat:$row_no}
	{assign var="hdnProductId" value="hdnProductId"|cat:$row_no}
	{assign var="productName" value="productName"|cat:$row_no}
	{assign var="comment" value="comment"|cat:$row_no}
	{assign var="qty" value="qty"|cat:$row_no}
	{assign var="listPrice" value="listPrice"|cat:$row_no}
	{assign var="productTotal" value="productTotal"|cat:$row_no}
	{assign var="netPrice" value="netPrice"|cat:$row_no}
   <tr id="row{$row_no}" valign="top">

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


	<!-- column 4 - Quantity - starts -->
	<td class="crmTableRow small lineOnTop" valign="top" align="left">
        <input id="{$qty}" name="{$qty}" type="text" class="small " style="width:50px" {$PRODUCT_READONLY} onfocus="this.className='detailedViewTextBoxOn'" onBlur="FindDuplicate(); settotalnoofrows(); calcGrandTotal();" value="{$data.$qty}"/>
	</td>
	<!-- column 4 - Quantity - ends -->

	<!-- column 5 - List Price with Discount, Total After Discount and Tax as table - starts -->
	<td class="crmTableRow small lineOnTop" align="left" valign="top">
	<input id="{$listPrice}" name="{$listPrice}" value="{$data.$listPrice}" type="text" class="small " style="width:70px" {$PRODUCT_READONLY} onBlur="calcGrandTotal();"/>
		
	</td>
	<!-- column 5 - List Price with Discount, Total After Discount and Tax as table - ends -->

        
	<!-- column 6 - Comment - starts -->
	<td valign="bottom" class="crmTableRow small lineOnTop" align="left">
		<input id="{$comment}" name="{$comment}" class=small style="width:70px" {$PRODUCT_READONLY} value="{$data.$comment}">
	</td>
	<!-- column 6 - Comment - ends -->

	<!-- column 7 - Product Total - starts -->
	<td class="crmTableRow small lineOnTop" align="right">
	<table width="100%" cellpadding="5" cellspacing="0">
	   <tr>
		<td id="productTotal{$row_no}" align="right">{$data.$productTotal}</td>
	   </tr>
	</table>
	</td>
	<!-- column 7 - Product Total - ends -->
   </tr>
   <!-- Product Details First row - Ends -->
   {/foreach}
</table>



<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" class="crmTable">
   <tr valign="top">
	<td class="crmTableRow big lineOnTop" width="80%" style="border-right:1px #dadada;">&nbsp;</td>
	<td class="crmTableRow big lineOnTop" align="right"><b>{$MOD.total}</b></td>
	<td id="grandTotal" name="grandTotal" class="crmTableRow big lineOnTop" align="right">{$total}</td>
   </tr>
   <input type="hidden" name="total" id="total" value="{$total}">
</table>
<input type="hidden" name="totalProductCount" id="totalProductCount" value="{$row_no}">
</td></tr>
<!-- Upto this Added to display the Product Details -->
<script type="text/javascript">calcGrandTotal();</script>