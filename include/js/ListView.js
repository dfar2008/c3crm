/*********************************************************************************

** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
function change(obj,divid)
{
	var select_options  =  document.getElementsByName('selected_id');
	var x = select_options.length;
	var viewid =getviewId();
	idstring = "";

	xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			idstring = select_options[i].value +";"+idstring
				xx++
		}
	}
	if (xx != 0)
	{
		document.getElementById('idlist').value=idstring;
	}
	else
	{
		alert(alert_arr.SELECT);
		return false;
	}
	fnvshobj(obj,divid);
}
function getviewId()
{
	var viewid ='';
	if(typeof(document.getElementById("viewname")) != 'undefined')
	{
		//var viewid = oViewname.options[oViewname.selectedIndex].value;
		viewid = document.getElementById("viewname").value;
	}
	else
	{
		viewid ='';
	}
	return viewid;
}
function massDelete_old(module)
{       
		var select_options  =  document.getElementsByName('selected_id');
		var x = select_options.length;
		var viewid =getviewId();
		idstring = "";

        xx = 0;
        for(i = 0; i < x ; i++)
        {
        	if(select_options[i].checked)
            {
            	idstring = select_options[i].value +";"+idstring
                xx++
            }
        } 
        if (xx != 0)
        {
            document.getElementById('idlist').value=idstring;
        }
        else
        {
            alert(alert_arr.SELECT);
            return false;
        } 
		
		
		if(confirm(alert_arr.DELETE))
		{

			$("#status").prop("display","inline");
			new Ajax.Request(
          	  	      'index.php',
			      	{queue: {position: 'end', scope: 'command'},
		                        method: 'post',
                		        postBody:"module=Users&action=massdelete&return_module="+module+"&viewname="+viewid+"&idlist="+idstring,
		                        onComplete: function(response) {
        	        	                $("status").style.display="none";
                	        	        result = response.responseText.split('&#&#&#');  
                        	        	$("ListViewContents").innerHTML= result[2];
	                        	        if(result[1] != '')
                                        		alert(result[1]);
		                        }
              			 }
       			);
		}
		else
		{
			return false;
		}

}



function massExport(module)
{
		var select_options  =  document.getElementsByName('selected_id');
		var x = select_options.length;
		var viewid =getviewId();
		idstring = "";

        xx = 0;
        for(i = 0; i < x ; i++)
        {
        	if(select_options[i].checked)
            {
            	idstring = select_options[i].value +";"+idstring
                xx++
            }
        }
        if (xx != 0)
        {
            document.getElementById('idlist').value=idstring;
        }
        else
        {
            alert(alert_arr.SELECT);
            return false;
        }
		document.massdelete.module.value = module;
		document.massdelete.action.value = "massExport";
		document.massdelete.allids.value = idstring;
		document.massdelete.submit();



}

function showNewCustomView(selectView,module)
{
	$("#status").prop("display","inline");
	var oldSelectView = document.massdelete.viewname.value;
	switchClass("view_" + oldSelectView,"off");
	document.massdelete.viewname.value = selectView;
	switchClass("view_" + selectView,"on");
	showDefaultCustomView(selectView,module);
}

function showDefaultCustomView(selectView,module)
{

	//var viewName = selectView.options[selectView.options.selectedIndex].value;
	new Ajax.Request(
               	'index.php',
                {queue: {position: 'end', scope: 'command'},
                       	method: 'post',
                        postBody:"module="+module+"&action="+module+"Ajax&file=ListView&ajax=true&start=1&viewname="+selectView,
                        onComplete: function(response) {
                        $("status").style.display="none";
                        result = response.responseText.split('&#&#&#');
                        $("ListViewContents").innerHTML= result[2];
                        if(result[1] != '')
                               	alert(result[1]);
			$('basicsearchcolumns_real').innerHTML = $('basicsearchcolumns').innerHTML
			$('basicsearchcolumns').innerHTML = '';
			document.basicSearch.search_text.value = '';
                        }
                }
	);
}

function showDefaultViewScope(viewscope,module)
{
	$("#status").prop("display","inline");
	var viewscopeValue = viewscope.options[viewscope.options.selectedIndex].value;
	var viewName =$('viewname').value;
	new Ajax.Request(
               	'index.php',
                {queue: {position: 'end', scope: 'command'},
                       	method: 'post',
                        postBody:"module="+module+"&action="+module+"Ajax&file=ListView&ajax=true&start=1&viewname="+viewName+"&viewscope="+viewscopeValue,
                        onComplete: function(response) {
                        $("status").style.display="none";
                        result = response.responseText.split('&#&#&#');
                        $("ListViewContents").innerHTML= result[2];
                        result[2].evalScripts();
                        if(result[1] != '')
                               	alert(result[1]);
								//$('basicsearchcolumns_real').innerHTML = $('basicsearchcolumns').innerHTML
								//$('basicsearchcolumns').innerHTML = '';
								//document.basicSearch.search_text.value = '';
                        }
                }
	);
}


function showCalendarViewScope(viewscope,module)
{
	var viewscopeValue = viewscope.options[viewscope.options.selectedIndex].value;
	document.location.href = document.location.href + "&viewscope="+viewscopeValue;
}


function getListViewEntries_js(module,purl)
{	
	$("#status").prop("display","inline");
	if($('#search_url').val() !='')
                urlstring = $('#search_url').val() ;
	else
		urlstring = ''; 
	$.ajax({  
               type: "GET",  
               //dataType:"Text",   
               url:"index.php?module="+module+"&action="+module+"Ajax&file=ListView&ajax=true&"+purl+urlstring,  
               success: function(msg){   
               	 $("#ListViewContents").html(msg); 
               		$("#status").prop("display","none");
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

function openListViewReport(openurl,params)
{
    window.open(openurl+params,"test","width=800,height=600,resizable=1,scrollbars=1");

}

function getColumnCollectInf(module,url)
{
     new Ajax.Request(
        	'index.php',
                {queue: {position: 'end', scope: 'command'},
               method: 'post',
               postBody:"module=Home&action=HomeAjax&file=UpdateCollectTotalInf&ajax=true&relatedmodule="+module+"&"+url,
			  onComplete: function(response) {
                        	$("status").style.display="none";
                                result = response.responseText;
                                $("collectcolumntable").innerHTML= result;
                                result.evalScripts();
                  	}
                }
        );
}
// QuickEdit Feature
function quick_edit_old(obj,divid,module) {
	var select_options  =  document.getElementsByName('selected_id');
	var x = select_options.length;
	idstring = "";

	xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			idstring = select_options[i].value +";"+idstring
			xx++
		}
	}
	if (xx != 0)
	{
		document.getElementById('idlist').value=idstring;

		quick_edit_formload(idstring,module);
		fnvshobj(obj, divid);
	}
	else
	{
		alert(alert_arr.SELECT);
		return false;
	}

}
function quick_edit_formload_old(idstring,module) {
	$("#status").prop("display","inline");
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
	    	method: 'post',
			postBody:"module="+encodeURIComponent(module)+"&action="+encodeURIComponent(module+'Ajax')+"&file=QuickEdit&mode=ajax",
				onComplete: function(response) {
                	$("status").style.display="none";
               	    var result = response.responseText;
                    $("quickedit_form_div").innerHTML= result;
					//$("quickedit_form")["quickedit_recordids"].value = idstring;
					//$("quickedit_form")["quickedit_module"].value = module;
					document.quickedit_form.quickedit_recordids.value = idstring;
					document.quickedit_form.quickedit_module.value = module;
					var jscripts = $('quickedit_javascript');
					if(jscripts) {
						eval(jscripts.innerHTML);
						// Updating global variables
						/*
						fieldname = quick_fieldname;
						for(var i=0;i<fieldname.length;i++){
							//alert(fieldname[i]);
							var calendar_jscript_id = 'quickedit_calendar_'+fieldname[i];
							//calendar_jscript = document.getElementById(calendar_jscript_id);
							calendar_jscript = $(calendar_jscript_id);
							if(calendar_jscript){
								eval(calendar_jscript.innerHTML);
							}
						}
						*/
					}
				}
		}
	);
}
function quick_edit_fieldchange_old(selectBox) {
	var oldSelectedIndex = selectBox.oldSelectedIndex;
	var selectedIndex = selectBox.selectedIndex;

	if($('quickedit_field'+oldSelectedIndex)) $('quickedit_field'+oldSelectedIndex).style.display='none';
	if($('quickedit_field'+selectedIndex)) $('quickedit_field'+selectedIndex).style.display='block';

	var quickeditfield = document.quickedit_form.quickedit_field.value;
	var calendar_jscript_id = 'quickedit_calendar_' + quickeditfield;
	calendar_jscript = $(calendar_jscript_id);
	if(calendar_jscript){
		eval(calendar_jscript.innerHTML);
	}

	selectBox.oldSelectedIndex = selectedIndex;
}
function ajax_quick_edit_old() {
	$("status").style.display = "inline";

	//var quickeditform = $("quickedit_form");
	var module = document.quickedit_form.quickedit_module.value;
	var idstring = document.quickedit_form.quickedit_recordids.value;

	var viewid = getviewId();
	var searchurl = document.getElementById("search_url").value;
	//var tplstart = "&";
	//if (gstart != "") { tplstart = tplstart + gstart; }

	//var quickeditfield = quickeditform['quickedit_field'].value;
	//var quickeditvalue = quickeditform['quickedit_value_'+quickeditfield].value;

	var quickeditfield = document.quickedit_form.quickedit_field.value;
	var quickeditvalue = "";

	if($('quickedit_value_'+quickeditfield) != null && $('quickedit_value_'+quickeditfield) != "undefined" && $('quickedit_value_'+quickeditfield).name.toString().indexOf("[]") > -1) {
		var sel = document.quickedit_form.elements['quickedit_value_'+quickeditfield+'[]'];
		for(var i=0;i<sel.options.length;i++){
			if(sel.options[i].selected) {
				if(i == 0) {
					quickeditvalue = sel.options[i].value;
				} else {
					quickeditvalue = quickeditvalue + " |##| " + sel.options[i].value;
				}
			}
		}
	} else {
		quickeditvalue = document.quickedit_form.elements['quickedit_value_'+quickeditfield].value;
	}
	var jscripts = $('quickedit_javascript');
	//alert(quick_fieldname[0]);
	if(jscripts) {
		eval(jscripts.innerHTML);
	}
	if(!quickEditFormValidate(quickeditfield,quick_fieldname,quick_fieldlabel,quick_fielddatatype)) {
		$("status").style.display = "none";
		return false;
	}

	var urlstring =
		"module="+encodeURIComponent(module)+"&action="+encodeURIComponent(module+'Ajax')+
		"&return_module="+encodeURIComponent(module)+
		"&mode=ajax&file=QuickEditSave&viewname=" + viewid +
		"&quickedit_field=" + encodeURIComponent(quickeditfield) +
		"&quickedit_value=" + encodeURIComponent(quickeditvalue) +
	   	"&idlist=" + idstring + searchurl;

	fninvsh("quickedit");

	new Ajax.Request(
		"index.php",
		{queue:{position:"end", scope:"command"},
			method:"post",
			postBody:urlstring,
			onComplete:function (response) {
				$("status").style.display = "none";
				var result = response.responseText.split("&#&#&#");
				$("ListViewContents").innerHTML = result[2];
				if (result[1] != "") {
					alert(result[1]);
				}
				$("basicsearchcolumns").innerHTML = "";
			}
		}
	);
}

