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
				$date_var = $adb->formatDate(date('YmdHis'));
				$query = "insert into ec_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values('";
				$query .= $current_id."','".$current_user->id."','".$current_user->id."','".$_REQUEST['return_module'].' Attachment'."','".$description."',".$date_var.",".$date_var.")";	
				$result = $adb->query($query);

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
				$filename = preg_replace('/\'/', '', $filename);

				$sql = "insert into ec_attachments values(";
				$sql .= $current_id.",'".$filename."','".$description."','".$filetype."','".$upload_file_path."')";
				$result = $adb->query($sql);


				$sql1 = "insert into ec_seattachmentsrel values('";
				$sql1 .= $crmid."','".$current_id."')";
				$result = $adb->query($sql1);
				if ($associated_account)
				{
					$sql1 = "insert into ec_seattachmentsrel values('";
					$sql1 .= $associated_account."','".$current_id."')";
					$result = $adb->query($sql1);
				}

				echo '<script>window.opener.location.href = window.opener.location.href;self.close();</script>';		
		} 
		else 
		{

			$errorCode =  $_FILES['binFile']['error'];
			if($errorCode == 4)
			{
				$errormessage = "<B><font color='red'>Kindly give a valid file for upload!</font></B> <br>" ;
				echo $errormessage;
				include "upload.php";
			}
			else if($errorCode == 2)
			{
				$errormessage = "<B><font color='red'>Sorry, the uploaded file exceeds the maximum filesize limit. Please try a file smaller than 1000000 bytes</font></B> <br>";
				echo $errormessage;
				include "upload.php";
			}
			else if($errorCode == 3)
			{
				echo "<b><font color='red'>1Problems in file upload. Please try again!</font></b><br>";
				include "upload.php";
			}
			else if($errorcode == '')
			{
				echo "<b><font color='red'>2Problems in file upload. Please try again!</font></b><br>";
				include "upload.php";
			}
			

		}
	} else {
		echo "<b><font color='red'>3Problems in file upload. Please try again!</font></b><br>";
		include "upload.php";
	}
}
?>
