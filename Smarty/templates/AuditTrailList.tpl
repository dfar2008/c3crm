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

<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
<form action="index.php" method="post" name="AuditTrail" id="form">
<input type='hidden' name='module' value='Users'>
<input type='hidden' name='action' value='AuditTrail'>
<input type='hidden' name='return_action' value='ListView'>
<input type='hidden' name='return_module' value='Users'>
<input type='hidden' name='parenttab' value='Settings'>


	<div align=center>
			{include file='SetMenu.tpl'}
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}audit.gif" alt="{$MOD.LBL_AUDIT_TRAIL}" width="48" height="48" border=0 title="{$MOD.LBL_AUDIT_TRAIL}"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > {$MOD.LBL_AUDIT_TRAIL}</b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_AUDIT_TRAIL_DESC}</td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
				<tr>
				<td class="big" height="40px;" width="70%"><strong>{$MOD.LBL_AUDIT_TRAIL}</strong></td>
				<td class="small" align="center" width="30%">&nbsp;
					<span id="audit_info" class="crmButton small cancel" style="display:none;"></span>
				</td>
				</tr>
				</table>
			
							<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow">
			<tr>
	         	    <td class="small" valign=top ><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                        <tr>
                            <td width="20%" nowrap class="small cellLabel"><strong>{$MOD.LBL_ENABLE_AUDIT_TRAIL} </strong></td>
                            <td width="80%" class="small cellText">
			{if $AuditStatus eq 'enabled'}
				<input type="checkbox" checked name="enable_audit" onclick="auditenabled(this)"></input>
			{else}
				<input type="checkbox" name="enable_audit" onclick="auditenabled(this)"></input>
			{/if}
			</td>
                        </tr>
                        
                        
                        </table>
	    </td>
                        </tr>
                        </table>	
				<table id="logs_info" class="small" border=0 cellspacing=0 cellpadding=5 width=100% >
				<tr>
				<td width="20%" nowrap class="small cellLabel"><strong>{$MOD.LBL_DOWNLOAD_LOG} </strong></td>
				<td width="80%" class="small cellText" nowrap><a href="logs/ecustomer.log" target="_blank">ecustomer.log</a></td>
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

</td>
   </tr>
</tbody>
</form>
</table>

{literal}
<script>

function auditenabled(ochkbox)
{
	if(ochkbox.checked == true)
	{
	     var status='enabled';
	$('audit_info').innerHTML = alert_arr['LOG_Enabled'];
	     $('audit_info').style.display = 'block';
	    
		
			
	}
	else
	{
	    var status = 'disabled';	
	     $('audit_info').innerHTML = alert_arr['LOG_Disabled'];
	     $('audit_info').style.display = 'block';
	     
	
	}
             $("status").style.display="block";
	     new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'module=Users&action=UsersAjax&file=SaveAuditTrail&ajax=true&audit_trail='+status,
                        onComplete: function(response) {
                                $("status").style.display="none";
                        }
                }
        );
			
	setTimeout("hide('audit_info')",3000);
}

function showAuditTrail()
{
	
	var userid = $('user_list').options[$('user_list').selectedIndex].value;
	window.open("index.php?module=Users&action=UsersAjax&file=ShowAuditTrail&userid="+userid,"","width=645,height=750,resizable=0,scrollbars=1,left=100");
	

}
</script>
{/literal}
