<form name="selectall_account" method="POST">
<input name="module" type="hidden" value="{$RETURN_MODULE}">
<input name="action" type="hidden" value="{$RETURN_ACTION}">
<input name="pmodule" type="hidden" value="{$MODULE}">
<input type="hidden" name="curr_row" value="{$CURR_ROW}"> 
<input name="entityid" type="hidden" value="">
<input name="popuptype" id="popup_type" type="hidden" value="{$POPUPTYPE}">
<input name="idlist" type="hidden" value="">

<div style="margin-top:0px;margin-bottom:0px;">
   <table class="table table-bordered table-hover table-condensed table-striped">
    <thead>
      <tr>  
        {if $SELECT neq 'enable'}
          <th align="left" width="35">
            <input type="checkbox" name="selectedAll" id="selectedAll" />
          </th>
         {/if} 
         {foreach name="listviewforeach" item=header from=$LISTHEADER}
             <th align="left">{$header}</th>
         {/foreach}
      </tr>
     </thead>
     <tbody>
       {foreach item=entity key=entity_id from=$LISTENTITY}
       <tr id="row_{$entity_id}"> 
         {if $SELECT neq 'enable'}
          <td>
            <input type="checkbox" name="selected_id"  id="selected_id_{$entity_id}" value="{$entity_id}" />
          </td>
         {/if}
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
</form>


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