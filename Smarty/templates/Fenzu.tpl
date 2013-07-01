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

function checkpublic(form,setpublic)
{ldelim}
        if(setpublic) form.roleid.disabled = true;
	else form.roleid.disabled = false;
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
<form enctype="multipart/form-data" name="Fenzu" method="POST" action="index.php" onsubmit="return mandatoryCheck();">
<input type="hidden" name="module" value="Fenzu">
<input type="hidden" name="action" value="Save">
<input type="hidden" name="parenttab" value="{$CATEGORY}">
<input type="hidden" name="cvmodule" value="{$CVMODULE}">
<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
<input type="hidden" name="record" value="{$FenzuID}">
<input type="hidden" name="return_action" value="{$RETURN_ACTION}">

<div class="container-fluid">
<div style="margin-left:0px;margin-right:10px;">
  <ul class="breadcrumb" style="margin-bottom:10px;">
    <li>
      <a class="hdrLink" href="index.php?action=ListView&module={$MODULE}&parenttab={$CATEGORY}">{$APP.$MODULE}</a> <span class="divider">/</span>
    </li>
    <li class="active"><a class="hdrLink" href="index.php?action=ListView&module={$MODULE}&parenttab={$CATEGORY}">{$APP.$CURRENTMODULE}</a> &gt; {if $FenzuID eq ''}{$MOD.New_Custom_View}{else}编辑分组{/if}</li>
  </ul>
