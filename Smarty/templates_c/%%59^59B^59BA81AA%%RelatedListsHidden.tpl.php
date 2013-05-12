<?php /* Smarty version 2.6.18, created on 2013-01-17 18:28:58
         compiled from RelatedListsHidden.tpl */ ?>

<form border="0" action="index.php" method="post" name="form" id="form">
<input type="hidden" name="module">
<input type="hidden" name="mode">
<input type="hidden" name="return_module" id="return_module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
<?php if ($this->_tpl_vars['SinglePane_View'] == 'true'): ?>
	<input type="hidden" name="return_action" value="DetailView">
<?php else: ?>
	<input type="hidden" name="return_action" value="CallRelatedList">
<?php endif; ?>
<input type="hidden" name="return_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<input type="hidden" name="parenttab" id="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
<input type="hidden" name="action">
<?php if ($this->_tpl_vars['MODULE'] == 'Calendar'): ?>
	<input type="hidden" name="activity_mode" value="<?php echo $this->_tpl_vars['ACTIVITY_MODE']; ?>
">
	<input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['USER_ID']; ?>
">
	<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
        <input type="hidden" name="account_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<?php echo $this->_tpl_vars['HIDDEN_PARENTS_LIST']; ?>

<?php elseif ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
        <input type="hidden" name="contact_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
        <input type="hidden" name="account_id" value="<?php echo $this->_tpl_vars['accountid']; ?>
">
	<input type="hidden" name="campaignid" value="<?php echo $this->_tpl_vars['campaignid']; ?>
">
	<?php echo $this->_tpl_vars['HIDDEN_PARENTS_LIST']; ?>

<?php elseif ($this->_tpl_vars['MODULE'] == 'Campaigns'): ?>
        <input type="hidden" name="campaignid" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Leads'): ?>
	<input type="hidden" name="lead_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<input type="hidden" name="campaignid" value="<?php echo $this->_tpl_vars['campaignid']; ?>
">
	<?php echo $this->_tpl_vars['HIDDEN_PARENTS_LIST']; ?>

<?php elseif ($this->_tpl_vars['MODULE'] == 'Potentials'): ?>
        <input type="hidden" name="potential_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Quotes'): ?>
        <input type="hidden" name="quoteid" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'SalesOrder'): ?>
        <input type="hidden" name="salesorderid" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'PurchaseOrder'): ?>
	<input type="hidden" name="purchaseorderid" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Invoice'): ?>
        <input type="hidden" name="invoiceid" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Products'): ?>
        <input type="hidden" name="product_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Vendors'): ?>
	<input type="hidden" name="vendor_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'PriceBooks'): ?>
	<input type="hidden" name="pricebook_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Emails'): ?>
        <input type="hidden" name="email_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
	<input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['USER_ID']; ?>
">
	<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'HelpDesk'): ?>
        <input type="hidden" name="ticket_id" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Memdays'): ?>
        <input type="hidden" name="convertmode" value="invoicetodelivery">

<?php endif; ?>
