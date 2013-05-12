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
<tbody><tr>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
        
	

	<div align=center>
		
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}layout.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.LBL_SHOP_SERVER_SETTINGS} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_SHOP_SERVER_SETTINGS} </td>
				</tr>
				</table>
                <br>
                
                <table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading" style="margin-left:10px;">
					<tr>
						<td class="big"><strong>店铺列表</strong>&nbsp;   
                      
                        </td>
                        <td class="big" align="right"><input title="{$APP.LBL_NEW_BUTTON_LABEL}" accessKey="{$APP.LBL_NEW_BUTTON_KEY}" class="crmButton small create" onclick="CreateNew();" type="button" name="button" value="{$APP.LBL_NEW_BUTTON_LABEL}" ></td>
                    </tr>
                 </table>
                <table border=1 cellspacing=0 cellpadding=5 width=100% align="left" class="listRow small" style="margin-left:10px;">
				<tr>
                {foreach from=$HEADERS item=header }
					<td class="cellLabel">{$header}</td>
                {/foreach}
                <td class="cellLabel">工具</td>
				</tr>
                
                {foreach from=$LISTENTRIES item=entries key=shopid }
				<tr >
				 {foreach from=$entries item=data  }
                    <td >{$data}</td>
				 {/foreach}
                   <td width="15%" >
                   <a href="index.php?module=Relsettings&action=ShopConfigEdit&parenttab=Settings&shopid={$shopid}">编辑</a> | 
                   <a href='javascript:confirmdelete("index.php?module=Relsettings&action=SaveShop&parenttab=Settings&shopid={$shopid}&transferto=del")'>删除</a>
                   </td>
                </tr>
                {/foreach}
                
				</table>
                
                
			</td>
			</tr>
            <tr>
                <td style="padding-left:20px;"> <font color="#FF0000">店铺设置详解: </font> 
                <a href="http://www.crmone.cn/bbs/viewthread.php?tid=1321&page=1" target="_blank"> http://www.crmone.cn/bbs/viewthread.php?tid=1321&page=1 </a></td>
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
{literal}
<script>
function CreateNew()
{
	window.location.href="index.php?module=Relsettings&action=ShopConfigEdit&parenttab=Settings";
}
</script>
{/literal}
