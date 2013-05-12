<?php
require_once('config.php');
require_once('modules/Users/Users.php');
require_once('include/logging.php');
require_once('include/utils/UserInfoUtil.php');
require_once('dosendmail.php');
global $adb;
$user_email = $_REQUEST['user_email'];

$query = "SELECT id FROM ec_users WHERE deleted=0 and email1 ='".$user_email."'";
$row = $adb->getFirstLine($query);
if(empty($row))
{
	echo 'Email:',$user_email,'不存在!';
	die;
}
else
{
	$id = $row['id'];
	$last_name = $row['last_name'];
	$len = 6;
	// 随机生成数组索引，从而实现随机数
	for($j=0; $j<100; $j++)
	{
		$pass = "";
		$options = getOptions();
		$lastIndex = 35;
		while (strlen($pass)<$len)
		{
			// 从0到35中随机取一个作为索引
			$index = rand(0,$lastIndex);
			// 将随机数赋给变量 $chr
			$chr = $options[$index];
			// 随机数作为 $pass 的一部分
			$pass .= $chr;
			$lastIndex = $lastIndex-1;
			// 最后一个索引将不会参与下一次随机抽奖
			$options[$index] = $options[$lastIndex];
		}	
	}
	//生成新的密码
	$focus = new Users();
	$new_password = $focus->encrypt_password($pass);
	$user_hash = strtolower(md5($pass));
	
	//change pwd to new pwd
	$query = "UPDATE ec_users SET user_password='$new_password', user_hash='$user_hash' where id='$id'";
	$adb->query($query);
	/*
	$mail = new SaeMail();
	$subject = "找回密码";
	$content = "尊敬的用户,您好,易客CRM已经收到您的找回密码请求,现已将您的密码重置为:".$pass.",请重新登录后修改.";
	global $log;
	$log->info($content);
	$sql="select * from ec_systems where server_type = 'email' and smownerid='$id'";
	$server_row = $adb->getFirstLine($sql);
	if(empty($server_row))
	{
		$from_email = "saecrm_noreply@sina.com";
		$pwd = "c3crm321";
		$server_name ="smtp.sina.com";
		$server_port = "25";
	}else{
		$from_email = $server_row['from_email'];
		$pwd = $server_row['server_password'];
		$server_name = $server_row['server'];
		$server_port = $server_row['server_port'];
	}
	

	$ret = $mail->quickSend( $user_email , $subject , $content , $from_email , $pwd ,$server_name , $server_port);
	if ($ret === false)
	{	$errMsg = $mail->errmsg();
		echo '发送失败'.$pass;
		die;
	}else{
		echo '发送成功';
		die;
	}*/
	//change pwd to new pwd
	
	$subject = "找回密码";
	$content = "尊敬的用户,您好,易客CRM已经收到您的找回密码请求,现已将您的密码重置为:".$pass.",请重新登录后修改.";
	global $log;
	$log->info($content);
	$msg = send_webmail($user_email,$last_name,'','',$subject,$content,'',$id); 

	if(!empty($msg))
	{
		echo '发送失败'.$msg;
		die;
	}else{
		echo '发送成功';
		die;
	}
}

// 生成0123456789abcdefghijklmnopqrstuvwxyz中的一个字符
function getOptions()
{
	$options = array();
	$result = array();
	for($i=48; $i<=57; $i++)
	{
		array_push($options,chr($i));  
	}
	for($i=65; $i<=90; $i++)
	{
		$j = 32;
		$small = $i + $j;
		array_push($options,chr($small));
	}
	return $options;
}
?>
