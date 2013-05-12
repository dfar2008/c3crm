<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<table width="100%" cellpadding="2" cellspacing="0" border="0">
   <tr>
	<td>
		{include file='Buttons_List_details.tpl'}

		<!-- Contents -->
		<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
		   <tr>
			<td  valign=top width=100%>
			<!-- PUBLIC CONTENTS STARTS-->
			   <div class="small" style="padding:5px" >

		
				<!-- Entity and More information tabs -->
				<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
				   <tr>
					<td>
						<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
						   <tr>
							<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
						   </tr>
						</table>
					</td>
				   </tr>
				   <tr>
					<td valign=top align=left >
						<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
						   <tr>

							<td align=left style="padding:10px;">
							<!-- content cache -->
								<!-- Entity informations display - starts -->	
								<table border=0 cellspacing=0 cellpadding=0 width=100%>
			                			   <tr>
									<td  width="80%">



<!-- The following table is used to display the buttons -->
   <form action="index.php" method="post" name="DetailView" id="form">
					{include file='DetailViewHidden.tpl'}
<table border=0 cellspacing=0 cellpadding=0 width=100%>
   {strip}
   <tr>
	<td  colspan=4 style="padding:5px">
		<table border=0 cellspacing=0 cellpadding=0 width=100%>
                   <tr>
                        <td>
				
				<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit" name="Edit" value="{$APP.LBL_EDIT_BUTTON_LABEL}">&nbsp;
				
				<input title="{$APP.LBL_LIST_BUTTON_TITLE}" class="crmbutton small edit" onclick="document.location.href='index.php?module={$MODULE}&action=index&parenttab={$CATEGORY}'" type="button" name="ListView" value="&nbsp;{$APP.LBL_LIST_BUTTON_LABEL}&nbsp;">&nbsp;
			</td>
			<td align=right>
				
				<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="crmbutton small create" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.isDuplicate.value='true';this.form.module.value='{$MODULE}'; this.form.action.value='EditView'" type="submit" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}">&nbsp;
				
				<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="crmbutton small delete" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='index'; this.form.action.value='Delete'; return confirm('{$APP.NTC_DELETE_CONFIRMATION}')" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}">&nbsp;
				
			</td>
                   </tr>
                </table>
	</td>
   </tr>
   {/strip}
</table>
<!-- Button displayed - finished-->

<!-- Entity information(blocks) display - start -->
{foreach key=header item=detail from=$BLOCKS}
	<table border=0 cellspacing=0 cellpadding=0 width=100% class="small" style="padding-bottom:10px;">
	   <tr>
		<td width="20%" height="1"></td><td height="1" width="30%"></td>
		<td width="20%" height="1"></td><td height="1" width="30%"></td>
	  </tr>
	   <tr>
		{strip}
		<td colspan=4 class="dvInnerHeader" >
			<b>
			       	{$header}
			</b>
		</td>
		{/strip}
	   </tr>

	   {foreach item=detail from=$detail}
	   <tr style="height:25px">
		{foreach key=label item=data from=$detail}
			{assign var=keyid value=$data.ui}
			{assign var=keyval value=$data.value}
			{assign var=keytblname value=$data.tablename}
			{assign var=keyfldname value=$data.fldname}
			{assign var=keyseclink value=$data.link}
				{if $label ne ''}					
					<td class="dvtCellLabel" align=right >{$label}</td>
					{if $keyfldname eq 'qtyinstock'}
						<td class="dvtCellInfo" align="left">&nbsp;<span id="dtlview_{$label}">{$keyval|nl2br}</span></td>
					{elseif $keyfldname eq 'product_description'}
						<td width="100%" colspan="3" class="dvtCellInfo" align="left">{$keyval}</td>
					{else}						
						{include file="DetailViewFields.tpl"}
					{/if}
				
				{/if}
		{/foreach}
	   </tr>	
	   {/foreach}	
	</table>
{/foreach}
{*-- End of Blocks--*} 
<!-- Entity information(blocks) display - ends -->

									</td>
<!-- The following table is used to display the buttons -->
								<table border=0 cellspacing=0 cellpadding=0 width=100%>
			                			   <tr>
									<td width="80%">
			{if $SinglePane_View eq 'false'}
<table border=0 cellspacing=0 cellpadding=0 width=100%>
   {strip}
   <tr>
	<td  colspan=4 style="padding:5px">
		<table border=0 cellspacing=0 cellpadding=0 width=100%>
                   <tr>
                        <td>
				
				<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit" name="Edit" value="{$APP.LBL_EDIT_BUTTON_LABEL}">&nbsp;
				
				
				<input title="{$APP.LBL_LIST_BUTTON_TITLE}" class="crmbutton small edit" onclick="document.location.href='index.php?module={$MODULE}&action=index&parenttab={$CATEGORY}'" type="button" name="ListView" value="&nbsp;{$APP.LBL_LIST_BUTTON_LABEL}&nbsp;">&nbsp;
			</td>
			<td align=right>
				
				<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="crmbutton small create" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.isDuplicate.value='true';this.form.module.value='{$MODULE}'; this.form.action.value='EditView'" type="submit" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}">&nbsp;
				
				<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="crmbutton small delete" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='index'; this.form.action.value='Delete'; return confirm('{$APP.NTC_DELETE_CONFIRMATION}')" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}">&nbsp;
				
			</td>
                   </tr>
                </table>

		
	</td>
   </tr>
   {/strip}
</table>
{/if}
</form>
		<table border=0 cellspacing=0 cellpadding=0 width=100%>
		  <tr>
			<td  width="100%">
			{if $SinglePane_View eq 'true'}
				{include file= 'RelatedListNew.tpl'}
			{/if}
		</td></tr></table>
</td></tr></table>
<!-- Button displayed - finished-->
									<!-- Inventory Actions - ends -->	

								   </tr>
								</table>
							</td>
						   </tr>
						</table>
					<!-- PUBLIC CONTENTS STOPS-->
					</td>
				   </tr>
				</table>
			   </div>
			</td>
		   </tr>
		</table>
		<!-- Contents - end -->
	</td>
   </tr>
</table>
<script language="javascript">
  var fieldname = new Array({$VALIDATION_DATA_FIELDNAME});
  var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL});
  var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE});
</script>

