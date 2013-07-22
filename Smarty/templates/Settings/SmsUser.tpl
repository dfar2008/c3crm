<link rel="stylesheet" type="text/css" href="themes/bootcss/css/Setting.css">
<div class="container-fluid" style="height:602px;">
	   <!--Dashboad-->
	<div class="container-fluid" style="height:602px;">
		<div class="row-fluid">
			<div class="span2" style="margin-left:-10px;">
				<div class="accordion" id="settingion1" style="overflow:auto;height:580px;">
					{include file='Settings/SettingLeft.tpl'}
				</div>
			</div>

			<div class="span10" style="margin-left:10px;">
				<form action="index.php" method="post" name="settingform" id="settingform">
					<input type="hidden" name="module" value="Settings">
					<input type="hidden" name="action">
					<input type="hidden" name="parenttab" value="Settings">
					<!--<input type="hidden" name="settype" value="{$SETTYPE}">
					<input type="hidden" name="settingmode" value="{$SETTINGMODE}">-->
					<input type="hidden" name="issubmit" value="1">
							<!--	Setting		-->
					<div class="row-fluid box" style="height:602px">
						<div class="tab-header">系统用户</div>
						  <div class="padded" style="overflow:auto;height:520px;">
							<!--	搜索	-->
							<table class="table-condensed" style="margin-bottom:8px;width:100%" >
								<tr>
									<td class="pull-left"> 
										<input class="search-query" type="text" value="{$user_name}" name="user_name"  size="18" style="border:1px solid #bababa;" placeholder="用户名/姓名/手机/Email" tabindex="13"/>
										<button type="submit" class="btn btn-small btn-success">
											<i class="icon-search icon-white"></i> 搜索
										</button>
									</td>
									<td class="pull-right">
										<button type="button" class="btn btn-small btn-primary " onclick="document.location.href='index.php?module=Settings&action=CreateMoreInfo'">
											<i class="icon-plus icon-white"></i> 新增用户
										</button>
									</td>
								</tr>
							</table>

							<table class="table table-condensed table-bordered table-hover">
								<thead>
									<tr>
										<th>
											<input type="checkbox"  name="selectall"   onClick=toggleSelect(this.checked,"selected_id")>
										</th>
										{$headerhtml}
									</tr>
								</thead>
								<tbody style="text-align: center;">
									{foreach item=entity key=entity_id from=$LISTENTITY}
										<tr id="row_{$entity_id}">
											<td width="2%">
												<input type="checkbox" NAME="selected_id" value= '{$entity_id}' 
												onClick=toggleSelectAll(this.name,"selectall")>
											</td>
											{foreach item=data from=$entity}
												<td>{$data}</td>
											{/foreach}
										</tr>
									{foreachelse}
										<tr id="row_{$entity_id}">
											<td colspan="{$countheader+1}" align="center">---&nbsp;无&nbsp;---</td>
										</tr>
									{/foreach}
								</tbody>
							</table>

							<input type="hidden" value="{$order_url}" id="order_url"  name="order_url"/>
							<input type="hidden" value="{$search_url}" id="search_url"  name="search_url"/>
						</div>
					</div>
						
					</div>
					<!--	/Setting	-->
				</form>
			</div>
	</div></div>
</div>
<script>
var type = "{$type}";
{literal}
function confirmDel(id){
	if(confirm("确认删除用户?")){
		document.location.href="index.php?module=Settings&action=SmsUserDelete&t=del&userid="+id;
	}else{	
		return false;
	}
}
function onoffUser(id,type){
	if(type=="on"){
		if(confirm("确定启用用户?")){
			document.location.href="index.php?module=Settings&action=SmsUserDelete&t=on&userid="+id;
		}else{
			return false;
		}
	}else{
		if(confirm("确定禁用用户?")){
			document.location.href="index.php?module=Settings&action=SmsUserDelete&t=off&userid="+id;
		}else{
			return false;
		}
	}
	
}
function getOrderBy(theorderbystr){
	getListViewEntries_js_2("Settings",theorderbystr);
} 
function getListViewEntries_js_2(module,url)
{	
	$("status").style.display="inline";
	if($('search_url').value!='')
		urlstring = $('search_url').value;
	else
		urlstring = '';
	
	location.href="index.php?module=Settings&action=SmsUser&"+url+urlstring;
}
function getListViewEntries_js(module,url)
{	
	$("status").style.display="inline";
	if($('search_url').value!='')
		urlstring = $('search_url').value;
	else
		urlstring = '';
		
	if($('order_url').value!='')
		order_url = $('order_url').value;
	else
		order_url = '';
	
	location.href="index.php?module=Settings&action=SmsUser&"+url+urlstring+order_url;
}
function getListViewWithPageNo(module,pageElement)
{
	//var pageno = document.getElementById('listviewpage').value;
	var pageno = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'start='+pageno);
}
function getListViewWithPageSize(module,pageElement)
{
	var pagesize = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'pagesize='+pagesize);
} 
window.onload = function(){
	if(type !=''){
	  document.getElementById(type).className = 'shituselect';
	}
}
function SendMail(){
	var select_options  =  document.getElementsByName('selected_id');
	var x = select_options.length;
	idstring = "";

	xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			idstring = select_options[i].value +";"+idstring
			xx++
		}
	}
	if (xx != 0)
	{
		location.href='index.php?module=Maillists&action=ListView&useridstr='+idstring;
	}
	else
	{
		alert("Error");
		return false;
	}
}
function SendSms(){
	var select_options  =  document.getElementsByName('selected_id');
	var x = select_options.length;
	idstring = "";

	xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			idstring = select_options[i].value +";"+idstring
			xx++
		}
	}
	if (xx != 0)
	{
		location.href='index.php?module=Qunfas&action=ListView&useridstr='+idstring;
	}
	else
	{
		alert("Error");
		return false;
	}
}
{/literal}
</script>

