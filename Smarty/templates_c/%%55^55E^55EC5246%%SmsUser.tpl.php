<?php /* Smarty version 2.6.18, created on 2013-05-10 12:01:49
         compiled from Settings/SmsUser.tpl */ ?>
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<style>
<?php echo '
.shitu{
	color:#000;	
	font-weight:normal;
}
.shituselect{
	color:#F00; 
	font-weight:bold;
}
.lvtCol12 {
    border-color: #DDDDDD #DDDDDD #DDDDDD #DDDDDD;
    border-style: solid;
    border-width: 1px 1px 1px 1px;
    color: #333333;
    font-size: 12px;
}
'; ?>

</style>
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
ico_mobile.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_SETTINGS']; ?>
</a> > <?php echo $this->_tpl_vars['MOD']['LBL_SMS_USER']; ?>
 </b></td>
				</tr>
				<tr>
					<td valign=top class="small"><?php echo $this->_tpl_vars['MOD']['LBL_SMS_USER']; ?>
 </td>
				</tr>
				</table>
				
				<br>
                 <form name="searchuser" action="index.php" method="post">
                    <input type="hidden" name="module" value="Settings">
			<input type="hidden" name="action" value="SmsUser">
                	   
                         <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="small" >
                        <tr>
                        	<td  width="5%" align="left" nowrap="nowrap"> <font color="#FF0000"><b>搜索:</b></font></td>
                            <td  width="5%" align="left" nowrap="nowrap">用户名：</td> 
                            <td  width="10%" align="left"><input type="text" value="<?php echo $this->_tpl_vars['user_name']; ?>
" name="user_name"  size="18" style="border:1px solid #bababa;" tabindex="13"/></td>
                            <td  width="5%" align="right" nowrap="nowrap">姓名：</td> 
                            <td  width="10%"><input type="text" value="<?php echo $this->_tpl_vars['last_name']; ?>
" name="last_name"  size="13" style="border:1px solid #bababa;" tabindex="13"/></td>
							<td  width="5%" align="right" nowrap="nowrap">手机：</td> 
                            <td  width="10%"><input type="text" value="<?php echo $this->_tpl_vars['phone_mobile']; ?>
" name="phone_mobile"  size="13" style="border:1px solid #bababa;" tabindex="13"/></td>
							<td  width="5%" align="right" nowrap="nowrap">Email：</td> 
                            <td  width="10%"><input type="text" value="<?php echo $this->_tpl_vars['email1']; ?>
" name="email1"  size="13" style="border:1px solid #bababa;" tabindex="13"/></td>
                            
                            <td  align="left"><input type="submit" value=" 搜索 " name="submit" class="crmbutton small edit"/></td> 
                        	<td  width="5%" align="right"><input type="button" value=" 新增用户 " name="button" class="crmbutton small edit"onclick="document.location.href='index.php?module=Settings&action=CreateMoreInfo';"/></td> 
                        </tr>
                       
                       </table>
                      
                     <table border=0 cellspacing=1 cellpadding=3 width=99% align="center" class="lvt small" >
                       
                       <tr>
                        <td class="lvtCol"><input type="checkbox"  name="selectall"   onClick=toggleSelect(this.checked,"selected_id")></td>
                            <?php echo $this->_tpl_vars['headerhtml']; ?>

                        </tr>
                        <!-- Table Contents -->
                        <?php $_from = $this->_tpl_vars['LISTENTITY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entity_id'] => $this->_tpl_vars['entity']):
?>
                        
                           <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
                           <td width="2%"><input type="checkbox" NAME="selected_id" value= '<?php echo $this->_tpl_vars['entity_id']; ?>
