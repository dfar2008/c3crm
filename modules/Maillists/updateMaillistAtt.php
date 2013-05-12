<?php
require_once('modules/Maillists/Maillists.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
global $adb;


$sjid =trim($_REQUEST['sjid']);

$selectattidsql = "select ec_attachments.* from ec_attachments " .
		" inner join ec_attachmentsjrel on ec_attachmentsjrel.attachmentsid = ec_attachments.attachmentsid " .
		"where ec_attachmentsjrel.sjid=$sjid and ec_attachments.deleted=0 order by ec_attachments.attachmentsid asc";

$result = $adb->getList($selectattidsql);
$showhtml = '';
foreach($result as $row)
{
	$name = $row['name'];
	$attachmentsid = $row['attachmentsid'];
	$showhtml .=$name."&nbsp; <a href='javascript:;' onclick='DeleteMaillistAtt(".$sjid.",".$attachmentsid.");'>删除</a><br>";
}
echo $showhtml;

?>