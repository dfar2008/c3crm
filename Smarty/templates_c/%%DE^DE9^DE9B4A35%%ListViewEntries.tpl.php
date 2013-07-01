<?php /* Smarty version 2.6.18, created on 2013-07-01 16:19:47
         compiled from Accounts/ListViewEntries.tpl */ ?>
<div id="quickedit_form_div" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="gaojisearch" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-380px;"></div>

<input name='search_url' id="search_url" type='hidden' value='<?php echo $this->_tpl_vars['SEARCH_URL']; ?>
'>
<input name="idlist" id="idlist" type="hidden">
<input name="action" id="action" type="hidden" value="ListView">
<input name="module" id="module" type="hidden" value="Accounts">
<input id="viewname" name="viewname" type="hidden" value="<?php echo $this->_tpl_vars['VIEWID']; ?>
">
<input name="change_owner" type="hidden">
<input name="change_status" type="hidden">
<input name="allids" type="hidden" value="<?php echo $this->_tpl_vars['ALLIDS']; ?>
">

<div style="margin-top:0px;margin-bottom:0px;overflow:auto;height:470px;width:1200px;">
   <table class="table table-bordered table-hover table-condensed table-striped">
    <thead>
      <tr>  
          <th align="left" width="35">
            <input type="checkbox" name="selectedAll" id="selectedAll" />
          </th>
         <?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['header']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
             <th align="left"><?php echo $this->_tpl_vars['header']; ?>
</th>
         <?php endforeach; endif; unset($_from); ?>
      </tr>
     </thead>
     <tbody>
       <?php $_from = $this->_tpl_vars['LISTENTITY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entity_id'] => $this->_tpl_vars['entity']):
?>
       <tr id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
"> 
          <td>
            <input type="checkbox" name="selected_id"  id="selected_id_<?php echo $this->_tpl_vars['entity_id']; ?>
" value="<?php echo $this->_tpl_vars['entity_id']; ?>
" />
          </td>
         <?php $_from = $this->_tpl_vars['entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?> 
          <td><?php echo $this->_tpl_vars['data']; ?>
</td>
         <?php endforeach; endif; unset($_from); ?>
        </tr> 
       <?php endforeach; else: ?>
        <tr> 
          <td colspan="<?php echo $this->_foreach['listviewforeach']['iteration']+1; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_FOUND']; ?>
</td>
        </tr> 
       <?php endif; unset($_from); ?>

    </tbody>
  </table>
  </div>
  <div style="margin-top:0px;margin-bottom:0px;">
  <table class="table table-bordered table-hover table-condensed"><tbody>
    <tr>
    <td colspan="15" style="margin:0px;vertical-align: center;" >
      <div class="span7 pull-left" style="margin-top:8px;">
        
      </div>
      
        <div class="span5" style="margin-top:8px;">
        <div class="pagination pagination-mini pagination-right" style="margin:0px;">
          <small style="color:#999999;"><?php echo $this->_tpl_vars['RECORD_COUNTS']; ?>
&nbsp;</small>
          <?php echo $this->_tpl_vars['NAVIGATION']; ?>

        </div>
      </div>
    </td>
    </tr>
    </tbody>
      </table>
  </div> 


<script language="JavaScript" type="text/javascript">
<?php echo '
$(function() {
    //全选 | 反全选
   $("#selectedAll").click(function() { 
        $(\'input[name="selected_id"]\').prop("checked",this.checked);
    });
    var $selected_id = $("input[name=\'selected_id\']"); 
    $selected_id.click(function(){
        $("#selectedAll").prop("checked",$selected_id.length == $selected_id.filter(":checked").length.length ? true : false);
    });

});
'; ?>

</script>