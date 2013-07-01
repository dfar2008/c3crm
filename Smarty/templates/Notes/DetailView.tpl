<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>

 <!-- center start -->
 <div class="container-fluid" style="height:606px;">
    <div class="row-fluid">
      
      <div class="span12" style="margin-left:0px;">
        <form action="index.php" method="post" name="DetailView" id="form">
          {include file='DetailViewHidden.tpl'}
          
         <div  class="pull-left" style="margin-bottom:5px;" >
              <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="location.href='index.php?module={$MODULE}&action=ListView&parenttab=Customer'">
                <i class="icon-arrow-left icon-white"></i>返回列表</button>
              <button class="btn btn-small btn-success" style="margin-top:2px;" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit" name="Edit" >
                <i class="icon-edit icon-white"></i>编辑</button>
          </div>
          <div class="pull-right" style="margin-bottom:5px;" >
               <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.isDuplicate.value='true';this.form.module.value='{$MODULE}'; this.form.action.value='EditView'" type="submit" name="Duplicate">
                <i class="cus-page_copy icon-white"></i>复制</button>
               <button class="btn btn-small btn-danger" style="margin-top:2px;"  onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='index'; this.form.action.value='Delete'; return confirm('{$APP.NTC_DELETE_CONFIRMATION}')" type="submit" name="Delete" > 
                <i class="icon-trash icon-white"></i>删除</button>
         </div>
         <div class="clearfix"></div>
          <div class="accordion"  style="margin-top:0px;margin-bottom:0px;overflow:auto;height:580px;">
          {foreach key=header item=detail name=listviewforeach from=$BLOCKS}
                <div class="accordion-group">
                   <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse"  href="#detail_{$smarty.foreach.listviewforeach.iteration}">
                      {$header}
                    </a>
                  </div>
                  <div id="detail_{$smarty.foreach.listviewforeach.iteration}" class="accordion-body collapse in">
                    <div class="accordion-inner">
                        <table class="table table-bordered table-hover table-condensedfordv dvtable">
                         <tbody>
                          {foreach item=detail from=$detail}
                          <tr>  
                            {foreach key=label item=data from=$detail}
                               {assign var=keyid value=$data.ui}
                               {assign var=keyval value=$data.value}
                               {assign var=keyseclink value=$data.link}
                                   {if $label ne ''}
                                     <td class="dvt">{$label}</td>
                                     {include file="DetailViewFields.tpl"}
                                   {/if}
                            {/foreach}
                          </tr>
                          {/foreach}
                         </tbody>
                        </table>
                   </div>
                 </div>
                </div>
            {/foreach}
            </form>
          </div>
      </div>
    </div>
 </div>
