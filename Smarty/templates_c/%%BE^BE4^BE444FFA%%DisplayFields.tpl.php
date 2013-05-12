<?php /* Smarty version 2.6.18, created on 2013-01-17 18:29:02
         compiled from DisplayFields.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'DisplayFields.tpl', 59, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['subdata']):
?>
	<?php if ($this->_tpl_vars['header'] == 'Product Details'): ?>
		<tr>
	<?php else: ?>
		<tr style="height:25px">
	<?php endif; ?>
	<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
		<?php $this->assign('uitype', ($this->_tpl_vars['maindata'][0][0])); ?>
		<?php $this->assign('fldlabel', ($this->_tpl_vars['maindata'][1][0])); ?>
		<?php $this->assign('fldlabel_sel', ($this->_tpl_vars['maindata'][1][1])); ?>
		<?php $this->assign('fldlabel_combo', ($this->_tpl_vars['maindata'][1][2])); ?>
		<?php $this->assign('fldname', ($this->_tpl_vars['maindata'][2][0])); ?>
		<?php $this->assign('fldvalue', ($this->_tpl_vars['maindata'][3][0])); ?>
		<?php $this->assign('secondvalue', ($this->_tpl_vars['maindata'][3][1])); ?>
		<?php $this->assign('thirdvalue', ($this->_tpl_vars['maindata'][3][2])); ?>
		<?php $this->assign('fourthvalue', ($this->_tpl_vars['maindata'][3][3])); ?>
		<?php $this->assign('vt_tab', ($this->_tpl_vars['maindata'][4][0])); ?>
		<?php $this->assign('readonly', ($this->_tpl_vars['maindata'][0][1])); ?>
		<?php $this->assign('mandatory', ($this->_tpl_vars['maindata'][0][2])); ?>
		<?php if ($this->_tpl_vars['readonly'] == '0'): ?>
		        <?php $this->assign('disable', ' disabled '); ?>
		<?php else: ?>
		        <?php $this->assign('disable', ' '); ?>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['mandatory'] == '1'): ?>
		        <?php $this->assign('required', " <font color='red'>*</font> "); ?>
		<?php else: ?>
		        <?php $this->assign('required', ' '); ?>
		<?php endif; ?>

		<?php if ($this->_tpl_vars['uitype'] == 2): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id="<?php echo $this->_tpl_vars['fldname']; ?>
" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
			</td>
		<?php elseif ($this->_tpl_vars['uitype'] == 11 || $this->_tpl_vars['uitype'] == 1 || $this->_tpl_vars['uitype'] == 13 || $this->_tpl_vars['uitype'] == 7 || $this->_tpl_vars['uitype'] == 9): ?>
			<td width="20%" class="dvtCellLabel" align="right"><?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>
</td>
			<td width="30%" align="left" class="dvtCellInfo"><input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id ="<?php echo $this->_tpl_vars['fldname']; ?>
" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"></td>
		<?php elseif ($this->_tpl_vars['uitype'] == 10): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 readonly name="<?php echo $this->_tpl_vars['thirdvalue']; ?>
" type="text" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
"><input<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" type="hidden" value="<?php echo $this->_tpl_vars['secondvalue']; ?>
">&nbsp;<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
select.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" LANGUAGE=javascript onclick="return openUITenPopup('<?php echo $this->_tpl_vars['fourthvalue']; ?>
');" align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img<?php echo $this->_tpl_vars['disable']; ?>
  src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
clear_field.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_LABEL']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_LABEL']; ?>
" LANGUAGE=javascript onClick="document.EditView.<?php echo $this->_tpl_vars['thirdvalue']; ?>
.value=''; document.EditView.<?php echo $this->_tpl_vars['fldname']; ?>
.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		<?php elseif ($this->_tpl_vars['uitype'] == 19 || $this->_tpl_vars['uitype'] == 20): ?>
			<!-- In Add Comment are we should not display anything -->
			<?php if ($this->_tpl_vars['fldlabel'] == $this->_tpl_vars['MOD']['LBL_ADD_COMMENT']): ?>
				<?php $this->assign('fldvalue', ""); ?>
			<?php endif; ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>

				<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td colspan=3>
            <?php if ($this->_tpl_vars['MODULE'] == 'Maillisttmps' || $this->_tpl_vars['MODULE'] == 'Qunfatmps'): ?>
				<textarea<?php echo $this->_tpl_vars['disable']; ?>
 class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'" name="<?php echo $this->_tpl_vars['fldname']; ?>
"  onBlur="this.className='detailedViewTextBox'" cols="90" style="height:200px;" ><?php echo ((is_array($_tmp=$this->_tpl_vars['fldvalue'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
                <?php else: ?>
                <textarea<?php echo $this->_tpl_vars['disable']; ?>
 class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'" name="<?php echo $this->_tpl_vars['fldname']; ?>
"  onBlur="this.className='detailedViewTextBox'" cols="90" rows="8"><?php echo ((is_array($_tmp=$this->_tpl_vars['fldvalue'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
                <?php endif; ?>
			</td>
		<?php elseif ($this->_tpl_vars['uitype'] == 21 || $this->_tpl_vars['uitype'] == 24): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>

				<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<textarea<?php echo $this->_tpl_vars['disable']; ?>
 value="<?php echo $this->_tpl_vars['fldvalue']; ?>
" name="<?php echo $this->_tpl_vars['fldname']; ?>
" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" rows=2><?php echo ((is_array($_tmp=$this->_tpl_vars['fldvalue'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
			</td>
		<?php elseif ($this->_tpl_vars['uitype'] == 15 || $this->_tpl_vars['uitype'] == 16 || $this->_tpl_vars['uitype'] == 111): ?> <!-- uitype 111 added for noneditable existing picklist values - ahmed -->
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>

				<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
			   <select<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" class="small">
				<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
					<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sel_value'] => $this->_tpl_vars['value']):
?>
						<option value="<?php echo $this->_tpl_vars['sel_value']; ?>
" <?php echo $this->_tpl_vars['value']; ?>
>                                                
                                                        <?php echo $this->_tpl_vars['sel_value']; ?>

                                                </option>
					<?php endforeach; endif; unset($_from); ?>
				<?php endforeach; endif; unset($_from); ?>
			   </select>
			</td>
        <?php elseif ($this->_tpl_vars['uitype'] == 155): ?> <!-- uitype 111 added for noneditable existing picklist values - ahmed -->
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>

				<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
			   <select<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" class="small">
				<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
						<option value="<?php echo $this->_tpl_vars['arr']['0']['0']; ?>
" <?php echo $this->_tpl_vars['arr']['1']; ?>
>                                                
                                                        <?php echo $this->_tpl_vars['arr']['0']['1']; ?>

                                                </option>
				<?php endforeach; endif; unset($_from); ?>
			   </select>
			</td>
        <?php elseif ($this->_tpl_vars['uitype'] == 1021 || $this->_tpl_vars['uitype'] == 1022 || $this->_tpl_vars['uitype'] == 1023): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>

				<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
			   <select<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" id="<?php echo $this->_tpl_vars['fldname']; ?>
" class="small" onchange="multifieldSelectChange('<?php echo $this->_tpl_vars['uitype']; ?>
','<?php echo $this->_tpl_vars['secondvalue']; ?>
','<?php echo $this->_tpl_vars['MODULE']; ?>
',this);">
				<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value']):
?>

						<option value="<?php echo $this->_tpl_vars['value'][1]; ?>
" relvalue="<?php echo $this->_tpl_vars['value'][0]; ?>
" <?php echo $this->_tpl_vars['value'][2]; ?>
>
                                                        <?php echo $this->_tpl_vars['value'][1]; ?>


				<?php endforeach; endif; unset($_from); ?>
			   </select>
			</td>
		<?php elseif ($this->_tpl_vars['uitype'] == 33): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
			   <select<?php echo $this->_tpl_vars['disable']; ?>
 MULTIPLE name="<?php echo $this->_tpl_vars['fldname']; ?>
[]" size="4" style="width:160px;" class="small">
                                                                                        <?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key_one'] => $this->_tpl_vars['arr']):
?>
				                    					<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sel_value'] => $this->_tpl_vars['value']):
?>
                    										<option value="<?php echo $this->_tpl_vars['sel_value']; ?>
" <?php echo $this->_tpl_vars['value']; ?>
><?php echo $this->_tpl_vars['sel_value']; ?>
</option>		
                    									<?php endforeach; endif; unset($_from); ?>
											<?php endforeach; endif; unset($_from); ?>
			   </select>
			</td>

		<?php elseif ($this->_tpl_vars['uitype'] == 53): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">	
				<select<?php echo $this->_tpl_vars['disable']; ?>
 name="assigned_user_id" class="small">
					<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key_one'] => $this->_tpl_vars['arr']):
?>
						<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sel_value'] => $this->_tpl_vars['value']):
?>
							<option value="<?php echo $this->_tpl_vars['key_one']; ?>
" <?php echo $this->_tpl_vars['value']; ?>
><?php echo $this->_tpl_vars['sel_value']; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
					<?php endforeach; endif; unset($_from); ?>
				</select>				
			</td>
		<?php elseif ($this->_tpl_vars['uitype'] == 54): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">				
				<select<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" class="small">
				<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key_one'] => $this->_tpl_vars['arr']):
?>
					<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sel_value'] => $this->_tpl_vars['value']):
?>
						<option value="<?php echo $this->_tpl_vars['sel_value']; ?>
" <?php echo $this->_tpl_vars['value']; ?>
><?php echo $this->_tpl_vars['sel_value']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
		<?php elseif ($this->_tpl_vars['uitype'] == 52 || $this->_tpl_vars['uitype'] == 77): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<?php if ($this->_tpl_vars['uitype'] == 52): ?>
					<select<?php echo $this->_tpl_vars['disable']; ?>
 name="assigned_user_id" class="small">
				<?php elseif ($this->_tpl_vars['uitype'] == 77): ?>
					<select<?php echo $this->_tpl_vars['disable']; ?>
 name="assigned_user_id" class="small">
				<?php else: ?>
					<select<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" class="small">
				<?php endif; ?>

				<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key_one'] => $this->_tpl_vars['arr']):
?>
					<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sel_value'] => $this->_tpl_vars['value']):
?>
						<option value="<?php echo $this->_tpl_vars['key_one']; ?>
" <?php echo $this->_tpl_vars['value']; ?>
><?php echo $this->_tpl_vars['sel_value']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
		<?php elseif ($this->_tpl_vars['uitype'] == 1004): ?>
		        <td  class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td  align="left" class="dvtCellInfo">
				<?php echo $this->_tpl_vars['fldvalue']; ?>

			</td>
		<?php elseif ($this->_tpl_vars['uitype'] == 51): ?>
			<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
				<?php $this->assign('popuptype', 'specific_account_address'); ?>
			<?php else: ?>
				<?php $this->assign('popuptype', 'specific_contact_account_address'); ?>
			<?php endif; ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 readonly name="account_name" class="detailedViewTextBox"  type="text" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
"><input<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" type="hidden" value="<?php echo $this->_tpl_vars['secondvalue']; ?>
">
                <br>①直接查客户: <input style='border: 1px solid rgb(186, 186, 186);' id='account_search_val' name='account_search_val' type="text">&nbsp;<input type='button' value='查' onclick='SearchAccountVal();'>
                <br>②浏览选客户: <img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
select.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype=<?php echo $this->_tpl_vars['popuptype']; ?>
&form=TasksEditView&form_submit=false","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img<?php echo $this->_tpl_vars['disable']; ?>
  src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
clear_field.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_LABEL']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_LABEL']; ?>
" LANGUAGE=javascript onClick="document.EditView.account_id.value=''; document.EditView.account_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		<?php elseif ($this->_tpl_vars['uitype'] == 50): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 readonly name="account_name" class="detailedViewTextBox"  type="text" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
"><input<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" type="hidden" value="<?php echo $this->_tpl_vars['secondvalue']; ?>
">
                <br>①直接查客户: <input style='border: 1px solid rgb(186, 186, 186);' id='account_search_val' name='account_search_val' type="text">&nbsp;<input type='button' value='查' onclick='SearchAccountVal();'>
                <br>②浏览选客户: <img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
select.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype=specific&form=TasksEditView&form_submit=false","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>
		<?php elseif ($this->_tpl_vars['uitype'] == 73): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 readonly class="detailedViewTextBox" name="account_name" type="text" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
"><input<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" type="hidden" value="<?php echo $this->_tpl_vars['secondvalue']; ?>
">&nbsp;
                <br>①直接查客户:<input style='border: 1px solid rgb(186, 186, 186);' id='account_search_val' name='account_search_val' type="text">&nbsp;<input type='button' value='查' onclick='SearchAccountVal();'>
                <br>②浏览选客户:<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
select.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&action=Popup&popuptype=specific_account_address&form=TasksEditView&form_submit=false","test","width=700,height=602,resizable=1,scrollbars=1");' align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		<?php elseif ($this->_tpl_vars['uitype'] == 57): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			
				<td width="30%" align="left" class="dvtCellInfo">
                  <select<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
"  id="<?php echo $this->_tpl_vars['fldname']; ?>
">
                      <?php echo $this->_tpl_vars['fldvalue']; ?>

                  </select>
                </td>
	
		<?php elseif ($this->_tpl_vars['uitype'] == 80): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 name="salesorder_name" readonly type="text"  value="<?php echo $this->_tpl_vars['fldvalue']; ?>
"><input<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" type="hidden" value="<?php echo $this->_tpl_vars['secondvalue']; ?>
">&nbsp;<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
select.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" LANGUAGE=javascript onclick='return openSOPopup()' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img<?php echo $this->_tpl_vars['disable']; ?>
  src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
clear_field.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_LABEL']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_LABEL']; ?>
" LANGUAGE=javascript onClick="document.EditView.salesorder_id.value=''; document.EditView.salesorder_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		<?php elseif ($this->_tpl_vars['uitype'] == 76): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 name="potential_name" readonly type="text"  value="<?php echo $this->_tpl_vars['fldvalue']; ?>
"><input<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" type="hidden" value="<?php echo $this->_tpl_vars['secondvalue']; ?>
">&nbsp;<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
select.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT']; ?>
" LANGUAGE=javascript onclick='return openPotentialPopup();' align="absmiddle" style='cursor:hand;cursor:pointer'>&nbsp;<img<?php echo $this->_tpl_vars['disable']; ?>
  src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
clear_field.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_LABEL']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_CLEAR_BUTTON_LABEL']; ?>
" LANGUAGE=javascript onClick="document.EditView.potential_id.value=''; document.EditView.potential_name.value='';return false;" align="absmiddle" style='cursor:hand;cursor:pointer'>
			</td>

		<?php elseif ($this->_tpl_vars['uitype'] == 17): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				
				<input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id ="<?php echo $this->_tpl_vars['fldname']; ?>
" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
">
				
			</td>

		<?php elseif ($this->_tpl_vars['uitype'] == 85): ?>
                        <td width="20%" class="dvtCellLabel" align="right">
                                <?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

                        </td>
                        <td width="30%" align="left" class="dvtCellInfo">
                                <img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
skype.gif" align="absmiddle"></img>
				<input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id ="<?php echo $this->_tpl_vars['fldname']; ?>
" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
">
				
                        </td>
		<?php elseif ($this->_tpl_vars['uitype'] == 86): ?>
                        <td width="20%" class="dvtCellLabel" align="right">
                                <?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

                        </td>
                        <td width="30%" align="left" class="dvtCellInfo">
                                <img border="0" src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
qq.gif"  align="absmiddle">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id ="<?php echo $this->_tpl_vars['fldname']; ?>
" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
">
                        </td>
		<?php elseif ($this->_tpl_vars['uitype'] == 87): ?>
                        <td width="20%" class="dvtCellLabel" align="right">
                                <?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

                        </td>
                        <td width="30%" align="left" class="dvtCellInfo">
                                <img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
msn.jpg" align="absmiddle"></img>
				<input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id ="<?php echo $this->_tpl_vars['fldname']; ?>
" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
">
                        </td>
		<?php elseif ($this->_tpl_vars['uitype'] == 88): ?>
                        <td width="20%" class="dvtCellLabel" align="right">
                                <?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

                        </td>
                        <td width="30%" align="left" class="dvtCellInfo">
                                <img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
trade.jpg" align="absmiddle">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id ="<?php echo $this->_tpl_vars['fldname']; ?>
" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
">
                        </td>
		<?php elseif ($this->_tpl_vars['uitype'] == 89): ?>
                        <td width="20%" class="dvtCellLabel" align="right">
                                <?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

                        </td>
                        <td width="30%" align="left" class="dvtCellInfo">
                                <img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
yahoo.gif" align="absmiddle">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id ="<?php echo $this->_tpl_vars['fldname']; ?>
" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'"onBlur="this.className='detailedViewTextBox'" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
">
                        </td>

		<?php elseif ($this->_tpl_vars['uitype'] == 71 || $this->_tpl_vars['uitype'] == 72): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" type="text" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"  value="<?php echo $this->_tpl_vars['fldvalue']; ?>
">
			</td>


		<?php elseif ($this->_tpl_vars['uitype'] == 5): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				

				<input<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" id="jscal_field_<?php echo $this->_tpl_vars['fldname']; ?>
" type="text"  size="11" maxlength="10" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
">
				<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
calendar.gif" id="jscal_trigger_<?php echo $this->_tpl_vars['fldname']; ?>
" onclick="javascript:displayCalendar('jscal_field_<?php echo $this->_tpl_vars['fldname']; ?>
',this)">

			</td>

		<?php elseif ($this->_tpl_vars['uitype'] == 22): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<textarea<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
" cols="30" rows="2"><?php echo $this->_tpl_vars['fldvalue']; ?>
</textarea>
			</td>

		<?php elseif ($this->_tpl_vars['uitype'] == 61): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td colspan="3" width="30%" align="left" class="dvtCellInfo">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 name="<?php echo $this->_tpl_vars['fldname']; ?>
"  type="file" value="<?php echo $this->_tpl_vars['secondvalue']; ?>
" />
				<input<?php echo $this->_tpl_vars['disable']; ?>
 type="hidden" name="id" value=""/><?php echo $this->_tpl_vars['fldvalue']; ?>

			</td>
		<?php elseif ($this->_tpl_vars['uitype'] == 104): ?><!-- Mandatory Email Fields -->			
			 <td width="20%" class="dvtCellLabel" align="right">
			 <?php echo $this->_tpl_vars['required']; ?>

			 <?php echo $this->_tpl_vars['fldlabel']; ?>

			 </td>
    			<td width="30%" align="left" class="dvtCellInfo"><input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id ="<?php echo $this->_tpl_vars['fldname']; ?>
" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"></td>
		<?php elseif ($this->_tpl_vars['uitype'] == 103): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" colspan="3" align="left" class="dvtCellInfo">
				<input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
			</td>	
			
			
		<?php elseif ($this->_tpl_vars['uitype'] == 106): ?>
			<td width="20%" class="dvtCellLabel" align="right">
				<?php echo $this->_tpl_vars['required']; ?>
<?php echo $this->_tpl_vars['fldlabel']; ?>

			</td>
			<td width="30%" align="left" class="dvtCellInfo">
				<?php if ($this->_tpl_vars['MODE'] == 'edit'): ?>
				<input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" readonly name="<?php echo $this->_tpl_vars['fldname']; ?>
" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				<?php else: ?>
				<input<?php echo $this->_tpl_vars['disable']; ?>
 type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
" class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
				<?php endif; ?>
			</td>

		
		
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
   </tr>
<?php endforeach; endif; unset($_from); ?>