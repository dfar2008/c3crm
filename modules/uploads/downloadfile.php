<?php
/********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
* 
 ********************************************************************************/

require_once('config.php');
require_once('include/database/PearDatabase.php');

global $adb;
global $fileId;
global $mod_strings;

$attachmentsid = $_REQUEST['fileid'];
$entityid = $_REQUEST['entityid'];

$returnmodule=$_REQUEST['return_module'];

$dbQuery = "SELECT * FROM ec_attachments WHERE attachmentsid = " .$attachmentsid ;
$result = $adb->query($dbQuery) or die("Couldn't get file list");
if($adb->num_rows($result) == 1)
{
	$fileType = @$adb->query_result($result, 0, "type");
	$name = @$adb->query_result($result, 0, "name");
	$filepath = @$adb->query_result($result, 0, "path");
    $encode_filename = base64_encode_filename($name);
	$saved_filename = $attachmentsid."_".$encode_filename;
	if(!is_file($filepath.$saved_filename)) {
		echo $mod_strings["NOT_EXIST"];
		exit();
	}
	
//	$filesize = filesize($filepath.$saved_filename);
//	$fp = fopen($filepath.$saved_filename, "rb");
//	
//	$name = iconv_ec("UTF-8","GB2312",$name);
//
//	ob_end_clean();
//	header('Cache-control: max-age=31536000');
//	header('Expires: '.gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
//	header('Content-Encoding: none');
//    header("Content-Type: application/force-download");
//	header("Content-Disposition: attachment; filename=$name");
//	header("Content-length: $filesize");
//	header("Cache-Control: private");	
//	header("Accept-Ranges: bytes");
//
//	if ($fp){
//		while(!feof($fp))
//			echo fread($fp, 8192);			
//		@fclose($fp);
//	}
	

	
	ob_end_clean();
	header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("X-DNS-Prefetch-Control: off");
	header("Cache-Control: private, no-cache, must-revalidate, post-check=0, pre-check=0");
	header("Pragma: no-cache");

	header("Content-Type: application/octet-stream");
    header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=$name");
    $fileContent = file_get_contents($filepath.$saved_filename);
	echo $fileContent;
	unset($fileContent);
	
}
else
{
	echo "Record doesn't exist.";
}
?>
