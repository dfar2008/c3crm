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
<link rel="stylesheet" type="text/css" href="themes/bootcss/css/Setting.css">
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<div>
				{include file="Settings/SettingLeft.tpl"}
			</div>
		</div>
		<div class="span10" style="margin-left:10px">
			<div class="row-fluid box">
				<div class="tab-header">{$MOD.LBL_FIELDS_ACCESS}</div>
						<!--<div class="page-header" style="margin-top:-10px">
							<h4 style="margin-bottom:-8px">
								<img src="{$IMAGE_PATH}orgshar.gif" alt="Users" title="Users" border="0" height="48" width="48">{$MOD.LBL_FIELDS_ACCESS}
								<small>{$MOD.LBL_SHARING_FIELDS_DESCRIPTION}</small>
							</h4>
						</div>-->
				<div class="padded">
					<div style="margin-top:-8px">
						<span class="label label-info">1.选择CRM模块:</span>
						<select name="Screen" class="detailedViewTextBox" style="width:30%;margin-left:100px"  onChange="changemodules(this)">
						{foreach item=module from=$FIELD_INFO}
						{if $module == $DEF_MODULE}
							<option selected value='{$module}'>{$APP.$module}</option>
						{else}		
							<option value='{$module}' >{$APP.$module}</option>
						{/if}
						{/foreach}
						</select>
					</div>
					<div style="margin-top:8px">
						<form action="index.php" method="post" name="new" id="form">
							<input type="hidden" name="module" value="Settings">
							<input type="hidden" name="parenttab" value="Settings">
							<input type="hidden" name="fld_module" id="fld_module" value="{$DEF_MODULE}">
							{if $MODE neq 'view'}
								<input type="hidden" name="action" value="UpdateDefaultFieldLevelAccess">
							{else}
								<input type="hidden" name="action" value="EditDefOrgFieldLevelAccess">
							{/if}	
							<!--content start-->
							{foreach key=module item=info name=allmodules from=$FIELD_LISTS}
							{if $module eq $DEF_MODULE}
							<div id="{$module}_fields" style="display:block">	
							{else}
							<div id="{$module}_fields" style="display:none">	
							{/if}
							<span class="label label-info" style="margin-bottom:8px">2.可供选择的字段 - {$APP.$module}:</span>
							<table cellspacing="0" class="table table-bordered">
								<tr>
									<td colspan="2" >
									{if $MODE neq 'edit'}
										<button  name="Edit" type="submit" class="btn btn-small btn-primary pull-right" >
											<i class="icon-edit icon-white"></i> {$APP.LBL_EDIT_BUTTON}
										</button>
									{else}
										<button title="save" accessKey="S" class="btn btn-small btn-success pull-right" type="submit" name="Save" value="">
											<i class="icon-ok icon-white"></i> {$APP.LBL_SAVE_LABEL}
										</button>
										<button name="Cancel"  class="btn btn-small btn-primary pull-left" type="button" onClick="goback();">
											<i class="icon-arrow-left icon-white"></i> {$APP.LBL_CANCEL_BUTTON_LABEL}
										</button>
									{/if}
									
									</td>
								</tr>
								<tr>
									<td valign=top width="25%" >
										<table class="table-hover" >
										{foreach item=elements name=groupfields from=$info}
											<tr>
											{foreach item=elementinfo name=curvalue from=$elements}
											   <td style="width:20px;border:0"  >&nbsp;</td>
											   <td width="5%" style="border:0" id="{$smarty.foreach.allmodules.iteration}_{$smarty.foreach.groupfields.iteration}_{$smarty.foreach.curvalue.iteration}">{$elementinfo.1}</td>
											   <td width="25%" style="border:0" nowrap  onMouseOver="this.className='prvPrfHoverOn',$('{$smarty.foreach.allmodules.iteration}_{$smarty.foreach.groupfields.iteration}_{$smarty.foreach.curvalue.iteration}').className='prvPrfHoverOn'" onMouseOut="this.className='prvPrfHoverOff',$('{$smarty.foreach.allmodules.iteration}_{$smarty.foreach.groupfields.iteration}_{$smarty.foreach.curvalue.iteration}').className='prvPrfHoverOff'">{$elementinfo.0}</td>
											{/foreach}
											</tr>
										 {/foreach}
										 </table>
									</td>
								 </tr>
							</table>
							
							</div>
							{/foreach}
						</form>
					</div>
					<!--content end-->
				</div>
			</div>
			<div class="pull-right">
				<a href="#top">[<i class="icon-arrow-up"></i>]</a>
			</div>
		</div>
	</div>
</div>

<script>
var def_field='{$DEF_MODULE}_fields';
{literal}
function changemodules(selectmodule)
{
	hide(def_field);
	module=selectmodule.options[selectmodule.options.selectedIndex].value;
	document.getElementById('fld_module').value = module; 
	def_field = module+"_fields";
	show(def_field);
}
</script>
{/literal}

