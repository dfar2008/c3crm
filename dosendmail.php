<?php
define('IN_CRMONE', true);
$root_directory = dirname(__FILE__)."/";
require($root_directory.'config.php');
require_once($root_directory.'include/utils/utils.php');
require_once($root_directory.'include/utils/CommonUtils.php');
require_once($root_directory.'include/database/PearDatabase.php');
require_once($root_directory.'include/logging.php');
require_once($root_directory.'modules/Users/Users.php');
require_once($root_directory.'include/utils/clean_incoming_data.php');
require_once($root_directory.'user_privileges/seqprefix_config.php');
require_once($root_directory.'include/Zend/Queue.php');    
global $adb;
global $site_URL;
global $dbconfig;
$options = array(
   'name'          => 'queue1',
   'driverOptions' => array(
       'host'      => $dbconfig['db_server'],
       'port'      => substr($dbconfig['db_port'],1),
       'username'  => $dbconfig['db_username'],
       'password'  => $dbconfig['db_password'],
       'dbname'    => $dbconfig['db_name'],
	   'type'      => 'pdo_mysql'
    )
);
$queue = new Zend_Queue('Db', $options);

//一分钟发送25条
$messages = $queue->receive(100);

foreach ($messages as $i => $message) {
     //参数字符串
    $postdata =  $message->body;	

	$posts = explode("&",$postdata);
	
	//sjid
	$sjid_arr = explode("=",$posts[0]);
	$sjid = $sjid_arr['1'];

	//maillogsid
	$maillogsid_arr = explode("=",$posts[1]);
	$maillogsid = $maillogsid_arr['1'];
	//判断是否已经发送过了
	$mailflag = checkMaillog($maillogsid);
	if(!$mailflag){
		continue;
	}

	//to_email
	$to_email_arr = explode("=",$posts[2]);
	$to_email = $to_email_arr['1'];

	//receiver
	$receiver_arr = explode("=",$posts[3]);
	$receiver = $receiver_arr['1'];
	
	//from_name
	$from_name_arr = explode("=",$posts[4]);
	$from_name = $from_name_arr['1'];
	
	//from_email
	$from_email_arr = explode("=",$posts[5]);
	$from_email = $from_email_arr['1'];
	
	//interval
	$interval_arr = explode("=",$posts[6]);
	$interval = $interval_arr['1'];
	
	//subject
	$subject = substr($posts[7],8);
	$subject =  str_replace("##",'&',$subject);	
	
	//mailcontent
	$mailcontent = substr($posts[8],12);
	$mailcontent =  str_replace("##",'&',$mailcontent);	 
	
	$mailcontent = str_replace("\$name\$",$receiver,$mailcontent);

	//userid
	$userid_arr = explode("=",$posts[9]);
	$userid =  $userid_arr[1];
	$imgurl = $_SERVER['HTTP_HOST'].'/getMailId.php?mailid='.$maillogsid;
	
	$mailcontent = $mailcontent;
	
	
	
	//$mailcontent = stripHTML($mailcontent);
	

	//失败回调地址
	//$callback = $site_URL."/domailfailed.php?sjid=$sjid&mailid=$maillogsid";

	//发送邮件
	$msg = send_webmail($to_email,$receiver,$from_name,$from_email,$subject,$mailcontent,$maillogsid,$userid); 
	//send_webmail($to_email,$subject,$mailcontent,$callback);
	
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
	saveMailLog($sjid,$maillogsid,$receiver,$to_email,$subject,$mailcontent,$flag,$result,$successrate,$userid);
	
	//删除该条Message
	$queue->deleteMessage($message);
	
	//暂停几秒
	if(empty($interval)) {
		$interval = 5;
	}
	sleep($interval);
}
function send_webmail($to_email,$receiver,$from_name,$from_email,$subject,$contents,$maillogsid,$userid)
{ 
	global $adb;
	// 实例化mail
	//if(empty($from_email)){
	$query = "select * from ec_systems where server_type='email' and smownerid='".$userid."' order by id";
//	}else{
//		$query = "select * from ec_systems where server_type='email' and from_email = '".$from_email."' ";
//	}
	$result = $adb->query($query);
	$rownum = $adb->num_rows($result);
	$server = $adb->query_result($result,0,'server');
    $username = $adb->query_result($result,0,'server_username');
    $password = $adb->query_result($result,0,'server_password');
	$smtp_auth = $adb->query_result($result,0,'smtp_auth');
	$server_port = $adb->query_result($result,0,'server_port');
	$from_email = $adb->query_result($result,0,'from_email');
	$from_name = $adb->query_result($result,0,'from_name'); 
	if($rownum == 0) {
		return "No Smtp Server!";
	}
	require_once('include/phpmailer/class.phpmailer.php');

	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

	$mail->IsSMTP(); // telling the class to use SMTP
	$result = "";

	try {
	  $mail->CharSet = "UTF-8";
	  $mail->Host       = $server; // SMTP server
	  //$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
	  $mail->SMTPAuth   = true;                  // enable SMTP authentication
	  $mail->Port       = $server_port;                    // set the SMTP port for the GMAIL server
	  $mail->Username   = $username; // SMTP account username
	  $mail->Password   = $password;        // SMTP account password
	  $mail->AddReplyTo($from_email, $from_name);
	  $mail->AddAddress($to_email, $receiver);
	  $mail->SetFrom($from_email, $from_name);
	  $mail->Subject = $subject;
	  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
	  $mail->MsgHTML($contents);
	  $mail->Send();
	} catch (phpmailerException $e) {
	  $result = $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  $result = $e->getMessage(); //Boring error messages from anything else!
	}
	return $result;
}
//detail
function saveMailLog($sjid,$maillogsid,$receiver,$receiver_email,$subject,$mailcontent,$flag,$result,$successrate,$userid){
	global $adb,$log;
	$mailcontent = addslashes($mailcontent);
	$sendtime = date("Y-m-d H:i:s");
	$query = "insert into ec_maillogs(id,userid,receiver,receiver_email,subject,mailcontent,flag,mailresult,sendtime,maillistsid) values($maillogsid,'".$userid."','".$receiver."','".$receiver_email."','".$subject."','".$mailcontent."',$flag,'".$result."','".$sendtime."','".$sjid."')";
	//echo $query."<br>";
	$adb->query($query);
	
	if($successrate == 1 && !empty($sjid)){
		//更新群发成功率
		$updatesql = "update ec_maillists set successrate = successrate+".$successrate." where maillistsid= '".$sjid."' ";
		$adb->query($updatesql);
	}
}

