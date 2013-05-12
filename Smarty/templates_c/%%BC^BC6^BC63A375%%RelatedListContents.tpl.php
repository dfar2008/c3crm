<?php /* Smarty version 2.6.18, created on 2013-01-17 18:28:58
         compiled from RelatedListContents.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'RelatedListContents.tpl', 22, false),)), $this); ?>
<link href="include/ajaxtabs/ajaxtabs.css" type="text/css" rel="stylesheet"/>
<?php echo '
<style>
 .newtaba li a{
	padding-top:5px; 
	padding-bottom:5px;
	font-weight:normal;
 }
 .newtaba li a.selected{
	padding-top:5px; 
	padding-bottom:5px; 
	font-weight:bold;
 }
</style>
'; ?>

<?php if ($this->_tpl_vars['SinglePane_View'] == 'true'): ?>
	<?php $this->assign('return_modname', 'DetailView'); ?>
<?php else: ?>
	<?php $this->assign('return_modname', 'CallRelatedList'); ?>
<?php endif; ?>

<?php if (count($this->_tpl_vars['RELATEDLISTS']) != 1): ?>
<ul id="countrytabs" class="shadetabs newtaba" style=" white-space:nowrap; border-bottom:1px solid #999999;padding-bottom:8px;">
<?php $_from = $this->_tpl_vars['RELATEDLISTS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
        $this->_foreach['foo']['iteration']++;
?>
  <?php if (($this->_foreach['foo']['iteration']-1) == 0): ?>
   <li><a href="javascript:;" onClick="getTabViewForRelated('<?php echo $this->_tpl_vars['header']; ?>
');return false;" id="<?php echo $this->_tpl_vars['header']; ?>
" rel="#default" class="tablink selected">
   <input type="hidden" id="typeid" value="<?php echo $this->_tpl_vars['header']; ?>
"/>
  <?php else: ?>
   <li><a href="javascript:;" onClick="getTabViewForRelated('<?php echo $this->_tpl_vars['header']; ?>
');return false;" id="<?php echo $this->_tpl_vars['header']; ?>
" rel="#default" class="tablink">
  <?php endif; ?>

 <?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['header']] != ''): ?>
    <?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['header']] == '产品'): ?>
    &nbsp;已购买产品
    <?php else: ?>
    &nbsp;<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['header']]; ?>

    <?php endif; ?>
<?php else: ?> 
    <?php if ($this->_tpl_vars['header'] == '产品'): ?>
    &nbsp;已购买产品
    <?php else: ?>
    &nbsp;<?php echo $this->_tpl_vars['header']; ?>

    <?php endif; ?>
<?php endif; ?>
</li></a>
<?php if (($this->_foreach['foo']['iteration']-1) != 0 && ($this->_foreach['foo']['iteration']-1) % 9 == 0): ?>
</ul>
<ul id="countrytabs" class="shadetabs newtaba" style=" white-space:nowrap;border-bottom:1px solid #999999;padding-top:5px;padding-bottom:6px;">
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</ul>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['RELATEDLISTS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
        $this->_foreach['foo']['iteration']++;
?>
<?php if (($this->_foreach['foo']['iteration']-1) == 0): ?>
<div id="<?php echo $this->_tpl_vars['header']; ?>
1"  style="display:;">
<?php else: ?>
<div id="<?php echo $this->_tpl_vars['header']; ?>
1" style="display:none;">
<?php endif; ?>

<table border=0 cellspacing=0 cellpadding=0 width=100% class="small" style="border-bottom:1px solid #999999;padding:5px;">
        <tr >
                <?php if ($this->_tpl_vars['detail'] != ''): ?>
                <td align=left><!--<?php echo $this->_tpl_vars['detail']['navigation']['0']; ?>
--></td>
                <?php echo $this->_tpl_vars['detail']['navigation']['1']; ?>

                <?php endif; ?>
                <td align=right>
			<?php if ($this->_tpl_vars['header'] == 'Potentials'): ?>			        
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Potential']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Potentials'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Potential']; ?>
">                               
				 </td>                       
                        
			<?php elseif ($this->_tpl_vars['header'] == 'Accounts'): ?>
				
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Account']; ?>
" accessyKey="F" class="crmbutton small edit" onclick="this.form.action.value='EditView';this.form.module.value='Accounts'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Account']; ?>
"></td>
				
			<?php elseif ($this->_tpl_vars['header'] == 'Contacts'): ?>				
				
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Contact']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Contacts'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Contact']; ?>
"></td>

			<?php elseif ($this->_tpl_vars['header'] == 'Attachments'): ?>
			        <?php if ($this->_tpl_vars['MODULE'] != 'Maillists'): ?>
						<input type="hidden" name="fileid">				
						<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_ATTACHMENT']; ?>
" accessyKey="F" class="crmbutton small create" onclick="window.open('upload.php?return_action=<?php echo $this->_tpl_vars['return_modname']; ?>
&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_id=<?php echo $this->_tpl_vars['ID']; ?>
','Attachments','width=500,height=300,resizable=1,scrollbars=1');" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_ATTACHMENT']; ?>
">
				<?php endif; ?>
				</td>
			<?php elseif ($this->_tpl_vars['header'] == 'Notes'): ?>
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Note']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView'; this.form.return_action.value='<?php echo $this->_tpl_vars['return_modname']; ?>
'; this.form.module.value='Notes'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Note']; ?>
">&nbsp;
				<input type="hidden" name="fileid">
				</td>
			<?php elseif ($this->_tpl_vars['header'] == 'Sales Order'): ?>				
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['SalesOrder']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='SalesOrder'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['SalesOrder']; ?>
"></td>				
			
			<?php elseif ($this->_tpl_vars['header'] == 'ModuleComments'): ?>
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['ModuleComments']; ?>
" accessyKey="F" class="crmbutton small create" onclick="window.open('addComments.php?return_action=<?php echo $this->_tpl_vars['return_modname']; ?>
&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&crmid=<?php echo $this->_tpl_vars['ID']; ?>
','Comments','width=500,height=300');" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['ModuleComments']; ?>
"></td>
			<?php elseif ($this->_tpl_vars['header'] == 'Memdays'): ?>
				<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
					<input type="submit" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Memdays']; ?>
" class="crmbutton small create"
							onclick="this.form.action.value='EditView';this.form.module.value='Memdays'"/>
				<?php endif; ?>
            <?php elseif ($this->_tpl_vars['header'] == 'Qunfas'): ?>
				<input title=" 发送短信 " accessyKey="F" class="crmbutton small create" onclick="javascript:location.href='index.php?module=Qunfas&action=ListView&idstring=<?php echo $this->_tpl_vars['ID']; ?>
&modulename=<?php echo $this->_tpl_vars['MODULE']; ?>
'" type="button" name="button" value=" 发送短信 "></td>
			<?php elseif ($this->_tpl_vars['header'] == 'Maillists'): ?>
				<input title=" 发送邮件 " accessyKey="F" class="crmbutton small create" onclick="javascript:location.href='index.php?module=Maillists&action=ListView&idstring=<?php echo $this->_tpl_vars['ID']; ?>
&modulename=<?php echo $this->_tpl_vars['MODULE']; ?>
'" type="button" name="button" value=" 发送邮件 "></td>
			
            <?php elseif ($this->_tpl_vars['header'] == 'Activity History'): ?>
                &nbsp;</td>
            <?php endif; ?>
        </tr>
</table>
<?php if ($this->_tpl_vars['detail'] != ''): ?>
	<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
?>
		<?php if ($this->_tpl_vars['header'] == 'header'): ?>
			<table border=0 cellspacing=1 cellpadding=3 width=100% style="background-color:#eaeaea;" class="small">
				<tr style="height:25px;background:#DFEBEF" >
				<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['headerfields']):
?>
					<td class="lvtCol"><?php echo $this->_tpl_vars['headerfields']; ?>
</td>
				<?php endforeach; endif; unset($_from); ?>
                                </tr>
		<?php elseif ($this->_tpl_vars['header'] == 'entries'): ?>
			<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
?>
				<tr bgcolor=white>
				<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['listfields']):
?>
	                                 <td><?php echo $this->_tpl_vars['listfields']; ?>
</td>
				<?php endforeach; endif; unset($_from); ?>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</table>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<table style="background-color:#eaeaea;color:eeeeee" border="0" cellpadding="3" cellspacing="1" width="100%" class="small">
		<tr style="height: 25px;" bgcolor="white">
			<td><i><?php echo $this->_tpl_vars['APP']['LBL_NONE_INCLUDED']; ?>
</i></td>
		</tr>
	</table>
<?php endif; ?>

<br><br>
</div>
<?php endforeach; endif; unset($_from); ?>
<div id="selectadd" class="drop_mnu" onMouseOut="fnHideDrop('selectadd')" onMouseOver="fnShowDrop('selectadd')" >
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Notes&action=EditView&return_module=Accounts&return_action=DetailView&return_id=<?php echo $this->_tpl_vars['ID']; ?>
'" class="drop_down"><?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Notes']; ?>
</a></td></tr>

<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Accounts&action=EditView'" class="drop_down"><?php echo $this->_tpl_vars['APP']['LNK_NEW_ACCOUNT']; ?>
</a></td></tr>
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=SalesOrder&action=EditView&return_module=Accounts&return_action=DetailView&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&account_id=<?php echo $this->_tpl_vars['ID']; ?>
'" class="drop_down"><?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
  <?php echo $this->_tpl_vars['APP']['SalesOrder']; ?>
</a></td></tr>
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Memdays&action=EditView&return_module=Accounts&return_action=DetailView&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&convertmode=invoicetodelivery'" class="drop_down"><?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Memdays']; ?>
</a></td></tr>
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Contacts&action=EditView&return_module=Accounts&return_action=DetailView&return_id=<?php echo $this->_tpl_vars['ID']; ?>
'" class="drop_down"><?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Contacts']; ?>
</a></td></tr>
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Maillists&action=ListView&idstring=<?php echo $this->_tpl_vars['ID']; ?>
&modulename=Accounts'" class="drop_down"> 发送邮件 </a></td></tr>
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Qunfas&action=ListView&idstring=<?php echo $this->_tpl_vars['ID']; ?>
&modulename=Accounts'" class="drop_down"> 发送短信 </a></td></tr>

</table>
</div>