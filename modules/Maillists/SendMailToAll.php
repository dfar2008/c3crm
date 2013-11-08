<?php
require_once('config.inc.php');      
require_once('include/utils/utils.php');          
require_once('include/Zend/Queue.php');       
global $adb,$current_user;
global $currentModule;
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

//$queue->send('postdata=1&name=1');

$nowdate = date("Y-m-d");
$nowdatetime = date("Y-m-d H:i:s");

$sjid = $_REQUEST["sjid"];
$subject = $_REQUEST["subject"];
$mailcontent = $_REQUEST["mailcontent"]; 
$mailcontent = stripslashes($mailcontent);

//$mailfrom = $_REQUEST["mailfrom"]; 
//$mailfrom_arr = explode("(",$mailfrom);
//$from_email = $mailfrom_arr[0];
//$from_name  = substr($mailfrom_arr[1],0,-1);
//$interval  = substr($mailfrom_arr[2],0,-2);
$from_name = $_REQUEST["from_name"];

$from_email = $_REQUEST["from_email"];
$interval = $_REQUEST["interval"];

$receiveaccountinfo = $_REQUEST["receiveaccountinfo"];


//$receiveaccountinfo =  str_replace("##",'&',$receiveaccountinfo);	
//$receiveaccountarr = explode("\n",$receiveaccountinfo);
$receiveaccountarr = explode("**",$receiveaccountinfo);
//var_dump($receiveaccountarr);
//exit;

$receiverinfo = '';
$cnm = count($receiveaccountarr);
if($cnm > 5000){
	echo "邮件接收人为:".$cnm.",已超过5000人，请分批发送。";
	die;
}

foreach($receiveaccountarr as $key=>$receiveaccount){
	if(empty($receiveaccount)){
		continue;
	}
	$receive_arr = explode("(",$receiveaccount);
	$email = $receive_arr[0]; //mail

	if($email && $email !=''){
		$is_true = preg_match("/^[a-z0-9_\+-]+(\.[a-z0-9_\+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,4})$/",$email);
		if(!$is_true){
			echo "Email:".$email."格式不正确.";die;
		 }
	}else{
			echo  "Email不能为空!";die;
	}
	
	$receive_name = substr($receive_arr[1],0,-1);
	
	if($receive_name ==''){
		echo  $email."对应的姓名为空!";die;
	}
	$sendresult[$key] = array($email,$receive_name);
	$receiverinfo .= $email.",".$receive_name.";";
} 

$maillogsidstr = '';
$totalnum = 0;
$arr = array();
$current_user_id = $current_user->id;
foreach($sendresult as $rst){
	//生成日志ID 	
	$maillogsid = $adb->getUniqueID("ec_maillogs");
	$maillogsidstr .= $maillogsid.",";
	$to_email = $rst[0];
	$receiver = $rst[1];
	
	$message = "sjid=$sjid&maillogsid=$maillogsid&to_email=$to_email&receiver=$receiver&from_name=$from_name&from_email=$from_email&interval=$interval&subject=$subject&mailcontent=$mailcontent&userid=".$current_user_id;
	 $queue->send($message);
	$totalnum++;
}


//保存事件
saveMailLists($sjid,$subject,$mailcontent,$maillogsidstr,$receiverinfo,$from_name,$from_email,$totalnum);

echo "SUCCESS";die;

exit();


//list 
function saveMailLists($sjid,$subject,$mailcontent,$maillogsidstr,$receiverinfo,$from_name,$from_email,$totalnum){
	global $adb;
	global $current_user;
	$maillistname = "QFYJ".date("Ymd")."-".$sjid;
	$mailcontent = addslashes($mailcontent);
	$sql = "insert into ec_maillists(maillistsid,maillistname,smcreatorid,createdtime,deleted,mailids,receiverinfo,from_name,from_email,subject,mailcontent,totalnum) values(".$sjid.",'".$maillistname."','".$current_user->id."','".date("Y-m-d H:i:s")."',0,'".$maillogsidstr."','".$receiverinfo."','".$from_name."','".$from_email."','".$subject."','".$mailcontent."','".$totalnum."')"; 
	$adb->query($sql);
	
	//$adb->query("insert into ec_crmentity (crmid,setype,smcreatorid,smownerid,createdtime,modifiedtime) values('".$sjid."','Maillists',".$current_user->id.",".$current_user->id.",'".$nowdatetime."','".$nowdatetime."')");	
}

?>