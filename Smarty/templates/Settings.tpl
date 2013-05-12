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

	{include file="Buttons_List1.tpl"}

<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
	<td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
	<br>
	<div align=center>
	<table border=0 cellspacing=0 cellpadding=20 width=90% class="settingsUI">
	<tr>
		<td>
			<!--All Icons table -->
			<table border=0 cellspacing=0 cellpadding=0 width=100%>
			<tr>

				<td class="settingsTabHeader">
				<!-- Users & Access Management -->
					{$MOD.LBL_USER_MANAGEMENT}	
				</td>
			</tr>
			<tr>
				<td class="settingsIconDisplay small">
				<!-- Icons for Users & Access Management -->
				
				<table border=0 cellspacing=0 cellpadding=10 width=100%>

			
			<tr>
				<td class="settingsIconDisplay small">
				<!-- Icons for Users & Access Management -->
				
				<table border=0 cellspacing=0 cellpadding=10 width=100%>
				<tr>
				        
					<td width=12.5% valign=top>
					<!-- empty-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>

							<td  valign=top><a href="index.php?module=Settings&action=CustomBlockList&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}blocklist.gif" alt="{$MOD.LBL_BLOCK_EDITOR}" title="{$MOD.LBL_BLOCK_EDITOR}"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Settings&action=CustomBlockList&parenttab=Settings">{$MOD.LBL_BLOCK_EDITOR}</a></td>
						</tr>
						
						</table>
					</td>
					<td width=12.5% valign=top>
					<!-- icon 9-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>
							<td  valign=top><a href="index.php?module=Settings&action=CustomFieldList&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}custom.gif" alt="{$MOD.LBL_CUSTOM_FIELDS}" title="{$MOD.LBL_CUSTOM_FIELDS}"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Settings&action=CustomFieldList&parenttab=Settings">{$MOD.LBL_CUSTOM_FIELDS}</a></td>
						</tr>
						
						</table>
					</td>
					<td width=12.5% valign=top>
					<!-- icon 10-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>

							<td  valign=top><a href="index.php?module=Settings&action=PickList&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}picklist.gif" alt="{$MOD.LBL_PICKLIST_EDITOR}" title="{$MOD.LBL_PICKLIST_EDITOR}"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Settings&action=PickList&parenttab=Settings">{$MOD.LBL_PICKLIST_EDITOR}</a></td>
						</tr>
						
						</table>
					</td>
                    
                    <td width=12.5% valign=top>
					<!-- icon 10-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>

							<td  valign=top><a href="index.php?module=Settings&action=SmsUser&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}picklist.gif" alt="{$MOD.LBL_SMS_USER}" title="{$MOD.LBL_SMS_USER}"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Settings&action=SmsUser&parenttab=Settings">{$MOD.LBL_SMS_USER}</a></td>
						</tr>
						
						</table>
					</td>
                    
                    
					
				</tr>
                <tr>
					
                    		<td width=12.5% valign=top>
						<!-- empty-->
							<table border=0 cellspacing=0 cellpadding=5 width=100%>
							<tr>

								<td  valign=top><a href="index.php?module=Settings&action=LayoutList&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}layout.gif" alt="{$MOD.LBL_LAYOUT_EDITOR}" title="{$MOD.LBL_LAYOUT_EDITOR}"></a></td>
							</tr>
							<tr>
								<td class=big valign=top><a href="index.php?module=Settings&action=LayoutList&parenttab=Settings">{$MOD.LBL_LAYOUT_EDITOR}</a></td>
							</tr>
							
							</table>
					</td>
					
					<!-- icon 6 -->
					<td width=12.5% valign=top>
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>
							<td  valign=top><a href="index.php?module=Users&action=DefaultFieldPermissions&parenttab=Settings"><img src="{$IMAGE_PATH}orgshar.gif" alt="Fields to be shown" width="48" height="48" border=0 title="Fields to be shown"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Users&action=DefaultFieldPermissions&parenttab=Settings">{$MOD.LBL_FIELDS_ACCESS}</a></td>
						</tr>
						
						</table>
					</td>

				
				 <td  valign=top  >
				<!-- icon 17-->
				    <table border=0 cellspacing=0 cellpadding=5 width=100%>
				    <tr>
					<td  valign=top><a href="index.php?module=Relsettings&action=SmsAccount&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}picklist.gif" alt="{$MOD.LBL_DUANXINZHANGHAOSHEZHI}" title="{$MOD.LBL_DUANXINZHANGHAOSHEZHI}"></a></td>
				    </tr>
				    <tr>
					<td class=big valign=top><a href="index.php?module=Relsettings&action=SmsAccount&parenttab=Settings">{$MOD.LBL_DUANXINZHANGHAOSHEZHI}</a></td>
				    </tr>
	    
				    </table>
				</td>
				<td  valign=top>&nbsp;</td>
			</tr>

			
			
			</table>	
	</div>
	</td>        
   </tr>
</tbody></table>
</td>
</tr></table>


