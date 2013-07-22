<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<script type="text/javascript" src="modules/Memdays/Memday.js"></script>
<script>
	var curryear = "{$curryear}";
		var currmonth = "{$currmonth}";
		var currdays = "{$currdays}";

	{literal}
		function editAccountRelInfo(urlstring){
			
			$.ajax({
				type:"GET",
				url:urlstring,
				success:function(msg){
					$("#account_rel").html(msg);
				}
			});
			$("#account_rel").modal("show");
		}
		function closeAccountRelInfo(){
			$("#account_rel").modal("hide");
		}
	{/literal}
</script>

<div class="modal hide fade" id="account_rel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:850px;"></div>

 <!-- center start -->
 <div class="container-fluid" style="height:606px;">
    <div class="row-fluid">
      <div class="span2">
           <div class="accordion" id="accordion2" style="margin-top:0px;margin-bottom:0px;overflow:auto;height:550px;">
            
            {include file="$MODULE/DetailLeft.tpl"}

         </div>
      </div>
       <div class="span10" style="margin-left:10px;">
          {include file= 'RelatedListNew.tpl'} 
       </div>
      </div>
    </div>
 </div>
