<?php
$theme_path="themes/softed/";
$image_path="include/images/";
$default_language = "zh_cn";
$default_theme = "softed";
$default_user_name = "admin";
$default_password = "admin";
$default_company_name = "";
?> 
<HTML><HEAD><TITLE>易客CRM-客户关系管理系统</TITLE>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">
<META content="客户关系管理系统" name=title>
<META content="基于电子商务的客户管理系统" name=description>
<META content="客户关系管理系统" name=keywords>
<STYLE type=text/css>
.word_10p {
	FONT-WEIGHT: bold; FONT-SIZE: 10pt; COLOR: #000000; FONT-FAMILY: "Verdana", "Arial", "Helvetica", "sans-serif"
}
.font_9p {
	FONT-SIZE: 9pt; COLOR: #000000; LINE-HEIGHT: 18px; FONT-FAMILY: "Verdana", "Arial", "Helvetica", "sans-serif"
}
.title {
	FONT-WEIGHT: bold; FONT-SIZE: 9pt; COLOR: #000000; LINE-HEIGHT: 20px; FONT-FAMILY: "Verdana", "Arial", "Helvetica", "sans-serif"
}
.inputbg1 {
 background-image:url(include/images/inputbg1.gif);
 background-position:bottom;
 background-repeat:no-repeat;
 }
.inputbg2 {
 background-image:url(include/images/inputbg2.gif);
 background-position:bottom;
 background-repeat:no-repeat;
 }
.inputbg3 {
 background-image:url(include/images/inputbg3.gif);
 background-position:bottom;
 background-repeat:no-repeat;
 }
.inputbg {
 background-image:url(include/images/inputbg.gif);
 background-position:bottom;
 background-repeat:no-repeat;
 }
</STYLE>
<script language="javascript">
function check() {
	if (document.loginform.user_name.value == '') {
		alert('用户名不能为空');
		document.loginform.user_name.focus();
		return false;
	}
	if (document.loginform.user_password.value == '') {
		alert('密码不能为空');
		document.loginform.user_password.focus();
		return false;
	}
	return true;
}
function logining_load(){
	document.loginform.user_name.focus();
}
</script>
</HEAD>
<BODY onLoad="logining_load()">
<DIV id=main>
<DIV id=msgbox>

</DIV>
<DIV id=loginbox align="center">
<form action="Authenticate.php" method="post" name="loginform" id="loginform">
<TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
<INPUT 	type=hidden name=returnURL> 
  <TBODY>
  <TR ><td colspan="4"><a href="http://www.c3crm.com" border="0" target="_blank"><img src="include/images/logo.gif" border="0"></a><br><br><br></td></TR>
  <TR>
    <TD width=30><IMG height=258 src="include/images/login_img01.gif" 
width=30></TD>
    <TD width=364 background="include/images/login_bg01.gif">
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
         
        <TR>
          <TD vAlign=top width=330>
            <TABLE class=font_9p cellSpacing=2 cellPadding=2 width=350 
            align=center border=0>
              <TBODY>              
              <TR vAlign=top>
                <TD class=title height=25>&nbsp;</TD>
                <TD class=word_10p height=25><FONT 
              color=#00458a>用户登录</FONT></TD></TR>
			  <TR>
                <TD class=word><FONT color=#000000>用户名</FONT></TD>
                <TD><INPUT style="width:270px;" value="<?php echo $default_user_name ?>" name="user_name"  ></TD>
			  </TR>
              <TR>
                <TD class=word><FONT color=#000000>密&nbsp;&nbsp;&nbsp;码</FONT></TD>
                <TD><INPUT type=password style="width:270px;" name="user_password" value="<?php echo $default_password ?>" ></TD>
			  </TR>
			  <input type="hidden" name="login_theme" value="softed">
			  <input type="hidden" name="login_language" value="zh_cn">
						 
			  <?php
				if( isset($_SESSION['validation'])){
				?>
				<tr>
					<td colspan="2"><font color="Red"> 出错 </font></td>
				</tr>
				<?php
				}
				else if(isset($_REQUEST["login_error"]) && $_REQUEST["login_error"] != "")
				{
				?>
				<tr>
					<td colspan="2"><b class="small"><font color="Brown">
					<?php echo $_REQUEST["login_error"] ?>
					</font>
					</b>
					</td>
				</tr>
				<?php
				}
			  ?>
              <TR>
                <TD>&nbsp;</TD>
                <TD><INPUT type=submit value="  登 录  " name=Submit onClick="return check()" tilte="登录至您的易客CRM系统"> 
                  <A href="sendpwd.php">忘记密码</A>
                </TD></TR>
			 
				
				
				</TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
    <TD vAlign=top background="include/images/login_bg02.gif">
      <P><BR><BR></P> 
      <TABLE class=font_9p cellSpacing=2 cellPadding=2 width=240 align=right 
      border=0>
        <TBODY>
        <TR vAlign=top>
          <TD class=word_10p height=20><FONT color=#ffffff>易客CRM，</FONT></TD></TR>
        <TR>
          <TD class=word_10p height=20><FONT 
        color=#ffffff>为您提供简单、易用的客户关系管理系统，让您更专注于您的专业领域！</FONT></TD></TR>
        <TR>
          <TD>&nbsp;</TD></TR>
        <TR vAlign=top>
          <TD   height=18><FONT color=#ffffff>E-mail: sales@c3crm.cn</FONT></TD></TR>   
	    <TR vAlign=top>
          <TD   height=18><FONT color=#ffffff>联系电话: 400 680 5898</FONT></TD></TR>         
        </TBODY></TABLE></TD>
    <TD width=30><IMG height=258 src="include/images/login_img02.gif" 
  width=30></TD></TR> </TABLE></FORM></DIV>
</BODY></HTML>
