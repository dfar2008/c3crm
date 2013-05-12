<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr><td>{include file='Buttons_List1.tpl'}</td></tr>
<tr><td>
<!-- Contents -->
<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
<tr>
	<td  valign=top width=100%>
		<!-- PUBLIC CONTENTS STARTS-->
		<div class="small" style="padding:10px" >
	
		<!-- Account details tabs -->
		<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
		<tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
				<tr>
					<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
					
					<td class="dvtSelectedCell" align=center nowrap>{$APP[$SINGLE_MOD]} {$APP.LBL_INFORMATION}</td>	
					<td class="dvtTabCache" style="width:10px">&nbsp;</td>
					{if $SinglePane_View eq 'false'}
						<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=CallRelatedList&module={$MODULE}&record={$ID}&parenttab={$CATEGORY}">{$APP.LBL_RELATED_INFO}</a></td>
					{/if}
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
					<td style="padding:5px">
					<!-- Command Buttons -->
				<form action="index.php" method="post" name="DetailView" id="form">
				<input type="hidden" name="parenttab" id="parenttab" value="{$CATEGORY}">
				<input type="hidden" name="module" id="module" value="{$MODULE}">
				<input type="hidden" name="record" id="record" value="{$ID}">
				<input type="hidden" name="isDuplicate" value=false>
				<input type="hidden" name="action" id="action">
				<input type="hidden" name="return_module" id="return_module">
				<input type="hidden" name="return_action" id="return_action">
				<input type="hidden" name="return_id" id="return_id">
				    <table border=0 cellspacing=0 cellpadding=0 width=100%>
					{strip}<tr>
					<td  colspan=4 style="padding:5px">		
					
						<table border=0 cellspacing=0 cellpadding=0 width=100%>
						<tr>
						<td>
						<input type="button" name="button" value=" 返回 " class="crmbutton small edit"  onclick="javascript:history.go(-1);">
						</td>
						</tr>
						</table>

							</td>
						     </tr>{/strip}
						     <tr><td>
							{foreach key=header item=detail from=$BLOCKS}
							<!-- Detailed View Code starts here-->
							<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
							<tr>
							<td width="25%" height="1"></td><td height="1" width="25%"></td>
							<td width="25%" height="1"></td><td height="1" width="25%"></td>
							</tr>
							 
						     <tr>{strip}
						     <td colspan=4 class="dvInnerHeader">
							<b>
						        	{$header}
	  			     			</b>
						     </td>{/strip}
					             </tr>
						   {foreach item=detail from=$detail}
						     <tr style="height:25px">
							{foreach key=label item=data from=$detail}
							   {assign var=keyid value=$data.ui}
							   {assign var=keyval value=$data.value}
							   {assign var=keyseclink value=$data.link}
							   {if $label ne ''}
							    <td class="dvtCellLabel" align=right>{$label}</td>								
							    {include file="DetailViewFields.tpl"}
							   {/if}
                                                        {/foreach}
						      </tr>	
						   {/foreach}	
						   </table>
                     	                      </td>
					   </tr>
		<tr><td>
			{/foreach}
                    {*-- End of Blocks--*} 
			</td>
                </tr>
		<tr><td>
			 <!-- Product Details informations -->
			 {$ASSOCIATED_PRODUCTS}
		</td></tr>
	   
			{if $SinglePane_View eq 'false'}
			                  <tr>
					     <td style="padding:10px">
		           <table border=0 cellspacing=0 cellpadding=0 width=100%>
				     {strip}<tr nowrap>
							<td  colspan=4 style="padding:5px">
						<table border=0 cellspacing=0 cellpadding=0 width=100%>
						<tr>
						<td>
					
						

						</td>
						</tr>
						</table>

							</td>


						     </tr>{/strip}
				</table>
</td></tr>
{/if}
</form>
		</table>
		</td>
		
</tr>
</table>
</td>
</tr></table>
</td>
	<td align=right valign=top><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
</tr></table>

