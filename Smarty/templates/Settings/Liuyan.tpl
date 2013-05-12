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
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > {$MOD.LBL_LIUYAN_LIST} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_LIUYAN_LIST} </td>
				</tr>
				</table>
				
				<br>
                 <form name="searchuser" action="index.php" method="post">
                    <input type="hidden" name="module" value="Settings">
					<input type="hidden" name="action" value="Liuyan">
                	   
                         <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="small" >
                        <tr>
                        	<td  width="5%" align="left" nowrap="nowrap"> <font color="#FF0000"><b>搜索:</b></font></td>
                            <td  width="5%" align="left" nowrap="nowrap">姓名：</td> 
                            <td  width="10%" align="left"><input type="text" value="{$name}" name="name"  size="15" style="border:1px solid #bababa;" tabindex="13"/></td>
							<td  width="5%" align="right" nowrap="nowrap">电话：</td> 
                            <td  width="10%"><input type="text" value="{$tel}" name="tel"  size="18" style="border:1px solid #bababa;" tabindex="13"/></td>
							<td  width="5%" align="right" nowrap="nowrap">留言：</td> 
                            <td  width="20%"><input type="text" value="{$content}" name="content"  size="33" style="border:1px solid #bababa;" tabindex="13"/></td>
                            <td  align="left"><input type="submit" value=" 搜索 " name="submit" class="crmbutton small edit"/></td> 
                        	<td  width="5%" align="right"><input type="button" value=" 刷新 " name="button" class="crmbutton small edit"onclick="getListViewEntries_js();"/></td> 
                        </tr>
                       
                       </table>
                      
                     <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="lvt small" >
                       
                       <tr>
                        <td class="lvtCol"><input type="checkbox"  name="selectall"   onClick=toggleSelect(this.checked,"selected_id")></td>
                            {$headerhtml}
                        </tr>
                        <!-- Table Contents -->
                        {foreach item=entity key=entity_id from=$LISTENTITY}
                        
                           <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
                           <td width="2%"><input type="checkbox" NAME="selected_id" value= '{$entity_id}' onClick=toggleSelectAll(this.name,"selectall")></td>
                            {foreach item=data from=$entity}	
                            <td nowrap="nowrap">{$data}</td>
                            {/foreach}
                          </tr>
                         {foreachelse}
                          <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
                            <td colspan="{$countheader+1}" align="center">---&nbsp;无&nbsp;---</td>
                          </tr>
                        {/foreach}
                        <tr>
                        
                       
                       <td nowrap width="100%" align="right" valign="middle" colspan="{$countheader+1}">
                            <table border=0 cellspacing=0 cellpadding=0 class="small">
                                 <tr><td style="padding-right:5px">{$RECORD_COUNTS}&nbsp;&nbsp;&nbsp;&nbsp;{$NAVIGATION}</td></tr>
                            </table>
                        </td>
                        </tr>
                    </table>
                   </form>
					
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
{literal}

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
	
	location.href="index.php?module=Settings&action=Liuyan&"+url+urlstring;
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
function changeReply(id){
	if($('search_url').value!='')
		urlstring = $('search_url').value;
	else
		urlstring = '';
	if(confirm("确认修改回复状态?")){
		location.href="index.php?module=Settings&action=Liuyan&change=1&id="+id+urlstring;	
	}
}

{/literal}
</script>

