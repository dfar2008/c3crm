<?php /* Smarty version 2.6.18, created on 2013-01-17 18:28:57
         compiled from DetailViewFields.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'DetailViewFields.tpl', 36, false),)), $this); ?>
		<?php if ($this->_tpl_vars['keyid'] == '1' || $this->_tpl_vars['keyid'] == 2 || $this->_tpl_vars['keyid'] == '11' || $this->_tpl_vars['keyid'] == '7' || $this->_tpl_vars['keyid'] == '9' || $this->_tpl_vars['keyid'] == '55' || $this->_tpl_vars['keyid'] == '71' || $this->_tpl_vars['keyid'] == '72'): ?> <!--TextBox-->
                                         	  <td width=25% class="dvtCellInfo" align="left">&nbsp;
							         <?php if ($this->_tpl_vars['data']['fldname'] == 'phone' || $this->_tpl_vars['data']['fldname'] == 'contactmobile'): ?>
                                 	 <a href="index.php?module=Qunfas&action=ListView&idstring=<?php echo $this->_tpl_vars['ID']; ?>
&modulename=<?php echo $this->_tpl_vars['MODULE']; ?>
" target="main"><?php echo $this->_tpl_vars['keyval']; ?>
</a>
                                      <?php else: ?>
                                         <?php echo $this->_tpl_vars['keyval']; ?>
 
                                      <?php endif; ?>                                            
                                                  </td>
                                             <?php elseif ($this->_tpl_vars['keyid'] == '13'): ?> <!--Email-->
                                                  <td width=25% class="dvtCellInfo" align="left">&nbsp;
						 					 <a href="index.php?module=Maillists&action=ListView&idstring=<?php echo $this->_tpl_vars['ID']; ?>
&modulename=<?php echo $this->_tpl_vars['MODULE']; ?>
" target="main"><?php echo $this->_tpl_vars['keyval']; ?>
</a>
                                                  </td>
                                             <?php elseif ($this->_tpl_vars['keyid'] == '15' || $this->_tpl_vars['keyid'] == '16' || $this->_tpl_vars['keyid'] == '111'): ?> <!--ComboBox-->
               							<td width=25% class="dvtCellInfo" align="left">&nbsp;<?php echo $this->_tpl_vars['keyval']; ?>

               							</td>
                                              <?php elseif ($this->_tpl_vars['keyid'] == '1021' || $this->_tpl_vars['keyid'] == '1022' || $this->_tpl_vars['keyid'] == '1023'): ?> <!--ComboBox-->
               							<td width=25% class="dvtCellInfo" align="left" id="mouseArea_<?php echo $this->_tpl_vars['label']; ?>
" >&nbsp;<span id="dtlview_<?php echo $this->_tpl_vars['label']; ?>
"><?php echo $this->_tpl_vars['keyval']; ?>
</span></td>
                                             <?php elseif ($this->_tpl_vars['keyid'] == '17'): ?> <!--WebSite-->
                                                  <td width=25% class="dvtCellInfo" align="left">&nbsp;<a href="<?php echo $this->_tpl_vars['keyval']; ?>
" target="_blank"><?php echo $this->_tpl_vars['keyval']; ?>
</a>
                                                  </td>
					     <?php elseif ($this->_tpl_vars['keyid'] == '85'): ?><!--Skype-->
                                                <td width=25% class="dvtCellInfo" align="left">&nbsp;<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
skype.gif" alt="Skype" title="Skype" LANGUAGE=javascript align="absmiddle"></img><a href="skype:<?php echo $this->_tpl_vars['keyval']; ?>
?call" target=_blank><?php echo $this->_tpl_vars['keyval']; ?>
</a></td>
					     <?php elseif ($this->_tpl_vars['keyid'] == '86'): ?><!--QQ-->
					        <?php if ($this->_tpl_vars['keyval'] != ''): ?>
                                                <td width=25% class="dvtCellInfo" align="left">&nbsp;<a target="blank" href="http://wpa.qq.com/msgrd?V=1&Uin=<?php echo $this->_tpl_vars['keyval']; ?>
&Site=CRMONE&Menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo $this->_tpl_vars['keyval']; ?>
:4"  align="absmiddle"><?php echo $this->_tpl_vars['keyval']; ?>
</a></td>
						<?php else: ?>
						<td width=25% class="dvtCellInfo" align="left">&nbsp;<img border="0" src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
qq.gif"  align="absmiddle"><?php echo $this->_tpl_vars['keyval']; ?>
</td>
						<?php endif; ?>
					     <?php elseif ($this->_tpl_vars['keyid'] == '87'): ?><!--MSN-->
                                                <td width=25% class="dvtCellInfo" align="left">&nbsp;<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
msn.jpg" alt="MSN" title="MSN" LANGUAGE=javascript align="absmiddle"></img><span id="dtlview_<?php echo $this->_tpl_vars['label']; ?>
"><a href="msnim:chat?contact=<?php echo $this->_tpl_vars['keyval']; ?>
" target=_blank><?php echo $this->_tpl_vars['keyval']; ?>
</a></td>	
					     <?php elseif ($this->_tpl_vars['keyid'] == '88'): ?><!--wangwang-->
                                                <td width=25% class="dvtCellInfo" align="left">&nbsp;<a target=_blank href='http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $this->_tpl_vars['keyval']; ?>
&site=cnalichn&s=4&charset=utf-8'><img border=0 src='http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $this->_tpl_vars['keyval']; ?>
&site=cnalichn&s=4&charset=utf-8'><?php echo $this->_tpl_vars['keyval']; ?>
</a></td>	
					     <?php elseif ($this->_tpl_vars['keyid'] == '89'): ?><!--YAHOO-->
                                                <td width=25% class="dvtCellInfo" align="left">&nbsp;<img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
yahoo.gif" alt="YAHOO" title="YAHOO" LANGUAGE=javascript align="absmiddle"></img><a href="ymsgr:sendIM?<?php echo $this->_tpl_vars['keyval']; ?>
" target=_blank><?php echo $this->_tpl_vars['keyval']; ?>
</a></td>	
                                             <?php elseif ($this->_tpl_vars['keyid'] == '19' || $this->_tpl_vars['keyid'] == '20'): ?> <!--TextArea/Description-->
                                                  <td width="75%" colspan="3" class="dvtCellInfo" align="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['keyval'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
                   
                                                  </td>
                                             <?php elseif ($this->_tpl_vars['keyid'] == '21' || $this->_tpl_vars['keyid'] == '24' || $this->_tpl_vars['keyid'] == '22'): ?> <!--TextArea/Street-->
                                                  <td width=25% class="dvtCellInfo" align="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['keyval'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

                                                  </td>
                                             <?php elseif ($this->_tpl_vars['keyid'] == '50' || $this->_tpl_vars['keyid'] == '73' || $this->_tpl_vars['keyid'] == '51' || $this->_tpl_vars['keyid'] == '57' || $this->_tpl_vars['keyid'] == '59' || $this->_tpl_vars['keyid'] == '75' || $this->_tpl_vars['keyid'] == '81' || $this->_tpl_vars['keyid'] == '76' || $this->_tpl_vars['keyid'] == '78' || $this->_tpl_vars['keyid'] == '80' || $this->_tpl_vars['keyid'] == '1010'): ?> <!--AccountPopup-->
                                                  <td width=25% class="dvtCellInfo" align="left">&nbsp;<a href="<?php echo $this->_tpl_vars['keyseclink']; ?>
"><?php echo $this->_tpl_vars['keyval']; ?>
</a>
                                                  </td>
					     <?php elseif ($this->_tpl_vars['keyid'] == 1004): ?> <!--Creator-->
                                                  <td width=25% class="dvtCellInfo" align="left">&nbsp;<?php echo $this->_tpl_vars['keyval']; ?>

                                                  </td>
                                             <?php elseif ($this->_tpl_vars['keyid'] == 82): ?> <!--Email Body-->
                                                  <td colspan="3" width=100% class="dvtCellInfo" align="left">&nbsp;<?php echo $this->_tpl_vars['keyval']; ?>

                                                  </td>
					<?php elseif ($this->_tpl_vars['keyid'] == '53'): ?> <!--Assigned To-->
                    <td width=25% class="dvtCellInfo" align="left">&nbsp;
				<?php echo $this->_tpl_vars['keyval']; ?>
                    
                    </td>
		    <?php elseif ($this->_tpl_vars['keyid'] == '56'): ?> <!--CheckBox--> 
                      <td width=25% class="dvtCellInfo" align="left"><?php echo $this->_tpl_vars['keyval']; ?>
&nbsp;
                        </td>
	

				<?php elseif ($this->_tpl_vars['keyid'] == 69): ?><!-- for Image Reflection -->
                                                  	<td align="left" width=25%">&nbsp;<?php echo $this->_tpl_vars['keyval']; ?>
</td>
				<?php else: ?>									
                                                  	
							<?php if ($this->_tpl_vars['keyseclink'] != ''): ?>
								<td width=25% class="dvtCellInfo" align="left" id="mouseArea_<?php echo $this->_tpl_vars['label']; ?>
">&nbsp;<a href="<?php echo $this->_tpl_vars['keyseclink']; ?>
"><?php echo $this->_tpl_vars['keyval']; ?>
</a></td>
							<?php else: ?>
								<td class="dvtCellInfo" align="left" width=25%">&nbsp;<?php echo $this->_tpl_vars['keyval']; ?>
</td>
							<?php endif; ?>
				<?php endif; ?>