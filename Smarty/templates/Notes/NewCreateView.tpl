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

{*<!-- module header -->*}
<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
		{include file='Buttons_List_create.tpl'}

{*<!-- Contents -->*}
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>

	<td class="showPanelBg" valign=top width=100%>
	     {*<!-- PUBLIC CONTENTS STARTS-->*}
	     <div class="small" style="padding:0px">
<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php">
	<input type="hidden" name="max_file_size" value="{$MAX_FILE_SIZE}">
	<input type="hidden" name="filename" value="{$FILENAME}">
	<input type="hidden" name="form">
	<input type="hidden" name="email_id" value="{$EMAILID}">
	<input type="hidden" name="ticket_id" value="{$TICKETID}">
	<input type="hidden" name="fileid" value="{$FILEID}">
	<input type="hidden" name="old_id" value="{$OLD_ID}">
    <input type="hidden" name="module" value="{$MODULE}">
<input type="hidden" name="record" value="{$ID}">
<input type="hidden" name="mode" value="Notes">
<input type="hidden" name="action">
<input type="hidden" name="parenttab" value="{$CATEGORY}">
<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
<input type="hidden" name="return_id" value="{$RETURN_ID}">
<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
<input type="hidden" name="return_viewname" value="{$RETURN_VIEWNAME}">
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


								   {foreach key=header item=data from=$BASBLOCKS}
								   <tr>
									
						         		<td colspan=4 class="detailedViewHeader">
                                                <b>{$header}</b>
									
							 			</td>
		                           </tr>

								   <!-- Here we should include the uitype handlings-->
								   {include file="DisplayFields2.tpl"}
								   {/foreach}

								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
										
                                                                		<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';saveNotes();  " type="button" name="savebutton" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
																		
                                                                		<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="winsa.close()" type="button" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
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

{literal}
	
{/literal}
</script>



