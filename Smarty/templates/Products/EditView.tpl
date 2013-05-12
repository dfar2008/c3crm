

{*<!-- module header -->*}
<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<script type="text/javascript" src="include/js/Inventory.js"></script>
{if $ID eq ''}
{include file='Buttons_List_create.tpl'}	
{else}
{include file='Buttons_List_edit.tpl'}	
{/if}
{*<!-- Contents -->*}
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>

	<td class="showPanelBg" valign=top width=100%>
		{*<!-- PUBLIC CONTENTS STARTS-->*}
		<div class="small" style="padding:0px">
		
		
			<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php">
			<input type="hidden" name="activity_mode" value="{$ACTIVITY_MODE}">
			<INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="800000">
			<input type="hidden" name="module" value="{$MODULE}">
			<input type="hidden" name="record" value="{$ID}">
			<input type="hidden" name="mode" value="{$MODE}">
			<input type="hidden" name="action">
			<input type="hidden" name="parenttab" value="{$CATEGORY}">
			<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
			<input type="hidden" name="return_id" value="{$RETURN_ID}">
			<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
			<input type="hidden" name="return_viewname" value="{$RETURN_VIEWNAME}">
			{*<!-- Account details tabs -->*}
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
						<td align=left style="padding:0px;" width=100%>
							{*<!-- content cache -->*}
					
							<table border=0 cellspacing=0 cellpadding=0 width=100%>
							   <tr>
								<td id ="autocom"></td>
							   </tr>
							   <tr>
								<td style="padding:10px">
								<!-- General details -->
									<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">

 										<tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">
												<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';  displaydeleted();check_duplicate();" type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
												<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="goback()" type="button" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
											</div>
										</td>
									   </tr>
									   <!-- included to handle the edit fields based on ui types -->
									   {foreach key=header item=data from=$BLOCKS}
                                       <tr><td colspan=4 style="height:10px;"></td></tr>
									      <tr>
										
										<td colspan=4 class="detailedViewHeader">
											<b>{$header}</b>
										</td>
									      </tr>

										<!-- Handle the ui types display -->
										{include file="DisplayFields.tpl"}
									   {/foreach}
									   <tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">
												<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';  displaydeleted();check_duplicate();" type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
												<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="goback()" type="button" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
											</div>
										</td>
									   </tr>
									</table>
								</td>
							   </tr>
							</table>
						</td>
						
					   </tr>
					</table>
				</td>
			   </tr>
			</table>
		</div>
	</td>
   </tr>
</table>
</form>

<script>	
        var fieldname = new Array({$VALIDATION_DATA_FIELDNAME})

        var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL})

        var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE})

	var ProductImages=new Array();
	var count=0;
	function delRowEmt(imagename)
	{ldelim}
		ProductImages[count++]=imagename;
		multi_selector.current_element.disabled = false;
		multi_selector.count--;
	{rdelim}
	function displaydeleted()
	{ldelim}
		if(ProductImages.length > 0)
			document.EditView.del_file_list.value=ProductImages.join('###');
	{rdelim}
	
	if(getObj("productcode") != undefined) {ldelim}
		if(getObj("productcode").value == "") {ldelim}
			getObj("productcode").value = "{$APP.AUTO_GEN_CODE}";
			//getObj("productcode").setAttribute("readOnly","true");
		{rdelim}
		else {ldelim}
			//getObj("productcode").setAttribute("readOnly","true");
		{rdelim}
	{rdelim}
	
</script>
