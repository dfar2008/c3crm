<?php
include('ecversion.php');


session_start();



// vtiger CRM version number; do not edit!

$ec_version = "5.0.2";
$release_date = "31 October 2006";


if (isset($_REQUEST['db_hostname']))
{
	if(strpos($_REQUEST['db_hostname'], ":"))
	{
		list($db_hostname,$db_port) = split(":",$_REQUEST['db_hostname']);
	}	
	else
	{
		$db_hostname = $_REQUEST['db_hostname'];
		if($db_type == "pgsql")
		     $db_port = '5432';
		else
		     $db_port = '3306';
	}	
}
if (isset($_REQUEST['db_username']))$db_username = $_REQUEST['db_username'];

if (isset($_REQUEST['db_password']))$db_password = $_REQUEST['db_password'];

if (isset($_REQUEST['db_name']))$db_name = $_REQUEST['db_name'];

if (isset($_REQUEST['db_type'])) $db_type = $_REQUEST['db_type'];

if (isset($_REQUEST['db_drop_tables'])) $db_drop_tables = $_REQUEST['db_drop_tables'];

if (isset($_REQUEST['db_create'])) $db_create = $_REQUEST['db_create'];

if (isset($_REQUEST['db_populate'])) $db_populate = $_REQUEST['db_populate'];

if (isset($_REQUEST['site_URL'])) $site_URL = $_REQUEST['site_URL'];

// update default port
if ($db_port == '')
{
	if($db_type == 'mysql')
	{
		$db_port = "3306";
	}
}

$cache_dir = 'cache/';

$parameter = "";
if (isset($db_hostname))  $parameter .= "db_hostname=".$db_hostname."&";
if (isset($db_username))  $parameter .= "db_username=".$db_username."&";
if (isset($db_password))  $parameter .= "db_password=".$db_password."&";
if (isset($db_name))  $parameter .= "db_name=".$db_name."&";
if (isset($db_drop_tables))  $parameter .= "db_drop_tables=".$db_drop_tables."&";
if (isset($db_create))  $parameter .= "db_create=".$db_create."&";
if (isset($db_populate)) $parameter .= "db_populate=".$db_populate."&";
$parameter .= "file=5createTables.php";


?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>易客CRM - 安装向导 - 创建配置文件</title>
	<link href="include/install/install.css" rel="stylesheet" type="text/css">
</head>

