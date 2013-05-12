<html>
<?php


ob_start();
eval("phpinfo();");
$info = ob_get_contents();
ob_end_clean();

 foreach(explode("\n", $info) as $line) {
           if(strpos($line, "Client API version")!==false)
               $mysql_version = trim(str_replace("Client API version", "", strip_tags($line)));
 }









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

$gd_info_alternate = 'function gd_info() {
$array = Array(
                       "GD Version" => "",
                       "FreeType Support" => 0,
                       "FreeType Support" => 0,
                       "FreeType Linkage" => "",
                       "T1Lib Support" => 0,
                       "GIF Read Support" => 0,
                       "GIF Create Support" => 0,
                       "JPG Support" => 0,
                       "PNG Support" => 0,
                       "WBMP Support" => 0,
                       "XBM Support" => 0
                     );
       $gif_support = 0;

       ob_start();
       eval("phpinfo();");
       $info = ob_get_contents();
       ob_end_clean();

       foreach(explode("\n", $info) as $line) {
           if(strpos($line, "GD Version")!==false)
               $array["GD Version"] = trim(str_replace("GD Version", "", strip_tags($line)));
           if(strpos($line, "FreeType Support")!==false)
               $array["FreeType Support"] = trim(str_replace("FreeType Support", "", strip_tags($line)));
           if(strpos($line, "FreeType Linkage")!==false)
               $array["FreeType Linkage"] = trim(str_replace("FreeType Linkage", "", strip_tags($line)));
           if(strpos($line, "T1Lib Support")!==false)
               $array["T1Lib Support"] = trim(str_replace("T1Lib Support", "", strip_tags($line)));
           if(strpos($line, "GIF Read Support")!==false)
               $array["GIF Read Support"] = trim(str_replace("GIF Read Support", "", strip_tags($line)));
           if(strpos($line, "GIF Create Support")!==false)
               $array["GIF Create Support"] = trim(str_replace("GIF Create Support", "", strip_tags($line)));
           if(strpos($line, "GIF Support")!==false)
               $gif_support = trim(str_replace("GIF Support", "", strip_tags($line)));
           if(strpos($line, "JPG Support")!==false)
               $array["JPG Support"] = trim(str_replace("JPG Support", "", strip_tags($line)));
           if(strpos($line, "PNG Support")!==false)
               $array["PNG Support"] = trim(str_replace("PNG Support", "", strip_tags($line)));
           if(strpos($line, "WBMP Support")!==false)
               $array["WBMP Support"] = trim(str_replace("WBMP Support", "", strip_tags($line)));
           if(strpos($line, "XBM Support")!==false)
               $array["XBM Support"] = trim(str_replace("XBM Support", "", strip_tags($line)));
       }

       if($gif_support==="enabled") {
           $array["GIF Read Support"]  = 1;
           $array["GIF Create Support"] = 1;
       }

       if($array["FreeType Support"]==="enabled"){
           $array["FreeType Support"] = 1;    }

       if($array["T1Lib Support"]==="enabled")
           $array["T1Lib Support"] = 1;

       if($array["GIF Read Support"]==="enabled"){
           $array["GIF Read Support"] = 1;    }

       if($array["GIF Create Support"]==="enabled")
           $array["GIF Create Support"] = 1;

       if($array["JPG Support"]==="enabled")
           $array["JPG Support"] = 1;

       if($array["PNG Support"]==="enabled")
           $array["PNG Support"] = 1;

       if($array["WBMP Support"]==="enabled")
           $array["WBMP Support"] = 1;

       if($array["XBM Support"]==="enabled")
           $array["XBM Support"] = 1;

       return $array;

}';

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>易客CRM - 安装向导 - 安装检查</title>
	<link href="include/install/install.css" rel="stylesheet" type="text/css">
</head>