function stripHTML($text) {

  # strip HTML, and turn links into the full URL
  $text = preg_replace("/\r/","",$text);

  #$text = preg_replace("/\n/","###NL###",$text);
  $text = preg_replace("/<script[^>]*>(.*?)<\/script\s*>/is","",$text);
  $text = preg_replace("/<style[^>]*>(.*?)<\/style\s*>/is","",$text);

  # would prefer to use < and > but the strip tags below would erase that.
#  $text = preg_replace("/<a href=\"(.*?)\"[^>]*>(.*?)<\/a>/is","\\2\n{\\1}",$text,100);

#  $text = preg_replace("/<a href=\"(.*?)\"[^>]*>(.*?)<\/a>/is","[URLTEXT]\\2[/URLTEXT][LINK]\\1[/LINK]",$text,100);

  $text = preg_replace("/<a[^>]*href=[\"\'](.*)[\"\'][^>]*>(.*)<\/a>/Umis","[URLTEXT]\\2[ENDURLTEXT][LINK]\\1[ENDLINK]\n",$text);

  $text = preg_replace("/<b>(.*?)<\/b\s*>/is","*\\1*",$text);
  $text = preg_replace("/<h[\d]>(.*?)<\/h[\d]\s*>/is","**\\1**\n",$text);
#  $text = preg_replace("/\s+/"," ",$text);
  $text = preg_replace("/<i>(.*?)<\/i\s*>/is","/\\1/",$text);
  $text = preg_replace("/<\/tr\s*?>/i","<\/tr>\n\n",$text);
  $text = preg_replace("/<\/p\s*?>/i","<\/p>\n\n",$text);
  $text = preg_replace("/<br[^>]*?>/i","<br>\n",$text);
  $text = preg_replace("/<br[^>]*?\/>/i","<br\/>\n",$text);
  $text = preg_replace("/<table/i","\n\n<table",$text);
  $text = strip_tags($text);

  # find all URLs and replace them back
  preg_match_all('~\[URLTEXT\](.*)\[ENDURLTEXT\]\[LINK\](.*)\[ENDLINK\]~Umis', $text, $links);
  foreach ($links[0] as $matchindex => $fullmatch) {
    $linktext = $links[1][$matchindex];
    $linkurl = $links[2][$matchindex];
    # check if the text linked is a repetition of the URL
    if (trim($linktext) == trim($linkurl) ||
      'http://'.trim($linktext) == trim($linkurl)) {
        $linkreplace = $linkurl;
    } else {
      $linkreplace = $linktext.' <'.$linkurl.'>';
    }
  #  $text = preg_replace('~'.preg_quote($fullmatch).'~',$linkreplace,$text);
    $text = str_replace($fullmatch,$linkreplace,$text);
  }
  $text = preg_replace("/<a href=[\"\'](.*?)[\"\'][^>]*>(.*?)<\/a>/is","[URLTEXT]\\2[ENDURLTEXT][LINK]\\1[ENDLINK]",$text,500);

  $text = replaceChars($text);

  $text = preg_replace("/###NL###/","\n",$text);
  # reduce whitespace
  while (preg_match("/  /",$text))
    $text = preg_replace("/  /"," ",$text);
  while (preg_match("/\n\s*\n\s*\n/",$text))
    $text = preg_replace("/\n\s*\n\s*\n/","\n\n",$text);
  $text = wordwrap($text,70);

  return $text;
}

function checkMaillog($maillogsid){
	global $adb;
	$query = "select id from ec_maillogs where id = '$maillogsid'";
	$result = $adb->query($query);
	$rownum = $adb->num_rows($result);
	if($rownum > 0){
		return false;
	}else{
		return true;
	}
}
?>
