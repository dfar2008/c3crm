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
if(isset($_POST['hidFileID']) && $_POST['hidFileID'] != "") {
	//foreach($_POST['filename'] as $file_details)
	//{
		
		$filename = $_POST['filename'];

		$file_info = pathinfo($filename);
		//获取文件扩展名
		$ext = $file_info["extension"];
		$savepath = $_POST["hidFileID"];
		$filesize = 0;
		if(is_file($savepath)) {
			$filesize = filesize($savepath);
		}

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
					$filename = preg_replace('/\'/', '', $filename);
					$sql1 = "insert into ec_crmentity (crmid,setype) values(".$current_id.",'".$_REQUEST['return_module']." Attachment')";
			        $adb->query($sql1);
					$sql = "insert into ec_attachments(attachmentsid,name,description,type,setype,path,smcreatorid,createdtime) values(";
					$sql .= $current_id.",'".$filename."','".$description."','".$filetype."','".$_REQUEST['return_module']."','".$upload_file_path."','".$current_user->id."',NOW())";
					$result = $adb->query($sql);
					$sql1 = "insert into ec_seattachmentsrel values('";
					$sql1 .= $crmid."','".$current_id."')";
					$result = $adb->query($sql1);
					if ($_REQUEST['return_module'] == 'Contacts')
					{
						$crmid = $_REQUEST['return_id'];
						$query = 'select accountid from ec_contactdetails where contactid='.$crmid;
						$result = $adb->query($query);
						if($adb->num_rows($result) != 0)
						{
							$associated_account = $adb->query_result($result,0,"accountid");
							$query = "select name,attachmentsize from ec_attachments where name= '".$filename."'";
							$result = $adb->query($query);
							if($adb->num_rows($result) != 0)
							{
								$log->debug("DGDEBUG Matched a row");
								$dg_size = $adb->query_result($result,0,"attachmentsize");
								$log->debug("DGDEBUG: These should be the same size: ".$dg_size." ".$filesize);
								if ($dg_size == $filesize)
								{
									$associated_account = '';
								}
							}
						}
						else
						{
							$associated_account = '';
						}
					}
					if ($associated_account)
					{
						$sql1 = "insert into ec_seattachmentsrel values('";
						$sql1 .= $associated_account."','".$current_id."')";
						$result = $adb->query($sql1);
					}

					echo '<script>window.opener.location.reload();self.close();</script>';		
			} else {
				echo '<script>window.opener.location.reload();self.close();</script>';
			}
			
		} else {
			echo '<script>window.opener.location.reload();self.close();</script>';		
		}
	//}
} else {
	foreach($_FILES as $fileindex => $file_details)
	{
		if($file_details['name'] != '' && $file_details['size'] > 0)
		{
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
			$upload_status = false;

			//upload the file in server
			if(is_uploaded_file($filetmp_name)) {
				$encode_file = base64_encode_filename($binFile);
				$upload_status = move_uploaded_file($filetmp_name,$upload_file_path.$current_id."_".$encode_file);
			}
			if($upload_status) 
			{
					$desc = $_REQUEST['txtDescription'];
					$description = addslashes($desc);				
					$filename = preg_replace('/\'/', '', $filename);
					$sql1 = "insert into ec_crmentity (crmid,setype) values(".$current_id.",'".$_REQUEST['return_module']." Attachment')";
			        $adb->query($sql1);
					$sql = "insert into ec_attachments(attachmentsid,name,description,type,setype,path,smcreatorid,createdtime) values(";
					$sql .= $current_id.",'".$filename."','".$description."','".$filetype."','".$_REQUEST['return_module']."','".$upload_file_path."','".$current_user->id."',NOW())";
					$result = $adb->query($sql);
					$sql1 = "insert into ec_seattachmentsrel values('";
					$sql1 .= $crmid."','".$current_id."')";
					$result = $adb->query($sql1);
					if ($_REQUEST['return_module'] == 'Contacts')
					{
						$crmid = $_REQUEST['return_id'];
						$query = 'select accountid from ec_contactdetails where contactid='.$crmid;
						$result = $adb->query($query);
						if($adb->num_rows($result) != 0)
						{
							$associated_account = $adb->query_result($result,0,"accountid");
							$query = "select name,attachmentsize from ec_attachments where name= '".$filename."'";
							$result = $adb->query($query);
							if($adb->num_rows($result) != 0)
							{
								$log->debug("DGDEBUG Matched a row");
								$dg_size = $adb->query_result($result,0,"attachmentsize");
								$log->debug("DGDEBUG: These should be the same size: ".$dg_size." ".$filesize);
								if ($dg_size == $filesize)
								{
									$associated_account = '';
								}
							}
						}
						else
						{
							$associated_account = '';
						}
					}
					if ($associated_account)
					{
						$sql1 = "insert into ec_seattachmentsrel values('";
						$sql1 .= $associated_account."','".$current_id."')";
						$result = $adb->query($sql1);
					}
					echo '<script>window.opener.location.reload();self.close();</script>';		
			} 
			else 
			{

				$errorCode =  $_FILES['binFile']['error'];
				if($errorCode == 4)
				{
					$errormessage = "<B><font color='red'>Kindly give a valid file for upload!</font></B> <br>" ;
					echo $errormessage;
				}
				else if($errorCode == 2)
				{
					$errormessage = "<B><font color='red'>Sorry, the uploaded file exceeds the maximum filesize limit. Please try a file smaller than 1000000 bytes</font></B> <br>";
					echo $errormessage;
				}
				else if($errorCode == 3)
				{
					echo "<b><font color='red'>1Problems in file upload. Please try again!</font></b><br>";
					
				}
				else if($errorcode == '')
				{
					echo "<b><font color='red'>2Problems in file upload. Please try again!</font></b><br>";
					
				}
				

			}
		} else {
			echo "<b><font color='red'>3Problems in file upload. Please try again!</font></b><br>";
			
		}
	}
}
?>
