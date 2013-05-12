<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
* 
 ********************************************************************************/

require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');
require_once('include/logging.php');
global $log,$adb;
global $current_user;
$crmid = $_REQUEST['return_id'];
if(isset($_POST['filename']) && is_array($_POST['filename'])) {
	//foreach($_POST['filename'] as $file_details)
	//{
		/*
			[filename] => libwhite.dat
            [clientpath] => D:\Programs\360safe\libwhite.dat
            [savepath] => D:\CRMONE\home\simpleCRM\upu\files\e2378eea311bf090679f979e2d5be3a5.dat
            [filetype] => application/octet-stream
            [filesize] => 3552
            [extension] => dat
		*/
		$file_details = $_POST['filename'];
		$clientpath = $file_details['clientpath'];
		$clientpath = str_replace("\\","/",$clientpath);
		$path_arr = explode('/',$clientpath);
		$num = count($path_arr);
		$filename = $path_arr[$num-1];
		//$filename = $file_details['filename'];
		$filesize = $file_details['filesize'];
		$ext = $file_details['extension'];
		$savepath = $file_details['savepath'];
		if($filename != '' && $filesize > 0)
		{
			if (in_array($ext, $upload_badext))
			{
				$filename .= ".txt";
			}
			$current_id = $adb->getUniqueID("ec_crmentity");
			$encode_file = base64_encode_filename($filename);
			$upload_file_path = decideFilePath();
			$upload_status = false;			
			$upload_status = copy($savepath,$upload_file_path.$current_id."_".$encode_file);
			if($upload_status) 
			{
				    unlink($savepath);
					$desc = $_REQUEST['txtDescription'];
					$description = addslashes($desc);
					$date_var = $adb->formatDate(date('YmdHis'));					
					$filename = preg_replace('/\'/', '', $filename);
					$sql1 = "insert into ec_crmentity (crmid,setype) values(".$current_id.",'".$_REQUEST['return_module']." Attachment')";
			        $adb->query($sql1);
					$sql = "insert into ec_attachments(attachmentsid,name,description,type,setype,path,smcreatorid,createdtime) values(";
					$sql .= $current_id.",'".$filename."','".$description."','".$filetype."','".$_REQUEST['return_module']."','".$upload_file_path."','".$current_user->id."',".$date_var.")";
					$result = $adb->query($sql);
					$sql1 = "insert into ec_seattachmentsrel values('";
					$sql1 .= $crmid."','".$current_id."')";
					$result = $adb->query($sql1);

					echo '<script>window.opener.location.href = window.opener.location.href;self.close();</script>';		
			}
			
		} 
	//}
}
?>
