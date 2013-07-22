<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td>{$APP.LBL_VIEW_SCOPE}: &nbsp;</td>
    <td>
		{assign var="viewscopefld" value="listviewscope"}
		<div class="chzn-select-div">
			<a href="javascript:ShowSeltUser_click('{$viewscopefld}');" class="chzn-single" tabindex="-1">
				<span id="{$viewscopefld}_name">{$VIEWSCOPENAME}</span>
				<input type="hidden" name="{$viewscopefld}_id" id="{$viewscopefld}_id" value="{$VIEWSCOPE}" />
				<div>
					<b/>
				</div>
			</a>
			<!--	 User List start	 -->
			<div class="chzn-userlist-div" id="{$viewscopefld}_div">
				<input type="text" name="{$viewscopefld}_text" id="{$viewscopefld}_text" 
					onkeydown="javascript:if(event.keyCode==13) return false;" 
					class="chzn-search" onKeyUp="SearchViewScope('{$MODULE}','{$viewscopefld}','{$VIEWSCOPE}',this)">
				<div id="{$viewscopefld}_info_div" style="overflow-y:auto;max-height:300px;height:300px;">
				</div>
				<script>
					setViewScopeOpts("{$MODULE}","{$viewscopefld}",'{$VIEWSCOPE}');
				</script>
			</div>
			<div id="{$viewscopefld}_bind_div" style="display: none;"></div>
			<!--	User List End		-->
		</div>
	</td>
	<td>&nbsp;&nbsp;</td>
	<td>
		{if $MODULE == 'Accounts'}
			<a id="moreoperate" href="" target="main" onmouseover="BatchfnDropDown(this,'selectoperate');" onmouseout="BatchfnHideDrop('selectoperate');" 
					onclick="return false;">
				{$APP.LBL_BULK_OPERATIONS}<img border="0" src="themes/images/collapse.gif">
			</a>
			<div id="selectoperate" class="drop_mnu" onMouseOut="BatchfnHideDrop('selectoperate')" onMouseOver="fnShowDrop('selectoperate')" >
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					{foreach key=button_check item=button_label from=$BUTTONS}
						{if $button_check eq 'quick_edit'}
							<tr><td>
								<a href="#" onclick="javascript:return quick_edit(this, 'quickedit', '{$MODULE}');" 
								class="drop_down">{$APP.LBL_QUICKEDIT_BUTTON_LABEL}</a>
							</td></tr>
						{elseif $button_check eq 'del'}
							<tr><td>
								<a href="#" onclick="javascript:return massDelete('{$MODULE}');" class="drop_down">{$APP.LBL_BULK_DELETE}</a>
							</td></tr>
						{elseif $button_check eq 'c_owner'}
							<tr><td>
							<a href="#" onclick="javascript:return change(this,'changeowner');" class="drop_down">{$button_label}</a>
							</td></tr>
							<tr><td>
							<a href="#" onclick="javascript:return change(this,'sharerecorddiv');" class="drop_down">{$APP.LBL_SHARE_BUTTON_LABEL}</a>
							</td></tr>
						{elseif $button_check eq 'merge'}
							<tr><td>
								<a href="#" onclick="javascript:merge_fields('selected_id', 'Accounts','{$CATEGORY}');return false;" class="drop_down">{$MOD.LBL_MERGE_DATA}</a>
							</td></tr>
						{/if}
					{/foreach}
					<tr><td>
						<a href="#" onclick="javascript:qunfa_sms(this, 'qunfasms', 'Accounts');return false;" class="drop_down">{$APP.LBL_BULK_SMS}</a>
					</td></tr>
					<tr><td>
						<a href="#" onclick="javascript:qunfa_mail(this, 'qunfamail', 'Accounts');return false;" class="drop_down">{$APP.LBL_BULK_MAIL}</a>
					</td></tr>
					{if $BUTTONS.quick_edit != ''}
					<tr><td>
						<a href="#" onclick="javascript:InAccountPool_click();return false;" 
							class="drop_down">{$APP.LBL_BULK_POOLS}</a>
					</td></tr>
					{/if}
				</table>
			</div>
		{elseif $MODULE == 'PurchaseOrder'}
			{foreach key=button_check item=button_label from=$BUTTONS}
					{if $button_check eq 'quick_edit'}
					<input class="crmbutton small cancel" type="button" value="{$APP.LBL_QUICKEDIT_BUTTON_LABEL}" onclick="return quick_edit(this, 'quickedit', '{$MODULE}')"/>
									{elseif $button_check eq 'del'}
										<input class="crmbutton small delete" type="button" value=" {$button_label} " onclick="return massDelete('{$MODULE}')"/>
					
				{elseif $button_check eq 'c_owner'}
							{if $MODULE neq 'Products' && $MODULE neq 'Faq' && $MODULE neq 'PriceBooks'}
												 <input class="crmbutton small edit" type="button" value=" {$button_label} " onclick="return change(this,'changeowner')"/>
						 <input class="crmbutton small edit" type="button" value=" {$APP.LBL_SHARE_BUTTON_LABEL} " onclick="return change(this,'sharerecorddiv')"/>
											{/if}
									{/if}
							 {/foreach}
			 {if $VIEWSALES == "1"}
				<input type="button"  class="crmbutton small save" value="{$APP.LNK_VIEW} {$APP.SalesOrder}" onclick="viewpurchase_click('&currpage=1');">
			 {/if}
		{elseif $MODULE == 'Gathers'}
			{if $BATCH_GATHERS}
				<input class="crmbutton small cancel" type="button" value="{$MOD.LBL_GATHERS_BUTTON_LABEL}" 
					onclick="return batch_gathers();"/>
			{/if}
			{foreach key=button_check item=button_label from=$BUTTONS}
				{if $button_check eq 'quick_edit'}
				<!-- <input class="crmbutton small cancel" type="button" value="{$APP.LBL_QUICKEDIT_BUTTON_LABEL}" onclick="return quick_edit(this, 'quickedit', '{$MODULE}')"/> -->
				{elseif $button_check eq 'del'}
					<input class="crmbutton small delete" type="button" value=" {$button_label} " onclick="return massDelete('{$MODULE}')"/>
				
				{elseif $button_check eq 'c_owner'}
					{if $MODULE neq 'Products' && $MODULE neq 'Faq' && $MODULE neq 'PriceBooks'}
						<input class="crmbutton small edit" type="button" value=" {$button_label} " onclick="return change(this,'changeowner')"/>
						<input class="crmbutton small edit" type="button" value=" {$APP.LBL_SHARE_BUTTON_LABEL} " onclick="return change(this,'sharerecorddiv')"/>
					{/if}
				{/if}
			{/foreach}
		{elseif $MODULE == 'Potentials'}
			<a id="moreoperate" href="index.php?module=Accounts&action=index" target="main" onmouseover="BatchfnDropDown(this,'selectoperate');" onmouseout="BatchfnHideDrop('selectoperate');" 
				onclick="return false;">
			{$APP.LBL_BULK_OPERATIONS}<img border="0" src="themes/images/collapse.gif">
			</a>
			<div id="selectoperate" class="drop_mnu" onMouseOut="BatchfnHideDrop('selectoperate')" onMouseOver="fnShowDrop('selectoperate')" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				{foreach key=button_check item=button_label from=$BUTTONS}
					{if $button_check eq 'quick_edit'}
						<tr><td>
							<a href="#" onclick="javascript:return quick_edit(this, 'quickedit', '{$MODULE}');" 
							class="drop_down">{$APP.LBL_QUICKEDIT_BUTTON_LABEL}</a>
						</td></tr>
					{elseif $button_check eq 'del'}
						<tr><td>
							<a href="#" onclick="javascript:return massDelete('{$MODULE}');" class="drop_down">{$APP.LBL_BULK_DELETE}</a>
						</td></tr>
					{elseif $button_check eq 'c_owner'}
						<tr><td>
						<a href="#" onclick="javascript:return change(this,'changeowner');" class="drop_down">{$button_label}</a>
						</td></tr>
						<tr><td>
						<a href="#" onclick="javascript:return change(this,'sharerecorddiv');" class="drop_down">{$APP.LBL_SHARE_BUTTON_LABEL}</a>
						</td></tr>
					{/if}
				{/foreach}
				<tr><td>
					<a href="#" onclick="javascript:qunfa_sms(this, 'qunfasms', '{$MODULE}');return false;" class="drop_down">{$APP.LBL_BULK_SMS}</a>
				</td></tr>
				<tr><td>
					<a href="#" onclick="javascript:qunfa_mail(this, 'qunfamail', '{$MODULE}');return false;" class="drop_down">{$APP.LBL_BULK_MAIL}</a>
				</td></tr>
			</table>
			</div>
		{elseif $MODULE == 'Warehouses'}
			{foreach key=button_check item=button_label from=$BUTTONS}
				{if $button_check eq 'quick_edit'}
					<input class="crmbutton small cancel" type="button" value="{$APP.LBL_QUICKEDIT_BUTTON_LABEL}" onclick="return quick_edit(this, 'quickedit', '{$MODULE}')"/>
				{elseif $button_check eq 'del'}
					<input class="crmbutton small delete" type="button" value=" {$button_label} " onclick="return massDelete('{$MODULE}')"/>	
				{elseif $button_check eq 'c_owner'}
					{if $MODULE neq 'Products' && $MODULE neq 'Faq' && $MODULE neq 'PriceBooks'}
						<input class="crmbutton small edit" type="button" value=" {$button_label} " onclick="return change(this,'changeowner')"/>
						<input class="crmbutton small edit" type="button" value=" {$APP.LBL_SHARE_BUTTON_LABEL} " onclick="return change(this,'sharerecorddiv')"/>
					{/if}
				{/if}
			{/foreach}

			{if $VIEWPURCHASE == 1}
				<input class="crmbutton small save" type="button" 
				value="{$APP.LNK_VIEW} {$APP.NOTWAREHOUSED} {$APP.PurchaseOrder}"
				onclick="viewpurchase_click('&currpage=1');"/>
			{/if}
			{if $VIEWDELIVERY == 1}
				<input class="crmbutton small save" type="button" 
				value="{$APP.LNK_VIEW} {$APP.CONSTANTS_NOTDELIVERYED} {$APP.Invoice}"
				onclick="viewpurchase_click('&currpage=1');"/>
			{/if}
		{elseif $MODULE == 'Contacts'}
			&nbsp;
			<a id="moreoperate" href="index.php?module=Accounts&action=index" target="main" onmouseover="BatchfnDropDown(this,'selectoperate');" onmouseout="BatchfnHideDrop('selectoperate');" 
			onclick="return false;">
			{$APP.LBL_BULK_OPERATIONS}<img border="0" src="themes/images/collapse.gif">
			</a>
			<div id="selectoperate" class="drop_mnu" onMouseOut="BatchfnHideDrop('selectoperate')" onMouseOver="fnShowDrop('selectoperate')" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				{foreach key=button_check item=button_label from=$BUTTONS}
					{if $button_check eq 'quick_edit'}
						<tr><td>
							<a href="#" onclick="javascript:return quick_edit(this, 'quickedit', '{$MODULE}');" 
							class="drop_down">{$APP.LBL_QUICKEDIT_BUTTON_LABEL}</a>
						</td></tr>
					{elseif $button_check eq 'del'}
						<tr><td>
							<a href="#" onclick="javascript:return massDelete('{$MODULE}');" class="drop_down">{$APP.LBL_BULK_DELETE}</a>
						</td></tr>
					{elseif $button_check eq 'c_owner'}
						<tr><td>
						<a href="#" onclick="javascript:return change(this,'changeowner');" class="drop_down">{$button_label}</a>
						</td></tr>
						<tr><td>
						<a href="#" onclick="javascript:return change(this,'sharerecorddiv');" class="drop_down">{$APP.LBL_SHARE_BUTTON_LABEL}</a>
						</td></tr>
					{/if}
				{/foreach}
				<tr><td>
					<a href="#" onclick="javascript:qunfa_sms(this, 'qunfasms', '{$MODULE}');return false;" class="drop_down">{$APP.LBL_BULK_SMS}</a>
				</td></tr>
				<tr><td>
					<a href="#" onclick="javascript:qunfa_mail(this, 'qunfamail', '{$MODULE}');return false;" class="drop_down">{$APP.LBL_BULK_MAIL}</a>
				</td></tr>
			</table>
			</div>
		{elseif $MODULE == 'Invoice'}
			{foreach key=button_check item=button_label from=$BUTTONS}
					{if $button_check eq 'quick_edit'}
					<input class="crmbutton small cancel" type="button" value="{$APP.LBL_QUICKEDIT_BUTTON_LABEL}" onclick="return quick_edit(this, 'quickedit', '{$MODULE}')"/>
									{elseif $button_check eq 'del'}
										<input class="crmbutton small delete" type="button" value=" {$button_label} " onclick="return massDelete('{$MODULE}')"/>
					
				{elseif $button_check eq 'c_owner'}
							{if $MODULE neq 'Products' && $MODULE neq 'Faq' && $MODULE neq 'PriceBooks'}
												 <input class="crmbutton small edit" type="button" value=" {$button_label} " onclick="return change(this,'changeowner')"/>
						 <input class="crmbutton small edit" type="button" value=" {$APP.LBL_SHARE_BUTTON_LABEL} " onclick="return change(this,'sharerecorddiv')"/>
											{/if}
									{/if}
							 {/foreach}
			 {if $VIEWSALES == "1"}
				<input type="button"  class="crmbutton small save" value="{$APP.LNK_VIEW} {$APP.SalesOrder}" onclick="viewpurchase_click('&currpage=1');">
			 {/if}
		{elseif $MODULE == 'Charges'}
			{if $BATCH_CHARGES}
				<input class="crmbutton small cancel" type="button" value="{$MOD.LBL_CHARGES_BUTTON_LABEL}" 
					onclick="return batch_charges();"/>
			{/if}
			{foreach key=button_check item=button_label from=$BUTTONS}
				{if $button_check eq 'quick_edit'}
				<!-- <input class="crmbutton small cancel" type="button" value="{$APP.LBL_QUICKEDIT_BUTTON_LABEL}" onclick="return quick_edit(this, 'quickedit', '{$MODULE}')"/> -->
				

								{elseif $button_check eq 'del'}
									<input class="crmbutton small delete" type="button" value=" {$button_label} " onclick="return massDelete('{$MODULE}')"/>
				
				{elseif $button_check eq 'c_owner'}
					{if $MODULE neq 'Products' && $MODULE neq 'Faq' && $MODULE neq 'PriceBooks'}
						<input class="crmbutton small edit" type="button" value=" {$button_label} " onclick="return change(this,'changeowner')"/>
						<input class="crmbutton small edit" type="button" value=" {$APP.LBL_SHARE_BUTTON_LABEL} " onclick="return change(this,'sharerecorddiv')"/>
					{/if}
				{/if}
			{/foreach}
		{elseif $MODULE == 'Calendar'}
			{foreach key=button_check item=button_label from=$BUTTONS}
				{if $button_check eq 'quick_edit'}
					<input class="crmbutton small cancel" type="button" value="{$APP.LBL_QUICKEDIT_BUTTON_LABEL}" onclick="return quick_edit(this, 'quickedit', '{$MODULE}')" />		
				{elseif $button_check eq 'del'}
					<input class="crmbutton small delete" type="button" value="{$button_label}" onclick="return massDelete('{$MODULE}')"/>
				{elseif $button_check eq 'c_owner'}						
					 <input class="crmbutton small edit" type="button" value="{$button_label}" onclick="return change(this,'changeowner')"/>
				{/if}
			{/foreach}
		{elseif $MODULE == 'Vcontacts'}
			<a id="moreoperate" href="index.php?module=Accounts&action=index" target="main" onmouseover="BatchfnDropDown(this,'selectoperate');" onmouseout="BatchfnHideDrop('selectoperate');" 
				onclick="return false;">
				{$APP.LBL_BULK_OPERATIONS}<img border="0" src="themes/images/collapse.gif">
				</a>
				<div id="selectoperate" class="drop_mnu" onMouseOut="BatchfnHideDrop('selectoperate')" onMouseOver="fnShowDrop('selectoperate')" >
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					{foreach key=button_check item=button_label from=$BUTTONS}
						{if $button_check eq 'quick_edit'}
							<tr><td>
								<a href="#" onclick="javascript:return quick_edit(this, 'quickedit', '{$MODULE}');" 
								class="drop_down">{$APP.LBL_QUICKEDIT_BUTTON_LABEL}</a>
							</td></tr>
						{elseif $button_check eq 'del'}
							<tr><td>
								<a href="#" onclick="javascript:return massDelete('{$MODULE}');" class="drop_down">{$APP.LBL_BULK_DELETE}</a>
							</td></tr>
						{elseif $button_check eq 'c_owner'}
							<tr><td>
							<a href="#" onclick="javascript:return change(this,'changeowner');" class="drop_down">{$button_label}</a>
							</td></tr>
							<tr><td>
							<a href="#" onclick="javascript:return change(this,'sharerecorddiv');" class="drop_down">{$APP.LBL_SHARE_BUTTON_LABEL}</a>
							</td></tr>
						{/if}
					{/foreach}
					<tr><td>
						<a href="#" onclick="javascript:qunfa_sms(this, 'qunfasms', '{$MODULE}');return false;" class="drop_down">{$APP.LBL_BULK_SMS}</a>
					</td></tr>
                     <tr><td>
						<a href="#" onclick="javascript:qunfa_mail(this, 'qunfamail', '{$MODULE}');return false;" class="drop_down">{$APP.LBL_BULK_MAIL}</a>
					</td></tr>
				</table>
				</div>
		{elseif $MODULE == 'Normaltasks'}
			{if $ALL  eq 'All'}
			<input class="crmbutton small delete" type="button" value=" 删除 " onclick="return deletedaccountBatch_click();"/>
			{/if}
			<input type="button" value=" 随机领取任务 " class="crmbutton small create" onclick="Lingquaccount_click();"/>
		{else}
			{foreach key=button_check item=button_label from=$BUTTONS}
				{if $button_check eq 'quick_edit'}
					<input class="crmbutton small cancel" type="button" value="{$APP.LBL_QUICKEDIT_BUTTON_LABEL}" onclick="return quick_edit(this, 'quickedit', '{$MODULE}')"/>
				{elseif $button_check eq 'del'}
					<input class="crmbutton small delete" type="button" value=" {$button_label} " onclick="return massDelete('{$MODULE}')"/>
				
				{elseif $button_check eq 'c_owner'}
					{if $MODULE neq 'Products' && $MODULE neq 'Faq'}
						<input class="crmbutton small edit" type="button" value=" {$button_label} " onclick="return change(this,'changeowner')"/>
						<input class="crmbutton small edit" type="button" value=" {$APP.LBL_SHARE_BUTTON_LABEL} " onclick="return change(this,'sharerecorddiv')"/>
					{/if}
				{/if}
			{/foreach}
		{/if}
	</td>
  </tr>
</table>