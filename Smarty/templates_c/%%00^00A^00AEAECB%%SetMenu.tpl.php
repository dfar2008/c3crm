<?php /* Smarty version 2.6.18, created on 2013-04-12 16:28:46
         compiled from SetMenu.tpl */ ?>
<table border=0 cellspacing=0 cellpadding=20 width=100% class="settingsUI">
<tr>
<td valign=top>
	<table border=0 cellspacing=0 cellpadding=0 width=100%>
	<tr>
	<td valign=top>
		<!--Left Side Navigation Table-->
		<table border=0 cellspacing=0 cellpadding=0 width=100%>
		<tr>
			<td class="settingsTabHeader" nowrap><?php echo $this->_tpl_vars['MOD']['LBL_USER_MANAGEMENT']; ?>
</td>
		</tr>

		
		<?php if ($_REQUEST['action'] == 'CustomBlockList'): ?>
		<tr><td class="settingsTabSelected" nowrap><a href="index.php?module=Settings&action=CustomBlockList&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_BLOCK_EDITOR']; ?>
</a></td></tr>
		<?php else: ?>
		<tr><td class="settingsTabList" nowrap><a href="index.php?module=Settings&action=CustomBlockList&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_BLOCK_EDITOR']; ?>
</a></td></tr>
		<?php endif; ?>
		<?php if ($_REQUEST['action'] == 'CustomFieldList' || $_REQUEST['action'] == 'LeadCustomFieldMapping'): ?>
		<tr><td class="settingsTabSelected" nowrap><a href="index.php?module=Settings&action=CustomFieldList&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_CUSTOM_FIELDS']; ?>
</a></td></tr>
		<?php else: ?>
		<tr><td class="settingsTabList" nowrap><a href="index.php?module=Settings&action=CustomFieldList&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_CUSTOM_FIELDS']; ?>
</a></td></tr>
		<?php endif; ?>
				
		<?php if ($_REQUEST['action'] == 'PickList' || $_REQUEST['action'] == 'SettingsAjax'): ?>
		<tr><td class="settingsTabSelected" nowrap><a href="index.php?module=Settings&action=PickList&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_PICKLIST_EDITOR']; ?>
</a></td></tr>						     <?php else: ?>
		<tr><td class="settingsTabList" nowrap><a href="index.php?module=Settings&action=PickList&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_PICKLIST_EDITOR']; ?>
</a></td></tr>
		<?php endif; ?>
		<?php if ($_REQUEST['action'] == 'LayoutList'): ?>
		<tr><td class="settingsTabSelected" nowrap><a href="index.php?module=Settings&action=LayoutList&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_LAYOUT_EDITOR']; ?>
</a></td></tr>
		<?php else: ?>
		<tr><td class="settingsTabList" nowrap><a href="index.php?module=Settings&action=LayoutList&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_LAYOUT_EDITOR']; ?>
</a></td></tr>
		<?php endif; ?>
		<?php if ($_REQUEST['action'] == 'DefaultFieldPermissions' || $_REQUEST['action'] == 'UpdateDefaultFieldLevelAccess' || $_REQUEST['action'] == 'EditDefOrgFieldLevelAccess'): ?>
		<tr><td class="settingsTabSelected" nowrap><a href="index.php?module=Users&action=DefaultFieldPermissions&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_FIELDS_ACCESS']; ?>
</a></td></tr>
		<?php else: ?>
		<tr><td class="settingsTabList" nowrap><a href="index.php?module=Users&action=DefaultFieldPermissions&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_FIELDS_ACCESS']; ?>
</a></td></tr>
		<?php endif; ?>
		
		<?php if ($_REQUEST['action'] == 'SmsAccount'): ?>
		<tr><td class="settingsTabSelected" nowrap><a 
		href="index.php?module=	Relsettings&action=SmsAccount&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_DUANXINZHANGHAOSHEZHI']; ?>
</a></td></tr>
		<?php else: ?>
		<tr><td class="settingsTabList" nowrap><a 
		href="index.php?module=	Relsettings&action=SmsAccount&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_DUANXINZHANGHAOSHEZHI']; ?>
</a></td></tr>
		<?php endif; ?>
	

		
        
           
		</table>
		<!-- Left side navigation table ends -->
		
	</td>
	<td width=90% class="small settingsSelectedUI" valign=top align=left>



