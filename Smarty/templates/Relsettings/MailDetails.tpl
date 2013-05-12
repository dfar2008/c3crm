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
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody>
	<tr>
    <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%"  align="center">
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}shareaccess.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.LBL_MAIL_DETAILS} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_MAIL_DETAILS} </td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
                	<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="small" align=left>
						<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="window.history.go(-1);" type="button" name="button" value=" 返回">
						</td>
						<td class="small" align=right>
						<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="window.history.go(-1);" type="button" name="button" value=" 返回">
						</td>
					
					</tr>
					</table>
					
                    <table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow" >
                      <tr>
                        <td class="small" valign=top >
                            <table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow">
                                <tr>
                               		<td class="small" valign=top >
                                    <table width="100%"  border="0" cellspacing="0" cellpadding="5">
                                            <tr>
                                                <td width="20%" nowrap class="small cellLabel"><strong>群发主题</strong></td>
                                                <td width="80%" class="small cellText">
                                                {$maillistname}&nbsp;
                                  			    </td>
                                              </tr>
                           			       	<tr>
                                                <td width="20%" nowrap class="small cellLabel"><strong>发件人</strong></td>
                                                <td width="80%" class="small cellText">
                                    				{$from_name}&nbsp;
                                  			    </td>
                                             </tr>
                                              <tr valign="top">
                                                <td nowrap class="small cellLabel"><strong>发件人邮箱</strong></td>
                                                <td class="small cellText">
													{$from_email}&nbsp;
                                    			</td>
                                              </tr>
                                              <tr>
                                                <td nowrap class="small cellLabel"><strong>接收人及邮箱</strong></td>
                                                <td class="small cellText">
                                    			{$receiverinfo}&nbsp;
                                   			    </td>
                                           </tr>
                                           <tr>
                                                <td nowrap class="small cellLabel"><strong>邮件主题</strong></td>
                                                <td class="small cellText">
                                    			{$subject}&nbsp;
                                   			    </td>
                                           </tr>
                                           <tr>
                                                <td nowrap class="small cellLabel"><strong>邮件内容</strong></td>
                                                <td class="small cellText">
                                    			{$mailcontent}&nbsp;
                                   			    </td>
                                           </tr>
                                           <tr>
                                                <td nowrap class="small cellLabel"><strong>成功发出率</strong></td>
                                                <td class="small cellText">
                                    			{$successrate}&nbsp;
                                   			    </td>
                                           </tr>
                                            <tr>
                                                <td nowrap class="small cellLabel"><strong>查看概率</strong></td>
                                                <td class="small cellText">
                                    			{$readrate}&nbsp;
                                   			    </td>
                                           </tr>
                                            <tr>
                                                <td nowrap class="small cellLabel"><strong>发送时间</strong></td>
                                                <td class="small cellText">
                                    			{$createdtime}&nbsp;
                                   			    </td>
                                           </tr>
                                   </table>
                         </td>
                        </tr>
                    </table>
              
				</td>
				</tr>
		        </table>
	</form>
   </td>
   </tr>
</tbody>
</table>