<body class="small cwPageBg" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<br><br>
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
					<tr><td class="small cwSelectedTab" id="configfile_tab" align=right><div align="left"><b>创建配置文件</b></div></td></tr>
					<tr><td class="small cwUnSelectedTab" id="dbcreate_tab" align=right><div align="left">创建数据库</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">完成</div></td></tr>
					</table>
					
				</td>
				<td width=80% valign=top class="cwContentDisplay" align=left>
				<table border=0 cellspacing=0 cellpadding=10 width=100%>
				<tr><td class=small align=left><img id="title_img" src="include/install/images/confWizConfFile.gif" alt="Config File Creation" title="Config File Creation"><img id="title_img1" src="include/install/images/confWizDbGeneration.gif" style="display:none;" alt="Database Generation" title="Database Generation"><br>
					  <hr noshade size=1></td></tr>
				<tr>
					<td align=left class="small" style="padding-left:20px">
					<?php
					if (isset($_REQUEST['root_directory']))
						$root_directory = $_REQUEST['root_directory'];
		
					if (is_file('config.inc.php'))
					    	$is_writable = is_writable('config.inc.php');
					else
	      					$is_writable = is_writable('.');

	      				/* open template configuration file read only */
	      				$templateFilename = 'config.template.php';
	      				$templateHandle = fopen($templateFilename, "r");
	      				if($templateHandle) {
		      				/* open include configuration file write only */
		      				$includeFilename = 'config.inc.php';
					      	$includeHandle = fopen($includeFilename, "w");
		      				if($includeHandle) {
			      			   while (!feof($templateHandle)) {
				      			$buffer = fgets($templateHandle);

				     			/* replace _DBC_ variable */
				      			$buffer = str_replace( "_DBC_SERVER_", $db_hostname, $buffer);
				      			$buffer = str_replace( "_DBC_PORT_", $db_port, $buffer);
				      			$buffer = str_replace( "_DBC_USER_", $db_username, $buffer);
				      			$buffer = str_replace( "_DBC_PASS_", $db_password, $buffer);
				      			$buffer = str_replace( "_DBC_NAME_", $db_name, $buffer);
				      			$buffer = str_replace( "_DBC_TYPE_", $db_type, $buffer);

				      			$buffer = str_replace( "_SITE_URL_", $site_URL, $buffer);

				      			/* replace dir variable */
				      			$buffer = str_replace( "_VT_ROOTDIR_", $root_directory, $buffer);
				      			$buffer = str_replace( "_VT_CACHEDIR_", $cache_dir, $buffer);
				      			$buffer = str_replace( "_VT_TMPDIR_", $cache_dir."images/", $buffer);
				      			$buffer = str_replace( "_VT_UPLOADDIR_", $cache_dir."upload/", $buffer);

						      	$buffer = str_replace( "_DB_STAT_", "true", $buffer);

						      	/* replace the application unique key variable */
					      		$buffer = str_replace( "_VT_APP_UNIQKEY_", md5($root_directory), $buffer);
	
					      		fwrite($includeHandle, $buffer);
					      		}

				      		fclose($includeHandle);
				      		}

				      	fclose($templateHandle);
				      	}
	//更新catmail的配置文件
	define('LF', "\n");
	/*
	delete catmail
	$mail_configpath = "mail/shared/config/driver.mysql.conf.php";
	if (!file_exists($mail_configpath) || !is_file($mail_configpath)) {
        touch($mail_configpath, 0755);
    }
    $suf = fopen($mail_configpath, 'w');
    if ($suf) {
        $old_umask = umask(0);
		fputs($suf, '<?php die(); ?>'.LF);
		fputs($suf, 'mysql_host;;'.$db_hostname.':'.$db_port.LF);
		fputs($suf, 'mysql_user;;'.$db_username.LF);
		fputs($suf, 'mysql_pass;;'.$db_password.LF);
		fputs($suf, 'mysql_database;;'.$db_name.LF);
		fputs($suf, 'mysql_prefix;;catmail'.LF);
		fclose($suf);
		chmod($mail_configpath, 0755);
		umask($old_umask);
    }
	

	//更新ajax im的配置文件
	$im_configpath = "im/config.php";
	if (!file_exists($im_configpath) || !is_file($im_configpath)) {
        touch($im_configpath, 0755);
    }
    $suf = fopen($im_configpath, 'w');
    if ($suf) {
        $old_umask = umask(0);
		fputs($suf, '<?php '.LF);
		fputs($suf, '$sql_host = "'.$db_hostname.':'.$db_port.'";'.LF);
		fputs($suf, '$sql_user = "'.$db_username.'";'.LF);
		fputs($suf, '$sql_pass = "'.$db_password.'";'.LF);
		fputs($suf, '$sql_db = "'.$db_name.'";'.LF);
		fputs($suf, "define('SQL_PREFIX', 'ajaxim_');".LF);
		fputs($suf, '?>');
		fclose($suf);
		//chmod($im_configpath, 0755);
		umask($old_umask);
    }
	*/
  
	if ($templateHandle && $includeHandle) {?>
			<div id="config_info">
			<p><strong class="big">成功创建config.inc.php配置文件 :</strong><br><br>
			<font color="green"><b><?php echo $root_directory; ?></b></font><br><br>
			请继续点击“下一步”创建数据库，创建数据库至少需要4分钟时间。喝杯咖啡休息一下...<br>
			</p>
			</div>
			<br>		
	<?php } 
	else {?>
			<div id="config_info"><p><strong class="big"><font color="red">不能写入配置文件(config.inc.php ) : </font></strong><br><br>
			<font color="green"><b><?php echo $root_directory; ?></b></font><br><br>
			<P>您可以手工创建config.inc.php配置文件以继续下面的安装过程。<P><br><br>
	<?php			
	$config = "<?php \n";
 	$config .= "include('ecversion.php');\n\n";
 	$config .= "// more than 8MB memory needed for graphics\n\n";
 	$config .= "// memory limit default value = 16M\n\n";
 	$config .= "ini_set('memory_limit','256M');\n\n";
 	$config .= "// show or hide world clock, calculator and FCKEditor\n\n";
 	$config .= "// world_clock_display default value = true\n";
 	$config .= "// calculator_display default value = true\n";
 	$config .= "// fckeditor_display default value = true\n\n";
 	$config .= "\$WORLD_CLOCK_DISPLAY = 'true';\n";
 	$config .= "\$CALCULATOR_DISPLAY = 'true';\n";
 	$config .= "\$FCKEDITOR_DISPLAY = 'true';\n\n";
 	
 	$config .= "//This is the URL for customer portal. (Ex. http://www.crmone.cn/portal)\n";
 	$config .= "\$PORTAL_URL = 'http://yourdomain.com/customerportal';\n\n";
 	$config .= "//These two are the HelpDesk support email id and the support name. ";
 	$config .= "(Ex. 'support@crmone.cn' and 'crmone Support')\n";
 	$config .= "\$HELPDESK_SUPPORT_EMAIL_ID = 'support@yourdomain.com';\n";
 	$config .= "\$HELPDESK_SUPPORT_NAME = 'yourdomain Name';\n\n";
 	
 	$config .= "/* Database configuration\n";
 	$config .= "      db_host_name:     MySQL Database Hostname\n";
 	$config .= "      db_user_name:        MySQL Username\n";
 	$config .= "      db_password:         MySQL Password\n";
 	$config .= "      db_name:             MySQL Database Name\n*/\n";
 	$config .= "\$dbconfig['db_server'] =     '".$db_hostname."';\n";
 	$config .= "\$dbconfig['db_port'] =     '".$db_port."';\n";
 	$config .= "\$dbconfig['db_username'] =     '".$db_username."';\n";
 	$config .= "\$dbconfig['db_password'] =         '".$db_password."';\n";
 	$config .= "\$dbconfig['db_name'] =             '".$db_name."';\n";
 	$config .= "\$dbconfig['db_type'] = '".$db_type."';\n";
	$config .= "\$dbconfig['db_status'] = 'true';\n";

	$config .= "// TODO: test if port is empty\n";
	$config .= "// TODO: set db_hostname dependending on db_type\n";
 	$config .= "\$dbconfig['db_hostname'] = \$dbconfig['db_server'].\$dbconfig['db_port'];\n\n";

	
	$config .= "// log_sql default value = false\n";
	$config .= "\$dbconfig['log_sql'] = false;\n\n";
	
	$config .= "// persistent default value = true\n";
	$config .= "\$dbconfigoption['persistent'] = true;\n\n";

	$config .= "// autofree default value = false\n";
	$config .= "\$dbconfigoption['autofree'] = false;\n\n";
	
	$config .= "// debug default value = 0\n";
	$config .= "\$dbconfigoption['debug'] = 0;\n\n";

	$config .= "// seqname_format default value = '%s_seq'\n";
	$config .= "\$dbconfigoption['seqname_format'] = '%s_seq';\n\n";

	$config .= "// portability default value = 0\n";
	$config .= "\$dbconfigoption['portability'] = 0;\n\n";

	$config .= "// ssl default value = false\n";
	$config .= "\$dbconfigoption['ssl'] = false;\n\n";

	$config .= "\$host_name = \$dbconfig['db_hostname'];\n\n";
	
	$config .= "\$site_URL ='$site_URL';\n\n";

	$config .= "// root directory path\n";
	$config .= "\$root_directory = '$root_directory';\n\n";

	$config .= "// cache direcory path\n";
	$config .= "\$cache_dir = '$cache_dir';\n\n";

	$config .= "// tmp_dir default value prepended by cache_dir = images/\n";
	$config .= "\$tmp_dir = '$cache_dir"."images/';\n\n";

	$config .= "// import_dir default value prepended by cache_dir = import/\n";
	$config .= "\$tmp_dir = '$cache_dir"."import/';\n\n";

	$config .= "// upload_dir default value prepended by cache_dir = upload/\n";
	$config .= "\$tmp_dir = '$cache_dir"."upload/';\n\n";

	$config .= "// mail server parameters\n";
	$config .= "\$mail_server = '$mail_server';\n";
	$config .= "\$mail_server_username = '$mail_server_username';\n";
	$config .= "\$mail_server_password = '$mail_server_password';\n\n";
	
	$config .= "// maximum file size for uploaded files in bytes also used when uploading import files\n";
	$config .= "// upload_maxsize default value = 3000000\n";
	$config .= "\$upload_maxsize = 3000000;\n\n";

	$config .= "// flag to allow export functionality\n";
	$config .= "// 'all' to allow anyone to use exports \n";
	$config .= "// 'admin' to only allow admins to export\n";
	$config .= "// 'none' to block exports completely\n";
	$config .= "// allow_exports default value = all\n";
	$config .= "\$allow_exports = 'all';\n\n";

 	$config .= "// Files with one of these extensions will have '.txt' appended to their filename on upload\n";
	$config .= "// upload_badext default value = php, php3, php4, php5, pl, cgi, py, asp, cfm, js, vbs, html, htm\n";
 	$config .= "\$upload_badext = array('php', 'php3', 'php4', 'php5', 'pl', 'cgi', 'py', 'asp', 'cfm', 'js', 'vbs', 'html', 'htm');\n\n";

 	$config .= "// This is the full path to the include directory including the trailing slash\n";
	$config .= "// includeDirectory default value = $root_directory..'include/\n";
 	$config .= "\$includeDirectory = \$root_directory.'include/';\n\n";
	
	$config .= "// list_max_entries_per_page default value = 20\n";
	$config .= "\$list_max_entries_per_page = '20';\n\n";

 	$config .= "// change this number to whatever you want. This is the number of pages that will appear in the pagination. by Raju \n";
 	$config .= "\$limitpage_navigation = '9';\n\n";
	
	$config .= "// history_max_viewed default value = 5\n";
 	$config .= "\$history_max_viewed = '5';\n\n";
 	
 	$config .= "// Map Sugar language codes to jscalendar language codes\n";
 	$config .= "// Unimplemented until jscalendar language files are fixed\n";
 	$config .= "// \$cal_codes = array('en_us'=>'en', 'ja'=>'jp', 'sp_ve'=>'sp', 'it_it'=>'it', 'tw_zh'=>'zh', 'pt_br'=>'pt', 'se'=>'sv', 'cn_zh'=>'zh', 'ge_ge'=>'de', 'ge_ch'=>'de', 'fr'=>'fr');\n\n";

	$config .= "//set default module and action\n";
 	$config .= "\$default_module = 'Home';\n";
 	$config .= "\$default_action = 'index';\n\n";

 	$config .= "//set default theme\n";
 	$config .= "\$default_theme = 'bluelagoon';\n\n";

 	$config .= "// If true, the time to compose each page is placed in the browser.\n";
 	$config .= "\$calculate_response_time = true;\n";

 	$config .= "// Default Username - The default text that is placed initially in the login form for user name.\n";
 	$config .= "\$default_user_name = '';\n";
	
 	$config .= "// Default Password - The default text that is placed initially in the login form for password.\n";
 	$config .= "\$default_password = '';\n";

 	$config .= "// Create default user - If true, a user with the default username and password is created.\n";
 	$config .= "\$create_default_user = false;\n";
 	$config .= "\$default_user_is_admin = false;\n";

 	$config .= "// disable persistent connections - If your MySQL/PHP configuration does not support persistent connections set this to true to avoid a large performance slowdown\n";
 	$config .= "\$disable_persistent_connections = false;\n";
 	$config .= "// Defined languages available.  The key must be the language file prefix.  E.g. 'en_us' is the prefix for every 'en_us.lang.php' file. \n";
 	
 	$language_value = "Array('en_us'=>'US English',)";
 	if(isset($_SESSION['language_keys']) && isset($_SESSION['language_values']))
 	{
 	    $language_value = 'Array(';
 	    $language_keys = explode(',', urldecode($_SESSION['language_keys']));
 	    $language_values = explode(',', urldecode($_SESSION['language_values']));
 	    $size = count($language_keys);
 	    for($i = 0; $i < $size; $i+=1)
 	    {
 	        $language_value .= "'$language_keys[$i]'=>'$language_values[$i]',";
 	    }
 	    $language_value .= ')';
 	}
 	$config .= "\$languages = $language_value;\n";
	$config .= "// Master currency name\n";
 	$config .= "\$currency_name = '$currency_name';\n";
 	$config .= "// Default charset if the language specific character set is not found.\n";
 	$config .= "\$default_charset = 'UTF-8';\n";
 	$config .= "// Default language in case all or part of the user's language pack is not available.\n";
 	$config .= "\$default_language = 'zh_cn';\n";
 	$config .= "// Translation String Prefix - This will add the language pack name to every translation string in the display.\n";
 	$config .= "\$translation_string_prefix = false;\n";
 	
 	$config .= "//Option to cache tabs permissions for speed.\n";
 	$config .= "\$cache_tab_perms = true;\n\n";
 	
 	$config .= "//Option to hide empty home blocks if no entries.\n";
 	$config .= "\$display_empty_home_blocks = false;\n\n";

 	$config .= "// Generating Unique Application Key\n";
 	$config .= "\$application_unique_key = '".md5($root_directory)."';\n\n";
 	$config .= "?>";
		
			echo "<TEXTAREA class=\"dataInput\" rows=\"15\" cols=\"80\">".$config."</TEXTAREA><br><br>";
			echo "<P>Did you remember to create the config.inc.php file ?</p>";
	
				  
		}	?>
				</div></td>
				</tr>
				<tr><td align="center"><img id="populating_info" src="include/install/images/loading.gif" style="visibility:hidden;"></td></tr>
				<tr>
				<td align=right style="height:60px;">
				 
				 <input  type="image" name="next" value="Next" id="next_btn" src="include/install/images/cwBtnNext.gif" onClick="document.location.href='install_db.php?<?php echo $parameter;?>';" />
					
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
	<script>
	function createtablejs()
	{
		document.getElementById('dbcreate_tab').innerHTML = '<div align="left"><b>创建数据库</b></div>';
		document.getElementById('configfile_tab').className = 'small cwUnSelectedTab';
		document.getElementById('configfile_tab').innerHTML = '<div align="left">创建配置文件</div>';
		document.getElementById('dbcreate_tab').className = 'small cwSelectedTab';
		oImg = document.getElementById('title_img').style.display = 'none';
		oImg = document.getElementById('title_img1').style.display = 'block';
		document.getElementById('populating_info').style.visibility='visible';
		document.getElementById("next_btn").style.display = 'none';
		window.document.title = '易客CRM - 安装向导 - 正在创建数据库 ...';
	}
	</script>
</body>
</html>
