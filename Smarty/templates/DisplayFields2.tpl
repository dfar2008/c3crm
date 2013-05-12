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
				<input{$disable} type="text" name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" value="{$fldvalue}" tabindex="{$vt_tab}" class="detailedViewTextBox upaccount">
			</td>
		{elseif $uitype eq 11 || $uitype eq 1 || $uitype eq 13 || $uitype eq 7 || $uitype eq 9}
			<td width=20% class="dvtCellLabel" align=right>{$required}{$fldlabel}</td>
			<td width=30% align=left class="dvtCellInfo"><input{$disable} type="text" tabindex="{$vt_tab}" name="{$fldname}" id ="{$fldname}" value="{$fldvalue}" class="detailedViewTextBox upaccount">
             
            </td>
		{elseif $uitype eq 10}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} readonly name="{$thirdvalue}" type="text" value="{$fldvalue}" class="upaccount"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}" class="upaccount">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick="return openUITenPopup('{$fourthvalue}');" align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.{$thirdvalue}.value=''; document.EditView.{$fldname}.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
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
				<textarea{$disable} class="detailedViewTextBox upaccount" tabindex="{$vt_tab}"    name="{$fldname}"   cols="90" rows="8" >{$fldvalue|escape}</textarea>
			</td>
		{elseif $uitype eq 21 || $uitype eq 24}
			<td width=20% class="dvtCellLabel" align=right>
				{$required}
				{$fldlabel}
			</td>
			<td width=30% align=left class="dvtCellInfo">
				<textarea{$disable} value="{$fldvalue}" name="{$fldname}" tabindex="{$vt_tab}" class="detailedViewTextBox upaccount" rows=2>{$fldvalue|escape}</textarea>
			</td>
		{elseif $uitype eq 15 || $uitype eq 16 || $uitype eq 111} <!-- uitype 111 added for noneditable existing picklist values - ahmed -->
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}
				{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			   <select{$disable} name="{$fldname}" tabindex="{$vt_tab}" class="small upaccount">
				{foreach item=arr from=$fldvalue}
					{foreach key=sel_value item=value from=$arr}
						<option value="{$sel_value}" {$value}>                                                
                                                        {$sel_value}
                                                </option>
					{/foreach}
				{/foreach}
			   </select>
			</td>
        {elseif $uitype eq 155} <!-- uitype 111 added for noneditable existing picklist values - ahmed -->
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}
				{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			   <select{$disable} name="{$fldname}" tabindex="{$vt_tab}" class="small upaccount">
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
			   <select{$disable} name="{$fldname}" id="{$fldname}" tabindex="{$vt_tab}" class="small upaccount" onchange="multifieldSelectChange('{$uitype}','{$secondvalue}','{$MODULE}',this);">
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
			   <select{$disable} MULTIPLE name="{$fldname}[]" size="4" style="width:160px;" tabindex="{$vt_tab}" class="small upaccount">
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
				<select{$disable} name="assigned_user_id" class="small upaccount">
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
				<select{$disable} name="{$fldname}" tabindex="{$vt_tab}" class="small upaccount">
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
					<select{$disable} name="assigned_user_id" class="small upaccount">
				{elseif $uitype eq 77}
					<select{$disable} name="assigned_user_id" tabindex="{$vt_tab}" class="small upaccount">
				{else}
					<select{$disable} name="{$fldname}" tabindex="{$vt_tab}" class="small upaccount">
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
            {if $MODULE eq 'Notes'}
            &nbsp;&nbsp;{$fldvalue}<input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}" class="upaccount">
            {else}
				<input{$disable} readonly name="account_name" class="detailedViewTextBox upaccount"  type="text" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}">
                <br>①直接查客户: <input style='border: 1px solid rgb(186, 186, 186);' id='account_search_val' name='account_search_val' type="text">&nbsp;<input type='button' value='查' onclick='SearchAccountVal();'>
                <br>②浏览选客户: <img tabindex="{$vt_tab}" src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype={$popuptype}&form=TasksEditView&form_submit=false","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.account_id.value=''; document.EditView.account_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
                {/if}
			</td>

		{elseif $uitype eq 50}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} readonly name="account_name" class="detailedViewTextBox upaccount"  type="text" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}" class="upaccount">
                <br>①直接查客户: <input style='border: 1px solid rgb(186, 186, 186);' id='account_search_val' name='account_search_val' type="text">&nbsp;<input type='button' value='查' onclick='SearchAccountVal();'>
                <br>②浏览选客户: <img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype=specific&form=TasksEditView&form_submit=false","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 73}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} readonly class="detailedViewTextBox upaccount" name="account_name" type="text" value="{$fldvalue}"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}" class="upaccount">&nbsp;
                <br>①直接查客户:<input style='border: 1px solid rgb(186, 186, 186);' id='account_search_val' name='account_search_val' type="text">&nbsp;<input type='button' value='查' onclick='SearchAccountVal();'>
                <br>②浏览选客户:<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype=specific_account_address&form=TasksEditView&form_submit=false","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		{elseif $uitype eq 57}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			
				<td width="30%" align=left class="dvtCellInfo">
                  <select{$disable} name="{$fldname}"  id="{$fldname}" class="upaccount">
                      {$fldvalue}
                  </select>
                </td>


		{elseif $uitype eq 80}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="salesorder_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}" class="upaccount"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}" class="upaccount">&nbsp;<img src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return openSOPopup()' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  tabindex="{$vt_tab}" src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.salesorder_id.value=''; document.EditView.salesorder_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 76}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="potential_name" readonly type="text" style="border:1px solid #bababa;" value="{$fldvalue}" class="upaccount"><input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}" class="upaccount">&nbsp;<img tabindex="{$vt_tab}" src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return openPotentialPopup();' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.potential_id.value=''; document.EditView.potential_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 17}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				&nbsp;&nbsp;
				<input{$disable} type="text" tabindex="{$vt_tab}" name="{$fldname}" style="border:1px solid #bababa;" size="27" class="upaccount"   value="{$fldvalue}">
			</td>

		{elseif $uitype eq 85}
                        <td width="20%" class="dvtCellLabel" align=right>
                                {$required}{$fldlabel}
                        </td>
                        <td width="30%" align=left class="dvtCellInfo">
                                <img src="{$IMAGE_PATH}skype.gif" align="absmiddle"></img><input{$disable} type="text" tabindex="{$vt_tab}" name="{$fldname}" style="border:1px solid #bababa;" size="27"     value="{$fldvalue}" class="upaccount">
                        </td>
		{elseif $uitype eq 86}
                        <td width="20%" class="dvtCellLabel" align=right>
                                {$required}{$fldlabel}
                        </td>
                        <td width="30%" align=left class="dvtCellInfo">
                                <img border="0" src="{$IMAGE_PATH}qq.gif"  align="absmiddle"><input{$disable} type="text" name="{$fldname}" style="border:1px solid #bababa;" size="27"     value="{$fldvalue}" class="upaccount">
                        </td>
		{elseif $uitype eq 87}
                        <td width="20%" class="dvtCellLabel" align=right>
                                {$required}{$fldlabel}
                        </td>
                        <td width="30%" align=left class="dvtCellInfo">
                                <img src="{$IMAGE_PATH}msn.jpg" align="absmiddle"></img><input{$disable} type="text" name="{$fldname}" style="border:1px solid #bababa;" size="27"     value="{$fldvalue}" class="upaccount">
                        </td>
		{elseif $uitype eq 88}
                        <td width="20%" class="dvtCellLabel" align=right>
                                {$required}{$fldlabel}
                        </td>
                        <td width="30%" align=left class="dvtCellInfo">
                                <img src="{$IMAGE_PATH}trade.jpg" align="absmiddle"><input{$disable} type="text" name="{$fldname}" style="border:1px solid #bababa;" size="27"     value="{$fldvalue}" class="upaccount">
                        </td>
		{elseif $uitype eq 89}
                        <td width="20%" class="dvtCellLabel" align=right>
                                {$required}{$fldlabel}
                        </td>
                        <td width="30%" align=left class="dvtCellInfo">
                                <img src="{$IMAGE_PATH}yahoo.gif" align="absmiddle"><input{$disable} type="text" name="{$fldname}" style="border:1px solid #bababa;" size="27"     value="{$fldvalue}" class="upaccount">
                        </td>

		{elseif $uitype eq 71 || $uitype eq 72}
			<td width="20%" class="dvtCellLabel" align=right>
				{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="{$fldname}" tabindex="{$vt_tab}" type="text" class="detailedViewTextBox upaccount"value="{$fldvalue}" >
			</td>


		{elseif $uitype eq 23 || $uitype eq 5 || $uitype eq 6}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				
				<input{$disable} name="{$fldname}" tabindex="{$vt_tab}" id="jscal_field_{$fldname}" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="{$fldvalue}" class="upaccount">
				<img src="{$IMAGE_PATH}calendar.gif" id="jscal_trigger_{$fldname}" onclick="javascript:displayCalendar('jscal_field_{$fldname}',this)">
				
			</td>

		{elseif $uitype eq 63}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="{$fldname}" type="text" size="2" value="{$fldvalue}" tabindex="{$vt_tab}" class="upaccount">&nbsp;
				<select{$disable} name="duration_minutes" tabindex="{$vt_tab}" class="small upaccount">
					{foreach key=labelval item=selectval from=$secondvalue}
						<option value="{$labelval}" {$selectval}>{$labelval}</option>
					{/foreach}
				</select>





		{elseif $uitype eq 59}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="{$fldname}" type="hidden" value="{$secondvalue}"  class="upaccount">
				<input{$disable} name="product_name" readonly type="text" value="{$fldvalue}"  class="upaccount">&nbsp;<img tabindex="{$vt_tab}" src="{$IMAGE_PATH}select.gif" alt="{$APP.LBL_SELECT}" title="{$APP.LBL_SELECT}" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&action=Popup&html=Popup_picker&form=HelpDeskEditView&popuptype=specific","test","width=700,height=602,resizable=1,scrollbars=1,top=150,left=200");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img{$disable}  src="{$IMAGE_PATH}clear_field.gif" alt="{$APP.LBL_CLEAR_BUTTON_LABEL}" title="{$APP.LBL_CLEAR_BUTTON_LABEL}" LANGUAGE=javascript onClick="document.EditView.product_id.value=''; document.EditView.product_name.value=''; return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		{elseif $uitype eq 55} 
			<td width="20%" class="dvtCellLabel" align=right>{$required}{$fldlabel}</td>
			<td width="30%" align=left class="dvtCellInfo">
				<select{$disable} name="salutationtype" class="small upaccount ">
					{foreach item=arr from=$fldvalue}
						{foreach key=sel_value item=value from=$arr}
							<option value="{$sel_value}" {$value}>{$sel_value}</option>
						{/foreach}
					{/foreach}
				</select>
				<input{$disable} type="text" name="{$fldname}" tabindex="{$vt_tab}" class="detailedViewTextBox upaccount"value= "{$secondvalue}">
			</td>

		{elseif $uitype eq 22}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
				<textarea{$disable} name="{$fldname}" cols="30" tabindex="{$vt_tab}" rows="2" class="upaccount">{$fldvalue}</textarea>
			</td>

		{elseif $uitype eq 61}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td colspan="3" width="30%" align=left class="dvtCellInfo">
				<input{$disable} name="{$fldname}"  type="file" value="{$secondvalue}" tabindex="{$vt_tab}" class="upaccount" />
				<input{$disable} type="hidden" name="id" value="" class="upaccount"/>{$fldvalue}
			</td>
		{elseif $uitype eq 156}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
				{if $fldvalue eq 'on'}
					<td width="30%" align=left class="dvtCellInfo">
						{if ($secondvalue eq 1 && $CURRENT_USERID != $smarty.request.record) || ($MODE == 'create')}
							<input{$disable} name="{$fldname}" tabindex="{$vt_tab}" type="checkbox" checked class="upaccount">
						{else}
							<input{$disable} name="{$fldname}" type="hidden" value="on" class="upaccount">
							<input{$disable} name="{$fldname}" disabled tabindex="{$vt_tab}" type="checkbox" checked class="upaccount"> 
						{/if}	
					</td>
				{else}
					<td width="30%" align=left class="dvtCellInfo">
						{if ($secondvalue eq 1 && $CURRENT_USERID != $smarty.request.record) || ($MODE == 'create')}
							<input{$disable} name="{$fldname}" tabindex="{$vt_tab}" type="checkbox" class="upaccount">
						{else}
							<input{$disable} name="{$fldname}" disabled tabindex="{$vt_tab}" type="checkbox" class="upaccount">
						{/if}	
					</td>
				{/if}

		{elseif $uitype eq 104}<!-- Mandatory Email Fields -->			
			 <td width=20% class="dvtCellLabel" align=right>
			 {$required}
			 {$fldlabel}
			 </td>
    	     <td width=30% align=left class="dvtCellInfo"><input{$disable} type="text" name="{$fldname}" id ="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class="detailedViewTextBox upaccount"></td>
			{elseif $uitype eq 115}<!-- for Status field Disabled for nonadmin -->
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" align=left class="dvtCellInfo">
			   {if $secondvalue eq 1}
			   	<select{$disable} name="{$fldname}" tabindex="{$vt_tab}" class="small upaccount">
			   {else}
			   	<select{$disable} disabled name="{$fldname}" class="small upaccount">
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
					<input{$disable} name="{$fldname}"  type="file" value="{$maindata[3].0.name}" tabindex="{$vt_tab}" class="upaccount"/>
					<input{$disable} type="hidden" name="id" value="" class="upaccount"/>
					{$maindata[3].0.name}
			</td>
			{elseif $uitype eq 103}
			<td width="20%" class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width="30%" colspan="3" align=left class="dvtCellInfo">
				<input{$disable} type="text" name="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class="detailedViewTextBox upaccount">
			</td>	
	

			{elseif $uitype eq 106}
			<td width=20% class="dvtCellLabel" align=right>
				{$required}{$fldlabel}
			</td>
			<td width=30% align=left class="dvtCellInfo">
				{if $MODE eq 'edit'}
				<input{$disable} type="text" readonly name="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class="detailedViewTextBox upaccount">
				{else}
				<input{$disable} type="text" name="{$fldname}" value="{$fldvalue}" tabindex="{$vt_tab}" class="detailedViewTextBox upaccount">
				{/if}
			</td>


		
		
		{/if}
	{/foreach}
   </tr>
{/foreach}
