<?php
$skipped_rows = array();
$rows = array();
if(isset($_SESSION['skipped_rows_in_excel']) && $_SESSION['skipped_rows_in_excel'] != "")
{
	$skipped_rows = $_SESSION['skipped_rows_in_excel'];
}
foreach($skipped_rows as $rowKey => $row)
{
	foreach($row as $k => $v) {
		$row[$k] = iconv_ec("UTF-8","GBK",$v);
	}
	$rows[$rowKey] = $row;
}
require_once("include/excel/excel_class.php");
$file_name = "Skipped.xls";
Create_Excel_File($file_name,$rows);
?>