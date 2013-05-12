<!--*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
-->
<script type="text/javascript" src="modules/CustomView/CustomView.js"></script>
<script language="javascript" type="text/javascript">
var typeofdata = new Array();
typeofdata['V'] = ['e','n','s','c','k'];
typeofdata['N'] = ['e','n','l','g','m','h'];
typeofdata['T'] = ['e','n','l','g','m','h'];
typeofdata['I'] = ['e','n','l','g','m','h'];
typeofdata['C'] = ['e','n'];
typeofdata['DT'] = ['e','n'];
typeofdata['D'] = ['e','n'];
var fLabels = new Array();
fLabels['e'] = alert_arr.EQUALS;
fLabels['n'] = alert_arr.NOT_EQUALS_TO;
fLabels['s'] = alert_arr.STARTS_WITH;
fLabels['c'] = alert_arr.CONTAINS;
fLabels['k'] = alert_arr.DOES_NOT_CONTAINS;
fLabels['l'] = alert_arr.LESS_THAN;
fLabels['g'] = alert_arr.GREATER_THAN;
fLabels['m'] = alert_arr.LESS_OR_EQUALS;
fLabels['h'] = alert_arr.GREATER_OR_EQUALS;
var noneLabel;
function goto_CustomAction(module)
{ldelim}
        document.location.href = "index.php?module="+module+"&action=CustomAction&record={$CUSTOMVIEWID}";
{rdelim}

function mandatoryCheck()
{ldelim}

        var mandatorycheck = false;
        var i,j;
        var manCheck = new Array({$MANDATORYCHECK});
        var showvalues = "{$SHOWVALUES}";
        if(manCheck)
        {ldelim}
                var isError = false;
                var errorMessage = "";
                if (trim(document.CustomView.viewName.value) == "") {ldelim}
                        isError = true;
                        errorMessage += "\n{$MOD.LBL_VIEW_NAME}";
                {rdelim}
                // Here we decide whether to submit the form.
                if (isError == true) {ldelim}
                        alert("{$MOD.Missing_required_fields}:" + errorMessage);
                        return false;
                {rdelim}
		
		for(i=1;i<=9;i++)
                {ldelim}
                        var columnvalue = document.getElementById("column"+i).value;
                        if(columnvalue != null)
                        {ldelim}
                                for(j=0;j<manCheck.length;j++)
                                {ldelim}
                                        if(columnvalue == manCheck[j])
                                        {ldelim}
                                                mandatorycheck = true;
                                        {rdelim}
                                {rdelim}
                                if(mandatorycheck == true)
                                {ldelim}
                                        return true;
                                {rdelim}else
                                {ldelim}
                                        mandatorycheck = false;
                                {rdelim}
                        {rdelim}
                {rdelim}
        {rdelim}
        if(mandatorycheck == false)
        {ldelim}
                alert(alert_arr.SELECT_REQUIRED_FIELD + "\n"+showvalues);
        {rdelim}
        
        return false;
{rdelim}
</script>
<form enctype="multipart/form-data" name="CustomView" method="POST" action="index.php" onsubmit="return mandatoryCheck();">
<input type="hidden" name="module" value="CustomView">
<input type="hidden" name="action" value="Save">
<input type="hidden" name="parenttab" value="{$CATEGORY}">
<input type="hidden" name="cvmodule" value="{$CVMODULE}">
<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
<input type="hidden" name="record" value="{$CUSTOMVIEWID}">
<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%" >
 <tbody><tr>
  <td class="showPanelBg" valign="top" width="100%">
  <div class="small" style="padding: 5px;">
<span class="lvtHeaderText"><a class="hdrLink" href="index.php?action=ListView&module={$MODULE}&parenttab={$CATEGORY}">{$APP.$MODULE}</a> &gt; {if $CUSTOMVIEWID eq ''}{$MOD.New_Custom_View}{else}编辑视图{/if}</span> <br>
<hr noshade="noshade" size="1">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="dvtContentSpace">
             <tbody><tr>
              <td align="left" valign="top">
