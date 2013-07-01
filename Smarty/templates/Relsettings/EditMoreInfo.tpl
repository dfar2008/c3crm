<!--	Setting Contact		-->
<ul class="breadcrumb">
	<li><a href="#">{$RELSETHEAD}</a> <span class="divider">/</span></li>
	<li class="active"><a href="index.php?module=Relsettings&action=index&relset={$RELSET}&parenttab=Settings">{$RELSETARRAY[$RELSET]}</a> <span class="divider">/</span></li>
	<li class="active">{$RELSETTITLE}</li>
	<li class="pull-right">
		{if $RELSETMODE == 'edit'}
			<button type="button" class="btn btn-small btn-success" style="margin-top:-2px;"
				 onclick="check();">
				<i class="icon-ok icon-white"></i>{$APP.LBL_SAVE_LABEL}
			</button>
		{else}
			<button type="button" class="btn btn-small btn-primary" style="margin-top:-2px;"
				onclick="this.form.relsetmode.value='edit';this.form.submit();">
				<i class="icon-edit icon-white"></i>{$APP.LBL_EDIT_BUTTON_LABEL}
			</button>
		{/if}
	</li>
</ul>

{if $RELSETMODE == 'edit'}
	<input type="hidden" name="user_name" value="{$user_name}">
    <input type="hidden" name="record" value="{$record}">
    <input type="hidden" name="mode" value="{$mode}">
	<table class="table table-condensed table-bordered">
		<tbody style="text-align: center;">
		  <tr>
			<th style="width:150px;">姓名</th>
			<td style="text-align:left;">
				<input type="text" value="{$last_name}" name="last_name">
			</td>
		  </tr><tr>
			<th style="width:150px;">Email</th>
			<td style="text-align:left;">
				{if $readonly eq 'readonly'}
					{$email1}
					<input  type="hidden" value="{$email1}" name="email1"  />
				{else}
					 <input  type="text" value="{$email1}" name="email1"  />
				{/if}
			</td>
		  </tr><tr>
			<th style="width:150px;">手机</th>
			<td style="text-align:left;">
				<input  type="text" value="{$phone_mobile}" name="phone_mobile">
			</td>
		  </tr>
		</tbody>
	</table>
{else}
	<table class="table table-condensed table-bordered">
		<tbody style="text-align: center;">
		  <tr>
			<th style="width:150px;">姓名</th>
			<td style="text-align:left;">{$last_name}</td>
		  </tr><tr>
			<th style="width:150px;">Email</th>
			<td style="text-align:left;">{$email1}</td>
		  </tr><tr>
			<th style="width:150px;">手机</th>
			<td style="text-align:left;">{$phone_mobile}</td>
		  </tr>
		</tbody>
	</table>
{/if}

<script>
{literal}
function check()
{	
	if (document.relsetform.email1.value == '') {
		alert('Email不能为空');
		document.relsetform.email1.focus();
		return false;
	}
	var mobile = /^0?(13[0-9]|15[012356789]|18[0236789]|14[57])[0-9]{8}$/; 
	var phone_mobile = document.relsetform.phone_mobile.value;
	if (!mobile.test(phone_mobile)) {
		alert('手机格式不正确');
		document.relsetform.phone_mobile.focus();
		return false;
	}
	var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	var email1 = document.relsetform.email1.value;
	if (!reg.test(email1)) {
		alert('Email格式不正确');
		document.relsetform.email1.focus();
		return false;
	}
	$.ajax({  
		   type: "GET",
		   url:"index.php?module=Relsettings&action=RelsettingsAjax&file=EditMoreInfo&ajax=true&email1="+email1+"&phone_mobile="+phone_mobile,
		   success: function(msg){
				if(msg.indexOf('FAILEDPHONE') != '-1') {
					alert("手机重复!");
					document.relsetform.phone_mobile.focus();
					return false;	
				}else if(msg.indexOf('FAILEDEMAIL') != '-1') {
					alert("Email重复!");
					document.relsetform.email1.focus();
					return false;	
				}else if(msg.indexOf('SUCCESS') != '-1'){
					document.relsetform.action.value = "SaveMoreInfo";
					document.relsetform.submit();
				}
		   }  
    });
}
{/literal}
</script>