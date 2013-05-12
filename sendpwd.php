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
<script language="javascript" type="text/javascript" src="include/scriptaculous/prototypeall.js"></script>

<script language="javascript">
function check() {
	if (document.loginform.user_email.value == '') {
		alert('Email不能为空');
		document.loginform.user_email.focus();
		return false;
	}
	if (loginform.user_email.value != "" && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(loginform.user_email.value)) {
		alert("Email无效");
		loginform.user_email.focus();
		return ;
	} else {
		check_duplicate();
	}

}
function logining_load(){
	document.loginform.user_email.focus();
}
function check_duplicate()
{
	var user_email = document.loginform.user_email.value;
	
	new Ajax.Request(
                'DoSendPwd.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'user_email='+user_email,
                        onComplete: function(response) {
							var result = response.responseText;
							alert(result);
                        }
                }
        );

}
</script>

</HEAD>
<BODY onLoad="logining_load()">
<DIV id=main>
<DIV id=msgbox>

</DIV>
<DIV id=loginbox align="center">
<form action="DoRegister.php" method="post" name="loginform" id="loginform">
<TABLE cellSpacing=0 cellPadding=0 width=720 border=0>
<INPUT 	type=hidden name=returnURL> 
  <TBODY>
  <TR><td colspan="4"><a href="http://www.c3crm.com" border="0" target="_blank"><img src="include/images/logo.gif" border="0"></a><br><br><br></td></TR>
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
              color=#00458a>找回密码</FONT></TD></TR>
			  <TR height="40">
                <TD class=word><FONT color=#000000>Email</FONT></TD>
                <TD><INPUT style="width:270px;" value="" name="user_email"  ></TD>
			  </TR>
			 
			  <TR>
                <TD>&nbsp;</TD>
                <TD><INPUT type=button value="  发送  " name=button onClick="return check()" tilte="易客CRM用户"> 
				[<A href="Login.php">登陆</A> ]
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
        </TBODY></TABLE></TD>
    <TD width=30><IMG height=258 src="include/images/login_img02.gif" 
  width=30></TD></TR> </TABLE></FORM></DIV>
</BODY></HTML>
