 <script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<script language="javascript">
function callSearch(searchtype)
{ldelim} 
        $("#status").css('display','inline');
        search_fld_val= $('#bas_searchfield').val();;

        search_txt_val= $('input[name=search_text]').val();
        var urlstring = 'index.php?';
        if(searchtype == 'Basic')
        {ldelim}
              urlstring += 'search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val+'&';
        {rdelim}
        else if(searchtype == 'Advanced')
        {ldelim}
                var no_rows = document.advSearch.search_cnt.value;
                for(jj = 0 ; jj < no_rows; jj++)
                {ldelim}
                        var sfld_name = getObj("Fields"+jj);
                        var scndn_name= getObj("Condition"+jj);
                        var srchvalue_name = getObj("Srch_value"+jj);
                        urlstring = urlstring+'Fields'+jj+'='+sfld_name[sfld_name.selectedIndex].value+'&';
                        urlstring = urlstring+'Condition'+jj+'='+scndn_name[scndn_name.selectedIndex].value+'&';
                        urlstring = urlstring+'Srch_value'+jj+'='+srchvalue_name.value+'&';
                {rdelim}
                for (i=0;i<getObj("matchtype").length;i++){ldelim}
                        if (getObj("matchtype")[i].checked==true)
                                urlstring += 'matchtype='+getObj("matchtype")[i].value+'&';
                {rdelim}
                urlstring += 'search_cnt='+no_rows+'&';
                urlstring += 'searchtype=advance&'
        {rdelim}
      
      $.ajax({ldelim}  
           type: "GET",  
           //dataType:"Text",   
           url:urlstring +'query=true&file=index&module={$MODULE}&action={$MODULE}Ajax&ajax=true',
           success: function(msg){ldelim}   
             $("#status").css("display","none");
             if(searchtype == 'Advanced'){ldelim}  
                $('#gaojisearch').modal('hide');
             {rdelim}  
             $("#ListViewContents").html(msg); 
           {rdelim}  
      {rdelim});

{rdelim}
function alphabetic(module,url,dataid)
{ldelim} 
        for(i=1;i<=26;i++)
        {ldelim}
                var data_td_id = 'alpha_'+ eval(i);
                getObj(data_td_id).addClass('searchAlph');

        {rdelim}
        getObj(dataid).addClass('searchAlphselected');
        $("#status").css('display','inline');
        
        $.ajax({ldelim}  
           type: "GET",  
           url:'index.php?module='+module+'&action='+module+'Ajax&file=index&ajax=true&'+url,
           success: function(msg){ldelim}   
             $("#status").css("display","none");
             $("#ListViewContents").html(msg); 
           {rdelim}  
        {rdelim});
{rdelim}

