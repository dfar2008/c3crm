<?php

require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('include/DatabaseUtil.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $current_language;

//Display the mail send status
$smarty = new CRMSmarty();

global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$newtcdate = $_REQUEST['newtcdate'];

$old_endtime = $_REQUEST['endtime'];

if($current_user->id ==27){
		$price = 0.01;
}else{
	$price = 6;	
}


if($newtcdate =='onemonth'){
	if(!empty($old_endtime) && $old_endtime !='0000-00-00 00:00:00'){
		$endtime = date("Y-m-d H:i:s",strtotime("1 month",strtotime($old_endtime)));
	}else{
		$endtime = date("Y-m-d H:i:s",strtotime("1 month"));
	}
	
	$chargefee = $price*1;

}



if($newtcdate =='threemonths'){
	if(!empty($old_endtime) && $old_endtime !='0000-00-00 00:00:00'){
		$endtime = date("Y-m-d H:i:s",strtotime("3 month",strtotime($old_endtime)));
	}else{
		$endtime = date("Y-m-d H:i:s",strtotime("3 month"));
	}
	$chargefee = $price*3;
}

if($newtcdate =='sixmonths'){
	if(!empty($old_endtime) && $old_endtime !='0000-00-00 00:00:00'){
		$endtime = date("Y-m-d H:i:s",strtotime("6 month",strtotime($old_endtime)));
	}else{
		$endtime = date("Y-m-d H:i:s",strtotime("6 month"));
	}
	$chargefee = $price*6;
}
if($newtcdate =='oneyear')
{
	if(!empty($old_endtime) && $old_endtime !='0000-00-00 00:00:00'){
		$endtime = date("Y-m-d H:i:s",strtotime("1 year",strtotime($old_endtime)));
	}else{
		$endtime = date("Y-m-d H:i:s",strtotime("1 year"));
	}
	$chargefee = $price*12;
}


$smarty->assign("endtime", $endtime);
$smarty->assign("total_fee", $chargefee);

$order_no = date('Ymdhis');
$smarty->assign("order_no", $order_no);

$userid = $current_user->id;


$adb->query("delete from ec_systemchargetmps where userid=$userid");

$chargetime = date("Y-m-d H:i:s");
$insertsql = "insert into ec_systemchargetmps(userid,chargetime,endtime,order_no,chargefee) values({$userid},'".$chargetime."','".$endtime."','".$order_no."','".$chargefee."')";
$adb->query($insertsql);

//保存记录
$tmpid = $adb->getUniqueID('ec_systemchargetmplogs');
$insertlogsql = "insert into ec_systemchargetmplogs(id,userid,chargetime,endtime,order_no,chargefee) values({$tmpid},{$userid},'".$chargetime."','".$endtime."','".$order_no."','".$chargefee."')";
$adb->query($insertlogsql);

$smarty->assign("userid", $current_user->id);

$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Relsettings/MessageConfigEdit.tpl");


?>
