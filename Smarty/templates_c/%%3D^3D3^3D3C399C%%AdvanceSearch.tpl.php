<?php /* Smarty version 2.6.18, created on 2013-05-10 11:29:37
         compiled from AdvanceSearch.tpl */ ?>

<div id="advSearch">
<form name="advSearch" action="index.php" onsubmit="return false;">
<input type="hidden" name="searchtype" value="advance">
<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
<input type="hidden" name="action" value="index">
<input type="hidden" name="query" value="true">
<input type="hidden" name="search_cnt">
		<table  cellspacing=0 cellpadding=5 width=98% class="searchUIAdv1 small" align="center" border=0>
			<tr>
					<td class="searchUIName small" nowrap align="left"><span class="moduleName"><?php echo $this->_tpl_vars['APP']['LBL_SEARCH']; ?>
</span></td>
					<?php if ($this->_tpl_vars['SEARCHMATCHTYPE'] == 'all'): ?>
					<td nowrap class="small"><b><input name="matchtype" type="radio" value="all" checked>&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_ADV_SEARCH_MSG_ALL']; ?>
</b></td>
					<td nowrap width=60% class="small" ><b><input name="matchtype" type="radio" value="any" >&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_ADV_SEARCH_MSG_ANY']; ?>
</b></td>
					<?php else: ?>
					<td nowrap class="small"><b><input name="matchtype" type="radio" value="all">&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_ADV_SEARCH_MSG_ALL']; ?>
</b></td>
					<td nowrap width=60% class="small" ><b><input name="matchtype" type="radio" value="any" checked>&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_ADV_SEARCH_MSG_ANY']; ?>
</b></td>
					<?php endif; ?>
			</tr>
		</table>
		<table cellpadding="2" cellspacing="0" width="98%" align="center" class="searchUIAdv2 small" border=0>
			<tr>
				<td align="center" class="small" width=90%>
				<div id="fixed" style="position:relative;width:98%;height:300px;padding:0px; overflow:auto;border:1px solid #CCCCCC;background-color:#ffffff" class="small">
					<table border=0 width=95%>
					<tr>
					<td align=left>
						<table width="100%"  border="0" cellpadding="2" cellspacing="0" id="adSrc" align="left">
						
							<?php if ($this->_tpl_vars['SEARCHCONSHTML']): ?>
							   <?php $_from = $this->_tpl_vars['SEARCHCONSHTML']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cons']):
        $this->_foreach['foo']['iteration']++;
?>
							     <tr  >
								<td width="31%">
								<select name="Fields<?php echo ($this->_foreach['foo']['iteration']-1); ?>
" class="detailedViewTextBox">
								<?php echo $this->_tpl_vars['cons']['0']; ?>

								</select>
								</td>
								<td width="32%">
								<select name="Condition<?php echo ($this->_foreach['foo']['iteration']-1); ?>
" class="detailedViewTextBox">
									<?php echo $this->_tpl_vars['cons']['1']; ?>

								</select>
								</td>
								<td width="32%">
								<input type="text" name="Srch_value<?php echo ($this->_foreach['foo']['iteration']-1); ?>
" value="<?php echo $this->_tpl_vars['cons']['2']; ?>
" class="detailedViewTextBox">
								</td>
							        </tr>
							     <?php endforeach; endif; unset($_from); ?>
							<?php else: ?>
							     <tr  >
								<td width="31%">
								<select name="Fields0" class="detailedViewTextBox">
								<?php echo $this->_tpl_vars['FIELDNAMES']; ?>

								</select>
								</td>
								<td width="32%">
								<select name="Condition0" class="detailedViewTextBox">
									<?php echo $this->_tpl_vars['CRITERIA']; ?>

								</select>
								</td>
								<td width="32%">
								<input type="text" name="Srch_value0" class="detailedViewTextBox">
								</td>
							     </tr>
							<?php endif; ?>
						
						</table>
					</td>
					</tr>
				</table>
				</div>	
				</td>
			</tr>
		</table>
			
		<table border=0 cellspacing=0 cellpadding=5 width=98% class="searchUIAdv3 small" align="center">
		<tr>
			<td align=left width=40%>
						<input type="button" name="more" value=" <?php echo $this->_tpl_vars['APP']['LBL_MORE_BUTTON']; ?>
 " onClick="fnAddSrch('<?php echo $this->_tpl_vars['FIELDNAMES']; ?>
','<?php echo $this->_tpl_vars['CRITERIA']; ?>
')" class="crmbuttom small edit" >
						<input name="button" type="button" value=" <?php echo $this->_tpl_vars['APP']['LBL_FEWER_BUTTON']; ?>
 " onclick="delRow()" class="crmbuttom small edit" >
			</td>
			<td align=left class="small">
			 <input type="button" class="crmbutton small create" value=" <?php echo $this->_tpl_vars['APP']['LBL_SEARCH_NOW_BUTTON']; ?>
 " onClick="totalnoofrows();callSearch('Advanced');">
			 <input type="button" class="crmbutton small edit" value=" <?php echo $this->_tpl_vars['APP']['LBL_SEARCH_CLEAR']; ?>
 " onClick="clearSearchResult('<?php echo $this->_tpl_vars['MODULE']; ?>
','advSearch');">
			</td>
            
		</tr>
	</table>
    </form>
</div>	