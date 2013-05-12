<?php


require_once("include/database/PearDatabase.php");
global $adb;
global $current_user;
$now = date("Y-m-d H:i:s");
$userid=$_REQUEST['userid'];
if(empty($userid)){
	die("CurrentUser->ID is null,Please Check it!");
}
$tc=$_REQUEST['tc'];
$price=$_REQUEST['price'];
$num=$_REQUEST['num'];
$newtcdate = $_REQUEST['newtcdate'];
if($newtcdate =='sixmonths'){
	$enddate = date("Y-m-d",strtotime("6 months"));
}
if($newtcdate =='oneyear')
{
	$enddate = date("Y-m-d",strtotime("1 year"));
}

$updatesql = "update ec_messageaccount set tc='".$tc."',price='".$price."',num='".$num."',enddate='".$enddate."',canuse='".$num."',chargenum=chargenum+1,modifiedtime='".$now."' where userid=$userid ";
$adb->query($updatesql );

$id = $adb->getUniqueID("ec_messageaccountlogs");
$query = "insert into ec_messageaccountlogs(id,userid,modifiedby,tc,price,num,enddate,modifiedtime,flag) values({$id},{$userid},'".$current_user->id."','".$tc."','".$price."','".$num."','".$enddate."','".$now."',1)";
$adb->query($query);

redirect("index.php?module=Relsettings&parenttab=Settings&action=MessageConfig");
?>