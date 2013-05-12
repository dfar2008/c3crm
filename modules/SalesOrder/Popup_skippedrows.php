<?php
set_time_limit(0);
require_once('modules/SalesOrder/ImportSalesOrder.php');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Skipped.xls"');
header('Cache-Control: max-age=0');
$skipped_rows = array();
$rows = array();
if(isset($_SESSION['import_skipped_rows']) && $_SESSION['import_skipped_rows'] != "")
{
	$skipped_rows = $_SESSION['import_skipped_rows'];
}

$focus=new ImportSalesOrder();
$focus->setAccountFile("php://output");
$focus->createXls($skipped_rows);
?>