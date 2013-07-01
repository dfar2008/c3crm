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
<style>
{literal}
.taobaolist{
	padding-left:30px;
}
.taobaolist td{
	border:1px solid #999;
	line-height:20px;
}
.th{
	font-weight:bold;
	background-color:#9CF		
}
.divas{
	font-size:14px;
	color:#00F;
	margin-bottom:5px;
}
{/literal}
</style>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody>
<tr>
<td class="showPanelBg" style="padding: 10px;" valign="top" width="100%" >

<form action="index.php" method="post" name="ShopApp" id="form" onsubmit="return checkEmpty();">
<input type="hidden" name="module" value="Relsettings">
<input type="hidden" name="action">
<input type="hidden" name="record" value="{$record}">
<input type="hidden" name="parenttab" value="Settings">
<input type="hidden" name="return_module" value="Relsettings">
<input type="hidden" name="return_action" value="Taobaozushou">
<!-- DISPLAY -->
<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
<tr>
    <td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}settingsTrash.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
    <td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.DIANPUYINGYONG} </b></td>
</tr>
<tr>
    <td valign=top class="small">{$EDITTYPE} {$MOD.DIANPUYINGYONG} </td>
</tr>
</table>

</td>
</tr>
<tr>
<td class="showPanelBg" style="padding: 5px 10px 5px 10px;" valign="top" width="100%" >

<table width="100%" align="left"  border="0" cellspacing="0" cellpadding="5" class="small" >
 <tr>
    <td  align="right">
    <input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='SaveShopapp';" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >&nbsp;&nbsp;
    							<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="goback()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
    </td>
 </tr>
</table>

</td>
</tr>
<tr>
<td class="showPanelBg" style="padding: 5px 10px 5px 10px;" valign="top" width="100%" >


<table width="100%"  border="0" cellspacing="0" cellpadding="5"  style="border:1px solid #999;">
<tr>
    <td width="20%" nowrap class="small cellLabel"><strong>店铺名称</strong></td>
    <td width="80%" class="small cellText">
<input type="text" class="detailedViewTextBox small" value="{$shopname}" name="shopname" id="shopname">
</td>
  </tr>
<tr>
    <td width="20%" nowrap class="small cellLabel"><strong>appKey</strong></td>
    <td width="80%" class="small cellText">
<input type="text" class="detailedViewTextBox small" style="width:300px;" value="{$appkey}" name="appkey" id="appkey">
<input class="crmButton small edit" type="button" onclick="CreateSessionKey();return false;" name="button" value=" 生成SessionKey ">(复制<font color=red>top_session</font>的值到SessionKey)
</td>
  </tr>
  <tr valign="top">
    <td nowrap class="small cellLabel"><strong>appSecret</strong></td>
    <td class="small cellText">
<input type="text" class="detailedViewTextBox small" value="{$appsecret}" name="appsecret" id="appsecret">
</td>
  </tr>
    <tr valign="top">
    <td nowrap class="small cellLabel"><strong>昵称</strong></td>
    <td class="small cellText">
    <input type="text" class="detailedViewTextBox small" value="{$nick}" name="nick" id="nick">
    </td>
  </tr>
    <tr valign="top">
    <td nowrap class="small cellLabel"><strong>SessionKey</strong></td>
    <td class="small cellText">
    <input type="text" class="detailedViewTextBox small" style="width:400px;" value="{$topsession}" name="topsession" id="topsession">(例:<font color=red>6100722293f62ccbefd8eed40c1759125e5a21510ade2ff275197881</font>)
    
    </td>
  </tr>
   <tr valign="top">
    <td nowrap class="small cellLabel"><strong>状态(是否启用)</strong></td>
    <td class="small cellText">
    <input type="checkbox"  name="status"   {if $status eq 1}checked="checked"{/if}/>
    </td>
  </tr>
</table>
	
</td>
</tr>
</tbody>
</table>
<script>
{literal}
function checkEmpty(){
	var appkey = document.getElementById("appkey").value;
	var appsecret = document.getElementById("appsecret").value;
	var nick = document.getElementById("nick").value;
	var topsession = document.getElementById("topsession").value;
	if(appkey == ''){
		alert("appKey不能为空");
		document.getElementById("appkey").focus();
		return false;
	}
	if(appsecret == ''){
		alert("appSecret不能为空");
		document.getElementById("appsecret").focus();
		return false;
	}
	if(nick == ''){
		alert("昵称不能为空");
		document.getElementById("nick").focus();
		return false;
	}
	if(topsession == ''){
		alert("SessionKey不能为空");
		document.getElementById("topsession").focus();
		return false;
	}
}
function CreateSessionKey(){
	appkey = document.getElementById("appkey").value;
	/*new Ajax.Request(
			'index.php',
			{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody:"module=Synchronous&action=PopupgetSessionKey&appkey="+appkey,
			onComplete: function(response) {
			result = response.responseText;
					if(result.indexOf('FAILED') != '-1') {
						alert("SessionKey获取失败，请重新获取!");
						return false;	
					}else{
						alert(result);
					}
				}
			}
		)	*/
	
	window.open("http://container.open.taobao.com/container?appkey="+appkey);
} 
{/literal}
</script>