// END



function massDelete(module)
{       
		var viewid =getviewId();
		idstring = "";

		$("input[name=selected_id]").each(function(){ 
		   if($(this).prop("checked")==true){
		   	 idstring += $(this).prop("value")+";";
		   }
		})
		
		if (idstring  != '')
        {
            document.getElementById('idlist').value=idstring;
        }
        else
        {
            alert(alert_arr.SELECT);
            return false;
        } 
		
		if(confirm(alert_arr.DELETE))
		{

			$("#status").prop("display","inline");

			$.ajax({  
               type: "GET",  
               //dataType:"Text",   
               url:"index.php?module=Users&action=massdelete&return_module="+module+"&viewname="+viewid+"&idlist="+idstring, 
               success: function(msg){   
               	 $("#status").prop("display","none");
               	 $("#ListViewContents").html(msg); 
               }  
      		});   
		}
		else
		{
			return false;
		}
}

function quick_edit(obj,divid,module) {
	idstring = "";

	$("input[name=selected_id]").each(function(){ 
	   if($(this).prop("checked")==true){
	   	 idstring += $(this).prop("value")+";";
	   }
	})

	if (idstring  != '')
	{
		document.getElementById('idlist').value=idstring;

		quick_edit_formload(idstring,module);
		
		$('#quickedit_form_div').modal('show');
	}
	else
	{
		alert(alert_arr.SELECT);
		return false;
	} 
}

