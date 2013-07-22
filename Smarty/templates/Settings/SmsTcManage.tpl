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
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<div class="accordion" id="settingion1" style="overflow:auto;height:580px;">
					{include file='Settings/SettingLeft.tpl'}
			</div>
		</div>
		<!--content start-->
		<div class="span10" style="margin-left:10px">
			<div class="page-header" style="margin-top:-10px">
				<h4 style="margin-bottom:-8px">
					<img src="{$IMAGE_PATH}ico_mobile.gif" alt="Users" width="48" height="48" border=0 title="Users">{$MOD.LBL_SMS_TC_MANAGE}
					<small>{$MOD.LBL_SMS_TC_MANAGE}</small>
				</h4>
			</div>
			<div style="margin-top:-8px">
				<div class="pull-left">
					<button type="button"  name="button" class="btn btn-small btn-primary" onclick="CreateNewTc();"/>
						<i class="icon-plus icon-white"></i> 新增套餐
					</button>
				</div>
				<div class="pull-right">
					<button type="button"  name="button" class="btn btn-small btn-inverse" onclick="window.location.reload();"/>
						<i class="icon-refresh icon-white"></i> 刷新
					</button>
				</div>
			</div><br><br>

			<div>
				 <table width=99% align="center" class="lvt small" >
                       
                       <tr>
                            {$headerhtml}
                        </tr>
                        <!-- Table Contents -->
                        {foreach item=entity key=entity_id from=$LISTENTITY}
                        
                           <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
                         
                            {foreach item=data from=$entity}	
                            <td nowrap="nowrap">{$data}</td>
                            {/foreach}
                          </tr>
                         {foreachelse}
                          <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
                            <td colspan="{$countheader}" align="center">---&nbsp;无&nbsp;---</td>
                          </tr>
                        {/foreach}
                        <tr>
                       <td nowrap width="100%" align="right" valign="middle" colspan="{$countheader}">
                            <table border=0 cellspacing=0 cellpadding=0 class="small" width="100%" align="right">
                                 <tr>
                                 <td width="70%"><font color=red><b>注:</b></font>  <b><font color=blue>A</font> : 个人用户套餐 ; <font color=blue>B</font> : 企业用户套餐</b></td>
                                 <td width="30%" style="padding-right:5px" align="right">{$RECORD_COUNTS}&nbsp;&nbsp;&nbsp;&nbsp;{$NAVIGATION}</td>
                                 </tr>
                            </table>
                        </td>
                        </tr>
                    </table>
				
			</div>



			 

		</div>
		<!--content end-->
	</div>
</div>
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<style>
{literal}
.shitu{
	color:#000;	
	font-weight:normal;
}
.shituselect{
	color:#F00; 
	font-weight:bold;
}
.lvtCol12 {
    border-color: #DDDDDD #DDDDDD #DDDDDD #DDDDDD;
    border-style: solid;
    border-width: 1px 1px 1px 1px;
    color: #333333;
    font-size: 12px;
}
{/literal}
</style>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody>
	<tr>
    <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
	
	<div align=center>
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}ico_mobile.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > {$MOD.LBL_SMS_TC_MANAGE} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_SMS_TC_MANAGE} </td>
				</tr>
				</table>
				
				<br>
                 
                         <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="small" >
                        <tr>
                        
                           <td  width="5%" align="left"><input type="button" value=" 新增套餐 " name="button" class="crmbutton small edit"onclick="CreateNewTc();"/></td> 
                           <td></td>
                        	<td  width="5%" align="right"><input type="button" value=" 刷新 " name="button" class="crmbutton small edit"onclick="window.location.reload();"/></td> 
                        </tr>
                       
                       </table>
                      
                     <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="lvt small" >
                       
                       <tr>
                            {$headerhtml}
                        </tr>
                        <!-- Table Contents -->
                        {foreach item=entity key=entity_id from=$LISTENTITY}
                        
                           <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
                         
                            {foreach item=data from=$entity}	
                            <td nowrap="nowrap">{$data}</td>
                            {/foreach}
                          </tr>
                         {foreachelse}
                          <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
                            <td colspan="{$countheader}" align="center">---&nbsp;无&nbsp;---</td>
                          </tr>
                        {/foreach}
                        <tr>
                       <td nowrap width="100%" align="right" valign="middle" colspan="{$countheader}">
                            <table border=0 cellspacing=0 cellpadding=0 class="small" width="100%" align="right">
                                 <tr>
                                 <td width="70%"><font color=red><b>注:</b></font>  <b><font color=blue>A</font> : 个人用户套餐 ; <font color=blue>B</font> : 企业用户套餐</b></td>
                                 <td width="30%" style="padding-right:5px" align="right">{$RECORD_COUNTS}&nbsp;&nbsp;&nbsp;&nbsp;{$NAVIGATION}</td>
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
	
</td>
   </tr>
</tbody>
</table>
<input type="hidden" value="{$search_url}" id="search_url"  name="search_url"/>
<script>
var type = "{$type}";
{literal}
// create new smstc
function CreateNewTc(){
	location.href="index.php?module=Settings&action=SmsTcManageEdit";
}

function getOrderBy(theorderbystr){
	getListViewEntries_js("Settings",theorderbystr);
} 
function getListViewEntries_js(module,url)
{	
	$("status").style.display="inline";
	if($('search_url').value!='')
		urlstring = $('search_url').value;
	else
		urlstring = '';
	
	location.href="index.php?module=Settings&action=SmsTcManage&"+url+urlstring;
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

