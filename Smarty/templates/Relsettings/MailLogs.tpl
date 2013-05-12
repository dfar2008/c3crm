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
                <a class="hdrLink" href="index.php?action=Maillists&module=Relsettings">群发统计</a>
                &gt;&gt;
                <a class="hdrLink" href="index.php?action=MailLogs&module=Relsettings">邮件日志</a>
                </td>
                </tr>
                <tr>
                </tbody>
                </table>
				
                {if $maillistsid neq ''}
                <table width="99%"  border="0" cellspacing="0" cellpadding="5" style="margin-top:10px;border:1px solid #ECECEC;margin-bottom:5px;" >
                       <tr style="height:25px;">
                        	<td class="dvInnerHeader" colspan="4">
                       		 <b>基本信息</b>
                       		 </td>
                        </tr>
                        <tr>
                            <td width="20%" nowrap class="dvtCellLabel small">编号
                            </td>
                            <td width="30%" class="small cellText">
                            {$maillistname}&nbsp;
                            </td>
                            <td width="20%" nowrap class="small dvtCellLabel">发件人</td>
                            <td width="30%" class="small cellText">
                                {$from_name}&nbsp;
                            </td>
                          </tr>
                        <tr>
                            <td nowrap class="small dvtCellLabel">邮件主题</td>
                            <td class="small cellText">
                            {$subject}&nbsp;
                            </td>
                             <td nowrap class="small dvtCellLabel">发件人邮箱</td>
                            <td class="small cellText">
                                {$from_email}&nbsp;
                            </td>
                         </tr>
                        <!--<tr>
                            <td nowrap class="small dvtCellLabel">接收人及邮箱</td>
                            <td class="small cellText" colspan="3"  >
                             <div style="width:900px;">{$receiverinfo}&nbsp;</div>
                            </td>
                       </tr>-->
                       <tr>
                            <td nowrap class="small dvtCellLabel">邮件内容</td>
                            <td class="small cellText" colspan="3">
                            {$contents}&nbsp;
                            </td>
                       </tr>
                       <tr>
                            <td nowrap class="small dvtCellLabel">邮件发送分析 </strong></td>
                            <td class="small cellText" colspan="3">
                               {$tongjihtml}
                            </td>
                       </tr>
                    
               </table>
            {/if}
                 <form name="searchuser" action="index.php" method="post">
                    <input type="hidden" name="module" value="Relsettings">
					<input type="hidden" name="action" value="MailLogs">
                    <input type="hidden" value="{$maillistsid}"   name="maillistsid"/>
                	   <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="small" style="border:1px solid #ECECEC;">
                		<tr>
                        	 <td  width="4%" nowrap="nowrap"><font color="#FF0000"><b>搜索:</b></font></td> 
                            <td  width="5%" nowrap="nowrap">接收人：</td> 
                            <td  width="10%"><input type="text" value="{$receiver}" name="receiver"/></td>
                            <td  width="5%" nowrap="nowrap">接收人Email：</td> 
                            <td  width="10%"><input type="text" value="{$receiver_email}" name="receiver_email"/></td>
                             <td  width="5%" align="center"  nowrap="nowrap">是否成功：</td>
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
                            <td   align="left"><input type="submit" value=" 搜索 " name="submit" class="crmbutton small edit"/></td> 
                            <td  width="15%" align="right">
                            <input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="window.history.go(-1);" type="button" name="button" value=" 返回">
                            <input type="button" value=" 刷新 " name="button" class="crmbutton small edit" onclick="getListViewEntries_js('Relsettings','');"/></td> 
                        </tr>
                       </table>
                      
                     <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="lvt small" >
                      {if $maillistsid neq ''}
                       <tr style="height:25px;">
                        	<td class="dvInnerHeader"  colspan="{$countheader}">
                       		 <b>详细日志列表</b>
                       		 </td>
                        </tr>
                      {/if}
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
   <input type="hidden" value="{$search_url}"   name="search_url"  id="search_url"/>
{literal}
<script>
function getListViewEntries_js(module,url)
{	
	$("status").style.display="inline";
	if($('search_url').value!='')
		urlstring = $('search_url').value;
	else
		urlstring = '';
	
	location.href="index.php?module=Relsettings&action=MailLogs&"+url+urlstring;
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
