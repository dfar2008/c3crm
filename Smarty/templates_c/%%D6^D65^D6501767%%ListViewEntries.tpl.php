<?php /* Smarty version 2.6.18, created on 2013-05-10 11:29:59
         compiled from SalesOrder/ListViewEntries.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'SalesOrder/ListViewEntries.tpl', 109, false),)), $this); ?>
<?php if ($_REQUEST['ajax'] != ''): ?>
&#&#&#<?php echo $this->_tpl_vars['ERROR']; ?>
&#&#&#
<?php endif; ?>
				<!-- List View Master Holder starts -->
				<table border=0 cellspacing=1 cellpadding=0 width=100% class="lvtBg">
                
<form name="massdelete" method="POST" action="index.php">
     <input name='search_url' id="search_url" type='hidden' value='<?php echo $this->_tpl_vars['SEARCH_URL']; ?>
'>
     <input name="idlist" id="idlist" type="hidden">
     <input name="action" id="action" type="hidden">
     <input name="module" id="module" type="hidden">
     <input id="viewname" name="viewname" type="hidden" value="<?php echo $this->_tpl_vars['VIEWID']; ?>
">
     <input name="change_owner" type="hidden">
     <input name="change_status" type="hidden">
     <input name="allids" type="hidden" value="<?php echo $this->_tpl_vars['ALLIDS']; ?>
">

                <tbody>
				<tr>
				<td>
				<!-- List View's Buttons and Filters starts -->
		        <table border=0 cellspacing=0 cellpadding=2 width=100% class="small">
			    <tr>
				<!-- Buttons -->
				<td style="padding-right:20px" align="left" nowrap>
				 <input class="crmbutton small delete" type="button" value=" <?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON']; ?>
 " onclick="return massDelete('<?php echo $this->_tpl_vars['MODULE']; ?>
')"/>
                </td>
				<td nowrap width="100%" align="right" valign="middle">
					<table border=0 cellspacing=0 cellpadding=0 class="small">
					     <tr><td style="padding-right:5px"><?php echo $this->_tpl_vars['RECORD_COUNTS']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['NAVIGATION']; ?>
</td></tr>
					</table>
				 </td>
			
					
       		    </tr>
			</table>
			<!-- List View's Buttons and Filters ends -->
			
			<table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
			<!-- Table Headers -->
			<!-- Table Headers -->
			<tr>
            <td class="lvtCol"><input type="checkbox"  name="selectall" onClick=toggleSelect(this.checked,"selected_id")></td>
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
			<tr bgcolor=white class="lvtColData changehand" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
			<td width="2%"><input type="checkbox" NAME="selected_id" value= '<?php echo $this->_tpl_vars['entity_id']; ?>
' onClick=toggleSelectAll(this.name,"selectall")></td>
			<?php $_from = $this->_tpl_vars['entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>	
			<td onClick="getTabViewNew('<?php echo $this->_tpl_vars['entity_id']; ?>
',this);" ><?php echo $this->_tpl_vars['data']; ?>
</td>
	        <?php endforeach; endif; unset($_from); ?>
			</tr>
			<?php endforeach; else: ?>
			    <tr><td style="background-color:#efefef;height:340px" align="center" colspan="<?php echo $this->_foreach['listviewforeach']['iteration']+1; ?>
">
			      <div style="border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 45%; position: relative; z-index: 0.1;">						
				  <table border="0" cellpadding="5" cellspacing="0" width="98%">
				  <tr>
				    <td rowspan="2" width="25%"><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
empty.jpg" height="60" width="61"></td>
				    <td style="border-bottom: 1px solid rgb(204, 204, 204);" nowrap="nowrap" width="75%"><span class="genHeaderSmall">
				    <?php echo $this->_tpl_vars['APP']['LBL_FOUND']; ?>

				    </span></td>
				   </tr>
				
				  </table> 	
				</div>					
			    </td></tr>	
		        <?php endif; unset($_from); ?> 
			 </table>
			 </div>
			 
			
		       </td>
		   </tr>
           </tbody>
            
              </form>	
	    </table>
<?php if ($this->_tpl_vars['LISTENTITY'] && count ( $this->_tpl_vars['LISTENTITY'] ) != 0): ?>
             <?php 
                $urlstr1="";
                foreach($_REQUEST as $key=>$value)
                {
                    if($key!='module'&&$key!='action'&&$key!='file')
                    {
                        $urlstr1.="&$key=$value";
                    }

                }
                $this->assign('COLLECTURLSTR',$urlstr1);
                ?>
             <div id="collectcolumntable">
                <script>getColumnCollectInf('<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['COLLECTURLSTR']; ?>
');</script>
            </div>
            <?php endif; ?>

<div id="basicsearchcolumns" style="display:none;"><select name="search_field" id="bas_searchfield" class="txtBox" style="width:150px"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SEARCHLISTHEADER']), $this);?>
</select></div>