<?php
require_once('config.inc.php');
require_once('include/utils/utils.php');
require_once('include/database/PearDatabase.php');
require_once('Sms/SmsLib.php');
global $current_user;
global $adb;

// new a mail
$mail = new SaeMail();
$nowdatetime = date("Y-m-d H:i:s");

$queue = new SaeTaskQueue('sendnums');
$array = array();
$url = "http://".$_SERVER['HTTP_HOST']."/getSendMailNums.php";

//查出所有用户
$query =  "select id,phone_mobile,email1,last_name,user_name from ec_users where 1";
$result = $adb->query($query); 
$num_rows = $adb->num_rows($result);
if($num_rows > 0){
	for($i=0;$i<$num_rows;$i++){
		$userid = $adb->query_result($result,$i,"id");
		$phone_mobile = $adb->query_result($result,$i,"phone_mobile");
		$email1 = $adb->query_result($result,$i,"email1");
		$last_name = $adb->query_result($result,$i,"last_name");
		$user_name = $adb->query_result($result,$i,"user_name");
		
		
		//搜索该用户所有的提醒规则模板
		$query2 = "select * from ec_memdayconfig where smownerid='{$userid}'";
		$result2 = $adb->query($query2);
		$num_rows2 = $adb->num_rows($result2);
		if($num_rows2 > 0){ 
			for($j=0;$j<$num_rows2;$j++){
				$tp = $adb->query_result($result2,$j,"tp");
				$type = $adb->query_result($result2,$j,"type");
				$sms_type = $adb->query_result($result2,$j,"sms");
				$autoact_sms_sm = $adb->query_result($result2,$j,"autoact_sms_sm");
				$email_type = $adb->query_result($result2,$j,"email");
				$autoact_email_bt = $adb->query_result($result2,$j,"autoact_email_bt");
				$autoact_email_sm = $adb->query_result($result2,$j,"autoact_email_sm");
				$emailtoacc = $adb->query_result($result2,$j,"emailtoacc");
				$emailtouser = $adb->query_result($result2,$j,"emailtouser");
				$smstoacc = $adb->query_result($result2,$j,"smstoacc");
				$smstouser = $adb->query_result($result2,$j,"smstouser");
				
				if($tp == 0){
					$date = date("m-d");
				}else{
					$date = date("m-d",strtotime("$tp days"));	
				}
				//搜索该提醒的纪念日类型和到期的客户信息
				$query3 = "select ec_account.* from ec_memdays 
							inner join ec_account 
								on ec_account.accountid  = ec_memdays.accountid
							where ec_memdays.memday938 ='".$type."' and ec_memdays.memday946 like '%".$date."' and ec_account.deleted=0 and ec_memdays.deleted=0";  
				 $result3 = $adb->query($query3);	
				 $num_rows3 = $adb->num_rows($result3);
				 if($num_rows3 > 0){ 
					 for($m=0;$m<$num_rows3;$m++){
						 $phone = $adb->query_result($result3,$m,"phone");
						 $email = $adb->query_result($result3,$m,"email");
						 $membername = $adb->query_result($result3,$m,"membername");
						 
						 
						  if($sms_type =='on'){
							 $sms_sm = explode('$',$autoact_sms_sm);
							 $message = '';
							 foreach($sms_sm as $sm){
								if($sm == 'name'){
									$message .=$membername;
								}else{
									$message .= $sm;
								}
							 }
							if($smstoacc =='on'){
								 if(!empty($phone)){
									
									 $phonename = array('phone'=>$phone,'name'=>$membername);
									 
									 $res = sendSMS($message,$phonename,$userid);
									 
									 $array[] = array('url'=>$url,"postdata" => "phone=$phone");
									 if($res['error'] == 0){
										 $flag=1;
										 $sendresult = "发送成功";
									 }else{
										 $flag=0; 
										 $sendresult = "发送失败".$res['message'];
									 }
									
									 //saveSmsLog($userid,$membername,$phone,$message,$flag,$sendresult,$nowdatetime);
								 }
							}
							if($smstouser =='on'){
								 if(!empty($phone_mobile)){
									 $phonename = array('phone'=>$phone_mobile,'name'=>'自己');
									 $res = sendSMS($message,$phonename,$userid);
									 $array[] = array('url'=>$url,"postdata" => "phone=$phone_mobile");
									 if($res == ''){
										 $flag=1;
										 $sendresult = "发送成功";
									 }else{
										 $flag=0; 
										 $sendresult = "发送失败".$res['message'];
									 }
									
									 //saveSmsLog($userid,"自己",$phone_mobile,$message,$flag,$sendresult,$nowdatetime);
								 }
							}
							
								 
							
						 }//on
						 
						 
						 if($email_type =='on'){
							$email_bt = explode('$',$autoact_email_bt);
							$subject = '';
							foreach($email_bt as $bt){
								if($bt == 'name'){
									$subject .=$membername;
								}else{
									$subject .= $bt;
								}
							}
							 
							$email_sm = explode('$',$autoact_email_sm);
							$content = '';
							foreach($email_sm as $sm){
								if($sm == 'name'){
									$content .=$membername;
								}else{
									$content .= $sm;
								}
							}
							
							
							 if($email !=''){
								if($emailtoacc =='on'){
									$interval = getIntervar($userid);
									if(!empty($interval)){
										sleep($interval);
									}else{
										sleep(5);	
									}
									
									$currenttime = date("Y-m-d H:i:s");
									
									$maillogsid = $adb->getUniqueID("ec_maillogs");
									$imghtml = '<img src="http://crm123.sinaapp.com/getMailId.php?mailid='.$maillogsid.'"  border=0 width="1" height="1" />';
									$content = $content.$imghtml;
									
									//失败回调地址
									$callback = "http://".$_SERVER['HTTP_HOST']."/domailfailed.php?mailid=$maillogsid";		
		
									 $res = send_webmail($mail,$email,$subject,$content,$userid,$callback);
									 $array[] = array('url'=>$url,"postdata" => "email=$email");
									 if($res == ''){
										 $flag=1;
										 $sendresult="发送成功";
									 }else{
										$flag=0;
										$sendresult="发送失败".$res; 
									 }
									 
									 saveMailLog($maillogsid,$userid,$membername,$email,$subject,$content,$flag,$sendresult,$currenttime);
								}
							 }
							 if($email1 !=''){
							    if($emailtouser =='on'){
									$interval = getIntervar($userid);
									if(!empty($interval)){
										sleep($interval);
									}else{
										sleep(5);	
									}
									
									$currenttime = date("Y-m-d H:i:s");
									
									$maillogsid = $adb->getUniqueID("ec_maillogs");
									$imghtml = '<img src="http://crm123.sinaapp.com/getMailId.php?mailid='.$maillogsid.'"  border=0 width="1" height="1" />';
									$content = $content.$imghtml;
									
									//失败回调地址
									$callback = "http://".$_SERVER['HTTP_HOST']."/domailfailed.php?mailid=$maillogsid";		
									
									 $res = send_webmail($mail,$email1,$subject,$content,$userid,$callback);
									 $array[] = array('url'=>$url,"postdata" => "email=$email1");
									 if($res == ''){
										 $flag=1;
										 $sendresult="发送成功";
									 }else{
										$flag=0;
										$sendresult="发送失败".$res; 
									 }
									 
									 saveMailLog($maillogsid,$userid,"自己",$email1,$subject,$content,$flag,$sendresult,$currenttime);
								}
							 }
						 }
					 }
				 }
			}
		}
	}
}

