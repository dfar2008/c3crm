<style>
{literal}
.taobaolist{
	
}
.taobaolist td{
	border:1px solid #999
}
.th{
	font-weight:bold;
	background-color:#D7E5EB		
}
.divas{
	font-weight:bold;
	font-size:14px;
	color:#00F;
	margin-bottom:5px;
}
{/literal}
</style>
<div>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
		<td class="showPanelBg" style="padding: 10px;" valign="top" width="100%" align="center">
		<br>
	<div align=center>
			{include file='SetMenu.tpl'}
			<!-- DISPLAY -->
			{if $MODE neq 'edit'}
			<b><font color=red>{$DUPLICATE_ERROR} </font></b>
			{/if}

				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tbody><tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}settingsTrash.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > {$MOD.TAOBAOZUSHOU} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.TAOBAOZUSHOU} </td>
				</tr>
				</tbody></table>

				<br>
				<table border="0" cellpadding="10" cellspacing="0" width="100%">
				<tbody><tr>
				<td>

				<table width="98%" align="left"  border="0" cellspacing="0" cellpadding="5" class="small" >
				 <tbody><tr>
				   <td class="divas">店铺及应用设置</td>
					<td  align="right"><input type="button" name="button" value="新增店铺应用" onclick="javascript:location.href='index.php?module=Relsettings&action=EditShopapp'" class="crmbutton small create"></td>
				 </tr>
				</tbody>
				</table>

				</td>
				</tr>
				<tr>
				<td class="showPanelBg" style="padding: 5px 10px 5px 10px;" valign="top" width="100%" align="center">
				 <table width="98%" align="left"  border="0" cellspacing="0" cellpadding="5" class="small taobaolist" >
				 <tr>
					{foreach item=head from=$APPHEAD}
					  <td class="th">{$head}</td>
					 {/foreach}
				 </tr>
				{foreach key=key item=smstc from=$LIST_ENTRIES}
				<tr class="lvtColData" bgcolor="white" onmouseout="this.className='lvtColData'" onmouseover="this.className='lvtColDataHover'">
					{foreach item=data from=$smstc}
						<td >{$data}</td>
					{/foreach}
				</tr>
				{foreachelse}
				 <td class="lvtColData" bgcolor="white" onmouseout="this.className='lvtColData'" onmouseover="this.className='lvtColDataHover'" colspan="{$counthead}" align="center">--无--</td>
				{/foreach}
				</table>	
 
				</td>
				</tr>
				<tr>
				<td class="showPanelBg" style="padding: 5px 10px 5px 10px;" valign="top" width="100%" align="center">
					
					<table width="98%" align="left"  border="0" cellspacing="0" cellpadding="5" class="small" >
					 <tr>
					   <td class="divas">当前启用店铺appKey与appSecret</td>
					 </tr>
					</table>

				</td>
				</tr>
				<tr>
				<td class="showPanelBg" style="padding: 5px 10px 5px 10px;" valign="top" width="100%" align="center">


				<table width="50%" align="left"  border="0" cellspacing="0" cellpadding="5" class="small taobaolist" >
				 <tr>
				 {if $current_id neq ''}
					 <td width="5%" class="th">appKey:</td>
					 <td width="20%">{$current_appkey}</td>
					 <td width="5%" class="th">appSecret:</td>
					 <td width="30%">{$current_appsecret}</td>

				 {else}
					 <td >{$noselect}</td>
				 {/if}
				   
				 </tr>
				</table>

				</td>
				</tr>
				<tr>
				<td class="showPanelBg" style="padding: 10px;" valign="top" width="100%" align="center">


				<form action="index.php" method="post" name="synform" id="form" >
				<input type="hidden" name="module" value="Synchronous">
				<input type="hidden" name="action" value="SynIn">
				<input type="hidden" name="record" id="record" value="{$current_id}" /> 
				<table width="98%" align="left"  border="0" cellspacing="0" cellpadding="5" class="small"  style="padding-top:20px;">
				 <tr>
					<td class="divas" width="25%">同步最近三个月内交易完成的订单：</td>
				   <td class="divas" >
					 <input type="button" name="button" value="&nbsp;&nbsp;开始同步&nbsp;&nbsp;" class="crmbutton small edit" onclick="beginsyn();"/>
				   &nbsp;&nbsp;</td>
				 </tr>
				</table>
				</form>

				</td>
				</tr>
				<tr>
				<td class="showPanelBg" style="padding: 10px;" valign="top" width="100%" align="center">


				<table width="98%" align="left"  border="0" cellspacing="0" cellpadding="5" class="small"  style="padding-top:20px;">
				 <tr>
				   <td class="divas"><font color=red>帮助：</font><a href="http://www.c3crm.com/bbs/forum.php?mod=viewthread&tid=1321&extra=page%3D1" target="_blank">如何增加淘宝店铺应用？</a>
				   </td>
				 </tr>
				</table>

				</td>
				</tr>
				<tr>
				<td class="showPanelBg" style="padding: 10px;" valign="top" width="100%" align="center">


				<form action="index.php" method="post" name="synimport" id="form" >
				<input type="hidden" name="module" value="Accounts">
				<input type="hidden" name="action" value="Import2">
				<table width="98%" align="left"  border="0" cellspacing="0" cellpadding="5" class="small"  style="padding-top:20px;">
				 <tr>
					<td class="divas" width="25%">导入三个月前的客户及订单信息：</td>
				   <td class="divas" >
					 <input type="submit" name="button" value="&nbsp;&nbsp;导入&nbsp;&nbsp;" class="crmbutton small edit" />
				   &nbsp;&nbsp;</td>
				 </tr>
				</table>
				</form>

			</div>
			</td>
			</tr>
</tbody>
</table>
</div>

{literal}
<script>
function beginsyn(){
	var  current_id = document.getElementById("record").value;
	if(current_id == ''){
		alert("你尚未启用一个店铺!");
		return false;
	}else{
		var t = confirm("确认同步三个月内的订单?");
		if(t){
			document.synform.submit();	
		}else{
			return false;	
		}
	}	
}
</script>
{/literal}
