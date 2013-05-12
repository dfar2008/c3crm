<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>上传邮件附件...</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">@import url("themes/softed/style.css");</style>
</head>


<script language=javascript>
var sjid='{$sjid}';
{literal}
function CloseWin()
{
	window.close();
}

function Uploading()
{	
	if(document.form1.userfile1.value ==''){
		alert("请先选择文件!");
		return false;
	}
	document.form1.submit();
	window.opener.uploadAttInfo(sjid);
	CloseWin();
}
{/literal}
</script>

<body leftmargin=0 topmargin=4 marginwidth=0 marginheight=0>
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td align="center">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			<form name=form1 enctype="multipart/form-data" action="index.php" method=POST>
			<input type="hidden" name="module" value="Maillists">
			<input type="hidden" name="action" value="uploadfileInfo">
             <input type="hidden" value="{$sjid}" name="sjid" id="sjid" />
				<tr height="20" >
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr height="25" align="center">
					<td class="dvtCellLabel"  width=25% align="right">请选择附件:</td>
					<td >&nbsp;<input type=file name=userfile1 class=detailedViewTextBox size=30></td>
				</tr>
				
				<tr height="30">
					<td class="tb_btn" align=center colspan=2>
						<input type=button value=" 上传 " name=upbtn class="crmbutton small save" onClick="javascript:Uploading();">
						<input type=button value=" 关闭 " name=close class="crmbutton small cancel" onClick="javascript:CloseWin();">
					</td>
				</tr>
			</form>
		</table>
		
	</td>
  </tr>
</table>

</body>
</html>
