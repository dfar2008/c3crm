

{*<!-- module header -->*}
<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
		{include file='Buttons_List_create.tpl'}

{*<!-- Contents -->*}
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>

	<td class="showPanelBg" valign=top width=100%>
	     {*<!-- PUBLIC CONTENTS STARTS-->*}
	     <div class="small" style="padding:0px">
		{include file='EditViewHidden.tpl'}

		{*<!-- Account details tabs -->*}
		<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
		   <tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
				   <tr>
					<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
				   <tr>
				</table>
			</td>
		   </tr>
		   <tr>
			<td valign=top align=left >

			    <!-- Basic Information Tab Opened -->
			    <div id="basicTab">

				<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
				   <tr>
					<td align=left>
					<!-- content cache -->
					
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
										
                                                                		<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';  saveNots();" type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
																		
                                                                		<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="goback()" type="button" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
									   </div>
									</td>
								   </tr>

								   {foreach key=header item=data from=$BASBLOCKS}
								   <tr>
									
						         		<td colspan=4 class="detailedViewHeader">
                                                	        		<b>{$header}</b>
									
							 		</td>
		                                        	   </tr>

								   <!-- Here we should include the uitype handlings-->
								   {include file="DisplayFields.tpl"}
								   {/foreach}

								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
										
                                                                		<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';  saveNots();" type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
																		
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
					
			    </div>
			    <!-- Basic Information Tab Closed -->		    

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


</script>



