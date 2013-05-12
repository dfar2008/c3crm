<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr><td>{include file='Buttons_List_details.tpl'}</td></tr>
<tr><td>
<!-- Contents -->
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center  >
<tr >
	
	<td  valign=top width="100%">
		<!-- PUBLIC CONTENTS STARTS-->
		<div class="small" style="padding:0px">
		
		<!-- Account details tabs -->
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
                <table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace" >
				<tr>

					<td align=left>
					<!-- content cache -->
					
				<table border=0 cellspacing=0 cellpadding=0 width=100%>
                <tr>
					<td style="padding:5px">
					<!-- Command Buttons -->
				<form action="index.php" method="post" name="DetailView" id="form">
					{include file='DetailViewHidden.tpl'}
				    <table border=0 cellspacing=0 cellpadding=0 width=100%>
					{strip}<tr>
					<td  colspan=4 style="padding:5px">		
					
						<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
						<tr>
						<td>
					
						
						<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;{$APP.LBL_EDIT_BUTTON_LABEL}&nbsp;">&nbsp;
						<input title="{$APP.LBL_LIST_BUTTON_TITLE}" class="crmbutton small edit" onclick="document.location.href='index.php?module={$MODULE}&action=index&parenttab={$CATEGORY}'" type="button" name="ListView" value="&nbsp;{$APP.LBL_LIST_BUTTON_LABEL}&nbsp;">&nbsp;
						
						</td>
						<td align=right>
    							
                                 <!--<input type="button" value=" 选择新增 " class="crmbutton small edit" onclick="return select_add(this, 'selectadd', 'Accounts','{$ID}')"  />-->
                                 
                                  <a id="moreadd" href="index.php?module=Accounts&action=DetailView&record={$ID}" target="main" onmouseover="fnDropDown(this,'selectadd');" >更多新增操作<img  border="0" src="themes/images/collapse.gif"></a>
								&nbsp;
								<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="crmbutton small create" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.isDuplicate.value='true';this.form.module.value='{$MODULE}'; this.form.action.value='EditView'" type="submit" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}">&nbsp;
								<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="crmbutton small delete" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='index'; this.form.action.value='Delete'; return confirm('{$APP.NTC_DELETE_CONFIRMATION}')" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}">&nbsp;
								

						</td>
						</tr>
						</table>

							</td>
						     </tr>{/strip}
						     <tr><td>
						{foreach key=header item=detail name=listviewforeach from=$BLOCKS}
							<!-- Detailed View Code starts here-->
							<table border=0 cellspacing=0 cellpadding=0 width=100% class="small" style="padding-bottom:10px;">
							<tr>
							<td width="20%" height="1"></td><td height="1" width="30%"></td>
							<td width="20%" height="1"></td><td height="1" width="30%"></td>
							</tr>							
						    <tr style="height:25px;">{strip}
                             {if $smarty.foreach.listviewforeach.iteration > 1}    
                             <td colspan=4 class="dvInnerHeader" style="cursor:Pointer;" onclick="ToggleGroupContent('Gsub{$smarty.foreach.listviewforeach.iteration}','Gimg{$smarty.foreach.listviewforeach.iteration}')">                                <img id="Gimg{$smarty.foreach.listviewforeach.iteration}" border="0" src="themes/images/expand.gif">
                                <b>
                                  {$header}
                                </b>
                               {else}
                               <td colspan=4 class="dvInnerHeader" style="cursor:Pointer;" >
                                <b>
                                  {$header}
                                </b>
                               {/if}
						     </td>{/strip}
					        </tr>
                              {if $smarty.foreach.listviewforeach.iteration > 1}
                                 <tr>
                                 <td colspan=4>
                                <div id="Gsub{$smarty.foreach.listviewforeach.iteration}" style="display:none;">
                                <table  border=0 cellspacing=0 cellpadding=0 width=100% class="small">
                             {else}
                             	 <tr>
                                 <td colspan=4>
                                 <table  border=0 cellspacing=0 cellpadding=0 width=100% class="small">
                              {/if}
                               {foreach item=detail from=$detail}
                                 <tr style="height:25px" >
                                {foreach key=label item=data from=$detail}
                                   {assign var=keyid value=$data.ui}
                                   {assign var=keyval value=$data.value}
                                   {assign var=keyseclink value=$data.link}
                                   {if $label ne ''}
                                    <td class="dvtCellLabel" align=right width="25%">{$label}</td>								
                                    	{include file="DetailViewFields.tpl"}
                                   {/if}
                                {/foreach}
                                  </tr>	
                               {/foreach}
                              {if $smarty.foreach.listviewforeach.iteration > 1}
                                   </table>
                              	 </div>	
                              	 </td>
                               </tr>
                               {else}
                                 </table>
                              	 </td>
                               </tr>
                              {/if}
						   </table>
                     	     </td>
					   </tr>
		<tr><td>
			{/foreach}
                    {*-- End of Blocks--*} 
			</td>
                </tr>

</form>
		
		</table>

		</td>
       
		</tr>
		</table>
		
		</div>
		<!-- PUBLIC CONTENTS STOPS-->
	</td>
</tr>
<tr>
<td>
	
	{include file= 'RelatedListNew.tpl'}
	
</td>
</tr>

</table>
</td>
</tr></table>
</td>
</tr></table>

