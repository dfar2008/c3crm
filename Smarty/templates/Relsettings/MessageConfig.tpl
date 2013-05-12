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
    <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%"  align="center">
	<form action="index.php" method="post" name="MessageConfig" id="form" >
	<input type="hidden" name="module" value="Relsettings">
	<input type="hidden" name="action">
    <input type="hidden" name="record" value="{$record}">
	<input type="hidden" name="parenttab" value="Settings">
	<input type="hidden" name="return_module" value="Relsettings">
	<input type="hidden" name="return_action" value="MessageConfig">
	
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}ico_mobile.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.LBL_SYSTEM_TC} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_SYSTEM_TC} </td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				 <table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
                    
						<td class="small" align=right>
                       		<input type="button" name="button" value=" 刷新 " onclick="window.location.reload();" class="crmbutton small edit"> 
						</td>
					</tr>
					</table>
					
                    <table border=0 cellspacing=0 cellpadding=0 width=100%  align="center" >
                      <tr>
                        <td class="small" valign=top >
                        	<br>
                             <table width="100%"  border="1" cellspacing="0" cellpadding="5" class="small" style="border:1px solid #999" align="center">
                             <tr>
                                  <td  >上次充值时间:&nbsp;&nbsp;<font color=blue><b>{$chargetime}</b></font></td>
                                  <td>上次充值金额:&nbsp;&nbsp;<font color=red><b>{$chargefee}元</b></font></td>
                                  <td>到期时间:&nbsp;&nbsp;<font color=red><b>{$endtime}</b></font></td>
                             </tr>
                            </table>
                            <br>
                            <table width="100%"  border="0" cellspacing="0" cellpadding="5" class="small" align="center">
                             <tr style="border:1px solid #999">
                             
                           		  <td style="border:1px solid #999; background-color:#9CC"><b>价格</b></td> 
                                  <td style="border:1px solid #999; background-color:#9CC"><b>充值</b></td> 
                              
                            </tr>
                          	
                            <tr class="lvtColData" bgcolor="white" onmouseout="this.className='lvtColData'" onmouseover="this.className='lvtColDataHover'">
                            	
									<td style="border:1px solid #999" width="49%"><font color=red><b>6（元/月）</b></font></td>
                                
                                	<td style="border:1px solid #999">
                                    <a href="javascript:;" onclick="confirmPay('onemonth');"><font color=green><b>一个月</b></font></a> &nbsp;|&nbsp;<a href="javascript:;" onclick="confirmPay('threemonths');"><font color=orange><b>三个月</b></font></a> &nbsp;|&nbsp;<a href="javascript:;" onclick="confirmPay('sixmonths');"><font color=red><b>半年</b></font></a> &nbsp;|&nbsp;<a href="javascript:;" onclick="confirmPay('oneyear');"><font color=blue><b>一年</b></font></a>
                                    </td>
                            </tr>
                            
                            </table>
                            <br>

							<font color=red><b>提示: 1.注册即送一个月免费试用，2.充值不会冲掉一个月的试用期。</b></font>                           
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
<script>
var endtime = '{$endtime}';
{literal}
function confirmPay(yeartype){
	var str = "确认充值";
	if(yeartype == 'onemonth'){
		str +="<一个月>";
	}else if(yeartype == 'threemonths'){
		str +="<三个月>";
	}else if(yeartype == 'sixmonths'){
		str +="<半年>";
	}else if(yeartype == 'oneyear'){
		str +="<一年>";
	}
	str +="?";
	if(confirm(str)){
		document.location.href="index.php?module=Relsettings&action=MessageConfigEdit&newtcdate="+yeartype+"&endtime="+endtime;
	}
}
{/literal}
</script>

