<?php
require_once('include/utils/utils.php');
global $adb;
$userid = $_REQUEST['userid'];

if(!isset($userid) || empty($userid)){
	die;
}
$query = "select `interval` from `ec_systems` where smownerid={$userid} "; 
$row = $adb->getFirstLine($query); 
$interval = $row['interval'];

sleep($interval);

$sjid = $_REQUEST['sjid'];
$maillogsid = $_REQUEST['maillogsid'];
$subject = $_REQUEST['subject'];
$subject =  str_replace("##",'&',$subject);	

$mailcontent = $_REQUEST['mailcontent'];
$mailcontent =  str_replace("##",'&',$mailcontent);	
$imghtml = '<img src="http://'.$_SERVER['HTTP_HOST'].'/getMailId.php?mailid='.$maillogsid.'"  border=0 width="1" height="1" />';
$mailcontent = $mailcontent.$imghtml;

$to_email = $_REQUEST['to_email'];
$receiver = $_REQUEST['receiver'];
$mailcontent = str_replace("\$name\$",$receiver,$mailcontent);

//失败回调地址
$callback = "http://".$_SERVER['HTTP_HOST']."/domailfailed.php?sjid=$sjid&mailid=$maillogsid";
//发送邮件
$msg = send_webmail($to_email,$subject,$mailcontent,$userid,$callback);

if(!empty($msg)){
	$flag = 0; //failed
	$result = "发送失败".$msg;
	$successrate = 0;
	
}else{
	$flag = 1;//success
	$result = "发送成功";
	$successrate = 1;
}
	
//保存单条邮件记录
saveMailLog($sjid,$maillogsid,$userid,$receiver,$to_email,$subject,$mailcontent,$flag,$result,$successrate);



function send_webmail($to_email,$subject,$contents,$userid,$callback)
{
	global $adb, $log;
	$log->debug("Entering send_webmail() method ...");
	
	// 实例化mail
	$mail = new SaeMail();
	
	$key = "webmail_array_".$userid;
	$webmail_array = getSqlCacheData($key);
	if(!$webmail_array) {
		$webmail_array = $adb->getFirstLine("select * from ec_systems where server_type='email' and smownerid='".$userid."'");
		if(empty($webmail_array)) {
			return "No Smtp Server!";
		}
	
		setSqlCacheData($key,$webmail_array);	
	}
		
	$from_email = $webmail_array['from_email'];
	if($from_email == ''){
		$from_email = $webmail_array['server_username'];
	}
	

	$options = array(
		'from'=>$from_email, //only one
		'to' => $to_email,  //(多个用,分开)
		'cc' => '',        //(多个用,分开)
		'smtp_host' => $webmail_array['server'],
		'smtp_port' => $webmail_array['server_port'],
		'smtp_username' => $webmail_array['server_username'],
		'smtp_password' => $webmail_array['server_password'],
		'subject' => $subject,
		'content' => $contents,
		'content_type' => "HTML", //"TEXT"|"HTML",default TEXT
		'charset' => "utf8",
		'tls' => "false",
		'compress' =>'',
		'callback_url' =>$callback
	);
	
	$mail->setOpt($options);
	
	$ret = $mail->send();
	
	if ($ret === false) {
		$errMsg = $mail->errmsg().'<br>';
		$log->info("send_webmail :: errormsg:".$mail->errmsg());
	}
	
	$mail->clean(); // 重用此对象
	$log->debug("Exit send_webmail() method ...");
	return $errMsg;
}
//detail
function saveMailLog($sjid,$maillogsid,$userid,$receiver,$receiver_email,$subject,$mailcontent,$flag,$result,$successrate){
	global $adb;
	global $log;
	$log->debug("Entering saveMailLog() method ...");
	
	$sendtime = date("Y-m-d H:i:s");
	
	$query = "insert into ec_maillogs(id,userid,receiver,receiver_email,subject,mailcontent,flag,result,sendtime) values($maillogsid,'".$userid."','".$receiver."','".$receiver_email."','".$subject."','".$mailcontent."',$flag,'".$result."','".$sendtime."')";
	$adb->query($query);
	
	if($successrate >0){
		//更新群发成功率
		$updatesql = "update ec_maillists set successrate = successrate+".$successrate." where maillistsid= '".$sjid."' ";
		$adb->query($updatesql);
	}
	$log->debug("Exit saveMailLog() method ...");
}


?>
