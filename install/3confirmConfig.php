<?php
if (isset($_REQUEST['db_hostname'])) $db_hostname= $_REQUEST['db_hostname'];
if (isset($_REQUEST['db_username'])) $db_username= $_REQUEST['db_username'];
if (isset($_REQUEST['db_password'])) $db_password= $_REQUEST['db_password'];
if (isset($_REQUEST['db_name'])) $db_name= $_REQUEST['db_name'];
if (isset($_REQUEST['db_drop_tables'])) $db_drop_tables = $_REQUEST['db_drop_tables'];
if (isset($_REQUEST['site_URL'])) $site_URL= $_REQUEST['site_URL'];
if (isset($_REQUEST['cache_dir'])) $cache_dir= $_REQUEST['cache_dir'];
if (isset($_REQUEST['root_directory'])) $root_directory = $_REQUEST['root_directory'];
if (isset($_REQUEST['db_type'])) $db_type = $_REQUEST['db_type'];
if (isset($_REQUEST['check_createdb'])) $check_createdb = $_REQUEST['check_createdb'];
if (isset($_REQUEST['root_user'])) $root_user = $_REQUEST['root_user'];
if (isset($_REQUEST['root_password'])) $root_password = $_REQUEST['root_password'];

$db_server_status = false; // does the db server connection exist?
$db_creation_failed = false; // did we try to create a database and fail?
$db_exist_status = false; // does the database exist?
$next = false; // allow installation to continue

//Checking for database connection parameters
if($db_type=='mysql')
{
	$mysql_conn = mysql_connect($db_hostname,$db_username,$db_password);
	if($mysql_conn) {
		$db_server_status = true;
	}
	
	$version = explode('-',mysql_get_server_info($mysql_conn));
	$mysql_server_version=$version[0];
	mysql_close($mysql_conn);

}
if(isset($_REQUEST['check_createdb']) && $_REQUEST['check_createdb'] == 'on')
{
	$root_user = $_REQUEST['root_user'];
	$root_password = $_REQUEST['root_password'];

	$mysql_conn = mysql_connect($db_hostname,$root_user,$root_password);
	if($mysql_conn)
	{
		$query = "drop database ".$db_name;
		mysql_query($query,$mysql_conn);
		$query = "create database ".$db_name." DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
		mysql_query($query,$mysql_conn);
		
	}
	mysql_close($mysql_conn);
}

// test the connection to the database
$mysql_conn = mysql_connect($db_hostname,$db_username,$db_password);
if($mysql_conn)
{
	$query = "ALTER DATABASE `".$db_name."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
	if(mysql_query($query,$mysql_conn)) {
		$db_exist_status = true;
	} else {
		$db_exist_status = false;
	}
	mysql_close($mysql_conn);
}


$error_msg = '';
$error_msg_info = '';

