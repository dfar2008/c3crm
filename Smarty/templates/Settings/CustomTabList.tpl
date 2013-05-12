{*
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/ *}
<script language="JavaScript" type="text/javascript" src="include/js/customview.js"></script>
<script language="javascript">
{literal}
function deleteTab(id)
{
        if(confirm(alert_arr.SURE_TO_DELETE))
        {
                document.form.action="index.php?module=Settings&action=DeleteTab&id="+id;
                document.form.submit();
        }
}

function getCreateTabForm(id)
{
        /*
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=CreateTab&id='+id+'&parenttab=Settings&ajax=true',
			onComplete: function(response) {
				$("createtab").innerHTML=response.responseText;
				execJS($('tabLayer'));
				execJS($('tabchooser'));
				
			}
		}
	);
	*/
	var url = 'index.php?module=Settings&action=CreateTab&id='+id+'&parenttab=Settings';
	document.location.href  = url;

}
function validate_module() {
		if(document.addtodb.enname.value == "") {
			alert(alert_arr.TAB_KEY_IS_NULL);
			document.addtodb.enname.focus();
			return false;
		}
		if(document.addtodb.cnname.value == "") {
			alert(alert_arr.TAB_LABEL_IS_NULL);
			document.addtodb.cnname.focus();
			return false;
		} else {
			if(isNaN(trim(document.addtodb.order.value))) {
				alert(alert_arr.LBL_ENTER_VALID_NO);
				document.addtodb.order.focus();
				return false;
			}
		}
		if(document.addtodb.order.value == "") {
			alert(alert_arr.DISPLAY_ORDER_IS_NULL);
			document.addtodb.order.focus();
			return false;
		} else {
			if(isNaN(trim(document.addtodb.order.value))) {
				alert(alert_arr.LBL_ENTER_VALID_NO);
				document.addtodb.order.focus();
				return false;
			}
		}
		return true;
}
{/literal}
</script>
<div id="createtab" style="display:block;position:absolute;width:400px;"></div>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">

	<div align=center>
			{include file='SetMenu.tpl'}
			<!-- DISPLAY -->
			{if $MODE neq 'edit'}
			<b><font color=red>{$DUPLICATE_ERROR} </font></b>
			{/if}
			
				<table class="settingsSelUITopLine" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tbody><tr>
					<td rowspan="2" valign="top" width="50"><img src="{$IMAGE_PATH}mainmenu.gif" alt="Users" title="Users" border="0" height="48" width="48"></td>
					<td class="heading2" valign="bottom"><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> &gt; {$MOD.LBL_TAB_EDITOR}</b></td>
				</tr>

				<tr>
					<td class="small" valign="top">{$MOD.LBL_TAB_DESCRIPTION}</td>
				</tr>
				</tbody></table>
				
				<br>
				<table border="0" cellpadding="10" cellspacing="0" width="100%">
				<tbody><tr>
				<td>
				<form action="index.php" method="post" name="form">
				<input type="hidden" name="module" value="Settings">
				<input type="hidden" name="mode">
				<table class="listTableTopButtons" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tr>
					<td class="small">&nbsp;</td>
					<td class="small" align="right">&nbsp;&nbsp;
					<input type="button" value=" {$MOD.LBL_NEW_TAB} " onClick="fnvshobj(this,'createtab');getCreateTabForm('')" class="crmButton create small"/>
				</tr>
				</table>

				<table class="listTable" border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td class="colHeader small" width="5%">#</td>
						<td class="colHeader small" width="20%">{$MOD.PARENT_TAB}</td>
						<td class="colHeader small" width="20%">{$MOD.MODULE_ORDER}</td>
						<td class="colHeader small" width="20%">{$MOD.LBL_CURRENCY_TOOL}</td>
					</tr>
					
					{foreach item=entries key=id from=$TABENTRIES}
					<tr>
						{foreach item=value from=$entries}
							<td class="listTableRow small" valign="top" nowrap>{$value}&nbsp;</td>
						{/foreach}
					</tr>
					{/foreach}
				</table>
				</form>	
			<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr>
		  	<td class="small" align="right" nowrap="nowrap"><a href="#top">{$MOD.LBL_SCROLL}</a></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
		<!-- End of Display -->
		
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
<br>
