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

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
	<tr>
    <td class="showPanelBg"  valign="top" width="100%">
	
	<div align=center>
    			<table class="small" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <tr style="background:#DFEBEF;height:27px;">
                <td class="moduleName" nowrap="" style="padding-left:10px;padding-right:50px">
                <a class="hdrLink" href="index.php?action=ListView&module=Maillists">群发邮件</a>
                &gt;&gt;
                群发统计
                </td>
                </tr>
                <tr>
                </tbody>
                </table>
				
                 <form name="searchuser" action="index.php" method="post">
                    <input type="hidden" name="module" value="Relsettings">
					<input type="hidden" name="action" value="Maillists">
                	   <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="small">
                		<tr>
							<td  width="5%" nowrap="nowrap">邮件主题：</td> 
                            <td  width="10%"><input type="text" value="{$subject}" name="subject"/></td>
                            <td  width="5%" nowrap="nowrap">发件人：</td> 
                            <td  width="10%"><input type="text" value="{$from_name}" name="from_name"/></td>
                            <td  width="5%" nowrap="nowrap">发件人邮箱：</td> 
                            <td  width="10%"><input type="text" value="{$from_email}" name="from_email"/></td>
                            <td   align="left"><input type="submit" value=" 搜索 " name="submit" class="crmbutton small edit"/></td> 
                            <td  width="5%" align="right"><input type="button" value=" 刷新 " name="button" class="crmbutton small edit"onclick="getListViewEntries_js();"/></td> 
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
<input type="hidden" value="{$order_url}" id="order_url"  name="order_url"/>
<input type="hidden" value="{$search_url}" id="search_url"  name="search_url"/>
{literal}
<script>
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
	
	location.href="index.php?module=Relsettings&action=Maillists&"+url+urlstring;
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
	location.href="index.php?module=Relsettings&action=Maillists&"+url+urlstring+order_url;
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