</script>
 <div class="container-fluid"> 

        <div style="margin-left:0px;margin-right:10px">
             <div>
                <div class="pull-left">
                  <form class="form-search pull-left" style="margin-bottom:5px;" name="basicSearch"  action="index.php" method="POST">
                      <select name="search_field" id="bas_searchfield" class="txtBox" style="width:130px">
                       {html_options  options=$SEARCHLISTHEADER selected=$BASICSEARCHFIELD}
                      </select>
                      <input type="hidden" name="searchtype" value="BasicSearch">
                      <input type="hidden" name="module" value="{$MODULE}">
                      <input type="hidden" name="parenttab" value="{$CATEGORY}">
                      <input type="hidden" name="action" value="index">
                      <input type="hidden" name="query" value="true">
                      <input type="hidden" name="search_cnt">
                      <input type="text" class="input-large search-query" value="{$BASICSEARCHVALUE}" name="search_text" onkeydown="javascript:if(event.keyCode==13) callSearch('Basic');return false;">
                      <button type="button" class="btn btn-small" onClick="callSearch('Basic');"><i class="icon-search"></i>&nbsp;搜索</button>
                      <button type="button" class="btn btn-small " onClick="clearSearchResult('{$MODULE}','BasicSearch');">
                      <i class="icon-remove-sign"></i>&nbsp;取消查找</button>
                      <button type="button" class="btn btn-small " onClick="openAdvanceDialogs('{$MODULE}');">
                      <i class="icon-share-alt"></i>&nbsp;高级搜索</button>
                      

                  </form>
                </div>
				<!--
                <div class="pull-right">
                  <button class="btn btn-small" style="margin-top:2px;"><i class="icon-refresh"></i>刷新</button>
                  <button class="btn btn-small" style="margin-top:2px;"><i class="icon-calendar"></i>日历</button>
                 <button class="btn btn-small" style="margin-top:2px;"><i class="icon-folder-open"></i>收藏</button>
                  <button class="btn btn-small" style="margin-top:2px;"><i class="icon-book"></i>帮助</button>
                  <button class="btn btn-small" style="margin-top:2px;"><i class="icon-home"></i>导航</button>
                </div> -->
                <div class="clear"></div> 
            </div>
            <div id="tablink">
              <ul class="nav nav-pills" style="margin-bottom:5px;">
                <li class="nav-header" style="padding-left:0px;padding-right:5px;">
                  <i class="icon-th-list"></i> 
                </li>

                 {foreach name="listviewforeach" key=id item=viewname from=$CUSTOMVIEW_OPTION}
                  {if $id eq $VIEWID} 
                    <li class="active"><a href="javascript:;" onclick="javascript:getTabView('{$MODULE}','viewname={$id}',this,{$id});" >{$viewname}</a></li>
                  {else}
                    <li ><a href="javascript:;" onclick="javascript:getTabView('{$MODULE}','viewname={$id}',this,{$id});">{$viewname}</a></li>
                  {/if}
                 {/foreach}
				 {if $ISADMIN === true}
                <li>
                  <a href="index.php?module={$MODULE}&action=CustomView&parenttab={$CATEGORY}" style="padding:2px;">
                    <i class="cus-add"></i></a>
                </li> 
                <li>
                   <a href="javascript:editView('{$MODULE}','{$CATEGORY}')" style="padding:2px;"><i class="cus-pencil"></i></a>
                </li>
                <li> 
                  <a href="javascript:deleteView('{$MODULE}','{$CATEGORY}')" style="padding:2px;"><i class="cus-cancel"></i></a>
                </li>
				{/if}
              </ul>
          </div>

          <div style="margin-top:2px;padding-top:5px;margin-bottom:5px;border-top:2px solid #0088CC;" >

             
              <div class="pull-left" style="margin-bottom:5px;">
                <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="javascript:location.href='index.php?module={$MODULE}&action=EditView'">
                  <i class="icon-plus icon-white"></i>新增</button>
                <button class="btn btn-small btn-danger" style="margin-top:2px;" onclick="javascript:return massDelete('{$MODULE}');">
                  <i class="icon-trash icon-white"></i>删除</button>
                <button class="btn btn-small btn-inverse" style="margin-top:2px;" onclick="javascript:quick_edit(this, 'quickedit', '{$MODULE}');return false;" >
                  <i class="icon-edit icon-white"></i>修改</button>
                <button class="btn btn-small btn-success" style="margin-top:2px;" onclick="javascript:location.href='index.php?module={$MODULE}&action=Import&step=1&return_module={$MODULE}&return_action=index&parenttab=Customer'">
                  <i class="icon-download icon-white"></i>导入</button>
                <button class="btn btn-small btn-success" style="margin-top:2px;" onclick="return selectedRecords('{$MODULE}','{$CATEGORY}')" >
                  <i class="icon-upload icon-white"></i>导出</button>
                 <button class="btn btn-small " style="margin-top:2px;" onclick="javascript:qunfa_mail(this, 'qunfamail', '{$MODULE}');return false;">
                  <i class="icon-envelope"></i>发送邮件</button>
                 <button class="btn btn-small " style="margin-top:2px;" onclick="javascript:qunfa_sms(this, 'qunfasms', '{$MODULE}');return false;">
                  <i class="icon-comment"></i>发送短信</button>

              </div>
               <div class="pull-right">
                  
              </div>
          </div>
          <div class="clear"></div> 

           <div id="ListViewContents" class="small" style="width:100%;position:relative;">
            {include file="$MODULE/ListViewEntries.tpl"}
          </div>

        </div>
      </div>

    </div>