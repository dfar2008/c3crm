<?php
require_once('config.inc.php');
require_once('include/utils/utils.php');
require_once('include/database/PearDatabase.php');
global $adb,$current_user;

$today = date("Y-m-d");

$oneweek = date("Y-m-d",strtotime("-1 week"))." 00:00:00";

$onemonth = date("Y-m-d",strtotime("-1 month"))." 00:00:00";

$threemonth = date("Y-m-d",strtotime("-3 month"))." 00:00:00";


$query = "select accountid from ec_account where deleted=0 order by smownerid";
$result = $adb->getList($query);
$nums = $adb->num_rows($result);
if($nums > 0){
	foreach($result as $row){
		$accountid = $row['accountid'];
		
		$query1 = "select count(*) as num from ec_salesorder where accountid=$accountid and createdtime  > '$oneweek'";
		
		$row1 = $adb->getFirstLine($query1);
		$oneweekbuynum = $row1['num'];
		if(empty($oneweekbuynum)){
				$oneweekbuynum=0;
		}
		
		$query2 = "select count(*) as num from ec_salesorder where accountid=$accountid and createdtime  > '$onemonth'";
		$row2 = $adb->getFirstLine($query2);
		$onemonthbuynum = $row2['num'];
		if(empty($onemonthbuynum)){
				$onemonthbuynum=0;
		}
		
		$query3 = "select count(*) as num from ec_salesorder where accountid=$accountid and createdtime  > '$threemonth'";
		$row3 = $adb->getFirstLine($query3);
		$threemonthbuynum = $row3['num'];
		if(empty($threemonthbuynum)){
				$threemonthbuynum=0;
		}
		
		$updatesql = "update ec_account set oneweekbuy=$oneweekbuynum,onemonthbuy=$onemonthbuynum,threemonthbuy=$threemonthbuynum where accountid=$accountid";
		
		$adb->query($updatesql);		
	}
}


?>