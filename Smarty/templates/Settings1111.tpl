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

	{include file="Buttons_List2.tpl"}

<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
	<td class="showPanelBg" style="padding: 2px;" valign="top" width="100%">
	<div align=center>
	<table border=0 cellspacing=0 cellpadding=1 width=100% class="settingsUI">
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
					<td width=12.5% valign=top>
					<!-- icon 1-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>
							<td valign=top><a href="index.php?module=Users&action=index&parenttab=Settings"><img src="{$IMAGE_PATH}ico-users.gif" alt="{$MOD.LBL_USERS}" width="48" height="48" border=0 title="{$MOD.LBL_USERS}"></a></td>
							</tr>
							<tr>
							<td class=big valign=top><a href="index.php?module=Users&action=index&parenttab=Settings">{$MOD.LBL_USERS}</a></td>
						</tr>

						
						</table>
					</td>
					<td width=12.5% valign=top>
					<!-- icon 2-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>

						<tr>
							<td  valign=top><a href="index.php?module=Users&action=listroles&parenttab=Settings"><img src="{$IMAGE_PATH}ico-roles.gif" alt="{$MOD.LBL_ROLES}" width="48" height="48" border=0 title="{$MOD.LBL_ROLES}"></a></td>
							</tr>
							<tr>
							<td class=big valign=top><a href="index.php?module=Users&action=listroles&parenttab=Settings">{$MOD.LBL_ROLES}</a></td>
						</tr>
						
						</table>

					</td>
					
					<td width=12.5% valign=top>
					<!-- icon 4-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>

						<tr>
							<td  valign=top><a href="index.php?module=Users&action=listgroups&parenttab=Settings"><img src="{$IMAGE_PATH}ico-groups.gif" alt="{$MOD.USERGROUPLIST}" width="48" height="48" border=0 title="{$MOD.USERGROUPLIST}"></a></td>
						</tr>
							<tr>
							<td class=big valign=top><a href="index.php?module=Users&action=listgroups&parenttab=Settings">{$MOD.USERGROUPLIST}</a></td>
						</tr>
						
						</table>

					</td>
				
					
					

					
					<td width=12.5% valign=top>
					<!-- icon 7-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>
							<td  valign=top><a href="index.php?module=Users&action=AuditTrailList&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}audit.gif" alt="{$MOD.LBL_AUDIT_TRAIL}" title="{$MOD.LBL_AUDIT_TRAIL}"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Users&action=AuditTrailList&parenttab=Settings">{$MOD.LBL_AUDIT_TRAIL}</a></td>
						</tr>

						
						</table>

						
					</td>
					<td width=12.5% valign=top>
					<!-- icon 8-->	
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>
							<td  valign=top><a href="index.php?module=Users&action=ListLoginHistory&parenttab=Settings"><img src="{$IMAGE_PATH}set-IcoLoginHistory.gif" alt="{$MOD.LBL_LOGIN_HISTORY_DETAILS}" width="48" height="48" border=0 title="{$MOD.LBL_LOGIN_HISTORY_DETAILS}"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Users&action=ListLoginHistory&parenttab=Settings">{$MOD.LBL_LOGIN_HISTORY_DETAILS}</a></td>
						</tr>
						

						</table>
					</td>
					<td width=12.5% valign=top></td>
					<td width=12.5% valign=top></td>
					<!-- Row 3 -->
					<tr>
					
				</tr>
				</table>


				</td>
			</tr>


			<tr>
				<td class="settingsTabHeader">

				<!-- Studio  -->
					{$MOD.LBL_STUDIO}	
				</td>
			</tr>
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
					<td width=12.5% valign=top>
						<!-- empty-->
							<table border=0 cellspacing=0 cellpadding=5 width=100%>
							<tr>

								<td  valign=top><a href="index.php?module=Settings&action=CustomTabList&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}mainmenu.gif" alt="{$MOD.LBL_TAB_EDITOR}" title="{$MOD.LBL_TAB_EDITOR}"></a></td>
							</tr>
							<tr>
								<td class=big valign=top><a href="index.php?module=Settings&action=CustomTabList&parenttab=Settings">{$MOD.LBL_TAB_EDITOR}</a></td>
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
					<td width=12.5% valign=top>
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>
								<td  valign=top><a href="index.php?module=Settings&action=PrintTemplate&parenttab=Settings"><img src="{$IMAGE_PATH}printtemplate.gif" width="48" height="48" border=0></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Settings&action=PrintTemplate&parenttab=Settings">{$MOD.LBL_PRINT_TEMPLATE}</a></td>
						</tr>
						
						</table>
					</td>
                    
					<!-- icon 6 -->
					
					
					</tr>
					</table>			
				
				</td>
			</tr>
			
			<tr>
				<td class="settingsTabHeader">
				<!-- Other settings -->
					{$MOD.LBL_OTHER_SETTINGS}
				</td>

			</tr>
			<tr>
				<td class="settingsIconDisplay small">
				<!-- Icons for Other Settings-->
				
				<table border=0 cellspacing=0 cellpadding=10 width=100%>
				<tr>    <td class="settingsIconDisplay small">

				<!-- Icons for Communication Templates -->
				
				<table border=0 cellspacing=0 cellpadding=10 width=100%>
				<tr>
				        
				        <td width=12.5% valign=top>
					<!-- icon 11-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>
							<td  valign=top><a href="index.php?module=Users&action=listemailtemplates&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}ViewTemplate.gif" alt="{$MOD.EMAILTEMPLATES}" title="{$MOD.EMAILTEMPLATES}"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Users&action=listemailtemplates&parenttab=Settings">{$MOD.EMAILTEMPLATES}</a></td>

						</tr>
						
						</table>
					</td>
					<td width=12.5% valign=top>
					<!-- icon 11-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>
							<td  valign=top><a href="index.php?module=Settings&action=db_backup&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}dbbackup.gif" alt="{$MOD.LBL_DATABASE_BACKUP}" title="{$MOD.LBL_DATABASE_BACKUP}"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Settings&action=db_backup&parenttab=Settings">{$MOD.LBL_DATABASE_BACKUP}</a></td>

						</tr>
						
						</table>
					</td>
					
			
					
					
					<td width=12.5% valign=top>
					<!-- icon 17-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>
							<td  valign=top><a href="index.php?module=Settings&action=EmailConfig&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}ogmailserver.gif" alt="{$MOD.LBL_MAIL_SERVER_SETTINGS}" title="{$MOD.LBL_MAIL_SERVER_SETTINGS}"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Settings&action=EmailConfig&parenttab=Settings">{$MOD.LBL_MAIL_SERVER_SETTINGS}</a></td>
						</tr>

						
						</table>
					</td>

					<td width=12.5% valign=top>
					<!-- icon 17-->
						<table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>
							<td  valign=top><a href="index.php?module=Settings&action=MessageConfig&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}ico_mobile.gif" alt="{$MOD.LBL_MESSAGE_SERVER_SETTINGS}" title="{$MOD.LBL_MESSAGE_SERVER_SETTINGS}"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Settings&action=MessageConfig&parenttab=Settings">{$MOD.LBL_MESSAGE_SERVER_SETTINGS}</a></td>
						</tr>

						
						</table>
					</td>
					<td width=12.5% valign=top>
					<!-- icon 18-->
					        <table border=0 cellspacing=0 cellpadding=5 width=100%>
						<tr>
							<td  valign=top><a href="index.php?module=Settings&action=CurrencyListView&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}currency.gif" alt="{$MOD.LBL_CURRENCY_SETTINGS}" title="{$MOD.LBL_CURRENCY_SETTINGS}"></a></td>
						</tr>
						<tr>
							<td class=big valign=top><a href="index.php?module=Settings&action=CurrencyListView&parenttab=Settings">{$MOD.LBL_CURRENCY_SETTINGS}</a></td>
						</tr>

						
						</table>				       

					</td>

					
					
				      
		
					<td width=12.5% valign=top>
					<!-- icon 17-->
					<table border=0 cellspacing=0 cellpadding=5 width=100%>
					<tr>
						<td  valign=top><a href="index.php?module=Settings&action=LicenseConfig&parenttab=Settings"><img border=0 src="{$IMAGE_PATH}license.gif" alt="{$MOD.LBL_LICENSE_SERVER_SETTINGS}" title="{$MOD.LBL_MESSAGE_SERVER_SETTINGS}"></a></td>
						</tr>
						<tr>
						<td class=big valign=top><a href="index.php?module=Settings&action=LicenseConfig&parenttab=Settings">{$MOD.LBL_LICENSE_SERVER_SETTINGS}</a></td>
					</tr>

					
					</table>
					</td>					
			
					
				</tr>
                <tr>
				 
                   </tr>
		</table>
		
		</td>
	</tr>
	</table>
	</td></tr></table>	
	</div>
	</td>        
   </tr>
</tbody></table>
</tr></table>


