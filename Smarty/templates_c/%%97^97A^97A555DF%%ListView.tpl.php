<?php /* Smarty version 2.6.18, created on 2013-07-01 16:19:16
         compiled from Qunfas/ListView.tpl */ ?>
 <script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
.js"></script>

<link href="themes/bootcss/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="themes/bootcss/js/bootstrap-datetimepicker.min.js"></script>


 <div class="container-fluid" style="height:606px;"> 
      <div class="row-fluid">
        <div class="span12" style="margin-left:0px;">
           
            <div id="tablink">
              <ul class="nav nav-pills" style="margin-bottom:5px;">
                <li class="nav-header" style="padding-left:0px;padding-right:5px;">
                  <i class="icon-th-list"></i> 
                </li>

                 <?php $_from = $this->_tpl_vars['CUSTOMVIEW_OPTION']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['viewname']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
                  <?php if ($this->_tpl_vars['id'] == $this->_tpl_vars['VIEWID']): ?> 
                    <li class="active"><a href="javascript:;" onclick="javascript:getTableViewForFenzu('<?php echo $this->_tpl_vars['MODULE']; ?>
','viewname=<?php echo $this->_tpl_vars['id']; ?>
',this,<?php echo $this->_tpl_vars['id']; ?>
);" ><?php echo $this->_tpl_vars['viewname']; ?>
</a></li>
                  <?php else: ?>
                    <li ><a href="javascript:;" onclick="javascript:getTableViewForFenzu('<?php echo $this->_tpl_vars['MODULE']; ?>
','viewname=<?php echo $this->_tpl_vars['id']; ?>
',this,<?php echo $this->_tpl_vars['id']; ?>
);"><?php echo $this->_tpl_vars['viewname']; ?>
</a></li>
                  <?php endif; ?>
                 <?php endforeach; endif; unset($_from); ?>
                <li>
                  <a href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Fenzu&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" style="padding:2px;">
                    <i class="cus-add"></i></a>
                </li> 
                <li>
                   <a href="javascript:editFenzu('<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['CATEGORY']; ?>
')" style="padding:2px;"><i class="cus-pencil"></i></a>
                </li>
                <li> 
                  <a href="javascript:deleteFenzu('<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['CATEGORY']; ?>
')" style="padding:2px;"><i class="cus-cancel"></i></a>
                </li>
              </ul>
          </div>

           <div id="ListViewContents" class="small" style="width:100%;position:relative;">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['MODULE'])."/ListViewEntries.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          </div>

        </div>
      </div>

    </div>



<script language="javascript" type="text/javascript">
<?php echo '
function setSendContent(obj){ 
	$("#sendmessageinfo").val(obj.value);
}
function checkFieldNum(){
	var sendmessageinfo = $("#sendmessageinfo").val();
	var contentlen = fucCheckLength2(sendmessageinfo);
	var zishu = 65 - contentlen;
	var str = "你还能输入:<font color=red><b>"+zishu+"</b></font>个字...";
	$("#showzishu").html(str);
}
'; ?>

</script>
