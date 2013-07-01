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
<table border=0 cellspacing=0 cellpadding=20 width=100% class="settingsUI">
<tr>
<td valign=top>
	<table border=0 cellspacing=0 cellpadding=0 width=100%>
	<tr>
	<td valign=top>
		<!--Left Side Navigation Table-->
		<table border=0 cellspacing=0 cellpadding=0 width=100%>
		<tr>
			<td class="settingsTabHeader" nowrap>{$MOD.LBL_USER_MANAGEMENT}</td>
		</tr>

		
		{if  $smarty.request.action eq 'CustomBlockList'}
		<tr><td class="settingsTabSelected" nowrap><a href="index.php?module=Settings&action=CustomBlockList&parenttab=Settings">{$MOD.LBL_BLOCK_EDITOR}</a></td></tr>
		{else}
		<tr><td class="settingsTabList" nowrap><a href="index.php?module=Settings&action=CustomBlockList&parenttab=Settings">{$MOD.LBL_BLOCK_EDITOR}</a></td></tr>
		{/if}
		{if  $smarty.request.action eq 'CustomFieldList' || $smarty.request.action eq 'LeadCustomFieldMapping'}
		<tr><td class="settingsTabSelected" nowrap><a href="index.php?module=Settings&action=CustomFieldList&parenttab=Settings">{$MOD.LBL_CUSTOM_FIELDS}</a></td></tr>
		{else}
		<tr><td class="settingsTabList" nowrap><a href="index.php?module=Settings&action=CustomFieldList&parenttab=Settings">{$MOD.LBL_CUSTOM_FIELDS}</a></td></tr>
		{/if}
				
		{if  $smarty.request.action eq 'PickList' ||  $smarty.request.action eq 'SettingsAjax'}
		<tr><td class="settingsTabSelected" nowrap><a href="index.php?module=Settings&action=PickList&parenttab=Settings">{$MOD.LBL_PICKLIST_EDITOR}</a></td></tr>						     {else}
		<tr><td class="settingsTabList" nowrap><a href="index.php?module=Settings&action=PickList&parenttab=Settings">{$MOD.LBL_PICKLIST_EDITOR}</a></td></tr>
		{/if}
		{if  $smarty.request.action eq 'LayoutList'}
		<tr><td class="settingsTabSelected" nowrap><a href="index.php?module=Settings&action=LayoutList&parenttab=Settings">{$MOD.LBL_LAYOUT_EDITOR}</a></td></tr>
		{else}
		<tr><td class="settingsTabList" nowrap><a href="index.php?module=Settings&action=LayoutList&parenttab=Settings">{$MOD.LBL_LAYOUT_EDITOR}</a></td></tr>
		{/if}

		{if  $smarty.request.action eq 'CustomTabList'}
		<tr><td class="settingsTabSelected" nowrap><a href="index.php?module=Settings&action=CustomTabList&parenttab=Settings">{$MOD.LBL_TAB_EDITOR}</a></td></tr>
		{else}
		<tr><td class="settingsTabList" nowrap><a href="index.php?module=Settings&action=CustomTabList&parenttab=Settings">{$MOD.LBL_TAB_EDITOR}</a></td></tr>
		{/if}
		{if $smarty.request.action eq 'DefaultFieldPermissions' || $smarty.request.action eq 'UpdateDefaultFieldLevelAccess' || $smarty.request.action eq 'EditDefOrgFieldLevelAccess' }
		<tr><td class="settingsTabSelected" nowrap><a href="index.php?module=Users&action=DefaultFieldPermissions&parenttab=Settings">{$MOD.LBL_FIELDS_ACCESS}</a></td></tr>
		{else}
		<tr><td class="settingsTabList" nowrap><a href="index.php?module=Users&action=DefaultFieldPermissions&parenttab=Settings">{$MOD.LBL_FIELDS_ACCESS}</a></td></tr>
		{/if}
		

	
	

		
        
           
		</table>
		<!-- Left side navigation table ends -->
		
	</td>
	<td width=90% class="small settingsSelectedUI" valign=top align=left>




