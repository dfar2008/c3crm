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
<td class="showPanelBg" style="padding: 10px;" valign="top" width="100%" >
    
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
    <table border=0 cellspacing=0 cellpadding=10 width=100% >
    <tr>
    <td>
        <table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						
						<td class="small" align=right>
    							<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="location.href='index.php?module=Settings&action=Liuyan'" type="button" name="button" value=" 返回 ">
						</td>
					</tr>
					</table>
					
					
               
			<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow" style="border:1px solid #999">
			<tr>
			<td class="small" valign=top >
            		<table width="100%"  border="0" cellspacing="0" cellpadding="5">
                        <tr style="height:25px;">
                            <td width="20%" nowrap class="small cellLabel"  align="right"><strong>姓名</strong></td>
                            <td width="80%" class="small cellText">
                            {$name}
			  				</td>
                        </tr>
                        <tr style="height:25px;">
                            <td width="20%" nowrap class="small cellLabel"  align="right"><strong>电话</strong></td>
                            <td width="80%" class="small cellText">
                            {$tel}
			  				</td>
                        </tr>
                        <tr style="height:25px;">
                            <td width="20%" nowrap class="small cellLabel"  align="right"><strong>留言</strong></td>
                            <td width="80%" class="small cellText">
                            {$content}
			  				</td>
                        </tr>
                        <tr style="height:25px;">
                            <td width="20%" nowrap class="small cellLabel"  align="right"><strong>是否回复</strong></td>
                            <td width="80%" class="small cellText">
                            {if $reply eq '1'}
                            	已回复
                            {else}
                            	<a href="javascript:changeReply({$ID});"><font color=red>未回复</font></a>
                            {/if}
			  				</td>
                        </tr>
                        <tr style="height:25px;">
                            <td width="20%" nowrap class="small cellLabel"  align="right"><strong>回复时间</strong></td>
                            <td width="80%" class="small cellText">
                            {$replytime}
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
<script>
{literal}
function changeReply(id){
	
	if(confirm("确认修改回复状态?")){
		location.href="index.php?module=Settings&action=DetailLiuyan&change=1&id="+id;	
	}
}
{/literal}
</script>
