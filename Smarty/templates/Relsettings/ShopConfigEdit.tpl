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
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
	
	<form action="index.php" method="post" name="ShopConfig" id="form" onsubmit="return validate(ShopConfig);">
	<input type="hidden" name="module" value="Relsettings">
	<input type="hidden" name="action">
    {if $ID neq ''}
    <input type="hidden" name="transferto" value="edit">
    {else}
    <input type="hidden" name="transferto" value="add">
    {/if}
	<input type="hidden" name="parenttab" value="Settings">
	<input type="hidden" name="return_module" value="Relsettings">
	<input type="hidden" name="return_action" value="ShopConfig">
    <input type="hidden" name="shopid" value="{$ID}">
	<div align=center>
			

				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}ico_mobile.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.LBL_SHOP_SERVER_SETTINGS} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_SHOP_SERVER_SETTINGS} </td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="big"><strong>{$MOD.LBL_SHOP_SERVER_SETTINGS}</strong></td>
						
						<td class="small" align=right>
							<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='SaveShop';" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >&nbsp;&nbsp;
    							<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="goback()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
						</td>
					</tr>
					</table>
					
					
						<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow">
						<tr>
						<td class="small" valign=top ><table width="100%"  border="0" cellspacing="0" cellpadding="5">
						  <tr valign="top">
						    <td width="20%" nowrap class="cellLabel"><strong>店铺名称</strong></td>
						    <td width="80%" class="cellText">
							<input type="text" class="small"  style="width:300px;" value="{$SHOPNAME}" name="shopname">
						    </td>
						  </tr>
						  <tr>
						    <td width="20%" nowrap class="cellLabel"><strong>appKey</strong></td>
						    <td width="80%" class="cellText">
							<input type="text" class="small" value="{$APPKEY}" style="width:300px;" name="appkey" id="appkey">
                            <input type="button" class="crmButton small edit" value=" 生成SessionKey "  name="button" onclick="CreateSessionKey();return false;">
						    </td>
						  </tr>
                           <tr>
						    <td width="20%" nowrap class="cellLabel"><strong>appSecret</strong></td>
						    <td width="80%" class="cellText">
							<input type="text" class="small" value="{$APPSECRET}" style="width:300px;" name="appsecret" id="appsecret">
                           
						    </td>
						  </tr>
						  <tr>
						    <td width="20%" nowrap class="cellLabel"><strong>状态</strong></td>
						    <td width="80%" class="cellText">
                            <select name="is_on">
                            {foreach from=$STATUSARR item=status key=key}
                            {if $key eq $IS_ON}
                            <option value="{$key}" selected="selected">{$status}</option>
                            {else}
                            <option value="{$key}">{$status}</option>
                            {/if}
                            {/foreach}
                            </select>
						    </td>
						  </tr>
						  <tr>
						    <td width="20%" nowrap class="cellLabel"><strong>SessionKey</strong></td>
						    <td width="80%" class="cellText">
							<input type="text" class="small" value="{$SESSIONKEY}" style="width:700px;" name="sessionkey" id="sessionkey" >
                            
                           
						    </td>
						  </tr>
						</table>				
						
						</td>
					  </tr>
					</table>
				
				</td>
				</tr>
				</table>
			
			
			
			</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
		
	</div>
	</form>
	
</td>
   </tr>
</tbody>
</table>
{literal}
<script>
function validate(form)
{
	if(form.shopname.value =='')
	{
		alert("店铺名不能为空");
		return false;
	}
	if(form.appkey.value =='')
	{
		alert("appkey不能为空");
		return false;
	}
	if(form.appsecret.value =='')
	{
		alert("appsecret不能为空");
		return false;
	}
	if(form.is_on.value =='1')
	{	
		
		result = confirm("确认启用此店铺?");
		if(result == true){
			return true;
		}else{
			return false;
		}
		
	}
	return true;
}
function CreateSessionKey(){
	appkey = document.getElementById("appkey").value;
	window.open("http://container.open.taobao.com/container?appkey="+appkey);
	
}
</script>
{/literal}
