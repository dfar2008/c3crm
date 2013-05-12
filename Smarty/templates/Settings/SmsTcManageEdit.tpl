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
    
	<form action="index.php" method="post" name="SmsTcManage" id="form" >
	<input type="hidden" name="module" value="Settings">
	<input type="hidden" name="action">
    <input type="hidden" name="record" value="{$record}">
	<input type="hidden" name="parenttab" value="Settings">
	<input type="hidden" name="return_module" value="Settings">
	<input type="hidden" name="return_action" value="SmsTcManage">
	<div align=center>
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}ico_mobile.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > {$MOD.LBL_SMS_TC_MANAGE} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_SMS_TC_MANAGE} </td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="small" align=right>
							<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='SaveSmsTcManage';return checkForm();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >&nbsp;&nbsp;
    							<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="goback();" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
						</td>
					</tr>
					</table>
				
			<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow" style="border:1px solid #999">
            
			<tr>
			<td class="small" valign=top >
            	<table width="100%"  border="0" cellspacing="0" cellpadding="5">
                        <tr style="height:25px;">
                            <td width="20%" nowrap class="small cellLabel"  align="right"><strong>套餐名</strong></td>
                            <td width="80%" class="small cellText">
                          	 <input type="text" value="{$tc}" name="tc"  id="tc"  />（A~Z）
			  				</td>
                        </tr>
                        <tr style="height:25px;">
                            <td width="20%" nowrap class="small cellLabel"  align="right"><strong>价格</strong></td>
                            <td width="80%" class="small cellText">
                            
                          	 <input type="text" value="{$price}" name="price"  id="price"   />（元/月）
			  				</td>
                        </tr>
                       <tr style="height:25px;">
                            <td width="20%" nowrap class="small cellLabel"  align="right"><strong>次数</strong></td>
                            <td width="80%" class="small cellText">
                          
                            <input type="text" value="{$num}" name="num"  id="num" />（次/月）
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
		</td>
	</tr>
	</table>
		
	</div>
	</form>
	
</td>
   </tr>
</tbody>
</table>

<script>
{literal}
function checkForm(){
	var record =  document.SmsTcManage.record.value;
	
	var tc = document.SmsTcManage.tc.value;
	if(tc =='' ){
		alert("套餐名不能为空");
        document.SmsTcManage.tc.focus();
        return false;
	}
	if((tc.charCodeAt(0)>90) || (tc.charCodeAt(0)<65)){
		alert("套餐名只能从A-Z");	
		document.SmsTcManage.tc.focus();
		return false;
	}
	
	var price = document.SmsTcManage.price.value;
	if(price =='' ){
		alert("价格不能为空");
        document.SmsTcManage.price.focus();
        return false;
	}
	var reg =  /^\d+\.?\d+$/;   //判断是否为数字
	if (!reg.test(price))
    {
        alert("价格应为数字");
        document.SmsTcManage.price.focus();
        return false;
    } 
	
	var num = document.SmsTcManage.num.value;
	if(num =='' ){
		alert("次数不能为空");
        document.SmsTcManage.num.focus();
        return false;
	}
	var reg = /^[0-9]+[0-9]*]*$/  ; //判断是否正整数
	if (!reg.test(num))
    {
        alert("次数应为正整数");
        document.SmsTcManage.num.focus();
        return false;
    }
	
   new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
		method: 'post',
		postBody:"module=Settings&action=SettingsAjax&file=SaveSmsTcManage&ajax=true&tc="+tc+"&record="+record,
		onComplete: function(response) {
		result = response.responseText; 
				if(result.indexOf('FAILED') != '-1') {
					alert("套餐名称重复");
					document.SmsTcManage.tc.focus();
					return false;	
				}else if(result.indexOf('SUCCESS') != '-1'){
					document.SmsTcManage.submit();
				}
			}
		}
	)	
}
{/literal}

</script>

