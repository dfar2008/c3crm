<?php /* Smarty version 2.6.18, created on 2013-05-10 11:48:50
         compiled from Relsettings/SmsLogs.tpl */ ?>
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody>
	<tr>
    <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
	
	<div align=center>
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
picklist.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_RELSETTINGS']; ?>
</a> > <?php echo $this->_tpl_vars['MOD']['LBL_SMS_LOGS']; ?>
 </b></td>
				</tr>
				<tr>
					<td valign=top class="small"><?php echo $this->_tpl_vars['MOD']['LBL_SMS_LOGS']; ?>
 </td>
				</tr>
				</table>
				
				<br>
                 <form name="searchuser" action="index.php" method="post">
                    <input type="hidden" name="module" value="Relsettings">
					<input type="hidden" name="action" value="SmsLogs">
                	   <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="small">
                		<tr>
                            <td  width="5%"  nowrap="nowrap">接收人：</td> 
                            <td  width="10%"><input type="text" value="<?php echo $this->_tpl_vars['receiver']; ?>
" name="receiver"/></td>
                            <td  width="5%"  nowrap="nowrap">接收人手机：</td> 
                            <td  width="10%" ><input type="text" value="<?php echo $this->_tpl_vars['receiver_phone']; ?>
" name="receiver_phone"/></td>
                            <td  width="5%"  nowrap="nowrap">是否成功：</td>
                            <td  width="10%">
                            <select name="flag">
                            <?php $_from = $this->_tpl_vars['FLAGARR']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['data']):
?>
                            	<?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['flag']): ?>
                               		<option value="<?php echo $this->_tpl_vars['key']; ?>
" selected="selected"><?php echo $this->_tpl_vars['data']; ?>
</option>
                                <?php else: ?>
                              		<option value="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['data']; ?>
</option>
                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                            </select>
                            </td>
                            <td   align="left"><input type="submit" value=" 搜索 " name="submit" class="crmbutton small edit"/></td> 
                            <td  width="5%" align="right"><input type="button" value=" 刷新 " name="button" class="crmbutton small edit"onclick="getListViewEntries_js();"/></td> 
                        </tr>
                       </table>
                      
                     <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="lvt small" style="TABLE-LAYOUT: fixed;OVERFLOW: hidden;TEXT-OVERFLOW: ellipsis; WORD-WRAP: break-word">
                       
                       <tr>
                            <?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['header']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
                                <td class="lvtCol"><?php echo $this->_tpl_vars['header']; ?>
</td>
                            <?php endforeach; endif; unset($_from); ?>
                        </tr>
                        <!-- Table Contents -->
                        <?php $_from = $this->_tpl_vars['LISTENTITY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entity_id'] => $this->_tpl_vars['entity']):
?>
                           <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
                            <?php $_from = $this->_tpl_vars['entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>	
                            <td><?php echo $this->_tpl_vars['data']; ?>
</td>
                            <?php endforeach; endif; unset($_from); ?>
                          </tr>
                         <?php endforeach; else: ?>
                          <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
                            <td colspan="<?php echo $this->_tpl_vars['countheader']; ?>
" align="center">---&nbsp;无&nbsp;---</td>
                          </tr>
                        <?php endif; unset($_from); ?>
                        <tr>
                       <td nowrap width="100%" align="right" valign="middle" colspan="<?php echo $this->_tpl_vars['countheader']; ?>
">
                            <table border=0 cellspacing=0 cellpadding=0 class="small">
                                 <tr><td style="padding-right:5px"><?php echo $this->_tpl_vars['RECORD_COUNTS']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['NAVIGATION']; ?>
</td></tr>
                            </table>
                        </td>
                        </tr>
                    </table>
                   </form>
					
				</td>
				</tr>
				</table>
						
			</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
		
	</div>
	
</td>
   </tr>
</tbody>
</table>
<input type="hidden" value="<?php echo $this->_tpl_vars['search_url']; ?>
" id="search_url"  name="search_url"/>
<?php echo '
<script>
function getListViewEntries_js(module,url)
{	
	$("status").style.display="inline";
	if($(\'search_url\').value!=\'\')
		urlstring = $(\'search_url\').value;
	else
		urlstring = \'\';
	location.href="index.php?module=Relsettings&action=SmsLogs&"+url+urlstring;
}
function getListViewWithPageNo(module,pageElement)
{
	//var pageno = document.getElementById(\'listviewpage\').value;
	var pageno = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,\'start=\'+pageno);
}
function getListViewWithPageSize(module,pageElement)
{
	var pagesize = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,\'pagesize=\'+pagesize);
} 
</script>
'; ?>
