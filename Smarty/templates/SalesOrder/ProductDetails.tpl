<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<tr>
<td colspan="4" align="left">
<table class="table table-bordered table-hover table-condensedforev dvtable"  id="proTab">
   <tr>
	<td colspan="20" align="left">
		<b>{$APP.LBL_PRODUCT_DETAILS}</b>
	</td>
   </tr>


   <!-- Header for the Product Details -->
   <tr valign="top">
	<td width=5% valign="top"  align="right"><b>{$APP.LBL_TOOLS}</b></td>
	{foreach key=row_no item=data from=$PRODUCTLABELLIST}
	<td width="{$data.LABEL_WIDTH}" ><b>{$data.LABEL}</b></td>
	{/foreach}
	<td width=8%  align="left"><b>{$APP.LBL_QTY}</b></td>
	<td width=12%  align="left"><b>{$APP.LBL_LIST_PRICE}</b></td>
	<td width=15% valign="top"  align="left"><b>{$APP.LBL_COMMENT}</b></td>
	<td width=10% nowrap  align="right"><b>{$APP.LBL_PRODUCT_TOTAL}</b></td>
   </tr>
</table>
<!-- Upto this has been added for form the first row. Based on these above we should form additional rows using script -->

<table class="table table-bordered table-hover  dvtable" style="margin-top:5px;">
   <!-- Add Product Button -->
   <tr>
	<td colspan="3">	
	<button type="button" name="Button" class="btm btn-primary"  onclick="selectProductRows();" >
		<i class="icon-plus icon-white"></i> {$APP.LBL_ADD_PRODUCT}
	</button>
	</td>
	<td id="netTotal" style="display:none">0.00</td>
   </tr>
</table>
<table class="table table-bordered table-hover dvtable" style="margin-top:5px;">
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
