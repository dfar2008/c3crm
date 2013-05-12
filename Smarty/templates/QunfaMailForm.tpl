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


<table border=0 cellspacing=0 cellpadding=5 width=95% align=center> 
	<tr>
		<td class=small >		
			<!-- popup specific content fill in starts -->
	     
				<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white  class="small">
				<tr>
                    <td>
                        <b>接收人: &nbsp;&nbsp;
                        <font color=red>{$receiveaccountinfo}</font>
                        <input name="receiveaccountinfo" id="receiveaccountinfo" value="{$receiveaccountinfo}" type="hidden">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>发&nbsp;&nbsp;件&nbsp;&nbsp;人: &nbsp;
                       
                        <font color=red>{if $from_name neq ''}"{$from_name}"{/if} &nbsp;
                        {if $from_email neq ''}({$from_email}){/if}</font></b> 
                        
                        <input name="from_name" id="from_name" value="{$from_name}" type="hidden">
                        <input name="from_email" id="from_email" value="{$from_email}" type="hidden">
                    </td>
                </tr>
                <tr>
                    <td>
                   		 <b>邮件主题:</b><input name="subject" id="subject" class="txtBox" value="">
                    </td>
                </tr>
                <tr>
                    <td valign="top" >
                        <p align="left">
                       <b> 邮件内容:</b><input title="选择Email模版" class="crmbutton small edit" onclick="window.open('index.php?module=Maillisttmps&action=MaillisttmpsAjax&file=lookupemailtemplates','emailtemplate','top=100,left=200,height=400,width=500,menubar=no,addressbar=no,status=yes')" type="button" name="button" value=" 选择Email模版  ">
                       <input class="crmButton create small" type="button" onclick="window.open('index.php?module=Maillists&action=MaillistsAjax&file=CreateTmps','CreateTmps','top=100,left=200,height=315,width=500,scrollbars=yes,menubar=yes,addressbar=no,status=yes')" name="profile" value="新增模版">
                       <br />
                        <textarea rows="17"  name="mailcontent" id="mailcontent" style="height:180px;"></textarea>
                        </p>
                    </td>
                </tr>
			</table>
		</td>
	</tr>
</table>
<input name="sjid" id="sjid" value="{$sjid}" type="hidden">

