function getListViewEntries_js(module,url)
{
	$("#status").css("display","inline");
	var querystr=$('#the_query_string').val();
	$.ajax({
		type:"GET",
		url:"index.php?module=Home&action=HomeAjax&file=UnifiedSearch&ajax=true&selectedmodule="+module+"&"+url+"&query_string="+querystr,
		success:function(msg){
			$("#status").css("display","none");
			result = msg.split('&#&#&#');
			$("#searchlistview_"+module).html(result[2]);
			//if(result[1] != '')
				//alert(result[1]);
			//eval(result[2]);
			//$("#searchlistview_"+module).html(msg);
		}
	});

}

function getListViewWithPageNo(module,pageElement)
{
	//var pageno = document.getElementById('listviewpage').value;
	var pageno = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'start='+pageno);
}

function getListViewWithPageSize(module,pageElement)
{
var pagesize = pageElement.options[pageElement.options.selectedIndex].value;
getListViewEntries_js(module,'pagesize='+pagesize);
} 
