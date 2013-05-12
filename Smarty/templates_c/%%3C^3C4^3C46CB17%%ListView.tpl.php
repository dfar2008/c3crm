<?php /* Smarty version 2.6.18, created on 2013-01-17 18:27:55
         compiled from Accounts/ListView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'Accounts/ListView.tpl', 122, false),)), $this); ?>
<link href="include/ajaxtabs/ajaxtabs.css" type="text/css" rel="stylesheet"/>
<script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
.js"></script>
<script language="javascript">
function callSearch(searchtype)
{
         
		getTabViewNewClear();
        $("status").style.display="inline";
	
	    search_fld_val= $('bas_searchfield').options[$('bas_searchfield').selectedIndex].value;
        search_txt_val=document.basicSearch.search_text.value;
        var urlstring = '';
        if(searchtype == 'Basic')
        {
                urlstring = 'search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val+'&';	

        }
        else if(searchtype == 'Advanced')
        {
                var no_rows = document.advSearch.search_cnt.value;
                for(jj = 0 ; jj < no_rows; jj++)
                {
                        var sfld_name = getObj("Fields"+jj);
                        var scndn_name= getObj("Condition"+jj);
                        var srchvalue_name = getObj("Srch_value"+jj);
                        urlstring = urlstring+'Fields'+jj+'='+sfld_name[sfld_name.selectedIndex].value+'&';
                        urlstring = urlstring+'Condition'+jj+'='+scndn_name[scndn_name.selectedIndex].value+'&';
                        urlstring = urlstring+'Srch_value'+jj+'='+srchvalue_name.value+'&';
                }
                for (i=0;i<getObj("matchtype").length;i++){
                        if (getObj("matchtype")[i].checked==true)
                                urlstring += 'matchtype='+getObj("matchtype")[i].value+'&';
                }
                urlstring += 'search_cnt='+no_rows+'&';
                urlstring += 'searchtype=advance&'
        }
	
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody:urlstring +'query=true&file=index&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&ajax=true',
			onComplete: function(response) {
				$("status").style.display="none";
                                result = response.responseText.split('&#&#&#');
                                $("ListViewContents").innerHTML= result[2];
                                result[2].evalScripts();
                                if(result[1] != '')
                                        alert(result[1]);
			}
	       }
        );
}
function alphabetic(module,url,dataid)
{
        for(i=1;i<=26;i++)
        {
                var data_td_id = 'alpha_'+ eval(i);
                getObj(data_td_id).className = 'searchAlph';

        }
        getObj(dataid).className = 'searchAlphselected';
	$("status").style.display="inline";
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module='+module+'&action='+module+'Ajax&file=index&ajax=true&'+url,
			onComplete: function(response) {
				$("status").style.display="none";
				result = response.responseText.split('&#&#&#');
				$("ListViewContents").innerHTML= result[2];
                result[2].evalScripts();
				if(result[1] != '')
			                alert(result[1]);
			}
		}
	);
}

</script>

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
<table border="0" cellpadding="0" cellspacing="0"  width="100%" >
<form name="basicSearch" action="index.php" onsubmit="return false;">
<tbody>
<tr width="27">
<td>
    <table border="0" cellpadding="0" cellspacing="0" class="table1234"  width="100%" >
    
      <tbody>
        <tr>
              <td style="padding-left:5px;">
                 <input title="<?php echo $this->_tpl_vars['APP']['LNK_NEW_ACCOUNT']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_NEW_ACCOUNT']; ?>
" class="crmbutton small create" onclick="javascript:location.href='index.php?module=Accounts&action=EditView'" type="button" name="Create" value="<?php echo $this->_tpl_vars['APP']['LNK_NEW_ACCOUNT']; ?>
">&nbsp;
                <input type="button" value="导入客户" class="crmbutton small edit" onclick="javascript:location.href='index.php?module=Accounts&action=Import&step=1&return_module=Accounts&return_action=index&parenttab=Customer'">&nbsp;
                 <a onclick="return selectedRecords('Accounts','Customer')" href="javascript:void(0)" name="export_link">
                <input type="button" value="导出客户" class="crmbutton small edit">
                </a>
               </td> 
               <td>
               <!-- <input title="<?php echo $this->_tpl_vars['APP']['LNK_IMPORT_THREE_MONTH_AGO_ACCOUNT']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_IMPORT_THREE_MONTH_AGO_ACCOUNT']; ?>
" class="crmbutton small create" onclick="javascript:location.href='index.php?module=Accounts&action=Import&step=1&return_module=Accounts&return_action=index'" type="button" name="import3" value="导入客户">&nbsp; -->
	       
               </td>
              
                <td class="small" nowrap width="40%">
                   <table border="0" cellpadding="0" cellspacing="0" class="table12345"  width="100%" >
                     <tbody>
                      <tr>
                      <td  nowrap="nowrap"><span style="font-size:12px;">搜索:</span></td>
                        <td>
                        <div id="basicsearchcolumns_real">
                        <select name="search_field" id="bas_searchfield" class="txtBox" style="width:130px">
                         <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SEARCHLISTHEADER'],'selected' => $this->_tpl_vars['BASICSEARCHFIELD']), $this);?>

                        </select>
                        </div>
                        <input type="hidden" name="searchtype" value="BasicSearch">
                        <input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
                        <input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
                        <input type="hidden" name="action" value="index">
                        <input type="hidden" name="query" value="true">
                        <input type="hidden" name="search_cnt">
                      </td>
                      <td class="small"><input type="text"  class="txtBox" style="width:150px" value="<?php echo $this->_tpl_vars['BASICSEARCHVALUE']; ?>
" name="search_text" onkeydown="javascript:if(event.keyCode==13) callSearch('Basic')"></td>
                      <td class="small" nowrap width=40% >
                          <input name="submit" type="button" class="crmbutton small create" onClick="callSearch('Basic');" value=" <?php echo $this->_tpl_vars['APP']['LBL_SEARCH_NOW_BUTTON']; ?>
 ">&nbsp;
                          <input name="submit" type="button" class="crmbutton small edit" onClick="clearSearchResult('<?php echo $this->_tpl_vars['MODULE']; ?>
','basicSearch');" value=" <?php echo $this->_tpl_vars['APP']['LBL_SEARCH_CLEAR']; ?>
 ">&nbsp;
                       </td>
                      <td nowrap="nowrap"><span class="small"><a href="javascript:;" onClick="openAdvanceDialogs('<?php echo $this->_tpl_vars['MODULE']; ?>
');"> <?php echo $this->_tpl_vars['APP']['LNK_ADVANCED_SEARCH']; ?>
</a></span></td>      
                      </tr>
                      </tbody>
                      </table>               
                </td>
         </tr> 
        </tbody>
     </table>
 </td>
 </tr>
 <tr>
 <td>

</td>
</tr>
</tbody>
</form>
</table>

<table class="list_table" style="margin-top:0px;" border="0" cellpadding="3" cellspacing="1" width="100%">
        <tbody>
        <tr >
        
          <td>
	  <table border="0" cellpadding="0" cellspacing="0" style="padding-right:5px;padding-top:2px;padding-bottom:2px;">

	  <tr>
	  <td><img src="themes/images/filter.png" border=0></td>
	  <td><?php echo $this->_tpl_vars['APP']['LBL_VIEW']; ?>

	  <?php $_from = $this->_tpl_vars['CUSTOMVIEW_OPTION']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['viewname']):
        $this->_foreach['listviewforeach']['iteration']++;
?>

			<?php if ($this->_tpl_vars['id'] == $this->_tpl_vars['VIEWID']): ?> 
			<span style="padding-right:5px;padding-top:5px;padding-bottom:5px;">
			&nbsp;&nbsp;<a class="cus_markbai tablink" href="javascript:;" onclick="javascript:getTabView('<?php echo $this->_tpl_vars['MODULE']; ?>
','viewname=<?php echo $this->_tpl_vars['id']; ?>
',this,<?php echo $this->_tpl_vars['id']; ?>
);"><?php echo $this->_tpl_vars['viewname']; ?>
</a>&nbsp;&nbsp;
			</span>
			<?php else: ?>
			<span style="padding-right:5px;padding-top:5px;padding-bottom:5px;">
			&nbsp;&nbsp;<a class="cus_markhui tablink" href="javascript:;" onclick="javascript:getTabView('<?php echo $this->_tpl_vars['MODULE']; ?>
','viewname=<?php echo $this->_tpl_vars['id']; ?>
',this,<?php echo $this->_tpl_vars['id']; ?>
);"><?php echo $this->_tpl_vars['viewname']; ?>
</a>&nbsp;&nbsp;
			</span>
			<?php endif; ?>		
			
	  <?php endforeach; endif; unset($_from); ?>
	  
	
		<?php if ($this->_tpl_vars['ALL'] == 'All'): ?>        
			<span style="padding-right:5px;padding-top:5px;padding-bottom:5px;">&nbsp;<a href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=CustomView&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP']['LNK_CV_CREATEVIEW']; ?>
</a> | 
						
						<a href="javascript:editView('<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['CATEGORY']; ?>
')"><?php echo $this->_tpl_vars['APP']['LNK_CV_EDIT']; ?>
</a> |
						
						<a href="javascript:deleteView('<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['CATEGORY']; ?>
')"><?php echo $this->_tpl_vars['APP']['LNK_CV_DELETE']; ?>
</a></span>&nbsp;
		<?php else: ?>
		        <span style="padding-right:5px;padding-top:5px;padding-bottom:5px;"> &nbsp;</span>
		        
		<?php endif; ?>
		
		</td>
        
      
		</tr>
            </tbody></table>
	</td>
        </tr>
        
	<tr>
          <td  colspan=3 bgcolor="#ffffff" valign="top">


<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>

     <tr>

     <tr>
        

	<td class="lvt" valign="top" width=100% style="padding:2px;">

	 
	   <!-- PUBLIC CONTENTS STARTS-->
	  <div id="ListViewContents" class="small" style="width:100%;position:relative;">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "Accounts/ListViewEntries.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	  </div>

     </td>
   </tr>
</table>
<!-- New List -->
</td></tr></tbody></table>

<div id="selectoperate" class="drop_mnu" onMouseOut="fnHideDrop('selectoperate')" onMouseOver="fnShowDrop('selectoperate')" >
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td><a href="#" onclick="javascript:return massDelete('<?php echo $this->_tpl_vars['MODULE']; ?>
');" class="drop_down">批量删除</a></td></tr>
	<tr><td><a href="#" onclick="javascript:quick_edit(this, 'quickedit', 'Accounts');return false;" class="drop_down">批量修改</a></td></tr>
	<tr><td><a href="#" onclick="javascript:qunfa_mail(this, 'qunfamail', 'Accounts');return false;" class="drop_down">批量发邮件</a></td></tr>
    <tr><td><a href="#" onclick="javascript:qunfa_sms(this, 'qunfasms', 'Accounts');return false;" class="drop_down">批量发短信</a></td></tr>
</table>
</div>

<div id="quickedit" class="layerPopup" style="display:none;width:450px;z-index:1000;">
<form name="quickedit_form" id="quickedit_form" action="javascript:void(0);">
<!-- Hidden Fields -->
<input type="hidden" name="quickedit_recordids">
<input type="hidden" name="quickedit_module">
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="layerHeadingULine">
<tr>
	<td class="layerPopupHeading" align="left" width="60%"><?php echo $this->_tpl_vars['APP']['LBL_QUICKEDIT_FORM_HEADER']; ?>
</td>
	<td>&nbsp;</td>
	<td align="right" width="40%"><img onClick="fninvsh('quickedit');" title="<?php echo $this->_tpl_vars['APP']['LBL_CLOSE']; ?>
" alt="<?php echo $this->_tpl_vars['APP']['LBL_CLOSE']; ?>
" style="cursor:pointer;" src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
close.gif" align="absmiddle" border="0"></td>
</tr>
</table>
<div id="quickedit_form_div"></div>
<table border=0 cellspacing=0 cellpadding=5 width=100% >
	<tr>
		<td align="center">
				<input type="button" name="button" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_LABEL']; ?>
" onClick="ajax_quick_edit()">
				<input type="button" name="button" class="crmbutton small cancel" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" onClick="fninvsh('quickedit')">
		</td>
	</tr>
</table>
</form>
</div>
<!-- END -->

<div id="qunfamail" class="layerPopup" style="display:none;width:450px; z-index:1000;">
<form name="qunfamail_form" id="qunfamail_form" action="javascript:void(0);">
<!-- Hidden Fields -->
<input type="hidden" name="qunfamail_recordids">
<input type="hidden" name="qunfamail_module">
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="layerHeadingULine">
<tr>
	<td class="layerPopupHeading" align="left" width="60%">群发邮件</td>
	<td>&nbsp;</td>
	<td align="right" width="40%"><img onClick="fninvsh('qunfamail');" title="<?php echo $this->_tpl_vars['APP']['LBL_CLOSE']; ?>
" alt="<?php echo $this->_tpl_vars['APP']['LBL_CLOSE']; ?>
" style="cursor:pointer;" src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
close.gif" align="absmiddle" border="0"></td>
</tr>
</table>
<div id="qunfamail_form_div"></div>
<table border=0 cellspacing=0 cellpadding=5 width=100% >
	<tr>
		<td align="center">
				<input type="button" name="button" class="crmbutton small save" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_LABEL']; ?>
" onClick="SendMailToAll('Maillists','','')">
				<input type="button" name="button" class="crmbutton small cancel" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" onClick="fninvsh('qunfamail')">
		</td>
	</tr>
</table>
</form>
</div>


<input type="hidden" id="tabview"  value="<?php echo $this->_tpl_vars['tabview']; ?>
" />
<input type="hidden" id="recordid"  value="" />
<input type="hidden" id="modulename"  value="Accounts" />
<script>
var record = '<?php echo $this->_tpl_vars['RECORD']; ?>
';
var winsa=null;


function showhide_dept(deptId,imgId)
{
	var x=document.getElementById(deptId).style;
	if (x.display=="none")
	{
		x.display="block";
		document.getElementById(imgId).src = "<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
minus.gif";
	}
	else
	{
		x.display="none";
		document.getElementById(imgId).src = "<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
plus.gif";
	}
}

<?php echo '

function ajaxChangeStatus(statusname)
{
	$("status").style.display="inline";
	//var viewid = document.getElementById(\'viewname\').options[document.getElementById(\'viewname\').options.selectedIndex].value;
	var viewid = document.getElementById(\'viewname\').value;
	var idstring = document.getElementById(\'idlist\').value;
	if(statusname == \'status\')
	{
		fninvsh(\'changestatus\');
		var url=\'&leadval=\'+document.getElementById(\'lead_status\').options[document.getElementById(\'lead_status\').options.selectedIndex].value;
		var urlstring ="module=Users&action=updateLeadDBStatus&return_module=Leads"+url+"&viewname="+viewid+"&idlist="+idstring;
	}
	else if(statusname == \'owner\')
	{
	    fninvsh(\'changeowner\');
	    var url=\'&user_id=\'+document.getElementById(\'lead_owner\').options[document.getElementById(\'lead_owner\').options.selectedIndex].value;
	    '; ?>

	    var urlstring ="module=Users&action=updateLeadDBStatus&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
"+url+"&viewname="+viewid+"&idlist="+idstring;
	    <?php echo '
		
	}
	new Ajax.Request(
                \'index.php\',
                {queue: {position: \'end\', scope: \'command\'},
                        method: \'post\',
                        postBody: urlstring,
                        onComplete: function(response) {
                                $("status").style.display="none";
                                result = response.responseText.split(\'&#&#&#\');
                                $("ListViewContents").innerHTML= result[2];
                                if(result[1] != \'\')
                                        alert(result[1]);
                        }
                }
        );
	
}

function clearSearchResult(module,searchtype){
    $("status").style.display="inline";
	getTabViewNewClear();
	if(searchtype ==\'advSearch\'){
		winsa.close();
	}
	if(searchtype ==\'basicSearch\'){
		document.basicSearch.search_text.value = \'\';
	}
	
    new Ajax.Request(
		\'index.php\',
		{queue: {position: \'end\', scope: \'command\'},
			method: \'post\',
			postBody:\'clearquery=true&file=index&module=\'+module+\'&action=\'+module+\'Ajax&ajax=true\',
			onComplete: function(response) {
                               
				               $("status").style.display="none";
							   
                                result = response.responseText.split(\'&#&#&#\');
                                $("ListViewContents").innerHTML= result[2];
                                result[2].evalScripts();
                                if(result[1] != \'\')
                                        alert(result[1]);
										
			}
	       }
        );
}





function openDialogs(record){
//window.open(\'index.php?module=Announcements&action=PopupUser\',\'test\',\'width=700,height=602,resizable=1,scrollbars=1\');
//Dialog.confirm($(\'rec\').innerHTML, {maximizable:false,minimizable:false,className:"mac_os_x",title:"选择接收人",draggable:true,width:400, okLabel: "确认", cancelLabel: "取消", onOk:function(win){ return getReceiver(); }});
if(!winsa){
winsa = new Window({maximizable:false,minimizable:false,className:"mac_os_x", title:"创建联系记录",width:"630px",height:"360px", destroyOnClose: false, recenterAuto:false});
//winsa.getContent().update($(\'rec\').innerHTML.gsub("recform1","recform").gsub("rectable1","rectable"));
}
//console.log($(\'rectable\'))
var options={
              method: \'post\',
              asynchronous:false,
              postBody:"module=Notes&action=NotesAjax&file=NewEditView&return_id="+record+"&return_module=Accounts"
            };
    
winsa.setAjaxContent("index.php", options, true, false);
if(!winsa.isMinimized()&&!winsa.isMaximized()){
new PeriodicalExecuter(function(pe) {
var width=630;
var height=360;
if(width!=0&&height!=0){
	if(Prototype.Browser.IE){
		height=height+23;
	}else{
		height=height+10;
	}
	if(width<600) width=600;
	winsa.setSize(width, height);
	pe.stop();
}

}, 0.5);
}
// wins.setSize(width, height);
// console.log([$(\'rectable\').getWidth(), $(\'rectable\').getHeight()])
}

function saveNotes(){
	var notes_title = document.EditView.notes_title.value;
	if(notes_title ==\'\'){
		alert("主题不能为空");
		document.EditView.notes_title.focus();
		return false;
	}
	
	
	
	var inputels=$$(\'.upaccount\');
	var searchobj={}
	searchobj[\'search\']=\'true\';    
	for(var i=0;i<inputels.length;i++){
		var inputel=inputels[i];
		searchobj[inputel.name]=$F(inputel);
	}
	document.EditView.savebutton.disabled = true;
	var findstr="&"+$H(searchobj).toQueryString();
	
	$("status").style.display="inline";
		new Ajax.Request(

			\'index.php\',

			  {queue: {position: \'end\', scope: \'command\'},

				method: \'post\',

				postBody: \'module=Notes&action=NotesAjax&file=Save\'+findstr,

				onComplete: function(response) {
						$("status").style.display="none";	
						result = response.responseText; 
						winsa.close();
						getTabViewForList("Noteinfo",\'\');	
				}
			  }
		);
}

</script>
'; ?>

