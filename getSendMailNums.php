<?php
require_once('config.inc.php');
require_once('include/utils/utils.php');
require_once('include/database/PearDatabase.php');
global $adb,$current_user;

$today = date("Y-m-d");

$oneweek = date("Y-m-d",strtotime("-5 day"))." 00:00:00";

$onemonth = date("Y-m-d",strtotime("-1 month"))." 00:00:00";

$threemonth = date("Y-m-d",strtotime("-3 month"))." 00:00:00";


sleep(60);

if(isset($_REQUEST['phone']) && $_REQUEST['phone'] !=''){
	$query = "select accountid,email,phone from ec_account where deleted=0 and phone ='".$_REQUEST['phone']."'";
}elseif(isset($_REQUEST['email']) && $_REQUEST['email'] !=''){
	$query = "select accountid,email,phone from ec_account where deleted=0 and email ='".$_REQUEST['email']."'";
}

$row = $adb->getFirstLine($query);
$nums = $adb->num_rows($row);
if($nums > 0){
		$accountid = $row['accountid'];
		$email = $row['email'];
		$phone = $row['phone'];

		//mail
		if($email !='' && $_REQUEST['email'] !=''){
			$query1 = "select count(*) as num from ec_maillogs where receiver_email ='".$email."' and flag=1 and sendtime > '$oneweek' ";
			$oneweeksendmailnum = $adb->getOne($query1);
			if(empty($oneweeksendmailnum)){
				$oneweeksendmailnum=0;
			}
			
			$query2 = "select count(*) as num from ec_maillogs where receiver_email ='".$email."' and flag=1 and sendtime > '$onemonth' ";
			$onemonthsendmailnum = $adb->getOne($query2);
			if(empty($onemonthsendmailnum)){
				$onemonthsendmailnum=0;
			}
			
			$query3 = "select count(*) as num from ec_maillogs where receiver_email ='".$email."' and flag=1 and sendtime > '$threemonth' ";
			$threemonthsendmailnum = $adb->getOne($query3);
			if(empty($threemonthsendmailnum)){
				$threemonthsendmailnum=0;
			}
			
			$query_date1 = "select * from ec_maillogs where receiver_email ='".$email."' and flag=1 order by sendtime desc ";	
			$row = $adb->getFirstLine($query_date1);
			$lastsendmaildate = '';
			if(!empty($row)){
				$lastsendmaildate = $row['sendtime'];
			}
			
			
			$updatemailsql = "update ec_account set oneweeksendmail=$oneweeksendmailnum,onemonthsendmail=$onemonthsendmailnum,threemonthsendmail=$threemonthsendmailnum,lastsendmaildate='".$lastsendmaildate."' where accountid=$accountid";
			$adb->query($updatemailsql);		
		}
		
		
		//phone
		if($phone !='' && $_REQUEST['phone'] !=''){
			$query4 = "select count(*) as num from ec_smslogs where receiver_phone ='".$phone."' and flag=1 and sendtime > '$oneweek' ";
			$oneweeksendmessnum = $adb->getOne($query4);
			if(empty($oneweeksendmessnum)){
				$oneweeksendmessnum=0;
			}
			
			$query5 = "select count(*) as num from ec_smslogs where receiver_phone ='".$phone."' and flag=1 and sendtime > '$onemonth' ";
			$onemonthsendmessnum = $adb->getOne($query5);
			if(empty($onemonthsendmessnum)){
				$onemonthsendmessnum=0;
			}
			
			$query6 = "select count(*) as num from ec_smslogs where receiver_phone ='".$phone."' and flag=1 and sendtime > '$threemonth' ";
			$threemonthsendmessnum = $adb->getOne($query6);
			if(empty($threemonthsendmessnum)){
				$threemonthsendmessnum=0;
			}
			
			$query_date2 = "select * from ec_smslogs where receiver_phone ='".$phone."' and flag=1 order by sendtime desc ";	
			$row = $adb->getFirstLine($query_date2);
			$lastsendmessdate = '';
			if(!empty($row)){
				$lastsendmessdate = $row['sendtime'];
			}
			
			$updatesmssql = "update ec_account set oneweeksendmess=$oneweeksendmessnum,onemonthsendmess=$onemonthsendmessnum,threemonthsendmess=$threemonthsendmessnum,lastsendmessdate='".$lastsendmessdate."' where accountid=$accountid";
			$adb->query($updatesmssql); echo $updatesmssql."<br>";			
		}
		
}

?>