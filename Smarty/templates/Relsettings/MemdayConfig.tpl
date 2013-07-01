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
<!--	Setting Contact		-->
<ul class="breadcrumb">
	<li><a href="#">{$RELSETHEAD}</a> <span class="divider">/</span></li>
	<li class="active"><a href="index.php?module=Relsettings&action=index&relset={$RELSET}&parenttab=Settings">{$RELSETARRAY[$RELSET]}</a> <span class="divider">/</span></li>
	<li class="active">{$RELSETTITLE}</li>
	<li class="pull-right">
		{if $RELSETMODE == 'edit'}
			<button type="button" class="btn btn-small btn-success" style="margin-top:-2px;"
			 onclick="this.form.action.value='SaveMemday';return validate_memday();">
			<i class="icon-ok icon-white"></i>{$APP.LBL_SAVE_LABEL}
		</button>
		{else}
			<button type="button" class="btn btn-small btn-primary" style="margin-top:-2px;"
				onclick="this.form.relsetmode.value='edit';this.form.submit();">
				<i class="icon-edit icon-white"></i>{$APP.LBL_GENERATE}
			</button>
		{/if}
	</li>
</ul>
{if $RELSETMODE == 'edit'}
	<input type="hidden" name="record" value="{$record}">
	<table class="table table-condensed table-bordered ">
		<tbody style="text-align: center;">
		  <tr>
			<th style="width:150px;">纪念日类型</th>
			<td style="text-align:left;">
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
		  </tr><tr>
			<th>执行日期</th>
			<td style="text-align:left;">
				<font color="#CC6699">【相对日期】</font>于纪念日提前             
                <font color="#CC6699"><input type="text" value="{$tp}" style="width:50px;" name="tp"/> </font>天提醒。( 0 或 不填 即为纪念日当天提醒。)
			</td>
		</tr><tr>
			<th rowspan="2">执行操作</th>
			<td style="text-align:left;">
				<input type="checkbox" name="sms" id="sms"  {$arr_sms}/>
				<font color="#3366FF"><b>发短信</b></font><br>
				<small style="color:#808080;">短信内容：</small>

				<textarea cols="60" name="autoact_sms_sm" id="autoact_sms_sm" rows="4" style="width:60%" onkeyup="checkFieldNum();"/>{$autoact_sms_sm}</textarea><br/>　<font color="999999">　　　　
				<span style="background-color: rgb(102, 170, 255); color: rgb(255, 255, 255);"> 通配符:会员名称$name$</span></font> <span id="showzishu">你还能输入:<font color=red><b>65</b></font>个字...</span><br/>
				<span style="padding-left:65px;">
					<input type="checkbox" name="smstoacc"  id="smstoacc" {$arr_smstoacc} /><font color="#6699FF"><b>发给客户</b></font>
					<input type="checkbox" name="smstouser" id="smstouser"  {$arr_smstouser} /><font color="#6699FF"><b>发给自己</b></font>
				</span>
			</td>
		</tr><tr>
			<td style="text-align:left;">
				<input type="checkbox" name="email" id="email" {$arr_email}/>
				<font color="#3366FF"><b>发邮件</b></font><br/>

				<small style="color:#808080;">邮件标题：</small>
				<input type="text" value="{$autoact_email_bt}" size="50" name="autoact_email_bt"/><br/>　　　　
				
				<br><small style="color:#808080;">邮件内容：</small>

				<textarea cols="60" name="autoact_email_sm" rows="4" style="width:60%"/>{$autoact_email_sm}</textarea><br/>　
				<font color="999999">　　　　
				<span style="background-color: rgb(102, 170, 255); color: rgb(255, 255, 255);"> 通配符:会员名称$name$</span></font><br/>
				<span style="padding-left:65px;">
					<input type="checkbox" name="emailtoacc" id="emailtoacc"  {$arr_emailtoacc}/><font color="#6699FF"><b>发给客户</b></font>
					<input type="checkbox" name="emailtouser" id="emailtouser" {$arr_emailtouser}/><font color="#6699FF"><b>发给自己</b></font>
				</span>
			</td>
		</tr>
		</tbody>
	</table>
{else}
<table class="table table-condensed table-bordered table-hover">
	<thead>
	  <tr>
		{foreach name="listviewforeach" item=header from=$LISTHEADER}
			<th>{$header}</th>
		{/foreach}
	  </tr>
	</thead>
	<tbody style="text-align: center;">
		{foreach item=entity key=entity_id from=$LISTENTITY}
			<tr>
				{foreach item=data from=$entity}	
					<td>{$data}</td>
				{/foreach}
			</tr>
		{foreachelse}
			<tr>
			<td colspan="{$countnheader}" align="center" height="30">--无--</td>
			</tr>
		{/foreach}
	</tbody>
	<tr>
		<td colspan="{$countnheader}">
		备注: 
		1.同一纪念日类型只能创建一个提醒模板。
		</td>
	</tr>
</table>
{/if}

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
	var record = document.relsetform.record.value;
	
	var types = document.getElementById("type").value;
	if(types == "请选择"){
		alert("请选择纪念日类型");
		return false;
	}

	var sms = document.getElementById("sms").checked;
	if(sms){
		var autoact_sms_sm = document.relsetform.autoact_sms_sm.value;
		if(autoact_sms_sm ==''){
			alert("短信内容不能为空");
			document.relsetform.autoact_sms_sm.focus();
			return false;
		}
		var autoact_sms_sm_field =  fucCheckLength2(autoact_sms_sm);
		if(autoact_sms_sm_field > 65){
			alert("短信内容不能超过65个字");
			document.relsetform.autoact_sms_sm.focus();
			return false;
		}
	}

	var email = document.getElementById("email").checked;
	if(email){
		var autoact_email_bt = document.relsetform.autoact_email_bt.value;
		if(autoact_email_bt ==''){
			alert("邮件标题不能为空");
			document.relsetform.autoact_email_bt.focus();
			return false;
		}
		var autoact_email_sm = document.relsetform.autoact_email_sm.value;
		if(autoact_email_sm ==''){
			alert("邮件内容不能为空");
			document.relsetform.autoact_email_sm.focus();
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
	$.ajax({  
		   type: "GET",
		   url:"index.php?module=Relsettings&action=RelsettingsAjax&file=SaveMemday&ajax=true&type="+types+"&record="+record,
		   success: function(msg){
				if(msg.indexOf('FAILED') != '-1') {
					alert("该纪念日类型已经创建过提醒模板了，请重新选择类型!");
					return false;	
				}else if(msg.indexOf('SUCCESS') != '-1'){
					document.relsetform.submit();
				}
		   }  
    });
}
function confirmdelmemday(record){
	if(confirm("请确定，是否删除？")){
		var urlstring = "index.php?module=Relsettings&action=index&relset=MemdayConfig";
		urlstring += "&relsetmode=delete&record="+record+"&del=1";
		location.href = urlstring;
	}
}
{/literal}
</script>