<?php
$theme_path="themes/softed/";
$image_path="include/images/";
$default_language = "zh_cn";
$default_theme = "softed";
$default_user_name = "";
$default_password = "";
$default_company_name = "";

?>
<!DOCTYPE html>
<!-- saved from url=(0050)http://wbpreview.com/previews/WB00U8L84/login.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Dashboard - Bootstrap Admin</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
	<!-- CSS -->
    <link href="themes/bootcss/css/bootstrap.css" rel="stylesheet">
    <link href="themes/bootcss/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="themes/bootcss/css/style.css" rel="stylesheet">
    <link href="themes/bootcss/css/cus-icons.css" rel="stylesheet">

	<link href="themes/bootcss/css/Login.css" rel="stylesheet">
  </head>
<script language="javascript">
function check() {
	if (document.loginform.user_name.value == '') {
		alert('Email不能为空');
		document.loginform.user_name.focus();
		return false;
	}
	if (loginform.user_name.value != "" && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(loginform.user_name.value)) {
		alert("Email无效");
		loginform.user_name.focus();
		return ;
	} else {
		check_duplicate();
	}

}
function logining_load(){
	document.loginform.user_name.focus();
}
function check_duplicate()
{
	var user_name = document.loginform.user_name.value;
	
	new Ajax.Request(
                'DoSendPwd.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'user_name='+user_name,
                        onComplete: function(response) {
							var result = response.responseText;
							alert(result);
                        }
                }
        );

}
</script>
<body onLoad="logining_load()">

<div class="navbar navbar-fixed-top">	
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 
				<span class="icon-bar"></span> 				
			</a>
			<a class="" href="http://www.c3crm.com/" target="_blank"><img src="themes/bootcss/img/logonew.png"></a>
			<ul class="nav pull-right">
				<li class="" style="line-height: 30px;">
					<a href="http://www.c3crm.com/" target="_blank">客户关系管理系统</a>
				</li>
			</ul>
		</div> <!-- /container -->
	</div> <!-- /navbar-inner -->
</div> <!-- /navbar -->


<div id="login-container">
	<div id="login-header">
		<h3 style="line-height: 15px;">找回密码</h3>
	</div> <!-- /login-header -->
	<div id="login-content" class="clearfix">
	
	<form action="DoRegister.php" method="post" name="loginform" id="loginform">
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="user_name">Email</label>
						<div class="controls">
							<input type="text" class="" id="user_name" name="user_name" value="<?php echo $login_user_name ?>">
						</div>
					</div>
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
				</fieldset>
				
				<div id="remember-me" class="pull-left"><br><br>
					<A href="register.php">&nbsp;注册</A>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A href="Login.php">登录&nbsp;</A>
				</div>
				
				<div class="pull-right">
					<button type="submit" class="btn btn-warning btn-large" onClick="return check()">
						发送
					</button>
				</div>
			</form>
			
		</div> <!-- /login-content -->
		
		<div id="login-extra">
			<p>
				<a href="training/sales01.html" target="_blank">培训视频</a>&nbsp;&nbsp;
				<a href="training/sfa.doc" target="_blank">SFA使用说明</a>&nbsp;&nbsp;
				<a href="mobile/index.html" target="_blank">手机登录</a>&nbsp;&nbsp;
				<a href="http://vdisk.weibo.com/s/5SBnr/1337924467" target="_blank">手机客户端下载</a>
			</p>
			<!--
			<p>
				或使用合作伙伴的账号登录，还在测试中，请不要点击<br>
				<a href="<?=$code_url?>"><img src="themes/images/weibo_login.png" title="测试中" alt="测试中" border="0"></a>
			</p>
			-->
			<p>我能用它做什么？让系统自动的帮您跟踪客户，真正的实现销售自动化(SFA)，</p>
			<p>让您感觉销售是件非常Easy的事情！还不心动吗，赶紧试试吧！</p>
			<p>E-mail: <a href="javascript:;">sales@c3crm.cn</a></p>
		</div> <!-- /login-extra -->
	
</div> <!-- /login-wrapper -->