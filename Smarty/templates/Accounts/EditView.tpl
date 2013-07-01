<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>

{*<!-- Contents -->*}
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

<!-- center start -->
     <div class="container-fluid" style="height:608px;">
        <div class="row-fluid">
          <div class="span2">
              <div class="accordion" id="accordion2" style="margin-top:0px;margin-bottom:0px;overflow-y:scroll;height:550px;">
                {include file="$MODULE/DetailLeft.tpl"}

             </div>
          </div>
          <div class="span10" style="margin-left:10px;">
             <div  class="pull-left" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="goback();">
                    <i class="icon-arrow-left icon-white"></i>取消</button>
              </div>
              <div class="pull-right" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-success" style="margin-top:2px;" onclick="this.form.action.value='Save';check_duplicate()" name="savebutton">
                    <i class="icon-ok icon-white"></i> 保存 </button>
                 
             </div>
             <div class="clearfix"></div>
              <div class="accordion"  style="margin-top:0px;margin-bottom:0px;overflow-y:scroll;height:550px;width:1200px;">
              	{foreach key=header item=data from=$BLOCKS}
                  <div class="accordion-group">
                     <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse"  href="#detailOne">
                        {$header}
                      </a>
                    </div>
                    <div id="detailOne" class="accordion-body collapse in">
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
               <div  class="pull-left" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="goback();">
                    <i class="icon-arrow-left icon-white"></i>取消</button>
              </div>
              <div class="pull-right" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-success" style="margin-top:2px;" onclick="this.form.action.value='Save';check_duplicate()" name="savebutton">
                    <i class="icon-ok icon-white"></i> 保存 </button>
             </div>
             <div class="clearfix"></div>
            
          </div>
        </div>
     </div>
     <!-- center end -->
</form>

<script>	
        var fieldname = new Array({$VALIDATION_DATA_FIELDNAME})
        var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL})
        var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE})
		if(getObj("customernum") != undefined) {ldelim}
		if(getObj("customernum").value == "") {ldelim}
			getObj("customernum").value = "{$APP.AUTO_GEN_CODE}";
			//getObj("customernum").setAttribute("readOnly","true");
		{rdelim}
		else {ldelim}
			//getObj("customernum").setAttribute("readOnly","true");
		{rdelim}
	{rdelim}

</script>
 