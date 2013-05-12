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
<script language="JavaScript" type="text/javascript" src="modules/PriceBooks/PriceBook.js"></script>
<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
{literal}
<script>
function editProductListPrice(id,pbid,price)
{
        $("status").style.display="inline";
        new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'action=ProductsAjax&file=EditListPrice&return_action=CallRelatedList&return_module=PriceBooks&module=Products&parenttab=Settings&record='+id+'&pricebook_id='+pbid+'&listprice='+price,
                        onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("editlistprice").innerHTML= response.responseText;
                        }
                }
        );
}

function gotoUpdateListPrice(id,pbid,proid)
{
        $("status").style.display="inline";
        $("roleLay").style.display = "none";
        var listprice=$("list_price").value;
                new Ajax.Request(
                        'index.php',
                        {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'module=Products&action=ProductsAjax&file=UpdateListPrice&ajax=true&return_action=CallRelatedList&return_module=PriceBooks&record='+id+'&pricebook_id='+pbid+'&product_id='+proid+'&list_price='+listprice,
                                onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                }
                        }
                );
}
{/literal}

function loadCvList(type,id) {ldelim}
        if(type === 'Accounts')
	{ldelim}
		if($("account_cv_list").value != 'None')
		{ldelim}
		$("account_list_button").innerHTML = '<input title="{$MOD.LBL_LOAD_LIST}" accessKey="" class="crmbutton small edit" value="{$MOD.LBL_LOAD_LIST}" type="button"  name="button" onclick="window.location.href=\'index.php?action=LoadList&module=Campaigns&return_action=DetailView&return_id='+id+'&list_type='+type+'&cvid='+$("account_cv_list").value+'\'">';
		{rdelim}
	{rdelim}
	if(type === 'Contacts')
	{ldelim}
		if($("cont_cv_list").value !='None')
		{ldelim}
			$("contact_list_button").innerHTML = '<input title="{$MOD.LBL_LOAD_LIST}" accessKey="" class="crmbutton small edit" value="{$MOD.LBL_LOAD_LIST}" type="button"  name="button" onclick="window.location.href=\'index.php?action=LoadList&module=Campaigns&return_id='+id+'&list_type='+type+'&cvid='+$("cont_cv_list").value+'\'">';
		{rdelim}
	{rdelim}
	if(type === 'Leads')
	{ldelim}
		if($("lead_cv_list").value != 'None')
		{ldelim}
			$("lead_list_button").innerHTML = '<input title="{$MOD.LBL_LOAD_LIST}" accessKey="" class="crmbutton small edit" value="{$MOD.LBL_LOAD_LIST}" type="button"  name="button" onclick="window.location.href=\'index.php?action=LoadList&module=Campaigns&return_id='+id+'&list_type='+type+'&cvid='+$("lead_cv_list").value+'\'">';
		{rdelim}
	{rdelim}

	
{rdelim}
</script>
	{include file='Buttons_List1.tpl'}
<!-- Contents -->
<div id="editlistprice" style="position:absolute;width:300px;"></div>
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
<tr>
	<td valign=top><img src="{$IMAGE_PATH}showPanelTopLeft.gif"></td>
	<td class="showPanelBg" valign=top width=100%>
		<!-- PUBLIC CONTENTS STARTS-->
		<div class="small" style="padding:20px">
		
		
			 <span class="lvtHeaderText"><font color="purple">[ {$ID} ] </font>{$NAME} -  {$APP.$SINGLE_MOD} {$APP.LBL_RELATED_INFO}</span> <br>
			 {$UPDATEINFO}
			 <hr noshade size=1>
			 <br> 
		
			<!-- Account details tabs -->
			<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
			<tr>
				<td>
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
						<tr>
							{if $OP_MODE eq 'edit_view'}
		                                                {assign var="action" value="EditView"}
                		                        {else}
                                		                {assign var="action" value="DetailView"}
		                                        {/if}
							<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
							{if $MODULE eq 'Calendar'}
                                                	<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action={$action}&module={$MODULE}&record={$ID}&activity_mode={$ACTIVITY_MODE}&parenttab={$CATEGORY}">{$APP.$SINGLE_MOD} {$APP.LBL_INFORMATION}</a></td>
		                                        {else}
                		                        <td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action={$action}&module={$MODULE}&record={$ID}&parenttab={$CATEGORY}">{$APP.$SINGLE_MOD} {$APP.LBL_INFORMATION}</a></td>
                                		        {/if}
							<td class="dvtTabCache" style="width:10px">&nbsp;</td>
							<td class="dvtSelectedCell" align=center nowrap>{$APP.LBL_RELATED_INFO}</td>
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
							<!-- content cache -->
								<table border=0 cellspacing=0 cellpadding=0 width=100%>
									<tr>
										<td style="padding:10px">
										   <!-- General details -->
												{include file='RelatedListsHidden.tpl'}
												<div id="RLContents">
					                                                        {include file='RelatedListContents.tpl'}
                                        						        </div>
												</form>
										  {*-- End of Blocks--*} 
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
	<!-- PUBLIC CONTENTS STOPS-->
	</td>
	<td align=right valign=top><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
</tr>
</table>