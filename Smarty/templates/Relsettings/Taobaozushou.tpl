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
                <font color="#CC6699"><input value="{$tp}" size="2" name="tp"/> </font>天提醒。( 0 或 不填 即为纪念日当天提醒。)
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
				<input type="edit" value="{$autoact_email_bt}" size="50" name="autoact_email_bt"/><br/>　　　　
				
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
<input type="hidden" name="record" id="record" value="{$current_id}" />
<table class="table table-condensed table-bordered table-hover">
	<thead>
	  <tr>
		{foreach name="listviewforeach" item=header from=$APPHEAD}
			<th>{$header}</th>
		{/foreach}
	  </tr>
	</thead>
	<tbody style="text-align: center;">
		{foreach item=entity key=entity_id from=$LIST_ENTRIES}
			<tr>
				{foreach item=data from=$entity}	
					<td>{$data}</td>
				{/foreach}
			</tr>
		{foreachelse}
			<tr>
			<td colspan="{$counthead}" align="center" height="30">--无--</td>
			</tr>
		{/foreach}
	</tbody>
</table>
<table class="table">
	<tr>
		<td colspan="{$counthead}">
			当前启用店铺appKey与appSecret
		</td>
	</tr>
	<tr>
		<td colspan="{$counthead}">
			{if $current_id neq ''}
				appKey:{$current_appkey}<br>
				appSecret:{$current_appsecret}
			{else}
				{$noselect}
			{/if}
		</td>
	</tr>
	<tr>
		<td colspan="{$counthead}">
			同步最近三个月内交易完成的订单：
			<button type="button" class="btn btn-small btn-info" style="margin-top:-2px;"
			 onclick="beginsyn();">
				<i class="icon-share icon-white"></i>开 始 同 步
			</button>
		</td>
	</tr>
	<tr>
		<td colspan="{$counthead}">
			帮助：
			<a href="http://www.crmone.cn/bbs/forum.php?mod=viewthread&tid=1321&extra=page%3D1" 
			target="_blank">如何增加淘宝店铺应用？</a>
		</td>
	</tr>
	<tr>
		<td colspan="{$counthead}">
			导入三个月前的客户及订单信息：
			<button type="button" class="btn btn-small btn-success" style="margin-top:-2px;"
					onclick="acctimport();">
				<i class="icon-download icon-white"></i>导 入
			</button>
		</td>
	</tr>
</table>

<script>
{/if}
{literal}
function beginsyn(){
	var  current_id = document.getElementById("record").value;
	if(current_id == ''){
		alert("你尚未启用一个店铺!");
		return false;
	}else{
		var t = confirm("确认同步三个月内的订单?");
		if(t){
			document.relsetform.module.value = 'Synchronous';
			document.relsetform.action.value = 'SynIn';
			var issubmit = document.relsetform.issubmit;
			if(issubmit.value == "1"){
				issubmit.value = "2";
				document.relsetform.submit();
			}
		}else{
			return false;
		}
	}
}
function acctimport(){
	document.relsetform.module.value = 'Accounts';
	document.relsetform.action.value = 'Import2';
	var issubmit = document.relsetform.issubmit;
	if(issubmit.value == "1"){
		issubmit.value = "2";
		document.relsetform.submit();
	}
}
{/literal}
</script>