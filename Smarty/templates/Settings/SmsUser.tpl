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
<ul class="breadcrumb">
	<li><a href="#">{$RELSETHEAD}</a> <span class="divider">/</span></li>
	<li class="active"><a href="index.php?module=Settings&action=index&settype={$SETTYPE}&parenttab=Settings">{$SETTYPEARRAY[$SETTYPE]}</a> <span class="divider">/</span></li>
	<li class="active">{$RELSETTITLE}</li>
	<li class="pull-right">
		<!-- <button type="button" class="btn btn-small btn-primary" style="margin-top:-2px;"
			onclick="window.location.reload();">
			<i class="icon-refresh icon-white"></i>刷新
		</button> -->
	</li>
</ul>
<!--	视图	-->
<div>
  <ul class="nav nav-pills" style="margin-bottom:5px;">
	<li class="nav-header" style="padding-left:0px;padding-right:5px;">
	  <i class="icon-th-list"></i>
	</li>
	<li class="active"><a href="#">所有</a></li>
	<li><a href="#">未验证</a></li>
	<li><a href="#">未购买过</a></li>
	<li><a href="#">充值少于5次</a></li>
	<li><a href="#">充值大于10次</a></li>
	<li><a href="#">已到期</a></li>
	<li><a href="#">今日到期</a></li>
	<li><a href="#">一周内到期</a></li>
	<li><a href="#">今日注册</a></li>
	<li><a href="#">7天内注册</a></li>
  </ul>
</div>

<!--	搜索	-->
<table class="table table-condensed">
	<tr>
		<th>用户名</th>
		<td>
			<input type="text" value="{$user_name}" name="user_name"  size="18" style="border:1px solid #bababa;" tabindex="13"/>
		</td>
		<th>姓名</th>
		<td>
			<input type="text" value="{$last_name}" name="last_name"  size="13" style="border:1px solid #bababa;" tabindex="13"/>
		</td>
		<th>手机</th>
		<td>
			<input type="text" value="{$phone_mobile}" name="phone_mobile"  size="13" style="border:1px solid #bababa;" tabindex="13"/>
		</td>
		<th>Email</th>
		<td>
			<input type="text" value="{$email1}" name="email1"  size="13" style="border:1px solid #bababa;" tabindex="13"/>
		</td>
		<td>
			<button type="submit" class="btn btn-small btn-success">
				<i class="icon-search icon-white"></i>搜索
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
<script>
var type = "{$type}";
{literal}
function confirmDel(id){
	if(confirm("确认禁用用户?")){
		document.location.href="index.php?module=Settings&action=SmsUserDelete&userid="+id;
	}else{	
		return false;
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

