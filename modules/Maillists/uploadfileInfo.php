<?php
require_once('modules/Maillists/Maillists.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
global $adb;


$sjid =trim($_REQUEST['sjid']);

//upload attachment start

foreach($_FILES as $fileindex => $file_details)
{
	if($file_details['name'] != '' && $file_details['size'] > 0)
	{
		global $current_user;
		global $upload_badext;
		$ownerid = $current_user->id;
		// Arbitrary File Upload Vulnerability fix - Philip
		$binFile = $file_details['name'];
		$ext_pos = strrpos($binFile, ".");
		$ext = substr($binFile, $ext_pos + 1);
		if (in_array($ext, $upload_badext))
		{
			$binFile .= ".txt";
		}
		// Vulnerability fix ends
		$current_id = $adb->getUniqueID("ec_crmentity");

		$filename = explode_basename($binFile);
		$filetype= $file_details['type'];
		$filesize = $file_details['size'];
		$filetmp_name = $file_details['tmp_name'];
		//get the file path inwhich folder we want to upload the file
		$upload_file_path = decideFilePath();
		//upload the file in server
		$upload_status = false;
		if(is_uploaded_file($filetmp_name)) {
			$encode_file = base64_encode_filename($binFile);
			$upload_status = move_uploaded_file($filetmp_name,$upload_file_path.$current_id."_".$encode_file);
		}
		if($upload_status)
		{
			$description = "";
			$adb->query("insert into ec_crmentity (crmid,setype) values('".$current_id."','Maillists Attachment')");
			$sql = "insert into ec_attachments(attachmentsid,name,description,type,setype,path,smcreatorid,createdtime) values(";
			$sql .= $current_id.",'".$filename."','".$description."','".$filetype."','Maillists','".$upload_file_path."','".$current_user->id."',NOW())";
			$adb->query($sql);

			$query_attachment = "delete from ec_seattachmentsrel where crmid = ".$sjid;
			$adb->query($query_attachment);
			$query_attachment = 'insert into ec_seattachmentsrel values('.$sjid.','.$current_id.')';
			$adb->query($query_attachment);

			$insertsjidsql = 'insert into ec_attachmentsjrel values('.$sjid.','.$current_id.')';
			$adb->query($insertsjidsql);
		}

	}
}



?>