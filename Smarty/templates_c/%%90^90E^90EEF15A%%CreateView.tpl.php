<?php /* Smarty version 2.6.18, created on 2013-07-01 16:19:54
         compiled from Accounts/CreateView.tpl */ ?>
<script type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
.js"></script>

<form name="EditView" method="POST" action="index.php">
<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
<input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['MODE']; ?>
">
<input type="hidden" name="action">
<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
<input type="hidden" name="return_module" value="<?php echo $this->_tpl_vars['RETURN_MODULE']; ?>
">
<input type="hidden" name="return_id" value="<?php echo $this->_tpl_vars['RETURN_ID']; ?>
">
<input type="hidden" name="return_action" value="<?php echo $this->_tpl_vars['RETURN_ACTION']; ?>
">
<input type="hidden" name="return_viewname" value="<?php echo $this->_tpl_vars['RETURN_VIEWNAME']; ?>
">

<!-- center start -->
     <div class="container-fluid" style="height:608px;">
        <div class="row-fluid">
          <div class="span2">
              <div class="accordion" id="accordion2" style="margin-top:0px;margin-bottom:0px;overflow-y:scroll;height:550px;">
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse"  href="#collapseOne">
                      <i class="cus-table"></i>&nbsp;<b>相关操作</b>
                    </a>
                  </div>
                  <div id="collapseOne" class="accordion-body collapse in">
                    <div class="accordion-inner">
                        <ul class="nav nav-list">
	                        
                        </ul>
                    </div>
                  </div>
                </div>

             </div>
          </div>
          <div class="span10" style="margin-left:10px;">
             <div  class="pull-left" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="goback();">
                    <i class="icon-arrow-left icon-white"></i>取消</button>
              </div>
              <div class="pull-right" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-success" style="margin-top:2px;" onclick="this.form.action.value='Save';check_duplicate()" name="savebutton">
                    <i class="icon-ok icon-white"></i> 保存 </button>
                 
             </div>
             <div class="clearfix"></div>
              <div class="accordion"  style="margin-top:0px;margin-bottom:0px;overflow-y:scroll;height:550px;width:1200px;">
              	<?php $_from = $this->_tpl_vars['BASBLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
?>
                  <div class="accordion-group">
                     <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse"  href="#detailOne">
                        <?php echo $this->_tpl_vars['header']; ?>

                      </a>
                    </div>
                    <div id="detailOne" class="accordion-body collapse in">
                      <div class="accordion-inner">
                          <table class="table table-bordered table-hover table-condensedforev dvtable">
                           <tbody>
                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                           </tbody>
                          </table>
                     </div>
                   </div>
                  </div>
                  <?php endforeach; endif; unset($_from); ?>
                  
              </div>
               <div  class="pull-left" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="goback();">
                    <i class="icon-arrow-left icon-white"></i>取消</button>
              </div>
              <div class="pull-right" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-success" style="margin-top:2px;" onclick="this.form.action.value='Save';check_duplicate()" name="savebutton">
                    <i class="icon-ok icon-white"></i> 保存 </button>
             </div>
             <div class="clearfix"></div>
            
          </div>
        </div>
     </div>
     <!-- center end -->
</form>

<script>	
        var fieldname = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDNAME']; ?>
)
        var fieldlabel = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDLABEL']; ?>
)
        var fielddatatype = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDDATATYPE']; ?>
)
		if(getObj("customernum") != undefined && getObj("customernum").value == "") {
	        getObj("customernum").value = "<?php echo $this->_tpl_vars['APP']['AUTO_GEN_CODE']; ?>
";
		//getObj("customernum").setAttribute("readOnly","true");
	}

</script>
 