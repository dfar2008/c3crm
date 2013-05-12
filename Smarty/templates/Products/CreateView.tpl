

{*<!-- module header -->*}

<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-{$APP.LBL_JSCALENDAR_LANG}.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<script type="text/javascript" src="include/js/Inventory.js"></script>
{include file='Buttons_List_create.tpl'}

{*<!-- Contents -->*}
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>

	<td class="showPanelBg" valign=top width=100%>
	     {*<!-- PUBLIC CONTENTS STARTS-->*}
	     {$ERROR_MESSAGE}
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
	     <div class="small" style="padding:20px">
		
		 {if $OP_MODE eq 'edit_view'}   
			 <span class="lvtHeaderText"><font color="purple">[ {$ID} ] </font>{$NAME} -  {$APP.LBL_EDITING}{$MOD[$SINGLE_MOD]}{$APP.LBL_INFORMATION}</span> <br>
			{$UPDATEINFO}	 
		 {/if}
		 {if $OP_MODE eq 'create_view'}
			<span class="lvtHeaderText">{$APP.LBL_NEW}{$MOD[$SINGLE_MOD]}</span> <br>
		 {/if}

		 <hr noshade size=1>
		 <br> 
		
		

		{*<!-- Account details tabs -->*}
		<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
		   <tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
				   <tr>
					<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>

					{if $BLOCKS_COUNT eq 2}	
						<td width=75 style="width:15%" align="center" nowrap class="dvtSelectedCell" id="bi" onclick="fnLoadValues('bi','mi','basicTab','moreTab','inventory','{$MODULE}')"><b>{$APP.LBL_BASIC}{$APP.LBL_INFORMATION}</b></td>
                    				<td class="dvtUnSelectedCell" style="width: 100px;" align="center" nowrap id="mi" onclick="fnLoadValues('mi','bi','moreTab','basicTab','inventory','{$MODULE}')"><b>{$APP.LBL_MORE}{$APP.LBL_INFORMATION}</b></td>
                   				<td class="dvtTabCache" style="width:65%" nowrap>&nbsp;</td>
					{else}
						<td class="dvtSelectedCell" align=center nowrap>{$APP.LBL_BASIC}{$APP.LBL_INFORMATION}</td>
	                                        <td class="dvtTabCache" style="width:65%">&nbsp;</td>
					{/if}
				   <tr>
				</table>
			</td>
		   </tr>
		   <tr>
			<td valign=top align=left >

			    {foreach item=blockInfo key=divName from=$BLOCKS}
			    <!-- Basic and More Information Tab Opened -->
			    <div id="{$divName}">

				<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
				   <tr>
					<!--this td is to display the entity details -->
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
										<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';check_duplicate();" type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
                                                                 		<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="goback()" type="button" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
									   </div>
									</td>
								   </tr>

								   {foreach key=header item=data from=$blockInfo}
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
										<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save'; check_duplicate();" type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
										<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="goback()" type="button" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
									   </div>
									</td>
								   </tr>
								</table>
								<!-- General details - end -->
							</td>
						   </tr>
						</table>
					</td>
				   </tr>
				</table>
							
			    </div>
			    {/foreach}
			</td>
		   </tr>
		</table>
	 </div>
	</td>
	<td align=right valign=top><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
   </tr>
</table>
</form>

<script>



        var fieldname = new Array({$VALIDATION_DATA_FIELDNAME})

        var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL})

        var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE})
	
	if(getObj("productcode") != undefined && getObj("productcode").value == "") {ldelim}
	        getObj("productcode").value = "{$APP.AUTO_GEN_CODE}";
		//getObj("productcode").setAttribute("readOnly","true");
	{rdelim}
	


</script>
