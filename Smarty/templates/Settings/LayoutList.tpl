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
function getLayoutList(customField)
{ldelim}
	var modulename = customField.options[customField.options.selectedIndex].value;
	$.ajax({ldelim}
		type:"GET",
		url:'index.php?module=Settings&action=SettingsAjax&file=LayoutList&fld_module='+modulename+'&parenttab=Settings&ajax=true',
		success: function(msg){ldelim}
			$("#cfList").html(msg);
		{rdelim}
	{rdelim});
	
{rdelim}

{literal}
function deleteCustomBlock(blockid, fld_module)
{
        if(confirm(alert_arr.SURE_TO_DELETE))
        {
                document.form.action="index.php?module=Settings&action=DeleteCustomBlock&fld_module="+fld_module+"&blockid="+blockid;
                document.form.submit();
        }
}

function getFieldLayoutForm(custommodule,fieldid,tabid,fieldlabel, blocklabel,order, blockid, typeofdata)
{
     var modulename = custommodule;
	 $.ajax({
		type:"GET",
		url:'index.php?module=Settings&action=SettingsAjax&file=CreateCustomLayout&fld_module='+custommodule+'&parenttab=Settings&ajax=true&blockid='+blockid+'&tabid='+tabid+'&fieldlabel='+fieldlabel+'&order='+order+'&blocklabel='+blocklabel+'&blockid='+blockid+'&fieldid='+fieldid+'&typeofdata='+typeofdata,
		success:function(msg){
			$("#createLayout").html(msg);
		}
	 });
	 $("#createLayout").modal("show");

}
function makeFieldSelected(oField,fieldid)
{
	if(gselected_fieldtype != '')
	{
		$(gselected_fieldtype).className = 'customMnu';
	}
	oField.className = 'customMnuSelected';	
	gselected_fieldtype = oField.id;	
	selFieldType(fieldid)
	document.getElementById('selectedfieldtype').value = fieldid;
}
var gselected_fieldtype = '';
function validate_layout() {
		if(document.addtodb.fieldlabel.value == "") {
			alert("字段标签不能为空！");
			document.addtodb.fieldlabel.focus();
			return false;
		}
		if(document.addtodb.order.value == "") {
			alert("显示顺序不能为空！");
			document.addtodb.order.focus();
			return false;
		} else {
			if(isNaN(trim(document.addtodb.order.value))) {
				alert("无效的数字");
				document.addtodb.order.focus();
				return false;
			}
		}
		return true;
}
{/literal}
</script>
<link rel="stylesheet" type="text/css" href="themes/bootcss/css/Setting.css">
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<div class="">
				{include file="Settings/SettingLeft.tpl"}
			</div>
		</div>

		<!--content-->
		<div class="span10" style="margin-left:10px">
			<div class="row-fluid box">
				<div class="tab-header">{$MOD.LBL_LAYOUT_EDITOR}</div>
					<!--<div class="page-header" style="margin-top:-10px">
						<h4 style="margin-bottom:-8px">
							<img src="{$IMAGE_PATH}custom.gif" alt="Users" title="Users" border="0" height="48" width="48">{$MOD.LBL_LAYOUT_EDITOR}
							<small>{$MOD.LBL_LAYOUT_DESCRIPTION}</small>
						</h4>
					</div>-->
				<div class="padded">
					<div style="margin-top:-8px;margin-bottom:8px">
						<span class="label label-info">1.{$MOD.LBL_SELECT_CF_TEXT}</span><br>
						<strong>选择CRM模块</strong>
						<select name="pick_module" class="importBox" onChange="getLayoutList(this)" style="margin-left:100px">
										{foreach key=sel_value item=value from=$MODULES}
										{if $MODULE eq $sel_value}
													{assign var = "selected_val" value="selected"}
										{else}
													{assign var = "selected_val" value=""}
											{/if}
											<option value="{$sel_value}" {$selected_val}>{$APP.$value}</option>
										{/foreach}
						  </select><br>
						<span class="label label-info">2.{$MOD.LBL_LAYOUT_EDITOR}:</span>
					</div>

					<div id="cfList">
										{include file="Settings/LayoutEntries.tpl"}
					</div>	
				</div>
			</div>
		</div>
		<!--content end-->
		<div class="pull-right">
			<a href="#top">[<i class="icon-arrow-up"></i>]</a>
		</div>
	</div>
</div>

<div id="createLayout" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:500px;height:238px"></div>
<br>

