<style type="text/css">@import url("themes/softed/style.css");</style>
<html>
<head>
<title>新增 短信模板</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0 class=small >
<form name="EditView" method="POST" action="" onSubmit="return checkIsEmpty();">
		<input type="hidden" name="module" value="Qunfas">
		<input type="hidden" name="record" value="">
		<input type="hidden" name="mode" value="save">
		<input type="hidden" name="action" value="CreateTmps">
<table border=0 cellspacing=0 cellpadding=0 width=100%  >
<tr style="background:#DFEBEF;height:27px;">
<td style="padding-left:10px;"><b>新增 短信模板</b></td>
</tr>

<tr>     
<td>   
<table border=0 cellspacing=0 cellpadding=0 width=100% align=left class="small">
   <tr height="25">
   		<td align="center" width="10%"  class="dvtCellLabel">模板名称</td>
   		<td width="90%"><input id="qunfatmpname" class="detailedViewTextBox" type="text" onBlur="this.className='detailedViewTextBox'" onFocus="this.className='detailedViewTextBoxOn'" value="" tabindex="1" name="qunfatmpname"></td>
   </tr>
   <tr>
   		<td align="center" width="20%"   class="dvtCellLabel">内容</td>
   		<td>
       <textarea class="detailedViewTextBox" style="height:200px;" cols="80" onBlur="this.className='detailedViewTextBox'" name="description" onFocus="this.className='detailedViewTextBoxOn'" tabindex="3"></textarea>
        </td>
   </tr>
   <tr>
    <td width="15%">&nbsp;</td><td width="18%">备注: 可用变量<b> $name$ </b>替换群发中的<b>联系人名称</b>.</td>									
   </tr>
   <tr>
    <td  colspan=2 style="padding:5px">
       <div align="center">
          <input title="保存 [Alt+S]" accessKey="S" class="crmbutton small save" type="submit" name="button" value="  保存  " style="width:70px" >

		 <input title="取消 [Alt+X]" accessKey="X" class="crmbutton small cancel" onClick="window.close()" type="button" name="button" value="  取消  " style="width:70px">
       </div>
    </td>
   </tr>
</table>
</td>
</tr>
</table>
</form>
</body>
</html>
<script>
{literal}
function checkIsEmpty(){ 
	if(document.EditView.qunfatmpname.value ==''){
		alert("短信模板名称不能为空!");
		document.EditView.qunfatmpname.focus();
		return false;
	}
	if(document.EditView.description.value ==''){
		alert("短信模板内容不能为空!");
		document.EditView.description.focus();
		return false;
	}
	return true;
}

{/literal} 
</script>

