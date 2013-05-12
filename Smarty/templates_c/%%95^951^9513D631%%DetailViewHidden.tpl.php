<?php /* Smarty version 2.6.18, created on 2013-01-17 18:28:57
         compiled from DetailViewHidden.tpl */ ?>
<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
	<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<input type="hidden" name="isDuplicate" value=false>
	<input type="hidden" name="action">
	<input type="hidden" name="return_module">
	<input type="hidden" name="return_action">
	<input type="hidden" name="return_id">
	<input type="hidden" name="contact_id">
	<input type="hidden" name="member_id">
	<input type="hidden" name="opportunity_id">
	<input type="hidden" name="case_id">
	<input type="hidden" name="task_id">
	<input type="hidden" name="meeting_id">
	<input type="hidden" name="call_id">
	<input type="hidden" name="email_id">
	<input type="hidden" name="source_module">
	<input type="hidden" name="entity_id">
	<?php echo $this->_tpl_vars['HIDDEN_PARENTS_LIST']; ?>


<?php elseif ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
	<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<input type="hidden" name="isDuplicate" value=false>
	<input type="hidden" name="action">
	<input type="hidden" name="return_module">
	<input type="hidden" name="return_action">
	<input type="hidden" name="return_id">
	<input type="hidden" name="reports_to_id">
	<input type="hidden" name="opportunity_id">
	<input type="hidden" name="contact_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<input type="hidden" name="parent_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<input type="hidden" name="contact_role">
	<input type="hidden" name="task_id">
	<input type="hidden" name="meeting_id">
	<input type="hidden" name="call_id">
	<input type="hidden" name="case_id">
	<input type="hidden" name="new_reports_to_id">
	<input type="hidden" name="email_directing_module">
	<?php echo $this->_tpl_vars['HIDDEN_PARENTS_LIST']; ?>

<?php elseif ($this->_tpl_vars['MODULE'] == 'Potentials'): ?>
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
        <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="isDuplicate" value=false>
        <input type="hidden" name="action">
        <input type="hidden" name="return_module">
        <input type="hidden" name="return_action">
        <input type="hidden" name="return_id" >
        <input type="hidden" name="contact_id">
        <input type="hidden" name="contact_role">
        <input type="hidden" name="opportunity_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="task_id">
        <input type="hidden" name="meeting_id">
        <input type="hidden" name="call_id">
        <input type="hidden" name="email_id">
        <input type="hidden" name="source_module">
        <input type="hidden" name="entity_id">
        <input type="hidden" name="convertmode">
        <input type="hidden" name="account_id" value="<?php echo $this->_tpl_vars['ACCOUNTID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Leads'): ?>
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
	<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<input type="hidden" name="isDuplicate" value=false>
	<input type="hidden" name="action">
	<input type="hidden" name="return_module">
	<input type="hidden" name="return_action">
	<input type="hidden" name="return_id">
	<input type="hidden" name="lead_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<input type="hidden" name="parent_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<input type="hidden" name="email_directing_module">
	<?php echo $this->_tpl_vars['HIDDEN_PARENTS_LIST']; ?>

<?php elseif ($this->_tpl_vars['MODULE'] == 'Products' || $this->_tpl_vars['MODULE'] == 'Vendors' || $this->_tpl_vars['MODULE'] == 'PriceBooks'): ?>
	<?php if ($this->_tpl_vars['MODULE'] == 'Products'): ?>
		<input type="hidden" name="product_id" value="<?php echo $this->_tpl_vars['id']; ?>
">
	<?php elseif ($this->_tpl_vars['MODULE'] == 'Vendors'): ?>
		<input type="hidden" name="vendor_id" value="<?php echo $this->_tpl_vars['id']; ?>
">
	<?php elseif ($this->_tpl_vars['MODULE'] == 'PriceBooks'): ?>
		<input type="hidden" name="current_language" value="">
	<?php endif; ?>
	<input type="hidden" name="parent_id" value="<?php echo $this->_tpl_vars['id']; ?>
">
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
        <input type="hidden" name="action">
        <input type="hidden" name="isDuplicate" value=false>
        <input type="hidden" name="mode">
        <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="return_module" value="<?php echo $this->_tpl_vars['RETURN_MODULE']; ?>
">
        <input type="hidden" name="return_id" value="<?php echo $this->_tpl_vars['RETURN_ID']; ?>
