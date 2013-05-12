<?php /* Smarty version 2.6.18, created on 2013-01-17 18:28:57
         compiled from Accounts/DetailView.tpl */ ?>
<script type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
.js"></script>
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr><td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List_details.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td></tr>
<tr><td>
<!-- Contents -->
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center  >
<tr >
	
	<td  valign=top width="100%">
		<!-- PUBLIC CONTENTS STARTS-->
		<div class="small" style="padding:0px">
		
		<!-- Account details tabs -->
		<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
        <tr>
					<td>
						<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
						   <tr>
							<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
						   </tr>
						</table>
					</td>
				   </tr>
		<tr>
			<td valign=top align=left >
                <table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace" >
				<tr>

					<td align=left>
					<!-- content cache -->
					
				<table border=0 cellspacing=0 cellpadding=0 width=100%>
                <tr>
					<td style="padding:5px">
					<!-- Command Buttons -->
				<form action="index.php" method="post" name="DetailView" id="form">
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'DetailViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				    <table border=0 cellspacing=0 cellpadding=0 width=100%>
					<?php echo '<tr><td  colspan=4 style="padding:5px"><table border=0 cellspacing=0 cellpadding=0 width=100% class="small"><tr><td><input title="'; ?><?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?><?php echo '" accessKey="'; ?><?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?><?php echo '" class="crmbutton small edit" onclick="this.form.return_module.value=\''; ?><?php echo $this->_tpl_vars['MODULE']; ?><?php echo '\'; this.form.return_action.value=\'DetailView\'; this.form.return_id.value=\''; ?><?php echo $this->_tpl_vars['ID']; ?><?php echo '\';this.form.module.value=\''; ?><?php echo $this->_tpl_vars['MODULE']; ?><?php echo '\';this.form.action.value=\'EditView\'" type="submit" name="Edit" value="&nbsp;'; ?><?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?><?php echo '&nbsp;">&nbsp;<input title="'; ?><?php echo $this->_tpl_vars['APP']['LBL_LIST_BUTTON_TITLE']; ?><?php echo '" class="crmbutton small edit" onclick="document.location.href=\'index.php?module='; ?><?php echo $this->_tpl_vars['MODULE']; ?><?php echo '&action=index&parenttab='; ?><?php echo $this->_tpl_vars['CATEGORY']; ?><?php echo '\'" type="button" name="ListView" value="&nbsp;'; ?><?php echo $this->_tpl_vars['APP']['LBL_LIST_BUTTON_LABEL']; ?><?php echo '&nbsp;">&nbsp;</td><td align=right><!--<input type="button" value=" 选择新增 " class="crmbutton small edit" onclick="return select_add(this, \'selectadd\', \'Accounts\',\''; ?><?php echo $this->_tpl_vars['ID']; ?><?php echo '\')"  />--><a id="moreadd" href="index.php?module=Accounts&action=DetailView&record='; ?><?php echo $this->_tpl_vars['ID']; ?><?php echo '" target="main" onmouseover="fnDropDown(this,\'selectadd\');" >更多新增操作<img  border="0" src="themes/images/collapse.gif"></a>&nbsp;<input title="'; ?><?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_TITLE']; ?><?php echo '" accessKey="'; ?><?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_KEY']; ?><?php echo '" class="crmbutton small create" onclick="this.form.return_module.value=\''; ?><?php echo $this->_tpl_vars['MODULE']; ?><?php echo '\'; this.form.return_action.value=\'DetailView\'; this.form.isDuplicate.value=\'true\';this.form.module.value=\''; ?><?php echo $this->_tpl_vars['MODULE']; ?><?php echo '\'; this.form.action.value=\'EditView\'" type="submit" name="Duplicate" value="'; ?><?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_LABEL']; ?><?php echo '">&nbsp;<input title="'; ?><?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_TITLE']; ?><?php echo '" accessKey="'; ?><?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_KEY']; ?><?php echo '" class="crmbutton small delete" onclick="this.form.return_module.value=\''; ?><?php echo $this->_tpl_vars['MODULE']; ?><?php echo '\'; this.form.return_action.value=\'index\'; this.form.action.value=\'Delete\'; return confirm(\''; ?><?php echo $this->_tpl_vars['APP']['NTC_DELETE_CONFIRMATION']; ?><?php echo '\')" type="submit" name="Delete" value="'; ?><?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_LABEL']; ?><?php echo '">&nbsp;</td></tr></table></td></tr>'; ?>

						     <tr><td>
						<?php $_from = $this->_tpl_vars['BLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
							<!-- Detailed View Code starts here-->
							<table border=0 cellspacing=0 cellpadding=0 width=100% class="small" style="padding-bottom:10px;">
							<tr>
							<td width="20%" height="1"></td><td height="1" width="30%"></td>
							<td width="20%" height="1"></td><td height="1" width="30%"></td>
							</tr>							
						    <tr style="height:25px;"><?php echo ''; ?><?php if ($this->_foreach['listviewforeach']['iteration'] > 1): ?><?php echo '<td colspan=4 class="dvInnerHeader" style="cursor:Pointer;" onclick="ToggleGroupContent(\'Gsub'; ?><?php echo $this->_foreach['listviewforeach']['iteration']; ?><?php echo '\',\'Gimg'; ?><?php echo $this->_foreach['listviewforeach']['iteration']; ?><?php echo '\')">                                <img id="Gimg'; ?><?php echo $this->_foreach['listviewforeach']['iteration']; ?><?php echo '" border="0" src="themes/images/expand.gif"><b>'; ?><?php echo $this->_tpl_vars['header']; ?><?php echo '</b>'; ?><?php else: ?><?php echo '<td colspan=4 class="dvInnerHeader" style="cursor:Pointer;" ><b>'; ?><?php echo $this->_tpl_vars['header']; ?><?php echo '</b>'; ?><?php endif; ?><?php echo '</td>'; ?>

					        </tr>
                              <?php if ($this->_foreach['listviewforeach']['iteration'] > 1): ?>
                                 <tr>
                                 <td colspan=4>
                                <div id="Gsub<?php echo $this->_foreach['listviewforeach']['iteration']; ?>
" style="display:none;">
                                <table  border=0 cellspacing=0 cellpadding=0 width=100% class="small">
                             <?php else: ?>
                             	 <tr>
                                 <td colspan=4>
                                 <table  border=0 cellspacing=0 cellpadding=0 width=100% class="small">
                              <?php endif; ?>
                               <?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['detail']):