$queue->addTask($array);
//将任务推入队列
$queue->push();



function getIntervar($userid){
	global $adb;
	$query = "select interval from ec_systems where server_type='email' and smownerid='".$userid."' ";	
	$row = $adb->getFirstLine($query);
	if(!empty($row)){
		return $row['interval'];
	}else{
		return '';	
	}
}

function send_webmail($mail,$to_email,$subject,$contents,$smownerid,$callback)
{
	global $adb, $log;
	global $current_user;
	$log->debug("Entering send_webmail() method ...");
	
	$key = "webmail_array_".$smownerid;
	$webmail_array = getSqlCacheData($key);
	if(!$webmail_array) {
		$webmail_array = $adb->getFirstLine("select * from ec_systems where server_type='email' and smownerid='".$current_user->id."'");
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
		$log->info("send_webmail ::errormsg:".$mail->errmsg());
	}
	$mail->clean(); // 重用此对象
	
	$log->debug("Exit send_webmail() method ...");
	return $errMsg;
}


function saveMailLog($maillogsid,$userid,$receiver,$receiver_email,$subject,$mailcontent,$flag,$result,$sendtime){
	global $adb;
	global $log;
	$log->debug("Entering saveMailLog() method ...");
	//$id = $adb->getUniqueID("ec_maillogs");
	$query = "insert into ec_maillogs(id,userid,receiver,receiver_email,subject,mailcontent,flag,result,sendtime) values($maillogsid,'".$userid."','".$receiver."','".$receiver_email."','".$subject."','".$mailcontent."',$flag,'".$result."','".$sendtime."')";
	$adb->query($query);
	$log->debug("Exit saveMailLog() method ...");
}
?>