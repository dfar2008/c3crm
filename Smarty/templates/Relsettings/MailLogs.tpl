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
	<li class="active"><a href="index.php?module=Relsettings&action=index&relset={$RELSET}&parenttab=Settings">{$RELSETARRAY[$RELSET]}</a> <span class="divider">/</span></li>
	<li class="active">{$RELSETTITLE}</li>
	<li class="pull-right">
		<!-- <button type="button" class="btn btn-small btn-primary" style="margin-top:-2px;"
			onclick="window.location.reload();">
			<i class="icon-refresh icon-white"></i>刷新
		</button> -->
	</li>
</ul>

{if $maillistsid neq ''}
	<table class="table table-condensed table-bordered">
		<tbody style="text-align: center;">
			<tr>
				<th style="width:150px;">编号</th>
				<td style="text-align:left;">{$maillistname}&nbsp;</td>
				<th style="width:150px;">发件人</th>
				<td style="text-align:left;">{$from_name}&nbsp;</td>
			</tr>
			<tr>
				<th style="width:150px;">邮件主题</th>
				<td style="text-align:left;">{$subject}&nbsp;</td>
				<th style="width:150px;">发件人邮箱</th>
				<td style="text-align:left;">{$from_email}&nbsp;</td>
			</tr>
			<tr>
				<th style="width:150px;">邮件内容</th>
				<td style="text-align:left;" colspan="3">{$contents}&nbsp;</td>
			</tr>
			<tr>
				<th style="width:150px;">邮件发送分析</th>
				<td style="text-align:left;" colspan="3">{$tongjihtml}&nbsp;</td>
			</tr>
		</tbody>
	</table>
{/if}
	<!--	! Search	-->
	<input type="hidden" value="{$maillistsid}"   name="maillistsid"/>
	<table class="table table-condensed">
	<tr>
		<th>接收人</th>
		<td><input type="text" value="{$receiver}" name="receiver"/></td>
		<th>接收人Email</th>
		<td><input type="text" value="{$receiver_email}" name="receiver_email"/></td>
		<th>是否成功</th>
		<td>
			<select name="flag">
				{foreach key=key item=data from=$FLAGARR}
					{if $key == $flag}
						<option value="{$key}" selected="selected">{$data}</option>
					{else}
						<option value="{$key}">{$data}</option>
					{/if}
				{/foreach}
			</select>
		</td>
		<td>
			<button type="submit" class="btn btn-small btn-success">
				<i class="icon-search icon-white"></i>搜索
			</button>
		</td> 
	</tr>
	</table>
	<!--	/ Search	-->
	<!--	! List	-->
	<table class="table table-bordered table-hover table-condensed table-striped">
		<thead>
			<tr>   
				{foreach name="listviewforeach" item=header from=$LISTHEADER}
					<th nowrap>{$header}</th>
				{/foreach}
			</tr>
		</thead>
		<tbody>
			{foreach item=entity key=entity_id from=$LISTENTITY}
				<tr>
					{foreach item=data from=$entity}	
						<td>{$data}</td>
					{/foreach}
				</tr>
			{foreachelse}
				<tr>
				<td colspan="{$countheader}" align="center">---&nbsp;无&nbsp;---</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
	<!--	/ List	-->
	<table class="table table-bordered table-hover table-condensed"><tbody>
		<tr><td colspan="15" style="margin:0px;vertical-align: center;" >
			<div class="span7 pull-left" style="margin-top:8px;">

			</div>

			<div class="span5" style="margin-top:8px;">
				<div class="pagination pagination-mini pagination-right" style="margin:0px;">
				<small style="color:#999999;">{$RECORD_COUNTS}&nbsp;</small>
				{$NAVIGATION}
				</div>
			</div>
		</td></tr>
	</table>

<input type="hidden" value="{$search_url}"   name="search_url"  id="search_url"/>

<script>
{literal}
function getListViewEntries_js(module,url)
{	
	 $("#status").prop("display","inline");
	if($('#search_url').val() !='')
		urlstring = $('#search_url').val() ;
	else
		urlstring = ''; 
	location.href="index.php?module=Relsettings&action=index&relset=MailLogs&"+url+urlstring;
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
{/literal}
</script>

