<?php
//get php configuration settings.  requires elaborate parsing of phpinfo() output
ob_start();
phpinfo(INFO_GENERAL);
$string = ob_get_contents();
ob_end_clean();

$pieces = explode("<h2", $string);
$settings = array();
foreach($pieces as $val)
{
   preg_match("/<a name=\"module_([^<>]*)\">/", $val, $sub_key);
   preg_match_all("/<tr[^>]*>
									   <td[^>]*>(.*)<\/td>
									   <td[^>]*>(.*)<\/td>/Ux", $val, $sub);
   preg_match_all("/<tr[^>]*>
									   <td[^>]*>(.*)<\/td>
									   <td[^>]*>(.*)<\/td>
									   <td[^>]*>(.*)<\/td>/Ux", $val, $sub_ext);
   foreach($sub[0] as $key => $val) {
		if (preg_match("/Configuration File \(php.ini\) Path /", $val)) {
	   		$val = preg_replace("/Configuration File \(php.ini\) Path /", '', $val);
			$phpini = strip_tags($val);
	   	}
   }

}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>易客CRM - 安装向导 - 欢迎使用易客CRM</title>
	<link href="include/install/install.css" rel="stylesheet" type="text/css">
</head>

<body class="small cwPageBg" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

	<br><br><br>
	<!-- Table for cfgwiz starts -->

	<table border=0 cellspacing=0 cellpadding=0 width=80% align=center>
	<tr>
		<td class="cwHeadBg" align=left><img src="include/install/images/configwizard.gif" alt="Configuration Wizard" hspace="20" title="Configuration Wizard"></td>
		<td class="cwHeadBg" align=right><img src="include/install/images/vtigercrm5.gif" alt="易客CRM" title="易客CRM"></td>
	</tr>
	</table>
	<table border=0 cellspacing=0 cellpadding=0 width=80% align=center>
	<tr>
		<td background="include/install/images/topInnerShadow.gif" align=left><img src="include/install/images/topInnerShadow.gif" ></td>

	</tr>
	</table>
	<table border=0 cellspacing=0 cellpadding=10 width=80% align=center>
	<tr>
		<td class="small" bgcolor="#4572BE" align=center>
			<!-- Master display -->
			<table border=0 cellspacing=0 cellpadding=0 width=97%>
			<tr>
				<td width=20% valign=top>

				<!-- Left side tabs -->
					<table border=0 cellspacing=0 cellpadding=10 width=100%>
					<tr><td class="small cwSelectedTab" align=right><div align="left"><b>欢迎使用易客CRM</b></div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">安装检查</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">系统配置</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">确认配置</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">创建配置文件</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">创建数据库</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">完成</div></td></tr>
					</table>
					
				</td>
				<td width=80% valign=top class="cwContentDisplay" align=left>
				<!-- Right side tabs -->
					<table border=0 cellspacing=0 cellpadding=10 width=100%>
					<tr><td class=small align=left><img src="include/install/images/welcome.gif" alt="Welcome to Configuration Wizard" title="Welcome to Configuration Wizard"><br>
					  <hr noshade size=1></td></tr>

					<tr>
						<td align=left class="small" style="padding-left:20px">
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;安装向导将创建易客CRM运行所需要的数据库和表文件。整个过程需要4分钟。点击开始按钮开始安装。
<br><br>
<p><span style="color:#555555">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;易客CRM支持Mysql5.x,PHP5.2.x，Apache1.3，不支持Mysql4.0.x，也可以运行在Easyphp,xampp/lamp,wamp等PHP集成平台上。</p> 
</center>
</span>
						
					  </td>
					</tr>
					
					
					<tr>
						<td align="center">
							请阅读 <a href="Copyright.txt" target="_BLANK">协议</a>，然后点击安装按钮开始安装。 
						</td>
					</tr>		
					<tr>
						<td align=center>
						<form action="install.php" method="post" name="installform" id="form">
				                <input type="hidden" name="file" value="1checkSystem.php" />	
						<input type="image" src="include/install/images/start.jpg" alt="Start" border="0" title="Start" style="cursor:pointer;" onClick="window.document.installform.submit();">
						</form><br>
					    <br></td>
					</tr>
					
					
				</table>
			</td>
		</tr>
	</table>
	<!-- Master display stops -->
	<br>
	</td>
	</tr>
	</table>
	<table border=0 cellspacing=0 cellpadding=0 width=80% align=center>
	<tr>

		<td background="include/install/images/bottomGradient.gif"><img src="include/install/images/bottomGradient.gif"></td>
	</tr>
	</table>
	<table border=0 cellspacing=0 cellpadding=0 width=80% align=center>
	<tr>
		<td align=center><img src="include/install/images/bottomShadow.jpg"></td>
	</tr>
	</table>
</body>
</html>
