<!--<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>-->
<!--<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>-->
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3>查找产品</h3>
</div>
<div class="modal-body" style="max-height:450px">

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
            {include file="Products/PopupContentsForSO.tpl"}
          </div>

        </div>
      </div>

    </div>
</div>
<div class="modal-footer" >
  <div class="pull-left">
  {if $SELECT eq 'enable'}
    <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="addMultiProductRow('SalesOrder');">
          <i class="icon-ok icon-white"></i>{$APP.LBL_ADD_ITEM} {$APP[$MODULE]}</button>
    {/if}
  </div>
  <div class="pull-right"></div>
  <div class="clear"></div>
</div>