function quick_edit_formload(idstring,module) {
	$("#status").prop("display","inline");
	$.ajax({  
		   type: "GET",  
		   //dataType:"Text",   
		   url:"index.php?module="+encodeURIComponent(module)+"&action="+encodeURIComponent(module+'Ajax')+"&file=QuickEdit&mode=ajax",
		   success: function(msg){   
		   	 $("#status").prop("display","none");
		   	 $("#quickedit_form_div").html(msg); 
		   	 $("input[name=quickedit_recordids]").val(idstring);
		   	 $("input[name=quickedit_module]").val(module);
		   }  
	});   
}
function quick_edit_fieldchange(selectBox) {
	var oldSelectedIndex = selectBox.oldSelectedIndex;
	var selectedIndex = selectBox.selectedIndex;

	if($('#quickedit_field'+oldSelectedIndex)) $('#quickedit_field'+oldSelectedIndex).css('display','none');
	if($('#quickedit_field'+selectedIndex)) $('#quickedit_field'+selectedIndex).css('display','block');

	selectBox.oldSelectedIndex = selectedIndex;
}

function ajax_quick_edit() {

	$("#status").css('display','inline');

	var module = $("input[name=quickedit_module]").val();
	var idstring = $("input[name=quickedit_recordids]").val();

	var viewid = getviewId();
	var searchurl = $('#search_url').val();
	
	var quickeditfield = $("select[name=quickedit_field]").val();
	var quickeditvalue = "";

	quickeditvalue = $('#quickedit_value_'+quickeditfield).val(); 
	
	if(!quickEditFormValidate(quickeditfield,quick_fieldname,quick_fieldlabel,quick_fielddatatype)) {
		$("#status").css('display','none');
		return false;
	}

	var urlstring ="index.php?"+
		"module="+encodeURIComponent(module)+"&action="+encodeURIComponent(module+'Ajax')+
		"&return_module="+encodeURIComponent(module)+
		"&mode=ajax&file=QuickEditSave&viewname=" + viewid +
		"&quickedit_field=" + encodeURIComponent(quickeditfield) +
		"&quickedit_value=" + encodeURIComponent(quickeditvalue) +
	   	"&idlist=" + idstring + searchurl;

	//fninvsh("quickedit");
	$('#quickedit_form_div').modal('hide');
	
	$.ajax({  
		   type: "GET",  
		   //dataType:"Text",   
		   url:urlstring,
		   success: function(msg){   
		   	 $("#status").css("display","none");
		   	 $("#ListViewContents").html(msg); 
		   }  
	});
}


