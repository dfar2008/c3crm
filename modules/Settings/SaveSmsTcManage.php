<?php


require_once("include/database/PearDatabase.php");
global $current_user;
global $adb;
$mod_strings =  return_specified_module_language("zh_cn","Settings"); 

$datetime = date("Y-m-d H:i:s");	

$record = $_REQUEST['record'];
$tc = $_REQUEST['tc'];
$price = $_REQUEST['price'];
$num = $_REQUEST['num'];	

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] =='true')
{
		if(empty($record)) {
			$query = "SELECT id FROM ec_smstc WHERE tc='".$tc."'"; 
		} else {
			$query = "SELECT id FROM ec_smstc WHERE tc='".$tc."' and id !=$record"; 
		}
        $result = $adb->getFirstLine($query);
        if($adb->num_rows($result) > 0)
        {
			echo "FAILED";
			die;
		}
		else
		{
			echo 'SUCCESS';
			die;
		}
}






if(empty($record)){
	$id = $adb->getUniqueID("ec_smstc");
	$insertsql = "insert into ec_smstc(id,tc,price,num) values({$id},'".$tc."','".$price."','".$num."')";
	$adb->query($insertsql);
}else{
	$updatesql = "update ec_smstc set tc='".$tc."',price='".$price."',num='".$num."' where id=$record ";	
	$adb->query($updatesql);
}


header("Location: index.php?module=Settings&parenttab=Settings&action=SmsTcManage");
?>
