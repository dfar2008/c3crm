<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>

<form name="EditView" method="POST" action="index.php">
<input type="hidden" name="module" value="{$MODULE}">
<input type="hidden" name="record" value="{$ID}">
<input type="hidden" name="mode" value="{$MODE}">
<input type="hidden" name="action">
<input type="hidden" name="parenttab" value="{$CATEGORY}">
<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
<input type="hidden" name="return_id" value="{$RETURN_ID}">
<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
<input type="hidden" name="return_viewname" value="{$RETURN_VIEWNAME}">

{if $MODULE_ENABLE_PRODUCT eq true }
	{assign var="validateFunction" value="validateInventory"}
{else}
	{assign var="validateFunction" value="formValidate"}
{/if}

<!-- center start -->
     <div class="container-fluid" style="height:608px;">
        <div class="row-fluid">
          
          <div class="span12" style="margin-left:0px;">
             <div  class="pull-left" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="goback();">
                    <i class="icon-arrow-left icon-white"></i>取消</button>
              </div>
              <div class="pull-right" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-success" style="margin-top:2px;" onclick="this.form.action.value='Save';return {$validateFunction}()" tyle="button" name="savebutton">
                    <i class="icon-ok icon-white"></i> 保存 </button>
                 
             </div>
             <div class="clearfix"></div>
              <div class="accordion"  style="margin-top:0px;margin-bottom:0px;overflow:auto;height:550px;">
                  <div class="accordion-group">
                     <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse"  href="#detailOne">
                        基本信息
                      </a>
                    </div>
                    <div id="detailOne" class="accordion-body collapse in">
                      <div class="accordion-inner">
                          <table class="table table-bordered table-hover table-condensedforev dvtable">
                           <tbody>
                            <tr>
                            	<td class="dvt" ><font color=red>*</font>模板名称</td>
                            	<td ><input type="text" name="maillisttmpname" id="maillisttmpname" value="{$maillisttmpname}" style="width:400px;" /></td>
                            </tr>
                             <tr>
                            	<td class="dvt"><font color=red>*</font>内容</td>
                            	<td ><textarea name="description" style="width:900px;height:200px;">{$description}</textarea></td>
                            </tr>
                            <tr>
								<td class="dvt">备注</td>
								<td > 可用变量<b> $name$ </b>替换群发中的<b>联系人名称</b>.</td>
						    </tr>
                           </tbody>
                          </table>
                     </div>
                   </div>
                  </div>
                  
              </div>
               
            
          </div>
        </div>
     </div>
     <!-- center end -->
</form>

<script>	
        var fieldname = new Array({$VALIDATION_DATA_FIELDNAME})
        var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL})
        var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE})


</script>
 