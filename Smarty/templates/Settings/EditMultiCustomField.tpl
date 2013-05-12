{*
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/ *}
<script language="JavaScript" type="text/javascript" src="include/js/customview.js"></script>
<script language="javascript">
function getCustomFieldList(customField)
{ldelim}
	var modulename = customField.options[customField.options.selectedIndex].value;
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=CustomMultiFieldList&fld_module='+modulename+'&parenttab=Settings&ajax=true',
			onComplete: function(response) {ldelim}
				$("cfList").innerHTML=response.responseText;
			{rdelim}
		{rdelim}
	);
{rdelim}

{literal}

function theformvalidate2()
{
    for(var i=1;i<=3;i++)
    {
        var el=$('multifieldlabel'+i);
        if(el){
            var elvalue=el.value;
            if(elvalue==null||elvalue.strip()==""){
                alert('字段标签不能为空');
                el.focus();
                return false;
            }
        }
    }
    var el=$('multifieldname');
    if(el.value.strip()==""){
         alert('级联标签名不能为空');
         el.focus();
         return false;
    }
    return true;
}

function savemultifieldvalue(multifieldid,level,parentfieldid)
{
    var pick_arr=new Array();
	pick_arr=trim($("picklist_values").value).split('\n');
	var len=pick_arr.length;
	for(i=0;i<len;i++)
	{
		var valone;
		curr_iter = i;
		valone=pick_arr[curr_iter];
		for(j=curr_iter+1;j<len;j++)
		{
			var valnext;
			valnext=pick_arr[j];
			if(trim(valone) == trim(valnext))
			{
				alert("下拉框列表值重复");
				return false;
			}
		}
		i = curr_iter

	}
	
		if(trim($("picklist_values").value) == '')
		{
			alert("下拉框列表值重复");
			$("picklist_values").focus();
			return false;
		}
	

    $("status").style.display = "inline";
	//Effect.Puff($('editdiv'),{duration:2});
	var body = escape($("picklist_values").value);
	var post_url = 'index.php?action=SettingsAjax&module=Settings&directmode=ajax&file=UpdateMultiComboValues&multifieldid='+multifieldid+'&level='+level+'&listarea='+body+'&parentfieldid='+parentfieldid;

	new Ajax.Request(
        	post_url,
	        {queue: {position: 'end', scope: 'command'},
        		method: 'get',
		        onComplete: function(response) {
					//window.location.reload();
                    $("status").style.display = "none";
                    reloadOptions(multifieldid);
                    $("createcf").style.display='none';
	             }
        	}
	);

}

function getCreateCustomFieldForm(multifieldid,level,parentfieldid,selfel)
{
      
        var parentfieldid=0;
        if(level>1){
            var parentlevel=level-1;
            var parentfieldid=$F("multifieldvalue"+parentlevel);
            if(parentfieldid==""){
                alert("请先选择上一级字段值");
                return;
            }
        }
        if(!confirm("使用该工具创建下拉框选项将删除所有下级关联选项，是否确定？")) return;
        $("status").style.display="inline";
        new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                method: 'post',
                postBody: 'action=SettingsAjax&module=Settings&mode=edit&file=EditMultiComboField&multifieldid='+multifieldid+'&level='+level+'&parentfieldid='+parentfieldid,
                onComplete: function(response) {
                    $("status").style.display="none";
                    $("createcf").innerHTML=response.responseText;
					//Effect.Grow('editdiv');
					////changed by dingjianting on 2007-1-4 for gloso project and drag layer
					var theEventHandle_picklist = document.getElementById("orgLay_title");
					var theEventRoot_picklist   = document.getElementById("orgLay");
					Drag.init(theEventHandle_picklist, theEventRoot_picklist);                  
                    $('createcf').style.display='';
                    Position.clone(selfel,$("createcf"),{setWidth:false,setHeight:false});
                	}
                }
        );


}

function getEditCustomFieldForm(multifieldid,level,parentfieldid,selfel)
{

        var parentfieldid=0;
        if(level>1){
            var parentlevel=level-1;
            var parentfieldid=$F("multifieldvalue"+parentlevel);
            if(parentfieldid==""){
                alert("请先选择上一级字段值");
                return;
            }
        }
        var url='index.php?action=PopupMultiFieldTree&module=Settings&multifieldid='+multifieldid+'&level='+level+'&parentfieldid='+parentfieldid
        window.open(url,"test","width=450,height=450,resizable=1,scrollbars=1");


}