</div>
<div style="margin-left:0px;margin-right:10px;">
     <table class="table table-bordered table-condensed table-striped"> 
         <tbody>
          <tr>  
            <td><i class="cus-bullet_purple"></i><b>{$MOD.Details}</b></td>
          </tr>
          <tr>  
            <td>
              <table class="table table-bordered table-hover table-condensed"> 
                <tbody>
                  <tr >
                    <td style="background-color:#fff;" width="10%" align="right">
                      <font color=red>*</font>{$MOD.LBL_VIEW_NAME}</td>
                    <td style="background-color:#fff;" width="20%">
                      <input type="text" name='viewName' value="{$VIEWNAME}" />
                    </td> 
                    <td style="background-color:#fff;">
                    
                          
                          {$publichtml}
                    </td>
                  </tr>
                </tbody>  
              </table>
            </td>
          </tr>
         
         
          <tr>  
            <td><i class="cus-bullet_purple"></i><b>设置过滤条件</b></td>
          </tr>
          <tr>  
            <td>
              <div class="tabbable tabs-left" style="margin-bottom: 18px;">
                <ul class="nav nav-tabs">
                  <li class="active" ><a href="#tab1" data-toggle="tab" >基本条件</a></li>
                  <li><a href="#tab2" data-toggle="tab">高级条件</a></li>
                </ul> 
                <div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
                  <div class="tab-pane active" id="tab1">
                    <div class="well" style="margin-bottom:10px;">
                      <b>{$MOD.LBL_AF_HDR1}</b><br>
                      1)当时间段为自定义时，开始日期和结束日期将为指定的日期，例如2010-10-10。<br>
                      2)当时间段为非自定义时，开始日期和结束日期将为动态的日期，例如选择本周时，开始日期和结束日期将分别为本周的周一和周末，而不是固定的日期。
                      3)<font color="#FF0000">生日字段只需确认月和日即可。</font>
                    </div>
                    <table class="table table-bordered table-hover table-condensed"> 
                      <tbody>
                        <tr>
                          <td colspan=2>
                              <b>{$MOD.Simple_Time_Filter}</b>
                          </td>
                        </tr>
                        <tr>
                          <td>
                             {$MOD.LBL_Select_a_Column} :
                          </td>
                          <td>
                            <select name="stdDateFilterField" class="select">
                              {foreach item=stdfilter from=$STDFILTERCOLUMNS}
                                <option {$stdfilter.selected} value={$stdfilter.value}>{$stdfilter.text}</option> 
                              {/foreach}
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>
                             {$MOD.Select_Duration} :
                          </td>
                          <td>
                            <select name="stdDateFilter" class="select" onchange='showDateRange(this.options[this.selectedIndex].value )'>
                              {foreach item=duration from=$STDFILTERCRITERIA}
                                <option {$duration.selected} value={$duration.value}>{$duration.text}</option>
                              {/foreach}
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            {$MOD.Start_Date} :
                          </td>
                          <td>
                            <input name="startdate" id="jscal_field_date_start" type="text" size="10" class="textField" value="{$STARTDATE}">
                            <img src="{$IMAGE_PATH}calendar.gif" id="jscal_trigger_date_start" onclick="javascript:displayCalendar('jscal_field_date_start',this)">
                          </td>
                         </tr>
                         <tr>
                          <td>
                            {$MOD.End_Date} :
                          </td>
                          <td>
                            <input name="enddate" id="jscal_field_date_end" type="text" size="10" class="textField" value="{$ENDDATE}">
                           <img src="{$IMAGE_PATH}calendar.gif" id="jscal_trigger_date_end" onclick="javascript:displayCalendar('jscal_field_date_end',this)">
                          </td>
                         </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="tab2">
                   <div class="well" style="margin-bottom:10px;">
                    <b>{$MOD.LBL_AF_HDR1}</b><br />
                    1){$MOD.LBL_AF_HDR2}<br />
                    2){$MOD.LBL_AF_HDR3}
                   </div>
                   <table class="table table-bordered table-hover table-condensed"> 
                    <tbody>
                      <tr>
                        <td colspan=3><b>{$MOD.LBL_RULE}</b></td>
                      </tr>
                      <tr>
                        <td width="20%">
                          <select name="fcol1" id="fcol1" onchange="updatefOptions(this, 'fop1');">
                            <option value="">{$MOD.LBL_NONE}</option>
                            {foreach item=filteroption key=label from=$BLOCK1}
                            <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                              {foreach item=text from=$filteroption}
                                <option {$text.selected} value={$text.value}>{$text.text}</option>
                              {/foreach}
                            {/foreach}
                          </select>
                        </td>
                        <td width="20%">
                          <select name="fop1" id="fop1">
                            <option value="">{$MOD.LBL_NONE}</option>
                            {foreach item=criteria from=$FOPTION1}
                            <option {$criteria.selected} value={$criteria.value}>{$criteria.text}</option>
                            {/foreach}
                          </select>
                        </td>
                        <td>
                           <input name="fval1" id="fval1" type="text" size=30 maxlength=80 value="{$VALUE1}">
                           &nbsp;{$MOD.LBL_AND}
                        </td>
                      </tr>
                      <tr>
                        <td width="20%">
                          <select name="fcol2" id="fcol2" onchange="updatefOptions(this, 'fop2');">
                            <option value="">{$MOD.LBL_NONE}</option>
                            {foreach item=filteroption key=label from=$BLOCK2}
                            <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                              {foreach item=text from=$filteroption}
                                <option {$text.selected} value={$text.value}>{$text.text}</option>
                              {/foreach}
                            {/foreach}
                          </select>
                        </td>
                        <td width="20%">
                          <select name="fop2" id="fop2">
                            <option value="">{$MOD.LBL_NONE}</option>
                            {foreach item=criteria from=$FOPTION2}
                              <option {$criteria.selected} value={$criteria.value}>{$criteria.text}</option>
                            {/foreach}
                            </select>
                        </td>
                        <td>
                          <input name="fval2" id="fval2" type="text" size=30 maxlength=80 value="{$VALUE2}">
                          &nbsp;{$MOD.LBL_AND}
                        </td>
                      </tr>
                      <tr>
                        <td width="20%">
                          <select name="fcol3" id="fcol3" onchange="updatefOptions(this, 'fop3');">
                            <option value="">{$MOD.LBL_NONE}</option>
                            {foreach item=filteroption key=label from=$BLOCK3}
                            <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                              {foreach item=text from=$filteroption}
                                <option {$text.selected} value={$text.value}>{$text.text}</option>
                              {/foreach}
                            {/foreach}
                          </select>
                        </td>
                        <td width="20%">
                          <select name="fop3" id="fop3">
                            <option value="">{$MOD.LBL_NONE}</option>
                            {foreach item=criteria from=$FOPTION3}
                              <option {$criteria.selected} value={$criteria.value}>{$criteria.text}</option>
                            {/foreach}
                          </select>
                        </td>
                        <td>
                          <input name="fval3" id="fval3" type="text" size=30 maxlength=80 value="{$VALUE3}">
                          &nbsp;{$MOD.LBL_AND}
                        </td>
                      </tr>
                      <tr>
                        <td width="20%">
                          <select name="fcol4" id="fcol4" onchange="updatefOptions(this, 'fop4');">
                            <option value="">{$MOD.LBL_NONE}</option>
                            {foreach item=filteroption key=label from=$BLOCK4}
                            <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                              {foreach item=text from=$filteroption}
                                <option {$text.selected} value={$text.value}>{$text.text}</option>
                              {/foreach}
                            {/foreach}
                          </select>
                        </td>
                        <td width="20%">
                          <select name="fop4" id="fop4">
                            <option value="">{$MOD.LBL_NONE}</option>
                            {foreach item=criteria from=$FOPTION4}
                             <option {$criteria.selected} value={$criteria.value}>{$criteria.text}</option>
                            {/foreach}
                          </select>
                        </td>
                        <td>
                          <input name="fval4" id="fval4" type="text" size=30 maxlength=80 value="{$VALUE4}">
                          &nbsp;{$MOD.LBL_AND}
                        </td>
                      </tr>
                      <tr>
                        <td width="20%">
                          <select name="fcol5" id="fcol5" onchange="updatefOptions(this, 'fop5');">
                            <option value="">{$MOD.LBL_NONE}</option>
                            {foreach item=filteroption key=label from=$BLOCK5}
                            <optgroup label="{$label}" class=\"select\" style=\"border:none\">
                              {foreach item=text from=$filteroption}
                                <option {$text.selected} value={$text.value}>{$text.text}</option>
                              {/foreach}
                            {/foreach}
                          </select>
                        </td>
                        <td width="20%">
                          <select name="fop5" id="fop5">
                            <option value="">{$MOD.LBL_NONE}</option>
                            {foreach item=criteria from=$FOPTION5}
                              <option {$criteria.selected} value={$criteria.value}>{$criteria.text}</option>
                            {/foreach}
                          </select>
                        </td>
                        <td>
                          <input name="fval5" id="fval5" type="text" size=30 maxlength=80 value="{$VALUE5}">
                        </td>
                      </tr>
                    </tbody>
                   </table>
                  </div>
                </div>
              </div> <!-- /tabbable -->
            </td>
          </tr>
          <tr>
            <td align="center">
               <input title="{$APP.LBL_SAVE_BUTTON_LABEL} [Alt+S]" accesskey="S" class="btn btn-success"  name="button2" value="{$APP.LBL_SAVE_BUTTON_LABEL}"  type="submit" onClick="return checkDuplicate();"/>
               <input title="{$APP.LBL_CANCEL_BUTTON_LABEL} [Alt+X]" accesskey="X" class="btn btn-warning" name="button2" onclick='goback()' value="{$APP.LBL_CANCEL_BUTTON_LABEL}"  type="button" />
            </td>
          </tr>
        </tbody>
      </table>
</div>
</div>
</form>
{$STDFILTER_JAVASCRIPT}
{$JAVASCRIPT}
<!-- to show the mandatory fields while creating new customview -->
<script language="javascript" type="text/javascript">
var k;
var colOpts;
var manCheck = new Array({$MANDATORYCHECK});
{literal}
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
}
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