function clearSearchResult(module,searchtype){
    $("#status").css('display','inline');

	if(searchtype =='advSearch'){
		$('#gaojisearch').modal('hide');
	}
	if(searchtype =='BasicSearch'){
		$("input[name=search_text]").val('');
		$("select[name=search_field]").val('');
	}
	$.ajax({  
		   type: "GET",  
		   //dataType:"Text",   
		   url:'index.php?module='+module+'&action='+module+'Ajax&ajax=true&file=index&clearquery=true',
		   success: function(msg){   
		   	 $("#status").css("display","none");
		   	 $("#ListViewContents").html(msg); 
		   }  
	});
}


function setLeftAssort(module){
	$.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:'index.php?module=Home&action=HomeAjax&file=sortviewBindAjax&sortview=view_assort&modname='+module,
       success: function(rest){ 
          if(rest == "error"){
            right_column_assort_d = "none";         
          }else{
            var treedivobj = "right_column_assort";
            var treeproj = eval('('+ rest +')')?eval('('+ rest +')'):JSON.parse(rest);
            right_column_assort_d = new dTree('right_column_assort_d');       
            var urlstring = '';var url='';
            for(var i=0;i<treeproj.length;i++){
               right_column_assort_d.add(treeproj[i].treeid,treeproj[i].treeparent,treeproj[i].treename,
                  "javascript:sortviewtree_click('"+module+"','"+treeproj[i].click+"');",
                    treeproj[i].treename,"_self");  
            }
          }
          document.getElementById(treedivobj).innerHTML = right_column_assort_d;
       }  
    });
}
function setLeftArea(module){
	$.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:'index.php?module=Home&action=HomeAjax&file=sortviewBindAjax&sortview=view_area&modname='+module,
       success: function(rest){ 
          if(rest == "error"){
            right_column_area_d = "none";         
          }else{
            var treedivobj = "right_column_area";
            var treeproj = eval('('+ rest +')')?eval('('+ rest +')'):JSON.parse(rest);
            right_column_area_d = new dTree('right_column_area_d');       
            var urlstring = '';var url='';
            for(var i=0;i<treeproj.length;i++){
               right_column_area_d.add(treeproj[i].treeid,treeproj[i].treeparent,treeproj[i].treename,
                  "javascript:sortviewtree_click('"+module+"','"+treeproj[i].click+"');",
                    treeproj[i].treename,"_self");  
            }
   // 			for(var i=0;i<treeproj.length;i++){
			// 		var currObj = "user_"+treeproj[i].treeid;
			// 		var treeid = treeproj[i].treeid;
			// 		var parenttreeproj = treeproj[i].treeparent;		
					
			// 			right_column_area_d.add(treeproj[i].treeid,treeproj[i].treeparent,treeproj[i].treename,
			// 				"javascript:sortviewtree_click('"+module+"','"+treeproj[i].click+"');",
			// 					treeproj[i].treename,"_self");
			// }
          }
          document.getElementById(treedivobj).innerHTML = right_column_area_d;
       }  
    });
}



function sortviewtree_click(module,urlstring){
  if(urlstring != ''){
    urlstring += '&searchtype=BasicSearch&type=others&';
    var findurlstr = $("#search_url").val();
    urlstring = findurlstr + '&' + urlstring ;
    $("#status").css('display','inline');
    $.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:'index.php?module='+module+'&action='+module+'Ajax&ajax=true&+'+urlstring+'query=true&file=Popup',
       success: function(msg){   
         $("#status").css('display','none');
         $("#ListViewContents").html(msg);
       }
     });
  }
}