' onClick=toggleSelectAll(this.name,"selectall")></td>
                            <?php $_from = $this->_tpl_vars['entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>	
                            <td nowrap="nowrap"><?php echo $this->_tpl_vars['data']; ?>
</td>
                            <?php endforeach; endif; unset($_from); ?>
                          </tr>
                         <?php endforeach; else: ?>
                          <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
                            <td colspan="<?php echo $this->_tpl_vars['countheader']+1; ?>
" align="center">---&nbsp;无&nbsp;---</td>
                          </tr>
                        <?php endif; unset($_from); ?>
                        <tr>
                        
                        <td class="lvtCol"><input type="checkbox"  name="selectall"   onClick=toggleSelect(this.checked,"selected_id")></td>
                        <td class="lvtCol" colspan=3 nowrap><input type="button" value="批量发邮件" onclick="SendMail();" class="crmbutton small edit"/>
						&nbsp;&nbsp;<input type="button" value="批量发短信" onclick="SendSms();" class="crmbutton small edit"/>
						</td>
                       <td nowrap width="100%" align="right" valign="middle" colspan="<?php echo $this->_tpl_vars['countheader']-1; ?>
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
<input type="hidden" value="<?php echo $this->_tpl_vars['order_url']; ?>
" id="order_url"  name="order_url"/>
<input type="hidden" value="<?php echo $this->_tpl_vars['search_url']; ?>
" id="search_url"  name="search_url"/>
<div id="tempDeldiv" style="display:block;width:500px;"></div>
<script>
var type = "<?php echo $this->_tpl_vars['type']; ?>
";
<?php echo '
function confirmDel(id){
	if(confirm("确认禁用用户?")){
		document.location.href="index.php?module=Settings&action=SmsUserDelete&userid="+id;
	}else{	
		return false;
	}
}

function deleteUser(obj,userid)
{
        $("status").style.display="inline";
        new Ajax.Request(
                \'index.php\',
                {queue: {position: \'end\', scope: \'command\'},
                        method: \'post\',
                        postBody: \'module=Users&action=UsersAjax&file=UserDeleteStep1&record=\'+userid,
                        onComplete: function(response) {
                                $("status").style.display="none";
                                $("tempDeldiv").innerHTML= response.responseText;
								fnvshobj(obj,"tempDeldiv");
								Drag.init(document.getElementById("DeleteLay_title"), document.getElementById("DeleteLay"));
                        }
                }
        );
}

function transferUser(del_userid)
{
        $("status").style.display="inline";
        $("DeleteLay").style.display="none";
        var trans_userid=$(\'transfer_user_id\').options[$(\'transfer_user_id\').options.selectedIndex].value;
        new Ajax.Request(
                \'index.php\',
                {queue: {position: \'end\', scope: \'command\'},
                        method: \'post\',
                        postBody: \'module=Users&action=UsersAjax&file=DeleteUser&ajax=true&delete_user_id=\'+del_userid+\'&transfer_user_id=\'+trans_userid,
                        onComplete: function(response) {
                                $("status").style.display="none";
								//fnvshobj(obj,"tempdiv");
								location.href="index.php?module=Settings&parenttab=Settings&action=SmsUser";
                        }
                }
        );

}

function getOrderBy(theorderbystr){
	getListViewEntries_js_2("Settings",theorderbystr);
} 
function getListViewEntries_js_2(module,url)
{	
	$("status").style.display="inline";
	if($(\'search_url\').value!=\'\')
		urlstring = $(\'search_url\').value;
	else
		urlstring = \'\';
	
	location.href="index.php?module=Settings&action=SmsUser&"+url+urlstring;
}
function getListViewEntries_js(module,url)
{	
	$("status").style.display="inline";
	if($(\'search_url\').value!=\'\')
		urlstring = $(\'search_url\').value;
	else
		urlstring = \'\';
		
	if($(\'order_url\').value!=\'\')
		order_url = $(\'order_url\').value;
	else
		order_url = \'\';
	
	location.href="index.php?module=Settings&action=SmsUser&"+url+urlstring+order_url;
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
window.onload = function(){
	if(type !=\'\'){
	  document.getElementById(type).className = \'shituselect\';
	}
}
function SendMail(){
	var select_options  =  document.getElementsByName(\'selected_id\');
	var x = select_options.length;
	idstring = "";

	xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			idstring = select_options[i].value +";"+idstring
			xx++
		}
	}
	if (xx != 0)
	{
		location.href=\'index.php?module=Maillists&action=ListView&useridstr=\'+idstring;
	}
	else
	{
		alert("Error");
		return false;
	}
}
function SendSms(){
	var select_options  =  document.getElementsByName(\'selected_id\');
	var x = select_options.length;
	idstring = "";

	xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			idstring = select_options[i].value +";"+idstring
			xx++
		}
	}
	if (xx != 0)
	{
		location.href=\'index.php?module=Qunfas&action=ListView&useridstr=\'+idstring;
	}
	else
	{
		alert("Error");
		return false;
	}
}
'; ?>

</script>
