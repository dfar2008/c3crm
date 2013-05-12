function getListViewEntries_js(module,url)
{
	$("status").style.display="inline";
	var querystr=$F('the_query_string');
        new Ajax.Request(
        	'index.php',
                {queue: {position: 'end', scope: 'command'},
                	method: 'post',
                        postBody:"module=Home&action=HomeAjax&file=UnifiedSearch&ajax=true&selectedmodule="+module+"&"+url+"&query_string="+querystr,
			onComplete: function(response) {
                        	$("status").style.display="none";
                                result = response.responseText.split('&#&#&#');
                                $("searchlistview_"+module).innerHTML= result[2];
                                if(result[1] != '')
                                        alert(result[1]);
                                result[2].evalScripts();
                  	}
                }
        );
}

function getListViewWithPageNo(module,pageElement)
{
	//var pageno = document.getElementById('listviewpage').value;
	var pageno = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'start='+pageno);
}

