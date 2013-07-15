<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3>查找客户</h3>
</div>
<div class="modal-body" >

<div class="container-fluid" > 
     
        <div  style="margin-left:10px;">
             <div>
                  <form name="basicSearch" action="index.php" onsubmit="return false;">
                    <table width="100%" cellpadding="5" cellspacing="0" class="table table-bordered table-hover table-condensed table-striped">
                    <tr>
                      <td width="35%" >             
                       <select name ="search_field" class="txtBox">
                         {html_options  options=$SEARCHLISTHEADER }
                       </select> &nbsp;
                      </td>
                      <td width="30%" >
                        <input type="text" name="search_text" class="txtBox" onkeydown="javascript:if(event.keyCode==13) callSearch('Basic')">
                        <input type="hidden" name="searchtype" value="BasicSearch">
                        <input type="hidden" name="module" value="{$MODULE}">
                        <input type="hidden" name="action" value="Popup">
                        <input type="hidden" name="query" value="true">
                        <input type="hidden" name="select_enable" id="select_enable" value="{$SELECT}">
                        <input type="hidden" name="curr_row" id="curr_row" value="{$CURR_ROW}">
                        <input name="popuptype" id="popup_type" type="hidden" value="{$POPUPTYPE}">
                        <input name="recordid" id="recordid" type="hidden" value="{$RECORDID}">
                        <input name="return_module" id="return_module" type="hidden" value="{$RETURN_MODULE}">
                        <input name="from_link" id="from_link" type="hidden" value="{$smarty.request.fromlink.value}">
                        <input id="viewname" name="viewname" type="hidden" value="{$VIEWID}">
              
                      </td>
                      <td >
                        <button type="button" class="btn btn-small" onClick="callSearch('Basic');"><i class="icon-search"></i>&nbsp;{$APP.LBL_SEARCH_NOW_BUTTON}</button>
                       
                      </td>
                    </tr>
                     <tr>
                      <td colspan="4" align="center">
                        <table width="100%" >
                        <tr>  
                          {$ALPHABETICAL}
                        </tr>
                        </table>
                      </td>
                    </tr>
                    </table>
                  </form>
               
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
              </ul>
          </div>
      
           <div id="ListViewContents" class="small" style="width:100%;position:relative;">
            {include file="Accounts/PopupContents.tpl"}
          </div>

        </div>
      </div>

    </div>
</div>
<div class="modal-footer" >
  <div class="pull-left">
  {if $SELECT neq 'enable'}
    <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="if(SelectAll('{$MODULE}','{$RETURN_MODULE}')) window.close();">
          <i class="icon-ok icon-white"></i>{$APP.LBL_ADD_ITEM} {$APP[$MODULE]}</button>
    {/if}
  </div>
  <div class="pull-right"></div>
  <div class="clear"></div>
</div>
<script>
var gPopupAlphaSearchUrl = '';
function callSearch(searchtype)
{ldelim}
    for(i=1;i<=26;i++)
    {ldelim}
        var data_td_id = 'alpha_'+ eval(i);
        getObj(data_td_id).className = 'searchAlph';
    {rdelim}
    gPopupAlphaSearchUrl = '';
    search_fld_val= document.basicSearch.search_field[document.basicSearch.search_field.selectedIndex].value;
    search_txt_val=document.basicSearch.search_text.value;
    var urlstring = '';
    if(searchtype == 'Basic')
    {ldelim}
	urlstring = 'search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val;
    {rdelim}
	popuptype = $('popup_type').value;
	urlstring += '&popuptype='+popuptype;
	urlstring = urlstring +'&query=true&file=Popup&module={$MODULE}&action={$MODULE}Ajax&ajax=true';
	urlstring +=gethiddenelements();
	$.ajax({ldelim}  
		   type: "GET",  
		   url:'index.php?'+urlstring,
		   success: function(msg){ldelim}   
		   	 $("#ListViewContents").html(msg); 
		   {rdelim}  
	{rdelim});
{rdelim}	
function alphabetic(module,url,dataid)
{ldelim}
    document.basicSearch.search_text.value = '';	
    for(i=1;i<=26;i++)
    {ldelim}
	var data_td_id = 'alpha_'+ eval(i);
	getObj(data_td_id).className = 'searchAlph';
    {rdelim}
    getObj(dataid).className = 'searchAlphselected';
    gPopupAlphaSearchUrl = '&'+url;	
    var urlstring ="module="+module+"&action="+module+"Ajax&file=Popup&ajax=true&"+url;
    urlstring +=gethiddenelements();
    $.ajax({ldelim}  
		   type: "GET",  
		   url:'index.php?'+urlstring,
		   success: function(msg){ldelim}   
		   	 $("#ListViewContents").html(msg); 
		   {rdelim}  
    {rdelim});    
{rdelim}
function gethiddenelements()
{ldelim}
	var urlstring='{$URLSTRING}'	
	if(getObj('select_enable').value != '')
		urlstring +='&select=enable';	
	if(document.getElementById('curr_row').value != '')
		urlstring +='&curr_row='+document.getElementById('curr_row').value;	
	if(getObj('recordid').value != '')
		urlstring +='&recordid='+getObj('recordid').value;	
	var return_module = document.getElementById('return_module').value;
	if(return_module != '')
		urlstring += '&return_module='+return_module;
	return urlstring;
{rdelim}																								
function getListViewEntries_js(module,url)
{ldelim}
	popuptype = document.getElementById('popup_type').value;
        var urlstring ="module="+module+"&action="+module+"Ajax&file=Popup&ajax=true&"+url;
    	urlstring +=gethiddenelements();
	search_fld_val= document.basicSearch.search_field[document.basicSearch.search_field.selectedIndex].value;
	search_txt_val=document.basicSearch.search_text.value;
    	if(search_txt_val != '')
		urlstring += '&query=true&search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val;
	if(gPopupAlphaSearchUrl != '')
		urlstring += gPopupAlphaSearchUrl;	
	else
		urlstring += '&popuptype='+popuptype;	
	$.ajax({ldelim}  
		   type: "GET",  
		   url:'index.php?'+urlstring,
		   success: function(msg){ldelim}
		   	 $("#ListViewContents").html(msg); 
		   {rdelim}  
	{rdelim});
{rdelim}

function getListViewWithPageNo(module,pageElement)
{ldelim}
	//var pageno = document.getElementById('listviewpage').value;
	var pageno = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'start='+pageno);
{rdelim}
function getListViewWithPageSize(module,pageElement)
{ldelim}
	//var pageno = document.getElementById('listviewpage').value;
	var pagesize = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'pagesize='+pagesize);
{rdelim}

function getListViewSorted_js(module,url)
{ldelim}
        var urlstring ="module="+module+"&action="+module+"Ajax&file=Popup&ajax=true"+url;
	$.ajax({ldelim}  
		   type: "GET",  
		   url:'index.php?'+urlstring,
		   success: function(msg){ldelim}   
		   	 $("#ListViewContents").html(msg); 
		   {rdelim}  
	{rdelim});
{rdelim}
</script>
