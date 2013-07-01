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

<!-- Added this file to display the fields in Create Entity page based on ui types  -->
{foreach key=label item=subdata from=$data}
	{if $header eq 'Product Details'}
		<tr>
	{else}
		<tr style="height:25px">
	{/if}
	{foreach key=mainlabel item=maindata from=$subdata}
		{assign var="uitype" value="$maindata[0][0]"}
		{assign var="fldlabel" value="$maindata[1][0]"}
		{assign var="fldlabel_sel" value="$maindata[1][1]"}
		{assign var="fldlabel_combo" value="$maindata[1][2]"}
		{assign var="fldname" value="$maindata[2][0]"}
		{assign var="fldvalue" value="$maindata[3][0]"}
		{assign var="secondvalue" value="$maindata[3][1]"}
		{assign var="thirdvalue" value="$maindata[3][2]"}
		{assign var="fourthvalue" value="$maindata[3][3]"}
		{assign var="vt_tab" value="$maindata[4][0]"}
		{assign var="readonly" value="$maindata[0][1]"}
		{assign var="mandatory" value="$maindata[0][2]"}
		{if $readonly eq '0'}
		        {assign var="disable" value=" disabled "}
		{else}
		        {assign var="disable" value=" "}
		{/if}
		{if $mandatory eq '1'}
		        {assign var="required" value=" <font color='red'>*</font> "}
		{else}
		        {assign var="required" value=" "}
		{/if}
		
		

		{if $uitype eq 2}
			<td width=20% class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width=30% align=left class="dvtCellInfo">
				<input{$disable} type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
			</td>
		{elseif $uitype eq 11 || $uitype eq 1 || $uitype eq 13 || $uitype eq 7 || $uitype eq 9}
			<td width=20% class="dvtCellLabel" align=right>{$required}{$fldlabel}</td>
			<td width=30% align=left class="dvtCellInfo">
              <input{$disable} type="text" tabindex="{$vt_tab}" name="{$fldname}" id ="{$fldname}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
            </td>       
		{elseif $uitype eq 10}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} readonly name="{$thirdvalue}" type="text" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick="return openUITenPopup('{$fourthvalue}');" align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.{$thirdvalue}.value=''; document.EditView.{$fldname}.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 19 || $uitype eq 20}
			<!-- In Add Comment are we should not display anything -->
			{if $fldlabel eq $MOD.LBL_ADD_COMMENT}
				{assign var=fldvalue value=""}
			{/if}
			<td width=20% class="dvtCellLabel" align=right>
				{$required}
				{$fldlabel}
			</td>
			<td colspan=3>
				<textarea{$disable} class="detailedViewTextBox" tabindex="{$vt_tab}" onFocus="this.className='detailedViewTextBoxOn'" name="{$fldname}"  onBlur="this.className='detailedViewTextBox'" cols="90" rows="8">{$fldvalue|escape}</textarea>
			</td>
		{elseif $uitype eq 21 || $uitype eq 24}
			<td width=20% class="dvtCellLabel" align=right>
				{$required}
				{$fldlabel}
			</td>
			<td width=30% align=left class="dvtCellInfo">
				<textarea{$disable} value="{$fldvalue}" name="{$fldname}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" rows=2>{$fldvalue|escape}</textarea>
			</td>
		{elseif $uitype eq 15 || $uitype eq 16 || $uitype eq 111} <!-- uitype 111 added for noneditable existing picklist values - ahmed -->
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}
				{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			   <select{$disable} name="{$fldname}" tabindex="{$vt_tab}" class="small">
				{foreach item=arr from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						<option value="{$sel_value}" {$value}>                                                
                                                        {$sel_value}
                                                </option>
					{/foreach}
				{/foreach}
			   </select>
               {if $fldname == 'memday940'}
               		<select name="memday942" class="small">
                    	<option value="">月</option>
                    </select>
                    <select name="memday944" class="small">
                    	<option value="">日</option>
                    </select>
               {/if}
			</td>
        {elseif $uitype eq 155} <!-- uitype 111 added for noneditable existing picklist values - ahmed -->
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}
				{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			   <select{$disable} name="{$fldname}" tabindex="{$vt_tab}" class="small">
				{foreach item=arr from=$fldvalue}
						<option value="{$arr.0.0}" {$arr.1}>                                                
                                                        {$arr.0.1}
                                                </option>
				{/foreach}
			   </select>
			</td>
        {elseif $uitype eq 1021 || $uitype eq 1022|| $uitype eq 1023}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}
				{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			   <select{$disable} name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" class="small" onchange="multifieldSelectChange('{$uitype}','{$secondvalue}','{$MODULE}',this);">
				{foreach item=value from=$fldvalue}

						<option value="{$value[1]}" relvalue="{$value[0]}" {$value[2]}>
                                                        {$value[1]}

				{/foreach}
			   </select>
			</td>
		{elseif $uitype eq 33}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			   <select{$disable} MULTIPLE name="{$fldname}[]" size="4" style="width:160px;" tabindex="{$vt_tab}" class="small">
                                                                                        {foreach key=key_one item=arr from=$fldvalue}
				                    					{foreach key=sel_value item=value from=$arr}
                    										<option value="{$sel_value}" {$value}>{$sel_value}</option>		
                    									{/foreach}
											{/foreach}
			   </select>
			</td>

		{elseif $uitype eq 53}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">	
				<select{$disable} name="assigned_user_id" class="small">
					{foreach key=key_one item=arr from=$fldvalue}
						{foreach key=sel_value item=value from=$arr}
							<option value="{$key_one}" {$value}>{$sel_value}</option>
						{/foreach}
					{/foreach}
				</select>				
			</td>
		{elseif $uitype eq 54}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">				
				<select{$disable} name="{$fldname}" tabindex="{$vt_tab}" class="small">
				{foreach key=key_one item=arr from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						<option value="{$sel_value}" {$value}>{$sel_value}</option>
					{/foreach}
				{/foreach}
				</select>
			</td>
		{elseif $uitype eq 52 || $uitype eq 77}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				{if $uitype eq 52}
					<select{$disable} name="assigned_user_id" class="small">
				{elseif $uitype eq 77}
					<select{$disable} name="assigned_user_id" tabindex="{$vt_tab}" class="small">
				{else}
					<select{$disable} name="{$fldname}" tabindex="{$vt_tab}" class="small">
				{/if}

				{foreach key=key_one item=arr from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						<option value="{$key_one}" {$value}>{$sel_value}</option>
					{/foreach}
				{/foreach}
				</select>
			</td>
		{elseif $uitype eq 1004}
		        <td  class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td  align=left class="dvtCellInfo">
				{$fldvalue}
			</td>
		{elseif $uitype eq 51}
			{if $MODULE eq 'Accounts'}
				{assign var='popuptype' value = 'specific_account_address'}
			{else}
				{assign var='popuptype' value = 'specific_contact_account_address'}
			{/if}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} readonly name="account_name" class="detailedViewTextBox"  type="text" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">
                <br>①直接查客户: <input style='border: 1px solid rgb(186, 186, 186);' id='account_search_val' name='account_search_val' type="text">&nbsp;<input type='button' value='查' onclick='SearchAccountVal();'>
                <br>②浏览选客户: <img tabindex="{$vt_tab}" src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype={$popuptype}&form=TasksEditView&form_submit=false","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.account_id.value=''; document.EditView.account_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 50}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} readonly name="account_name" class="detailedViewTextBox"  type="text" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">
                <br>①直接查客户: <input style='border: 1px solid rgb(186, 186, 186);' id='account_search_val' name='account_search_val' type="text">&nbsp;<input type='button' value='查' onclick='SearchAccountVal();'>
                <br>②浏览选客户: <img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype=specific&form=TasksEditView&form_submit=false","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 73}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} readonly class="detailedViewTextBox" name="account_name" type="text" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;
                <br>①直接查客户:<input style='border: 1px solid rgb(186, 186, 186);' id='account_search_val' name='account_search_val' type="text">&nbsp;<input type='button' value='查' onclick='SearchAccountVal();'>
                <br>②浏览选客户:<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype=specific_account_address&form=TasksEditView&form_submit=false","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 75 || $uitype eq 81}
			<td width="20%" class="dvtCellLabel" align=right>
				{if $uitype eq 81}
					{$required}
					{assign var="pop_type" value="specific_vendor_address"}
					{else}{assign var="pop_type" value="specific"}
				{/if}
				{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="vendor_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Vendors&action=Popup&html=Popup_picker&popuptype={$pop_type}&form=EditView","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>
				{if $uitype eq 75}
					&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.vendor_id.value='';document.EditView.vendor_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				{/if}
			</td>
		{elseif $uitype eq 57}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			
				<td width="30%" align=left class="dvtCellInfo">
                    <!--
					<input{$disable} name="contact_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return openContactPopup()' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.contact_id.value=''; document.EditView.contact_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				-->
                  <select{$disable} name="{$fldname}"  id="{$fldname}">
                      {$fldvalue}
                  </select>
                </td>
		{elseif $uitype eq 154}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			
				<td width="30%" align=left class="dvtCellInfo">
					<input{$disable} name="cangkuname2" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Cangkus&action=Popup&html=Popup_picker&popuptype=specific_cangku&form=EditView","test","width=700,height=602,resizable=1,scrollbars=1") ' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.cangkusid2.value=''; document.EditView.cangkuname2.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
				</td>	
		
		{elseif $uitype eq 58}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="campaignname" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Campaigns&action=Popup&html=Popup_picker&popuptype=specific_campaign&form=EditView","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.campaignid.value=''; document.EditView.campaignname.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 80}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="salesorder_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return openSOPopup()' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.salesorder_id.value=''; document.EditView.salesorder_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 1010}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="invoice_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return openInvoicePopup()' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.invoiceid.value=''; document.EditView.invoice_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 79}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="purchaseorder_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=PurchaseOrder&action=Popup&html=Popup_picker&popuptype=specific&form=EditView","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.purchaseorder_id.value=''; document.EditView.purchaseorder_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 78}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="quote_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Quotes&action=Popup&html=Popup_picker&popuptype=specific&form=EditView","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.quote_id.value=''; document.EditView.quote_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 76}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="potential_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img tabindex="{$vt_tab}" src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return openPotentialPopup();' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.potential_id.value=''; document.EditView.potential_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 17}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				&nbsp;&nbsp;http://&nbsp;
				<input{$disable} type="text" tabindex="{$vt_tab}" name="{$fldname}" style="border:1px solid #bababa;" size="27" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="{$fldvalue}">
			</td>

		{elseif $uitype eq 85}
                        <td width="20%" class="dvtCellLabel" align=right>
                                {$required}{$fldlabel}
                        </td>
                        <td width="30%" align=left class="dvtCellInfo">
                                <img src="{$IMAGE_PATH}skype.gif" align="absmiddle"></img><input{$disable} type="text" tabindex="{$vt_tab}" name="{$fldname}" style="border:1px solid #bababa;" size="27" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="{$fldvalue}">
                        </td>
		{elseif $uitype eq 86}
                        <td width="20%" class="dvtCellLabel" align=right>
                                {$required}{$fldlabel}
                        </td>
                        <td width="30%" align=left class="dvtCellInfo">
                                <img border="0" src="{$IMAGE_PATH}qq.gif"  align="absmiddle"><input{$disable} type="text" name="{$fldname}" style="border:1px solid #bababa;" size="27" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="{$fldvalue}">
                        </td>
		{elseif $uitype eq 87}
                        <td width="20%" class="dvtCellLabel" align=right>
                                {$required}{$fldlabel}
                        </td>
                        <td width="30%" align=left class="dvtCellInfo">
                                <img src="{$IMAGE_PATH}msn.jpg" align="absmiddle"></img><input{$disable} type="text" name="{$fldname}" style="border:1px solid #bababa;" size="27" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="{$fldvalue}">
                        </td>
		{elseif $uitype eq 88}
                        <td width="20%" class="dvtCellLabel" align=right>
                                {$required}{$fldlabel}
                        </td>
                        <td width="30%" align=left class="dvtCellInfo">
                                <img src="{$IMAGE_PATH}trade.jpg" align="absmiddle"><input{$disable} type="text" name="{$fldname}" style="border:1px solid #bababa;" size="27" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="{$fldvalue}">
                        </td>
		{elseif $uitype eq 89}
                        <td width="20%" class="dvtCellLabel" align=right>
                                {$required}{$fldlabel}
                        </td>
                        <td width="30%" align=left class="dvtCellInfo">
                                <img src="{$IMAGE_PATH}yahoo.gif" align="absmiddle"><input{$disable} type="text" name="{$fldname}" style="border:1px solid #bababa;" size="27" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="{$fldvalue}">
                        </td>

		{elseif $uitype eq 71 || $uitype eq 72}
			<td width="20%" class="dvtCellLabel" align=right>
				{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="{$fldname}" tabindex="{$vt_tab}" type="text" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"  value="{$fldvalue}">
			</td>

		{elseif $uitype eq 56}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			{if $fldname eq 'notime' && $ACTIVITY_MODE eq 'Events'}
				{if $fldvalue eq 1}
					<td width="30%" align=left class="dvtCellInfo">
						<input{$disable} name="{$fldname}" type="checkbox" tabindex="{$vt_tab}" onclick="toggleTime()" checked>
					</td>
				{else}
					<td width="30%" align=left class="dvtCellInfo">
						<input{$disable} name="{$fldname}" tabindex="{$vt_tab}" type="checkbox" onclick="toggleTime()" >
					</td>
				{/if}
			{else}
				{if $fldvalue eq 1}
					<td width="30%" align=left class="dvtCellInfo">
						<input{$disable} name="{$fldname}" type="checkbox" tabindex="{$vt_tab}" checked>
					</td>
				{else}
					<td width="30%" align=left class="dvtCellInfo">
						<input{$disable} name="{$fldname}" tabindex="{$vt_tab}" type="checkbox">
					</td>
				{/if}
			{/if}
		{elseif $uitype eq 23 || $uitype eq 5 || $uitype eq 6}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				{foreach key=date_value item=time_value from=$fldvalue}
					{assign var=date_val value="$date_value"}
					{assign var=time_val value="$time_value"}
				{/foreach}

				<input{$disable} name="{$fldname}" tabindex="{$vt_tab}" id="jscal_field_{$fldname}" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="{$date_val}">
				<img src="{$IMAGE_PATH}calendar.gif" id="jscal_trigger_{$fldname}" onclick="javascript:displayCalendar('jscal_field_{$fldname}',this)">

				{if $uitype eq 6}
					<input{$disable} name="time_start" tabindex="{$vt_tab}" style="border:1px solid #bababa;" size="5" maxlength="5" type="text" value="{$time_val}">
				{/if}
				{if $uitype eq 23}
					<input{$disable} name="time_end" tabindex="{$vt_tab}" style="border:1px solid #bababa;" size="5" maxlength="5" type="text" value="{$time_val}">
				{/if}

			</td>

		{elseif $uitype eq 63}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="{$fldname}" type="text" size="2" value="{$fldvalue}" tabindex="{$vt_tab}" >&nbsp;
				<select{$disable} name="duration_minutes" tabindex="{$vt_tab}" class="small">
					{foreach key=labelval item=selectval from=$secondvalue}
						<option value="{$labelval}" {$selectval}>{$labelval}</option>
					{/foreach}
				</select>

		{elseif $uitype eq 68 || $uitype eq 66 || $uitype eq 62}
			<td width="20%" class="dvtCellLabel" align=right>
				<select{$disable} class="small" name="parent_type" onChange='document.EditView.parent_name.value=""; document.EditView.parent_id.value=""'>
					{section name=combo loop=$fldlabel}
						<option value="{$fldlabel_combo[combo]}" {$fldlabel_sel[combo]}>{$fldlabel[combo]}</option>
					{/section}
				</select>
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">
				<input{$disable} name="parent_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}">
				&nbsp;<img src="{$IMAGE_PATH}select.gif" tabindex="{$vt_tab}" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module="+ document.EditView.parent_type.value +"&action=Popup&html=Popup_picker&form=HelpDeskEditView","test","width=700,height=602,resizable=1,scrollbars=1,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.parent_id.value=''; document.EditView.parent_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 357}
			<td width="20%" class="dvtCellLabel" align=right>To:&nbsp;</td>
			<td width="90%" colspan="3">
				<input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">
				<textarea{$disable} readonly name="parent_name" cols="70" rows="2">{$fldvalue}</textarea>&nbsp;
				<select{$disable} name="parent_type" class="small">
					{foreach key=labelval item=selectval from=$fldlabel}
						<option value="{$labelval}" {$selectval}>{$labelval}</option>
					{/foreach}
				</select>
				&nbsp;<img tabindex="{$vt_tab}" src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module="+ document.EditView.parent_type.value +"&action=Popup&html=Popup_picker&form=HelpDeskEditView","test","width=700,height=602,resizable=1,scrollbars=1,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.parent_id.value=''; document.EditView.parent_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		   <tr style="height:25px">
			<td width="20%" class="dvtCellLabel" align=right>CC:&nbsp;</td>	
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="ccmail" type="text" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"  value="">
			</td>
			<td width="20%" class="dvtCellLabel" align=right>BCC:&nbsp;</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="bccmail" type="text" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"  value="">
			</td>
		   </tr>

		{elseif $uitype eq 59}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">
				<input{$disable} name="product_name" readonly type="text" value="{$fldvalue}">&nbsp;<img tabindex="{$vt_tab}" src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&action=Popup&html=Popup_picker&form=HelpDeskEditView&popuptype=specific","test","width=700,height=602,resizable=1,scrollbars=1,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.product_id.value=''; document.EditView.product_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 55} 
			<td width="20%" class="dvtCellLabel" align=right>{$required}{$fldlabel}</td>
			<td width="30%" align=left class="dvtCellInfo">
				<select{$disable} name="salutationtype" class="small">
					{foreach item=arr from=$fldvalue}
						{foreach key=sel_value item=value from=$arr}
							<option value="{$sel_value}" {$value}>{$sel_value}</option>
						{/foreach}
					{/foreach}
				</select>
				<input{$disable} type="text" name="{$fldname}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" value= "{$secondvalue}">
			</td>

		{elseif $uitype eq 22}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<textarea{$disable} name="{$fldname}" cols="30" tabindex="{$vt_tab}" rows="2">{$fldvalue}</textarea>
			</td>

		{elseif $uitype eq 69}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td colspan="3" width="30%" align=left class="dvtCellInfo">
				{if $MODULE eq 'Products'}
					<input{$disable} name="del_file_list" type="hidden" value="">
					<div id="files_list" style="border: 1px solid grey; width: 500px; padding: 5px; background: rgb(255, 255, 255) none repeat scroll 0%; -moz-background-clip: initial; -moz-background-origin: initial; -moz-background-inline-policy: initial; font-size: x-small">Files Maximum 6
						<input{$disable} id="my_file_element" type="file" name="file_1" tabindex="{$vt_tab}" >
						{assign var=image_count value=0}
						{if $maindata[3].0.name neq ''}
						   {foreach name=image_loop key=num item=image_details from=$maindata[3]}
							<div align="center">
								<img src="{$image_details.path}{$image_details.encode_name}" height="50">&nbsp;&nbsp;[{$image_details.name}]<input{$disable} id="file_{$num}" value="Delete" type="button" class="crmbutton small delete" onclick='this.parentNode.parentNode.removeChild(this.parentNode);delRowEmt("{$image_details.name}")'>
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
					<input{$disable} name="{$fldname}"  type="file" value="{$maindata[3].0.name}" tabindex="{$vt_tab}" />
					<input{$disable} type="hidden" name="id" value=""/>
					{ if $maindata[3].0.name != "" }
						
				<div id="replaceimage">[{$maindata[3].0.name}] <a href="javascript:;" onClick="delimage({$ID})">Del</a></div>
					{/if}
					
				{/if}
			</td>

		{elseif $uitype eq 61}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td colspan="3" width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="{$fldname}"  type="file" value="{$secondvalue}" tabindex="{$vt_tab}" />
				<input{$disable} type="hidden" name="id" value=""/>{$fldvalue}
			</td>
		{elseif $uitype eq 156}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
				{if $fldvalue eq 'on'}
					<td width="30%" align=left class="dvtCellInfo">
						{if ($secondvalue eq 1 && $CURRENT_USERID != $smarty.request.record) || ($MODE == 'create')}
							<input{$disable} name="{$fldname}" tabindex="{$vt_tab}" type="checkbox" checked>
						{else}
							<input{$disable} name="{$fldname}" type="hidden" value="on">
							<input{$disable} name="{$fldname}" disabled tabindex="{$vt_tab}" type="checkbox" checked>
						{/if}	
					</td>
				{else}
					<td width="30%" align=left class="dvtCellInfo">
						{if ($secondvalue eq 1 && $CURRENT_USERID != $smarty.request.record) || ($MODE == 'create')}
							<input{$disable} name="{$fldname}" tabindex="{$vt_tab}" type="checkbox">
						{else}
							<input{$disable} name="{$fldname}" disabled tabindex="{$vt_tab}" type="checkbox">
						{/if}	
					</td>
				{/if}
		{elseif $uitype eq 98}<!-- Role Selection Popup -->		
			<td width="20%" class="dvtCellLabel" align=right>
			        {$required}
				{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			{if $thirdvalue eq 1}
				<input{$disable} name="role_name" id="role_name" readonly class="txtBox" tabindex="{$vt_tab}" value="{$secondvalue}" type="text">&nbsp;
				<a href="javascript:openPopup();"><img src="{$IMAGE_PATH}select.gif" align="absmiddle" border="0"></a>
			{else}	
				<input{$disable} name="role_name" id="role_name" tabindex="{$vt_tab}" class="txtBox" readonly value="{$secondvalue}" type="text">&nbsp;
			{/if}	
			<input{$disable} name="user_role" id="user_role" value="{$fldvalue}" type="hidden">
			</td>
		{elseif $uitype eq 104}<!-- Mandatory Email Fields -->			
			 <td width=20% class="dvtCellLabel" align=right>
			 {$required}
			 {$fldlabel}
			 </td>
    	     <td width=30% align=left class="dvtCellInfo"><input{$disable} type="text" name="{$fldname}" id ="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"></td>
			{elseif $uitype eq 115}<!-- for Status field Disabled for nonadmin -->
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			   {if $secondvalue eq 1}
			   	<select{$disable} name="{$fldname}" tabindex="{$vt_tab}" class="small">
			   {else}
			   	<select{$disable} disabled name="{$fldname}" class="small">
			   {/if} 
				{foreach item=arr from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						<option value="{$sel_value}" {$value}>{$sel_value}</option>
					{/foreach}
				{/foreach}
			   </select>
			</td>
			{elseif $uitype eq 105}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
					<input{$disable} name="{$fldname}"  type="file" value="{$maindata[3].0.name}" tabindex="{$vt_tab}" />
					<input{$disable} type="hidden" name="id" value=""/>
					{$maindata[3].0.name}
			</td>
			{elseif $uitype eq 103}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" colspan="3" align=left class="dvtCellInfo">
				<input{$disable} type="text" name="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
			</td>	
			{elseif $uitype eq 101}<!-- for reportsto field USERS POPUP -->
				<td width="20%" class="dvtCellLabel" align=right>
			       {$required}{$fldlabel}
	            </td>
				<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} readonly name='reports_to_name' class="small" type="text" value='{$fldvalue}' tabindex="{$vt_tab}" ><input{$disable} name='reports_to_id' type="hidden" value='{$secondvalue}'>&nbsp;<input{$disable} title="Change [Alt+C]" accessKey="C" type="button" class="small" value='{$UMOD.LBL_CHANGE}' name=btn1 LANGUAGE=javascript onclick='return window.open("index.php?module=Users&action=Popup&form=UsersEditView&form_submit=false","test","width=640,height=522,resizable=0,scrollbars=0");'>
	            </td>
			{elseif $uitype eq 116}<!-- for currency in users details-->	
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			   {if $secondvalue eq 1}
			   	<select{$disable} name="{$fldname}" tabindex="{$vt_tab}" class="small">
			   {else}
			   	<select{$disable} disabled name="{$fldname}" tabindex="{$vt_tab}" class="small">
			   {/if} 

				{foreach item=arr key=uivalueid from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						<option value="{$uivalueid}" {$value}>{$sel_value}</option>
					{/foreach}
				{/foreach}
			   </select>
			</td>
			{elseif $uitype eq 106}
			<td width=20% class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width=30% align=left class="dvtCellInfo">
				{if $MODE eq 'edit'}
				<input{$disable} type="text" readonly name="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				{else}
				<input{$disable} type="text" name="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				{/if}
			</td>
			{elseif $uitype eq 99}
				{if $MODE eq 'create'}
				<td width=20% class="dvtCellLabel" align=right>
					{$required}{$fldlabel}
				</td>
				<td width=30% align=left class="dvtCellInfo">
					<input{$disable} type="password" name="{$fldname}" tabindex="{$vt_tab}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				</td>
				{/if}
		{elseif $uitype eq 30}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td colspan="3" width="30%" align=left class="dvtCellInfo">
				{assign var=check value=$secondvalue[0]}
				{assign var=yes_val value=$secondvalue[1]}
				{assign var=no_val value=$secondvalue[2]}

				<input{$disable} type="radio" name="set_reminder" tabindex="{$vt_tab}" value="Yes" {$check}>&nbsp;{$yes_val}&nbsp;
				<input{$disable} type="radio" name="set_reminder" value="No">&nbsp;{$no_val}&nbsp;

				{foreach item=val_arr from=$fldvalue}
					{assign var=start value="$val_arr[0]"}
					{assign var=end value="$val_arr[1]"}
					{assign var=sendname value="$val_arr[2]"}
					{assign var=disp_text value="$val_arr[3]"}
					{assign var=sel_val value="$val_arr[4]"}
					<select{$disable} name="{$sendname}" class="small">
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
			</td>
		{elseif $uitype eq 83} <!-- Handle the Tax in Inventory -->
			{foreach item=tax key=count from=$TAX_DETAILS}
				{if $tax.check_value eq 1}
					{assign var=check_value value="checked"}
					{assign var=show_value value="visible"}
				{else}
					{assign var=check_value value=""}
					{assign var=show_value value="hidden"}
				{/if}
				<td align="right" class="dvtCellLabel" style="border:0px solid red;">
					{$tax.taxlabel} {$APP.COVERED_PERCENTAGE}
					<input{$disable} type="checkbox" name="{$tax.check_name}" id="{$tax.check_name}" class="small" onclick="fnshowHide(this,'{$tax.taxname}')" {$check_value}>
				</td>
				<td class="dvtCellInfo" align="left" style="border:0px solid red;">
					<input{$disable} type="text" class="detailedViewTextBox" name="{$tax.taxname}" id="{$tax.taxname}" value="{$tax.percentage}" style="visibility:{$show_value};" onBlur="fntaxValidation('{$tax.taxname}')">
				</td>
			   </tr>
			{/foreach}

			<td colspan="2" class="dvtCellInfo">&nbsp;</td>
		{elseif $uitype eq 1006}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="catalogname" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&action=PopupForCatalog&parenttab=Product","test_catalog","width=660,height=420,resizable=0,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.catalogid.value=''; document.EditView.catalogname.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 1009}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="vcontactname" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return openVContactPopup();' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.vcontactsid.value=''; document.EditView.vcontactname.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 1012}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="projectname" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Projects&action=Popup","test_project","width=660,height=420,resizable=0,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.projectsid.value=''; document.EditView.projectname.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 1013}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="faqcategoryname" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Faq&action=PopupForCategory&parenttab=Support","test_faqcategory","width=660,height=420,resizable=0,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.faqcategoryid.value=''; document.EditView.faqcategoryname.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 1011}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="projecttemplatename" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Projecttemplates&action=Popup","test_projecttemplate","width=660,height=420,resizable=0,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.projecttemplatesid.value=''; document.EditView.projecttemplatename.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 1020}
			<td width=20% class="dvtCellLabel" align=right>{$required}{$fldlabel}</td>
			<td width=30% align=left class="dvtCellInfo">
           
             <input{$disable} type="hidden" tabindex="{$vt_tab}" name="{$fldname}" id ="{$fldname}" value="{$fldvalue}" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
             
             <input type="text" name="{$fldname}_name" id ="{$fldname}_name" value="{$secondvalue}" class="detailedViewTextBox" readonly="readonly" >
            <input type="image" src="themes/softed/images/select.gif"  onclick="SelectUser('{$fldname}');return false;"/>
           
            </td>    
         {elseif $uitype eq 1050}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				{foreach key=date_value item=time_value from=$fldvalue}
					{assign var=date_val value="$date_value"}
					{assign var=time_val value="$time_value"}
				{/foreach}

				<input{$disable} name="{$fldname}" tabindex="{$vt_tab}" id="f_date_{$fldname}" type="text" style="border:1px solid #bababa;" size="16" maxlength="15" value="{$date_val}">
				<img src="{$IMAGE_PATH}calendar2.gif" id="f_btn_{$fldname}" onclick="javascript:displayCalendar('f_date_{$fldname}',this,true)">
			</td>
		{/if}
	{/foreach}
   </tr>
{/foreach}
