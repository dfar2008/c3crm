<!--	Setting Contact		-->
<ul class="breadcrumb">
	<li><a href="#">{$RELSETHEAD}</a> <span class="divider">/</span></li>
	<li class="active"><a href="index.php?module=Relsettings&action=index&relset={$RELSET}&parenttab=Settings">{$RELSETARRAY[$RELSET]}</a> <span class="divider">/</span></li>
	<li class="active">{$RELSETTITLE}</li>
	<li class="pull-right">
		{if $RELSETMODE == 'edit'}
			<button type="button" class="btn btn-small btn-success" style="margin-top:-2px;"
			onclick="save_mail_server();">
			<i class="icon-ok icon-white"></i>{$APP.LBL_SAVE_LABEL}
		</button>
		{else}
			<button type="button" class="btn btn-small btn-primary" style="margin-top:-2px;"
				onclick="this.form.relsetmode.value='edit';this.form.submit()">
				<i class="icon-edit icon-white"></i>{$APP.LBL_EDIT_BUTTON}
			</button>
		{/if}
	</li>
</ul>
{if $RELSETMODE == 'edit'}
	<input type="hidden" name="server_type" value="email">
	<table class="table table-condensed table-bordered table-hover">
		<tbody style="text-align: center;">
		  <tr>
			<th style="width:150px;">{$MOD.LBL_OUTGOING_MAIL_SERVER}</th>
			<td style="text-align:left;">
				<input type="text" class="detailedViewTextBox small" value="{$MAILSERVER}" name="server">
			</td>
		  </tr><tr>
			<th style="width:150px;">{$MOD.LBL_OUTGOING_MAIL_SERVER_PORT}</th>
			<td style="text-align:left;">
				<input type="text" class="detailedViewTextBox small" value="{$MAILSERVER_PORT}" name="port">
			</td>
		</tr><tr>
			<th style="width:150px;">{$MOD.LBL_USERNAME}</th>
			<td style="text-align:left;">
				<input type="text" class="detailedViewTextBox small" value="{$USERNAME}" name="server_username">
			</td>
		</tr><tr>
			<th style="width:150px;">{$MOD.LBL_PASWRD}</th>
			<td style="text-align:left;">
				<input type="password" class="detailedViewTextBox small" value="{$PASSWORD}" name="server_password">
			</td>
		</tr><tr>
			<th style="width:150px;">{$MOD.LBL_REQUIRES_AUTHENT}</th>
			<td style="text-align:left;">
				<input type="checkbox" name="smtp_auth" {$SMTP_AUTH}/>
			</td>
		</tr><tr>
			<th style="width:150px;">{$MOD.LBL_MAILSENDPERSON}</th>
			<td style="text-align:left;">
				<input type="text" class="detailedViewTextBox small" value="{$FROMNAME}" name="from_name">
			</td>
		</tr><tr>
			<th style="width:150px;">{$MOD.LBL_MAILSENDMAIL}</th>
			<td style="text-align:left;">
				<input type="text" class="detailedViewTextBox small" value="{$FROMEMAIL}" name="from_email">
			</td>
		</tr><tr>
			<th style="width:150px;">发送间隔</th>
			<td style="text-align:left;">
				{$intervaloptions} （秒）
			</td>
		  </tr>
		</tbody>
	</table>
{else}
	<table class="table table-condensed table-bordered table-hover">
		<thead>
		  <tr>  
			<th>{$MOD.LBL_OUTGOING_MAIL_SERVER}</th>
			<th>{$MOD.LBL_OUTGOING_MAIL_SERVER_PORT}</th>
			<th>{$MOD.LBL_USERNAME}</th>
			<th>{$MOD.LBL_PASWRD}</th>
			<th>{$MOD.LBL_REQUIRES_AUTHENT}</th>
			<th>{$MOD.LBL_MAILSENDPERSON}</th>
			<th>{$MOD.LBL_MAILSENDMAIL}</th>
			<th>发送间隔</th>
		  </tr>
		</thead>
		<tbody style="text-align: center;">
		  <tr>  
			<td>{$MAILSERVER}&nbsp;</td>
			<td>{$MAILSERVER_PORT}</td>
			<td>{$USERNAME}</td>
			<td>{$PASSWORD}</td>
			<td>{$SMTP_AUTH}</td>
			<td>{$FROMNAME}</td>
			<td>{$FROMEMAIL}</td>
			<td>{$INTERVAL}</td>
		  </tr>
		</tbody>
	</table>
{/if}
<script>
{literal}
function save_mail_server(){
	var server = document.relsetform.server;
	if(server.value == ''){
		alert("服务器名称不能为空")
		return false;
	}
	var issubmit = document.relsetform.issubmit;
	if(issubmit.value == "1"){
		issubmit.value = "2";
		document.relsetform.action.value = "Save";
		document.relsetform.submit();
	}
}
{/literal}
</script>