 <script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>

<script  language="JavaScript" type="text/javascript" src="include/kindeditor/kindeditor.js"></script>
<script>
{literal}	
		KE.show({
			id : 'mailcontent',
			imageUploadJson : 'include/kindeditor/php/upload_json.php',
			fileManagerJson : 'include/kindeditor/php/file_manager_json.php',
			allowFileManager : true,
			afterCreate : function(id) {
				KE.util.focus(id);
			}
		});
{/literal}	
</script>

 <div class="container-fluid" style="height:606px;"> 
      <div class="row-fluid">
        <div class="span12" style="margin-left:0px;">
           
            <div id="tablink">
              <ul class="nav nav-pills" style="margin-bottom:5px;">
                <li class="nav-header" style="padding-left:0px;padding-right:5px;">
                  <i class="icon-th-list"></i> 
                </li>

                 {foreach name="listviewforeach" key=id item=viewname from=$CUSTOMVIEW_OPTION}
                  {if $id eq $VIEWID} 
                    <li class="active"><a href="javascript:;" onclick="javascript:getTableViewForFenzu('{$MODULE}','viewname={$id}',this,{$id});" >{$viewname}</a></li>
                  {else}
                    <li ><a href="javascript:;" onclick="javascript:getTableViewForFenzu('{$MODULE}','viewname={$id}',this,{$id});">{$viewname}</a></li>
                  {/if}
                 {/foreach}
				 {if $ISADMIN === true}
                <li>
                  <a href="index.php?module={$MODULE}&action=Fenzu&parenttab={$CATEGORY}" style="padding:2px;">
                    <i class="cus-add"></i></a>
                </li> 
                <li>
                   <a href="javascript:editFenzu('{$MODULE}','{$CATEGORY}')" style="padding:2px;"><i class="cus-pencil"></i></a>
                </li>
                <li> 
                  <a href="javascript:deleteFenzu('{$MODULE}','{$CATEGORY}')" style="padding:2px;"><i class="cus-cancel"></i></a>
                </li>
				{/if}
              </ul>
          </div>

           <div id="ListViewContents" class="small" style="width:100%;position:relative;">
            {include file="$MODULE/ListViewEntries.tpl"}
          </div>

        </div>
      </div>

    </div>

<div id="selecttmpdiv" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;"></div>
<div id="createtmpdiv" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;"></div>


<script language="javascript" type="text/javascript">
{literal}

function uploadAttInfo(sjid){  
	
	$("#status").prop("display","inline");
	alert("添加成功");
	$.ajax({  
		   type: "GET",  
		   //dataType:"Text",   
		   url:"index.php?module=Maillists&action=MaillistsAjax&file=updateMaillistAtt&sjid="+sjid,
		   success: function(msg){   
		   	 $("#status").prop("display","none");
		   	 $("#maillistattinfo").html(msg); 
		   }  
	});   

}
function DeleteMaillistAtt(sjid,attachmentsid){

	$("#status").prop("display","inline");
	alert("删除成功");
	$.ajax({  
		   type: "GET",  
		   //dataType:"Text",   
		   url:"index.php?module=Maillists&action=MaillistsAjax&file=deleteMaillistAtt&sjid="+sjid+"&attachmentsid="+attachmentsid,
		   success: function(msg){   
		   	 $("#status").prop("display","none");
		   	 $("#maillistattinfo").html(msg); 
		   }  
	});   
}
function SelectTmp(){
	var url = 'index.php?module=Maillisttmps&action=MaillisttmpsAjax&file=lookupemailtemplates';
  $("#status").prop("display","inline");
  $.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:url,
       success: function(msg){   
         $("#status").prop("display","none");
         $("#selecttmpdiv").html(msg); 
       }  
  }); 
  $('#selecttmpdiv').modal('show');
}

function CreateTmp(){
	var url = 'index.php?module=Maillists&action=MaillistsAjax&file=CreateTmps';
  $("#status").prop("display","inline");
  $.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:url,
       success: function(msg){   
         $("#status").prop("display","none");
         $("#createtmpdiv").html(msg); 
       }  
  }); 
  $('#createtmpdiv').modal('show');
}

{/literal}
</script>