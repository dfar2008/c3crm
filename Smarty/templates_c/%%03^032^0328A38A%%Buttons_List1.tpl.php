<?php /* Smarty version 2.6.18, created on 2013-04-12 16:28:41
         compiled from Buttons_List1.tpl */ ?>

<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class=small>

<tr style="background:#DFEBEF;height:27px;">
	<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>
   <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['CATEGORY']]; ?>
 > <a class="hdrLink" href="index.php?action=ListView&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
 </a> 
    </td>
</tr>
<tr><td style="height:2px"></td></tr>
</TABLE>