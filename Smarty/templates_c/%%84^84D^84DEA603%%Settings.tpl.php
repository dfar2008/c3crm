<?php /* Smarty version 2.6.18, created on 2013-07-01 16:18:42
         compiled from Settings.tpl */ ?>
<!--	dree	-->
<LINK href="themes/bootcss/css/Setting.css" type="text/css" rel=stylesheet>
<div class="container-fluid" style="height:602px;">
	   <!--Dashboad-->
	<div class="container-fluid" style="height:602px;">
		<div class="row-fluid">
			<div class="span2" style="margin-left:-10px;">
				<div class="accordion" id="settingion1" style="overflow:auto;height:580px;">
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Settings/SettingLeft.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</div>
			</div>

			<div class="span10" style="margin-left:10px;">
				<!--	Setting		-->
				<div class="row-fluid box" style="height:602px;">
					<div class="tab-header">
						<?php echo $this->_tpl_vars['RELSETHEAD']; ?>

					</div>
					  <div class="padded" style="overflow:auto;height:520px;">

							<form action="index.php" method="post" name="settingform" id="settingform">
								<input type="hidden" name="module" value="Settings">
								<input type="hidden" name="action">
								<input type="hidden" name="parenttab" value="Settings">
								<input type="hidden" name="settype" value="<?php echo $this->_tpl_vars['SETTYPE']; ?>
">
								<input type="hidden" name="settingmode" value="<?php echo $this->_tpl_vars['SETTINGMODE']; ?>
">
								<input type="hidden" name="issubmit" value="1">
								<?php if ($this->_tpl_vars['SETTYPE'] == 'SmsUser'): ?>
									<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Settings/SmsUser.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
								<?php elseif ($this->_tpl_vars['SETTYPE'] == 'CustomBlockList'): ?>
									<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Settings/CustomBlockList.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
								<?php endif; ?>
							</form>
					  </div>
				</div>
					
				</div>
				<!--	/Setting	-->
			</div>
	</div></div>
</div>