<table width="100%"  border="0" cellspacing="0" cellpadding="5">
<tr>
		 <td colspan="4" class="detailedViewHeader"><strong>{$MOD.Details}</strong></td>
		</tr>
		<tr>
		<td colspan="4">
                <table width="100%"  border="0" cellspacing="0" cellpadding="5">
		<tr>
		 <td class="dvtCellInfo" align="right" width="10%"><span class="style1">*</span>{$MOD.LBL_VIEW_NAME} </td>
		 <td class="dvtCellInfo" width="25%" >
		  <input class="detailedViewTextBox" type="text" name='viewName' value="{$VIEWNAME}" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'"/>
		 </td>
		 <!-- <td class="dvtCellInfo" width="75%">
		  {if $CHECKED eq 'checked'}
		      <input type="hidden" name="setDefault" value="1" >
		  {else}
		     <input type="hidden" name="setDefault" value="0" >
		  {/if}
		  </td> -->
          <td class="dvtCellInfo" width="75%">
		  {if $MCHECKED eq 'checked'}
		      {$MOD.LBL_LIST_IN_METRICS}&nbsp;<input type="checkbox" name="setMetrics" value="1" checked/>
		  {else}
		      {$MOD.LBL_LIST_IN_METRICS}&nbsp;<input type="checkbox" name="setMetrics" value="0" />
		  {/if}
		 </td>
         	<!-- {$publichtml} -->
		 
		</tr>
		</table>
		</td></tr>
        
		<tr>
		 <td colspan="4" class="detailedViewHeader">
		  <b>{$MOD.LBL_STEP_2_TITLE} </b>
		 </td>
         
		</tr>
		<tr class="dvtCellLabel" colspan="4">
        <table class="dvtCellLabel" width="100%" style="padding-top:10px;padding-bottom:20px;">
         <tbody>
           <tr>
                <td><select name="column1" id="column1" onChange="checkDuplicate();">
	                <option value="">{$MOD.LBL_NONE}</option>
			{foreach item=filteroption key=label from=$CHOOSECOLUMN1}
				<optgroup label="{$label}" class=\"select\" style=\"border:none\">
					{foreach item=text from=$filteroption}
		   		         <option {$text.selected} value={$text.value}>{$text.text}</option>
                    {/foreach}
			{/foreach}
          	        {$CHOOSECOLUMN1}
	              </select>
                  </td>
		   <td>
		   <select name="column2" id="column2" onChange="checkDuplicate();">
                        <option value="">{$MOD.LBL_NONE}</option>
                        {foreach item=filteroption key=label from=$CHOOSECOLUMN2}
                                <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                                {foreach item=text from=$filteroption}
                                     <option {$text.selected} value={$text.value}>{$text.text}</option>
                                {/foreach}
                        {/foreach}
                        {$CHOOSECOLUMN2}
                      </select></td>
		   <td><select name="column3" id="column3" onChange="checkDuplicate();">
                        <option value="">{$MOD.LBL_NONE}</option>
                        {foreach item=filteroption key=label from=$CHOOSECOLUMN3}
                                <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                                {foreach item=text from=$filteroption}
                                     <option {$text.selected} value={$text.value}>{$text.text}</option>
                                {/foreach}
                        {/foreach}
                        {$CHOOSECOLUMN3}
                      </select>
                      </td>
		   <td>
                      <select name="column4" id="column4" onChange="checkDuplicate();">
                        <option value="">{$MOD.LBL_NONE}</option>
                        {foreach item=filteroption key=label from=$CHOOSECOLUMN4}
                                <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                                {foreach item=text from=$filteroption}
                                     <option {$text.selected} value={$text.value}>{$text.text}</option>
                                {/foreach}
                        {/foreach}
                        {$CHOOSECOLUMN4}
                      </select></td>
           	
		   <td><select name="column5" id="column5" onChange="checkDuplicate();">
                        <option value="">{$MOD.LBL_NONE}</option>
                        {foreach item=filteroption key=label from=$CHOOSECOLUMN5}
                                <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                                {foreach item=text from=$filteroption}
                                     <option {$text.selected} value={$text.value}>{$text.text}</option>
                                {/foreach}
                        {/foreach}
                        {$CHOOSECOLUMN5}
                      </select>
                      </td>
              </tr>
              <tr>
		   <td>
                      <select name="column6" id="column6" onChange="checkDuplicate();">
                        <option value="">{$MOD.LBL_NONE}</option>
                        {foreach item=filteroption key=label from=$CHOOSECOLUMN6}
                                <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                                {foreach item=text from=$filteroption}
                                     <option {$text.selected} value={$text.value}>{$text.text}</option>
                                {/foreach}
                        {/foreach}
                        {$CHOOSECOLUMN6}
                      </select></td>
                   <td><select name="column7" id="column7" onChange="checkDuplicate();">
                        <option value="">{$MOD.LBL_NONE}</option>
                        {foreach item=filteroption key=label from=$CHOOSECOLUMN7}
                                <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                                {foreach item=text from=$filteroption}
                                     <option {$text.selected} value={$text.value}>{$text.text}</option>
                                {/foreach}
                        {/foreach}
                        {$CHOOSECOLUMN7}
                      </select>
                      </td>
		   <td><select name="column8" id="column8" onChange="checkDuplicate();">
                        <option value="">{$MOD.LBL_NONE}</option>
                        {foreach item=filteroption key=label from=$CHOOSECOLUMN8}
                                <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                                {foreach item=text from=$filteroption}
                                     <option {$text.selected} value={$text.value}>{$text.text}</option>
                                {/foreach}
                        {/foreach}
                        {$CHOOSECOLUMN8}
			</select></td>
		   <td><select name="column9" id="column9" onChange="checkDuplicate();">
                        <option value="">{$MOD.LBL_NONE}</option>
                        {foreach item=filteroption key=label from=$CHOOSECOLUMN9}
                                <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                                {foreach item=text from=$filteroption}
                                     <option {$text.selected} value={$text.value}>{$text.text}</option>
                                {/foreach}
                        {/foreach}
                        {$CHOOSECOLUMN9}
                        </select></td>
           </tr>
         </tbody>
        </table>
		  
		</tr>	
		{*section name=SelectColumn start=1 loop=4 step=1}
		<tr class="{cycle values="dvtCellLabel,dvtCellInfo"}">
		 {section name=Column start=1 loop=5 step=1}
		<td align="center">
		{math equation="(x-1)*4+ y" x=$smarty.section.SelectColumn.index y=$smarty.section.Column.index}.&nbsp;	
		  <select id="column{math equation="(x-1)*4+ y" x=$smarty.section.SelectColumn.index y=$smarty.section.Column.index}" name ="column{math equation="(x-1)*4+ y" x=$smarty.section.SelectColumn.index y=$smarty.section.Column.index}" class="detailedViewTextBox">
		   <option value="">{$MOD.LBL_NONE}</option>
		   {foreach item=filteroption key=label from={$CHOOSECOLUMN|cat: {math equation="(x-1)*4+ y" x=$smarty.section.SelectColumn.index y=$smarty.section.Column.index}}}
		    <optgroup label="{$label}" class=\"select\" style=\"border:none\">
		    {foreach item=text from=$filteroption}
		     <option {$text.selected} value={$text.value}>{$text.text}</option>
		    {/foreach}
		   {/foreach}
		  </select>
		 </td>
		 {/section}
	        </tr>
		{/section*}
          <tr>
        <td >&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
		<tr>
		 <td colspan="4" class="detailedViewHeader">
		  <b>选择列表中汇总字段</b><br />		  
		 </td>
		</tr>
		<tr class="dvtCellInfo" style="height:40px;">
		   <td colspan=4>
		        
		        <select name="collectcolumn" id="collectcolumn" onChange="">
                        <option value="">{$MOD.LBL_NONE}</option>
                        {foreach item=filteroption key=label from=$CHOOSECOLLECTCOLUMN}
                                <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                                {foreach item=text from=$filteroption}
                                     <option {$text.selected} value={$text.value}>{$text.text}</option>
                                {/foreach}
                        {/foreach}
                        {$CHOOSECOLLECTCOLUMN}
                      </select>
                  &nbsp;&nbsp;&nbsp;&nbsp;( 列表中将根据所选汇总字段进行自动汇总 )    
                      </td>
		</tr>
        <tr>
        <td >&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
		<tr>
		 <td colspan="4" class="detailedViewHeader">
		  <b>设置过滤条件</b>
		 </td>
		</tr>
		<tr><td colspan="4">
		<table align="left" border="0" cellpadding="0" cellspacing="0" width="95%">
		<tbody><tr>
		 <td>
		  <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%">
		   <tbody><tr>
		    <td class="dvtTabCache" style="width: 10px;" nowrap>&nbsp;</td>
		    <td style="width: 100px;" nowrap class="dvtSelectedCell" id="pi" onclick="fnLoadCvValues('pi','mi','mnuTab','mnuTab2')">
		     <b>{$MOD.LBL_STEP_3_TITLE}</b>
		    </td>
		    <td class="dvtUnSelectedCell" style="width: 100px;" align="center" nowrap id="mi" onclick="fnLoadCvValues('mi','pi','mnuTab2','mnuTab')">
		     <b>{$MOD.LBL_STEP_4_TITLE}</b>
		    </td>
		    <td class="dvtTabCache" nowrap style="width:55%;">&nbsp;</td>
		   </tr>
		   </tbody>
	          </table>
		 </td>
	        </tr>
		<tr>
		 <td align="left" valign="top">
		  <div id="mnuTab">
		     <table width="100%" cellspacing="0" cellpadding="5" class="dvtContentSpace">
		     <tr><td class="dvtCellInfo">{$MOD.LBL_AF_HDR1}<br />
			1)当时间段为自定义时，开始日期和结束日期将为指定的日期，例如2010-10-10。<br />
			2)当时间段为非自定义时，开始日期和结束日期将为动态的日期，例如选择本周时，开始日期和结束日期将分别为本周的周一和周末，而不是固定的日期。
		       </td></tr>
                      <tr><td>
			<table width="75%" border="0" cellpadding="5" cellspacing="0" align="left">
			  <tr><td colspan="2" class="detailedViewHeader"><b>{$MOD.Simple_Time_Filter}</b></td></tr>
			  <tr>
			     <td width="50%" align="right" class="dvtCellLabel">{$MOD.LBL_Select_a_Column} :</td>
			     <td width="50%" class="dvtCellInfo">
				<select name="stdDateFilterField" class="select">
				{foreach item=stdfilter from=$STDFILTERCOLUMNS}
					<option {$stdfilter.selected} value={$stdfilter.value}>{$stdfilter.text}</option>	
				{/foreach}
                                </select>
			  </tr>
			  <tr>
			     <td align="right" class="dvtCellLabel">{$MOD.Select_Duration} :</td>
			     <td class="dvtCellInfo">
			        <select name="stdDateFilter" class="select" onchange='showDateRange(this.options[this.selectedIndex].value )'>
				{foreach item=duration from=$STDFILTERCRITERIA}
					<option {$duration.selected} value={$duration.value}>{$duration.text}</option>
				{/foreach}
				</select>
			     </td>
			  </tr>
			  <tr>
			     <td align="right" class="dvtCellLabel">{$MOD.Start_Date} :</td>
			     <td width="25%" align=left class="dvtCellInfo">
			     <input name="startdate" id="jscal_field_date_start" type="text" size="10" class="textField" value="{$STARTDATE}">
			     <img src="{$IMAGE_PATH}calendar.gif" id="jscal_trigger_date_start" onclick="javascript:displayCalendar('jscal_field_date_start',this)">
			     </td>
	            	  </tr>
			  <tr>
			     <td align="right" class="dvtCellLabel">{$MOD.End_Date} :</td> 
  			     <td width="25%" align=left class="dvtCellInfo">
			     <input name="enddate" id="jscal_field_date_end" type="text" size="10" class="textField" value="{$ENDDATE}">
			     <img src="{$IMAGE_PATH}calendar.gif" id="jscal_trigger_date_end" onclick="javascript:displayCalendar('jscal_field_date_end',this)">
			     </td>
			  </tr>
			</table>
		      </td></tr>
		      <tr><td>&nbsp;</td></tr>
	            </table>
		   </div>
		   <div id="mnuTab2">
		      <table width="100%" cellspacing="0" cellpadding="5" class="dvtContentSpace">
		       <tr><td class="dvtCellInfo">{$MOD.LBL_AF_HDR1}<br />
			1){$MOD.LBL_AF_HDR2}<br />
			2){$MOD.LBL_AF_HDR3}
		       </td></tr>
		       <tr><td>
			<table width="75%" border="0" cellpadding="5" cellspacing="0" align="left">
			  <tr><td class="detailedViewHeader"><b>{$MOD.LBL_RULE}</b></td></tr>
			  
			  <tr class="dvtCellLabel">
			  <td><select name="fcol1" id="fcol1" onchange="updatefOptions(this, 'fop1');">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=filteroption key=label from=$BLOCK1}
				<optgroup label="{$label}" class=\"select\" style=\"border:none\">
				{foreach item=text from=$filteroption}
				  <option {$text.selected} value={$text.value}>{$text.text}</option>
				{/foreach}
			      {/foreach}
			      </select> &nbsp; <select name="fop1" id="fop1">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=criteria from=$FOPTION1}
				<option {$criteria.selected} value={$criteria.value}>{$criteria.text}</option>
			      {/foreach}
			      </select>&nbsp; <input name="fval1" id="fval1" type="text" size=30 maxlength=80 value="{$VALUE1}">
			    &nbsp;{$MOD.LBL_AND}</td>
			</tr>
			<tr class="dvtCellInfo">
			  <td><select name="fcol2" id="fcol2" onchange="updatefOptions(this, 'fop2');">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=filteroption key=label from=$BLOCK2}
				<optgroup label="{$label}" class=\"select\" style=\"border:none\">
				{foreach item=text from=$filteroption}
				  <option {$text.selected} value={$text.value}>{$text.text}</option>
				{/foreach}
			      {/foreach}
			      </select> &nbsp; <select name="fop2" id="fop2">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=criteria from=$FOPTION2}
				<option {$criteria.selected} value={$criteria.value}>{$criteria.text}</option>
			      {/foreach}
			      </select>&nbsp; <input name="fval2" id="fval2" type="text" size=30 maxlength=80 value="{$VALUE2}">
			    &nbsp;{$MOD.LBL_AND}</td>
			</tr>
			<tr class="dvtCellLabel">
			  <td><select name="fcol3" id="fcol3" onchange="updatefOptions(this, 'fop3');">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=filteroption key=label from=$BLOCK3}
				<optgroup label="{$label}" class=\"select\" style=\"border:none\">
				{foreach item=text from=$filteroption}
				  <option {$text.selected} value={$text.value}>{$text.text}</option>
				{/foreach}
			      {/foreach}
			      </select> &nbsp; <select name="fop3" id="fop3">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=criteria from=$FOPTION3}
				<option {$criteria.selected} value={$criteria.value}>{$criteria.text}</option>
			      {/foreach}
			      </select>&nbsp; <input name="fval3" id="fval3" type="text" size=30 maxlength=80 value="{$VALUE3}">
			    &nbsp;{$MOD.LBL_AND}</td>
			</tr>
			<tr class="dvtCellInfo">
			  <td><select name="fcol4" id="fcol4" onchange="updatefOptions(this, 'fop4');">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=filteroption key=label from=$BLOCK4}
				<optgroup label="{$label}" class=\"select\" style=\"border:none\">
				{foreach item=text from=$filteroption}
				  <option {$text.selected} value={$text.value}>{$text.text}</option>
				{/foreach}
			      {/foreach}
			      </select> &nbsp; <select name="fop4" id="fop4">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=criteria from=$FOPTION4}
				<option {$criteria.selected} value={$criteria.value}>{$criteria.text}</option>
			      {/foreach}
			      </select>&nbsp; <input name="fval4" id="fval4" type="text" size=30 maxlength=80 value="{$VALUE4}">
			    &nbsp;{$MOD.LBL_AND}</td>
			</tr>
			<tr class="dvtCellLabel">
			  <td><select name="fcol5" id="fcol5" onchange="updatefOptions(this, 'fop5');">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=filteroption key=label from=$BLOCK5}
				<optgroup label="{$label}" class=\"select\" style=\"border:none\">
				{foreach item=text from=$filteroption}
				  <option {$text.selected} value={$text.value}>{$text.text}</option>
				{/foreach}
			      {/foreach}
			      </select> &nbsp; <select name="fop5" id="fop5">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=criteria from=$FOPTION5}
				<option {$criteria.selected} value={$criteria.value}>{$criteria.text}</option>
			      {/foreach}
			      </select>&nbsp; <input name="fval5" id="fval5" type="text" size=30 maxlength=80 value="{$VALUE5}">
			    &nbsp;</td>
			</tr>

			  {*section name=advancedFilter start=1 loop=6 step=1}
			  <tr class="{cycle values="dvtCellInfo,dvtCellLabel"}">
			    <td align="left" width="33%">
			      <select name="fcol{$smarty.section.advancedFilter.index}" id="fcol{$smarty.section.advancedFilter.index}" onchange="updatefOptions(this, 'fop{$smarty.section.advancedFilter.index}'); class="detailedViewTextBox">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=filteroption key=label from=$BLOCK}
				<optgroup label="{$label}" class=\"select\" style=\"border:none\">
				{foreach item=text from=$filteroption}
				  <option {$text.selected} value={$text.value}>{$text.text}</option>
				{/foreach}
			      {/foreach}
			      </select>
			    </td>
			    <td align="left" width="33%">
			      <select name="fcol{$smarty.section.advancedFilter.index}" id="fcol{$smarty.section.advancedFilter.index}" class="detailedViewTextBox">
			      <option value="">{$MOD.LBL_NONE}</option>
			      {foreach item=criteria from=$FOPTION}
				<option {$criteria.selected} value={$criteria.value}>{$criteria.text}</option>
			      {/foreach}
			      </select>
			    </td>
			    <td width="34%" nowrap><input name="txt" value="" class="detailedViewTextBox" type="text"  onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'"/>&nbsp;And</td>
			  </tr>
			  {/section*}
			  </table>
	  </td></tr></table></div></td></tr></table>
	  </td></tr>
	  <tr><td colspan="4" style="padding: 5px;">
		<div align="center">
		  <input title="{$APP.LBL_SAVE_BUTTON_LABEL} [Alt+S]" accesskey="S" class="crmbutton small save"  name="button2" value="{$APP.LBL_SAVE_BUTTON_LABEL}" style="width: 70px;" type="submit" onClick="return checkDuplicate();"/>
		  <input title="{$APP.LBL_CANCEL_BUTTON_LABEL} [Alt+X]" accesskey="X" class="crmbutton small cancel" name="button2" onclick='goback()' value="{$APP.LBL_CANCEL_BUTTON_LABEL}" style="width: 70px;" type="button" />
		</div>
	  </td></tr>
	  <tr><td colspan="4">&nbsp;</td></tr>
	  </table>
	 </td></tr>
       <tr><td>&nbsp;</td></tr>
     </table>
   </div>
  </td>
  </tr>
  </table>
