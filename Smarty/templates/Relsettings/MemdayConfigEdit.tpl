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
<tbody>
	<tr>
    <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
    
	<form action="index.php" method="post" name="MemdayConfig" id="form" >
	<input type="hidden" name="module" value="Relsettings">
	<input type="hidden" name="action">
    <input type="hidden" name="record" value="{$record}">
	<input type="hidden" name="parenttab" value="Settings">
	<input type="hidden" name="return_module" value="Relsettings">
	<input type="hidden" name="return_action" value="MemdayConfig">
	<div align=center>
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}ico_mobile.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.LBL_MEMDAY_SETTINGS} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_MEMDAY_SETTINGS} </td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						
						<td class="small" align=right>
							<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='SaveMemday';return validate_memday();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >&nbsp;&nbsp;
    							<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="goback()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
						</td>
					</tr>
					</table>
					
					
					
			<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow" style="border:1px solid #999">
			<tr>
			<td class="small" valign=top ><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                       <tr style="height:80px;">
                            <td width="20%" nowrap class="small cellLabel"  align="center"><strong>纪念日类型</strong></td>
                            <td width="80%" class="small cellText">
                            <select name="type" id="type">
							{foreach from=$typearr item=tt}
                            	{if $tt eq $type}
                            	<option value="{$tt}" selected="selected">{$tt}</option>
                                {else}
                                <option value="{$tt}" >{$tt}</option>
                                {/if}
                            {/foreach}
                            </select>
			  				</td>
                        </tr>
                        <tr style="height:80px;">
                            <td width="20%" nowrap class="small cellLabel"  align="center"><strong>执行日期</strong></td>
                            <td width="80%" class="small cellText">
                             <font color="#CC6699">【相对日期】</font>于纪念日提前             
                             <font color="#CC6699"><input value="{$tp}" size="2" name="tp"/> </font>天提醒。( 0 或 不填 即为纪念日当天提醒。)
			  				</td>
                        </tr>
					    <tr>
                            <td width="20%" nowrap class="small cellLabel" rowspan="2" align="center"><strong>执行操作</strong></td>
                            <td width="80%" class="small cellText">
							<input type="checkbox" name="sms" id="sms"  {$arr_sms}/>
                            <font color="#3366FF"><b>发短信</b></font><br> 	<br> 
                            <font color="808080"><span style="vertical-align: top;">短信内容：</span></font>
                           <textarea cols="60" name="autoact_sms_sm" id="autoact_sms_sm" rows="5" style="width:60%" onkeyup="checkFieldNum();"/>{$autoact_sms_sm}</textarea><br/>　<font color="999999">　　　　
                                  <span style="background-color: rgb(102, 170, 255); color: rgb(255, 255, 255);"> 通配符:会员名称$name$</span></font> <span id="showzishu">你还能输入:<font color=red><b>65</b></font>个字...</span><br><br/>
                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" name="smstoacc"  id="smstoacc" {$arr_smstoacc} /><font color="#6699FF"><b>发给客户</b></font>
                                <input type="checkbox" name="smstouser" id="smstouser"  {$arr_smstouser} /><font color="#6699FF"><b>发给自己</b></font>
			   				 </td>
                          </tr>
                            <tr>
                            <td width="80%" class="small cellText">
							 <input type="checkbox" name="email" id="email" {$arr_email}/>
                             <font color="#3366FF"><b>发邮件</b></font><br/><br/>
                             
                            <font color="808080">邮件标题：</font>
                                    <input type="edit" value="{$autoact_email_bt}" size="50" name="autoact_email_bt"/><br/>　　　　
                                 <br/><font color="808080"><span style="vertical-align: top;">邮件内容：</span></font>
                                  <textarea cols="60" name="autoact_email_sm" rows="5" style="width:60%"/>{$autoact_email_sm}</textarea><br/>　
                                  <font color="999999">　　　　
                                  <span style="background-color: rgb(102, 170, 255); color: rgb(255, 255, 255);"> 通配符:会员名称$name$</span></font><br><br/>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" name="emailtoacc" id="emailtoacc"  {$arr_emailtoacc} /><font color="#6699FF"><b>发给客户</b></font>
                                <input type="checkbox" name="emailtouser" id="emailtouser" {$arr_emailtouser} /><font color="#6699FF"><b>发给自己</b></font>
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
<script>
{literal}
function checkFieldNum(){
	var autoact_sms_sm = document.getElementById('autoact_sms_sm').value;
	var contentlen = fucCheckLength2(autoact_sms_sm);
	var zishu = 65 - contentlen;
	var str = "你还能输入:<font color=red><b>"+zishu+"</b></font>个字...";
	//document.getElementById("showzishu").update(str);
	$("showzishu").update(str);
}
function getCheckedValue(name){
	var checkboxs=document.getElementsByName(name);
	for (var i=0;i<checkboxs.length;i++)
	{
		if(checkboxs[i].checked == true){
			return 	checkboxs[i].value;
		}
	}
}
function validate_memday(){
	var record= document.MemdayConfig.record.value;
	
	var type = document.getElementById("type").value;
	if(type == "请选择"){
		alert("请选择纪念日类型");
		return false;
	}

	var sms = document.getElementById("sms").checked;
	if(sms){
		var autoact_sms_sm = document.MemdayConfig.autoact_sms_sm.value;
		if(autoact_sms_sm ==''){
			alert("短信内容不能为空");
			document.MemdayConfig.autoact_sms_sm.focus();
			return false;
		}
		var autoact_sms_sm_field =  fucCheckLength2(autoact_sms_sm);
		if(autoact_sms_sm_field > 65){
			alert("短信内容不能超过65个字");
			document.MemdayConfig.autoact_sms_sm.focus();
			return false;
		}
	}

	var email = document.getElementById("email").checked;
	if(email){
		var autoact_email_bt = document.MemdayConfig.autoact_email_bt.value;
		if(autoact_email_bt ==''){
			alert("邮件标题不能为空");
			document.MemdayConfig.autoact_email_bt.focus();
			return false;
		}
		var autoact_email_sm = document.MemdayConfig.autoact_email_sm.value;
		if(autoact_email_sm ==''){
			alert("邮件内容不能为空");
			document.MemdayConfig.autoact_email_sm.focus();
			return false;
		}
	}
	if(!sms && !email){
		alert("短信和邮件,至少选中一项执行操作");
		return false;
	}
	
	var smstoacc = document.getElementById("smstoacc").checked;
	var smstouser = document.getElementById("smstouser").checked;
	if(sms && !smstoacc && !smstouser){
		alert("发送短信,至少选择一个发送对象");
		return false;
	}
	
	var emailtoacc = document.getElementById("emailtoacc").checked;
	var emailtouser = document.getElementById("emailtouser").checked;
	if(email && !emailtoacc && !emailtouser){
		alert("发送邮件,至少选择一个发送对象");
		return false;
	}
	
	new Ajax.Request(
			'index.php',
			{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody:"module=Relsettings&action=RelsettingsAjax&file=SaveMemday&ajax=true&type="+type+"&record="+record,
			onComplete: function(response) {
			result = response.responseText; 
					if(result.indexOf('FAILED') != '-1') {
						alert("该纪念日类型已经创建过提醒模板了，请重新选择类型!");
						return false;	
					}else if(result.indexOf('SUCCESS') != '-1'){
						document.MemdayConfig.submit();
					}
				}
			}
		)	
}
{/literal}
</script>

