<?php


require_once("include/database/PearDatabase.php");
global $current_user;
global $adb;
$mod_strings =  return_specified_module_language("zh_cn","Settings"); 

$now = date("Y-m-d H:i:s");	

$userid=$_REQUEST['userid'];
if(empty($userid)){
	die("CurrentUser->ID is null,Please Check it!");
}

$old_endtime = $_REQUEST['endtime'];
if(empty($old_endtime) || $old_endtime =='0000-00-00 00:00:00'){
	$old_endtime = '';
}

//价格6元
$price = 6;

$newtcdate = $_REQUEST['newtcdate'];
if($newtcdate =='onemonth'){
	if(!empty($old_endtime)){
		$endtime = date("Y-m-d H:i:s",strtotime("1 month",strtotime($old_endtime)));
	}else{
		$endtime = date("Y-m-d H:i:s",strtotime("1 month"));
	}
	$chargefee = $price*1;
}

if($newtcdate =='threemonths'){
	if(!empty($old_endtime)){
		$endtime = date("Y-m-d H:i:s",strtotime("3 months",strtotime($old_endtime)));
	}else{
		$endtime = date("Y-m-d H:i:s",strtotime("3 months"));
	}
	$chargefee = $price*3;
}

if($newtcdate =='sixmonths'){
	if(!empty($old_endtime)){
		$endtime = date("Y-m-d H:i:s",strtotime("6 months",strtotime($old_endtime)));
	}else{
		$endtime = date("Y-m-d H:i:s",strtotime("6 months"));
	}
	$chargefee = $price*6;
}
if($newtcdate =='oneyear')
{
	if(!empty($old_endtime)){
		$endtime = date("Y-m-d H:i:s",strtotime("1 year",strtotime($old_endtime)));
	}else{
		$endtime = date("Y-m-d H:i:s",strtotime("1 year"));
	}
	$chargefee = $price*12;
}

$sql="select * from ec_systemcharges where  userid='".$userid."' "; 
$row = $adb->getFirstLine($sql);

if(!empty($row)){
	$updatesql = "update ec_systemcharges set endtime='".$endtime."',chargetime='".$now."',chargenum=chargenum+1,chargefee='".$chargefee."' where userid=$userid ";
	$adb->query($updatesql); 
}else{
	$insertsql = "insert into ec_systemcharges(userid,chargenum,chargetime,chargefee,endtime) values({$userid},'1','".$now."','".$chargefee."','".$endtime."')";
	$adb->query($insertsql);
}


$id = $adb->getUniqueID("ec_systemchargelogs");
$query = "insert into ec_systemchargelogs(id,userid,modifiedby,chargetime,endtime,total_fee,modifiedtime,flag) values({$id},{$userid},'".$current_user->id."','".$now."','".$endtime."','".$chargefee."','".$now."',1)";
$adb->query($query);
header("Location: index.php?module=Settings&parenttab=Settings&action=SmsUser");
?>
