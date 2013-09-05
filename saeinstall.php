<?php
define('IN_CRMONE', true);
$root_directory = dirname(__FILE__)."/";
require($root_directory.'include/init.php');
global $adb;
$filepath = $root_directory.'storage/c3crm.sql';
//echo "filepath:".$filepath."<br>";
$init = sql_import($filepath);

//$cron = new SaeCron();
//$url2 = 'dosendmail.php';
//$ret = $cron->add($url2, 'every 3 mins');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>易客CRM开源免费版</title>
<link href="style/index.css" rel="stylesheet" type="text/css" />
</head>
<body class="help">
<div>
<?php if($init==true) echo "<h>数据库初始化成功！默认用户名和密码均为admin</h>"; else echo "<h>数据库初始化失败，请刷新或者手动运行SQL语句。</h>"; echo "&nbsp;&nbsp;<a href='Login.php'>点此进入登录页面</a>";?>
<p>易客CRM开源免费版<br/>
----------------------------------------------------------------------<br/>
易客CRM，国内10大CRM品牌，采用最流行的开发语言-PHP开发语言，基于LAMP(Linux、Apache、Mysql、PHP)平台开发的新一代BS架构客户关系管理系统。易客CRM是根据国内中小型企业特点开发出的企业应用解决方案，主要面向中小型企业且企业为IT、咨询、贸易、连锁零售或服务业等.。该系统成熟稳定、简单易用、功能强大, 零风险、低投入、支持多种操作系统、异地办公等, 为您的企业带来最大的方便！ <br/>

如果需要了解更多详细信息，请访问易客CRM官方网站：<a target="_blank" href="http://www.c3crm.com">http://www.c3crm.com</a><br/>

如果您对此程序有任何意见和建议，或者bug反馈，可以通过以下方式联系。<br/>

1、新浪微博：<a target="_blank" href="http://e.weibo.com/crmone">@易客CRM软件</a><br/>
2、联系电话：400 680 5898<br/>
</p>
</div>
<?php
$renamefile = uniqid(rand(), true);
if(!@rename("install.php", $renamefile."install.php.txt"))
{
	if (@copy ("install.php", $renamefile."install.php.txt"))
       	{
        	 @unlink($renamefile."install.php.txt");
     	}
}
?>
</body>
</html>