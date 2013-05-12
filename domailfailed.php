<?php
require_once('include/utils/utils.php');
global $adb;

$sjid = $_REQUEST['sjid'];
$maillogsid = $_REQUEST['mailid'];


$updatesql = "update ec_maillists set successrate = successrate-1 where maillistsid= '".$sjid."' ";
$adb->query($updatesql);


$updatesql2 = "update ec_maillogs set flag=0,result='发送失败，邮件退回' where id= '".$maillogsid."' ";
$adb->query($updatesql2);
	

?>
