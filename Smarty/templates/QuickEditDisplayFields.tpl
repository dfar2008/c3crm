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

{assign var="fldcount" value=0}
<div id="quickedit_field0" style="display: none;">&nbsp;</div>

<!-- Added this file to display the fields in Quick Edit Form page based on ui types  -->
{foreach key=header item=data from=$BLOCKS}
	

	{foreach key=label item=subdata from=$data}
		{foreach key=mainlabel item=maindata from=$subdata}
			{assign var="uitype" value="$maindata[0][0]"}
			{assign var="fldlabel" value="$maindata[1][0]"}
			{assign var="fldlabel_sel" value="$maindata[1][1]"}
			{assign var="fldlabel_combo" value="$maindata[1][2]"}
			{assign var="fldname" value="$maindata[2][0]"}
			{assign var="fldvalue" value="$maindata[3][0]"}
			{assign var="secondvalue" value="$maindata[3][1]"}
			{assign var="thirdvalue" value="$maindata[3][2]"}
			{assign var="vt_tab" value="$maindata[4][0]"}
			{if $uitype neq ''}
			

			
		
			{assign var="fldcount" value=$fldcount+1}

			<div id="quickedit_field{$fldcount}" uitype="{$uitype}" style="display: none;">
				{if $uitype eq 2}
					<font color="red">*</font>
					<input type="text" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				{elseif $uitype eq 3}<!-- Non Editable field, only configured value will be loaded -->
					<input readonly type="text" tabindex="{$vt_tab}" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" id ="{$fldname}" {if $MODE eq 'edit'} value="{$fldvalue}" {else} value="{$inv_no}" {/if} class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				{elseif $uitype eq 11 || $uitype eq 1 || $uitype eq 13 || $uitype eq 7 || $uitype eq 9}
					{if $fldname eq 'tickersymbol' && $MODULE eq 'Accounts'}
						<input type="text" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" id ="{$fldname}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn';" onBlur="this.className='detailedViewTextBox';{if $fldname eq 'tickersymbol' && $MODULE eq 'Accounts'}sensex_info(){/if}">
						<span id="vtbusy_info" style="display:none;"><img src="{$IMAGE_PATH}vtbusy.gif" border="0"></span>
					{else}
						<input type="text" tabindex="{$vt_tab}" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" id ="{$fldname}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				{/if}
				{elseif $uitype eq 19 || $uitype eq 20}
					<!-- In Add Comment are we should not display anything -->
					{if $fldlabel eq $MOD.LBL_ADD_COMMENT}
						{assign var=fldvalue value=""}
					{/if}
					{if $uitype eq 20}
						<font color="red">*</font>
					{/if}
					<textarea class="detailedViewTextBox" tabindex="{$vt_tab}" onFocus="this.className='detailedViewTextBoxOn'" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}"  onBlur="this.className='detailedViewTextBox'" cols="90" rows="8">{$fldvalue}</textarea>
					{if $fldlabel eq $MOD.Solution}
						<input type = "hidden" name="helpdesk_solution" value = '{$fldvalue}'>
					{/if}
				{elseif $uitype eq 21 || $uitype eq 24}
					{if $uitype eq 24}
						<font color="red">*</font>
					{/if}
					<textarea value="{$fldvalue}" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" rows=2>{$fldvalue}</textarea>
				{elseif $uitype eq 15 || $uitype eq 16 || $uitype eq 111} <!-- uitype 111 added for noneditable existing picklist values - ahmed -->
					{if $uitype eq 16}
						<font color="red">*</font>
					{/if}
					<select name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" class="small">
					{foreach item=arr from=$fldvalue}
						{foreach key=sel_value item=value from=$arr}
							<option value="{$sel_value}">                                                
								{$sel_value}
							</option>
						{/foreach}
					{/foreach}
				   </select>
				{elseif $uitype eq 33}
					<select MULTIPLE name="quickedit_value_{$fldname}[]" id="quickedit_value_{$fldname}" size="4" style="width:160px;" tabindex="{$vt_tab}" class="small">
						{foreach item=arr from=$fldvalue}
							{foreach key=sel_value item=value from=$arr}
                    						<option value="{$sel_value}" {$value}>{$sel_value}</option>		
                    					{/foreach}
						{/foreach}
				   </select>
				{elseif $uitype eq 53}
					{assign var=check value=1}
					{foreach key=key_one item=arr from=$fldvalue}
						{foreach key=sel_value item=value from=$arr}
							{if $value ne ''}
								{assign var=check value=$check*0}
							{else}
								{assign var=check value=$check*1}
							{/if}
						{/foreach}
					{/foreach}
					{if $check eq 0}
						{assign var=select_user value='checked'}
						{assign var=style_user value='display:block'}
						{assign var=style_group value='display:none'}
					{else}
						{assign var=select_group value='checked'}
						{assign var=style_user value='display:none'}
						{assign var=style_group value='display:block'}
					{/if}

					<input type="radio" tabindex="{$vt_tab}" name="assigntype" {$select_user} value="U" onclick="toggleAssignType(this.value)" >&nbsp;{$APP.LBL_USER}

					{if $secondvalue neq ''}
						<input type="radio" name="assigntype" {$select_group} value="T" onclick="toggleAssignType(this.value)">&nbsp;{$APP.LBL_GROUP}
					{/if}
				
					<span id="assign_user" style="{$style_user}">
						<select name="assigned_user_id" class="small">
							{foreach key=key_one item=arr from=$fldvalue}
								{foreach key=sel_value item=value from=$arr}
									<option value="{$key_one}" {$value}>{$sel_value}</option>
								{/foreach}
							{/foreach}
						</select>
					</span>

					{if $secondvalue neq ''}
						<span id="assign_team" style="{$style_group}">
							<select name="assigned_group_name" class="small">';
								{foreach key=key_one item=arr from=$secondvalue}
									{foreach key=sel_value item=value from=$arr}
										<option value="{$sel_value}" {$value}>{$sel_value}</option>
									{/foreach}
								{/foreach}
							</select>
						</span>
					{/if}
			{elseif $uitype eq 52 || $uitype eq 77}
				{if $uitype eq 52}
					<select name="assigned_user_id" class="small">
				{elseif $uitype eq 77}
					<select name="assigned_user_id1" tabindex="{$vt_tab}" class="small">
				{else}
					<select name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" class="small">
				{/if}

				{foreach key=key_one item=arr from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						<option value="{$key_one}" {$value}>{$sel_value}</option>
					{/foreach}
				{/foreach}
				</select>
			{elseif $uitype eq 51}
				{if $MODULE eq 'Accounts'}
					{assign var='popuptype' value = 'specific_account_address'}
				{else}
					{assign var='popuptype' value = 'specific_contact_account_address'}
				{/if}
				<input readonly name="account_name" style="border:1px solid #bababa;" type="text" value="{$fldvalue}"><input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img tabindex="{$vt_tab}" src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype={$popuptype}&form=TasksEditView&form_submit=false","test","width=640,height=602,resizable=0,scrollbars=0");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.account_id.value=''; this.form.account_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			{elseif $uitype eq 50}
				<font color="red">*</font>
				<input readonly name="account_name" type="text" value="{$fldvalue}"><input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype=specific&form=TasksEditView&form_submit=false","test","width=640,height=602,resizable=0,scrollbars=0");' align="absmiddle" style='cursor:hand;cursor:pointer'>
			{elseif $uitype eq 73}
				<font color="red">*</font>
				<input readonly name="account_name" id = "single_accountid" type="text" value="{$fldvalue}"><input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype=specific_account_address&form=TasksEditView&form_submit=false","test","width=640,height=602,resizable=0,scrollbars=0");' align="absmiddle" style='cursor:hand;cursor:pointer'>
			{elseif $uitype eq 75 || $uitype eq 81}
				{if $uitype eq 81}
					<font color="red">*</font>
					{assign var="pop_type" value="specific_vendor_address"}
					{else}{assign var="pop_type" value="specific"}
				{/if}
				<input name="vendor_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Vendors&action=Popup&html=Popup_picker&popuptype={$pop_type}&form=EditView","test","width=640,height=602,resizable=0,scrollbars=0");' align="absmiddle" style='cursor:hand;cursor:pointer'>
				{if $uitype eq 75}
					&nbsp;<input type="image" tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.vendor_id.value='';this.form.vendor_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				{/if}
			{elseif $uitype eq 57}
				<input name="contact_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='selectContact("false","general",document.EditView)' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.contact_id.value=''; this.form.contact_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
		
			{elseif $uitype eq 58}
				<input name="campaignname" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Campaigns&action=Popup&html=Popup_picker&popuptype=specific_campaign&form=EditView","test","width=640,height=602,resizable=0,scrollbars=0");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.campaignid.value=''; this.form.campaignname.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			{elseif $uitype eq 80}
				<input name="salesorder_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='selectSalesOrder();' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.salesorder_id.value=''; this.form.salesorder_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			{elseif $uitype eq 78}
				<input name="quote_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='selectQuote()' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.quote_id.value=''; this.form.quote_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			{elseif $uitype eq 76}			
				<input name="potential_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img tabindex="{$vt_tab}" src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='selectPotential()' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.potential_id.value=''; this.form.potential_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			{elseif $uitype eq 17}
				&nbsp;&nbsp;http://
				<input style="width:74%;" class = 'detailedViewTextBoxOn' type="text" tabindex="{$vt_tab}" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" style="border:1px solid #bababa;" size="27" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" onkeyup="validateUrl('{$fldname}');" value="{$fldvalue}">
			{elseif $uitype eq 85}
	            <img src="{$IMAGE_PATH}skype.gif" alt="Skype" title="Skype" LANGUAGE=javascript align="absmiddle"></img><input type="text" tabindex="{$vt_tab}" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" style="border:1px solid #bababa;" size="27" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="{$fldvalue}">
			{elseif $uitype eq 71 || $uitype eq 72}
				{if $uitype eq 72}
					<font color="red">*</font>
				{/if}
				<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" type="text" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"  value="{$fldvalue}">
			{elseif $uitype eq 56}
				{if $fldname eq 'notime' && $ACTIVITY_MODE eq 'Events'}
					{if $fldvalue eq 1}
							<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="checkbox" tabindex="{$vt_tab}" onclick="toggleTime()" checked>
					{else}
							<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" type="checkbox" onclick="toggleTime()" >
					{/if}
					<!-- For Portal Information we need a hidden field existing_portal with the current portal value -->
					{elseif $fldname eq 'portal'}
						<input type="hidden" name="existing_portal" value="{$fldvalue}">
						<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="checkbox" tabindex="{$vt_tab}" {if $fldvalue eq 1}checked{/if}>
				{else}
					{if $fldvalue eq 1}
							<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="checkbox" tabindex="{$vt_tab}" checked>
					{else}
							<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" type="checkbox" {if ( $PROD_MODE eq 'create' &&  $fldname|substr:0:3 neq 'cf_') ||( $fldname|substr:0:3 neq 'cf_' && $PRICE_BOOK_MODE eq 'create' ) || $USER_MODE eq 'create'}checked{/if}>
					{/if}
				{/if}
			{elseif $uitype eq 23 || $uitype eq 5 || $uitype eq 6}
				{foreach key=date_value item=time_value from=$fldvalue}
					{assign var=date_val value="$date_value"}
					{assign var=time_val value="$time_value"}
				{/foreach}

				<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" id="jscal_field_{$fldname}" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="{$date_val}">
				<img src="{$IMAGE_PATH}calendar.gif" id="jscal_trigger_{$fldname}" onclick="javascript:displayCalendar('jscal_field_{$fldname}',this)">

				{if $uitype eq 6}
					<input name="time_start" tabindex="{$vt_tab}" style="border:1px solid #bababa;" size="5" maxlength="5" type="text" value="{$time_val}">
				{/if}

				{foreach key=date_format item=date_str from=$secondvalue}
					{assign var=dateFormat value="$date_format"}
					{assign var=dateStr value="$date_str"}
				{/foreach}

				
				

		{elseif $uitype eq 63}
				<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="text" size="2" value="{$fldvalue}" tabindex="{$vt_tab}" >&nbsp;
				<select name="duration_minutes" tabindex="{$vt_tab}" class="small">
					{foreach key=labelval item=selectval from=$secondvalue}
						<option value="{$labelval}" {$selectval}>{$labelval}</option>
					{/foreach}
				</select>

		{elseif $uitype eq 68 || $uitype eq 66 || $uitype eq 62}
				<select class="small" name="parent_type" onChange='document.EditView.parent_name.value=""; document.EditView.parent_id.value=""'>
					{section name=combo loop=$fldlabel}
						<option value="{$fldlabel_combo[combo]}" {$fldlabel_sel[combo]}>{$fldlabel[combo]}</option>
					{/section}
				</select>
				<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">
				<input name="parent_name" readonly id = "parentid" type="text" style="border:1px solid #bababa;" value="{$fldvalue}">
				&nbsp;<img src="{$IMAGE_PATH}select.gif" tabindex="{$vt_tab}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module="+ document.EditView.parent_type.value +"&action=Popup&html=Popup_picker&form=HelpDeskEditView","test","width=640,height=602,resizable=0,scrollbars=0,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.parent_id.value=''; this.form.parent_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>

		{elseif $uitype eq 357}
			To:&nbsp;
				<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">
				<textarea readonly name="parent_name" cols="70" rows="2">{$fldvalue}</textarea>&nbsp;
				<select name="parent_type" class="small">
					{foreach key=labelval item=selectval from=$fldlabel}
						<option value="{$labelval}" {$selectval}>{$labelval}</option>
					{/foreach}
				</select>
				&nbsp;<img tabindex="{$vt_tab}" src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module="+ document.EditView.parent_type.value +"&action=Popup&html=Popup_picker&form=HelpDeskEditView","test","width=640,height=602,resizable=0,scrollbars=0,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.parent_id.value=''; this.form.parent_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			CC:&nbsp;
				<input name="ccmail" type="text" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"  value="">
			BCC:&nbsp;
				<input name="bccmail" type="text" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"  value="">
		{elseif $uitype eq 59}
				<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$secondvalue}">
				<input name="product_name" readonly type="text" value="{$fldvalue}">&nbsp;<img tabindex="{$vt_tab}" src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&action=Popup&html=Popup_picker&form=HelpDeskEditView&popuptype=specific","test","width=640,height=602,resizable=0,scrollbars=0,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<input type="image" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR}" title="{$APP.LBL_CLEAR}" LANGUAGE=javascript onClick="this.form.product_id.value=''; this.form.product_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>

		{elseif $uitype eq 55 || $uitype eq 255} 
			{if $uitype eq 55}	
			{elseif $uitype eq 255}	
				<font color="red">*</font>
			{/if}
			
			{if $fldvalue neq ''}
			<select name="salutationtype" class="small" style="width: 30%;">
				{foreach item=arr from=$fldvalue}
						<option value="{$arr[1]}" {$arr[2]}>
                                                	{$arr[0]}
                                                </option>
				{/foreach}
			</select>
			{/if}
			<input type="text" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" style="width: 65%;" value= "{$secondvalue}" >

		{elseif $uitype eq 22}
				<font color="red">*</font>
				<textarea name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" cols="30" tabindex="{$vt_tab}" rows="2">{$fldvalue}</textarea>

		{elseif $uitype eq 69}
				{if $MODULE eq 'Products'}
					<input name="del_file_list" type="hidden" value="">
					<div id="files_list" style="border: 1px solid grey; width: 500px; padding: 5px; background: rgb(255, 255, 255) none repeat scroll 0%; -moz-background-clip: initial; -moz-background-origin: initial; -moz-background-inline-policy: initial; font-size: x-small">{$APP.Files_Maximum_6}
						<input id="my_file_element" type="file" name="file_1" tabindex="{$vt_tab}"  onchange="validateFilename(this)"/>
						<!--input type="hidden" name="file_1_hidden" value=""/-->
						{assign var=image_count value=0}
						{if $maindata[3].0.name neq '' && $DUPLICATE neq 'true'}
						   {foreach name=image_loop key=num item=image_details from=$maindata[3]}
							<div align="center">
								<img src="{$image_details.path}{$image_details.name}" height="50">&nbsp;&nbsp;[{$image_details.orgname}]<input id="file_{$num}" value="Delete" type="button" class="crmbutton small delete" onclick='this.parentNode.parentNode.removeChild(this.parentNode);delRowEmt("{$image_details.orgname}")'>
							</div>
					   	   {assign var=image_count value=$smarty.foreach.image_loop.iteration}
					   	   {/foreach}
						{/if}
					</div>

					<script>
						{*<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->*}
						var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 6 );
						multi_selector.count = {$image_count}
						{*<!-- Pass in the file element -->*}
						multi_selector.addElement( document.getElementById( 'my_file_element' ) );
					</script>
				{else}
					<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}"  type="file" value="{$maindata[3].0.name}" tabindex="{$vt_tab}" onchange="validateFilename(this);" />
					<input name="{$fldname}_hidden"  type="hidden" value="{$maindata[3].0.name}" />
					<input type="hidden" name="id" value=""/>
					{ if $maindata[3].0.name != "" && $DUPLICATE neq 'true'}
						
				<div id="replaceimage">[{$maindata[3].0.orgname}] <a href="javascript:;" onClick="delimage({$ID})">Del</a></div>
					{/if}
					
				{/if}

		{elseif $uitype eq 61}
				<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}"  type="file" value="{$secondvalue}" tabindex="{$vt_tab}" onchange="validateFilename(this)"/>
				<input type="hidden" name="{$fldname}_hidden" value="{$secondvalue}"/>
				<input type="hidden" name="id" value=""/>{$fldvalue}
		{elseif $uitype eq 156}
				{if $fldvalue eq 'on'}
						{if ($secondvalue eq 1 && $CURRENT_USERID != $smarty.request.record) || ($MODE == 'create')}
							<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" type="checkbox" checked>
						{else}
							<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="on">
							<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" disabled tabindex="{$vt_tab}" type="checkbox" checked>
						{/if}	
				{else}
						{if ($secondvalue eq 1 && $CURRENT_USERID != $smarty.request.record) || ($MODE == 'create')}
							<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" type="checkbox">
						{else}
							<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" disabled tabindex="{$vt_tab}" type="checkbox">
						{/if}	
				{/if}
		{elseif $uitype eq 98}<!-- Role Selection Popup -->		
			<font color="red">*</font>
			{if $thirdvalue eq 1}
				<input name="role_name" id="role_name" readonly class="txtBox" tabindex="{$vt_tab}" value="{$secondvalue}" type="text">&nbsp;
				<a href="javascript:openPopup();"><img src="{$IMAGE_PATH}select.gif" align="absmiddle" border="0"></a>
			{else}	
				<input name="role_name" id="role_name" tabindex="{$vt_tab}" class="txtBox" readonly value="{$secondvalue}" type="text">&nbsp;
			{/if}	
			<input name="user_role" id="user_role" value="{$fldvalue}" type="hidden">
		{elseif $uitype eq 104}<!-- Mandatory Email Fields -->			
			 <font color="red">*</font>
			<input type="text" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" id ="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
			{elseif $uitype eq 115}<!-- for Status field Disabled for nonadmin -->
			   {if $secondvalue eq 1 && $CURRENT_USERID != $smarty.request.record}
			   	<select id="user_status" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" class="small">
			   {else}
			   	<select id="user_status" disabled name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" class="small">
			   {/if} 
				{foreach item=arr from=$fldvalue}
                                        <option value="{$arr[1]}" {$arr[2]} >
                                                {$arr[0]}
                                        </option>
				{/foreach}
			   </select>
			{elseif $uitype eq 105}
				{if $MODE eq 'edit' && $IMAGENAME neq ''}
					<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}"  type="file" value="{$maindata[3].0.name}" tabindex="{$vt_tab}" onchange="validateFilename(this);" />[{$IMAGENAME}]<br>{$APP.LBL_IMG_FORMATS}
					<input name="quickedit_value_{$fldname}_hidden"  type="hidden" value="{$maindata[3].0.name}" />
				{else}
					<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}"  type="file" value="{$maindata[3].0.name}" tabindex="{$vt_tab}" onchange="validateFilename(this);" /><br>{$APP.LBL_IMG_FORMATS}
					<input name="quickedit_value_{$fldname}_hidden"  type="hidden" value="{$maindata[3].0.name}" />
				{/if}
					<input type="hidden" name="id" value=""/>
					{$maindata[3].0.name}
			{elseif $uitype eq 103}
				<input type="text" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
			{elseif $uitype eq 101}<!-- for reportsto field USERS POPUP -->
				<input readonly name='reports_to_name' class="small" type="text" value='{$fldvalue}' tabindex="{$vt_tab}" ><input name='reports_to_id' type="hidden" value='{$secondvalue}'>&nbsp;<input title="Change [Alt+C]" accessKey="C" type="button" class="small" value='{$UMOD.LBL_CHANGE}' name=btn1 LANGUAGE=javascript onclick='return window.open("index.php?module=Users&action=Popup&form=UsersEditView&form_submit=false","test","width=640,height=603,resizable=0,scrollbars=0");'>
			{elseif $uitype eq 116}<!-- for currency in users details-->	
			   {if $secondvalue eq 1}
			   	<select name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" class="small">
			   {else}
			   	<select disabled name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" class="small">
			   {/if} 

				{foreach item=arr key=uivalueid from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						<option value="{$uivalueid}" {$value}>{$sel_value}</option>
						<!-- code added to pass Currency field value, if Disabled for nonadmin -->
						{if $value eq 'selected' && $secondvalue neq 1}
							{assign var="curr_stat" value="$uivalueid"}
						{/if}
						<!--code ends -->
					{/foreach}
				{/foreach}
			   </select>
			<!-- code added to pass Currency field value, if Disabled for nonadmin -->
			{if $curr_stat neq ''}
				<input name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" type="hidden" value="{$curr_stat}">
			{/if}
			<!--code ends -->
			{elseif $uitype eq 106}
				<font color="red">*</font>
				{if $MODE eq 'edit'}
				<input type="text" readonly name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				{else}
				<input type="text" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				{/if}
			{elseif $uitype eq 99}
				{if $MODE eq 'create'}
					<font color="red">*</font>

					<input type="password" name="quickedit_value_{$fldname}" id="quickedit_value_{$fldname}" tabindex="{$vt_tab}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				{/if}
		{elseif $uitype eq 30}
				{assign var=check value=$secondvalue[0]}
				{assign var=yes_val value=$secondvalue[1]}
				{assign var=no_val value=$secondvalue[2]}

				<input type="radio" name="set_reminder" tabindex="{$vt_tab}" value="Yes" {$check}>&nbsp;{$yes_val}&nbsp;
				<input type="radio" name="set_reminder" value="No">&nbsp;{$no_val}&nbsp;

				{foreach item=val_arr from=$fldvalue}
					{assign var=start value="$val_arr[0]"}
					{assign var=end value="$val_arr[1]"}
					{assign var=sendname value="$val_arr[2]"}
					{assign var=disp_text value="$val_arr[3]"}
					{assign var=sel_val value="$val_arr[4]"}
					<select name="{$sendname}" class="small">
						{section name=reminder start=$start max=$end loop=$end step=1 }
							{if $smarty.section.reminder.index eq $sel_val}
								{assign var=sel_value value="SELECTED"}
							{else}
								{assign var=sel_value value=""}
							{/if}
							<OPTION VALUE="{$smarty.section.reminder.index}" "{$sel_value}">{$smarty.section.reminder.index}</OPTION>
						{/section}
					</select>
					&nbsp;{$disp_text}
				{/foreach}
		{elseif $uitype eq 83} <!-- Handle the Tax in Inventory -->
			{foreach item=tax key=count from=$TAX_DETAILS}
				{if $tax.check_value eq 1}
					{assign var=check_value value="checked"}
					{assign var=show_value value="visible"}
				{else}
					{assign var=check_value value=""}
					{assign var=show_value value="hidden"}
				{/if}
				<div style="border:0px solid red;">
					{$tax.taxlabel} {$APP.COVERED_PERCENTAGE}
					<input type="checkbox" name="{$tax.check_name}" id="{$tax.check_name}" class="small" onclick="fnshowHide(this,'{$tax.taxname}')" {$check_value}>
				</div>
				<div style="border:0px solid red;">
					<input type="text" class="detailedViewTextBox" name="{$tax.taxname}" id="{$tax.taxname}" value="{$tax.percentage}" style="visibility:{$show_value};" onBlur="fntaxValidation('{$tax.taxname}')">
				</div>
			{/foreach}
		{/if}
</div>
{/if}
	{/foreach}
{/foreach}
{/foreach}