</form>
{$STDFILTER_JAVASCRIPT}
{$JAVASCRIPT}
<!-- to show the mandatory fields while creating new customview -->
<script language="javascript" type="text/javascript">
var k;
var colOpts;
var manCheck = new Array({$MANDATORYCHECK});
{literal}
/* --xiaoyang 2012-09-18
if(document.CustomView.record.value == '')
{
  for(k=0;k<manCheck.length;k++)
  {
      selname = "column"+(k+1);
      colOpts = document.getElementById(selname).options;
      for (l=0;l<colOpts.length;l++)
      {
        if(colOpts[l].value == manCheck[k])
        {
          colOpts[l].selected = true;
        }
      }
  }
}*/
function checkDuplicate()
{
	var cvselect_array = new Array('column1','column2','column3','column4','column5','column6','column7','column8','column9')
		for(var loop=0;loop < cvselect_array.length-1;loop++)
		{
			selected_cv_columnvalue = $(cvselect_array[loop]).options[$(cvselect_array[loop]).selectedIndex].value;
			if(selected_cv_columnvalue != '')
			{	
				for(var iloop=0;iloop < cvselect_array.length;iloop++)
				{
					if(iloop == loop)
						iloop++;
					selected_cv_icolumnvalue = $(cvselect_array[iloop]).options[$(cvselect_array[iloop]).selectedIndex].value;	
					if(selected_cv_columnvalue == selected_cv_icolumnvalue)
					{
						alert(alert_arr.FIELD_REPEATED);
						$(cvselect_array[iloop]).selectedIndex = 0;
						return false;
					}

				}
			}
		}
		return true;
}
//checkDuplicate();
{/literal}
</script>