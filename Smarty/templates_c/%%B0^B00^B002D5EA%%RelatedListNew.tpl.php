<?php /* Smarty version 2.6.18, created on 2013-01-17 18:28:58
         compiled from RelatedListNew.tpl */ ?>
<script type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
.js"></script>
<?php echo '
<script>
function getTabViewForRelated(ID){ 
	var typeid = document.getElementById("typeid").value;
	document.getElementById(typeid).className="tablink";
	document.getElementById(ID).className="tablink selected";
	document.getElementById(typeid+"1").style.display = "none";
	document.getElementById(ID+"1").style.display = "";
	document.getElementById("typeid").value = ID;
}
'; ?>

</script>

<!-- Contents -->
<div id="editlistprice" style="position:absolute;width:300px;"></div>
		<!-- PUBLIC CONTENTS STARTS-->
		
			<!-- Account details tabs -->
			<tr>
				<td valign=top align=left >
					<div class="small" style="padding:5px">
		                	<table border=0 cellspacing=0 cellpadding=3 width=100% >
						<tr>
							<td valign=top align=left>
							<!-- content cache -->
								<table border=0 cellspacing=0 cellpadding=0 width=100%>
									<tr>
										<td >
										   <!-- General details -->
												<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'RelatedListsHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
												<div id="RLContents">
					                                 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'RelatedListContents.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                        		</div>
												</form>
										   
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</div>
				</td>
			</tr>
	<!-- PUBLIC CONTENTS STOPS-->
