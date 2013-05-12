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
function deleteCustomModule(id)
{
        if(confirm(alert_arr.SURE_TO_DELETE))
        {
                document.form.action="index.php?module=Settings&action=DeleteCustomModule&id="+id;
                document.form.submit();
        }
}
function exportCustomModule(id)
{
        if(confirm(alert_arr.SURE_TO_EXPORT))
        {
                document.form.action="index.php?module=Settings&action=SettingsAjax&file=exportCustomModule&id="+id;
                document.form.submit();
        }
}
function installCustomModule(id)
{
        if(confirm(alert_arr.SURE_TO_INSTALL))
        {
                document.form.action="index.php?module=Settings&action=installCustomModule&id="+id;
                document.form.submit();
        }
}
function uninstallCustomModule(id)
{
        if(confirm(alert_arr.SURE_TO_UNINSTALL))
        {
                document.form.action="index.php?module=Settings&action=uninstallCustomModule&id="+id;
                document.form.submit();
        }
}

function getCreateCustomModuleForm(id)
{
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=CreateCustomModule&id='+id+'&parenttab=Settings&ajax=true',
			onComplete: function(response) {
				$("createmodule").innerHTML=response.responseText;
				execJS($('moduleLayer'));
			}
		}
	);

}
function checkIsCreateModule()
{
        var enname = document.addtodb.enname.value;
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=isCreateModule&parenttab=Settings&ajax=true&enname='+enname,
			onComplete: function(response) {
				if(response.responseText == "true") {
					document.addtodb.submit();
				} else if(response.responseText == "false") {
					alert(alert_arr.MODULES_FOLDER_NOT_WRITABLE);
				} else {
					alert(alert_arr.MODULES_EXISTED);
				}
			}
		}
	);

}
function validate_module() {
		if(document.addtodb.enname.value == "") {
			alert(alert_arr.TAB_KEY_IS_NULL);
			document.addtodb.enname.focus();
			return false;
		} else {
		        var str = document.addtodb.enname.value;
		        var re = /^[a-zA-Z]+$/i;
			if (!re.test(str)) {
				alert(alert_arr.INPUT_VALID_CHARACTER);
				document.addtodb.enname.focus();
				return false;
			}
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
		//return true;
		if(checkRelatedmodule()) {
			checkIsCreateModule();
		}
		
}
function checkRelatedmodule() {
        var relatedmodule1 = document.addtodb.relatedmodule1.value;
	var relatedmodule2 = document.addtodb.relatedmodule2.value;
	var relatedmodule3 = document.addtodb.relatedmodule3.value;
	if(relatedmodule1 != "") {
		if(relatedmodule2 != "") {
			if(relatedmodule1 == relatedmodule2) {
				alert(alert_arr.RELATEDMODULE_REPEATED);
				return false;
			}
		}
		if(relatedmodule3 != "") {
			if(relatedmodule1 == relatedmodule3) {
				alert(alert_arr.RELATEDMODULE_REPEATED);
				return false;
			}
		}

	}
	if(relatedmodule2 != "") {
		if(relatedmodule1 == "") {			
			alert(alert_arr.RELATEDMODULE1_ISNULL);
			return false;
		}
		if(relatedmodule3 != "") {
			if(relatedmodule2 == relatedmodule3) {
				alert(alert_arr.RELATEDMODULE_REPEATED);
				return false;
			}
		}

	}
	if(relatedmodule3 != "") {
		if(relatedmodule2 == "") {			
			alert(alert_arr.RELATEDMODULE1_ISNULL);
			return false;
		}
	}
	return true;
}
function checkImportExport(form) 
{
	if(form.product.checked == true) {
		form.importexport.disabled=true;
	} else {
		form.importexport.disabled=false;
	}
}
{/literal}
</script>
<div id="createmodule" style="display:block;position:absolute;width:500px;"></div>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopLeft.gif"></td>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
        <br>

	<div align=center>
			{include file='SetMenu.tpl'}
			<!-- DISPLAY -->
			{if $MODE neq 'edit'}
			<b><font color=red>{$DUPLICATE_ERROR} </font></b>
			{/if}
			
				<table class="settingsSelUITopLine" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tbody><tr>
					<td rowspan="2" valign="top" width="50"><img src="{$IMAGE_PATH}modulelist.gif" alt="Users" title="Users" border="0" height="48" width="48"></td>
					<td class="heading2" valign="bottom"><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> &gt; {$MOD.LBL_MODULE_EDITOR}</b></td>
				</tr>

				<tr>
					<td class="small" valign="top">{$MOD.LBL_MODULEBUILDER_DESCRIPTION}</td>
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
					<input type="button" value=" {$MOD.LBL_NEW_MODULE} " onClick="fnvshobj(this,'createmodule');getCreateCustomModuleForm('')" class="crmButton create small"/>
				</tr>
				</table>

				<table class="listTable" border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td class="colHeader small" width="5%">#</td>
						<td class="colHeader small" width="10%">{$MOD.MODULE_ENNAME}</td>
						<td class="colHeader small" width="10%">{$MOD.MODULE_CNNAME}</td>
						<td class="colHeader small" width="10%">{$MOD.PARENT_TAB}</td>
						<td class="colHeader small" width="15%">{$MOD.IS_ACCOUNTID}</td>
						<td class="colHeader small" width="15%">{$MOD.IS_CONTACTID}</td>
						<td class="colHeader small" width="10%">{$MOD.MODULE_ORDER}</td>
						<td class="colHeader small" width="10%">{$MOD.MODULE_STATUS}</td>
						<td class="colHeader small" width="15%">{$MOD.LBL_CURRENCY_TOOL}</td>
					</tr>
					
					{foreach item=entries key=id from=$MODULEENTRIES}
					<tr>
						{foreach item=value from=$entries}
							<td class="listTableRow small" valign="top" nowrap>{$value}&nbsp;</td>
						{/foreach}
					</tr>
					{/foreach}
				</table>
				</form>	
			<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td align="center"><img src="include/images/builder_flow.jpg" border="0"></td></tr>
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
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
        </tr>
</tbody>
</table>
<br>