if(!$db_server_status)
{
	$error_msg = 'Unable to connect to database Server. Invalid mySQL Connection Parameters specified';
	$error_msg_info = 'This may be due to the following reasons:<br>
			-  specified database user, password, hostname, database type, or port is invalid.<BR>
			-  specified database user does not have access to connect to the database server from the host';
}
elseif($db_type == 'mysql' && $mysql_server_version < '4.1')
{
	$error_msg = 'MySQL version '.$mysql_server_version.' is not supported, kindly connect to MySQL 4.1.x or above';
}
elseif($db_creation_failed)
{
	$error_msg = 'Unable to Create Database '.$db_name;
	$error_msg_info = 'Message: The database User "'. $root_user .'" doesn\'t have permission to Create database. Try changing the Database settings';
}
elseif(!$db_exist_status)
{
	$error_msg = 'The Database "'.$db_name.'" is not found.Try changing the Database settings';
}
else
{
	$next = true;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>易客CRM - 安装向导 - 确认配置</title>
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
					<tr><td class="small cwSelectedTab" align=right><div align="left"><b>确认配置</b></div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">创建配置文件</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">创建数据库</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">完成</div></td></tr>
					</table>
					
				</td>
				<td width=80% valign=top class="cwContentDisplay" align=left>
				<table border=0 cellspacing=0 cellpadding=10 width=100%>
				<tr><td class=small align=left><img src="include/install/images/confWizConfirmSettings.gif" alt="确认配置" title="确认配置"><br>
					  <hr noshade size=1></td></tr>
				<tr>
					<td align=left class="small" style="padding-left:20px">
					<?php if($error_msg) : ?>
						<div style="background-color:#ff0000;color:#ffffff;padding:5px">
						<b><?php echo $error_msg ?></b>
						</div>
						<?php if($error_msg_info) : ?>
							<p><?php echo $error_msg_info ?><p>
						<?php endif ?>
					<?php endif ?>
					<table width="90%" cellpadding="5" border="0" class="small" style="background-color:#cccccc" cellspacing="1">
					<tr>
						<td colspan=2><strong>数据库配置</strong></td>
					</tr>
					<tr bgcolor="White">
						<td bgcolor="#F5F5F5" width="40%">数据库服务器</td>
						<td align="left" nowrap> <font class="dataInput"><?php if (isset($db_hostname)) echo "$db_hostname"; ?></font></td>
					</tr>
					<tr bgcolor="White">
						<td bgcolor="#F5F5F5" width="40%">用户名</td>
						<td align="left" nowrap> <font class="dataInput"><?php if (isset($db_username)) echo "$db_username"; ?></font></td>
					</tr>
					<tr bgcolor="White">
						<td bgcolor="#F5F5F5" width="40%" noWrap>密码</td>
						<td align="left" nowrap> <font class="dataInput"><?php if (isset($db_password)) echo ereg_replace('.', '*', $db_password); ?></font></td>
					</tr>
					<tr bgcolor="White">
						<td noWrap bgcolor="#F5F5F5" width="40%">数据库类型</td>
						<td align="left" nowrap> <font class="dataInput"><?php if (isset($db_type)) echo "$db_type"; ?></font></td>
					</tr>
					<tr bgcolor="White">
						<td noWrap bgcolor="#F5F5F5" width="40%">数据库名</td>
						<td align="left" nowrap> <font class="dataInput"><?php if (isset($db_name)) echo "$db_name"; ?></font></td>
					</tr>
					</table>
					<table width="90%" cellpadding="5" border="0" class="small" cellspacing="1" style="background-color:#cccccc">
					<tr>
						<td colspan=2 ><strong>站点配置</strong></td>
					</tr>
					<tr bgcolor="White">
						<td bgcolor="#F5F5F5" width="40%">网址</td>
						<td align="left"> <font class="dataInput"><?php if (isset($site_URL)) echo $site_URL; ?></font></td>
					</tr>
					<tr bgcolor="White">
						<td bgcolor="#F5F5F5" width="40%">路径</td>
						<td align="left"><font class="dataInput"><?php if (isset($root_directory)) echo $root_directory; ?></font></td>
					</tr>
					<tr bgcolor="White">
						<td bgcolor="#F5F5F5" width="40%">缓存路径</td>
						<td align="left"> <font class="dataInput"><?php if (isset($cache_dir)) echo $root_directory.''.$cache_dir; ?></font></td>
					</tr>
					</table>	

					


					<br><br>
					<table width="90%" cellpadding="5" border="0" class="small" >
					<tr>
					<td align="left" valign="bottom">
					<form action="install.php" method="post" name="form" id="form">
						<input type="hidden" name="file" value="2setConfig.php">
						<input type="hidden" class="dataInput" name="db_type" value="<?php if (isset($db_type)) echo "$db_type"; ?>" />
						<input type="hidden" class="dataInput" name="db_hostname" value="<?php if (isset($db_hostname)) echo "$db_hostname"; ?>" />
						<input type="hidden" class="dataInput" name="db_username" value="<?php if (isset($db_username)) echo "$db_username"; ?>" />
						<input type="hidden" class="dataInput" name="db_password" value="<?php if (isset($db_password)) echo "$db_password"; ?>" />
						<input type="hidden" class="dataInput" name="db_name" value="<?php if (isset($db_name)) echo "$db_name"; ?>" />
						<input type="hidden" class="dataInput" name="db_drop_tables" value="<?php if (isset($db_drop_tables)) echo "$db_drop_tables"; ?>" />
						<input type="hidden" class="dataInput" name="site_URL" value="<?php if (isset($site_URL)) echo "$site_URL"; ?>" />
						<input type="hidden" class="dataInput" name="root_directory" value="<?php if (isset($root_directory)) echo "$root_directory"; ?>" />
						<input type="hidden" class="dataInput" name="cache_dir" value="<?php if (isset($cache_dir)) echo $cache_dir; ?>" />			<input type="hidden" class="dataInput" name="check_createdb" value="<?php if (isset($check_createdb)) echo "$check_createdb"; ?>" />
						<input type="hidden" class="dataInput" name="root_user" value="<?php if (isset($root_user)) echo "$root_user"; ?>" />
						<input type="hidden" class="dataInput" name="root_password" value="<?php if (isset($root_password)) echo "$root_password"; ?>" />
						<input type="image" name="Change" value="Change" title="Change" src="include/install/images/cwBtnChange.gif"/>
					</form>
					</td>

					<?php if($next) : ?>
					<td align="right" valign="bottom">
					<form action="install.php" method="post" name="form" id="form">
						<input type="hidden" name="file" value="4createConfigFile.php">
						<input type="hidden" class="dataInput" name="db_populate" value="0">							
						<input type="hidden" class="dataInput" name="db_type" value="<?php if (isset($db_type)) echo "$db_type"; ?>" />
						<input type="hidden" class="dataInput" name="db_hostname" value="<?php if (isset($db_hostname)) echo "$db_hostname"; ?>" />
						<input type="hidden" class="dataInput" name="db_username" value="<?php if (isset($db_username)) echo "$db_username"; ?>" />
						<input type="hidden" class="dataInput" name="db_password" value="<?php if (isset($db_password)) echo "$db_password"; ?>" />
						<input type="hidden" class="dataInput" name="db_name" value="<?php if (isset($db_name)) echo "$db_name"; ?>" />
						<input type="hidden" class="dataInput" name="db_drop_tables" value="<?php if (isset($db_drop_tables)) echo "$db_drop_tables"; ?>" />
						<input type="hidden" class="dataInput" name="site_URL" value="<?php if (isset($site_URL)) echo "$site_URL"; ?>" />
						<input type="hidden" class="dataInput" name="root_directory" value="<?php if (isset($root_directory)) echo "$root_directory"; ?>" />

						<input type="hidden" class="dataInput" name="cache_dir" value="<?php if (isset($cache_dir)) echo $cache_dir; ?>" />
						<input type="hidden" class="dataInput" name="check_createdb" value="<?php if (isset($check_createdb)) echo "$check_createdb"; ?>" />
						<input type="hidden" class="dataInput" name="root_user" value="<?php if (isset($root_user)) echo "$root_user"; ?>" />
						<input type="hidden" class="dataInput" name="root_password" value="<?php if (isset($root_password)) echo "$root_password"; ?>" />
						<input type="image" src="include/install/images/cwBtnNext.gif" name="next" title="Next" value="Create" onClick="window.location=('install.php')"/>
					</form>
					</td>
					<?php endif ?>
					</tr>
					</table>

				</td>
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
