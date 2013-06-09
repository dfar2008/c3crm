function callSearch(searchtype)
{ alert("33");
        for(i=1;i<=26;i++)
        {
            var data_td_id = 'alpha_'+ eval(i);
            getObj(data_td_id).className = 'searchAlph';
        }
        gPopupAlphaSearchUrl = '';
        search_fld_val= $('select[name=search_field]').val();
        search_txt_val= $('input[name=search_text]').val();
        var urlstring = 'index.php?';
        if(searchtype == 'Basic')
        {
              urlstring += 'search_field='+search_fld_val+'&searchtype=BasicSearch&search_text='+search_txt_val+'&';
        }
        popuptype = $('#popup_type').val();
        urlstring += '&popuptype='+popuptype;
        urlstring = urlstring +'&query=true&file=Popup&module={$MODULE}&action={$MODULE}Ajax&ajax=true';
        urlstring +=gethiddenelements();
        alert(urlstring);
        $.ajax({  
             type: "GET",  
             //dataType:"Text",   
             url:urlstring,
             success: function(msg){   
               $("#ListViewContents").html(msg); 
             }  
        });

}
function alphabetic(module,url,dataid)
{ 
        for(i=1;i<=26;i++)
        {
            var data_td_id = 'alpha_'+ eval(i);
            getObj(data_td_id).className = 'searchAlph';
        }
        getObj(dataid)className = 'searchAlphselected';
        gPopupAlphaSearchUrl = '&'+url; 
        var urlstring ="module="+module+"&action="+module+"Ajax&file=Popup&ajax=true&"+url;
        urlstring +=gethiddenelements();
        $.ajax({  
           type: "GET",  
           url:urlstring,
           success: function(msg){   
             $("#ListViewContents").html(msg); 
           }  
        });
}
function gethiddenelements()
{
  var urlstring='';alert(getObj('select_enable').value);
  if(getObj('select_enable').value != '')
    urlstring +='&select=enable'; 
  if(document.getElementById('curr_row').value != '')
    urlstring +='&curr_row='+document.getElementById('curr_row').value; 
  if(getObj('fldname_pb').value != '')
    urlstring +='&fldname='+getObj('fldname_pb').value; 
  if(getObj('productid_pb').value != '')
    urlstring +='&productid='+getObj('productid_pb').value; 
  if(getObj('recordid').value != '')
    urlstring +='&recordid='+getObj('recordid').value;  
  var return_module = document.getElementById('return_module').value;
  if(return_module != '')
    urlstring += '&return_module='+return_module;
  return urlstring;
}

function add_data_to_relatedlist(entity_id,recordid,mod) {
        opener.document.location.href="index.php?module={$RETURN_MODULE}&action=updateRelations&destination_module="+mod+"&entityid="+entity_id+"&parid="+recordid+"&return_action={$RETURN_ACTION}";
}