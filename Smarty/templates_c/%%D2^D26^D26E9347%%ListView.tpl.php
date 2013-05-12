<?php /* Smarty version 2.6.18, created on 2013-01-17 17:22:37
         compiled from SfaDesktops/ListView.tpl */ ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                <div id="searchingUI" style="display:none;">
                                        <table border=0 cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                                <td align=center>
                                                <img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
searching.gif" alt="Searching... please wait"  title="Searching... please wait">
                                                </td>
                                        </tr>
                                        </table>

                                </div>
                        </td>
                </tr>
                </table>
        </td>
</tr>
</table>
<table class="list_table" style="margin-top: 2px;" border="0" cellpadding="3" cellspacing="1" width="100%">
<tbody>
  <tr>
    <td  colspan=3 bgcolor="#ffffff" valign="top">

<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
  <tr>
	<td valign="top" width=100% style="padding:2px;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
          <td width=85% align="left" valign=top>
           <!-- PUBLIC CONTENTS STARTS-->
          <div id="ListViewContents">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "SfaDesktops/ListViewEntries.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          </div>
          </td>
	    </tr>
	  </table>
    </td>
   </tr>
</table>
<!-- New List -->
</td></tr></tbody></table>