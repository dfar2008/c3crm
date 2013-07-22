<?php
require_once("include/Zend/Json.php");
global $adb;
$query = "SELECT id as userid,user_name,last_name,prefix from ec_users where deleted=0";
$result = $adb->query($query);
$rows = $adb->num_rows($result);
//$userArr = new Array();
if($rows > 0 ){
    for($i=0;$i<$rows;$i++){
        $userid = $adb->query_result($result,$i,"userid");
        $username = $adb->query_result($result,$i,"user_name");
        $lastname = $adb->query_result($result,$i,"last_name");
        $prefix = $adb->query_result($result,$i,"prefix");
        $userArr['user'][$userid]['username']['value'] = $username;
        $userArr['user'][$userid]['lastname']['value'] = $lastname;
        $userArr['user'][$userid]['prefix']['value'] = $prefix;
    }
}
//var_dump($userArr);
//$userArr = getSmownerUserOptsInfo();
//var_dump($userArr);
//exit();
if($userArr && !empty($userArr)){
	$json = new Zend_Json();
	$jsonuser = $json->encode($userArr);
	echo $jsonuser;die;
}else{
	echo '';die;
}
die;
?>