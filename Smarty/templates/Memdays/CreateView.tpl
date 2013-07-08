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
     <div class="container-fluid">
        <div class="row-fluid">
         
          <div class="span12" style="margin-left:0px;">
             <div  class="pull-left" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="goback();">
                    <i class="icon-arrow-left icon-white"></i>取消</button>
              </div>
              <div class="pull-right" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-success" style="margin-top:2px;" onclick="this.form.action.value='Save';return validateInventory()" name="savebutton">
                    <i class="icon-ok icon-white"></i> 保存 </button>
                 
             </div>
             <div class="clearfix"></div>
              <div class="accordion"  style="margin-top:0px;margin-bottom:0px;">
              	{foreach key=header item=data name=listviewforeach from=$BASBLOCKS}
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

<script>	
        var fieldname = new Array({$VALIDATION_DATA_FIELDNAME})
        var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL})
        var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE})
		var curryear = "{$curryear}";
		var currmonth = "{$currmonth}";
		var currdays = "{$currdays}";
		{literal}
		window.onload = function(){
			setYearOpts(curryear);
			var calendar = document.EditView.memday1004;
			calendar.onchange = function(){
				setMonthOpts(currmonth);
				document.EditView.memday944.length = 1;
			};
			calendar.onchange();
			
			var monthobj = document.EditView.memday942;
			monthobj.onchange = function(){
				document.EditView.memday944.length = 1;
				var month = document.EditView.memday942.value;
				month = parseInt(month);
				if(month > 0){
					setDaysOpts(currdays);
				}
			};
			monthobj.onchange();
			var yearobj = document.EditView.memday940;
			yearobj.onchange = function(){
				document.EditView.memday944.length = 1;
				var year = document.EditView.memday940.value;
				year = parseInt(year);
				if(year > 0){
					setDaysOpts(currdays);
				}
			};
		}
		{/literal}
</script>
 