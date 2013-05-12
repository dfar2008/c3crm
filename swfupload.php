<?php
include("config.php");
//设置默认服务端文件名
global $tmp_dir, $root_directory;
$upload_file_name = tempnam($root_directory.$tmp_dir, "upload.crm");
if (isset($_FILES["attachement_file"]) && is_uploaded_file($_FILES["attachement_file"]["tmp_name"]) && $_FILES["attachement_file"]["error"] == 0) {
	//上传文件赋值给$upload_file
	$upload_file=$_FILES["attachement_file"];
	if(move_uploaded_file($upload_file["tmp_name"],$upload_file_name)){
		echo $upload_file_name;
	}else{
		echo '';
	}
} else {
	echo ' '; // I have to return something or SWFUpload won't fire uploadSuccess
}
?>