?>
                                 <tr style="height:25px" >
                                <?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['data']):
?>
                                   <?php $this->assign('keyid', $this->_tpl_vars['data']['ui']); ?>
                                   <?php $this->assign('keyval', $this->_tpl_vars['data']['value']); ?>
                                   <?php $this->assign('keyseclink', $this->_tpl_vars['data']['link']); ?>
                                   <?php if ($this->_tpl_vars['label'] != ''): ?>
                                    <td class="dvtCellLabel" align=right width="25%"><?php echo $this->_tpl_vars['label']; ?>
</td>								
                                    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DetailViewFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                   <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?>
                                  </tr>	
                               <?php endforeach; endif; unset($_from); ?>
                              <?php if ($this->_foreach['listviewforeach']['iteration'] > 1): ?>
                                   </table>
                              	 </div>	
                              	 </td>
                               </tr>
                               <?php else: ?>
                                 </table>
                              	 </td>
                               </tr>
                              <?php endif; ?>
						   </table>
                     	     </td>
					   </tr>
		<tr><td>
			<?php endforeach; endif; unset($_from); ?>
                     
			</td>
                </tr>

</form>
		
		</table>

		</td>
       
		</tr>
		</table>
		
		</div>
		<!-- PUBLIC CONTENTS STOPS-->
	</td>
</tr>
<tr>
<td>
	
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'RelatedListNew.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
</td>
</tr>

</table>
</td>
</tr></table>
</td>
</tr></table>
