<?php


require_once("include/database/PearDatabase.php");
global $adb;
global $current_user;
$now = date("Y-m-d H:i:s");
$record=$_REQUEST['record'];

$shopname = $_REQUEST['shopname'];
$appkey = $_REQUEST['appkey'];
$appsecret = $_REQUEST['appsecret'];
$nick = $_REQUEST['nick'];
$topsession = $_REQUEST['topsession'];

if(isset($_REQUEST['status']) && $_REQUEST['status'] =='on'){

	$status = 1;
	
	$sql = "update ec_appkey set status=0 where smownerid='".$current_user->id."' ";
	$adb->query($sql);
}else{
	$status = 0;
}

if(!empty($record)){
	$updatesql = "update ec_appkey set shopname='".$shopname."',appkey='".$appkey."',appsecret='".$appsecret."',nick='".$nick."',topsession='".$topsession."',status='".$status."' where id=$record";
	$adb->query($updatesql);
}else{
	$id = $adb->getUniqueID("ec_appkey");
	$insertsql = "insert into ec_appkey(id,shopname,appkey,appsecret,nick,topsession,status,smownerid) values({$id},'".$shopname."','".$appkey."','".$appsecret."','".$nick."','".$topsession."','".$status."','".$current_user->id."')";
	$adb->query($insertsql);
}

redirect("index.php?module=Relsettings&parenttab=Settings&action=Taobaozushou");
?>