<?php /* Smarty version 2.6.18, created on 2013-05-10 11:30:06
         compiled from Qunfas/ListView.tpl */ ?>


<link href="include/ajaxtabs/ajaxtabs.css" type="text/css" rel="stylesheet"/>
<script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
.js"></script>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        </td>
                </tr>
                </table>
        </td>
</tr>
</table>


<table class="list_table" style="margin-top:2px;" border="0" cellpadding="3" cellspacing="1" width="100%">
        <tbody><tr >
        
          <td>
	  <table border="0" cellpadding="0" cellspacing="0" style="padding-right:5px;padding-top:2px;padding-bottom:2px;">

	  <tr>
	  <td><img src="themes/images/filter.png" border=0></td>
	  <td><?php echo $this->_tpl_vars['APP']['LBL_FENZU']; ?>

	  <?php $_from = $this->_tpl_vars['CUSTOMVIEW_OPTION']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['fenzuname']):
        $this->_foreach['listviewforeach']['iteration']++;
?>

			<?php if ($this->_tpl_vars['id'] == $this->_tpl_vars['VIEWID']): ?> 
			<span style="padding-right:5px;padding-top:5px;padding-bottom:5px;">
			&nbsp;&nbsp;<a class="cus_markbai tablink" href="javascript:;" onclick="javascript:getTableViewForFenzu('<?php echo $this->_tpl_vars['MODULE']; ?>
','viewname=<?php echo $this->_tpl_vars['id']; ?>
',this,<?php echo $this->_tpl_vars['id']; ?>
);"><?php echo $this->_tpl_vars['fenzuname']; ?>
</a>&nbsp;&nbsp;
			</span>
			<?php else: ?>
			<span style="padding-right:5px;padding-top:5px;padding-bottom:5px;">
			&nbsp;&nbsp;<a class="cus_markhui tablink" href="javascript:;" onclick="javascript:getTableViewForFenzu('<?php echo $this->_tpl_vars['MODULE']; ?>
','viewname=<?php echo $this->_tpl_vars['id']; ?>
',this,<?php echo $this->_tpl_vars['id']; ?>
);"><?php echo $this->_tpl_vars['fenzuname']; ?>
</a>&nbsp;&nbsp;
			</span>
			<?php endif; ?>		
			
	  <?php endforeach; endif; unset($_from); ?>
	  
	
		        
			<span style="padding-right:5px;padding-top:5px;padding-bottom:5px;">&nbsp;<a href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Fenzu&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP']['LNK_CV_CREATEFENZU']; ?>
</a> | 
						
						<a href="javascript:editFenzu('<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['CATEGORY']; ?>
')"><?php echo $this->_tpl_vars['APP']['LNK_CV_EDIT']; ?>
</a> |
						
						<a href="javascript:deleteFenzu('<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['CATEGORY']; ?>
')"><?php echo $this->_tpl_vars['APP']['LNK_CV_DELETE']; ?>
</a></span>&nbsp;
		</td>
		</tr>
            </tbody></table>
	</td>
        </tr>
	<tr>
<td  colspan=3 bgcolor="#ffffff" valign="top">
<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
     <tr>
      <td class="lvt" valign="top" width=100% style="padding:0px;">
	   <!-- PUBLIC CONTENTS STARTS-->
	  <div id="ListViewContents" class="small" style="width:100%;position:relative;">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "Qunfas/ListViewEntries.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	  </div>
     </td>
   </tr>
</table>
<!-- New List -->
</td></tr></tbody></table>

<!-- QuickEdit Feature -->

<script language="javascript" type="text/javascript">
<?php echo '
function setSendContent(obj){
	document.getElementById(\'sendmessageinfo\').value = obj.value;
}
function checkFieldNum(){
	var sendmessageinfo = document.getElementById(\'sendmessageinfo\').value;
	var contentlen = fucCheckLength2(sendmessageinfo);
	var zishu = 65 - contentlen;
	var str = "你还能输入:<font color=red><b>"+zishu+"</b></font>个字...";
	//document.getElementById("showzishu").update(str);
	$("showzishu").update(str);
}
'; ?>

</script>



