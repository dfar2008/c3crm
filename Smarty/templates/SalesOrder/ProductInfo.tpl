<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<!-- Added to display the Product Details -->
<script type="text/javascript">
function displayCoords(currObj,obj,mode,curr_row) 
{ldelim}
	
	document.getElementById("discount_div_title_final").innerHTML = '<b>' + alert_arr.Set_Discount_for + '</b>';
	document.getElementById(obj).style.display = "block";

{rdelim}
  
function doNothing(){ldelim}
{rdelim}

function fnHidePopDiv(obj){ldelim}
	document.getElementById(obj).style.display = 'none';
{rdelim}
</script>


<tr><td colspan="4" align="left">

<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" class="crmTable" id="proTab">
   <tr>
	<td colspan="20" class="dvInnerHeader">
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
	<input id="{$qty}" name="{$qty}" type="text" class="small " {$PRODUCT_READONLY} style="width:50px" onfocus="this.className='detailedViewTextBoxOn'" onBlur="FindDuplicate(); settotalnoofrows(); calcTotal();" value="{$data.$qty}"/>
	</td>
	

	<td class="crmTableRow small lineOnTop" align="left" valign="top">
	   <input id="{$listPrice}" name="{$listPrice}" value="{$data.$listPrice}" {$PRODUCT_READONLY} type="text" class="small " style="width:70px" onBlur="calcTotal();"/>&nbsp;
	</td>
     
	<td class="crmTableRow small lineOnTop" align="left">
		<input id="{$comment}" name="{$comment}" class=small {$PRODUCT_READONLY} style="width:70px" value="{$data.$comment}">
	</td>
	<span style="display:none" id="netPrice{$row_no}"><b>{$data.$netPrice}</b></span>
	

	
	<td class="crmTableRow small lineOnTop" align="right">
		<table width="100%" cellpadding="5" cellspacing="0">
		   <tr>
			<td id="productTotal{$row_no}" align="right">{$data.$productTotal}</td>
		   </tr>
		</table>
	</td>
	
   </tr>
   <!-- Product Details First row - Ends -->
   {/foreach}
</table>



<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" class="crmTable">
  

<!--
All these details are stored in the first element in the array with the index name as final_details 
so we will get that array, parse that array and fill the details
-->
{assign var="FINAL" value=$ASSOCIATEDPRODUCTS.1.final_details}
   
   <!-- Product Details Final Total Discount, Tax and Shipping&Hanling  - Starts -->
   <!--	changed by dingjianting on 2006-12-28 for gloso project -->
   <tr valign="top">
	<td width="88%" colspan="2" style="display:none" class="crmTableRow small lineOnTop" align="right"><b>{$APP.LBL_NET_TOTAL}</b></td>
	<td width="12%" id="netTotal" style="display:none" class="crmTableRow small lineOnTop" align="right">0.00</td>
   </tr>
   <!-- -->

   <tr valign="top">
	<td class="crmTableRow small lineOnTop" width="75%" style="border-right:1px #dadada;" align="right">&nbsp;
	        <!-- Popup Discount DIV -->
		<div class="discountUI" id="discount_div_final">
			<input type="hidden" id="discount_type_final" name="discount_type_final" value="{$FINAL.discount_type_final}">
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="small">
			   <tr style="cursor:move;">
				<td id="discount_div_title_final" nowrap align="left" ></td>
				<td align="right"><img src="{$IMAGE_PATH}close.gif" border="0" onClick="fnHidePopDiv('discount_div_final')" style="cursor:pointer;"></td>
			   </tr>
			   <tr>
				<td align="left" class="lineOnTop"><input type="radio" name="discount_final" checked >&nbsp; {$APP.LBL_ZERO_DISCOUNT}</td>
				<td class="lineOnTop">&nbsp;</td>
			   </tr>
			   <tr>
				<td align="left"><input type="radio" name="discount_final"  {$FINAL.checked_discount_percentage_final}>&nbsp; % {$APP.LBL_OF_PRICE}</td>
				<td align="right"><input type="text" class="small" size="2" id="discount_percentage_final" name="discount_percentage_final" value="{$FINAL.discount_percentage_final}" {$FINAL.style_discount_percentage_final} onBlur="setDiscount(this,'_final');">&nbsp;%</td>
			   </tr>
			   <tr>
				<td align="left" nowrap><input type="radio" name="discount_final" {$FINAL.checked_discount_amount_final}>&nbsp;{$APP.LBL_DIRECT_PRICE_REDUCTION}</td>
				<td align="right"><input type="text" id="discount_amount_final" name="discount_amount_final" size="5" value="{$FINAL.discount_amount_final}" {$FINAL.style_discount_amount_final} onBlur="setDiscount(this,'_final');"></td>
			   </tr>
			</table>
		</div>
		<script>
			//changed by dingjianting on 2007-1-4 for gloso project and drag layer
			var theEventHandle = document.getElementById("discount_div_title_final");
			var theEventRoot   = document.getElementById("discount_div_final");
			Drag.init(theEventHandle, theEventRoot);
		</script>
		<!-- End Div -->
	</td>
	<td class="crmTableRow small lineOnTop" align="right">
		(-)&nbsp;<b><a href="javascript:doNothing();">{$APP.LBL_DISCOUNT}</a>
	</td>
	<td id="discountTotal_final" class="crmTableRow small lineOnTop" align="right">{$FINAL.discountTotal_final}</td>
   </tr>


   <tr valign="top">
	<td class="crmTableRow small" style="border-right:1px #dadada;">&nbsp;</td>
	<td class="crmTableRow small" align="right">
		(+)&nbsp;<b>{$APP.LBL_SHIPPING_AND_HANDLING_CHARGES} </b>
	</td>
	<td class="crmTableRow small" align="right">
		<input id="shipping_handling_charge" name="shipping_handling_charge" type="text" {$PRODUCT_READONLY} class="small" style="width:40px" align="right" value="{$FINAL.shipping_handling_charge}" onBlur="calcTotal();">%
	</td>
   </tr>

 
   <tr valign="top">
	<td class="crmTableRow small" style="border-right:1px #dadada;">&nbsp;</td>
	<td class="crmTableRow small" align="right">
		{$APP.LBL_ADJUSTMENT}
		<select disabled id="adjustmentType" name="adjustmentType" class=small>
			<option value="+">{$APP.LBL_ADD}</option>
			<option value="-">{$APP.LBL_DEDUCT}</option>
		</select>
	</td>
	<td class="crmTableRow small" align="right">
		<input id="adjustment" name="adjustment" type="text" {$PRODUCT_READONLY} class="small" style="width:40px" align="right" value="{$FINAL.adjustment}" onBlur="calcTotal();">
	</td>
   </tr>


   <tr valign="top">
	<td class="crmTableRow big lineOnTop" style="border-right:1px #dadada;">&nbsp;</td>
	<td class="crmTableRow big lineOnTop" align="right"><b>{$APP.LBL_GRAND_TOTAL}</b></td>
	<td id="grandTotal" name="grandTotal" class="crmTableRow big lineOnTop" align="right">{$FINAL.grandTotal}</td>
   </tr>
</table>
		<input type="hidden" value="{$PRE_CURRENCY_NAME}" id="prev_selected_currency_name" name="prev_selected_currency_name" />
		<input type="hidden" name="totalProductCount" id="totalProductCount" value="{$row_no}">
		<input type="hidden" name="subtotal" id="subtotal" value="">
		<input type="hidden" name="total" id="total" value="">
</td></tr>
<script>calcTotal();</script>