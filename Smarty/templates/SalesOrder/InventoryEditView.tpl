<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
{*<!-- Contents -->*}
{include file='EditViewHidden.tpl'}

<!-- center start -->
     <div class="container-fluid">
        <div class="row-fluid">
          
          <div class="span12" style="margin-left:0px;">
             <div  class="pull-left" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-primary" style="margin-top:2px;" onclick="goback();">
                    <i class="icon-arrow-left icon-white"></i>取消</button>
              </div>
              <div class="pull-right" style="margin-bottom:5px;" >
                  <button class="btn btn-small btn-success" style="margin-top:2px;"  type="button"
				 onclick="this.form.action.value='Save';validateInventory('{$MODULE}')" name="savebutton">
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
                  {if $APPIN_PROCESS eq ''}
                  <div>
					   <table class="table table-bordered table-condensedforev dvtable">
						   <tr>
							<td colspan=4>
								{include file="SalesOrder/ProductDetailsEditView.tpl"}
							</td>
						   </tr>
					   </table>
					   {else}
					   <table class="table table-bordered  table-condensedforev dvtable">
						   <tr>
							<td colspan=4>
								{include file="SalesOrder/ProductInfo.tpl"}
							</td>
						    </tr>
						</table>
					</div>
					{/if}
              </div>
             
            
          </div>
        </div>
     </div>
     <!-- center end -->
</form>

<script language="javascript">
        var fieldname = new Array({$VALIDATION_DATA_FIELDNAME})
        var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL})
        var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE})
		if(getObj("subject") != undefined) {ldelim}
			if(getObj("subject").value == "") {ldelim}
				getObj("subject").value = "{$APP.AUTO_GEN_CODE}";
				getObj("subject").setAttribute("readOnly","true");
			{rdelim}
			else {ldelim}
				getObj("subject").setAttribute("readOnly","true");
			{rdelim}
		{rdelim}



 
	{literal}
	function callSearch(searchtype){
		for(i=1;i<=26;i++){
			var data_td_id = 'alpha_'+ eval(i);
			//getObj(data_td_id).className = 'searchAlph';
			$("#"+data_td_id).addClass("searchAlph");
		}
		gPopupAlphaSearchUrl = '';
		search_fld_val= document.basicSearch.search_field[document.basicSearch.search_field.selectedIndex].value;
		search_txt_val=document.basicSearch.search_text.value;
		var urlstring = '';
		if(searchtype == 'Basic'){
			urlstring = 'search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val;
		}
		popuptype = $('#popup_type').value;
		urlstring += '&popuptype='+popuptype;
		urlstring = urlstring +'&query=true&file=PopupForSO&module=Products&action=ProductsAjax&ajax=true';
		urlstring +=gethiddenelements();
		$.ajax({
			type:"GET",
			url:"index.php?"+urlstring,
			success:function(msg){
				$("#ListViewContents").html(msg);
				setSelectedProductRow();
			}
		});
	} 
	function gethiddenelements(){
		var urlstring=''
		if($('#select_enable').val()!= '')
			urlstring +='&select=enable';
		if(document.getElementById('curr_row').value != '')
			urlstring +='&curr_row='+document.getElementById('curr_row').value;
		if($('#fldname_pb').val() != '')
			urlstring +='&fldname='+$('#fldname_pb').val();
		if($('#productid_pb').val() != '')
			urlstring +='&productid='+$('#productid_pb').val();
		if($('#recordid').val() != '')
			urlstring +='&recordid='+$('#recordid').val();
		var return_module = document.getElementById('return_module').value;
		if(return_module != '')
			urlstring += '&return_module='+return_module;
		var idlist = document.selectall.idlist.value;
		var productlist = document.selectall.productlist.value;
		urlstring = urlstring + "&idlist=" + idlist;
		urlstring = urlstring + "&productlist=" + productlist;
		if($('#vendor_id') != undefined && $('#vendor_id').val() != '')
			urlstring +='&vendor_id='+$('vendor_id').val();
		return urlstring;
	} 

	var gPopupAlphaSearchUrl = '';
	function getListViewEntries_js(module,url){
		popuptype = document.getElementById('popup_type').value;
		var urlstring ="module="+module+"&action="+module+"Ajax&file=PopupForSO&ajax=true&"+url;
		urlstring +=gethiddenelements();
		//search_fld_val= document.basicSearch.search_field[document.basicSearch.search_field.selectedIndex].value;
		search_fld_val= document.selectall.search_field.value;
		//search_txt_val=document.basicSearch.search_text.value;
		search_txt_val=document.selectall.search_text.value;
		if(search_txt_val != '')
			urlstring += '&query=true&search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val;
		if(gPopupAlphaSearchUrl != '')
			urlstring += gPopupAlphaSearchUrl;
		else
			urlstring += '&popuptype='+popuptype;
		$.ajax({
			type:"GET",
			url:"index.php?"+urlstring,
			success: function(msg){
				$("#ListViewContents").html(msg);
				setSelectedProductRow();
			}
		});
	} 

	function getListViewWithPageSize(module,pageElement){
		//var pageno = document.getElementById('listviewpage').value;
		var pagesize = pageElement.options[pageElement.options.selectedIndex].value;
		getListViewEntries_js(module,'pagesize='+pagesize);
	} 
	{/literal}
</script>