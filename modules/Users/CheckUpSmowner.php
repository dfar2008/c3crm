<?php
global $adb,$current_user;
if($current_user->is_admin == "on"){
	echo "Yes";die;
}
$modname = $_REQUEST["modname"];
$tabid = getTabid($modname);
$key = "check_update_smownerid_".$current_user->id."_".$tabid;
$readonly = getSqlCacheData($key);
if(!$readonly) {
	$readonly = 0;
	$query = "select fieldid from ec_field where tabid = {$tabid} and columnname = 'smownerid' ";
	$result = $adb->query($query);
	$numrows = $adb->num_rows($result);
	if($numrows && $numrows == 1){
		$fieldid = $adb->query_result($result,0,"fieldid");
	}
	$profileId = getRoleRelatedProfileId($current_user->roleid);
	if($profileId > 0){
		$query = "select visible,readonly from ec_profile2field where profileid = {$profileId}
					and tabid = {$tabid} and fieldid = {$fieldid} ";
		$result = $adb->query($query);
		$numrows = $adb->num_rows($result);
		if($numrows && $numrows == 1){
			$readonly = $adb->query_result($result,0,"readonly");
		}
	}
	setSqlCacheData($key,$readonly);
}
if($readonly == 0){
	echo 'No';die;
}else{
	echo 'Yes';die;
}
die;
?>