<body class="small cwPageBg" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

	<br><br><br>
	<!-- Table for cfgwiz starts -->

	<table border=0 cellspacing=0 cellpadding=0 width=80% align=center>
	<tr>
		<td class="cwHeadBg" align=left><img src="include/install/images/configwizard.gif" alt="安装向导" hspace="20" title="Configuration Wizard"></td>
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
					<tr><td class="small cwSelectedTab" align=right><div align="left"><b>安装检查</b></div></td></tr>
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
				    <tr><td class=small align=left><img src="include/install/images/confWizInstallCheck.gif" alt="安装检查" title="安装检查"><br>
					  <hr noshade size=1></td></tr>
				    <tr>
					<td align=left class="small" style="padding-left:20px">
	    				<table cellpadding="10" cellspacing="1" width="90%" border="0" class="small" style="background-color:#cccccc">
					<tr bgcolor="#efefef"><td colspan=2><span style="color:#003399"><strong>PHP核心组件</strong></span></td></tr>
					<tr bgcolor="#fafafa">
						<td valign=top ><strong>PHP 版本</strong><BR></td>
						<td  valign=top bgcolor="white"><?php $php_version = phpversion(); echo (str_replace(".", "", $php_version) < "430") ? "<strong><font color=\"#FF0000\">失败</strong><br> 安装的版本不支持($php_version)</font>" : "<strong><font color=\"#00CC00\">通过</strong><br>安装的版本：$php_version</font>"; ?></td>
    					</tr>
					<tr bgcolor="#fafafa">
						<td valign=top ><strong>mbstring库</strong></td>
				        	<td valign=top bgcolor=white><?php echo function_exists('mb_detect_encoding')?"<strong><font color=\"#00CC00\">通过</strong><br>mbstring库可用</font>":"<strong><font color=\"#FF0000\">失败</strong><br>不可用。您可以忽略mbstring库，但易客CRM的Webmail将不能正常使用</font>";?></td>
					</tr>
					<tr bgcolor="#fafafa">
						<td valign=top ><strong>simplexml库</strong></td>
				        	<td valign=top bgcolor=white><?php echo function_exists('simplexml_load_file')?"<strong><font color=\"#00CC00\">通过</strong><br>simplexml库可用</font>":"<strong><font color=\"#FF0000\">失败</strong><br>不可用。您可以忽略simplexml库，但易客CRM的Webmail将不能正常使用</font>";?></td>
					</tr>
					<tr bgcolor="#fafafa">
						<td valign=top ><strong>GD库</strong><br> version 2.0 or later</td>
						<td valign=top bgcolor="white"><?php
						if (!extension_loaded('gd')) {
							echo "<strong><font size=-1 color=\"#FF0000\">GD库没有配置 </strong>.您可以忽略GD库，但易客CRM的验证码将不能正常显示</font>";
						}
						else {
							if (!function_exists('gd_info'))
							{
								eval($gd_info_alternate);
							}
							$gd_info = gd_info();

							if (isset($gd_info['GD Version'])) {
								$gd_version = $gd_info['GD Version'];
								$gd_version=preg_replace('%[^0-9.]%', '', $gd_version);

								if ($gd_version > "2.0") {
									echo "<strong><font color=\"#00CC00\">通过</strong><br>已安装的版本：$gd_version</font>";
								}
								else {
									echo "<strong><font color=\"#00CC00\">通过</strong><br>已安装的版本：$gd_version</font>";
								}
							}
							else {
								echo "<strong><font size=-1 color=\"#FF0000\">GD库可用，但是没有正确配置。您可以忽略GD库，但易客CRM的验证码将不能正常显示</font>";
							}
						}
						?>
						</td>
					</tr>
					<tr bgcolor="#efefef"><td colspan=2><strong><span style="color:#003399">Read/Write Access</span></strong></td></tr>
					<tr bgcolor="#fafafa">
						<td valign=top ><strong>易客CRM配置文件</strong><br>(config.inc.php)</strong></td>
						<td valign=top bgcolor="white" ><?php echo (is_writable('./config.inc.php') || is_writable('.'))?"<strong><font color=\"#00CC00\">可写</font>":"<strong><font color=\"#FF0000\">失败</strong><br>不可写</font>"; ?></td>
					</tr>

					
		 			<tr bgcolor="#fafafa">
						<td valign=top ><strong>缓存目录 </strong> <br>(cache/)</td>
            					<td valign=top bgcolor="white" ><?php echo (is_writable('./cache/'))?"<strong><font color=\"#00CC00\">可写</font></strong>":"<strong><font color=\"#FF0000\">不可写</font></strong>"; ?></td>
        				</tr>
					<tr bgcolor="#fafafa">
						<td valign=top ><strong>日志目录 </strong> <br>(logs/)</td>
            					<td valign=top bgcolor="white" ><?php echo (is_writable('./logs/'))?"<strong><font color=\"#00CC00\">可写</font></strong>":"<strong><font color=\"#FF0000\">不可写<br>备份数据库将不能备份。</font></strong>"; ?></td>
        				</tr>
		 			
					<tr bgcolor="#fafafa">
		    				<td valign=top ><strong>上传目录</strong><br> (storage/)</td>
            					<td valign=top bgcolor="white"><?php echo (is_writable('./storage/'))?"<strong><font color=\"#00CC00\">可写</font></strong>":"<strong><font color=\"#FF0000\">不可写</strong> <br>您将遇到上传附件问题。</font>"; ?></td>
        				</tr>
					<tr bgcolor="#fafafa">
		    				<td valign=top ><strong>安装目录</strong><br> (install/)</td>
            					<td valign=top bgcolor="white"><?php echo (is_writable('./install/'))?"<strong><font color=\"#00CC00\">可写</font></strong>":"<strong><font color=\"#FF0000\">不可写</strong> <br>最后一步将出现问题</font>"; ?></td>
        				</tr>
					<tr bgcolor="#fafafa">
		    				<td valign=top ><strong>安装文件</strong><br> (install.php)</td>
            					<td valign=top bgcolor="white"><?php echo (is_writable('./install.php'))?"<strong><font color=\"#00CC00\">可写</font></strong>":"<strong><font color=\"#FF0000\">不可写</strong> <br>最后一步将出现问题</font>"; ?></td>
					</tr>
					<tr bgcolor="#fafafa">
				                <td valign=top ><strong>Smarty编译目录 </strong><br> (Smarty/templates_c)</td>
				                <td valign=top bgcolor="white"><?php echo (is_writable('./Smarty/templates_c/'))?"<strong><font color=\"#00CC00\">可写</font></strong>":"<strong><font color=\"#FF0000\">不可写</strong> <br>您将不能登陆 </font>";?></td>
					</tr>
       				</table>
				<br><br>
	   	   		<!-- Recommended Settings -->
				<table cellpadding="10" cellspacing="1" width="90%" border="0" class="small" style="background-color:#cccccc">
				<tr bgcolor="#efefef"><td colspan=2><span style="color:#003399"><strong>推荐配置: 我们强烈建议您检查php.ini的配置项。 </strong></span></td></tr>
				<tr bgcolor="#ffffff"> <td valign=top ><strong>Safe Mode Off</strong></tr>
				<tr bgcolor="#ffffff"> <td valign=top ><strong>Display Errors On</strong></tr>
				<tr bgcolor="#ffffff"> <td valign=top ><strong>File Uploads On</strong></tr>
				<tr bgcolor="#ffffff"> <td valign=top ><strong>Register Globals Off</strong></tr>
				<tr bgcolor="#ffffff"> <td valign=top ><strong>Max Execution Time 600</strong></tr>
				<tr bgcolor="#ffffff"> <td valign=top ><strong>output_buffering= On</strong></tr>
				<tr bgcolor="#ffffff"> <td valign=top ><strong>Change the memory limit = 32M</strong></tr>
				<tr bgcolor="#ffffff"> <td valign=top ><strong>error_reporting = E_WARNING & ~E_NOTICE</strong></tr>
				<tr bgcolor="#ffffff"> <td valign=top ><strong>allow_call_time_reference = On</strong></tr>
				<tr bgcolor="#ffffff"> <td valign=top ><strong>log_errors = Off</strong></tr>
				<tr bgcolor="#ffffff"> <td valign=top ><strong>short_open_tag= On</strong></tr>
				</table>
			</td>
			</tr>
			<tr>
				<td align=center>
					<form action="install.php" method="post" name="installform" id="form">
			                <input type="hidden" name="file" value="2setConfig.php" />	
					<input type="image" src="include/install/images/cwBtnNext.gif" alt="Next" border="0" title="Next" onClick="window.document.installform.submit();">
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
