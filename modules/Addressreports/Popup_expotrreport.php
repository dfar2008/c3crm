<?php
require_once("config.php");
require_once("include/utils/utils.php");
require_once('include/database/PearDatabase.php');
global $mod_strings;
global $app_strings;
global $adb;
global $current_user;

if($_REQUEST['startdate'] && !empty($_REQUEST['startdate'])){
	$startdate = $_REQUEST['startdate'];
}
if($startdate && !empty($startdate)){
	$where .= "and ec_account.createdtime > '{$startdate} 00:00:00' ";
}
if($_REQUEST['enddate'] && !empty($_REQUEST['enddate'])){
	$enddate = $_REQUEST['enddate'];		
}
if($enddate && !empty($enddate)){
	$where .= "and ec_account.createdtime < '{$enddate} 23:59:59' ";
}
$order = "ec_account.createdtime";$desc = 'asc';
$groupsql = "case when ec_account.bill_state = '' or ec_account.bill_state is null 
				then SUBSTRING(bill_street,1,2) else SUBSTRING(ec_account.bill_state,1,3) end";
$query = "select {$groupsql} as groupdate,count(*) as groupnum from ec_account where ec_account.deleted = 0 ";
if($where && !empty($where)){
	$query .= $where;
}
$query .= "group by {$groupsql} ";
$query .= "order by {$order} {$desc} ";

$result = $adb->query($query);
$num_rows = $adb->num_rows($result);
$reportData .= "\"序号\"";
$reportData .= ",\"分布地区\"";
$reportData .= ",\"客户数量\"";
$reportData .= "\r\n";
if($num_rows && $num_rows > 0){
	$for_i = 1;
	while($row = $adb->fetch_array($result)){
		$reportData .= "\"".$for_i."\"";
		$reportData .= ",\"".$row['groupdate']."\"";
		$reportData .= ",\"".$row['groupnum']."\"";
		$reportData .= "\r\n";
		$sumtotalcols += $row['groupnum'];
		$for_i ++;
	}
}

$reportData .= "\"\",\"小计\"";
$reportData .= ",\"".$sumtotalcols."\"";
$reportData .= "\r\n";

ob_clean();
header("Pragma: cache");
header("Content-type: application/octet-stream; charset=GBK");
header("Content-Disposition: attachment; filename={$_REQUEST['module']}.csv");
header("Content-transfer-encoding: binary");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
header("Cache-Control: post-check=0, pre-check=0", false );
header("Content-Length: ".strlen($reportData));
$reportData = iconv_ec("UTF-8","GBK",$reportData);
print $reportData;

exit;
	
?>