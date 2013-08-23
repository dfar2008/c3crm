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
-->*}<!--
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>-->
<ul class="breadcrumb" style="margin-bottom:3px">
	<li><a href="#">{$RELSETHEAD}</a> <span class="divider">/</span></li>
	<li class="active"><a href="index.php?module=Relsettings&action=index&relset={$RELSET}&parenttab=Settings">{$RELSETARRAY[$RELSET]}</a> <span class="divider">/</span></li>
	<li class="active">{$RELSETTITLE}</li>
</ul>
<!--<input type="hidden" name="action" value="SmsLogs">-->
<input type="hidden" value="{$search_url}" id="search_url"  name="search_url"/>
<table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="small">
	<tr>
		<td  width="5%"  nowrap="nowrap">接收人：</td> 
		<td  width="10%"><input type="text" value="{$receiver}" name="receiver"/></td>
		<td  width="5%"  nowrap="nowrap">接收人手机：</td> 
		<td  width="10%" ><input type="text" value="{$receiver_phone}" name="receiver_phone"/></td>
		<td  width="5%"  nowrap="nowrap">是否成功：</td>
		<td  width="10%">
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
		<td   align="left">
			<button type="button" name="button" class="btn btn-small btn-success" onclick="searchsms()" >
				<i class="icon-search icon-white"></i> 搜索
			</button>
			&nbsp;
			<button class="btn btn-small btn-primary" type="button" onclick="getListViewEntries_js()">
			<i class="icon-refresh icon-white"></i> 刷新
			</button>
		</td> 
	</tr>
</table>
 <table  width=99% align="center" class="table table-striped table-hover table-bordered table-condensed">
	<thead>
	   <tr>
		{foreach name="listviewforeach" item=header from=$LISTHEADER}
			<th>{$header}</th>
		{/foreach}
		</tr>
	</thead>
	<tbody>
		<!-- Table Contents -->
		{foreach item=entity key=entity_id from=$LISTENTITY}
		   <tr id="row_{$entity_id}">
			{foreach item=data from=$entity}	
			<td>{$data}</td>
			{/foreach}
		  </tr>
		 {foreachelse}
		  <tr id="row_{$entity_id}">
			<td colspan="{$countheader}" align="center">---&nbsp;无&nbsp;---</td>
		  </tr>
		{/foreach}
		<tr>
			<td width="100%"  align="right" valign="middle" colspan="{$countheader}">	
				<div class="pagination pagination-mini pagination-right" style="margin: 0">{$RECORD_COUNTS}&nbsp;&nbsp;&nbsp;{$NAVIGATION}</div>
			</td>
		</tr>
	</tbody>
</table>

{literal}
<script>
function searchsms(){
	//document.relsetform.action.value = "SmsLogs";
	document.relsetform.submit();
}
function getListViewEntries_js(module,url)
{	
	$("#status").css("display","inline");
	if($('#search_url').val()!='')
		urlstring = $('#search_url').val();
	else
		urlstring = '';
	location.href="index.php?module=Relsettings&action=index&relset=SmsLogs&"+url+urlstring;
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
</script>
{/literal}
