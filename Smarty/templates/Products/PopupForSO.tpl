<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3>查找产品</h3>
</div>
<div class="modal-body" >


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

