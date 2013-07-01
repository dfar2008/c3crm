 <script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>

 <div class="container-fluid" style="height:606px;"> 
      <div class="row-fluid">
        <div class="span12" style="margin-left:0px;">

           <div id="ListViewContents" class="small" style="width:100%;position:relative;">
              <table  class="table table-bordered table-hover table-condensed table-striped">
                <tbody>
                <tr style="background:#DFEBEF;height:27px;">
                  <td class="moduleName" nowrap="" style="padding-left:10px;padding-right:50px">
                  <a class="hdrLink" href="index.php?action=ListView&module=Maillists">群发邮件</a>
                  &gt;&gt;
                  群发统计
                  </td>
                </tr>
                </tbody>
              </table>
               <form name="searchuser" action="index.php" method="post">
                    <input type="hidden" name="module" value="Relsettings">
                    <input type="hidden" name="action" value="Maillists">
                    <table class="table table-bordered table-hover table-condensed table-striped">
                    <tr>
                        <td  width="5%" nowrap="nowrap">邮件主题：</td> 
                        <td  width="10%"><input type="text" value="{$subject}" name="subject"/></td>
                        <td  width="5%" nowrap="nowrap">发件人：</td> 
                        <td  width="10%"><input type="text" value="{$from_name}" name="from_name"/></td>
                        <td  width="5%" nowrap="nowrap">发件人邮箱：</td> 
                        <td  width="10%"><input type="text" value="{$from_email}" name="from_email"/></td>
                        <td   align="left"><input type="submit" value=" 搜索 " name="submit" class="btn btn-primary btn-small"/></td> 
                    </tr>
                   </table>
                </form>
            <div style="margin-top:0px;margin-bottom:0px;overflow:auto;height:470px;">
             

             <table class="table table-bordered table-hover table-condensed table-striped">
              <thead>
                <tr>  
                    
                   {foreach name="listviewforeach" item=header from=$LISTHEADER}
                       <th align="left">{$header}</th>
                   {/foreach}
                </tr>
               </thead>
               <tbody>
                 {foreach item=entity key=entity_id from=$LISTENTITY}
                 <tr id="row_{$entity_id}"> 
                    
                   {foreach item=data from=$entity} 
                    <td>{$data}</td>
                   {/foreach}
                  </tr>  
                 {foreachelse}
                  <tr> 
                    <td colspan="{$smarty.foreach.listviewforeach.iteration+1}">{$APP.LBL_FOUND}</td>
                  </tr> 
                 {/foreach}

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
                    <small style="color:#999999;">{$RECORD_COUNTS}&nbsp;</small>
                    {$NAVIGATION}
                  </div>
                </div>
              </td>
              </tr>
              </tbody>
                </table>
            </div> 

          </div>
        </div>
      </div>

    </div>


<input type="hidden" value="{$order_url}" id="order_url"  name="order_url"/>
<input type="hidden" value="{$search_url}" id="search_url"  name="search_url"/>

{literal}
<script>
function getOrderBy(theorderbystr){
  getListViewEntries_js_2("Settings",theorderbystr);
} 
function getListViewEntries_js_2(module,url)
{ 
  $("#status").css('display','inline');
  if($('#search_url').val()!='')
    urlstring = $('#search_url').value;
  else
    urlstring = '';
  
  location.href="index.php?module=Relsettings&action=Maillists&"+url+urlstring;
}
function getListViewEntries_js(module,url)
{ 
  $("#status").css('display','inline');
  if($('#search_url').val()!='')
    urlstring = $('#search_url').val();
  else
    urlstring = '';
  if($('#order_url').val()!='')
    order_url = $('#order_url').val();
  else
    order_url = '';
  location.href="index.php?module=Relsettings&action=Maillists&"+url+urlstring+order_url;
}
function getListViewWithPageNo(module,pageElement)
{
  var pageno = pageElement.options[pageElement.options.selectedIndex].value;
  getListViewEntries_js(module,'start='+pageno);
}
function getListViewWithPageSize(module,pageElement)
{
  var pagesize = pageElement.options[pageElement.options.selectedIndex].value;
  getListViewEntries_js(module,'pagesize='+pagesize);
} 
</script>
{/literal}
