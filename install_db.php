<?php
set_time_limit(600);

if (isset($_REQUEST['db_name'])) $db_name  				= $_REQUEST['db_name'];
if (isset($_REQUEST['db_drop_tables'])) $db_drop_tables 	= $_REQUEST['db_drop_tables'];
if (isset($_REQUEST['db_create'])) $db_create 			= $_REQUEST['db_create'];
if (isset($_REQUEST['db_populate'])) $db_populate		= $_REQUEST['db_populate'];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>易客CRM - 安装向导 - 完成</title>


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
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">欢迎使用易客CRM</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">安装检查</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">系统配置</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">确认配置</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">创建配置文件</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">创建数据库</div></td></tr>
					<tr><td class="small cwSelectedTab" align=right><div align="left"><b>完成</b></div></td></tr>
					</table>
					
				</td>
				<td width=80% valign=top class="cwContentDisplay" align=left>
				<!-- Right side tabs -->
					<table border=0 cellspacing=0 cellpadding=10 width=100%>
					<tr><td class=small align=left><img src="include/install/images/confWizFinish.gif" alt="安装完成" title="安装完成"><br>
					  <hr noshade size=1></td></tr>

					<tr>
					<td align=center class="small" style="height:250px;"> 

<?php

require('include/init.php');
global $adb;
$filepath = 'storage/c3crm.sql';
$init = sql_import($filepath);


//populating forums data

//this is to rename the installation file and folder so that no one destroys the setup
$renamefile = uniqid(rand(), true);

//@rename("install.php", $renamefile."install.php.txt");
if(!rename("install.php", $renamefile."install.php.txt"))
{
	if (copy ("install.php", $renamefile."install.php.txt"))
       	{
        	 unlink($renamefile."install.php.txt");
     	}
}

//@rename("install/", $renamefile."install/");
if(!rename("install/", $renamefile."install/"))
{
	if (copy ("install/", $renamefile."install/"))
       	{
        	 unlink($renamefile."install/");
     	}
}
//populate Calendar data

?>
		<table border=0 cellspacing=0 cellpadding=5 align="center" width=75% style="background-color:#E1E1FD;border:1px dashed #111111;">
		<tr>
			<td align=center class=small>
			<b>易客CRM安装完成！</b>
			<hr noshade size=1>
			<div style="width:100%;padding:10px; "align=left>
			<ul>
			<li>您的install.php被重命名为 <?php echo $renamefile;?>install.php.txt.
			<li>您的install目录被重命名为 <?php echo $renamefile;?>install/.  
			<li>易客CRM默认的用户名和密码均为admin。
			</ul>
			</div>

			</td>
		</tr>
		</table>
		<br>	
		<table border=0 cellspacing=0 cellpadding=10 width=100%>
		<tr><td colspan=2 align="center">
				 <form action="index.php" method="post" name="form" id="form">
				 <input type="hidden" name="default_user_name" value="admin">
			 	 <input  type="image" src="include/install/images/cwBtnFinish.gif" name="next" title="Finish" value="完成" />
				 </form>
		</td></tr>
		</table>		
		</td>

		</tr>
		</table>
		<!-- Master display stops -->
		
	</td>
	</tr>
	</table>
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