">
        <input type="hidden" name="return_action" value="">	
<?php elseif ($this->_tpl_vars['MODULE'] == 'Notes'): ?>
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
        <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="isDuplicate" value=false>
        <input type="hidden" name="action">
        <input type="hidden" name="return_module">
        <input type="hidden" name="return_action">
        <input type="hidden" name="return_id">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Emails'): ?>
        <input type="hidden" name="module" value="Emails">
        <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="isDuplicate" value=false>
        <input type="hidden" name="action">
        <input type="hidden" name="contact_id" value="<?php echo $this->_tpl_vars['CONTACT_ID']; ?>
">
        <input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['USER_ID']; ?>
">
        <input type="hidden" name="return_module" value="<?php echo $this->_tpl_vars['RETURN_MODULE']; ?>
">
        <input type="hidden" name="return_action" value="<?php echo $this->_tpl_vars['RETURN_ACTION']; ?>
">
        <input type="hidden" name="return_id" value="<?php echo $this->_tpl_vars['RETURN_ID']; ?>
">
        <input type="hidden" name="source_module">
        <input type="hidden" name="entity_id">
<?php elseif ($this->_tpl_vars['MODULE'] == 'HelpDesk'): ?>
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
        <input type="hidden" name="action">
        <input type="hidden" name="mode">
        <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="return_module" value="<?php echo $this->_tpl_vars['RETURN_MODULE']; ?>
">
        <input type="hidden" name="return_id" value="<?php echo $this->_tpl_vars['RETURN_ID']; ?>
">
        <input type="hidden" name="return_action" value="">
        <input type="hidden" name="isDuplicate">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Faq'): ?>
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
        <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="isDuplicate" value=false>
        <input type="hidden" name="action">
        <input type="hidden" name="return_module">
        <input type="hidden" name="return_action">
        <input type="hidden" name="return_id">
        <input type="hidden" name="source_module">
        <input type="hidden" name="entity_id">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Quotes'): ?>
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
        <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="isDuplicate" value=false>
        <input type="hidden" name="action">
        <input type="hidden" name="convertmode">
        <input type="hidden" name="return_module">
        <input type="hidden" name="return_action">
        <input type="hidden" name="return_id">
        <input type="hidden" name="member_id">
        <input type="hidden" name="opportunity_id">
        <input type="hidden" name="case_id">
        <input type="hidden" name="task_id">
        <input type="hidden" name="meeting_id">
        <input type="hidden" name="call_id">
        <input type="hidden" name="email_id">
        <input type="hidden" name="source_module">
        <input type="hidden" name="entity_id">
<?php elseif ($this->_tpl_vars['MODULE'] == 'PurchaseOrder' || $this->_tpl_vars['MODULE'] == 'SalesOrder' || $this->_tpl_vars['MODULE'] == 'Invoice'): ?>
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
        <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="isDuplicate" value=false>
        <input type="hidden" name="action">
        <input type="hidden" name="return_module">
        <input type="hidden" name="return_action">
        <input type="hidden" name="return_id">
        <input type="hidden" name="member_id">
        <input type="hidden" name="opportunity_id">
        <input type="hidden" name="case_id">
        <input type="hidden" name="task_id">
        <input type="hidden" name="meeting_id">
        <input type="hidden" name="call_id">
        <input type="hidden" name="email_id">
        <input type="hidden" name="source_module">
        <input type="hidden" name="entity_id">
       	<input type="hidden" name="convertmode">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Calendar'): ?>
	<input type="hidden" name="module" value="Calendar">
        <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="activity_mode" value="<?php echo $this->_tpl_vars['ACTIVITY_MODE']; ?>
">
        <input type="hidden" name="isDuplicate" value=false>
        <input type="hidden" name="action">
        <input type="hidden" name="return_module">
        <input type="hidden" name="return_action">
        <input type="hidden" name="return_id">
        <input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['USER_ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Campaigns'): ?>
        <input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
        <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="isDuplicate" value=false>
        <input type="hidden" name="action">
        <input type="hidden" name="return_module">
        <input type="hidden" name="return_action">
        <input type="hidden" name="return_id">
<?php else: ?>
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
        <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="isDuplicate" value=false>
        <input type="hidden" name="action">
        <input type="hidden" name="return_module">
        <input type="hidden" name="return_action">
        <input type="hidden" name="return_id">
<?php endif; ?>

