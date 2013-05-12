<?php
include("../../config.php");

//设置默认服务端文件名
$filename = "orderdetail".GetID( ".csv" );

$s = new SaeStorage();


if (isset($_FILES["Filedata"]) && is_uploaded_file($_FILES["Filedata"]["tmp_name"]) && $_FILES["Filedata"]["error"] == 0) {
	//上传文件赋值给$upload_file
	$upload_file=$_FILES["Filedata"];
	
	$ret = $s->upload( 'upload' , $filename , $upload_file["tmp_name"] );

	if($ret == false){
		echo 'error';
	}else{
		echo $filename;
	}
} else {

	echo ''; // I have to return something or SWFUpload won't fire uploadSuccess
}
// 生成随机文件名
function GetID($prefix) {
   //第一步:初始化种子
   //microtime(); 是个数组
   $seedstr =@split(" ",microtime(),5);
   
   $seed =$seedstr[0]*10000;   
   //第二步:使用种子初始化随机数发生器
   srand($seed);   
   //第三步:生成指定范围内的随机数
   $random =rand(1000,10000);
  
   $filename = date("YmdHis", time()).$random.$prefix;
  
   return $filename;
}

?>