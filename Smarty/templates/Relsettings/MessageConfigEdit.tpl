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
	<form action="alipay/alipayto.php" method="post" name="MessageConfig" id="form"  target="_blank">
    <input type="hidden" name="total_fee" id="total_fee"  value="{$total_fee}" />
	<input type="hidden" name="order_no" id="order_no"  value="{$order_no}" />
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
                
                    <table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow" >
                      <tr>
                        <td class="small" valign=top >
                            <table width="100%"  border="0" cellspacing="0" cellpadding="5" class="small" >
                            <tr>
                           	  <td style="border:1px solid #999; background-color:#CCC" colspan="6"><font color=black><b>订单详细信息:</b></font></td> 
                            </tr>
                             <tr>
                              <td style="border:1px solid #999">订单号</td> 
                              <td style="border:1px solid #999">总金额(元)</td> 
                              <td style="border:1px solid #999">有效期至</td>
                            </tr>
                           <tr>
                          	 <td style="border:1px solid #999"><font color=red><b>{$order_no}</b></font></td> 
                              <td style="border:1px solid #999"><font color=red><b>{$total_fee}</b></font></td> 

                              <td style="border:1px solid #999"><font color=red><b>{$endtime}</b></font></td>
                            </tr>
                            </table>
                         </td>
                        </tr>
                    </table>
                    <br> <br>
                            <table width="100%"  border="0" cellspacing="0" cellpadding="5" class="small" >
                            <tr align="center">
                                 <td >
                                	<input type="image" src="../../../alipay/images/280x50.png"  value="付款" name="pay" />
                                </td>
                            </tr>
                            </table>
                            	<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
                                <tr>
                                    <td class="small" align=center style="font-size:16px">
                                        <font color=red><b>付款已完成？ 付款遇到问题？ <a href="javascript:history.go(-1);">返回</a></b></font>
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
