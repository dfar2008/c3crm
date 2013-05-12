<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<tr>
<td colspan="4" align="left">
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
</table>
<!-- Upto this has been added for form the first row. Based on these above we should form additional rows using script -->

<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" class="crmTable">
   <!-- Add Product Button -->
   <tr>
	<td colspan="3">	
	<input type="button" name="Button" class="crmbutton small create" value="{$APP.LBL_ADD_PRODUCT}" onclick="selectProductRows(this.form);" />
	</td>
	<td id="netTotal" style="display:none">0.00</td>
   </tr>
</table>
<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" class="crmTable">
  <tr valign="top">
	<td class="crmTableRow big lineOnTop" style="border-right:1px #dadada;" align="right" width="90%"><b>{$APP.LBL_GRAND_TOTAL}</b></td>
	<td id="grandTotal" name="grandTotal" class="crmTableRow big lineOnTop" align="right" width="10%">&nbsp;<b></b></td>
   </tr>
</table>
<input type="hidden" name="totalProductCount" id="totalProductCount" value="">
<input type="hidden" name="subtotal" id="subtotal" value="">
<input type="hidden" name="total" id="total" value="">
</td>
</tr>
