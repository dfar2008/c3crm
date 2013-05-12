<table width="100%" border="0" cellpadding="5" cellspacing="0">
   <tr>
	<td>&nbsp;</td>
   </tr>

   <tr>
	<td align="left" class="genHeaderSmall">{$APP.LBL_ACTIONS}</td>
   </tr>

   <!-- SO Actions starts -->
    <tr>
	<td align="left" style="padding-left:10px;">
		<img src="{$IMAGE_PATH}pointer.gif" hspace="5" align="absmiddle"/>
		<a href="#" onclick="window.open('upload.php?return_action=DetailView&return_module={$MODULE}&return_id={$ID}','Attachments','width=500,height=300');" class="webMnu">{$APP.LBL_CREATE_BUTTON_LABEL}{$APP.LBL_ATTACHMENT}</a> 
	</td>
   </tr>  
   <tr>
	<td align="left" style="padding-left:10px;">
		<img src="{$IMAGE_PATH}pointer.gif" hspace="5" align="absmiddle"/>
		<a href="javascript: document.DetailView.module.value='PurchaseOrder'; document.DetailView.action.value='EditView'; document.DetailView.return_module.value='SalesOrder'; document.DetailView.return_action.value='DetailView'; document.DetailView.return_id.value='{$ID}'; document.DetailView.record.value='{$ID}';document.DetailView.convertmode.value='sotopurchaseorder'; document.DetailView.submit();" class="webMnu">{$APP.LBL_CREATE_BUTTON_LABEL}{$APP.PurchaseOrder}</a> 
	</td>
   </tr>
   <tr>
	<td align="left" style="padding-left:10px;">
		<img src="{$IMAGE_PATH}pointer.gif" hspace="5" align="absmiddle"/>
		<a href="javascript: document.DetailView.module.value='Invoice'; document.DetailView.action.value='EditView'; document.DetailView.return_module.value='SalesOrder'; document.DetailView.return_action.value='DetailView'; document.DetailView.return_id.value='{$ID}'; document.DetailView.record.value='{$ID}'; document.DetailView.convertmode.value='sotoinvoice'; document.DetailView.submit();" class="webMnu">{$APP.LBL_CREATE_BUTTON_LABEL}{$APP.Invoice}</a> 
	</td>
   </tr>


   <tr>
	<td align="left">
		<span class="genHeaderSmall">{$APP.LBL_TOOLS}</span><br /> 
	</td>
   </tr>
   {assign var=export_pdf_action value="CreateSOPDF"}
	

   <tr>
	<td align="left" style="padding-left:10px;">
		<img src="{$IMAGE_PATH}pointer.gif" hspace="5" align="absmiddle"/>
		<a href="javascript: document.DetailView.return_module.value='{$MODULE}';document.DetailView.return_action.value='DetailView';document.DetailView.module.value='{$MODULE}'; document.DetailView.action.value='{$export_pdf_action}';document.DetailView.record.value='{$ID}'; document.DetailView.return_id.value='{$ID}';document.DetailView.submit();" class="webMnu">{$APP.LBL_EXPORT_TO_PDF}</a> 
	</td>
   </tr>
   <tr>
	<td align="left" style="padding-left:10px;">
		<img src="{$IMAGE_PATH}pointer.gif" hspace="5" align="absmiddle"/>
		<a href="index.php?module={$MODULE}&action=CreatePDFPrint&record={$ID}" target="_blank" class="webMnu">{$APP.LNK_PRINT}</a>
	</td>
   </tr>
</table>
