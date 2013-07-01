<?php 
	ob_start();
	require_once('include/utils/utils.php');
	global $adb;
	
	$mailid = $_REQUEST['mailid'];
	$adb->query("UPDATE `ec_maillogs` SET `read` = '1' WHERE `id` ={$mailid}");
	
	$query = "select maillistsid from ec_maillists where mailids like '%$mailid,%' "; 
	$row = $adb->getFirstLine($query);
	if(!empty($row)){
		$maillistsid = $row['maillistsid'];
		$adb->query("UPDATE `ec_maillists` SET `readrate` = `readrate`+1 WHERE `maillistsid` ={$maillistsid}");
	}
	

@ob_end_clean();
header("Content-Type: image/png");
print base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAABGdBTUEAALGPC/xhBQAAAAZQTFRF////AAAAVcLTfgAAAAF0Uk5TAEDm2GYAAAABYktHRACIBR1IAAAACXBIWXMAAAsSAAALEgHS3X78AAAAB3RJTUUH0gQCEx05cqKA8gAAAApJREFUeJxjYAAAAAIAAUivpHEAAAAASUVORK5CYII=');
