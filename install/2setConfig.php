<?php
// TODO: deprecate connection.php file
//require_once("connection.php");

// TODO: introduce MySQL port as parameters to use non-default value 3306
//$sock_path=":" .$mysql_port;
$hostname = $_SERVER['SERVER_NAME'];

// TODO: introduce Apache port as parameters to use non-default value 80
//$web_root = $_SERVER['SERVER_NAME']. ":" .$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'];
//$web_root = $hostname.$_SERVER['PHP_SELF'];
$web_root = $HTTP_SERVER_VARS["HTTP_HOST"] . $HTTP_SERVER_VARS["REQUEST_URI"];
$web_root = str_replace("/install.php", "", $web_root);
$web_root = "http://".$web_root;

$current_dir = pathinfo(dirname(__FILE__));
$current_dir = $current_dir['dirname']."/";
$cache_dir = "cache/";

if (is_file("config.php") && is_file("config.inc.php")) {
	require_once("config.inc.php");
	session_start();

	if(isset($upload_maxsize))
	$_SESSION['upload_maxsize'] = $upload_maxsize;

	if(isset($allow_exports))
	$_SESSION['allow_exports'] = $allow_exports;

	if(isset($disable_persistent_connections))
	$_SESSION['disable_persistent_connections'] = $disable_persistent_connections;

	if(isset($default_language))
	$_SESSION['default_language'] = $default_language;

	if(isset($translation_string_prefix))
	$_SESSION['translation_string_prefix'] = $translation_string_prefix;

	if(isset($default_charset))
	$_SESSION['default_charset'] = $default_charset;

	if(isset($languages)) {
		// need to encode the languages in a way that can be retrieved later
		$language_keys = Array();
		$language_values = Array();

		foreach($languages as $key=>$value) {
			$language_keys[] = $key;
			$language_values[] = $value;
		}
		$_SESSION['language_keys'] = urlencode(implode(",",$language_keys));
		$_SESSION['language_values'] = urlencode(implode(",",$language_values));
	}
													
	global $dbconfig;

	if (isset($_REQUEST['db_hostname']))
	$db_hostname = $_REQUEST['db_hostname'];
	elseif (isset($dbconfig['db_hostname']))
	$db_hostname = $dbconfig['db_hostname'];
	else
	$db_hostname = $hostname;

	if (isset($_REQUEST['db_username']))
	$db_username = $_REQUEST['db_username'];
	elseif (isset($dbconfig['db_username']))
	$db_username = $dbconfig['db_username'];

	if (isset($_REQUEST['db_password']))
	$db_password = $_REQUEST['db_password'];
	elseif (isset($dbconfig['db_password']))
	$db_password = $dbconfig['db_password'];

	if (isset($_REQUEST['db_type']))
	$db_type = $_REQUEST['db_type'];
	elseif (isset($dbconfig['db_type']))
	$db_type = $dbconfig['db_type'];

	if (isset($_REQUEST['db_name']))
	$db_name = $_REQUEST['db_name'];
	elseif (isset($dbconfig['db_name']) && $dbconfig['db_name']!='_DBC_NAME_')
	$db_name = $dbconfig['db_name'];
	else
	$db_name = 'dbcrmone';

	!isset($_REQUEST['db_drop_tables']) ? $db_drop_tables = "0" : $db_drop_tables = $_REQUEST['db_drop_tables'];
	if (isset($_REQUEST['host_name'])) $host_name = $_REQUEST['host_name'];
	else $host_name = $hostname;

	if (isset($_REQUEST['site_URL'])) $site_URL = $_REQUEST['site_URL'];
	elseif (isset($site_URL) && $site_URL!='_SITE_URL_')
	$site_URL = $site_URL;
	else $site_URL = $web_root;

	if(isset($_REQUEST['root_directory'])) $root_directory = $_REQUEST['root_directory'];
	else $root_directory = $current_dir;
	    
	if (isset($_REQUEST['cache_dir']))
	$cache_dir= $_REQUEST['cache_dir'];
	}
	else {
		!isset($_REQUEST['db_hostname']) ? $db_hostname = $hostname: $db_hostname = $_REQUEST['db_hostname'];
		!isset($_REQUEST['db_name']) ? $db_name = "ecustomer" : $db_name = $_REQUEST['db_name'];
		!isset($_REQUEST['db_drop_tables']) ? $db_drop_tables = "0" : $db_drop_tables = $_REQUEST['db_drop_tables'];
		!isset($_REQUEST['host_name']) ? $host_name= $hostname : $host_name= $_REQUEST['host_name'];
		!isset($_REQUEST['site_URL']) ? $site_URL = $web_root : $site_URL = $_REQUEST['site_URL'];
		!isset($_REQUEST['root_directory']) ? $root_directory = $current_dir : $root_directory = stripslashes($_REQUEST['root_directory']);
		!isset($_REQUEST['cache_dir']) ? $cache_dir = $cache_dir : $cache_dir = stripslashes($_REQUEST['cache_dir']);
	}
	!isset($_REQUEST['check_createdb']) ? $check_createdb = "" : $check_createdb = $_REQUEST['check_createdb'];
	!isset($_REQUEST['root_user']) ? $root_user = "" : $root_user = $_REQUEST['root_user'];
	!isset($_REQUEST['root_password']) ? $root_password = "" : $root_password = $_REQUEST['root_password'];
	// determine database options
	$db_options = array();
	if(function_exists('mysql_connect')) {
		$db_options['mysql'] = 'MySQL';
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>易客CRM - 安装向导 - 系统配置</title>
	<link href="include/install/install.css" rel="stylesheet" type="text/css">
</head>

<body class="small cwPageBg" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<style>
	.hide_tab{display:none;}
	.show_tab{display:inline-table;}
</style>

<script type="text/javascript" language="Javascript">

	function fnShow_Hide(){
		var sourceTag = document.getElementById('check_createdb').checked;
		if(sourceTag){
			document.getElementById('root_user').className = 'show_tab';
			document.getElementById('root_pass').className = 'show_tab';
			document.getElementById('root_user_txtbox').focus();
		}
		else{
			document.getElementById('root_user').className = 'hide_tab';
			document.getElementById('root_pass').className = 'hide_tab';
		}
	}

function trim(s) {
        while (s.substring(0,1) == " ") {
                s = s.substring(1, s.length);
        }
        while (s.substring(s.length-1, s.length) == ' ') {
                s = s.substring(0,s.length-1);
        }

        return s;
}

function verify_data(form) {
	var isError = false;
	var errorMessage = "";
	// Here we decide whether to submit the form.
	if (trim(form.db_hostname.value) =='') {
		isError = true;
		errorMessage += "\n 数据库服务器";
		form.db_hostname.focus();
	}
	if (trim(form.db_username.value) =='') {
		isError = true;
		errorMessage += "\n 数据库用户名";
		form.db_username.focus();
	}
	if (trim(form.db_name.value) =='') {
		isError = true;
		errorMessage += "\n 数据库名称";
		form.db_name.focus();
	}
	if (trim(form.site_URL.value) =='') {
		isError = true;
		errorMessage += "\n 网址";
		form.site_URL.focus();
	}
	if (trim(form.root_directory.value) =='') {
		isError = true;
		errorMessage += "\n 路径";
		form.root_directory.focus();
	}
	
	if (trim(form.cache_dir.value) =='') {
                isError = true;
                errorMessage += "\n 缓存目录";
                form.cache_dir.focus();
        }

	if(document.getElementById('check_createdb').checked == true)
	{
		if (trim(form.root_user.value) =='') {
			isError = true;
			errorMessage += "\n 数据库管理员名称";
			form.root_user.focus();
		}
	}

	// Here we decide whether to submit the form.
	if (isError == true) {
		alert("必填字段: " + errorMessage);
		return false;
	}
	if (trim(form.admin_email.value) != "" && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(form.admin_email.value)) {
		alert("Email:'"+form.admin_email.value+"'无效");
		form.admin_email.focus();
		exit();
	}

	form.submit();
}
// end hiding contents from old browsers  -->
</script>

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
					<tr><td class="small cwSelectedTab" align=right><div align="left"><b>系统配置</b></div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">确认配置</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">创建配置文件</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">创建数据库</div></td></tr>
					<tr><td class="small cwUnSelectedTab" align=right><div align="left">完成</div></td></tr>
					</table>
					
				</td>
				<td width=80% valign=top class="cwContentDisplay" align=left>
				<!-- Right side tabs -->
				    <form action="install.php" method="post" name="installform" id="form" name="setConfig" id="form">
				    <table border=0 cellspacing=0 cellpadding=10 width=100%>
				    <tr><td class=small align=left><img src="include/install/images/confWizSysConfig.gif" alt="系统配置" title="系统配置"><br>
					  <hr noshade size=1></td></tr>
				    <tr>
					<td align=left class="small" style="padding-left:20px">

	
				<table width="100%" cellpadding="5"  cellspacing="1" border="0" class=small><tbody>
				<tr>
					<td >
		          		<b>请输入以下的数据库配置信息...</b><br>

					  如果您没有数据库的管理权限(例如您在虚拟主机上安装), 您应该在进行下一步之前创建易客CRM系统需要的数据库。然后，安装程序将创建需要的数据库表。
					  <br><br>
			
					  如果您不确定数据库服务器，我们建议您采用默认值。<br><br>
					  
					  *- 必填信息
					  

					</td>
				</tr>
				</table>
			
			<br>
			
			<table width="90%" cellpadding="5"  cellspacing="1" border="0" class=small style="background-color:#cccccc"><tbody>
			<tr><td colspan=2><strong>数据库配置</strong></td></tr>
			<tr>
               <td width="25%" nowrap bgcolor="#F5F5F5" ><strong>数据库类型</strong> <sup><font color=red>*</font></sup></td>
               <td width="75%" bgcolor="white" align="left">
		<?php if(!$db_options) : ?>
			没有检测到数据库
		<?php elseif(count($db_options) == 1) : ?>
			<?php list($db_type, $label) = each($db_options); ?>
			<input type="hidden" name="db_type" value="<?php echo $db_type ?>"><?php echo $label ?>
		<?php else : ?>
			<select name="db_type">
			<?php foreach($db_options as $db_option_type => $label) : ?>
				<option value="<?php echo $db_option_type ?>" <?php if(isset($db_type) && $db_type == $db_option_type) { echo "SELECTED"; } ?>><?php echo $label ?></option>
			<?php endforeach ?>
			</select>
		<?php endif ?>
			   </td>
            </tr>
			<tr>
               <td width="25%" nowrap bgcolor="#F5F5F5" ><strong>数据库服务器</strong> <sup><font color=red>*</font></sup></td>
               <td width="75%" bgcolor="white" align="left"><input type="text" class="dataInput" name="db_hostname" value="<?php if (isset($db_hostname)) echo "$db_hostname"; ?>" /></td>
              </tr>
              <tr>
               <td nowrap bgcolor="#F5F5F5"><strong>用户名</strong> <sup><font color=red>*</font></sup></td>
               <td bgcolor="white" align="left"><input type="text" class="dataInput" name="db_username" value="<?php if (isset($db_username)) echo "$db_username"; ?>" /></td>
              </tr>
              <tr>
               <td nowrap bgcolor="#F5F5F5"><strong>密码</strong></td>
               <td bgcolor="white" align="left"><input type="password" class="dataInput" name="db_password" value="<?php if (isset($db_password)) echo "$db_password"; ?>" /></td>
              </tr>
              <tr>
               <td nowrap bgcolor="#F5F5F5"><strong>数据库名</strong> <sup><font color=red>*</font></sup></td>
               <td bgcolor="white" align="left"><input type="text" class="dataInput" name="db_name" value="<?php if (isset($db_name)) echo "$db_name"; ?>" />&nbsp;
		       <?php if($check_createdb == 'on')
			       {?>
			       <input name="check_createdb" type="checkbox" id="check_createdb" checked onClick="fnShow_Hide()"/>
			       <?php }else{?>
				       <input name="check_createdb" type="checkbox" id="check_createdb" onClick="fnShow_Hide()"/>
			       <?php } ?>
			       &nbsp;创建数据库(将删除已有的数据库)</td>
              </tr>
	      <tr id="root_user" class="hide_tab">
			   <td bgcolor="#f5f5f5" nowrap="nowrap" width="25%"><strong>管理员用户名</strong> <sup><font color="red">*</font></sup></td>
			   <td align="left" bgcolor="white"><input class="dataInput" name="root_user" id="root_user_txtbox" value="<?php echo $root_user;?>" type="text"></td>
 	      </tr>
	      <tr id="root_pass" class="hide_tab">
			   <td bgcolor="#f5f5f5" nowrap="nowrap"><strong>管理员密码</strong></td>
			   <td align="left" bgcolor="white"><input class="dataInput" name="root_password" value="<?php echo $root_password;?>" type="password"></td>
	      </tr>
              </table>
			
			<br><br>
			
		  <!-- Web site configuration -->
		<table width="90%" cellpadding="5" border="0" style="background-color:#cccccc" cellspacing="1" class="small"><tbody>
            <tr>
				<td ><strong>站点配置</strong></td>
            </tr>
			<tr>
				<td width="25%" bgcolor="#F5F5F5" ><strong>网址</strong> <sup><font color=red>*</font></sup></td>
				<td width="75%" bgcolor=white align="left"><input class="dataInput" type="text" name="site_URL"
				value="<?php if (isset($site_URL)) echo $site_URL; ?>" size="40" />
				</td>
			</tr>
			<tr>
				<td bgcolor="#F5F5F5"><strong>路径</strong> <sup><font color=red>*</font></sup></td>
				<td align="left" bgcolor="white"><input class="dataInput" type="text" name="root_directory" value="<?php if (isset($root_directory)) echo "$root_directory"; ?>" size="40" /> </td>
			</tr>
			<tr valign="top">
				<td bgcolor="#F5F5F5"><strong>缓存路径  <sup><font color=red>*</font></sup><br>(必须可写)</td>
				<td align="left" bgcolor="white"><?php echo $root_directory; ?><input class="dataInput" type="text" name="cache_dir" size='14' value="<?php if (isset($cache_dir)) echo $cache_dir; ?>" size="40" /> </td>
          </tr>
          </table>

		<!-- System Configuration -->
		</td>
		</tr>
		<tr>
				<td align=center>
					<input type="hidden" name="file" value="3confirmConfig.php" />
					<input type="image" src="include/install/images/cwBtnNext.gif" id="starttbn" alt="Next" border="0" title="Next" onClick="return verify_data(window.document.installform);">
					<br>
				    <br></td>
			</tr>
		</table>
		</form>
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
	fnShow_Hide();
	</script>
</body>
</html>