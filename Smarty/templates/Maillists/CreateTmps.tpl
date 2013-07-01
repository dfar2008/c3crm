
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3>新增 邮件模板</h3>
</div>
<div class="modal-body">

<form name="EditView" method="POST" action="" >
		<input type="hidden" name="module" value="Maillists">
		<input type="hidden" name="record" value="">
		<input type="hidden" name="mode" value="save">
		<input type="hidden" name="action" value="CreateTmps">
   
<table class="table table-bordered table-hover table-condensed table-striped">
   <tr height="25">
   		<td align="center" class="dvt">模板名称</td>
   		<td >
        <input id="maillisttmpname" type="text" value="" tabindex="1" name="maillisttmpname"></td>
   </tr>
   <tr>
   		<td align="center" class="dvt">内容</td>
   		<td>
       <textarea style="height:200px;width:615px;" name="description" tabindex="3"></textarea>
        </td>
   </tr>
   <tr>
    <td align="center" class="dvt">&nbsp;备注</td>
    <td width="18%"> 可用变量<b> $name$ </b>替换群发中的<b>联系人名称</b>.</td>
   </tr>
  
</table>

</form>
</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    <button class="btn btn-primary" type="button" onclick="checkIsEmpty();" >保存并选择</button>
</div>
<script>
{literal}
function checkIsEmpty(){ 
	if(document.EditView.maillisttmpname.value ==''){
		alert("邮件模板名称不能为空!");
		document.EditView.maillisttmpname.focus();
		return false;
	}
	if(document.EditView.description.value ==''){
		alert("邮件模板内容不能为空!");
		document.EditView.description.focus();
		return false;
	}
	SaveTmp();
}
function SaveTmp(){
  var searchobj={}
  searchobj['search']='true'; 
  searchobj['record']= $("input[name=record]").val();
  searchobj['mode']= $("input[name=mode]").val();
  searchobj['maillisttmpname']= $("input[name=maillisttmpname]").val();
  searchobj['description']= $("textarea[name=description]").val();
  var findstr=$.param(searchobj);  

  subject = searchobj['maillisttmpname'];
  repstr = searchobj['description'];

  $("#status").prop("display","inline");
  $.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:"index.php?module=Maillists&action=CreateTmps&"+findstr,
       success: function(msg){   
           $("#status").prop("display","none");

           $("#subject").val(subject);
            if(KE != undefined) {
              KE.html("mailcontent",repstr);
            } else {
              $('#mailcontent').val(repstr);
            }

           $('#createtmpdiv').modal('hide');
       }  
  }); 
}
{/literal} 
</script>

