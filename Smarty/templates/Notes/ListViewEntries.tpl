<div id="quickedit_form_div" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="gaojisearch" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-380px;"></div>

<input name='search_url' id="search_url" type='hidden' value='{$SEARCH_URL}'>
 <input name="idlist" id="idlist" type="hidden">
 <input name="action" id="action" type="hidden">
 <input name="module" id="module" type="hidden">
 <input id="viewname" name="viewname" type="hidden" value="{$VIEWID}">
 <input name="change_owner" type="hidden">
 <input name="change_status" type="hidden">
 <input name="allids" type="hidden" value="{$ALLIDS}">

<div style="margin-top:0px;margin-bottom:0px;overflow:">
   <table class="table table-bordered table-hover table-condensed table-striped">
    <thead>
      <tr>  
          <th align="left" width="35">
            <input type="checkbox" name="selectedAll" id="selectedAll" />
          </th>
         {foreach name="listviewforeach" item=header from=$LISTHEADER}
             <th align="left">{$header}</th>
         {/foreach}
      </tr>
     </thead>
     <tbody>
       {foreach item=entity key=entity_id from=$LISTENTITY}
       <tr id="row_{$entity_id}"> 
          <td>
            <input type="checkbox" name="selected_id"  id="selected_id_{$entity_id}" value="{$entity_id}" />
          </td>
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


<script language="JavaScript" type="text/javascript">
{literal}
$(function() {
    //全选 | 反全选
   $("#selectedAll").click(function() { 
        $('input[name="selected_id"]').prop("checked",this.checked);
    });
    var $selected_id = $("input[name='selected_id']"); 
    $selected_id.click(function(){
        $("#selectedAll").prop("checked",$selected_id.length == $selected_id.filter(":checked").length.length ? true : false);
    });

});
{/literal}
</script>