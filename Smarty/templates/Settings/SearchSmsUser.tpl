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
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > {$MOD.LBL_SMS_USER} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_SMS_USER} </td>
				</tr>
				</table>
				
				<br>
                <form name="searchuser" action="index.php" method="post">
                    <input type="hidden" name="module" value="Settings">
					<input type="hidden" name="action" value="SearchSmsUser">
                	   <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="small">
                		<tr>
                            <td  width="5%">用户名:</td> 
                            <td  width="10%"><input type="text" value="{$user_name}" name="user_name"/></td>
                            <td  width="5%" align="center">姓名:</td> 
                            <td width="10%"><input type="text" value="{$last_name}" name="last_name"/></td>
                            <td  width="5%"><input type="submit" value=" 搜索用户 " name="submit" class="crmbutton small edit"/></td> 
                            <td>
                            <input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="location.href='index.php?module=Settings&action=SmsUser'"  type="button" name="button" value=" 返回 ">
                            </td>
                        </tr>
                       </table>
             
                     <table border=0 cellspacing=1 cellpadding=3 width=98% align="center" class="lvt small" >
                       
                       <tr>
                            {foreach name="listviewforeach" item=header from=$LISTHEADER}
                                <td class="lvtCol">{$header}</td>
                            {/foreach}
                        </tr>
                        <!-- Table Contents -->
                        {foreach item=entity key=entity_id from=$LISTENTITY}
                           <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
                            {foreach item=data from=$entity}	
                            <td>{$data}</td>
                            {/foreach}
                          </tr>
                          {foreachelse}
                          <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
                            <td colspan="{$countheader}" align="center">---&nbsp;无&nbsp;---</td>
                          </tr>
                        {/foreach}
                        <tr>
                           <td nowrap width="100%" align="right" valign="middle" colspan="{$countheader}">
                            <table border=0 cellspacing=0 cellpadding=0 class="small">
                                 <tr><td style="padding-right:5px">{$RECORD_COUNTS}&nbsp;&nbsp;&nbsp;&nbsp;{$NAVIGATION}</td></tr>
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
{literal}
<script>
function getListViewEntries_js(module,url)
{	
	$("status").style.display="inline";
	if($('search_url').value!='')
		urlstring = $('search_url').value;
	else
		urlstring = '';
	location.href="index.php?module=Settings&action=SearchSmsUser&"+url+urlstring;
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
