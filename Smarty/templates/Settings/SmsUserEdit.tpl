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
    
<form action="index.php" method="post" name="SmsUser" id="form" >
<input type="hidden" name="module" value="Settings">
<input type="hidden" name="action">
<input type="hidden" name="userid" value="{$userid}">
<input type="hidden" name="mode" value="{$mode}">
<input type="hidden" name="parenttab" value="Settings">
<input type="hidden" name="return_module" value="Settings">
<input type="hidden" name="return_action" value="SmsUser">
<input type="hidden" name="endtime" value="{$endtime}">
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
    <table border=0 cellspacing=0 cellpadding=10 width=100% >
    <tr>
    <td>
        <table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						
						<td class="small" align=right>
							<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='SaveSmsUser';" type="submit" name="submit" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >&nbsp;&nbsp;
    							<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="goback();" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
						</td>
					</tr>
					</table>
					
					
                <table width="100%"  border="0" cellspacing="0" cellpadding="5" class="small" style="border:1px solid #999">
                         <tr>
                              <td><font color=red><b>当前系统信息:</b></font></td>
                              <td>充值次数:&nbsp;&nbsp;<font color=blue><b>{$chargenum}</b></font></td>
                              <td>最新充值时间:&nbsp;&nbsp;<font color=blue><b>{$chargetime}</b></font></td>
                              <td>最新充值金额:&nbsp;&nbsp;<font color=blue><b>{$chargefee}</b>（元）</font></td>
                              <td>到期时间:&nbsp;&nbsp;<font color=red><b>{$endtime}</b></font></td>
                         </tr>
                </table>
                
                <br>
			<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow" style="border:1px solid #999">
			<tr>
			<td class="small" valign=top >
            		<table width="100%"  border="0" cellspacing="0" cellpadding="5">
                        <tr style="height:25px;">
                            <td width="20%" nowrap class="small cellLabel"  align="right"><strong>用户名</strong></td>
                            <td width="80%" class="small cellText">
                            {$user_name}
                          	 <input type="hidden" value="{$user_name}" name="user_name"  />
			  				</td>
                        </tr>
                        <tr style="height:25px;">
                            <td width="20%" nowrap class="small cellLabel"  align="right"><strong>姓名</strong></td>
                            <td width="80%" class="small cellText">
                            {$last_name}
                          	 <input type="hidden" value="{$last_name}" name="last_name"  />
			  				</td>
                        </tr>
                       <tr style="height:25px;">
                            <td width="20%" nowrap class="small cellLabel"  align="right"><strong>套餐</strong></td>
                            <td width="80%" class="small cellText">
                            <input type="radio" name="newtcdate" value="onemonth"  checked="checked">
                                    一个月
                            <input type="radio" name="newtcdate" value="threemonths" >
                                    三个月
                          	<input type="radio" name="newtcdate" value="sixmonths"  >
                                    半年
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="newtcdate" value="oneyear" >
                            1年
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
</form>
	
</td>
</tr>
</tbody>
</table>