function updateChildOptions(multifieldid,level)
{
    var level=parseInt(level);
    var parentfieldid=$F('multifieldvalue'+level);
    if(parentfieldid==""){
        if($('multifieldvalue'+(level+1))) $('multifieldvalue'+(level+1)).update("<option value=''>--未选择--</option>");
        if($('multifieldvalue'+(level+2))) $('multifieldvalue'+(level+2)).update("<option value=''>--未选择--</option>");
    }
	new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                method: 'post',
                postBody: 'action=SettingsAjax&module=Settings&file=updateChildOptions&multifieldid='+multifieldid+'&level='+level+'&parentfieldid='+parentfieldid,
                onComplete: function(response) {
                    var optionval=response.responseText;
                     if($('multifieldvalue'+(level+1))) $('multifieldvalue'+(level+1)).update(optionval);
                     if($('multifieldvalue'+(level+2))) $('multifieldvalue'+(level+2)).update("<option value=''>--未选择--</option>");
                }
            }
        );
}

function reloadOptions(multifieldid)
{
     if($('multifieldvalue2')) $('multifieldvalue2').update("<option value=''>--未选择--</option>");
     if($('multifieldvalue3')) $('multifieldvalue3').update("<option value=''>--未选择--</option>");
     new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                method: 'post',
                postBody: 'action=SettingsAjax&module=Settings&file=updateChildOptions&multifieldid='+multifieldid+'&level=0&parentfieldid=0',
                onComplete: function(response) {
                    var optionval=response.responseText;
                     if($('multifieldvalue1')) $('multifieldvalue1').update(optionval);

                }
            }
        );
}
function CustomFieldMapping()
{
        document.form.action="index.php?module=Settings&action=LeadCustomFieldMapping";
        document.form.submit();
}
var gselected_fieldtype = '';

function theformvalidate() {
	var nummaxlength = 255;


	lengthLayer=getObj("lengthdetails")

        var str = getObj("fldLabel").value;
        if (!emptyCheck("fldLabel",'字段标签'))
                return false;
	return true;

}

function gotoBack(modulename)
{
    window.location.href="index.php?module=Settings&action=CustomMultiFieldList&fld_module="+modulename+"&parenttab=Settings";
}
{/literal}
</script>
<div id="createcf" style="position:absolute;width:510px; left: 682px; top: 339px;"></div>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopLeft.gif"></td>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
        <br>

	<div align=center>
			{include file='SetMenu.tpl'}
			<!-- DISPLAY -->
			{if $MODE neq 'edit'}
			<b><font color=red>{$DUPLICATE_ERROR} </font></b>
			{/if}

				<table class="settingsSelUITopLine" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tbody><tr>
					<td rowspan="2" valign="top" width="50"><img src="{$IMAGE_PATH}relatedfield.gif" alt="Users" title="Users" border="0" height="48" width="48"></td>
					<td class="heading2" valign="bottom"><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> &gt; 编辑级联字段信息</b></td>
				</tr>

				<tr>
					<td class="small" valign="top">- 编辑级联字段信息。</td>
				</tr>
				</tbody></table>

				<br>
				<table border="0" cellpadding="10" cellspacing="0" width="100%">
				<tbody><tr>
				<td>

				
				<div id="cfList">
                        <form action="index.php" method="post" name="form">
                            <input type="hidden" name="multifieldid" value="{$FieldInfo.multifieldid}">
                            <input type="hidden" name="module" value="Settings">
                            <input type="hidden" name="action" value="SaveMultiFieldBasicInfo">
                            <input type="hidden" name="parenttab" value="Settings">
                            <input type="hidden" name="mode">
                            <table class="tableHeading" border="0" cellpadding="5" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td class="small" align="left">
                                    编辑级联字段: <input type="text" id="multifieldname" name="multifieldname" value="{$FieldInfo.multifieldname}" />
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="listTableTopButtons" border="0" cellpadding="5" cellspacing="0" width="100%">
                            <tr>
                                <td class="small">&nbsp;</td>
                                <td class="small" align="right">&nbsp;&nbsp;
                                <input type="submit" name="Edit" value="保存" class="crmButton small create" onclick="return theformvalidate2();">
                               <input type="button" name="Edit" value="取消" class="crmButton small edit" onclick="gotoBack('{$FieldInfo.modulename}');">
                            </tr>
                            </table>

                            <table class="listTable" border="0" cellpadding="5" cellspacing="0" width="100%">

                                <tr>
                                    <td class="colHeader small" width="5%">#</td>
                                    <td class="colHeader small" width="20%">级联字段标签</td>
                                    <td class="colHeader small" width="20%">级联字段值</td>
                                    <td class="colHeader small" width="20%">是否必填</td>
                                </tr>

                                {foreach item=entries key=id from=$CFENTRIES}
                                <tr>
                                    {foreach item=value from=$entries}
                                        <td class="listTableRow small" valign="top" nowrap>{$value}&nbsp;</td>
                                    {/foreach}
                                </tr>
                                {/foreach}
                    </table>
                    </form>
                    <br>


                </div>
			<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr>

		  	<td class="small" align="right" nowrap="nowrap"><a href="#top">{$MOD.LBL_SCROLL}</a></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
		<!-- End of Display -->

		</td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </div>

        </td>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
        </tr>
</tbody>
</table>
<br>
