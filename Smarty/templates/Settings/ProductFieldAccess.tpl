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
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<div id="createviewtablediv" style="display:block;position:absolute;left:700px;top:290px;"></div>
<script>
{literal}


   function previewProductTable(nowmodule)
{
    //alert('0000000');

    nowmodule = $("fld_module").value;
    //alert('1111111111');
    new Ajax.Request(
			'index.php',
                          {queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Settings&action=SettingsAjax&file=createProductTable&nowmodule='+nowmodule,
				onComplete: function(response) {
					$("createviewtablediv").innerHTML=response.responseText;
					eval($("addDefaultPlan").innerHTML);

				}
                           }
		);
    // return false;

}


{/literal}
</script>
<script>
var def_field='{$DEF_MODULE}_fields';
</script>
<script>
{literal}

function changemodules(selectmodule)
{
	hide(def_field);
	module=selectmodule;
	document.getElementById('fld_module').value = module;
	def_field = module+"_fields";
	show(def_field);
}

function checkInt()
{
  //alert("123");
    for(var i=0;i<document.new1.elements.length;i++)
    {
	if(document.new1.elements[i].type=='text')
        {
            if (isNaN(document.new1.elements[i].value))
            {
                alert('请输入数字');
                document.new1.elements[i].focus();
                return false;
            }
	}
    }
}
{/literal}
</script>

<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopLeft.gif"></td>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
	<br>
	<div align=center>
	
	{include file='SetMenu.tpl'}
		<!-- DISPLAY -->
		<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
		<form action="index.php" method="post" name="new1" id="form" onSubmit="return checkInt();" >
		<input type="hidden" name="module" value="Settings">
		<input type="hidden" name="parenttab" value="Settings">
		<input type="hidden" name="fld_module" id="fld_module" value="{$DEF_MODULE}">
		{if $MODE neq 'view'}
			<input type="hidden" name="action" value="UpdateProductField">
		{else}
			<input type="hidden" name="action" value="EditProductField">
		{/if}	
		<tr>
			<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}productfield.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
			<td colspan=2 class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > 产品字段定制 </b></td>
			<td rowspan=2 class="small" align=right>&nbsp;</td>
		</tr>
		<tr>
			<td valign=top class="small">定制各模块中的产品字段</td>
		</tr>
		</table>
		<br>
		<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
		<tr>
			<td class="big"><strong>产品模块管理</strong></td>
			<td class="small" align=right>
			{if $MODE neq 'edit'}
				<input name="Edit" type="submit" class="crmButton small edit" value="{$APP.LBL_EDIT_BUTTON}" />
                                <input class="crmbutton small edit" onclick="previewProductTable('{$DEF_MODULE}')" name="previewproduct" value="预览" type="button"/>
                                
			{else}
				<input title="save" accessKey="S" class="crmButton small save" type="submit" name="Save" value="{$APP.LBL_SAVE_LABEL}">
				<input name="Cancel" value=" {$APP.LBL_CANCEL_BUTTON_LABEL} " class="crmButton small cancel" type="button" onClick="goback();">
			{/if}
			</td>
		</tr>
		</table>
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="listTableTopButtons">
                <tr>
        		<td  style="padding-left:5px;" class="big">选择模块&nbsp;
			<select name="Screen" class="detailedViewTextBox" style="width:30%;"  onChange="changemodules(value)">
			{foreach item=module from=$FIELD_INFO}
				{if $module == $DEF_MODULE}
					<option selected value='{$module}'>{$APP.$module}</option>
				{else}		
					<option value='{$module}' >{$APP.$module}</option>
				{/if}
			{/foreach}
			</select>
		    	</td>
	                <td align="right">&nbsp;</td>
                </tr>
		</table>
		{foreach key=module item=info name=allmodules from=$FIELD_LISTS}
		{if $module eq $DEF_MODULE}
			<div id="{$module}_fields" style="display:block">	
		{else}
			<div id="{$module}_fields" style="display:none">	
		{/if}
	 	<table cellspacing=0 cellpadding=5 width=100% class="listTable small">
       		
		<tr>
                	<td valign=top width="25%" >
		     	<table border=0 cellspacing=0 cellpadding=5 width=100% class=small>
                                <tr>
                                    <td width=1%></td>
                                    <td width=5%></td>
                                    <td width=10%><strong>字段名</strong></td>
                                    <td width=9%><strong>字段宽度</strong></td>
                                    <td width=1%></td>
                                    <td width=5%></td>
                                    <td width=10%><strong>字段名</strong></td>
                                    <td width=9%><strong>字段宽度</strong></td>
                                    <td width=1%></td>
                                    <td width=5%></td>
                                    <td width=10%><strong>字段名</strong></td>
                                    <td width=9%><strong>字段宽度</strong></td>
                                    <td width=1%></td>
                                    <td width=5%></td>
                                    <td width=10%><strong>字段名</strong></td>
                                    <td width=9%><strong>字段宽度</strong></td>

                                </tr>
                                <tr>
                                </tr>
				{foreach item=elements name=groupfields from=$info}
                        	<tr>
					{foreach item=elementinfo name=curvalue from=$elements}
                           		<td style="width:20px">&nbsp;</td>
                           		<td width="5%" id="{$smarty.foreach.allmodules.iteration}_{$smarty.foreach.groupfields.iteration}_{$smarty.foreach.curvalue.iteration}">{$elementinfo.1}</td>
                           		<td width="10%" nowrap  onMouseOver="this.className='prvPrfHoverOn',$('{$smarty.foreach.allmodules.iteration}_{$smarty.foreach.groupfields.iteration}_{$smarty.foreach.curvalue.iteration}').className='prvPrfHoverOn'" onMouseOut="this.className='prvPrfHoverOff',$('{$smarty.foreach.allmodules.iteration}_{$smarty.foreach.groupfields.iteration}_{$smarty.foreach.curvalue.iteration}').className='prvPrfHoverOff'">{$elementinfo.0}</td>
                                        <td width="5%" id="{$smarty.foreach.allmodules.iteration}_{$smarty.foreach.groupfields.iteration}_{$smarty.foreach.curvalue.iteration}_2">{$elementinfo.2}%</td>
                                        {/foreach}
                         	</tr>
                         	{/foreach}
                     	</table>
			</td>
                </tr>
                </table>
		</div>
		{/foreach}
	</td>
	</tr>
        </table>
</td>
</tr>
</table>
</td>
</tr>
</form>
</table>
</div>
</td>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
   </tr>
</tbody>
</table>


