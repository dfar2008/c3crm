<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
{include file='Buttons_List1.tpl'}	

{*<!-- Contents -->*}
<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
   <tr>
	<td valign=top><img src="{$IMAGE_PATH}showPanelTopLeft.gif"></td>

	<td class="showPanelBg" valign=top width=100%>
		{*<!-- PUBLIC CONTENTS STARTS-->*}
		<div class="small" style="padding:20px">
			<span class="lvtHeaderText"><font color="purple">[ {$ID} ] </font>{$NAME} - {$APP.LBL_EDITING}{$APP[$SINGLE_MOD]}{$APP.LBL_INFORMATION}</span> <br>
			{$UPDATEINFO}	 
			
			

			<hr noshade size=1>
		        <form name="EditView" method="POST" action="index.php">
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
						<td class="dvtSelectedCell" align=center nowrap>{$APP[$SINGLE_MOD]}{$APP.LBL_INFORMATION}</td>
						<td class="dvtTabCache" style="width:10px">&nbsp;</td>
						<td class="dvtTabCache" style="width:100%">&nbsp;</td>
					   </tr>
					</table>
				</td>
			   </tr>
			   <tr>
				<td valign=top align=left >
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
					   <tr>

						<td align=left>
							{*<!-- content cache -->*}
					
							<table border=0 cellspacing=0 cellpadding=0 width=100%>
							   <tr>
								<td id ="autocom"></td>
							   </tr>
							   <tr>
								<td style="padding:10px">
									<!-- General details -->
									{if $MODULE_ENABLE_PRODUCT eq true }
										{assign var="validateFunction" value="validateInventory"}
									{else}
										{assign var="validateFunction" value="formValidate"}
									{/if}
									<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
									   <tr>
										<td width="15%">&nbsp;</td><td width="18%">&nbsp;</td>
										<td width="15%">&nbsp;</td><td width="18%">&nbsp;</td>
										<td width="15%">&nbsp;</td><td width="18%">&nbsp;</td>
									   </tr>
									   <tr>
										<td  colspan=6 style="padding:5px">
											<div align="center">
												<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';return {$validateFunction}()" type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
												<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="goback()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
											</div>
										</td>
									   </tr>

									   <!-- included to handle the edit fields based on ui types -->
									   {foreach key=header item=data from=$BLOCKS}
									      <tr>                                                                                
										<td colspan=6 class="detailedViewHeader"><b>{$header}</b></td>
									      </tr>
										<!-- Handle the ui types display -->
										{include file="DisplayFields.tpl"}
									   {/foreach}	
									   
									   <tr>
										<td colspan=6>
										{if $MODULE_ENABLE_PRODUCT eq true && $AVAILABLE_PRODUCTS eq true}
										   {if $APPIN_PROCESS eq ''}										  
											{include file="Qunfas/ProductDetailsEditView.tpl"}											
										   {else}
										   	{include file="Qunfas/ProductInfo.tpl"}
										   {/if}
										{elseif $MODULE_ENABLE_PRODUCT eq true}
											{include file="Qunfas/ProductDetails.tpl"}
										{/if}
										</td>
										
									   </tr>

									   <tr>
										<td  colspan=6 style="padding:5px">
											<div align="center">												
												<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';return {$validateFunction}()" type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
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
		<div>
	</td>
	<td align=right valign=top><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
   </tr>
</table>
</form>
<script>	

        var fieldname = new Array({$VALIDATION_DATA_FIELDNAME})

        var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL})

        var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE})

</script>
