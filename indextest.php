<?php
$root_directory = dirname(__FILE__)."/";
global $adb;
include_once($root_directory."config.php");
include_once($root_directory."include/database/PearDatabase.php");
require_once('include/CRMSmarty.php');
$smarty = new CRMSmarty();

$date_var = date('YmdHis');
echo "date:".$date_var."<br>";
$nowdate = $adb->formatDate($date_var);
echo "nowdate:".$nowdate."<br>";

$sql = "INSERT  INTO user ( name , age , regtime ) VALUES ( 'aaaaaaaa' , '22222222' , $nowdate ) ";//NOW()
$result = $adb->query($sql);
if($adb->errno() != 0)
{
	die( "Error:".$adb->errmsg());
}
$sql = "select * FROM user order by id desc";
$data = $adb->query( $sql );

$smarty->assign("LISTENTITY",$data);
$smarty->display("ListView.tpl");
?>
