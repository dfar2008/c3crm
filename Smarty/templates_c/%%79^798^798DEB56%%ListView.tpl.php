<?php /* Smarty version 2.6.18, created on 2013-07-01 16:19:45
         compiled from Products/ListView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'Products/ListView.tpl', 80, false),)), $this); ?>
 <script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
.js"></script>
<script language="javascript">
function callSearch(searchtype)
{ 
        $("#status").css('display','inline');
        search_fld_val= $('#bas_searchfield').val();;

        search_txt_val= $('input[name=search_text]').val();
        var urlstring = 'index.php?';
        if(searchtype == 'Basic')
        {
              urlstring += 'search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val+'&';
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
      
      $.ajax({  
           type: "GET",  
           //dataType:"Text",   
           url:urlstring +'query=true&file=index&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&ajax=true',
           success: function(msg){   
             $("#status").css("display","none");
             if(searchtype == 'Advanced'){  
                $('#gaojisearch').modal('hide');
             }  
             $("#ListViewContents").html(msg); 
           }  
      });

}
function alphabetic(module,url,dataid)
{ 
        for(i=1;i<=26;i++)
        {
                var data_td_id = 'alpha_'+ eval(i);
                getObj(data_td_id).addClass('searchAlph');

        }
        getObj(dataid).addClass('searchAlphselected');
        $("#status").css('display','inline');
        
        $.ajax({  
           type: "GET",  
           url:'index.php?module='+module+'&action='+module+'Ajax&file=index&ajax=true&'+url,
           success: function(msg){   
             $("#status").css("display","none");
             $("#ListViewContents").html(msg); 
           }  
        });
}

</script>
 <div class="container-fluid" style="height:606px;"> 
      <div class="row-fluid">
        
        <div class="span12" style="margin-left:0px;">
             <div>
                <div class="pull-left">
                  <form class="form-search pull-left" style="margin-bottom:5px;" name="basicSearch"  action="index.php" method="POST">
                      <select name="search_field" id="bas_searchfield" class="txtBox" style="width:130px">
                       <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SEARCHLISTHEADER'],'selected' => $this->_tpl_vars['BASICSEARCHFIELD']), $this);?>

                      </select>
                      <input type="hidden" name="searchtype" value="BasicSearch">
                      <input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
                      <input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
                      <input type="hidden" name="action" value="index">
                      <input type="hidden" name="query" value="true">
                      <input type="hidden" name="search_cnt">
                      <input type="text" class="input-large search-query" value="<?php echo $this->_tpl_vars['BASICSEARCHVALUE']; ?>
" name="search_text" >
                      <button type="button" class="btn btn-small" onClick="callSearch('Basic');"><i class="icon-search"></i>&nbsp;搜索</button>
                      <button type="button" class="btn btn-small " onClick="clearSearchResult('<?php echo $this->_tpl_vars['MODULE']; ?>
','BasicSearch');">
                      <i class="icon-remove-sign"></i>&nbsp;取消查找</button>
                      <button type="button" class="btn btn-small " onClick="openAdvanceDialogs('<?php echo $this->_tpl_vars['MODULE']; ?>
');">
                      <i class="icon-share-alt"></i>&nbsp;高级搜索</button>
                      

                  </form>
                </div>
                <div class="pull-right"> 
                
                </div> 
                <div class="clear"></div> 
            </div>
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
                    <li class="active"><a href="javascript:;" onclick="javascript:getTabView('<?php echo $this->_tpl_vars['MODULE']; ?>
','viewname=<?php echo $this->_tpl_vars['id']; ?>
',this,<?php echo $this->_tpl_vars['id']; ?>
);" ><?php echo $this->_tpl_vars['viewname']; ?>
</a></li>
                  <?php else: ?>
                    <li ><a href="javascript:;" onclick="javascript:getTabView('<?php echo $this->_tpl_vars['MODULE']; ?>
','viewname=<?php echo $this->_tpl_vars['id']; ?>
',this,<?php echo $this->_tpl_vars['id']; ?>
);"><?php echo $this->_tpl_vars['viewname']; ?>
</a></li>
                  <?php endif; ?>
                 <?php endforeach; endif; unset($_from); ?>
                <li>
                  <a href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=CustomView&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" style="padding:2px;">
                    <i class="cus-add"></i></a>
                </li> 
                <li>
                   <a href="javascript:editView('<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['CATEGORY']; ?>
')" style="padding:2px;"><i class="cus-pencil"></i></a>
                </li>
                <li> 
                  <a href="javascript:deleteView('<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['CATEGORY']; ?>
')" style="padding:2px;"><i class="cus-cancel"></i></a>
                </li>
              </ul>
          </div>

          <div style="margin-top:2px;padding-top:5px;margin-bottom:5px;border-top:2px solid #0088CC;" >

             
              <div class="pull-left" style="margin-bottom:5px;">
                <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="javascript:location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=EditView'">
                  <i class="icon-plus icon-white"></i>新增</button>
                <button class="btn btn-small btn-danger" style="margin-top:2px;" onclick="javascript:return massDelete('<?php echo $this->_tpl_vars['MODULE']; ?>
');">
                  <i class="icon-trash icon-white"></i>删除</button>
              </div>
               <div class="pull-right">
                  
              </div>
          </div>
          <div class="clear"></div> 

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