<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>

{if $RETURN_ACTION=="CallRelatedList"}
<div class="modal-header">
	<button class="close" data-dismiss="modal" type="button" aria-hidden="true" >&times;</button>
	<h3>修改联系记录</h3>
</div>
<div class="modal-body" style="max-height:500px">
{/if}

	{*<!-- Contents -->*}
	{include file='EditViewHidden.tpl'}

	<!-- center start -->
		 <div class="container-fluid">
			<div class="row-fluid">
			  
			  <div class="span12" style="margin-left:0px;">
				 <div  class="pull-left" style="margin-bottom:5px;" >
					  {if $RETURN_ACTION=="CallRelatedList"}
					  <button type="button" class="btn btn-small btn-primary" style="margin-top:2px;" onclick="closeAccountRelInfo();">
					  {else}
					  <button type="button" class="btn btn-small btn-primary" style="margin-top:2px;" onclick="goback();">
					  {/if}
						<i class="icon-arrow-left icon-white"></i>取消</button>
				  </div>
				  <div class="pull-right" style="margin-bottom:5px;" >
					  <button class="btn btn-small btn-success" style="margin-top:2px;" onclick="this.form.action.value='Save';saveNots();" type="button" name="savebutton">
						<i class="icon-ok icon-white"></i> 保存 </button>
				 </div>
				 <div class="clearfix"></div>
				  <div class="accordion"  style="margin-top:0px;margin-bottom:0px;">
					{foreach key=header item=data name=listviewforeach from=$BLOCKS}
					  <div class="accordion-group">
						 <div class="accordion-heading">
						  <a class="accordion-toggle" data-toggle="collapse"  href="#detail_{$smarty.foreach.listviewforeach.iteration}">
							{$header}
						  </a>
						</div>
						<div id="detail_{$smarty.foreach.listviewforeach.iteration}" class="accordion-body collapse in">
						  <div class="accordion-inner">
							  <table class="table table-bordered table-hover table-condensedforev dvtable">
							   <tbody>
								{include file="DisplayFields.tpl"}
							   </tbody>
							  </table>
						 </div>
					   </div>
					  </div>
					  {/foreach}
					  
				  </div>
				   
				
			  </div>
			</div>
		 </div>
		 <!-- center end -->
	</form>

{if $RETURN_ACTION=="CallRelatedList"}	
</div>
<div class="modal-footer">
</div>
{/if}

<script>	
        var fieldname = new Array({$VALIDATION_DATA_FIELDNAME})
        var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL})
        var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE})
		var userDateFormat = "yyyy-mm-dd";
</script>
 